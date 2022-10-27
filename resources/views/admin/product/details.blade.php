@extends('admin.layouts.master')
@section('title', 'Product Details')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="p-1">
                    <a href="javascript:void(0);" onclick="window.history.back()"><button
                            class="btn bg-dark text-white my-2 mx-3"><i class="fas fa-arrow-left"></i> Back</button></a>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-1">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex justify-content-between align-items-center px-2">
                                    <h3 class="text-center title-2">Product Info</h3>
                                    <a href="{{ route('admin#product#editPage', $product->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit mr-2"></i> Edit Info
                                    </a>
                                </div>
                                <hr>
                                <div class="row p-3">
                                    <div class="col-lg-4 ml-auto d-flex align-items-center">
                                        @if ($product->image !== null)
                                            <img src="{{ asset('storage/product_img/' . $product->image) }}"
                                                class="img-thumbnail">
                                        @endif
                                    </div>
                                    <div class="col-lg-7 ml-auto d-flex align-items center">
                                        <div>
                                            <button class="btn btn-dark mb-2"><i
                                                    class="fas fa-pizza-slice text-warning mr-3"></i>{{ $product->name }}
                                            </button>
                                            <button class="btn btn-dark mb-2"><i
                                                    class="fa fa-code-branch text-warning mr-3"></i>{{ $product->category_name }}
                                            </button>
                                            <button class="btn btn-dark mb-2"><i
                                                    class="fa fa-dollar-sign text-warning mr-3"></i>
                                                ${{ $product->price }}/-
                                            </button>

                                            <button class="btn btn-dark mb-2"><i
                                                    class="fa fa-clock text-warning mr-3"></i>{{ $product->waiting_time }}
                                                min
                                            </button>
                                            <button class="btn btn-dark mb-2"><i
                                                    class="fa fa-eye text-warning mr-3"></i>{{ $product->view_count }}
                                            </button>

                                            <div class="mt-3">
                                                <i class="fas fa-comment-alt text-warning"></i> Description
                                                <p>{{ $product->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection

@section('script')
    <script>
        /* after old password wrong show alert box */
        @if (session('accountUpdate'))
            Swal.fire({
                icon: 'success',
                title: 'Updated!!',
                text: 'Your account is successfully updated.',
            })
        @endif
    </script>
@endsection
