@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">My Tasks</h1>
            <p class="text-sm text-slate-500">Manage and track your work</p>
        </div>

        <a href="{{ route('tasks.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
            + New Task
        </a>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm border">
            <p class="text-sm text-slate-500">Total</p>
            <h2 class="text-xl font-bold">{{ $counts->total }}</h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border">
            <p class="text-sm text-slate-500">Todo</p>
            <h2 class="text-xl font-bold text-slate-700">{{ $counts->todo }}</h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border">
            <p class="text-sm text-slate-500">In Progress</p>
            <h2 class="text-xl font-bold text-blue-600">{{ $counts->in_progress }}</h2>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border">
            <p class="text-sm text-slate-500">Done</p>
            <h2 class="text-xl font-bold text-green-600">{{ $counts->done }}</h2>
        </div>
    </div>

    {{-- FILTERS --}}
    <form method="GET" class="flex flex-wrap gap-3 items-center">

        <select name="status"
                class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
            <option value="">All Status</option>
            <option value="todo" {{ request('status')=='todo' ? 'selected' : '' }}>Todo</option>
            <option value="in_progress" {{ request('status')=='in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="done" {{ request('status')=='done' ? 'selected' : '' }}>Done</option>
        </select>

        <select name="category_id"
                class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <button class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-slate-900 transition">
            Filter
        </button>
    </form>

    {{-- TASK LIST --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($tasks as $task)

        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-orange-400 hover:shadow-md transition">

            {{-- HEADER --}}
            <div class="flex items-start justify-between mb-2">

                <h3 class="text-lg font-semibold text-slate-800">
                    <a href="{{ route('tasks.show', $task) }}"
                       class="hover:text-blue-600 hover:underline transition">
                        {{ $task->title }}
                    </a>
                </h3>

                {{-- STATUS BADGE --}}
                <span class="text-xs px-2 py-1 rounded-full
                    @if($task->status == 'todo') bg-slate-100 text-slate-600
                    @elseif($task->status == 'in_progress') bg-blue-100 text-blue-600
                    @else bg-green-100 text-green-600
                    @endif">
                    {{ ucfirst(str_replace('_',' ', $task->status)) }}
                </span>

            </div>

            {{-- CATEGORY --}}
            <p class="text-sm text-slate-500 mb-2">
                {{ $task->category->name }}
            </p>

            {{-- DUE DATE --}}
            @if($task->due_date)
                @php $isOverdue = \Carbon\Carbon::parse($task->due_date)->isPast() && $task->status !== 'done'; @endphp

                <p class="text-sm {{ $isOverdue ? 'text-red-500 font-medium' : 'text-slate-500' }}">
                    {{ $isOverdue ? '⚠ Overdue:' : 'Due:' }}
                    {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                </p>
            @endif

            {{-- ACTION --}}
            <div class="mt-4 flex justify-end">

                @if($task->status !== 'done')
                    <form method="POST" action="{{ route('tasks.status', $task) }}">
                        @csrf
                        @method('PATCH')

                        <button class="text-sm px-3 py-1.5 rounded-lg border hover:bg-slate-100 transition">
                            Next →
                        </button>
                    </form>
                @endif

            </div>

        </div>

        @empty
            <p class="text-slate-500">No tasks found.</p>
        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="pt-6">
        {{ $tasks->links() }}
    </div>

</div>

@endsection