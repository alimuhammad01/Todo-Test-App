<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

class UserController extends Controller
{
    public function index()
    {
        $active_tasks = auth()->user()->tasks()->where('complete', 0)->paginate(10);
        $complete_tasks = auth()->user()->tasks()->where('complete', 1)->paginate(10);
        return view('user_dashboard', compact('active_tasks', 'complete_tasks'));
    }

    public function add()
    {
        return view('add');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);
        $task = new Tasks();
        $task->description = $request->description;
        $task->user_id = auth()->user()->id;
        $task->save();
        return redirect('/');
    }

    public function delete(Request $request, Tasks $task)
    {
        if(isset($_POST['delete'])) {
            $task->delete();
            return redirect('/');
        }
    }

    public function updateStatus() {
        $task = Tasks::find($_POST['id']);
        $task->complete = true;
        $task->save();
        return response()->json(['success' => 'Task has been marked as completed.']);
    }

}
