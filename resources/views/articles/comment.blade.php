<link href="{{asset('css/article.css')}}" rel="stylesheet">

<div class="card comment_line" >
    <div class="card-header" id="comment">
        <p class="text">
        User: {{$user->name}}
        </p>
    </div>
    <div class="body">
        <p class="text">{{$comment->content}}</p>
    </div>
</div>
