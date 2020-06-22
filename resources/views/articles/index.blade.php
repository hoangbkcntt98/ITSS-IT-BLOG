@extends('layouts.product-details-layout')
<link href="{{asset('css/article.css')}}" rel="stylesheet">

@section('content')
    <div class="card">
        <div class="card-header title">{{$article->title}}</div>
        <div class="card-body">
            <div>
                <img src="{{asset('/images')}}/{{$article->image}}"
                     class="image"
                     alt="product_image">
            </div>
            <br/>
            <div class="card">
                <div class="card-header">
                    <p class="text">Author: {{$author->name}}
                        <br/>
                    Published at: {{$article->published_at}}
                    </p>
                </div>
                <div class="body content">
                    <p class="text">{{$article->content}}</p>
                </div>
            </div>
            <br/>
        </div>
        <div class="card-footer" >
            <h4 class="text">Comments</h4>
            <div id = "add-comment">
                @foreach($comments as $comment)
                    <div class="card comment_line" >
                        <div class="card-header" id="comment">
                            <p class="text">
                            User: {{$comment->name}}
                            </p>
                        </div>
                        <div class="body">
                            <p class="text">{{$comment->content}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <h4>Add a comment</h4>
            <div class = "form-group">
                <input type="text" placeholder="comment something ..."
                       name="comment" id = "comment-content"/>
                <div class="center_button">
                    <button id = "comment-button" class = "btn btn-primary btn-sm" >Comment</button>
                </div>
            </div>
        </div>
    </div>
<script>

    $('#comment-button').click(function(){
        var value = $('#comment-content').val();
        if(value!=null){
            $.ajax({
            type: 'post',
            url: '{{  url(url()->current()) }}',
                data: ({
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    comment: value
                }),
                success:function(data){
                    $('#add-comment').append(data.html);
             },
            });
        }else{
            alert('Content of comment is empty')
        }

    });

	$.ajaxSetup({
 		headers: {
  			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 			}
		});
</script>
@endsection
