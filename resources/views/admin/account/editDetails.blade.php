@extends('admin.layouts.master')
@section('title', 'Edit Account Details')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10 offset-1">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h3 class="title-2">Edit Account Info</h3>
                                    <p class="small mt-2"><span class="text-danger">*</span> You can only just upload profile
                                        with the first phase.</p>
                                </div>

                                <hr>

                                {{-- Start User Image --}}
                                <div class="row">
                                    <div class="col-3 mx-auto">
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender == 'male')
                                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle">
                                            @else
                                                <img src="{{ asset('images/female_default.webp') }}" class="rounded-circle">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/admin_profile/' . Auth::user()->image) }}"
                                                class="rounded-circle">
                                        @endif
                                    </div>
                                </div>
                                {{-- Start User Image --}}

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <form action="{{ route('admin#account#updateDetails') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Update User Profile</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="file" name="image">
                                                    <button type="submit"
                                                        class="input-group-text btn text-light bg-dark">Upload</button>
                                                </div>
                                                @error('image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Role</label>
                                                <input class="form-control" type="text" name="role"
                                                    value="{{ old('name', Auth::user()->role) }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input class="form-control" type="text" name="name"
                                                    value="{{ old('name', Auth::user()->name) }}" placeholder="Username">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <input class="form-control" type="email" name="email"
                                                    value="{{ old('email', Auth::user()->email) }}" placeholder="Email">
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input class="form-control" type="text" name="phone"
                                                    value="{{ old('phone', Auth::user()->phone) }}"
                                                    placeholder="09-98xxxx">
                                                @error('phone')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="form-control" name="gender" required>
                                                    <option value="male"
                                                        @if (Auth::user()->gender == 'male') selected @endif>Male</option>
                                                    <option value="female"
                                                        @if (Auth::user()->gender == 'female') selected @endif>Female</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Address</label>
                                                <textarea class="form-control" type="text" name="address" placeholder="Address">{{ old('address', Auth::user()->address) }}</textarea>
                                                @error('address')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <button class="au-btn au-btn--block btn-dark m-b-20" type="submit"><i
                                                    class="fas fa-edit"></i> Update</button>

                                        </form>
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
