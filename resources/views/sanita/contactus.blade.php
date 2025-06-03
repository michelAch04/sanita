@extends('sanita.layout')

@section('content')
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-4">Contact Us</h2>
        <form class="mx-auto" style="max-width: 600px;">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea class="form-control" id="message" rows="4" placeholder="Type your message here..."></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark">Send Message</button>
            </div>
        </form>
    </div>
</section>
@endsection