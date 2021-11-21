
<?php
use App\Models\User;
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить задачу') }}</div>

                    <div class="card-body">
                        <form method="get" action="{{route('addtask')}}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Название') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Описание') }}</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="deadline" class="col-md-4 col-form-label text-md-right">{{ __('Дедлайн') }}</label>

                                <div class="col-md-6">
                                    <input id="deadline" type="date" class="form-control @error('deadline') is-invalid @enderror" name="deadline" value="{{ old('deadline') }}" autocomplete="deadline" autofocus>

                                    @error('deadline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="priority" class="col-md-4 col-form-label text-md-right">{{ __('Приоритет') }}</label>

                                <div class="col-md-6">
                                    <select name="priority" id="priority" class="form-select form-select-lg mb-3">
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
                                <label for="responsibleID" class="col-md-4 col-form-label text-md-right">{{ __('Ответственный') }}</label>

                                <div class="col-md-6">
                                    <select name="responsibleID" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                        <option value="{{Auth::user()->id}}">Я</option>
                                        @foreach($subordinates as $subordinate)
                                            <option value="{{$subordinate->id}}">{{$subordinate->surname}} {{$subordinate->name}} {{$subordinate->patronymic}}</option>
                                        @endforeach

                                    </select>


                                    @error('supervisor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Добавить') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
