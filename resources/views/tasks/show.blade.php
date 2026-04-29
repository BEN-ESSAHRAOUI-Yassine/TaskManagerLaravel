@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('tasks.index') }}"
           class="text-sm text-slate-500 hover:text-blue-600 transition">
            ← Back to tasks
        </a>

        <div class="flex gap-3">
            @can('update', $task)
                <a href="{{ route('tasks.edit', $task) }}"
                   class="px-4 py-2 text-sm border border-slate-300 rounded-lg hover:bg-slate-50 transition">
                    Edit
                </a>
            @endcan

            @can('delete', $task)
                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">

        {{-- TITLE --}}
        <h1 class="text-2xl font-bold text-slate-800 mb-3">
            {{ $task->title }}
        </h1>

        {{-- STATUS BADGE --}}
        <div class="mb-6">
            <span class="px-3 py-1 text-xs font-semibold rounded-full
                @if($task->status === 'todo') bg-slate-100 text-slate-600
                @elseif($task->status === 'in_progress') bg-blue-100 text-blue-700
                @elseif($task->status === 'done') bg-green-100 text-green-700
                @endif">
                {{ str_replace('_', ' ', $task->status) }}
            </span>
        </div>

        {{-- DESCRIPTION --}}
        <p class="text-slate-600 leading-relaxed mb-8">
            {{ $task->description ?? 'No description provided.' }}
        </p>

        {{-- INFO GRID --}}
        <div class="grid md:grid-cols-3 gap-6">

            {{-- CATEGORY --}}
            <div class="bg-slate-50 p-4 rounded-lg border">
                <p class="text-xs text-slate-500 mb-1">Category</p>
                <p class="font-medium text-slate-800">
                    {{ $task->category->name }}
                </p>
            </div>

            {{-- DUE DATE --}}
            <div class="bg-slate-50 p-4 rounded-lg border">
                <p class="text-xs text-slate-500 mb-1">Due Date</p>

                @if($task->due_date && \Carbon\Carbon::parse($task->due_date)->isPast() && $task->status !== 'done')
                    <p class="font-medium text-red-600">
                        ⚠ {{ $task->due_date }}
                    </p>
                @else
                    <p class="font-medium text-slate-800">
                        {{ $task->due_date ?? 'Not set' }}
                    </p>
                @endif
            </div>

            {{-- STATUS ACTION --}}
            <div class="bg-slate-50 p-4 rounded-lg border flex flex-col justify-between">
                <p class="text-xs text-slate-500 mb-2">Progress</p>

                @if($task->status !== 'done')
                    <form method="POST" action="{{ route('tasks.status', $task) }}">
                        @csrf
                        @method('PATCH')

                        <button class="w-full px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Move to next →
                        </button>
                    </form>
                @else
                    <p class="text-green-600 font-medium">Completed ✔</p>
                @endif
            </div>

        </div>

    </div>

</div>

@endsection