@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Create Task</h1>
        <p class="text-slate-500 mt-1">Add a new task to your workflow</p>
    </div>

    {{-- FORM CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">

        <form method="POST" action="{{ route('tasks.store') }}" class="space-y-6">
            @csrf

            {{-- TITLE --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">
                    Title
                </label>
                <input type="text" name="title"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none"
                       placeholder="e.g. Finish project report"
                       required>
            </div>

            {{-- DESCRIPTION --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">
                    Description
                </label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none"
                          placeholder="Optional details..."></textarea>
            </div>

            {{-- GRID --}}
            <div class="grid md:grid-cols-2 gap-6">

                {{-- CATEGORY --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        Category
                    </label>
                    <select name="category_id"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none"
                            required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- DUE DATE --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        Due Date
                    </label>
                    <input type="date" name="due_date"
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none">
                </div>

            </div>

            {{-- ACTIONS --}}
            <div class="flex items-center justify-between pt-4">

                <a href="{{ route('tasks.index') }}"
                   class="text-slate-500 hover:text-blue-600 transition">
                    ← Cancel
                </a>

                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Create Task
                </button>

            </div>

        </form>

    </div>

</div>

@endsection