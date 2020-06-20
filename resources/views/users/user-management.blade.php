<div class="tab-pane" id="user-manager">
    <div style = "padding-top:2em;">
				<div class="form-group">
                    Search by Name : <input type="text" class="form-controller" id="search" name="search"></input>
                </div>
				<table class="table table-bordered table-hover" id = "table_id">
					<thead>
						<tr>
							<td style = "background:#D8D8D8;"><h5>Full Name</h5></td>
							<td style = "background:#D8D8D8;" ><h5>Email</h5></td>
							<td style = "background:#D8D8D8;"><h5>Updated At</h5></td>
							<td style = "background:#D8D8D8;"><h5>Phone</h5></td>
                            <td style = "background:#D8D8D8;"><h5>Account Type</h5></td>
							<!-- <td ></td> -->
						</tr>
					</thead>
					<tbody id = "user">
						@foreach($users as $us)
                        <tr>
							<td class="cart_description">
								<h5>{{$us->name}}</h5>
							</td>
							<td class="cart_description">
                            <h5>{{$us->email}}</h5>
							</td>
							<td class="cart_description">
                            <h5>{{ \Carbon\Carbon::parse($us->updated_at)->format('d/m/Y g:i A')}}</h5>
							</td>
                            <td class="cart_description">
								<h5>{{$us->phone}}</h5>
                            </td>
                            <td class="cart_description">
								<h5>
                                    @if($us->is_admin==1)
                                        Admin
                                    @else
                                        User
                                    @endif
                                </a>
							</td>
                            <td class="cart_description" style = "border-right:none;padding-right:1px">
                                @if($us->is_admin==0)
								 <button  type = "button" class = "btn btn-danger btn-sm" value = "Delete" id = "del_user" onclick = "del_user({{$us->id}})"><span class="glyphicon glyphicon-trash"></span></button>

                                @endif
							</td>
                            <td class="cart_description" style = "border-left:none;padding-left:0px;">
                            @if($us->is_admin==0)
                                <input type = "button" class = "btn btn-success btn-sm" value = "Detail" id = "view_pro" onclick = "view_user({{$us->id}})">
                            @endif
                            </td>
						</tr>
                        @endforeach
					</tbody>
				</table>
			</div>
</div><!--/tab-pane-->
<script type="text/javascript">
            function view_user(id){
				window.open('/user/'.concat(id),'popup',200,300);
			}
            $('#search').on('keyup',function(){

                $value = $(this).val();
				console.log($value);
                $.ajax({
                    type: 'get',
                    url: '{{  url('user_search') }}',
                    data: {
                        'search': $value
                    },
                    success:function(data){
                        $('#user').html(data);
                    }
                });
            });
			function del_user(id){
               var result = confirm("Are you sure to delete this user?");
                if(result)  {
                    $.ajax({
                        type: 'delete',
                        url: '{{  url('del_user') }}',
                        data: ({
                            _token : $('meta[name="csrf-token"]').attr('content'),
                            'id':id
                        }),
                        success:function(data){
                            $('#user').html(data.users);
                            $('#post').html(data.posts);
                        }
                    });
              }

			}

			$.ajaxSetup({
 			 headers: {
  			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				}
			});
			// $('#del_user').on('onclick',function(){

            // })
            // $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
