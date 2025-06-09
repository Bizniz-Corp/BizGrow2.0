@extends('hnf')

@section('title', 'BizGrow - Manajemen Bisnis UMKM')

@section('content')

    <header id="hero" class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold display-4">BizGrow: Kembangkan UMKM Anda!</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5 lead">
                        Manajemen bisnis cerdas untuk UMKM. Kelola stok, catat penjualan, dan dapatkan prediksi akurat untuk pertumbuhan usaha Anda.
                    </p>
                    <a class="btn btn-primary btn-xl" href="{{ route('register') }}">Daftar Gratis Sekarang</a>
                    <a class="btn btn-outline-light btn-xl ms-2" href="#fitur">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </header>

    <section class="page-section" id="pain-points">
        <div class="container px-4 px-lg-5">
            <div class="text-center mb-5">
                <h2 class="mt-0 section-heading">Tantangan Umum Bisnis Anda?</h2>
                <hr class="divider divider-dark" />
                <p class="text-muted mb-4">BizGrow hadir untuk membantu Anda mengatasi berbagai kendala dalam mengelola bisnis.</p>
            </div>
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-3 col-md-6 text-center mb-5 mb-lg-0">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-boxes fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Stok Tidak Akurat</h3>
                        <p class="text-muted mb-0">Sering kehabisan atau kelebihan stok produk yang merugikan?</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center mb-5 mb-lg-0">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-pencil-square fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Pencatatan Manual</h3>
                        <p class="text-muted mb-0">Repot dengan pembukuan penjualan yang rumit dan memakan waktu?</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center mb-5 mb-md-0">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-graph-up-arrow fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Sulit Prediksi Pasar</h3>
                        <p class="text-muted mb-0">Bingung menentukan jumlah produksi atau pembelian barang?</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-gear fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Operasional Lambat</h3>
                        <p class="text-muted mb-0">Merasa operasional bisnis sehari-hari kurang efisien dan terstruktur?</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-light" id="fitur">
        <div class="container px-4 px-lg-5">
            <div class="text-center">
                <h2 class="section-heading">Solusi Lengkap dari BizGrow</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">Fitur canggih yang dirancang khusus untuk kemudahan dan pertumbuhan bisnis UMKM Anda.</p>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-4 col-md-6 text-center mb-4">
                    <div class="mt-5 card-feature">
                        <div class="mb-3"><i class="bi-archive-fill fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Manajemen Stok & Produk</h3>
                        <p class="text-muted mb-0">Atur katalog produk dan pantau ketersediaan stok secara real-time untuk efisiensi maksimal.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center mb-4">
                    <div class="mt-5 card-feature">
                        <div class="mb-3"><i class="bi-receipt-cutoff fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Pencatatan Penjualan</h3>
                        <p class="text-muted mb-0">Catat semua transaksi penjualan dengan mudah, cepat, dan terintegrasi. Dapatkan laporan otomatis.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center mb-4">
                    <div class="mt-5 card-feature">
                        <div class="mb-3"><i class="bi-graph-up fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Prediksi Permintaan</h3>
                        <p class="text-muted mb-0">Optimalkan strategi bisnis Anda dengan fitur prediksi permintaan pasar yang akurat berdasarkan data.</p>
                    </div>
                </div>
                 <div class="col-lg-4 col-md-6 text-center mb-4">
                    <div class="mt-5 card-feature">
                        <div class="mb-3"><i class="bi-bar-chart-line-fill fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Analisis & Laporan</h3>
                        <p class="text-muted mb-0">Pahami kinerja bisnis Anda melalui laporan keuangan dan penjualan yang mudah dimengerti.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center mb-4">
                    <div class="mt-5 card-feature">
                        <div class="mb-3"><i class="bi-shield-check fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Keamanan Data Terjamin</h3>
                        <p class="text-muted mb-0">Data bisnis Anda aman bersama kami dengan sistem enkripsi dan backup rutin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section" id="how-it-works">
        <div class="container px-4 px-lg-5">
            <div class="text-center">
                <h2 class="section-heading">Mulai dengan BizGrow dalam 3 Langkah!</h2>
                <hr class="divider divider-dark" />
            </div>
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 text-center p-4">
                    <div class="mb-2"><i class="bi-person-plus-fill fs-1 text-primary"></i></div>
                    <h4 class="my-3">1. Daftar Akun</h4>
                    <p class="text-muted">Buat akun gratis Anda dalam beberapa menit tanpa biaya tersembunyi.</p>
                </div>
                <div class="col-md-4 text-center p-4">
                    <div class="mb-2"><i class="bi-cloud-upload-fill fs-1 text-primary"></i></div>
                    <h4 class="my-3">2. Input Data Bisnis</h4>
                    <p class="text-muted">Masukkan informasi produk, stok awal, dan data penjualan Anda dengan mudah.</p>
                </div>
                <div class="col-md-4 text-center p-4">
                    <div class="mb-2"><i class="bi-rocket-takeoff-fill fs-1 text-primary"></i></div>
                    <h4 class="my-3">3. Kembangkan Bisnis</h4>
                    <p class="text-muted">Nikmati kemudahan pengelolaan dan dapatkan insight berharga untuk pertumbuhan usaha.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-dark text-white" id="testimonials">
        <div class="container px-4 px-lg-5">
            <div class="text-center">
                <h2 class="section-heading">Dipercaya oleh UMKM Seperti Anda</h2>
                <hr class="divider divider-light" />
                <p class="text-white-75 mb-5">Lihat bagaimana BizGrow membantu mereka bertumbuh.</p>
            </div>
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="card testimonial-card h-100">
                        <div class="card-body">
                            <p class="fst-italic mb-4">"Sejak pakai BizGrow, stok barang jadi lebih terkontrol dan prediksi penjualan sangat membantu kami mengurangi kerugian. Fiturnya lengkap dan mudah digunakan!"</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <div class="d-flex align-items-center">
                                {{-- <img src="{{ asset('images/user1.jpg') }}" alt="User Testimonial" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;"> --}}
                                <div>
                                    <h6 class="fw-bold mb-0">Anonymous</h6>
                                    <small class="text-muted">Pemilik Toko Kelontong</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="card testimonial-card h-100">
                        <div class="card-body">
                            <p class="fst-italic mb-4">"Aplikasi BizGrow benar-benar mengubah cara saya mengelola usaha. Laporan keuangannya sangat detail dan membantu pengambilan keputusan. Sangat direkomendasikan!"</p>
                        </div>
                         <div class="card-footer bg-transparent border-0">
                            <div class="d-flex align-items-center">
                                {{-- <img src="{{ asset('images/user2.jpg') }}" alt="User Testimonial" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;"> --}}
                                <div>
                                    <h6 class="fw-bold mb-0">Anonymous</h6>
                                    <small class="text-muted">Pemilik UMKM</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                     <div class="card testimonial-card h-100">
                        <div class="card-body">
                            <p class="fst-italic mb-4">"Sejak menggunakan Bizgrow saya merasa efisiensi waktu dan peningkatan omzet."</p>
                        </div>
                         <div class="card-footer bg-transparent border-0">
                            <div class="d-flex align-items-center">
                                {{-- <img src="{{ asset('images/user3.jpg') }}" alt="User Testimonial" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;"> <div> --}}
                                <div>
                                    <h6 class="fw-bold mb-0">Anonymous</h6>
                                    <small class="text-muted">Pemilik Warung</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section" id="tentang-kami">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="section-heading">Tentang BizGrow</h2>
                    <hr class="divider divider-dark" />
                    <p class="text-muted mb-4">
                        Kami percaya setiap UMKM berhak mendapatkan akses ke teknologi yang memudahkan pengelolaan dan pengembangan bisnis. BizGrow hadir sebagai partner pertumbuhan Anda, menyediakan alat yang intuitif dan powerful untuk membantu Anda mencapai kesuksesan.
                    </p>
                    <p class="text-muted">
                        Misi kami adalah memberdayakan jutaan UMKM di Indonesia dengan solusi digital yang terjangkau dan efektif.
                    </p>
                    </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-light" id="harga">
        <div class="container px-4 px-lg-5">
            <div class="text-center">
                <h2 class="section-heading">Gunakan BizGrow Sekarang, GRATIS!</h2>
                <hr class="divider" />
                <p class="text-muted mb-4">
                    BizGrow berkomitmen untuk mendukung pertumbuhan UMKM. Nikmati semua fitur unggulan kami tanpa biaya berlangganan.
                </p>
                <a class="btn btn-primary btn-xl" href="{{ route('register') }}">Daftar dan Mulai Sekarang!</a>
            </div>
        </div>
    </section>
    <section class="page-section" id="faq">
        <div class="container px-4 px-lg-5">
            <div class="text-center">
                <h2 class="section-heading">Pertanyaan Umum (FAQ)</h2>
                <hr class="divider divider-dark" />
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOneFaq">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneFaq" aria-expanded="true" aria-controls="collapseOneFaq">
                                    Apakah data saya aman di BizGrow?
                                </button>
                            </h2>
                            <div id="collapseOneFaq" class="accordion-collapse collapse show" aria-labelledby="headingOneFaq" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Ya, keamanan data Anda adalah prioritas kami. BizGrow menggunakan enkripsi standar industri dan praktik keamanan terbaik untuk melindungi semua informasi bisnis Anda. Kami juga melakukan backup data secara rutin.
                                </div>
                            </div>
                        </div>
                        {{-- <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwoFaq">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoFaq" aria-expanded="false" aria-controls="collapseTwoFaq">
                                    Apakah aplikasi ini benar-benar gratis?
                                </button>
                            </h2>
                            <div id="collapseTwoFaq" class="accordion-collapse collapse" aria-labelledby="headingTwoFaq" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Saat ini, BizGrow menyediakan semua fiturnya secara gratis untuk membantu UMKM. Kami mungkin akan memperkenalkan paket premium dengan fitur tambahan di masa mendatang, namun pengguna yang sudah terdaftar akan selalu memiliki akses ke fitur dasar yang ada.
                                </div>
                            </div>
                        </div> --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThreeFaq">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeFaq" aria-expanded="false" aria-controls="collapseThreeFaq">
                                    Bagaimana cara memulai menggunakan BizGrow?
                                </button>
                            </h2>
                            <div id="collapseThreeFaq" class="accordion-collapse collapse" aria-labelledby="headingThreeFaq" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    Sangat mudah! Cukup klik tombol "Daftar Gratis", isi formulir pendaftaran singkat, dan Anda bisa langsung mulai mengelola bisnis Anda. Tidak ada instalasi yang rumit.
                                </div>
                            </div>
                        </div>
                         <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFourFaq">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourFaq" aria-expanded="false" aria-controls="collapseFourFaq">
                                    UMKM jenis apa saja yang cocok menggunakan BizGrow?
                                </button>
                            </h2>
                            <div id="collapseFourFaq" class="accordion-collapse collapse" aria-labelledby="headingFourFaq" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted">
                                    BizGrow dirancang fleksibel untuk berbagai jenis UMKM, mulai dari toko kelontong, warung makan, pedagang online, hingga produsen skala kecil yang membutuhkan manajemen stok, penjualan, dan prediksi.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section bg-dark text-white" id="final-cta">
        <div class="container px-4 px-lg-5 text-center">
            <h2 class="mb-4">Siap Mengembangkan Bisnis Anda ke Level Berikutnya?</h2>
            <p class="text-white-75 mb-4">Jangan tunda lagi kesuksesan bisnis Anda. Bergabunglah dengan ribuan UMKM lainnya yang telah merasakan manfaat BizGrow.</p>
            <a class="btn btn-light btn-xl" href="{{ route('register') }}">Daftar Gratis Sekarang!</a>
        </div>
    </section>

    <section class="page-section" id="kontak">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="mt-0 section-heading">Hubungi Kami</h2>
                    <hr class="divider divider-dark" />
                    <p class="text-muted mb-5">Punya pertanyaan atau butuh bantuan? Tim kami siap membantu Anda!</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="bi-envelope fs-3 mb-3 text-muted"></i>
                        <a class="d-block" href="mailto:bizgrow@gmail.com">bizgrow@gmail.com</a>
                    </div>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-auto text-center">
                    <p class="text-muted small">Atau ikuti kami di media sosial:</p>
                    <a href="https://www.facebook.com" class="btn btn-outline-dark btn-social mx-1"><i class="bi-facebook"></i></a>
                    <a href="https://www.instagram.com" class="btn btn-outline-dark btn-social mx-1"><i class="bi-instagram"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection
