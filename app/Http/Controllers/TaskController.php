<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Task::with(['category','user']);
        
        $query->where('user_id', auth()->id());

        if ($request->status) {
            $query->where('status', $request->status);
        }


        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $tasks = $query->latest()->paginate(8)->withQueryString();
        $categories = Category::all();


       // Dashboard stats
        $counts = Task::where('user_id', auth()->id())
        ->selectRaw("
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
        if ($task->user_id !== auth()->id()) {
             abort(403);
        }
        


       $categories = Category::all();
       return view('tasks.edit', compact('task','categories'));
   }

   public function show(Task $task)
   {    $this->authorize('view',$task);
        $users = User::all();
        $categories = Category::all();
        return view('tasks.show', compact('task','categories','users'));
   }


   public function update(Request $request, Task $task)
   {
       $this->authorize('update',$task);


       $task->update($request->validate([
           'title'=>'required',
           'description'=>'nullable',
           'status'=>'required',
           'category_id'=>'required',
           'due_date'=>'nullable|date' 
       ]));


       return redirect()->route('tasks.index');
   }


   public function destroy(Task $task)
   {
       $this->authorize('delete',$task);


       $task->delete();
       return redirect()->route('tasks.index');
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
