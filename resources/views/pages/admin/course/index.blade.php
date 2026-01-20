@extends('layouts.admin')

@section('title', 'Manajemen Kursus')

@section('breadcrumb')
	<li class="breadcrumb-item active">Data Kursus</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 mb-2">
				<h5 class="card-title fw-semibold mb-4 fs-4">Daftar Data Kursus</h5>
				<div class="row g-2 align-items-center">
					<div class="col-12 col-md-6">
						<form method="GET" class="w-100 d-flex align-items-center gap-2">
							<div class="input-group ">
								<span class="input-group-text"><i class="bx bx-search"></i></span>
								<input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
									placeholder="Cari judul kursus...">
								<button class="btn btn-outline-secondary border btn-search-course" type="submit">
									<span class="button-content">Cari</span>
									<span class="spinner-content d-none">
										<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
										Mencari
									</span>
								</button>
							</div>
							<a href="{{ url()->current() }}"
								class="btn btn-secondary border d-flex align-items-center gap-1 {{ request('search') ? '' : 'd-none' }}">
								<i class="bi bi-arrow-counterclockwise"></i>
								<span>Reset</span>
							</a>
						</form>
					</div>
					<div class="col-12 col-md-auto ms-md-auto text-md-end">
						<a href="{{ route('admin.courses.create') }}" class="btn btn-primary w-100 w-md-auto">
							<i class="bi bi-plus-lg me-1"></i> Tambah Baru
						</a>
					</div>
				</div>
			</div>
			<div class="card-body ">
				<div class="table-responsive text-nowrap">
					<table class="table table-hover">
						<thead>
							<tr class="text-start">
								<th>#</th>
								<th>Judul</th>
								<th>Kategori</th>
								<th>Pengajar</th>
								<th>Harga</th>
								<th>Status</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($courses as $course)
								<tr>
									<td>{{ $courses->firstItem() + $loop->index }}</td>
									<td>{{ Str::limit($course->title, 50, '...') }}</td>
									<td>{{ $course->category->name ?? '-' }}</td>
									<td>{{ $course->teacher->user->name ?? '-' }}</td>
									<td>{{ $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : 'Gratis' }}</td>
									<td>
										@php
											$status = $course->status;
											$badgeClass = match ($status) {
											    'approved' => 'bg-success',
											    'pending' => 'bg-warning',
											    'rejected' => 'bg-danger',
											    default => 'bg-secondary',
											};
										@endphp
										<span class="badge w-100 {{ $badgeClass }}">{{ ucfirst($status) }}</span>
									</td>
									<td class="d-flex justify-content-center gap-2">
										<a href="{{ route('admin.courses.show', $course) }}" class="btn btn-sm btn-info"><i
												class="bx bx-info-circle"></i> Lihat</a>
										<a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-warning"><i
												class="bx bx-pencil"></i> Ubah</a>
										<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
											data-bs-target="#modalDeleteCourse{{ $course->id }}"><i class="bx bx-trash"></i> Hapus</button>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="7" class="text-center text-muted py-4">
										<i class="bi bi-folder-x fs-4 d-block mb-2"></i>
										Tidak ada data ditemukan.
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				@foreach ($courses as $course)
					<div class="modal fade" id="modalDeleteCourse{{ $course->id }}" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content rounded-4 shadow-lg border-0 p-2">
								<div class="modal-header border-0 pb-0">
									<div class="d-flex align-items-center gap-2 w-100">
										<i class="bi bi-exclamation-triangle-fill text-danger fs-3 me-2"></i>
										<div class="flex-grow-1">
											<h5 class="modal-title mb-0 fw-bold text-danger">Konfirmasi Hapus</h5>
											<small class="text-muted">Aksi ini tidak dapat dibatalkan</small>
										</div>
										<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
								</div>
								<div class="modal-body pt-3 pb-0 px-4">
									<p class="mb-3 fs-6">Apakah Anda yakin ingin menghapus
										<strong>{{ Str::limit($course->title, 15, '...') }}</strong>?
									</p>
								</div>
								<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
									<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
									<form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger px-4 btn-delete-course">
											<span class="button-content"><i class="bx bx-trash me-1"></i> Hapus</span>
											<span class="spinner-content d-none">
												<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
												Menghapus
											</span>
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
					<div class="small text-muted">
						Halaman <strong>{{ $currentPage }}</strong> dari <strong>{{ $lastPage }}</strong><br>
						Menampilkan <strong>{{ $perPage }}</strong> data per halaman (total <strong>{{ $total }}</strong>
						kursus)
					</div>
					<div>
						{{ $courses->links() }}
					</div>
				</div>
			</div>
		</div>

		<!-- Card: Accordion Course Pending/Rejected -->
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 mb-2">
				<button class="w-100 d-flex align-items-center justify-content-between border-0 bg-transparent p-0" type="button"
					data-bs-toggle="collapse" data-bs-target="#pendingAccordion" aria-expanded="false" aria-controls="pendingAccordion"
					id="pendingAccordionBtn" style="outline:none;">
					<h5 class="card-title fw-semibold mb-0 d-flex align-items-center gap-2">
						Daftar Data Pengajuan Kursus
						<span
							class="badge bg-warning text-dark d-flex align-items-center justify-content-center shadow-sm border border-warning-subtle"
							style="width:1.8rem; height:1.8rem; border-radius:50%; font-size:0.85rem; font-weight:600; letter-spacing:0.5px; padding:0;">
							{{ $pendingCount ?? 0 }}
						</span>
					</h5>
					<i class="bi bi-chevron-down ms-auto"></i>
				</button>
			</div>
			<div class="collapse" id="pendingAccordion">
				<div class="card-body" id="pendingAccordionBody">
					<div class="text-center text-muted py-4 d-none" id="pending-loading">
						<div class="spinner-border text-warning m-2" role="status"><span class="visually-hidden">Loading...</span>
						</div>
						<div> Memuat data...</div>
					</div>
					<div id="pending-table-container"></div>
				</div>
			</div>
		</div>
	</div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Spinner for delete course
			document.querySelectorAll('.modal form').forEach(function(form) {
				form.addEventListener('submit', function(e) {
					var btn = form.querySelector('.btn-delete-course');
					if (btn) {
						btn.disabled = true;
						btn.querySelector('.button-content').classList.add('d-none');
						btn.querySelector('.spinner-content').classList.remove('d-none');
					}
				});
			});

			// Spinner for search course
			document.querySelectorAll('form input[name="search"]').forEach(function(input) {
				var form = input.closest('form');
				if (form) {
					form.addEventListener('submit', function(e) {
						var btn = form.querySelector('.btn-search-course');
						if (btn) {
							btn.disabled = true;
							btn.querySelector('.button-content').classList.add('d-none');
							btn.querySelector('.spinner-content').classList.remove('d-none');
						}
					});
				}
			});

			let loaded = false;
			const pendingAccordion = document.getElementById('pendingAccordion');
			const pendingTableContainer = document.getElementById('pending-table-container');
			const pendingLoading = document.getElementById('pending-loading');

			function renderActions(course) {
				return `
			<a href="/admin/courses/${course.id}" class="btn btn-sm btn-info"><i class="bx bx-info-circle"></i> Lihat</a>
			<a href="/admin/courses/${course.id}/edit" class="btn btn-sm btn-warning"><i class="bx bx-pencil"></i> Ubah</a>
			<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDeleteCourse${course.id}"><i class="bx bx-trash"></i> Hapus</button>
		`;
			}

			function renderTable(courses, meta) {
				if (!courses.length) {
					return `
				<div class="table-responsive text-nowrap">
					<table class="table table-hover">
						<thead>
							<tr class="text-start">
								<th>#</th>
								<th>Judul</th>
								<th>Kategori</th>
								<th>Pengajar</th>
								<th>Status</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="6" class="text-center text-muted py-4">
									<i class="bi bi-folder-x fs-4 d-block mb-2"></i>
									Tidak ada data tersedia.
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			`;
				}
				return `
			<div class="table-responsive text-nowrap">
				<table class="table table-hover">
					<thead>
						<tr class="text-start">
							<th>#</th>
							<th>Judul</th>
							<th>Kategori</th>
							<th>Pengajar</th>
							<th>Status</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						${courses.map((course, idx) => {
							let badgeClass = course.status === 'pending' ? 'bg-warning text-dark' : (course.status === 'rejected' ? 'bg-danger' : 'bg-secondary');
							let number = meta && meta.from ? (meta.from + idx) : (idx + 1);
							return `
									<tr>
										<td>${number}</td>
										<td>${course.title}</td>
										<td>${course.category ? course.category.name : '-'}</td>
										<td>${course.teacher && course.teacher.user ? course.teacher.user.name : '-'}</td>
										<td><span class="badge w-100 ${badgeClass}">${course.status}</span></td>
										<td class="d-flex justify-content-center gap-2">${renderActions(course)}</td>
									</tr>
								`;
						}).join('')}
					</tbody>
				</table>
			</div>
		`;
			}

			function renderPagination(meta, links) {
				return `
			<div class='d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2'>
				<div class='small text-muted'>Halaman <strong>${meta.current_page}</strong> dari <strong>${meta.last_page}</strong><br>Menampilkan <strong>${meta.per_page}</strong> data per halaman (total <strong>${meta.total}</strong> kursus)</div>
				<div>${links}</div>
			</div>
		`;
			}

			function showLoading(show = true) {
				if (show) {
					pendingLoading.classList.remove('d-none');
				} else {
					pendingLoading.classList.add('d-none');
				}
			}

			function showError() {
				pendingTableContainer.innerHTML = `<div class='text-danger text-center'>Gagal memuat data.</div>`;
			}

			function loadPendingTable(url = '/admin/courses/pending-list') {
				showLoading(true);
				window.axios.get(url)
					.then(function(response) {
						const courses = response.data.courses.data;
						const meta = response.data.courses;
						const links = response.data.links;
						let html = renderTable(courses, meta) + renderPagination(meta, links);
						pendingTableContainer.innerHTML = html;
					})
					.catch(showError)
					.finally(function() {
						showLoading(false);
						loaded = true;
					});
			}

			// Event delegation for pagination
			pendingTableContainer.addEventListener('click', function(e) {
				const target = e.target.closest('.pagination a');
				if (target) {
					e.preventDefault();
					const url = target.getAttribute('href');
					if (url) {
						loadPendingTable(url);
					}
				}
			});

			pendingAccordion.addEventListener('show.bs.collapse', function() {
				if (loaded) return;
				loadPendingTable();
			});
		});
	</script>
@endpush
