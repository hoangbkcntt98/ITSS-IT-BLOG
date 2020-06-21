@extends('layouts.product-details-layout')

@section('content')
    <div class="product-details"><!--product-details-->
        @if($product = $products->get(0))
            <div class="col-sm-5">
                <div class="view-product">
                    <img src="{{$product->image}}" alt=""/>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="product-information py-0"><!--/product-information-->
                    <h2>{{$product->product_name}}</h2>
                    <span>
                        <span>Price: ${{$product->price}}</span>
                    </span>
                    <p><b>CPU:</b>{{$product->CPU}}</p>
                    <p><b>RAM:</b> {{$product->RAM}}</p>
                    <p><b>Disk:</b> {{$product->disk}}</p>
                    <p><b>Graphic Card:</b> {{$product->graphic_card}}</p>
                    <p><b>OS:</b> {{$product->OS}}</p>
                    <p><b>Size:</b> {{$product->size}}</p>
                    <p><i>Publish Date:</i> {{$product->created_at}}</p>
                </div><!--/product-information-->
                <div class="row">
                    <div id="vote-stars-result">
                        <b>Vote Rate: <i>(Total Rate: {{$product->count_rates}} votes, rate
                                average: {{$product->stars_rate}})</i></b>
                    </div>
                    @include('product-details.ratting-stars')
                    @if($user != null && $user->is_admin == 1)
                        <div>
                            <a class="btn btn-primary btn-block pull-right"
                               href="/product-details/{{$product->id}}/edit">Edit</a>
                        </div>
                    @endif
                </div>
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
                                <li><a href=""><i class="fa fa-user"></i>{{$users->get($article->user_id)->name}}</a>
                                </li>
                                <li><a href=""><i class="fa fa-clock-o"></i>{{$article->created_at}}</a></li>
                                <li><a href=""><i class="fa fa-calendar-o"></i>{{$article->updated_at}}</a></li>
                            </ul>
                            <a href={{url()->current()."/articles"}}>{{$article->title}}</a>
                        </div>
                    </div>
                    @endforeach
                    <a href="{{url()->current()."/create_article"}}">
                        <button type="button" class="btn btn-primary btn-lg pull-right">
                            Add Reviews
                        </button>
                    </a>
                </div>
                @elseif($articles->count()==0)
                    <div>
                        <h3>No Reviews For this product. Please add Reviews the product at here!!!</h3>
                        <a href="{{url()->current()."/create_article"}}">
                            <button type="button" class="btn btn-primary btn-lg pull-right">
                                Add Reviews
                            </button>
                        </a>
                    </div>
                @endif

    </div><!--/category-tab-->
    </div>
@endsection
