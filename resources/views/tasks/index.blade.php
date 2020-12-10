@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h1>لیست کارها</h1>
            <a href="{{route('tasks.create')}}" class="btn btn-primary">اضافه کردن</a>
        </div>

        @if(session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif

        @forelse($tasks as $task)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        {{  $task->title  }} <a href="{{route('tasks.show',$task)}}"> نمایش</a></h5>
                    <span class="badge badge-primary">{{  $task->done ? 'انجام شده' : 'انجام نشده' }}</span>
                </div>
                <div class="card-footer d-flex flex-column">
                    <h5>
                        <a href="{{route('tasks.edit',[$task])}}">ویرایش</a>
                    </h5>
                    <p class="card-text">{{  verta($task->date)  }}</p>
                    <a href="{{route('tasks.show',[$task])}}">نمایش</a>
                    <a href="{{route('tasks.delete',[$task])}}">حذف از طریق متد get</a>
                    <form action="{{route('tasks.destroy',[$task])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('آیا مطمئن هستید؟')">حذف از طریق متد delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="alert alert-info">شما هنوز کاری اضافه نکرده اید</div>
        @endforelse
    </div>
@endsection
