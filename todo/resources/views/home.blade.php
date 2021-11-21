<?php
use App\Models\Task;
use App\Models\User;
?>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md">
            <div class="card">
                <div class="card-header">Задачи на сегодня</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-header">Задачи на неделю</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(count($tasks))
                        @foreach($tasks as $task)
                            @if($task->status !== "Отменена")
                                    <div class="card">
                                        <div class="card-header @if($task->status == 'Выполнена') {{'done-task'}} @elseif($task->dedaline < date("Y-n-j")) {{'overdue-task'}} @endif">
                                            <h4>{{$task->name}}</h4>
                                            <h5 class="card-text">{{$task->description}}</h5>
                                        </div>
                                        <div class="card-body">

                                            <b>Приоритет:</b>  {{$task->priority}} <br>
                                            <b>Дедлайн:</b> {{$task->deadline}} <br>
                                            <b>Ответственный:</b>
                                            @if($task->responsibleID == Auth::user()->id )
                                                Я
                                            @else
                                                <a href="mailto:{{User::where('id',$task -> responsibleID)->get()->first()->email}}">
                                                    {{User::where('id',$task -> responsibleID)->get()->first()->surname}}
                                                    {{User::where('id',$task -> responsibleID)->get()->first()->name}}
                                                    {{User::where('id',$task -> responsibleID)->get()->first()->patronymic}}
                                                </a>

                                            @endif
                                            <br>
                                            <form id="change-status-form-{{$task->id}}" action="{{ route('changeStatus') }}" method="get"  >
                                                <b>Статус:</b>
                                                <select name="status" id="" onchange="document.getElementById('change-status-form-{{$task->id}}').submit();">
                                                    <option @if($task->status == "К выполнению") selected @endif value="{{$task->id}}_К выполнению">К выполнению</option>
                                                    <option @if($task->status == "Выполняется") selected @endif value="{{$task->id}}_Выполняется">Выполняется</option>
                                                    <option @if($task->status == "Выполнена") selected @endif  value="{{$task->id}}_Выполнена">Выполнена</option>
                                                </select>
                                                @csrf
                                            </form>
                                            <br><br>

                                            @if($task->creatorID == Auth::user()->id)
                                                <div class="row">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-outline-primary" >Изменить задачу</button>
                                                    </div>
                                                    <div class="col">
                                                        <form id="cancel-task-form" action="{{ route('cancelTask') }}"  >
                                                            <button class="btn btn-outline-danger" name="cancelId"  value="{{$task->id}}" onclick="document.getElementById('cancel-task-form').submit();">Отменить задачу</button>
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                            @endif


                        @endforeach
                    @else
                        Задач еще нет. Создать новую?
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-header">Задачи на будущее</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
