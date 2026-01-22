@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Data Kategori</a></li>
	<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Ubah Kategori</h5>
				<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary border">
					Batal
				</a>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.categories.update', $category) }}" method="POST">
					@csrf
					@method('PUT')
					<div class="mb-3">
						<label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
						<input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
							value="{{ old('name', $category->name) }}" required maxlength="100" placeholder="Masukkan nama kategori">
						@error('name')
							<div class="text-danger mt-1 small">{{ ucfirst($message) }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label for="description" class="form-label">Deskripsi</label>
						<textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
						 maxlength="255" rows="3" placeholder="Masukkan deskripsi (opsional)">{{ old('description', $category->description) }}</textarea>
						@error('description')
							<div class="text-danger mt-1 small">{{ ucfirst($message) }}</div>
						@enderror
					</div>
					<div class="d-flex justify-content-end mt-4">
						<button type="submit" class="btn btn-app-primary" id="submitCategoryBtn">
							<span class="button-content">
								Simpan
							</span>
							<span class="spinner-content d-none">
								<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
								Sedang Menyimpan...
							</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		const categoryForm = document.querySelector('form[action="{{ route('admin.categories.update', $category) }}"]');
		const submitCategoryBtn = document.getElementById('submitCategoryBtn');
		if (categoryForm && submitCategoryBtn) {
			categoryForm.addEventListener('submit', function() {
				submitCategoryBtn.disabled = true;
				submitCategoryBtn.querySelector('.button-content').classList.add('d-none');
				submitCategoryBtn.querySelector('.spinner-content').classList.remove('d-none');
			});
		}
	</script>
@endpush
