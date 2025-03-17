<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task as T;
use App\Models\TaskHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Task extends Component
{
    public $tasks, $name, $description, $priority, $status, $due_date, $user_id, $task_id;
    public $isOpen = 0;
    public $priorityFilter, $statusFilter, $dueDateFilter;
    public $publicLink;

    /**
     * Reset the task filters.
     */
    public function resetFilters()
    {
        $this->priorityFilter = '';
        $this->statusFilter = '';
        $this->dueDateFilter = '';
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $this->filterTasks();
        return view('livewire.tasks')->layout('layouts.app');
    }

    /**
     * Filter tasks based on filters set in the component.
     */
    public function filterTasks()
    {
        $query = T::query();

        if ($this->priorityFilter) {
            $query->where('priority', $this->priorityFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->dueDateFilter) {
            $query->whereDate('due_date', '=', Carbon::parse($this->dueDateFilter));
        }

        $this->tasks = $query->get();
    }

    /**
     * Open the modal for creating a new task.
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * Open the modal.
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * Close the modal.
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    /**
     * Reset input fields.
     */
    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->priority = '';
        $this->status = '';
        $this->due_date = '';
        $this->user_id = '';
        $this->task_id = '';
    }

    /**
     * Store or update a task.
     */
    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'priority' => 'required|string',
            'status' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $user = Auth::user();

        if (!$user) {
            session()->flash('error', 'User is not logged in.');
            return;
        }

        try {
            $task = T::updateOrCreate(
                ['id' => $this->task_id],
                [
                    'name' => $this->name,
                    'description' => $this->description,
                    'priority' => $this->priority,
                    'status' => $this->status,
                    'due_date' => Carbon::parse($this->due_date),
                    'user_id' => $this->user_id = $user->id,
                ]
            );

            // Add task to Google Calendar
            $this->addToGoogleCalendar($task);

            session()->flash('message', 'Task created successfully.');
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving task: ' . $e->getMessage());
        }
    }

    /**
     * Edit a task.
     *
     * @param int $id
     */
    public function edit($id)
    {
        try {
            $task = T::findOrFail($id);
            $this->task_id = $id;
            $this->name = $task->name;
            $this->description = $task->description;
            $this->priority = $task->priority;
            $this->status = $task->status;
            $this->due_date = $task->due_date;
            $this->user_id = $task->user_id;

            TaskHistory::create([
                'task_id' => $this->task_id,
                'name' => $this->name,
                'description' => $this->description,
                'priority' => $this->priority,
                'status' => $this->status,
                'due_date' => $this->due_date,
            ]);

            $this->openModal();
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Task not found.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error editing task: ' . $e->getMessage());
        }
    }

    /**
     * Delete a task.
     *
     * @param int $id
     */
    public function delete($id)
    {
        try {
            $task = T::findOrFail($id);
            $task->delete();
            session()->flash('message', 'Task Deleted Successfully.');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Task not found.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting task: ' . $e->getMessage());
        }
    }

    /**
     * Generate public link for a task.
     *
     * @param int $taskId
     */
    public function generatePublicLink($taskId)
    {
        try {
            $task = T::findOrFail($taskId);

            $publicLink = url("/tasks/{$task->id}");

            $task->public_link = $publicLink;
            $task->save();

            session()->flash('message', 'Publiczny link został wygenerowany!');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Task not found.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error generating public link: ' . $e->getMessage());
        }
    }

    /**
     * Show task details by id.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $task = T::findOrFail($id);

            $this->task_id = $task->id;
            $this->name = $task->name;
            $this->description = $task->description;
            $this->priority = $task->priority;
            $this->status = $task->status;
            $this->due_date = $task->due_date;
            $this->user_id = $task->user_id;
            $this->publicLink = $task->public_link;

            $this->openModal();
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Task not found.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error showing task: ' . $e->getMessage());
        }
    }

    /**
     * Get task history by task ID.
     *
     * @param int $taskId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTaskHistory($taskId)
    {
        return TaskHistory::where('task_id', $taskId)->orderByDesc('created_at')->get();
    }
}
