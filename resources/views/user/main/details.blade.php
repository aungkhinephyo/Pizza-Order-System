@extends('user.layouts.master')
@section('title', 'Product Details')
@section('content')

    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5 pt-3">
        <a href="javascript:void(0);" class="text-decoration-none btn btn-dark rounded-2 mb-5"
            onclick="window.history.back();"><i class="fas fa-arrow-left text-light"></i> Back</a>
        <div class="row px-xl-5">
            <div class="col-lg-5">
                <div style="max-height: 350px; overflow:hidden">
                    <img class="w-100 h-100 rounded-1" src="{{ asset('storage/product_img/' . $product->image) }}">
                </div>
            </div>

            <div class="col-lg-7 h-100">
                <div class="h-100 bg-light p-30">

                    <h3>{{ $product->name }}</h3>

                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                        </div>
                        <small class="pt-1"><i class="fas fa-eye"></i> {{ $product->view_count }}</small>
                    </div>

                    <h3 class="font-weight-semi-bold mb-4">$ {{ $product->price }}</h3>

                    <p class="mb-4">{{ $product->description }}</p>

                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" id="quantity" class="form-control bg-secondary border-0 text-center"
                                value="1" min="1" max="20">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="addtocart-btn" class="btn btn-primary px-3"><i
                                class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>

                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <!-- Products Start -->
    <div class="container-fluid pb-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($products as $p)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="w-100 h-100" src="{{ asset('storage/product_img/' . $p->image) }}"
                                    alt="">
                                <div class="product-action">
                                    <a class="btn btn-dark text-light rounded-2" href="javascript:void(0);"><i
                                            class="fa fa-heart"></i></a>
                                    <a class="btn btn-dark text-light rounded-2"
                                        href="{{ route('user#prodcutDetailsPage', $p->id) }}"><i
                                            class="fas fa-info-circle"></i></a>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center text-center py-2">
                                <h6>{{ $p->name }}</h6>
                                <h5>$ {{ $p->price }}</h5>
                                <small><i class="fas fa-eye"></i> {{ $p->view_count }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $.ajax({
                type: 'get',
                url: '/user/ajax/addViewCount',
                data: {
                    product_id: {{ $product->id }},
                },
                dataType: 'json',
            })

            $(document).on('click', '#addtocart-btn', function() {
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/addToCart',
                    data: {
                        user_id: {{ Auth::user()->id }},
                        product_id: {{ $product->id }},
                        quantity: $('#quantity').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully added to cart',
                            text: 'Check your cart.',
                        })
                    }
                })
            })

        });
    </script>
@endsection
