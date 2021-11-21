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

        $responsible_task_today = Task::
            where('responsibleID', Auth::user()->id)->
            where('deadline', "=", date("Y-n-j"))->
            get();
        $creator_tasks_today = Task::
            where('creatorID', Auth::user()->id)->
            where('deadline', "=", date("Y-n-j"))->
            get();
        $all_tasks_today = $creator_tasks_today->merge($responsible_task_today);

        $responsible_task_week = Task::
            where('responsibleID', Auth::user()->id)->
            whereBetween('deadline', [date("Y-n-j", strtotime(' +1 day')),date("Y-n-j", strtotime(' +7 day'))])->
            get();
        $creator_tasks_week = Task::
            where('creatorID', Auth::user()->id)->
            whereBetween('deadline', [date("Y-n-j", strtotime(' +1 day')),date("Y-n-j", strtotime(' +7 day'))])->
            get();
        $all_tasks_week = $creator_tasks_week->merge($responsible_task_week);

        $responsible_task_future = Task::
            where('responsibleID', Auth::user()->id)->
            where('deadline', "=", date("Y-n-j", strtotime(' +8 day')))->
            get();
        $creator_tasks_future = Task::
            where('creatorID', Auth::user()->id)->
            where('deadline', "=", date("Y-n-j", strtotime(' +8 day')))->
            get();
        $all_tasks_future = $creator_tasks_future->merge($responsible_task_future);

        $subordinates = User::where(
            'supervisor', Auth::user()->id
        )->get();
        return view('home')->with('tasks_future',$all_tasks_future)->with('subordinates',$subordinates)->with('tasks_today',$all_tasks_today)->with('tasks_week',$all_tasks_week);
    }

    public function add()
    {


    }


}
