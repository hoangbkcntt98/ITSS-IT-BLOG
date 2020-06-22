<script>
$(document).ready(function() { 
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".file-upload").on('change', function(){
        readURL(this);
    });
});
</script>
<style>
    #pro{
        border: 1px solid gray;
         border-radius: 25px;
         padding:1em;
         background: -webkit-linear-gradient(left, white, white);
    }
    .img-circle{
        border:0.5px solid;
    }
</style>
<div class="container bootstrap snippet" id = "pro">
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
              

      <div class="text-center">
      {!! Form::open(['action' => ['ProfileController@update',$user->id],'method'=>'PUT','role'=>'form','enctype'=>'multipart/form-data']) !!}
        @if($user->img=='http://ssl.gstatic.com/accounts/ui/avatar_2x.png')
        <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar" style = "width:200px;height:200px;">
        @else
        <img src="../images/{{$user->img}}" class="avatar img-circle img-thumbnail" alt="avatar" style = "width:200px;height:200px;">
        @endif
        <h6>Upload a different photo...</h6>
        {{Form::file('image',['class' => 'text-center center-block file-upload'])}}
      </div></hr><br>      
          <div class="panel panel-default">
            <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
            <div class="panel-body"><a href="http://bootnipets.com">{{$user->email}}</a></div>
          </div>
          
          
          <ul class="list-group">
            <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Comments</strong></span> 125</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> 13</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> 37</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> 78</li>
          </ul> 
               
          <div class="panel panel-default">
            <div class="panel-heading">Social Media</div>
            <div class="panel-body">
            	<i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
            </div>
          </div>
          
        </div><!--/col-3-->
    	<div class="col-sm-9" style = "padding-top:5%;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Information</a></li>
                <li><a data-toggle="tab" href="#post-manager">Articles</a></li>
                @if($user->is_admin==1)
                <li><a data-toggle="tab" href="#user-manager">Users</a></li>
                <li><a data-toggle="tab" href="#product-manager">Products</a></li>

                @endif
              </ul>
              
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                
                  <div class='form-horizontal'>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="first_name"><h4>Full name</h4></label>
                              {{Form::text('name', $user->name, ['class' => 'form-control'])}}
                          </div>
                          <div class="col-xs-6">
                              <label for="phone"><h4>Phone</h4></label>
                              {{Form::text('phone', $user->phone, ['class' => 'form-control'])}}
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="email"><h4>Email</h4></label>
                              {{Form::text('email', $user->email, ['class' => 'form-control'])}}
                          </div>
                          @if($user->is_admin)
                          <div class="col-xs-6">
                              <label for="password"><h4>Account Type</h4></label>
                              {{Form::select('is_admin', [1 => 'Admin', 0 =>'User'], $user->is_admin)}}
                          </div>
                          @else
                          <div class="col-xs-6">
                              <label for="password"><h4>Account Type</h4></label>
                              {{Form::select('is_admin', [0 =>'User'], $user->is_admin)}}
                          </div>
                          @endif
                      </div>
                      <div class="form-group">
                          <div class="col-xs-6">
                              <label for="password"><h4>Password</h4></label>
                              {{Form::input('password','password', $user->password, ['class' => 'form-control'])}}
                          </div>
                          <div class="col-xs-6">
                            <label for="password2"><h4>Password Confirm</h4></label>
                            {{Form::input('password','password-confirm', '', ['class' => 'form-control'])}}
                          </div>
                      </div>
                      <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                                {{Form::submit('Save Changes',['class'=>'btn btn-lg btn-primary btn-success'])}}
                                <button class="btn btn-lg btn-primary" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                            </div>
                      </div>
                      {!! Form::close() !!}
                      </div>
              <hr> 
             </div><!--/tab-pane-->
             @include("users.user-management")
             @include("users.post-managerment")
             @include("users.product-management")
          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->