<style>
    .footer-section {
        background: #f4f5f7;
        color: #4a4a4a;
        font-family: "Inter", sans-serif;
    }

    .footer-text {
        font-size: 16px;
        line-height: 1.6;
        color: #666;
        max-width: 330px;
    }

    /* ICON BULAT */
    .footer-info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .footer-icon {
        width: 42px;
        height: 42px;
        background: #e1eef7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .footer-icon i {
        font-size: 18px;
        color: #008080;
    }

    .footer-info-text {
        color: #444;
        font-size: 15px;
        line-height: 1.4;
        font-weight: 500;
    }

    /* JUDUL */
    .footer-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 18px;
        color: #3a3a3a;
    }

    /* LIST */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        text-decoration: none;
        color: #555;
        transition: 0.2s ease;
    }

    .footer-links a:hover {
        color: #008080;
    }

    /* GARIS PEMBATAS */
    .footer-divider {
        border-color: #ddd;
    }

    /* COPYRIGHT */
    .footer-bottom {
        color: #888;
        font-size: 14px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .footer-title {
            margin-top: 20px;
        }
    }
</style>

{{-- Footer --}}
<footer class="footer-section pt-5 pb-2">
    <div class="container">

        <div class="row justify-content-between align-items-start">

            <!-- About -->
            <div class="col-lg-4 col-md-12 mb-4">
                <a href="" class="text-decoration-none fs-4 text-primary fw-bold">
                    <img src="{{ asset('assets/img/logo.png') }}" height="64" alt="kemenag" class="mb-2">
                    SILAYANKRIS
                </a>

                <div class="mt-4">

                    <!-- Alamat -->
                    <div class="footer-info-item">
                        <div class="footer-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div class="footer-info-text">
                            Jl. Masjid Agung Timur No. 4
                            <br>Surabaya, Jawa Timur
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="footer-info-item">
                        <div class="footer-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div class="footer-info-text">
                            (031) 828-5319
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="footer-info-item">
                        <div class="footer-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div class="footer-info-text">
                            penyelenggarakristen.sby@kemenag.go.id
                        </div>
                    </div>

                </div>
            </div>

            <!-- Quick Link -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="footer-title">Tautan Cepat</h5>
                <ul class="footer-links">
                    <li><a href="/home">Home</a></li>
                    <li><a href="/berita">Berita</a></li>
                    <li><a href="/">Layanan</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="footer-title">Layanan</h5>
                <ul class="footer-links">
                    <li><a href="/login">Berkas TPG Guru</a></li>
                    <li><a href="/login">Pendataan Gereja</a></li>
                </ul>
            </div>

            <!-- Help -->
            <div class="col-lg-3 col-md-4 mb-4">
                <h5 class="footer-title">Bantuan & Dukungan</h5>
                <ul class="footer-links">
                    <li><a href="#" target="_blank">Hubungi Whatsapp</a></li>
                </ul>
            </div>

        </div>

        <hr class="footer-divider my-4">

        <p class="footer-bottom text-center">
            &copy; 2025 <strong>SILAYANKRIS</strong> - Kementerian Agama Kota Surabaya.
            <br>Seluruh hak cipta dilindungi.
        </p>

    </div>
</footer>
