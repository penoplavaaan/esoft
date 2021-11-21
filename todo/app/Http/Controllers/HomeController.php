<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $responsible_task = Task::where(
            'responsibleID', Auth::user()->id
        )->get();
        $creator_tasks = Task::where(
            'creatorID', Auth::user()->id
        )->get();
        $all_tasks = $creator_tasks->merge($responsible_task);
        return view('home')->with('tasks',$all_tasks);
    }

    public function add()
    {
        $subordinates = User::where(
            'supervisor', Auth::user()->id
        )->get();
        return view('add')->with('subordinates',$subordinates);
    }


}
