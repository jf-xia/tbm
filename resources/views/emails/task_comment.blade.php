<!doctype html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<div>
    Hi {{ $groupComment->task->user->name }}:<br><br>
    <b>{{ $groupComment->user->name }}</b> <b style="color:red">{{ $groupComment->grade==2 ? trans('view.Bad') : trans('view.Good') }}</b>, @lang('view.Thank you for your hard work!') <b>{{ $groupComment->user->name }}</b> @lang('view.Says'):
    <br><br>
    {{ $groupComment->comment }}
</div>
<small><i><a href="{{ url('') }}" style="color: #c4e3f3">@lang('view.THIS IS AN AUTOMATIC EMAIL, PLEASE DO NOT REPLY TO THIS MESSAGE.')</a> </i></small>

</body>
</html>