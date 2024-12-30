<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BizGrow - Empower Your Business</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">

</head>

<body>

    <!-- Hero Section -->
    <header class="hero-section d-flex flex-column justify-content-center align-items-center text-center">
        <img src="{{ asset('images/logo.png') }}" alt="BizGrow Logo" class="logo mb-4">
        <h1 class="display-4 fw-bold">Welcome to BizGrow</h1>
        <p class="lead mb-4">Empower your small business with smart predictions for demand, profit, and stock tracking.</p>
        <div>
            <a href="pages/indexsignup.html" class="btn btn-lg btn-custom btn-signup me-3">Sign Up</a>
            <a href="pages/indexsignin.html" class="btn btn-lg btn-custom btn-signin">Sign In</a>
        </div>
    </header>

    <!-- Features Section -->
    <section class="features-section text-center py-5">
        <h2 class="section-title">Our Features</h2>
        <p class="section-subtitle mb-5">Explore how BizGrow supports your business growth.</p>
        <div class="container">
            <div class="row">
                <div class="col-md-4 feature-item">
                    <img src="{{ asset('images/landing_page1.jpg') }}" alt="Predict Demand" class="feature-icon mb-3">
                    <h3 class="feature-title">Predict Demand</h3>
                    <p>Optimize stock levels by accurately forecasting demand.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <img src="{{ asset('images/landing_page1.jpg') }}" alt="Optimize Profits" class="feature-icon mb-3">
                    <h3 class="feature-title">Optimize Profits</h3>
                    <p>Maximize profits with actionable insights and trend analysis.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <img src="{{ asset('images/landing_page1.jpg') }}" alt="Track Inventory" class="feature-icon mb-3">
                    <h3 class="feature-title">Track Inventory</h3>
                    <p>Real-time tracking to manage stock seamlessly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.css') }}"></script>
    <script src="{{ asset('js/landing_page.js') }}"></script>
</body>
</html>
