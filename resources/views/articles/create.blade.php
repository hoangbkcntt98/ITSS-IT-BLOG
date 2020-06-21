@extends('layouts.product-details-layout')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="{{asset('css/article.css')}}" rel="stylesheet">

@section('content')
    <div class="card">
        <div class="card-header title">Create New Article</div>

        <div class="card-body">
            <form enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <div class="input_image">
                    <div>
                        <img class="preview_image" id="preview" src="#" alt="article image" />
                    </div>
                    <div>
                        <input type="file" name="article_image" id="imgInp">
                    </div>
                </div>

                <div>
                    <textarea class="textarea_article" name="title" placeholder="input title..." required="true"></textarea>
                    <br>
                    <textarea class="textarea_article" name="description" placeholder="input description" required="true"></textarea>
                    <br>
                    <textarea class="textarea_article content" name="text" placeholder="input content of article..." required="true"></textarea>
                </div>
                <div class="center_button">
                    <button type="submit" class = "btn btn-primary btn-sm" id="submit-button" name="product_id" value={{$product_id}}>Submit</button>
                </div>
            </form>
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
