@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>ورود</h1>

        @if(session('error'))
            <p class="text-danger">{{session('error')}}</p>
        @endif

        <form action="{{  route('login')  }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="email">ایمیل</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="password">رمز</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary">ورود</button>
        </form>
    </div>
@endsection
