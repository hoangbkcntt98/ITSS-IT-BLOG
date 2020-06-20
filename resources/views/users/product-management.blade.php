<div class="tab-pane" id="product-manager">
    <div style = "padding-top:2em;">
				<div class="form-group">
                    Search by Product Name: <input type="text" class="form-controller" id="pro_search" name="search"></input>
                </div>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<td style = "background:#D8D8D8;"><h5>Name</h5></td>
							<td style = "background:#D8D8D8;" ><h5>CPU</h5></td>
							<td style = "background:#D8D8D8;"><h5>RAM</h5></td>
							<td style = "background:#D8D8D8;"><h5>OS</h5></td>
                            <td style = "background:#D8D8D8;"><h5>Price</h5></td>
                            <td></td>
							<!-- <td ></td> -->
						</tr>
					</thead>
					<tbody id = 'product'>
						@if($products)
						@foreach($products as $pro)
                        <tr>
							<td class="cart_description">
								<h5>{{$pro->product_name}}</h5>
							</td>
                            <td class="cart_description">
								<h5>{{$pro->CPU}}</h5>
							</td>
                            <td class="cart_description">
								<h5>{{$pro->RAM}}</h5>
							</td>
                            <td class="cart_description">
								<h5>{{$pro->OS}}</h5>
							</td>
                            <td class="cart_description">
								<h5>{{$pro->price}}</h5>
							</td>
							<td class="cart_description">
								<button class = "btn btn-danger btn-sm" value = "D" id = "del_pro" onclick = "del_pro({{$pro->id}})"><span class="glyphicon glyphicon-trash"></span></button>
								<input type = "button" class = "btn btn-success btn-sm" value = "Detail" id = "view_pro" onclick = "view_pro({{$pro->id}})">
							</td>
						</tr>
                        @endforeach
						@endif
					</tbody>
				</table>
			</div>
</div><!--/tab-pane-->
<script type="text/javascript">
             $('#pro_search').on('keyup',function(){
                $value = $(this).val();
				console.log($value);
                $.ajax({
                    type: 'get',
                    url: '{{  url('pro_search') }}',
                    data: {
                        'search': $value
                    },
                    success:function(data){
                        $('#product').html(data);
                    }
                });
            });
			function del_pro(id){
				var result = confirm("Are you sure to delete this product?");
				if(result){
					$.ajax({
                    type: 'delete',
                    url: '{{  url('del_pro') }}',
                    data: ({
						_token : $('meta[name="csrf-token"]').attr('content'),
                        'id':id
                    }),
                    success:function(data){
						$('#product').html(data);
                    }
                });
				}
			}
			function view_pro(id){
				window.open('product-details/'.concat(id),'popup',200,300);
			}
			$.ajaxSetup({
 			 headers: {
  			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				}
			});

</script>
