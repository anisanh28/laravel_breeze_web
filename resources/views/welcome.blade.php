@extends('layouts.front')

@section('meta')
<meta name="description" content="Learn more about TechAcademy, your place to gain tech knowledge and skills.">
@endsection

@section('title')
    <title>Home Page - TechAcademy</title>
@endsection

@section('style')
    <style>
        /* Background setup using right to left gradient */
        .background-image {
            background: linear-gradient(to left, #4f46e5, #14b8a6 ); /* Gradient from right to left */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        /* Container for the two columns */
        .content-container {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two equal columns */
            gap: 2rem;
            max-width: 1200px;
            width: 100%;
            padding: 2rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        /* Styling for the left text content */
        .content-wrapper {
            text-align: left;
            font-family: 'Roboto', sans-serif;
        }

        .content-wrapper h1 {
            font-size: 2.5rem;
            line-height: 1.3;
            margin-bottom: 1rem;
            font-weight: 700;
            animation: fadeInUp 1s ease-in-out;
        }

        .content-wrapper p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            color: #f0f0f0;
            animation: fadeInUp 1.5s ease-in-out;
        }

        /* Keyframes for fade-in animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button styling */
        .cta-button {
            background-color: #ee5006;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            animation: fadeInUp 2s ease-in-out;
        }

        .cta-button:hover {
            background-color: #00a587;
            transform: translateY(-5px);
        }

        /* Right image styling */
        .image-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-wrapper img {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            animation: fadeInUp 1.5s ease-in-out;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content-container {
                grid-template-columns: 1fr; /* Stack columns vertically on smaller screens */
                text-align: center;
            }

            .content-wrapper h1 {
                font-size: 2rem;
            }

            .content-wrapper p {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="background-image">
        <div class="content-container">
            <!-- Left column for text content -->
            <div class="content-wrapper">
                <h1>Selamat datang di TechAcademy</h1>
                <p>Your journey to mastering technology starts here. Join us to enhance your skills and knowledge.</p>
                <a href="{{ url('/login') }}" class="cta-button">Learn More</a>
            </div>

            <!-- Right column for image content -->
            <div class="image-wrapper">
                <img src="{{ asset('images/tech_image.jpg') }}" alt="Tech Academy Illustration"> <!-- Pastikan path gambar benar -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
