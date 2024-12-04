{{-- resources/views/about.blade.php --}}
@extends('layouts.front')

@section('title')
    <title>About Us - TechAcademy</title>
@endsection

@section('style')
<style>
    /* Full-screen gradient background */
    .background-gradient {
        background: linear-gradient(to left, #4f46e5, #14b8a6);
        min-height: 100vh;
        padding-top: 5rem; /* Adjust for navbar height */
        padding-bottom: 3rem; /* Extra padding at the bottom */
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }

    /* Content container for the page */
    .about-container {
        max-width: 1200px;
        width: 100%;
        padding: 0.5rem;
    }

    /* Title and introductory text */
    .about-container h1 {
        text-align: left;
        font-size: 2rem;
        margin-bottom: 1rem;
        font-weight: bold; /* Menjadikan teks bold */
        animation: fadeIn 1.5s ease-in-out;
    }

    .about-container p {
        text-align: justify;
        font-size: 1rem;
        margin-bottom: 2rem;
        animation: fadeIn 2s ease-in-out;
    }

    .about-container h3 {
        font-size: 1.2rem;
        color: #ffff;
        font-weight: bold; /* Menjadikan teks bold */
        margin-bottom: 1rem;
    }

    .section p {
        font-size: 1rem;
        color: #f0f0f0;
    }

    /* Responsive grid for text and video */
    .video-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        align-items: center;
        margin-top: 2rem;
    }

    .video-container iframe {
        width: 100%;
        height: 300px;
        border-radius: 10px;
    }

    /* Keyframe animation for fade-in effect */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .about-container h1 {
            font-size: 2.5rem;
        }

        .about-container p {
            font-size: 1rem;
        }

        .video-container {
            grid-template-columns: 1fr; /* Stack columns vertically on smaller screens */
        }
    }
</style>
@endsection

@section('content')
<div class="background-gradient">
    <div class="about-container">
        <h1>Tentang Kami</h1>
        <p>TechAcademy adalah platform pembelajaran berbasis teknologi yang dirancang untuk membantu pengguna meningkatkan pengetahuan dan keterampilan
             di bidang teknologi. Dengan menggunakan pendekatan Just in Time Teaching dan model Problem Based Learning, TechAcademy menyediakan pengalaman 
             belajar yang dinamis dan efektif. Platform ini menjadi komitmen developer untuk mendorong penguasaan kemampuan berpikir melalui pembelajaran yang
             mudah diakses dan sesuai dengan kebutuhan pengguna.</p>
        <h3>Cara Penggunaan TechAcademy</h3>
            <p>
                Ikuti panduan ini untuk memulai dengan TechAcademy. Pelajari berbagai fitur dan manfaat yang dapat Anda manfaatkan untuk belajar lebih efektif.
            </p>
        
        <!-- Video section -->
        <div class="video-container">
            <iframe src="https://www.youtube.com/embed/x6nL4Rg5jA0?si=h5eCtk3igyBEsLNc" title="TechAcademy Usage Guide" allowfullscreen></iframe>
        </div>
    </div>
</div>
@endsection
