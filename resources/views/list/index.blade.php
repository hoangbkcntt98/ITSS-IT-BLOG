@extends('layouts.master')

@section('content')

    <div class="container">

        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if (session()->has('error_message'))
            <div class="alert alert-danger">
                {{ session()->get('error_message') }}
            </div>
        @endif

        @if($products->count() > 0)
            @foreach ($products->chunk(4) as $items)
                <div class="row">
                    @foreach ($items as $product)
                        <div class="col-md-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <a href="{{ url('product-details', [$product->id]) }}"><img src="{{$product->image}}" alt="product" class="product-img"></a>
                                        <a href="{{ url('product-details', [$product->id]) }}"><h3>{{ $product->product_name }}</h3> </a>
                                        <div class="star">
                                            <p>{{ $product->stars_rate }}</p>
                                            <img src="layouts/images/home/star.png" alt="" class="star-rating">
                                        </div>
                                    </div> <!-- end caption -->
                                    <div class="product-overlay">
                                        <div class="overlay-content">
                                            <a href="{{ url('product-details', [$product->id]) }}">
                                                <p><b>CPU:</b>{{$product->CPU}}</p>
                                                <p><b>RAM:</b> {{$product->RAM}}</p>
                                                <p><b>Disk:</b> {{$product->disk}}</p>
                                                <p><b>Graphic Card:</b> {{$product->graphic_card}}</p>
                                                <p><b>OS:</b> {{$product->OS}}</p>
                                                <p><b>Size:</b> {{$product->size}}</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- product-image-wrapper -->
                        </div> <!-- end col-md-3 -->
                    @endforeach
                </div> <!-- end row -->
            @endforeach
            {{$products->render()}}
        @else
                    <div class="text-center">
                        <h3>No result!!!</h3>
                    </div>
        @endif

    </div> <!-- end container -->


@endsection
