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
                <label for="username">ایمیل یا شماره</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>

            <div class="form-group">
                <label for="password">رمز</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-primary">ورود</button>
        </form>
    </div>
@endsection
