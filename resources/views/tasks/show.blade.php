@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <div>
                <h1 id="title">{{  $task->title  }} ({{  $task->done ? 'انجام شده' : 'انجام نشده' }})</h1>
                <button class="btn btn-info btn-sm" type="submit" onclick="doneTask()">تغییر وضعیت</button>
            </div>
            <a href="{{route('tasks.index')}}" class="btn btn-primary">بازگشت</a>
        </div>

        <h2>یادداشت شما</h2>
        @forelse($task->notes as $note)
            <div class="card mb-4">
                <div class="card-body">
                    <p class="card-text">{{  $note->text  }}</p>
                </div>
                <div class="card-footer">
                    {!! Form::open(['route' => ['tasks.notes.destroy',$task->id,$note->id], 'method' => 'delete']) !!}
                    {!! Form::submit('حذف',['class' => 'btn btn-danger mt-10']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @empty
            <p>هنوز یادداشتی برای این کار اضافه نشده است</p>
        @endforelse

        <h3>افزودن یادداشت</h3>

        {!! Form::open(['route' => ['tasks.notes.store',$task->id]]) !!}
        {!! Form::textarea('text',null,['class' => 'form-control']) !!}
        {!! Form::submit('افزودن',['class' => 'btn btn-primary btn-block mt-10']) !!}
        {!! Form::close() !!}
    </div>
@endsection
@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function doneTask() {
            $.ajax({
                'method': 'post',
                'url': '{{  route('tasks.done',$task)  }}',
                success: function (response) {
                    if (response.success) {
                        $('#title').html(response.data.title + "(" + (response.data.done ? "انجام شده" : "انجام نشده") + ")")
                    }
                }
            })
        }
    </script>
@endpush


