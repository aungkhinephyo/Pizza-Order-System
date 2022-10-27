@extends('admin.layouts.master')
@section('title', 'Edit Product')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <a href="javascript:void(0);" onclick="window.history.back()"><button class="btn bg-dark text-white my-2 mx-3"><i
                        class="fas fa-arrow-left"></i> Back</button></a>
            <div class="container-fluid">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title mb-3">
                                <h3 class="text-center title-2">Edit Product</h3>
                            </div>

                            {{-- Start Product Image --}}
                            <div class="row">
                                <div class="col-4 mx-auto">
                                    @if ($product->image !== null)
                                        <img src="{{ asset('storage/product_img/' . $product->image) }}"
                                            class="img-thumbnail mb-3">
                                    @endif
                                </div>
                            </div>
                            {{-- Start Product Image --}}

                            <form action="{{ route('admin#product#update') }}" method="POST" novalidate="novalidate"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="productId" value="{{ $product->id }}" />
                                <div class="form-group">
                                    <label>Update Image</label>
                                    <div class="input-group">
                                        <input name="productImage" type="file"
                                            class="form-control  @error('productName')
                                        is-invalid @enderror" />
                                        <button type="submit"
                                            class="input-group-text btn bg-dark text-light">Upload</button>
                                    </div>
                                    @error('productImage')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Name</label>
                                    <input name="productName" type="text"
                                        class="form-control @error('productName')
                                        is-invalid @enderror"
                                        value="{{ old('productName', $product->name) }}" autofocus />
                                    @error('productName')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Category</label>
                                    <select name="productCategory"
                                        class="form-control  @error('productCategory')
                                        is-invalid @enderror">

                                        <option value="">Choose Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if ($product->category_id == $category->id) selected @endif>{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('productCategory')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Description</label>
                                    <textarea name="productDescription"
                                        class="form-control  @error('productDescription')
                                        is-invalid @enderror"
                                        rows="6" placeholder="Type here...">{{ old('productDescription', $product->description) }}</textarea>
                                    @error('productDescription')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Price</label>
                                    <input name="productPrice" type="number"
                                        class="form-control @error('productPrice')
                                        is-invalid @enderror"
                                        min="5" max="100" step="0.01"
                                        value="{{ old('productPrice', $product->price) }}" placeholder="$.." />
                                    @error('productPrice')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Waiting Time (min)</label>
                                    <input name="productTime" type="number"
                                        class="form-control @error('productTime')
                                        is-invalid @enderror"
                                        min="15" step="1"
                                        value="{{ old('productTime', $product->waiting_time) }}" placeholder="..." />
                                    @error('productTime')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <span id="payment-button-amount"><i class="fas fa-edit"></i> Update</span>
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
    <!-- END MAIN CONTENT-->

@endsection
