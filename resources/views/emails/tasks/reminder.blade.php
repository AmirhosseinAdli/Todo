@component('mail::message')
    # Reminder

    {{$task->title}}

    @component('mail::button', ['url' => route('tasks.show',$task)])
        View Task
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
