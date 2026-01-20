@extends('layouts.admin')

@section('title', 'Detail Kategori')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Data Kategori</a></li>
	<li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Detail Kategori</h5>
				<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
					<i class="bi bi-arrow-left"></i> Kembali
				</a>
			</div>
			<div class="card-body">
				<div class="row mb-2">
					<div class="mb-3">
						<label class="form-label text-start d-block">Nama</label>
						<input type="text" class="form-control" value="{{ $category->name }}" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label text-start d-block">Slug</label>
						<input type="text" class="form-control" value="{{ $category->slug }}" readonly>
					</div>
					<div class="mb-3">
						<label class="form-label text-start d-block">Deskripsi</label>
						<textarea class="form-control" rows="3" readonly>{{ filled($category->description) ? $category->description : '-' }}</textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
