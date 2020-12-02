@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h1>لیست کارها</h1>
            <a href="{{route('tasks.create')}}" class="btn btn-primary">اضافه کردن</a>
        </div>
        @forelse($tasks as $task)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{  $task->title  }}</h5>
                    <span class="badge badge-primary">{{  $task->done ? 'انجام شده' : 'انجام نشده' }}</span>
                </div>
            </div>
        @empty
            <div class="alert alert-info">شما هنوز کاری اضافه نکرده اید</div>
        @endforelse
    </div>
@endsection
