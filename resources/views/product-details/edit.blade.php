@extends('layouts.product-details-layout')

@section('content')
    <div class="product-details"><!--product-details-->
        @if($product = $products->get(0))
            <div class="col-sm-5">
                <div class="view-product">
                    <img src="{{$product->image}}" alt=""/>
                </div>
            </div>
            <div class="col-sm-7 pt-0">
                <div class="product-information"><!--/product-information-->
                    <img src="../../../public/layouts/images/product-details/new.jpg" class="newarrival" alt=""/>
                    <img src="../../../public/layouts/images/product-details/rating.png" alt=""/>
                    <form method="POST" action="/product-details/{{$product->id}}/save">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Product name: </label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$product->product_name}}">
                        </div>
                        <div class="form-group">
                            <label for="price">Price: </label>
                            <input type="text" class="form-control" id="price" name="price" value="{{$product->price}}">
                        </div>
                        <div class="form-group">
                            <label for="cpu">CPU Information: </label>
                            <input type="text" class="form-control" id="cpu" name="cpu" value="{{$product->CPU}}">
                        </div>
                        <div class="form-group">
                            <label for="ram">RAM Information: </label>
                            <input type="text" class="form-control" id="ram" name="ram" value="{{$product->RAM}}">
                        </div>
                        <div class="form-group">
                            <label for="disk">Disk: </label>
                            <input type="text" class="form-control" id="disk" name="disk" value="{{$product->disk}}">
                        </div>
                        <div class="form-group">
                            <label for="graphic-card">Card Graphic: </label>
                            <input type="text" class="form-control" id="graphic-card" name="graphic_card" value="{{$product->graphic_card}}">
                        </div>
                        <div class="form-group">
                            <label for="os">OS: </label>
                            <input type="text" class="form-control" id="os" name="os" value="{{$product->OS}}">
                        </div>
                        <div class="form-group">
                            <label for="size">Size: </label>
                            <input type="text" class="form-control" id="size" name="size" value="{{$product->size}}">
                        </div>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </form>
                    <p><i>Publish Date:</i> {{$product->created_at}}</p>
                </div><!--/product-information-->
            </div>
        @elseif(!$product = $products->get(0))
            <div>
                <p>Product Information not defiend</p>
            </div>
        @endif
    </div><!--/product-details-->

    <div class="category-tab shop-details-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#reviews" data-toggle="tab">Reviews</a></li>
            </ul>
        </div>
        @if($articles->count() > 0)
            @foreach($articles as $article)
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="reviews">
                        <div class="col-sm-12">
                            <ul>
                                <li><a href=""><i class="fa fa-user"></i>{{$users[$article->user_id-1]->name}}</a>
                                </li>
                                <li><a href=""><i class="fa fa-clock-o"></i>{{$article->created_at}}</a></li>
                                <li><a href=""><i class="fa fa-calendar-o"></i>{{$article->updated_at}}</a></li>
                            </ul>
                            <a href="#">{{$article->title}}</a>
                        </div>
                    </div>
                    @endforeach
                    <button type="button" class="btn btn-primary btn-lg pull-right">
                        Add Reviews
                    </button>
                </div>
                @elseif($articles->count()==0)
                    <div>
                        <h3>No Reviews For this product. Please add Reviews the product at here!!!</h3>
                        <button type="button" class="btn btn-primary btn-lg pull-right">
                            Add Reviews
                        </button>

                    </div>
                @endif

    </div><!--/category-tab-->
    </div>
@endsection

