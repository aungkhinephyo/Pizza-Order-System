@extends('admin.layouts.master')
@section('title', 'Account Details')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10 offset-1">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex justify-content-between align-items-center px-2">
                                    <h3 class="text-center title-2">Account Info</h3>
                                    <a href="{{ route('admin#account#editDetailsPage') }}" class="btn btn-primary">
                                        <i class="fas fa-edit mr-2"></i> Edit Info
                                    </a>
                                </div>
                                <hr>
                                <div class="row p-3">
                                    <div class="col-lg-4 ml-auto d-flex align-items-center">
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender == 'male')
                                                <img src="{{ asset('images/default-user.jpg') }}">
                                            @else
                                                <img src="{{ asset('images/female_default.webp') }}">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/admin_profile/' . Auth::user()->image) }}"
                                                class="profile_img rounded-circle">
                                        @endif
                                    </div>
                                    <div class="col-lg-6 ml-auto d-flex align-items center">
                                        <div>
                                            <ul class="list-unstyled">
                                                <li class="my-3" style="font-weight:bold;"><i
                                                        class="fas fa-user text-primary mr-3"></i>{{ Auth::user()->name }}
                                                </li>
                                                <li class="my-3" style="font-weight:bold;"><i
                                                        class="fas fa-envelope text-primary mr-3"></i>{{ Auth::user()->email }}
                                                </li>
                                                <li class="my-3" style="font-weight:bold;">
                                                    <i
                                                        class="fas fa-phone-volume text-primary mr-3"></i>{{ Auth::user()->phone }}
                                                </li>
                                                <li class="my-3" style="font-weight:bold;">
                                                    <i
                                                        class="fas fa-map-marker-alt text-primary mr-3"></i>{{ Auth::user()->address }}
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
