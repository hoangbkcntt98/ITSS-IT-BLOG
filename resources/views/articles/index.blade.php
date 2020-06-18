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
                    <div class="card-footer" >
                        <h4>Comments</h4>
                        <div id = "add-comment">
                            @foreach($comments as $comment)
                                <div class="card" >
                                    <div class="card-header" id="comment">
                                        <p class="center_vertical">
                                        User: {{$comment->name}}
                                        </p>
                                    </div>
                                    <div class="body">
                                        <p class="content">{{$comment->content}}</p>
                                    </div>
                                </div>
                                </br>
                            @endforeach
                        </div>
                        <h4>Add a comment</h4>
                        <div class = "form-group">
                            <input type="text" placeholder="comment something ..."
                                   name="comment" id = "comment-content"/>
                            <button id = "comment-button" class = "btn btn-primary btn-sm" >Comment</button>
                        </div>
                    </div>
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
            url: '{{  url('articles/'.$article->id) }}',
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
