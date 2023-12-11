@extends('layouts.app')
@section('title' , 'List of Tasks')
@section('content')
<nav class="mb-4">
    <a href="{{ route('task.create') }}" class="link">Add Task</a>
</nav>
    {{-- @if(count($tasks)) --}}
        @forelse ($tasks as $task )
            <div>
                <a href="{{ route('tasks.show', ['task' => $task->id]) }}" @class(['line-through font-bold' => $task->completed])>{{ $task->title }}</a>
            </div>
        @empty
            <div>There are no Tasks</div>
        @endforelse
    <nav class="mt-4">
        @if($tasks->count())
           {{ $tasks->links() }}
        @endif
    </nav>

@endsection
