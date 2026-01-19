@extends('layouts.appadmin')

@section('title', 'Tambah Pengguna')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
	<li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
@endsection

@section('content')
	<div class="card shadow-sm border-0 mb-4 p-3">
		<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
			<h5 class="mb-0 fw-semibold fs-4">Tambah Pengguna</h5>

			<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
				<i class="bi bi-arrow-left"></i> Batal
			</a>
		</div>

		<div class="card-body">
			<form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">

				{{-- PERAN & STATUS --}}
				<div class="row">
					{{-- PERAN (kiri) --}}
					<div class="col-md-6 mb-3">
						<label for="role" class="form-label">Peran <span class="text-danger">*</span></label>
						<x-select-input id="role" name="role" label="Peran" :options="[
						    'guru' => 'Guru',
						    'staff-gereja' => 'Pengurus Gereja',
						    'admin' => 'Admin',
						]" :selected="old('role')" :searchable="false"
							required />
					</div>

					{{-- STATUS (kanan) --}}
					<div class="col-md-6 mb-3">
						<label for="status" class="form-label">Status <span class="text-danger">*</span></label>
						<x-select-input id="status" name="status" label="Status" :options="[
						    'aktif' => 'Aktif',
						    'nonaktif' => 'Nonaktif',
						]" :selected="old('status')" :searchable="false"
							required />
					</div>
				</div>

				{{-- NAMA --}}
				<div class="mb-3">
					<label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
					<input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap"
						value="{{ old('name') }}">
					@error('name')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- EMAIL --}}
				<div class="mb-3">
					<label for="email" class="form-label">Email <span class="text-danger">*</span></label>
					<input type="email" name="email" class="form-control" required placeholder="Masukkan email"
						value="{{ old('email') }}">
					@error('email')
						<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>

				{{-- NOMOR TELEPON --}}
				<div class="mb-3">
					<label for="nomor_telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
					<input type="text" name="nomor_telepon" class="form-control" required placeholder="Masukkan nomor telepon"
						value="{{ old('nomor_telepon') }}">
					@error('nomor_telepon')
						<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>

				{{-- PASSWORD --}}
				<div class="mb-3">
					<label for="password" class="form-label">Password <span class="text-danger">*</span></label>
					<div class="input-group">
						<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
							required placeholder="Masukkan password minimal 8 karakter dengan huruf besar, huruf kecil, dan angka">
						<button type="button" class="btn password-toggle-btn" id="togglePassword">
							<i class="bi bi-eye-slash"></i>
						</button>
					</div>
					@error('password')
						<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>

				{{-- KONFIRMASI PASSWORD --}}
				<div class="mb-3">
					<label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
					<div class="input-group">
						<input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
							id="password_confirmation" name="password_confirmation" required placeholder="Masukkan ulang password">
						<button type="button" class="btn password-toggle-btn" id="togglePasswordConfirm">
							<i class="bi bi-eye-slash"></i>
						</button>
					</div>
					@error('password_confirmation')
						<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>

				{{-- FOTO PROFIL --}}
				<div class="mb-3">
					<label for="profile_photo_path" class="form-label">Foto Profil <span class="text-muted">(Opsional)</span></label>

					{{-- Preview gambar di atas input --}}
					<div class="text-center mb-3" id="photo-preview-container" style="display:none;">
						<img id="photo-preview" src="#" alt="Preview Foto Profil" class="img-thumbnail rounded"
							style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
					</div>
					<input type="file" class="form-control @error('profile_photo_path') is-invalid @enderror"
						id="profile_photo_path" name="profile_photo_path" accept="image/*">
					<small class="text-muted">Format: jpg, png, jpeg. Maksimal: 2MB. Ukuran pas foto: 3x4.</small>

					@error('profile_photo_path')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- Bagian untuk GURU --}}
				<div id="form-guru" style="display:none;">
					<hr>
					<h5>Data Guru</h5>
					{{-- NIK --}}
					<div class="mb-3">
						<label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
						<input type="text" name="nik" class="form-control" placeholder="Masukkan NIK"
							value="{{ old('nik') }}" required>
						@error('nik')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					{{-- TEMPAT LAHIR --}}
					<div class="mb-3">
						<label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
						<input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir"
							value="{{ old('tempat_lahir') }}" required>
						@error('tempat_lahir')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					{{-- TANGGAL LAHIR --}}
					<div class="mb-3">
						<label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
						<input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}"
							placeholder="Masukkan Tanggal Lahir" required>
						@error('tanggal_lahir')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					{{-- ASAL SEKOLAH INDUK --}}
					<div class="mb-3">
						<label for="sekolah_id" class="form-label">Asal Sekolah Induk <span class="text-danger">*</span></label>
						<div id="sekolah-wrapper">
							<div class="mb-2 sekolah-group d-flex gap-1 align-items-center">
								<x-select-input id="sekolah" name="sekolah_id[]" label="Sekolah" :options="$sekolahs" :selected="old('sekolah_id.0')"
									dropdownClass="flex-fill" required />
								@error('sekolah_id')
									<div class="invalid-feedback d-block">{{ $message }}</div>
								@enderror
								<button type="button" class="btn btn-danger remove-sekolah" disabled>
									&times;
								</button>
							</div>
						</div>

						<button type="button" id="add-sekolah" class="btn btn-outline-secondary mt-2 rounded-box px-3 py-1.5">
							<i class="bi bi-plus-lg"></i> Tambah Sekolah
						</button>
					</div>
				</div>

				{{-- Bagian untuk STAFF GEREJA --}}
				<div id="form-gereja" style="display:none;">
					<hr>
					<h5>Data Pengurus Gereja</h5>
					{{-- GEREJA --}}
					<div class="mb-3">
						<label for="gereja_id" class="form-label">Gereja <span class="text-danger">*</span></label>
						<x-select-input id="gereja" name="gereja_id" label="Gereja" :options="$gerejas" :selected="old('gereja_id')" required />
						@error('gereja_id')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

				<div class="d-flex justify-content-end mt-4">
					<button type="submit" class="btn btn-primary">
						<i class="bi bi-save me-1"></i> Simpan
					</button>
				</div>
			</form>

			{{-- STYLE --}}
			<style>
				/* ======== STYLE PASSWORD TOGGLE BUTTON ======== */
				.password-toggle-btn {
					border-color: #ced4da !important;
					background-color: #f8f9fa !important;
				}

				.password-toggle-btn:hover {
					background-color: #e9ecef !important;
					border-color: #c5cbd2 !important;
				}
			</style>

			{{-- SCRIPT --}}
			<script>
				// ---------------- helper: inisialisasi satu select berdasarkan id (hidden input id) ----------------
				function initSelectInput(id) {
					const hidden = document.getElementById(id);
					const btn = document.getElementById('btn-' + id);
					const listRoot = document.getElementById('list-' + id);
					const search = document.getElementById('search-' + id);

					if (!hidden || !btn || !listRoot) return;

					// 1) Pasang klik pada tiap item (overwrite yg lama)
					listRoot.querySelectorAll('.dropdown-item').forEach(item => {
						item.onclick = function(e) {
							const val = String(this.dataset.value ?? '');
							hidden.value = val;
							btn.textContent = this.textContent.trim();

							// triggere event agar semua listener lain tanggap (change & input)
							hidden.dispatchEvent(new Event('input', {
								bubbles: true
							}));
							hidden.dispatchEvent(new Event('change', {
								bubbles: true
							}));
						};

						// pastikan setiap item tampil (reset hasil filter)
						item.style.display = '';
					});

					// 2) Pasang search handler (tidak menggandakan karena assignment)
					if (search) {
						search.oninput = function() {
							const keyword = this.value.toLowerCase();

							const allSelected = Array.from(document.querySelectorAll(
									'input[type="hidden"][name="sekolah_id[]"]'))
								.map(i => i.value)
								.filter(v => v !== '');

							const currentValue = hidden.value;

							listRoot.querySelectorAll('.dropdown-item').forEach(item => {
								const val = item.dataset.value;

								// Pertama filter berdasarkan teks
								const match = item.textContent.toLowerCase().includes(keyword);

								// Jika opsi sudah dipakai di input lain (bukan current), tetap sembunyikan
								if (allSelected.includes(val) && val !== currentValue) {
									item.style.display = 'none';
								} else {
									item.style.display = match ? '' : 'none';
								}
							});
						};
					}

					// 3) Pasang onchange/oninput pada hidden input untuk update global
					//    gunakan property assignment supaya tidak ada duplicate listener
					hidden.oninput = updateSekolahOptions;
					hidden.onchange = updateSekolahOptions;
				}

				// ---------------- update global: sembunyikan opsi yang telah dipilih di tempat lain ----------------
				function updateSekolahOptions() {
					// kumpulkan semua selected (non-empty)
					const selected = Array.from(document.querySelectorAll('input[type="hidden"][name="sekolah_id[]"]'))
						.map(i => String(i.value || ''))
						.filter(v => v !== '');

					// untuk setiap group, sembunyikan opsi yang digunakan di group lain
					document.querySelectorAll('.sekolah-group').forEach(group => {
						const hidden = group.querySelector('input[type="hidden"][name="sekolah_id[]"]');
						const current = hidden ? String(hidden.value || '') : '';

						group.querySelectorAll('.dropdown-item').forEach(item => {
							const val = String(item.dataset.value ?? '');
							if (val !== '' && selected.includes(val) && val !== current) {
								item.style.display = 'none';
							} else {
								item.style.display = '';
							}
						});
					});
				}

				// ---------------- cloning sekolah group ----------------
				function cloneSekolahGroup() {
					const wrapper = document.getElementById('sekolah-wrapper');
					const groups = wrapper.querySelectorAll('.sekolah-group');
					const base = groups[0];
					const idx = groups.length; // new index

					const clone = base.cloneNode(true);

					// cari old hidden id dari base
					const oldHidden = base.querySelector('input[type="hidden"][name="sekolah_id[]"]');
					if (!oldHidden) return;
					const oldId = oldHidden.id;
					const newId = oldId + '_' + idx;

					// ganti semua kemunculan id lama di innerHTML clone jadi id baru
					clone.innerHTML = clone.innerHTML
						.replaceAll(`btn-${oldId}`, `btn-${newId}`)
						.replaceAll(`dropdown-${oldId}`, `dropdown-${newId}`)
						.replaceAll(`search-${oldId}`, `search-${newId}`)
						.replaceAll(`list-${oldId}`, `list-${newId}`)
						.replaceAll(`id="${oldId}"`, `id="${newId}"`);

					// append ke DOM
					wrapper.appendChild(clone);

					// reset any filter state (tampilkan semua item)
					clone.querySelectorAll('.dropdown-item').forEach(i => i.style.display = '');

					// reset hidden value and button text
					const hiddenNew = clone.querySelector(`#${newId}`);
					if (hiddenNew) hiddenNew.value = '';

					const btnNew = clone.querySelector(`#btn-${newId}`);
					if (btnNew) {
						const placeholder = btnNew.getAttribute('data-placeholder') || 'Pilih Sekolah';
						btnNew.textContent = placeholder;
					}

					// aktifkan tombol remove pada clone
					const removeBtn = clone.querySelector('.remove-sekolah');
					if (removeBtn) removeBtn.disabled = false;

					// init events for the new select
					initSelectInput(newId);

					// after clone, ensure global sync
					updateSekolahOptions();
				}

				// ======== Inisialisasi saat DOM siap ==========
				document.addEventListener('DOMContentLoaded', function() {
					// init existing selects
					document.querySelectorAll('input[type="hidden"][name="sekolah_id[]"]').forEach(h => {
						if (h.id) initSelectInput(h.id);
					});

					// bind add button
					const addBtn = document.getElementById('add-sekolah');
					if (addBtn) addBtn.addEventListener('click', cloneSekolahGroup);

					// delegated remove button (works for clones too)
					document.addEventListener('click', function(e) {
						if (e.target.classList.contains('remove-sekolah')) {
							const groups = document.querySelectorAll('.sekolah-group');
							if (groups.length > 1) {
								e.target.closest('.sekolah-group').remove();

								// after removal, re-sync global options
								updateSekolahOptions();
							}
						}
					});

					// initial sync once
					updateSekolahOptions();
				});

				// ======== TAMPILKAN / SEMBUNYIKAN FORM BERDASARKAN ROLE ========
				const role = document.getElementById('role');
				const guruForm = document.getElementById('form-guru');
				const gerejaForm = document.getElementById('form-gereja');

				// Saat user mengubah pilihan
				role.addEventListener('change', function() {
					const isGuru = this.value === 'guru';
					guruForm.style.display = isGuru ? 'block' : 'none';
					gerejaForm.style.display = (this.value === 'staff-gereja') ? 'block' : 'none';

					// toggle required/disabled on sekolah selects to avoid browser validation errors
					const selects = document.querySelectorAll('select[name="sekolah_id[]"]');
					selects.forEach(s => {
						if (isGuru) {
							s.removeAttribute('disabled');
							s.setAttribute('required', 'required');
						} else {
							s.removeAttribute('required');
							s.setAttribute('disabled', 'disabled');
						}
					});
				});

				// ======== Auto-show berdasarkan old('role') ==========
				document.addEventListener("DOMContentLoaded", function() {
					const selectedRole = "{{ old('role') }}"; // Blade inject

					if (selectedRole === 'guru') {
						guruForm.style.display = 'block';
					}

					if (selectedRole === 'staff-gereja') {
						gerejaForm.style.display = 'block';
					}
					updateSekolahOptions();
				});

				// ======== Preview Foto Profil ==========
				const photoInput = document.getElementById('profile_photo_path');
				const previewContainer = document.getElementById('photo-preview-container');
				const previewImage = document.getElementById('photo-preview');

				photoInput.addEventListener('change', function(event) {
					const file = event.target.files[0];
					if (file) {
						const reader = new FileReader();
						reader.onload = function(e) {
							previewImage.src = e.target.result;
							previewContainer.style.display = 'block';
						};
						reader.readAsDataURL(file);
					} else {
						previewContainer.style.display = 'none';
					}
				});

				// ======== Show / Hide Password ==========
				const passwordInput = document.getElementById("password");
				const togglePassword = document.getElementById("togglePassword");

				togglePassword.addEventListener("click", function() {
					const type = passwordInput.type === "password" ? "text" : "password";
					passwordInput.type = type;

					this.querySelector("i").classList.toggle("bi-eye");
					this.querySelector("i").classList.toggle("bi-eye-slash");
				});

				// ======== Show / Hide Password Confirmation ==========
				const passwordConfirmInput = document.getElementById("password_confirmation");
				const togglePasswordConfirm = document.getElementById("togglePasswordConfirm");

				togglePasswordConfirm.addEventListener("click", function() {
					const type = passwordConfirmInput.type === "password" ? "text" : "password";
					passwordConfirmInput.type = type;

					this.querySelector("i").classList.toggle("bi-eye");
					this.querySelector("i").classList.toggle("bi-eye-slash");
				});
			</script>

		</div>
	</div>
@endsection
