<style>
    .footer-section {
        /* background: #fffff; */
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
        color: #1E3A8A;
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
<footer class="footer-section bg-white pt-5 pb-2 shadow">
    <div class="container">

        <div class="row justify-content-between align-items-start">

            <!-- About -->
            <div class="col-lg-4 col-md-12 mb-4">
                <a href="" class="text-decoration-none fs-4 text-app-primary fw-bold">
                    <img src="{{ asset('assets/img/logo/Logo Simpul.svg') }}" height="64" alt="kemenag" class="mb-2">
                    SIMPUL
                </a>

                <div class="mt-4">

                    <!-- Alamat -->
                    <div class="footer-info-item">
                        <div class="footer-icon">
                            <i class="bi bi-geo-alt-fill text-app-secondary"></i>
                        </div>
                        <div class="footer-info-text">
                            Jl. Tunjungan 14
                            <br>Surabaya, Jawa Timur
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="footer-info-item">
                        <div class="footer-icon">
                            <i class="bi bi-telephone-fill text-app-secondary"></i>
                        </div>
                        <div class="footer-info-text">
                            0853-3558-9526
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="footer-info-item">
                        <div class="footer-icon">
                            <i class="bi bi-envelope-fill text-app-secondary"></i>
                        </div>
                        <div class="footer-info-text">
                            simpul@gmail.com
                        </div>
                    </div>

                </div>
            </div>

            <!-- Quick Link -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="footer-title">Tautan Cepat</h5>
                <ul class="footer-links">
                    <li><a href="/home">Home</a></li>
                    <li><a href="/berita">Kursus</a></li>
                    <li><a href="/">Lowongan Karir</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="footer-title">Program Unggulan</h5>
                <ul class="footer-links">
                    <li><a href="#">Kelas Guru</a></li>
                    <li><a href="#">Kelas Administrasi</a></li>
                    <li><a href="#">Pelatihan Digital</a></li>
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
            &copy; 2026 <strong>SIMPUL</strong> - Sistem Informasi Manajemen Pembelajaran Unggul Lokal
            <br>Seluruh hak cipta dilindungi.
        </p>

    </div>
</footer>
