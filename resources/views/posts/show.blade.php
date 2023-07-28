@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-5">
        <div class="card">
            <div class="card-header">
                <img src="{{ asset('storage/images/'.$post->image) }}" alt="" class="card-img-top">
            </div>
            <div class="card-body">
                <p class="text-muted">
                    {{$post->title}}
                </p>
                <p class="fw-bold">
                    {{$post->body}}
                </p>
            </div>
            <div class="card-footer">
                <form action="{{route('comments.store',$post->id)}}" method="post">
                    @csrf
                    <div class="input-group">
                        <textarea name="body" id=""  rows="1" class="form-control">

                        </textarea>
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
                <div class="mt-3">
                    <ul class="list-group">
                        @foreach($post->comments as $comment)
                        <li class="border-0 p-3 list-group-item">
                            <p class="text-muted">
                                {{$comment->user->name}} &nbsp; <span class="fw-bold">{{ $comment->body }}</span>
                            </p>
                            <p class="p-0 m-0 text-m">
                                <form action="{{route('comments.delete',$comment->id)}}" methods="post">
                                    @csrf
                                    @method('DELETE')
                                    @if ($comment->user->id === Auth::user()->id)
                                    <button class="btn p-0 text-danger">Delete</button>
                                    &middot;
                                    @endif
                                    <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                                </form>
                            </p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
