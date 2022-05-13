<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;


class AdminController extends Controller
{
    public function index()
    {
        $deleted_tasks = Tasks::onlyTrashed()->paginate(10);
        $active_tasks = Tasks::where('complete', 0)->paginate(10);
        $completed_tasks = Tasks::where('complete', 1)->paginate(10);
        return view('admin_dashboard', compact('deleted_tasks', 'active_tasks', 'completed_tasks'));
    }

    public function delete(Request $request, Tasks $task)
    {
        if(isset($_POST['delete'])) {
            $task->delete();
            return redirect('/admin');
        }
    }

    public function updateStatus() {
        $task = Tasks::find($_POST['id']);
        $task->complete = true;
        $task->save();
        return response()->json(['success' => 'Task has been marked as completed.']);
    }
}
