<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddTaskController extends Controller
{
    protected string $redirectTo = RouteServiceProvider::HOME;

    protected function validator(array $data)
    {

    }

    protected function create(Request $request)
    {
        Task::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'deadline' => $request['deadline'],
            'priority' => $request['priority'],
            'responsibleID' => $request['responsibleID'],
            'creatorID' => Auth::user()->id
        ]);

        return redirect()->route('home');
    }
    protected function changeStatus(Request $request)
    {
        $task_id = explode('_',$request->status)[0];
        $new_task_value = explode('_',$request->status)[1];
        Task::where('id', $task_id)->update(array('status' => $new_task_value));
        return redirect()->route('home');
    }
}
