<div class="tab-pane" id="post-manager">
    <div style = "padding-top:2em;">
				<div class="form-group">
                    Search by Title: <input type="text" class="form-controller" id="post_search" name="search"></input>
                </div>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<td style = "background:#D8D8D8;"><h5>Author</h5></td>
							<td style = "background:#D8D8D8;" ><h5>Title</h5></td>
							<td style = "background:#D8D8D8;"><h5>Product</h5></td>
							<td style = "background:#D8D8D8;"><h5>Created At</h5></td>
                            <td style = "background:#D8D8D8;"><h5>Updated At</h5></td>
                            <td></td>
							<!-- <td ></td> -->
						</tr>
					</thead>
					<tbody id = 'post'>
						@if($posts)
						@foreach($posts as $post)
                        <tr>
							<td class="cart_description">
								<h5>{{$post->name}}</h5>
							</td>
                            <td class="cart_description">
								<h5>{{$post->title}}</h5>
							</td>
                            <td class="cart_description">
								<h5>{{$post->product_name}}</h5>
							</td>
                            <td class="cart_description">
								<h5>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y g:i A')}}</h5>
							</td>
                            <td class="cart_description">
								<h5>{{ \Carbon\Carbon::parse($post->updated_at)->format('d/m/Y g:i A')}}</h5>
							</td>
							<td class="cart_description">
								<button class = "btn btn-danger btn-sm" value = "Delete" id = "del_user" onclick = "del_post({{$post->id}})"><span class="glyphicon glyphicon-trash"></span></button>
							</td>

						</tr>
                        @endforeach
						@endif
					</tbody>
				</table>
			</div>
</div><!--/tab-pane-->
<script type="text/javascript">
             $('#post_search').on('keyup',function(){

                $value = $(this).val();
				console.log($value);
                $.ajax({
                    type: 'get',
                    url: '{{  url('post_search') }}',
                    data: {

                        'search': $value
                    },
                    success:function(data){
                        $('#post').html(data);
                    }
                });
            });
			function del_post(id){
				console.log(id);
				var result = confirm("Are you sure to delete this post?");
				if(result){
					$.ajax({
                    type: 'delete',
                    url: '{{  url('del_post') }}',
                    data: ({
						_token : $('meta[name="csrf-token"]').attr('content'),
                        'id':id
                    }),
                    success:function(data){
						$('#post').html(data);
                    }
                	});
				}
			}
			$.ajaxSetup({
 			 headers: {
  			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				}
			});

</script>
