@extends('layouts.app')

@section('full_page_head')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Hilot Sarap</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles -->
<style>
    .hero-section {
        background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1600334129128-685c5582fd35?ixlib=rb-4.0.3');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0;
    }
    .service-card {
        transition: transform 0.3s;
        height: 100%;
    }
    .service-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection

@section('full_page')
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Hilot Sarap</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Experience Authentic Filipino Massage</h1>
        <p class="lead mb-5">Relax, rejuvenate, and restore your balance with our traditional healing techniques</p>
        <div class="d-flex justify-content-center gap-3">
            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal">Book Now</button>
            <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#registerModal">Create Account</button>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Our Services</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card service-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Traditional Filipino Massage</h5>
                        <p class="card-text">Experience the authentic healing touch that has been passed down through generations.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Aromatherapy Massage</h5>
                        <p class="card-text">Enhance your massage experience with essential oils that promote relaxation and healing.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Hot Stone Therapy</h5>
                        <p class="card-text">Smooth, heated stones are used to release tension and promote deep relaxation.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Foot Reflexology</h5>
                        <p class="card-text">Targeted pressure points on the feet to promote healing throughout the body.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Full Body Scrub</h5>
                        <p class="card-text">Exfoliate and rejuvenate your skin with our traditional herbal scrubs.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card service-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Ventosa (Cupping)</h5>
                        <p class="card-text">Traditional cupping therapy to improve circulation and release muscle tension.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-light py-4">
    <div class="container text-center">
        <p class="mb-0">© 2025 Hilot Sarap. All rights reserved.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
