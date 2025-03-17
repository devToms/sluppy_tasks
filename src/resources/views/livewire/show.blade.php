<!-- resources/views/livewire/tasks/show.blade.php -->
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Task Details
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <h3 class="text-xl font-bold">{{ $task->name }}</h3>
            <p><strong>Description:</strong> {{ $task->description }}</p>
            <p><strong>Priority:</strong> {{ $task->priority }}</p>
            <p><strong>Status:</strong> {{ $task->status }}</p>
            <p><strong>Due Date:</strong> {{ $task->due_date->format('Y-m-d') }}</p>

            @if($task->public_link)
                <p><strong>Public Link:</strong> <a href="{{ $task->public_link }}" target="_blank">{{ $task->public_link }}</a></p>
            @endif
        </div>
    </div>
</div>
