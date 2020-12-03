@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h1>{{$task->title}}</h1>
            <a href="{{route('tasks.index')}}" class="btn btn-secondary">بازگشت</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{  route('tasks.update',[$task])  }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="title">عنوان</label>
                <input type="text" class="form-control" id="title" name="title" value="{{$task->title}}">
                @error('title') <p class="m-0">{{$message}}</p> @enderror
            </div>
            <div class="form-check">
                <input type="hidden" name="done" value="0">
                <input type="checkbox" class="form-check-input" id="done" name="done" value="1"
                       @if($task->done) checked @endif >
                <label class="form-check-label" for="done">آیا کار انجام شده است؟</label>
            </div>
            <button type="submit" class="btn btn-primary">بروزرسانی</button>
        </form>
    </div>
@endsection
