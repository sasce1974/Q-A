@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        @include('layouts._messages')
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{ $question->title }}</h1>
                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back To All Questions</a>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="media">
                            <div class="d-flex flex-column vote-controls">

                                <a title="This question is useful" class="vote-up {{Auth::guest() ? 'off' : ''}}"
                                   onclick="event.preventDefault(); document.getElementById('up-vote-question-{{$question->id}}').submit()">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <form class="d-none" action="/laravel1/learning/public/questions/{{$question->id}}/vote" id="up-vote-question-{{$question->id}}" method="post">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>

                                <span class="votes-count">{{$question->votes}}</span>

                                <a title="This question is not useful" class="vote-down {{Auth::guest() ? 'off' : ''}}"
                                   onclick="event.preventDefault(); document.getElementById('down-vote-question-{{$question->id}}').submit()">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form class="d-none" action="/laravel1/learning/public/questions/{{$question->id}}/vote" id="down-vote-question-{{$question->id}}" method="post">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>

                                <a title="Click to mark as favorite question, click again to undo"
                                   class="mt-2 favorite {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }}"
                                    onclick="event.preventDefault(); document.getElementById('favorite-question-{{$question->id}}').submit()">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">{{$question->favorites_count}}</span>
                                    <form class="d-none" action="/laravel1/learning/public/questions/{{$question->id}}/favorites" id="favorite-question-{{$question->id}}" method="post">
                                        @csrf
                                        @if($question->is_favorited)
                                            @method('DELETE')
                                        @endif
                                    </form>
                                </a>
                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="float-right" style="min-width: 12em">
                                    <span class="text-muted">Posted {{ $question->created_date }}</span>
                                    <div class="media mt-2">
                                        <a href="{{ $question->user->url }}" class="pr-2">
                                            <img src="{{ $question->user->avatar }}">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('answers._index', [
        'answers' => $question->answers,
        'answers_count' => $question->answers_count,
        ])
        @if(Auth::check())
        @include('answers._create')
        @endif
    </div>
@endsection
