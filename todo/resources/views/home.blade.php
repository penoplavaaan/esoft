<?php
use App\Models\Task;
use App\Models\User;
?>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @if(isset($tasks) && !isset($responsibleIDs))
            <div class="card">
                <div class="card-header">Все задачи</div>
                <div class="card-body">
                    @if(count($tasks))
                    @foreach($tasks as $task)
                        @if($task->status !== "Отменена")
                            <div class="card">
                                <div class="card-header @if($task->status == 'Выполнена') {{'done-task'}} @elseif($task->deadline < date("Y-n-j")) {{'overdue-task'}} @endif">
                                    <h3 id="name-{{$task->id}}">{{$task->name}}</h3>
                                </div>
                                <div class="card-body">
                                    <p>
                                    <h6 id="description-{{$task->id}}" class="card-text">{{$task->description}}</h6>
                                    </p>
                                    <div >
                                        <b>Приоритет: </b>
                                        <span id="priority-{{$task->id}}" class="
                                                    @if($task->priority ==="Высокий") red
                                                    @elseif($task->priority ==="Средний") yellow
                                                    @else green
                                                    @endif
                                            ">{{$task->priority}}</span>
                                    </div>

                                    <div>
                                        <b>Дедлайн:</b>
                                        <span id="deadline-{{$task->id}}">{{$task->deadline}}</span>
                                    </div>

                                    <div>
                                        <b>Ответственный:</b>
                                        @if($task->responsibleID == Auth::user()->id )
                                            <span id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}">Я</span>
                                        @else
                                            <a id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}" href="mailto:{{User::where('id',$task -> responsibleID)->get()->first()->email}}">
                                                {{User::where('id',$task -> responsibleID)->get()->first()->surname}}
                                                {{User::where('id',$task -> responsibleID)->get()->first()->name}}
                                                {{User::where('id',$task -> responsibleID)->get()->first()->patronymic}}
                                            </a>
                                        @endif
                                    </div>


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
                                                <button type="button"   data-task-id="{{$task->id}}" class="btn btn-outline-primary trigger-change-task" data-bs-toggle="modal" data-bs-target="#changeTask">Изменить задачу</button>
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
                        Задач еще нет. <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addTask">Создать новую?</button>
                    @endif
                </div>
            </div>
        @elseif(isset($tasks_today))
            <div class="col-md">

                <div class="card">
                    <div class="card-header">Задачи на сегодня</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(count($tasks_today))
                            @foreach($tasks_today as $task)
                                @if($task->status !== "Отменена")
                                    <div class="card">
                                        <div class="card-header @if($task->status == 'Выполнена') {{'done-task'}} @elseif($task->deadline < date("Y-n-j")) {{'overdue-task'}} @endif">
                                            <h3 id="name-{{$task->id}}">{{$task->name}}</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                            <h6 id="description-{{$task->id}}" class="card-text">{{$task->description}}</h6>
                                            </p>
                                            <div >
                                                <b>Приоритет: </b>
                                                <span id="priority-{{$task->id}}" class="
                                                    @if($task->priority ==="Высокий") red
                                                    @elseif($task->priority ==="Средний") yellow
                                                    @else green
                                                    @endif
                                                    ">{{$task->priority}}</span>
                                            </div>

                                            <div>
                                                <b>Дедлайн:</b>
                                                <span id="deadline-{{$task->id}}">{{$task->deadline}}</span>
                                            </div>

                                            <div>
                                                <b>Ответственный:</b>
                                                @if($task->responsibleID == Auth::user()->id )
                                                    <span id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}">Я</span>
                                                @else
                                                    <a id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}" href="mailto:{{User::where('id',$task -> responsibleID)->get()->first()->email}}">
                                                        {{User::where('id',$task -> responsibleID)->get()->first()->surname}}
                                                        {{User::where('id',$task -> responsibleID)->get()->first()->name}}
                                                        {{User::where('id',$task -> responsibleID)->get()->first()->patronymic}}
                                                    </a>
                                                @endif
                                            </div>


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
                                                        <button type="button"   data-task-id="{{$task->id}}" class="btn btn-outline-primary trigger-change-task" data-bs-toggle="modal" data-bs-target="#changeTask">Изменить задачу</button>
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
                                Задач еще нет. <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addTask">Создать новую?</button>
                            @endif

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
                        @if(count($tasks_week))
                            @foreach($tasks_week as $task)
                                @if($task->status !== "Отменена")
                                    <div class="card">
                                        <div class="card-header
                                                @if($task->status == 'Выполнена') {{'done-task'}} @elseif($task->deadline < date("Y-n-j")) {{'overdue-task'}} @endif">
                                            <h3 id="name-{{$task->id}}">{{$task->name}}</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                            <h6 id="description-{{$task->id}}" class="card-text">{{$task->description}}</h6>
                                            </p>
                                            <div >
                                                <b>Приоритет: </b>
                                                <span id="priority-{{$task->id}}" class="
                                                    @if($task->priority ==="Высокий") red
                                                    @elseif($task->priority ==="Средний") yellow
                                                    @else green
                                                    @endif
                                                    ">{{$task->priority}}</span>
                                            </div>

                                            <div>
                                                <b>Дедлайн:</b>
                                                <span id="deadline-{{$task->id}}">{{$task->deadline}}</span>
                                            </div>

                                            <div>
                                                <b>Ответственный:</b>
                                                @if($task->responsibleID == Auth::user()->id )
                                                    <span id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}">Я</span>
                                                @else
                                                    <a id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}" href="mailto:{{User::where('id',$task -> responsibleID)->get()->first()->email}}">
                                                        {{User::where('id',$task -> responsibleID)->get()->first()->surname}}
                                                        {{User::where('id',$task -> responsibleID)->get()->first()->name}}
                                                        {{User::where('id',$task -> responsibleID)->get()->first()->patronymic}}
                                                    </a>
                                                @endif
                                            </div>


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
                                                        <button type="button"   data-task-id="{{$task->id}}" class="btn btn-outline-primary trigger-change-task" data-bs-toggle="modal" data-bs-target="#changeTask">Изменить задачу</button>
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
                                Задач еще нет. <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addTask">Создать новую?</button>
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
                        @if(count($tasks_future))
                            @foreach($tasks_future as $task)
                                @if($task->status !== "Отменена")
                                    <div class="card">
                                        <div class="card-header @if($task->status == 'Выполнена') {{'done-task'}} @elseif($task->deadline < date("Y-n-j")) {{'overdue-task'}} @else 123 @endif">
                                            <h3 id="name-{{$task->id}}">{{$task->name}}</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                            <h6 id="description-{{$task->id}}" class="card-text">{{$task->description}}</h6>
                                            </p>
                                            <div >
                                                <b>Приоритет: </b>
                                                <span id="priority-{{$task->id}}" class="
                                                    @if($task->priority ==="Высокий") red
                                                    @elseif($task->priority ==="Средний") yellow
                                                    @else green
                                                    @endif
                                                    ">{{$task->priority}}</span>
                                            </div>

                                            <div>
                                                <b>Дедлайн:</b>
                                                <span id="deadline-{{$task->id}}">{{$task->deadline}}</span>
                                            </div>

                                            <div>
                                                <b>Ответственный:</b>
                                                @if($task->responsibleID == Auth::user()->id )
                                                    <span id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}">Я</span>
                                                @else
                                                    <a id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}" href="mailto:{{User::where('id',$task -> responsibleID)->get()->first()->email}}">
                                                        {{User::where('id',$task -> responsibleID)->get()->first()->surname}}
                                                        {{User::where('id',$task -> responsibleID)->get()->first()->name}}
                                                        {{User::where('id',$task -> responsibleID)->get()->first()->patronymic}}
                                                    </a>
                                                @endif
                                            </div>


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
                                                        <button type="button"   data-task-id="{{$task->id}}" class="btn btn-outline-primary trigger-change-task" data-bs-toggle="modal" data-bs-target="#changeTask">Изменить задачу</button>
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
                                Задач еще нет. <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addTask">Создать новую?</button>
                            @endif

                    </div>
                </div>
            </div>
        @elseif(isset($responsibleIDs))
            @foreach($responsibleIDs as $ID)
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">
                            Ответственный пользователь:
                            @if($ID == Auth::user()->id)
                                Я
                            @else
                            {{User::where('id',"=",$ID)->get()->first()->surname}} {{User::where('id',"=",$ID)->get()->first()->name}}
                            @endif
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if(count($all_tasks))
                                @foreach($all_tasks as $task)
                                    @if($task->status !== "Отменена" && $task->responsibleID == $ID)
                                        <div class="card">
                                            <div class="card-header @if($task->status == 'Выполнена') {{'done-task'}} @elseif($task->deadline < date("Y-n-j")) {{'overdue-task'}} @endif">
                                                <h3 id="name-{{$task->id}}">{{$task->name}}</h3>
                                            </div>
                                            <div class="card-body">
                                                <p>
                                                <h6 id="description-{{$task->id}}" class="card-text">{{$task->description}}</h6>
                                                </p>
                                                <div >
                                                    <b>Приоритет: </b>
                                                    <span id="priority-{{$task->id}}" class="
                                                    @if($task->priority ==="Высокий") red
                                                    @elseif($task->priority ==="Средний") yellow
                                                    @else green
                                                    @endif
                                                        ">{{$task->priority}}</span>
                                                </div>

                                                <div>
                                                    <b>Дедлайн:</b>
                                                    <span id="deadline-{{$task->id}}">{{$task->deadline}}</span>
                                                </div>

                                                <div>
                                                    <b>Ответственный:</b>
                                                    @if($task->responsibleID == Auth::user()->id )
                                                        <span id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}">Я</span>
                                                    @else
                                                        <a id="responsible-{{$task->id}}" data-responsible-id="{{$task -> responsibleID}}" href="mailto:{{User::where('id',$task -> responsibleID)->get()->first()->email}}">
                                                            {{User::where('id',$task -> responsibleID)->get()->first()->surname}}
                                                            {{User::where('id',$task -> responsibleID)->get()->first()->name}}
                                                            {{User::where('id',$task -> responsibleID)->get()->first()->patronymic}}
                                                        </a>
                                                    @endif
                                                </div>


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
                                                            <button type="button"   data-task-id="{{$task->id}}" class="btn btn-outline-primary trigger-change-task" data-bs-toggle="modal" data-bs-target="#changeTask">Изменить задачу</button>
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
                                Задач еще нет. <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addTask">Создать новую?</button>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        @endif


        <div class="modal fade" id="changeTask" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Изменить задачу</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="get" action="{{route('cahangeTask')}}">
                        @csrf
                        <div class="modal-body">


                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Название') }}</label>

                                <div class="col-md-6">
                                    <input id="name-change" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name-change" value="{{ old('name') }}" required
                                           autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Описание') }}</label>

                                <div class="col-md-6">
                                    <input id="description-change" type="text"
                                           class="form-control @error('description') is-invalid @enderror"
                                           name="description" value="{{ old('description') }}" required
                                           autocomplete="description" autofocus>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deadline"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Дедлайн') }}</label>

                                <div class="col-md-6">
                                    <input id="deadline-change" type="date"
                                           class="form-control @error('deadline') is-invalid @enderror"
                                           name="deadline" value="{{ old('deadline') }}"
                                           autocomplete="deadline" autofocus>

                                    @error('deadline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="priority"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Приоритет') }}</label>

                                <div class="col-md-6" id="priority-change">
                                    <select name="priority-change"
                                            class="form-select form-select-lg mb-3">
                                        <option value="Низкий" class="green">Низкий</option>
                                        <option value="Средний" class="yellow">Средний</option>
                                        <option value="Высокий" class="red">Высокий</option>
                                    </select>
                                    @error('priority')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="responsibleID"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Ответственный') }}</label>

                                <div class="col-md-6" id="responsible-change">
                                    <select name="responsibleID" class="form-select form-select-lg mb-3"
                                            aria-label=".form-select-lg example">
                                        <option value="{{Auth::user()->id}}">Я</option>
                                        @foreach($subordinates as $subordinate)
                                            <option
                                                value="{{$subordinate->id}}">{{$subordinate->surname}} {{$subordinate->name}} {{$subordinate->patronymic}}</option>
                                        @endforeach

                                    </select>


                                    @error('supervisor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Закрыть
                            </button>
                            <button type="submit" class="btn btn-outline-primary" id="change-values" name="change-id">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
