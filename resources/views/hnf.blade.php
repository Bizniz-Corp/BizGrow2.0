<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BizGrow - Empower Your Business')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('styles')
    @stack('scripts-head')
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand fw-bold" href="{{ route('landing') }}">
                <img src="{{ asset('images/logo.png') }}" alt="BizGrow Logo" height="48" class="me-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                    <li class="nav-item"><a class="nav-link me-lg-3" href="#fitur">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="#tentang-kami">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="#testimonials">Testimonial</a></li>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link me-lg-3" href="#kontak">Kontak</a></li>
                </ul>
                @guest
                    <a class="btn btn-outline-primary rounded-pill px-3 mb-2 mb-lg-0 me-lg-2" href="{{ route('login') }}">
                        <span class="d-flex align-items-center">
                            <i class="bi-box-arrow-in-right me-2"></i>
                            <span class="small">Login</span>
                        </span>
                    </a>
                    <a class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" href="{{ route('register') }}">
                        <span class="d-flex align-items-center">
                            <i class="bi-person-plus-fill me-2"></i>
                            <span class="small">Register</span>
                        </span>
                    </a>
                @else
                    <a class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" href="{{ route('home') }}">
                        <span class="d-flex align-items-center">
                            <i class="bi-speedometer2 me-2"></i>
                            <span class="small">Dashboard</span>
                        </span>
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main style="margin-top: 80px;">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-light py-5 mt-5">
        <div class="container px-4 px-lg-5">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5 class="fw-bold">BizGrow</h5>
                    <p class="small text-muted">Solusi cerdas untuk pertumbuhan UMKM Anda.</p>
                    <p class="small text-muted mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'BizGrow') }}. All Rights Reserved.</p>
                </div>
                <div class="col-md-2 col-6">
                    <h6 class="text-uppercase fw-bold mb-3">Link Cepat</h6>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#fitur" class="text-muted text-decoration-none">Fitur</a></li>
                        <li><a href="#tentang-kami" class="text-muted text-decoration-none">Tentang Kami</a></li>
                        <li><a href="#faq" class="text-muted text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6">
                    <h6 class="text-uppercase fw-bold mb-3">Legal</h6>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#" class="text-muted text-decoration-none">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-uppercase fw-bold mb-3">Alamat Kantor</h6>
                    <p class="small text-muted">
                        Jl. Jalan<br>
                        Kota Bandung, Indonesia<br>
                        Email: <a href="mailto:bizgrow@gmail.com" class="text-muted text-decoration-none">info@bizgrow.com</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.css') }}"></script>
    <script src="{{ asset('js/landing_page.js') }}"></script>
    @stack('scripts')
</body>
</html>
