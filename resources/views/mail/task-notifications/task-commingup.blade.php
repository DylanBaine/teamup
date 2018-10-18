@component('mail::message')
<div style="width: 500px; margin: auto; margin-top: 20px;">
    <header>
        <h1>
            You have some tasks with activity coming up.
        </h1>
        <hr>
    </header>
    @if(count($notifications->startingTomorrow))
    <h2>Tasks Starting Tomorrow:</h2>
    <ul>
        @foreach($notifications->startingTomorrow as $n)
        <li>
            <a href="{{url('/app-redirect?ref=cronEmail:TasksCommingUp&to=tasks/'.$n->task->id)}}/manage">
                {{$n->task->name}}
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    @if(count($notifications->dueTomorrow))
    <h2>Tasks Due Tomorrow:</h2>
    <ul>
        @foreach($notifications->dueTomorrow as $n)
        <li>
            <a href="{{url('/app-redirect?ref=cronEmail:TasksCommingUp&to=tasks/'.$n->task->id)}}/manage">
                {{$n->task->name}}
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    @if(count($notifications->dueToday))
    <h2>Tasks Due Today:</h2>
    <ul>
        @foreach($notifications->dueToday as $n)
        <li>
            <a href="{{url('/app-redirect?ref=cronEmail:TasksCommingUp&to=tasks/'.$n->task->id)}}/manage">
                {{$n->task->name}}
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    @if(count($notifications->startingTomorrow))
    <h2>Tasks Starting Tomorrow:</h2>
    <ul>
        @foreach($notifications->startingTomorrow as $n)
        <li>
            <a href="{{url('/app-redirect?ref=cronEmail:TasksCommingUp&to=tasks/'.$n->task->id)}}/manage">
                {{$n->task->name}}
            </a>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endcomponent