@if($model instanceof App\Question)
    @php
        $name = 'question';
        $firstURLSegment = 'questions';
        $vote_count_column = $model->votes ?? !empty($model);
    @endphp
@elseif($model instanceof App\Answer)
    @php
        $name = 'answer';
        $firstURLSegment = 'answers';
        $vote_count_column = $model->votes_count ?? !empty($model);
    @endphp
@endif
<a title="This {{ $name }} is useful" class="vote-up {{Auth::guest() ? 'off' : ''}}"
   onclick="event.preventDefault(); document.getElementById('up-vote-{{ $name }}-{{$model->id}}').submit()">
    <i class="fas fa-caret-up fa-3x"></i>
</a>
<form class="d-none" action="/laravel1/learning/public/{{ $firstURLSegment }}/{{$model->id}}/vote" id="up-vote-{{ $name }}-{{$model->id}}" method="post">
    @csrf
    <input type="hidden" name="vote" value="1">
</form>

<span class="votes-count">{{$vote_count_column}}</span>

<a title="This {{ $name }} is not useful" class="vote-down {{Auth::guest() ? 'off' : ''}}"
   onclick="event.preventDefault(); document.getElementById('down-vote-{{ $name }}-{{$model->id}}').submit()">
    <i class="fas fa-caret-down fa-3x"></i>
</a>
<form class="d-none" action="/laravel1/learning/public/{{ $firstURLSegment }}/{{$model->id}}/vote" id="down-vote-{{ $name }}-{{$model->id}}" method="post">
    @csrf
    <input type="hidden" name="vote" value="-1">
</form>
