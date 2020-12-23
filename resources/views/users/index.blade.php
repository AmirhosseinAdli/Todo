@extends('layouts.app')

@section('content')
    <ul>
        @foreach($users as $user)
            <li>{{$user->name}} - {{$user->role}}@can('delete-admin',$user)<a href="#">delete</a>@endcan</li>
        @endforeach
    </ul>
@endsection
