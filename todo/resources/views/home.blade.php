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
                            <div class="card">
                                <div class="card-header">
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
                                    <b>Статус:</b>

                                    <select name="" id="" onchange="">
                                        <option @if($task->status == "К выполнению") selected @endif value="{{$task->id}}">К выполнению</option>
                                        <option @if($task->status == "Выполняется") selected @endif value="{{$task->id}}">Выполняется</option>
                                        <option @if($task->status == "Выполнена") selected @endif  value="{{$task->id}}">Выполнена</option>
                                        <option @if($task->status == "Отменена") selected @endif value="{{$task->id}}">Отменена</option>
                                    </select>
                                    <br><br>
                                    <button type="button" class="btn btn-outline-primary">Изменить задачу</button> <button href="#" class="btn btn-outline-danger">Удалить задачу</button>
                                </div>
                            </div>

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
