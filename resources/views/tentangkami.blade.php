{{-- resources/views/about.blade.php --}}
@extends('layouts.front')

@section('title', 'About Us')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">About Us</h1>
    <p class="lead text-center">Welcome to our company! We’re dedicated to providing the best service possible.</p>
    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Our Mission</h3>
            <p>Our mission is to deliver high-quality, innovative solutions that help our clients achieve their goals.</p>
        </div>
        <div class="col-md-6">
            <h3>Our Vision</h3>
            <p>We aim to be a leader in our industry, known for our commitment to customer satisfaction and cutting-edge technology.</p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <h3>Meet the Team</h3>
            <p>Our team consists of talented individuals from diverse backgrounds who are passionate about what they do.</p>
            <!-- Optional: Add team members' profiles here -->
        </div>
    </div>
</div>
@endsection
