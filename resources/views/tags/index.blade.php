@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h1>لیست تگ ها</h1>
            <div>
                <a href="{{route('tags.create')}}" class="btn btn-primary">اضافه کردن</a>
                <a href="{{route('tasks.index')}}" class="btn btn-secondary">مدیریت تسک ها</a>
            </div>
        </div>

        @if(session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif

        @forelse($tags as $tag)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title" style="color: {{$tag->color}}">{{  $tag->name  }}</h5>
                </div>
                <div class="card-footer d-flex flex-column">
                    <a href="{{route('tags.show',$tag)}}">نمایش</a>
                    <form action="{{route('tags.destroy',$tag)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('آیا مطمئن هستید؟')">حذف از طریق متد delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="alert alert-info">شما هنوز تگی اضافه نکرده اید</div>
        @endforelse
    </div>
@endsection
