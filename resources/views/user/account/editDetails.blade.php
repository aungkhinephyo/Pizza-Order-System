@extends('user.layouts.master')
@section('title', 'Edit Account Details')

@section('content')
    <!-- MAIN CONTENT-->

    <div class="container-fluid">
        <a href="javascript:void(0);" class="text-decoration-none btn btn-dark rounded-2 my-3"
            onclick="window.history.back();"><i class="fas fa-arrow-left text-light"></i> Back</a>
        <div class="row">
            <div class="col-lg-7 mx-auto mt-2">
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
                                        <img src="{{ asset('images/default-user.jpg') }}" class="profile_img" />
                                    @else
                                        <img src="{{ asset('images/female_default.webp') }}" class="profile_img" />
                                    @endif
                                @else
                                    <img src="{{ asset('storage/user_profile/' . Auth::user()->image) }}"
                                        class="profile_img">
                                @endif
                            </div>
                        </div>
                        {{-- Start User Image --}}

                        <div class="row mt-4">
                            <div class="col-12">
                                <form action="{{ route('user#account#updateDetails') }}" method="POST"
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
                                            value="{{ old('phone', Auth::user()->phone) }}" placeholder="09-98xxxx">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender" required>
                                            <option value="male" @if (Auth::user()->gender == 'male') selected @endif>Male
                                            </option>
                                            <option value="female" @if (Auth::user()->gender == 'female') selected @endif>Female
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" type="text" name="address" placeholder="Address">{{ old('address', Auth::user()->address) }}</textarea>
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="d-grid">
                                        <button class="btn btn-dark" type="submit"><i class="fas fa-edit"></i>
                                            Update</button>
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
