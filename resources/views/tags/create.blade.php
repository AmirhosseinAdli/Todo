@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h1>تگ جدید</h1>
            <a href="{{route('tags.index')}}" class="btn btn-secondary">بازگشت</a>
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

        <form action="{{  route('tags.store')  }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">نام</label>
                <input type="text" class="form-control" id="name" name="name">
                @error('name') <p class="m-0">{{$message}}</p> @enderror
            </div>
            <div>
                <label for="color">رنگ</label>
                <input type="color" class="form-control" id="color" name="color">
            </div>
            <button type="submit" class="btn btn-primary">اضافه کردن</button>
        </form>
    </div>
@endsection
