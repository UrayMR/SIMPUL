@extends('layouts.app')

@section('title', 'Pendataan Gereja')

@section('content')
    <!-- Toast Notification -->
    <x-toast />

    <!-- Breadcrumb -->
    <div class="container-fluid pt-3 text-dark border-bottom">
        <div class="container pb-3">
            <a href="/home" class="text-dark text-decoration-none">Home</a>
            <span class="mx-2">></span>
            <a href="#" class="text-dark text-decoration-none">Layanan</a>
            <span class="mx-2">></span>
            <span class="text-dark">Pendataan Gereja</span>
        </div>
    </div>

    <!-- Header -->
    <div class="container-fluid py-4 bg-primary text-light">
        <div class="container">
            <h1 class="fw-bold mb-0">Pendataan Gereja</h1>
            <p class="mb-0">Kelola data gereja Anda</p>
        </div>
    </div>

    <div class="container my-5">
        <div class="card shadow-sm border-0 mb-4 p-3">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold fs-4">Data Gereja</h5>
                <div>
                    <button type="button" id="btnEdit" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i> Ubah
                    </button>
                    <button type="button" id="btnCancel" class="btn btn-secondary" style="display: none;">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                </div>
            </div>

            <div class="card-body">
                @if ($gereja)
                    <form id="formGereja" action="{{ route('user.gereja.update', $gereja->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama Gereja --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Gereja</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $gereja->nama) }}" placeholder="Masukkan nama gereja">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Berdiri --}}
                        <div class="mb-3">
                            <label class="form-label">Tanggal Berdiri</label>
                            <input type="date" name="tanggal_berdiri"
                                class="form-control @error('tanggal_berdiri') is-invalid @enderror"
                                value="{{ old('tanggal_berdiri', optional($gereja->tanggal_berdiri)->format('Y-m-d')) }}">
                            @error('tanggal_berdiri')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Bergabung Sinode --}}
                        <div class="mb-3">
                            <label class="form-label">Tanggal Bergabung Sinode</label>
                            <input type="date" name="tanggal_bergabung_sinode"
                                class="form-control @error('tanggal_bergabung_sinode') is-invalid @enderror"
                                value="{{ old('tanggal_bergabung_sinode', optional($gereja->tanggal_bergabung_sinode)->format('Y-m-d')) }}">
                            @error('tanggal_bergabung_sinode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                value="{{ old('alamat', $gereja->alamat) }}" placeholder="Masukkan alamat lengkap">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Lokasi --}}
                        <div class="row">
                            {{-- Kota --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kabupaten/Kota</label>
                                <x-select-input id="kab_kota" label="Kabupaten/Kota" name="kab_kota" :options="['Surabaya' => 'Surabaya']"
                                    placeholder="Pilih Kota" :selected="old('kab_kota', $gereja->kab_kota)" />
                                @error('kab_kota')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kecamatan --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <x-select-input id="kecamatan" label="Kecamatan" name="kecamatan" :options="[]"
                                    placeholder="Pilih Kecamatan" :selected="old('kecamatan', $gereja->kecamatan)" />
                                @error('kecamatan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kelurahan --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kelurahan / Desa</label>
                                <x-select-input id="kel_desa" label="Kelurahan / Desa" name="kel_desa" :options="[]"
                                    placeholder="Pilih Kelurahan" :selected="old('kel_desa', $gereja->kel_desa)" />
                                @error('kel_desa')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Jarak Gereja Lain --}}
                        <div class="mb-3">
                            <label class="form-label">Jarak Gereja Lain</label>
                            <input type="text" name="jarak_gereja_lain"
                                class="form-control @error('jarak_gereja_lain') is-invalid @enderror"
                                value="{{ old('jarak_gereja_lain', $gereja->jarak_gereja_lain) }}"
                                placeholder="Contoh: 2 km dari GKP terdekat">
                            @error('jarak_gereja_lain')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kontak --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $gereja->email) }}" placeholder="Masukkan email gereja">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" name="nomor_telepon"
                                    class="form-control @error('nomor_telepon') is-invalid @enderror"
                                    value="{{ old('nomor_telepon', $gereja->nomor_telepon) }}"
                                    placeholder="Masukkan nomor telepon" maxlength="20">
                                @error('nomor_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nama Pendeta atau Gembala Sidang --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Pendeta atau Gembala Sidang</label>
                            <div id="pendeta-wrapper">
                                @php
                                    $oldPendetas = old('nama_pendeta', $gereja->nama_pendeta ?? []);
                                    if (!is_array($oldPendetas)) {
                                        $oldPendetas = $oldPendetas ? [$oldPendetas] : [''];
                                    }
                                    if (empty($oldPendetas)) {
                                        $oldPendetas = [''];
                                    }
                                @endphp

                                @foreach ($oldPendetas as $idx => $nama)
                                    <div class="mb-2 pendeta-group d-flex gap-2 align-items-center">
                                        <input type="text" name="nama_pendeta[]"
                                            class="form-control @error('nama_pendeta.' . $idx) is-invalid @enderror"
                                            value="{{ $nama }}"
                                            placeholder="Masukkan nama pendeta atau gembala sidang">
                                        <button type="button" class="btn btn-danger remove-pendeta"
                                            {{ $idx === 0 ? 'disabled' : '' }}>
                                            &times;
                                        </button>
                                        @error('nama_pendeta.' . $idx)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <small id="pendeta-help-text" class="text-muted mb-2" style="display: none;">Untuk menambah
                                pendeta atau gembala sidang, silakan klik tombol <strong>"Tambah"</strong> di bawah</small>
                            <button type="button" id="add-pendeta" class="btn btn-outline-secondary rounded px-3 py-1">
                                <i class="bi bi-plus-lg"></i> Tambah
                            </button>

                            @error('nama_pendeta')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Gereja --}}
                        <div class="mb-3">
                            <label class="form-label">Status Gereja</label>
                            <x-select-input id="status_gereja" label="Status Gereja" name="status_gereja"
                                :options="[
                                    'permanen' => 'Permanen',
                                    'semi-permanen' => 'Semi Permanen',
                                    'tidak-permanen' => 'Tidak Permanen',
                                ]" placeholder="Pilih Status" :selected="old('status_gereja', $gereja->status_gereja)" :searchable="false" />
                            @error('status_gereja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Piagam Sekolah Minggu --}}
                        <div class="mb-3">
                            <label class="form-label">Piagam Sekolah Minggu (File)</label>

                            <input type="file" name="piagam_sekolah_minggu_path"
                                class="form-control @error('piagam_sekolah_minggu_path') is-invalid @enderror"
                                accept=".pdf">

                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                @if ($gereja->piagam_sekolah_minggu_path)
                                    <a href="{{ route('gdrive.preview', ['path' => $gereja->piagam_sekolah_minggu_path]) }}"
                                        target="_blank" class="text-primary text-decoration-underline">
                                        Lihat File Lama
                                    </a>

                                    <span class="text-muted">
                                        {{ basename($gereja->piagam_sekolah_minggu_path) }}
                                    </span>
                                @else
                                    <span class="text-muted">Belum ada file</span>
                                @endif
                            </div>

                            @error('piagam_sekolah_minggu_path')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- JSON Fields --}}
                        <h5 class="mt-4 fw-bold">Data Jemaat</h5>
                        <div class="row">
                            {{-- Jumlah Umat --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Umat</label>

                                <div class="input-group mb-1">
                                    <input type="number" name="jumlah_umat[laki_laki]" class="form-control"
                                        placeholder="Jumlah laki-laki"
                                        value="{{ old('jumlah_umat.laki_laki', $gereja->jumlah_umat['laki_laki'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Laki-laki
                                    </span>
                                </div>
                                @error('jumlah_umat.laki_laki')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="input-group">
                                    <input type="number" name="jumlah_umat[perempuan]" class="form-control"
                                        placeholder="Jumlah perempuan"
                                        value="{{ old('jumlah_umat.perempuan', $gereja->jumlah_umat['perempuan'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Perempuan
                                    </span>
                                </div>
                                @error('jumlah_umat.perempuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah Majelis (Pendeta) --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Majelis (Pendeta)</label>

                                <div class="input-group mb-1">
                                    <input type="number" name="jumlah_majelis_pendeta[laki_laki]" class="form-control"
                                        placeholder="Jumlah laki-laki"
                                        value="{{ old('jumlah_majelis_pendeta.laki_laki', $gereja->jumlah_majelis_pendeta['laki_laki'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Laki-laki
                                    </span>
                                </div>
                                @error('jumlah_majelis_pendeta.laki_laki')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="input-group">
                                    <input type="number" name="jumlah_majelis_pendeta[perempuan]" class="form-control"
                                        placeholder="Jumlah perempuan"
                                        value="{{ old('jumlah_majelis_pendeta.perempuan', $gereja->jumlah_majelis_pendeta['perempuan'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Perempuan
                                    </span>
                                </div>
                                @error('jumlah_majelis_pendeta.perempuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah Majelis (Penetua) --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Majelis (Penetua)</label>  
                                <div class="input-group mb-1">
                                    <input type="number" name="jumlah_majelis_penetua[laki_laki]" class="form-control"
                                        placeholder="Jumlah laki-laki"
                                        value="{{ old('jumlah_majelis_penetua.laki_laki', $gereja->jumlah_majelis_penetua['laki_laki'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Laki-laki
                                    </span>
                                </div>
                                @error('jumlah_majelis_penetua.laki_laki')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="input-group">
                                    <input type="number" name="jumlah_majelis_penetua[perempuan]" class="form-control"
                                        placeholder="Jumlah perempuan"
                                        value="{{ old('jumlah_majelis_penetua.perempuan', $gereja->jumlah_majelis_penetua['perempuan'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Perempuan
                                    </span>
                                </div>
                                @error('jumlah_majelis_penetua.perempuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah Majelis (Diaken) --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Majelis (Diaken)</label>
                                <div class="input-group mb-1">
                                    <input type="number" name="jumlah_majelis_diaken[laki_laki]" class="form-control"
                                        placeholder="Jumlah laki-laki"
                                        value="{{ old('jumlah_majelis_diaken.laki_laki', $gereja->jumlah_majelis_diaken['laki_laki'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Laki-laki
                                    </span>
                                </div>
                                @error('jumlah_majelis_diaken.laki_laki')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="input-group">
                                    <input type="number" name="jumlah_majelis_diaken[perempuan]" class="form-control"
                                        placeholder="Jumlah perempuan"
                                        value="{{ old('jumlah_majelis_diaken.perempuan', $gereja->jumlah_majelis_diaken['perempuan'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Perempuan
                                    </span>
                                </div>
                                @error('jumlah_majelis_diaken.perempuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah Majelis (Tua-Tua Jamaat) --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Majelis (Tua-Tua Jamaat)</label>
                                <div class="input-group mb-1">
                                    <input type="number" name="jumlah_majelis_tua_jamaat[laki_laki]"
                                        class="form-control" placeholder="Jumlah laki-laki"
                                        value="{{ old('jumlah_majelis_tua_jamaat.laki_laki', $gereja->jumlah_majelis_tua_jamaat['laki_laki'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Laki-laki
                                    </span>
                                </div>
                                @error('jumlah_majelis_tua_jamaat.laki_laki')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="input-group">
                                    <input type="number" name="jumlah_majelis_tua_jamaat[perempuan]"
                                        class="form-control" placeholder="Jumlah perempuan"
                                        value="{{ old('jumlah_majelis_tua_jamaat.perempuan', $gereja->jumlah_majelis_tua_jamaat['perempuan'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Perempuan
                                    </span>
                                </div>
                                @error('jumlah_majelis_tua_jamaat.perempuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah Pemuda --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Pemuda</label>

                                <div class="input-group mb-1">
                                    <input type="number" name="jumlah_pemuda[laki_laki]" class="form-control"
                                        placeholder="Jumlah laki-laki"
                                        value="{{ old('jumlah_pemuda.laki_laki', $gereja->jumlah_pemuda['laki_laki'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Laki-laki
                                    </span>
                                </div>
                                @error('jumlah_pemuda.laki_laki')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="input-group">
                                    <input type="number" name="jumlah_pemuda[perempuan]" class="form-control"
                                        placeholder="Jumlah perempuan"
                                        value="{{ old('jumlah_pemuda.perempuan', $gereja->jumlah_pemuda['perempuan'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Perempuan
                                    </span>
                                </div>
                                @error('jumlah_pemuda.perempuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah Guru Sekolah Minggu --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Guru Sekolah Minggu</label>

                                <div class="input-group mb-1">
                                    <input type="number" name="jumlah_guru_sekolah_minggu[laki_laki]"
                                        class="form-control" placeholder="Jumlah laki-laki"
                                        value="{{ old('jumlah_guru_sekolah_minggu.laki_laki', $gereja->jumlah_guru_sekolah_minggu['laki_laki'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Laki-laki
                                    </span>
                                </div>
                                @error('jumlah_guru_sekolah_minggu.laki_laki')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="input-group">
                                    <input type="number" name="jumlah_guru_sekolah_minggu[perempuan]"
                                        class="form-control" placeholder="Jumlah perempuan"
                                        value="{{ old('jumlah_guru_sekolah_minggu.perempuan', $gereja->jumlah_guru_sekolah_minggu['perempuan'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Perempuan
                                    </span>
                                </div>
                                @error('jumlah_guru_sekolah_minggu.perempuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah Murid Sekolah Minggu --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Murid Sekolah Minggu</label>

                                <div class="input-group mb-1">
                                    <input type="number" name="jumlah_murid_sekolah_minggu[laki_laki]"
                                        class="form-control" placeholder="Jumlah laki-laki"
                                        value="{{ old('jumlah_murid_sekolah_minggu.laki_laki', $gereja->jumlah_murid_sekolah_minggu['laki_laki'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Laki-laki
                                    </span>
                                </div>
                                @error('jumlah_murid_sekolah_minggu.laki_laki')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="input-group">
                                    <input type="number" name="jumlah_murid_sekolah_minggu[perempuan]"
                                        class="form-control" placeholder="Jumlah perempuan"
                                        value="{{ old('jumlah_murid_sekolah_minggu.perempuan', $gereja->jumlah_murid_sekolah_minggu['perempuan'] ?? 0) }}"
                                        min="0">
                                    <span class="input-group-text d-flex align-items-center justify-content-center"
                                        style="width: 30%">
                                        Perempuan
                                    </span>
                                </div>
                                @error('jumlah_murid_sekolah_minggu.perempuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol --}}
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" id="btnSubmit" class="btn btn-primary" style="display: none;">
                                    <i class="bi bi-save me-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>

                    <script>
                        // Fungsi untuk toggle form state
                        function toggleFormState(enable) {
                            const form = document.getElementById('formGereja');
                            const btnEdit = document.getElementById('btnEdit');
                            const btnCancel = document.getElementById('btnCancel');
                            const btnSubmit = document.getElementById('btnSubmit');

                            // Toggle readonly untuk text/date/email/number inputs
                            form.querySelectorAll(
                                'input[type="text"], input[type="date"], input[type="email"], input[type="number"], textarea').forEach(
                                input => {
                                    input.readOnly = !enable;
                                });

                            // Toggle file input
                            form.querySelectorAll('input[type="file"]').forEach(input => {
                                input.disabled = !enable;
                            });

                            // Toggle dropdown buttons
                            const dropdownButtons = form.querySelectorAll('[id^="btn-"]');
                            dropdownButtons.forEach(btn => {
                                btn.disabled = !enable;
                                if (!enable) {
                                    btn.classList.add('disabled');
                                    btn.style.pointerEvents = 'none';
                                    btn.style.opacity = '0.65';
                                } else {
                                    btn.classList.remove('disabled');
                                    btn.style.pointerEvents = 'auto';
                                    btn.style.opacity = '1';
                                }
                            });

                            // Toggle pendeta buttons (add/remove)
                            const pendetaButtons = form.querySelectorAll('#add-pendeta, .remove-pendeta');
                            pendetaButtons.forEach(btn => {
                                btn.disabled = !enable;
                                btn.style.display = enable ? 'inline-block' : 'none';
                            });

                            // Toggle pendeta help text
                            const pendetaHelpText = document.getElementById('pendeta-help-text');
                            if (pendetaHelpText) {
                                pendetaHelpText.style.display = enable ? 'block' : 'none';
                            }

                            if (enable) {
                                btnEdit.style.display = 'none';
                                btnCancel.style.display = 'inline-block';
                                btnSubmit.style.display = 'inline-block';
                            } else {
                                btnEdit.style.display = 'inline-block';
                                btnCancel.style.display = 'none';
                                btnSubmit.style.display = 'none';
                            }
                        }

                        // Event listener untuk tombol Ubah
                        document.getElementById('btnEdit').addEventListener('click', function() {
                            toggleFormState(true);
                        });

                        // Event listener untuk tombol Batal
                        document.getElementById('btnCancel').addEventListener('click', function() {
                            if (confirm('Batalkan perubahan?')) {
                                location.reload();
                            }
                        });

                        // Disable form saat halaman pertama kali dibuka
                        document.addEventListener('DOMContentLoaded', function() {
                            toggleFormState(false);
                        });

                        // Langsung hide help text saat script load
                        const helpText = document.getElementById('pendeta-help-text');
                        if (helpText) helpText.style.display = 'none';

                        // Handle Dropdown Kota
                        document.addEventListener("DOMContentLoaded", function() {

                            document.querySelectorAll("#dropdown-kab_kota .dropdown-item").forEach(item => {
                                item.addEventListener("click", function() {
                                    const value = this.getAttribute("data-value");
                                    document.getElementById("kab_kota").value = value;
                                    document.getElementById("btn-kab_kota").textContent = value;

                                    // Reset kecamatan & kelurahan
                                    document.getElementById("btn-kecamatan").textContent = "Pilih Kecamatan";
                                    document.getElementById("kecamatan").value = "";
                                    document.getElementById("list-kecamatan").innerHTML =
                                        `<li><span class="dropdown-item-text">Loading...</span></li>`;

                                    document.getElementById("btn-kel_desa").textContent = "Pilih Kelurahan";
                                    document.getElementById("kel_desa").value = "";
                                    document.getElementById("list-kel_desa").innerHTML =
                                        `<li><span class="dropdown-item-text">Pilih kecamatan terlebih dahulu</span></li>`;

                                    // Fetch Kecamatan
                                    fetch(`/admin/get-kecamatan?kota=${value}`)
                                        .then(res => res.json())
                                        .then(data => {
                                            let list = "";
                                            data.forEach(kec => {
                                                list +=
                                                    `<li><a class="dropdown-item py-1" data-value="${kec}">${kec}</a></li>`;
                                            });
                                            document.getElementById("list-kecamatan").innerHTML = list;
                                            attachDropdownEventKecamatan();
                                        });
                                });
                            });

                            const selectedKota = "{{ old('kab_kota', $gereja->kab_kota) }}";
                            const selectedKecamatan = "{{ old('kecamatan', $gereja->kecamatan) }}";
                            const selectedKel = "{{ old('kel_desa', $gereja->kel_desa) }}";

                            if (selectedKota) {
                                // Tampilkan kota pada button
                                document.getElementById("btn-kab_kota").textContent = selectedKota;
                                document.getElementById("kab_kota").value = selectedKota;

                                // Load kecamatan dulu
                                fetch(`/admin/get-kecamatan?kota=${selectedKota}`)
                                    .then(res => res.json())
                                    .then(data => {
                                        let list = "";
                                        data.forEach(kec => {
                                            list +=
                                                `<li><a class="dropdown-item py-1" data-value="${kec}">${kec}</a></li>`;
                                        });
                                        document.getElementById("list-kecamatan").innerHTML = list;
                                        attachDropdownEventKecamatan();

                                        // Set kecamatan lama
                                        if (selectedKecamatan) {
                                            document.getElementById("btn-kecamatan").textContent = selectedKecamatan;
                                            document.getElementById("kecamatan").value = selectedKecamatan;
                                        }

                                        // Setelah kecamatan update → load kelurahan
                                        if (selectedKecamatan) {
                                            fetch(`/admin/get-kelurahan?kota=${selectedKota}&kecamatan=${selectedKecamatan}`)
                                                .then(res => res.json())
                                                .then(kels => {
                                                    let kelList = "";
                                                    kels.forEach(k => {
                                                        kelList +=
                                                            `<li><a class="dropdown-item py-1" data-value="${k}">${k}</a></li>`;
                                                    });
                                                    document.getElementById("list-kel_desa").innerHTML = kelList;
                                                    attachDropdownEventKelurahan();

                                                    // Set kelurahan lama
                                                    if (selectedKel) {
                                                        document.getElementById("btn-kel_desa").textContent = selectedKel;
                                                        document.getElementById("kel_desa").value = selectedKel;
                                                    }
                                                });
                                        }
                                    });
                            }
                        });


                        // Handle Dropdown Kecamatan
                        function attachDropdownEventKecamatan() {
                            document.querySelectorAll("#dropdown-kecamatan .dropdown-item").forEach(item => {
                                item.addEventListener("click", function() {
                                    const value = this.getAttribute("data-value");
                                    document.getElementById("kecamatan").value = value;
                                    document.getElementById("btn-kecamatan").textContent = value;

                                    // Reset kelurahan
                                    document.getElementById("btn-kel_desa").textContent = "Pilih Kelurahan";
                                    document.getElementById("kel_desa").value = "";
                                    document.getElementById("list-kel_desa").innerHTML =
                                        `<li><span class="dropdown-item-text">Loading...</span></li>`;

                                    let kota = document.getElementById("kab_kota").value;

                                    fetch(`/admin/get-kelurahan?kota=${kota}&kecamatan=${value}`)
                                        .then(res => res.json())
                                        .then(data => {
                                            let list = "";
                                            data.forEach(kel => {
                                                list +=
                                                    `<li><a class="dropdown-item py-1" data-value="${kel}">${kel}</a></li>`;
                                            });
                                            document.getElementById("list-kel_desa").innerHTML = list;
                                            attachDropdownEventKelurahan();
                                        });
                                });
                            });
                        }

                        // Handle Dropdown Kelurahan
                        function attachDropdownEventKelurahan() {
                            document.querySelectorAll("#dropdown-kel_desa .dropdown-item").forEach(item => {
                                item.addEventListener("click", function() {
                                    const value = this.getAttribute("data-value");
                                    document.getElementById("kel_desa").value = value;
                                    document.getElementById("btn-kel_desa").textContent = value;
                                });
                            });
                        }

                        // ============ Multiple Pendeta Input ============
                        function clonePendetaGroup() {
                            const wrapper = document.getElementById('pendeta-wrapper');
                            const base = wrapper.querySelector('.pendeta-group');
                            const clone = base.cloneNode(true);

                            // Reset input value
                            const input = clone.querySelector('input[name="nama_pendeta[]"]');
                            if (input) {
                                input.value = '';
                                input.classList.remove('is-invalid');
                            }

                            // Enable remove button
                            const removeBtn = clone.querySelector('.remove-pendeta');
                            if (removeBtn) removeBtn.disabled = false;

                            // Remove error message if exists
                            const errorDiv = clone.querySelector('.invalid-feedback');
                            if (errorDiv) errorDiv.remove();

                            wrapper.appendChild(clone);
                        }

                        // Bind add button
                        const addPendetaBtn = document.getElementById('add-pendeta');
                        if (addPendetaBtn) {
                            addPendetaBtn.addEventListener('click', clonePendetaGroup);
                        }

                        // Delegated remove button
                        document.addEventListener('click', function(e) {
                            if (e.target.classList.contains('remove-pendeta')) {
                                const groups = document.querySelectorAll('.pendeta-group');
                                if (groups.length > 1) {
                                    e.target.closest('.pendeta-group').remove();
                                }
                            }
                        });
                    </script>
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Anda belum terdaftar di gereja manapun. Silakan hubungi administrator.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
