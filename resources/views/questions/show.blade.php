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

                                @include('shared._vote', [
                                    'model'=>$question,
                                ])

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
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        @include('shared._author', [
                                            'label'=>'Asked',
                                            'model'=> $question,
                                        ])
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
