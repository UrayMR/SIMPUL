@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
	<li class="breadcrumb-item active" aria-current="page">Detail Data Pengguna</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Detail Data Pengguna</h5>

				<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left"></i> Kembali
				</a>
			</div>

			<div class="card-body">
				<div class="row mb-2">
					{{-- FOTO KIRI --}}
					<div class="col-md-3 text-center mb-3">

						@php
							$name = $user->name ?? 'User';
							$defaultAvatar =
							    'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&color=000&size=300';
							$photoPath = null;
							if ($user->role === 'teacher' && $user->teacher && $user->teacher->profile_picture_path) {
							    $fullPath = public_path('storage/' . $user->teacher->profile_picture_path);
							    if (file_exists($fullPath)) {
							        $photoPath = asset('storage/' . $user->teacher->profile_picture_path);
							    }
							}
						@endphp

						@if ($photoPath)
							<img src="{{ $photoPath }}" class="img-thumbnail rounded shadow-sm"
								style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
						@else
							<img src="{{ $defaultAvatar }}" class="img-thumbnail rounded shadow-sm"
								style="width: 180px; height: 240px; object-fit: cover; border: 2px solid #dee2e6;">
						@endif
					</div>

					{{-- FORM KANAN (LABEL TETAP RATA KIRI) --}}
					<div class="col-md-9">
						{{-- PERAN & STATUS --}}
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label text-start d-block">Peran</label>
								<select class="form-select" disabled>
									<option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Teacher</option>
									<option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
									<option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
								</select>
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label text-start d-block">Status</label>
								<select class="form-select" disabled>
									<option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Aktif</option>
									<option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
									<option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
									<option value="rejected" {{ $user->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
								</select>
							</div>
						</div>

						{{-- NAMA --}}
						<div class="mb-3">
							<label class="form-label text-start d-block">Nama</label>
							<input type="text" class="form-control" value="{{ $user->name }}" readonly>
						</div>
						<div class="mb-3">
							<label class="form-label text-start d-block">Email</label>
							<input type="email" class="form-control" value="{{ $user->email }}" readonly>
						</div>
						<div class="mb-3">
							<label class="form-label text-start d-block">Nomor Telepon</label>
							<input type="text" class="form-control" value="{{ $user->phone_number ?? '-' }}" readonly>
						</div>
					</div>
				</div>

				{{-- DATA TEACHER --}}
				@if ($user->role === 'teacher' && $user->teacher)
					<hr>
					<div class="mb-3">
						<label class="form-label">Bio</label>
						<textarea class="form-control" rows="3" readonly>{{ $user->teacher->bio ?? '-' }}</textarea>
					</div>
					<div class="mb-3">
						<label class="form-label">Keahlian</label>
						<input type="text" class="form-control" value="{{ $user->teacher->expertise ?? '-' }}" readonly>
					</div>
				@endif

				<hr class="my-4">

				<div class="mb-3">
					<label class="form-label">Dibuat Pada</label>
					<input type="text" class="form-control" value="{{ $user->created_at->translatedFormat('d F Y, H:i') }}"
						readonly>
				</div>
				<div class="mb-3">
					<label class="form-label">Diperbarui Pada</label>
					<input type="text" class="form-control" value="{{ $user->updated_at->translatedFormat('d F Y, H:i') }}"
						readonly>
				</div>
			</div>
		</div>
	</div>
@endsection
