@extends('admin.layouts.master')
@section('title', 'Edit Category')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 mx-auto text-right">
                        <a href="{{ route('admin#category#list') }}"><button
                                class="btn bg-dark text-white my-3 mx-2">List</button></a>
                    </div>
                </div>
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Category Name</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#category#update', $category->id) }}" method="POST"
                                novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label mb-1">Edit Name</label>
                                    <input name="categoryName" type="text"
                                        class="form-control @error('categoryName')
                                        is-invalid @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Seafood..."
                                        value="{{ old('categoryName', $category->name) }}" autofocus />
                                    @error('categoryName')
                                        <small class="text-danger fs-6">{{ $message }}</small>
                                    @enderror
                                    <input type="hidden" name="categoryId" value="{{ $category->id }}">
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <span id="payment-button-amount"><i class="fas fa-pencil-alt mr-1"></i>Update</span>
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
