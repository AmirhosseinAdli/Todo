@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>ثبت نام</h1>

        @if(session('error'))
            <p class="text-danger">{{session('error')}}</p>
        @endif

        <form action="{{  route('register')  }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">نام</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="email">ایمیل</label>
                <input type="email" class="form-control" id="email" name="email">
                @error('email') <p class="m-0">{{$message}}</p> @enderror
            </div>

            <div class="form-group">
                <label for="mobile">موبایل</label>
                <input type="text" class="form-control" id="mobile" name="mobile">
                @error('mobile') <p class="m-0">{{$message}}</p> @enderror
            </div>

            <div class="form-group">
                <label for="password">رمز</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="password_confirmation">تکرار رمز</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">ثبت نام</button>
        </form>
    </div>
@endsection
