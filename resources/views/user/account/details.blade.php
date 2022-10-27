@extends('user.layouts.master')
@section('title', 'Account Details')

@section('content')
    <div class="container-fluid">
        <a href="javascript:void(0);" class="text-decoration-none btn btn-dark rounded-2 my-3"
            onclick="window.history.back();"><i class="fas fa-arrow-left text-light"></i> Back</a>

        <div class="row">
            <div class="col-lg-6 mx-auto mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between align-items-center px-2">
                            <h3 class="text-center title-2">Account Info</h3>
                            <a href="{{ route('user#account#editDetailsPage') }}" class="btn btn-info">
                                <i class="fas fa-edit mr-2"></i> Edit Info
                            </a>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-4 ml-auto d-flex align-items-center">
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
                            <div class="col-lg-6 ml-auto d-flex align-items center">
                                <div>
                                    <ul class="list-unstyled">
                                        <li class="my-3" style="font-weight:bold;"><i
                                                class="fas fa-user text-info mr-3"></i>{{ Auth::user()->name }}
                                        </li>
                                        <li class="my-3" style="font-weight:bold;"><i
                                                class="fas fa-envelope text-info mr-3"></i>{{ Auth::user()->email }}
                                        </li>
                                        <li class="my-3" style="font-weight:bold;">
                                            <i class="fas fa-phone-volume text-info mr-3"></i>{{ Auth::user()->phone }}
                                        </li>
                                        <li class="my-3" style="font-weight:bold;">
                                            <i class="fas fa-map-marker-alt text-info mr-3"></i>{{ Auth::user()->address }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        /* after old password change show alert box */
        @if (session('accountUpdate'))
            Swal.fire({
                icon: 'success',
                title: 'Updated!!',
                text: 'Your account is successfully updated.',
            })
        @endif
    </script>
@endsection
