
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Task Reminder</h1>
        <p>Hi,</p>
        <p>This is a reminder for the following task:</p>
        <div class="bg-white rounded-lg shadow p-6 mb-4">
            <p><strong>Task Name:</strong> {{ $task->name }}</p>
            <p><strong>Deadline:</strong> {{ $task->deadline }}</p>
        </div>
        <p>Please make sure to complete it before the deadline.</p>
        <p>Thank you!</p>
    </div>
@endsection
