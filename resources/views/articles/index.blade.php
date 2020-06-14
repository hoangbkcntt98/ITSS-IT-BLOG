@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$article->title}}</div>
                    <div class="card-body">
                        <p>Author: {{$author->name}}</p>
                        <p>Published at: {{$article->published_at}}</p>
                        <br/>
                        <img src="../images/{{$article->image}}"
                             style="
                             display: block;
                             margin-left: auto;
                             margin-right: auto;
                             width: 50%;"
                             alt="acerA515.jpg">
                        <br/>
                        <p>{{$article->content}}</p>
                        <br/>
                    </div>
                    <div class="card-footer">
                        <p>Comments</p>
                            @foreach($comments as $comment)
                                <p>User: {{$comment->user_name}}</p>
                                <p>{{$comment->content}}</p>
                                <br/>
                            @endforeach
                        <p>Add a comment</p>
                        <form method="post">
                            @csrf
                            <input type="text" name="content"/>
                            <input type="submit" class="btn btn-success"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
