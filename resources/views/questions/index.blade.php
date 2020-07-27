@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-lg-10">
                <div class="card">
                    <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>All Questions</h2>
                        <div class="ml-auto">
                            <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask Questions</a>
                        </div>
                    </div>
                    </div>

                    <div class="card-body">
                        @include('layouts._messages')

                        @forelse($questions as $question)
                            <div class="media post">
                                <div class="d-flex flex-column counters">
                                    <div class="vote">
                                        <strong>{{ $question->votes }}</strong> {{ Str::plural('vote', $question->votes) }}
                                    </div>
                                    <div class="status {{ $question->status }}">
                                        <strong>{{ $question->answers_count }}</strong> {{ Str::plural('answer', $question->answers_count) }}
                                    </div>
                                    <div class="view">
                                        {{ $question->views . " " . Str::plural('view', $question->views) }}
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                                        <div class="ml-auto" style="min-width: 7em">
                                            @if($authenticated)
                                                @can('update-question', $question) {{--First define Gate 'update-question' in AuthServiceProvider.php--}}
                                                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                                @endcan
                                                @can('delete-question', $question)
                                                <form class="form-delete" method="post" action="{{ route('questions.destroy', $question->id) }}">
                                                    {{ method_field('DELETE') }}
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                                @endcan
                                            @endif
                                        </div>
                                    </div>

                                    <p class="lead">
                                        Asked by <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        <small class="text-muted">{{ $question->created_date }}</small>
                                    </p>
                                    <div class="excerpt">{{ $question->excerpt(300) }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-warning">
                                <strong>SORRY</strong> There are no questions available.
                            </div>
                        @endforelse
                        <div class="flex-column align-content-center">
                            {{ $questions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
