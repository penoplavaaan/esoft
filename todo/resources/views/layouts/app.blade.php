<?php

use App\Models\User;

?>

    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Войти') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Зарегистрироваться') }}</a>
                            </li>
                        @endif
                    @else

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Здравствуйте, <u> {{ Auth::user()->surname }} {{ Auth::user()->name }} {{ Auth::user()->patronymic }}</u>!
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->supervisor != null)
                                    <div class="dropdown-item">
                                        Ваш
                                        начальник: {{User::where('id', Auth::user()->supervisor )->get()->first()->name}}
                                        .
                                        <br><a
                                            href="mailto:{{User::where('id', Auth::user()->supervisor )->get()->first()->email}}">
                                            Напишем ему?</a>
                                    </div>
                                @endif

                                <div class="dropdown-item">
                                    Ваш ID в системе: {{ Auth::user()->id }}
                                </div>

                                <a class="dropdown-item red" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    Выйти из системы
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                        <li class="nav-item">
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addTask">
                                Добавим задачу?
                            </button>
                            <!--form id="add-task-form" action="/home/add" method="get" class="d-none"-->
                            </form>
                        </li>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Давайте изменим сортировку!
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route('home')}}">---</a>
                                <a class="dropdown-item" href="{{route('orderbydate')}}">По дате</a>
                                <a class="dropdown-item" href="{{route('orderbyresponsible')}}">По ответственным</a>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="addTask" tabindex="-1" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Добавить задачу</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="get" action="{{route('addtask')}}">
                                        @csrf
                                        <div class="modal-body">


                                            <div class="form-group row">
                                                <label for="name"
                                                       class="col-md-4 col-form-label text-md-right">{{ __('Название') }}</label>

                                                <div class="col-md-6">
                                                    <input id="name" type="text"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           name="name" value="{{ old('name') }}" required
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
                                                    <input id="description" type="text"
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
                                                    <input id="deadline" type="date"
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

                                                <div class="col-md-6">
                                                    <select name="priority" id="priority"
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

                                                <div class="col-md-6">
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
                                            <button type="submit" class="btn btn-outline-primary">Добавить</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
