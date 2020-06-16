@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$article->title}}</div>
                    <div class="card-body">
                        <img src="../images/{{$article->image}}"
                             class="center_positioning"
                             alt="acerA515.jpg">
                        <br/>
                        <div class="card">
                            <div class="card-header" id="info">
                                <p class="center_vertical">Author: {{$author->name}}
                                    <br/>
                                Published at: {{$article->published_at}}
                                </p>
                            </div>
                            <div class="body">
                                <p class="content">{{$article->content}}</p>
                            </div>
                        </div>
                        <br/>
                    </div>
                    <div class="card-footer">
                        <h4>Comments</h4>
                            @foreach($comments as $comment)
                                <div class="card">
                                    <div class="card-header" id="comment">
                                        <p class="center_vertical">
                                        User: {{$comment->name}}
                                        </p>
                                    </div>
                                    <div class="body">
                                        <p class="content">{{$comment->content}}</p>
                                    </div>
                                </div>
                                <br/>
                            @endforeach
                        <h4>Add a comment</h4>
                        <form method="post">
                            @csrf
                            <input type="text" placeholder="comment something ..."
                                   name="comment" class="input_comment"/>
                            <input type="submit" id = "submitButton" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
