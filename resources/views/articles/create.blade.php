@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Article</div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div>
                                <div>
                                    <img class="preview_image" id="preview" src="#" alt="article image" />
                                </div>
                                <div>
                                    <input type="file" name="article_image" id="imgInp">
                                </div>
                            </div>

                            <div>
                                <textarea  class="input_comment textarea_article" name="title" placeholder="input title..." required="true"></textarea>
                                <br>
                                <textarea  class="input_comment textarea_article" name="description" placeholder="input description" required="true"></textarea>
                                <br>
                                <textarea class="input_comment textarea_article content" name="text" placeholder="input content of article..." required="true"></textarea>
                            </div>

                            <button type="submit" name="product_id" value={{$product_id}}>Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgInp").change(function() {
            readURL(this);
        });
    </script>
@endsection
