<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;
use App\Models\User;


class TaskController extends Controller
{
   public function index(Request $request)
   {
       $query = Task::with(['category','user']);


       if ($request->status) {
           $query->where('status', $request->status);
       }


       if ($request->category_id) {
           $query->where('category_id', $request->category_id);
       }


       $tasks = $query->latest()->paginate(8);
       $categories = Category::all();


       // Dashboard stats
       $counts = Task::selectRaw("
           count(*) as total,
           sum(status='todo') as todo,
           sum(status='in_progress') as in_progress,
           sum(status='done') as done
       ")->first();


       return view('tasks.index', compact('tasks','categories','counts'));
   }


   public function create()
   {
       $categories = Category::all();
       return view('tasks.create', compact('categories'));
   }


   public function store(Request $request)
   {
       $data = $request->validate([
           'title'=>'required',
           'description'=>'nullable',
           'category_id'=>'required|exists:categories,id',
           'due_date'=>'nullable|date'
       ]);


       $data['user_id'] = auth()->id();


       Task::create($data);


       return redirect()->route('tasks.index');
   }


   public function edit(Task $task)
   {
       $this->authorize('update',$task);


       $categories = Category::all();
       return view('tasks.edit', compact('task','categories'));
   }


   public function update(Request $request, Task $task)
   {
       $this->authorize('update',$task);


       $task->update($request->validate([
           'title'=>'required',
           'description'=>'nullable',
           'status'=>'required',
           'category_id'=>'required'
       ]));


       return redirect()->route('tasks.index');
   }


   public function destroy(Task $task)
   {
       $this->authorize('delete',$task);


       $task->delete();
       return back();
   }


   public function updateStatus(Task $task)
   {
       $this->authorize('update',$task);


       $next = match($task->status) {
           'todo'=>'in_progress',
           'in_progress'=>'done',
           default=>'todo'
       };


       $task->update(['status'=>$next]);


       return back();
   }
}
