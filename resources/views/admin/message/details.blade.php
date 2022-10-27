@extends('admin.layouts.master')
@section('title', 'Message Details Page')
@section('content')
    <div class="main-content">

        <div class="section__content section__content--p30">
            <div class="container">
                <a href="{{ route('admin#contact#listPage') }}"><button class="btn bg-dark text-white my-2 mx-3"><i
                            class="fas fa-arrow-left"></i> Back</button></a>
                <div class="col-md-12">

                    <div class="col-12 p-5 mb-4 bg-white shadow">

                        <div class="row">
                            <div class="col-lg-2 text-primary">
                                <p><i class="fas fa-user-tag mr-2"></i> <span>Name:</span></p>
                                <p><i class="fas fa-envelope mr-3"></i><span>Email:</span></p>
                                <p><i class="fas fa-phone-alt mr-3"></i><span>Phone:</span></p>
                                <p><i class="fab fa-battle-net mr-3"></i><span>Subject:</span></p>
                            </div>
                            <div class="col-lg-5 text-dark">
                                <p>{{ $message->name }}</p>
                                <p>{{ $message->email }}</p>
                                <p>{{ $message->phone }}</p>
                                <p>{{ $message->subject }}</p>

                            </div>
                        </div>
                        </h4>
                        <div>
                            <p class="text-dark mt-4 mb-2">Message is sent at
                                {{ $message->created_at->format('M-j-Y g:i a') }}.</p>
                            <p class="bg-secondary text-light p-3">"" {{ $message->message }} ""</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
