<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Manage Tasks (Laravel 11 Livewire CRUD with Jetstream & Tailwind CSS - ItSolutionStuff.com)
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create New Taskt</button>

            <div class="mb-4">
                <form wire:submit.prevent="filterTasks">
                    <div class="flex space-x-4">
                        <div>
                            <label for="priority" class="block">Priority</label>
                            <select wire:model="priorityFilter" id="priority" class="w-full">
                                <option value="">Select Priority</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block">Status</label>
                            <select wire:model="statusFilter" id="status" class="w-full">
                                <option value="">Select Status</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <div>
                            <label for="due_date" class="block">Due Date</label>
                            <input type="date" wire:model="dueDateFilter" id="due_date" class="w-full" />
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if($isOpen)
                @include('livewire.create')
            @endif

            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-20">No.</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Priority</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Due Date</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td class="border px-4 py-2">{{ $task->id }}</td>
                            <td class="border px-4 py-2">{{ $task->name }}</td>
                            <td class="border px-4 py-2">{{ $task->description }}</td>
                            <td class="border px-4 py-2">{{ $task->priority }}</td>
                            <td class="border px-4 py-2">{{ $task->status }}</td>
                            <td class="border px-4 py-2">{{ $task->due_date }}</td>
                            <td class="border px-4 py-2">
                                @if($task->public_link)
                                    <input type="text" id="link-{{ $task->id }}" value="{{ $task->public_link }}" readonly 
                                           class="border p-1 w-48">
                                    <button onclick="copyToClipboard('link-{{ $task->id }}')" 
                                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-3 rounded ml-2">
                                        Kopiuj
                                    </button>
                                @else
                                    <button wire:click="generatePublicLink({{ $task->id }})" 
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Generuj link
                                    </button>
                                @endif
                                <button wire:click="edit({{ $task->id }})" 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $task->id }})" 
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete
                                </button>
                                    Show
                                    <button wire:click="show({{ $task->id }})" 
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    show
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
    <h3>Task History</h3>
    <ul>
        @foreach($this->getTaskHistory($task_id) as $history)
            <li>
                <strong>{{ $history->created_at->format('Y-m-d H:i') }}</strong>
                <br>
                Name: {{ $history->name }}
                <br>
                Description: {{ $history->description }}
                <br>
                Priority: {{ $history->priority }}
                <br>
                Status: {{ $history->status }}
                <br>
                Due Date: {{ $history->due_date }}
                <hr>
            </li>
        @endforeach
    </ul>
</div>

        </div>
    </div>
</div>

<script>
    function copyToClipboard(id) {
        var copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        alert("Skopiowano: " + copyText.value);
    }
</script>
