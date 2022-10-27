@extends('admin.layouts.master')
@section('title', 'Create Product')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-10 mx-auto text-right">
                        <a href="{{ route('admin#product#listPage') }}"><button
                                class="btn bg-dark text-white my-3 mx-2">List</button></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="card">
                            <div class="card-body p-5">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Create New Product</h3>
                                </div>
                                <hr>
                                <form action="{{ route('admin#product#create') }}" method="POST" novalidate="novalidate"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input name="productName" type="text"
                                            class="form-control @error('productName')
                                        is-invalid @enderror"
                                            placeholder="New Product..." value="{{ old('productName') }}" autofocus />
                                        @error('productName')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Category</label>
                                        <select name="productCategory"
                                            class="form-control  @error('productName')
                                        is-invalid @enderror">
                                            <option value="">Choose Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('productCategory')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Description</label>
                                        <textarea name="productDescription"
                                            class="form-control  @error('productName')
                                        is-invalid @enderror"
                                            rows="6" placeholder="Type here...">{{ old('productDescription') }}</textarea>
                                        @error('productDescription')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Product Image</label>
                                        <input name="productImage" type="file"
                                            class="form-control  @error('productName')
                                        is-invalid @enderror" />
                                        @error('productImage')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Price</label>
                                        <input name="productPrice" type="number"
                                            class="form-control @error('productPrice')
                                        is-invalid @enderror"
                                            min="5" max="100" step="0.01" value="{{ old('productPrice') }}"
                                            placeholder="$.." />
                                        @error('productPrice')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Waiting Time (min)</label>
                                        <input name="productTime" type="number"
                                            class="form-control @error('productTime')
                                        is-invalid @enderror"
                                            min="15" step="1" value="{{ old('productTime') }}"
                                            placeholder="..." />
                                        @error('productPrice')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div>
                                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                            <span id="payment-button-amount">Create</span>
                                            {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                            <i class="fa-solid fa-circle-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection
