@extends('user.layouts.master')
@section('title', 'Contact Page')
@section('content')

    <div class="container">
        <a href="{{ route('user#homePage') }}" class="text-decoration-none btn btn-dark rounded-2 my-3"
            onclick="window.history.back();"><i class="fas fa-arrow-left text-light"></i> Back</a>
        <div class="row mt-4">
            <div class="col-lg-6 mx-auto p-5 shadow rounded-3">
                <h3 class="text-center">Contact Us</h3>
                <form action="{{ route('sendMessage') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                            placeholder="Your Name" autofocus />
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                            placeholder="Email Address" />
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label>Phone Number</label>
                        <input type="number" name="phone" class="form-control" value="{{ old('phone') }}"
                            placeholder="Phone Number" />
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label>Subject</label>
                        <select name="subject" class="form-select">
                            <option value="" selected disabled>Choose option</option>
                            <option value="About Order">About Order</option>
                            <option value="Suggestion">Suggestion</option>
                            <option value="UX Experience">UX Experience</option>
                            <option value="UI Experience">UI Experience</option>
                        </select>
                        @error('subject')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label>Message</label>
                        <textarea name="message" rows="5" class="form-control">{{ old('name') }}</textarea>
                        @error('message')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info">Send Message</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        @if (session('sent'))
            Swal.fire({
                icon: 'success',
                title: 'Successfully Sent',
                text: 'Message has been sent.',
            })
        @endif
    </script>
@endsection
