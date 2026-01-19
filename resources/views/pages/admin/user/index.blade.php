@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('breadcrumb')
	<li class="breadcrumb-item active">Data Pengguna</li>
@endsection

@section('content')
	<div class="container-fluid">
		<!-- Card: User Aktif/Nonaktif -->
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 mb-2">
				<h5 class="card-title fw-semibold mb-4">Daftar Data Pengguna</h5>
				<div class="row g-2 align-items-center">
					<!-- Search -->
					<div class="col-12 col-md-6">
						<form method="GET" class="w-100 d-flex align-items-center gap-2">
							<div class="input-group ">
								<span class="input-group-text"><i class="bx bx-search"></i></span>
								<input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
									placeholder="Cari nama atau email...">
								<button class="btn btn-outline-secondary border" type="submit">Cari</button>
							</div>
							<a href="{{ url()->current() }}"
								class="btn btn-secondary border d-flex align-items-center gap-1 {{ request('search') ? '' : 'd-none' }}">
								<i class="bi bi-arrow-counterclockwise"></i>
								<span>Reset</span>
							</a>
						</form>
					</div>
					<div class="col-12 col-md-auto ms-md-auto text-md-end">
						<a href="{{ route('admin.users.create') }}" class="btn btn-primary w-100 w-md-auto">
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
								<th>Nama</th>
								<th>Email</th>
								<th>Peran</th>
								<th class="text-center">Status</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($users as $user)
								<tr>
									<td>{{ $users->firstItem() + $loop->index }}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td><span>{{ ucfirst($user->role) }}</span></td>
									<td>
										@php
											$status = $user->status;
											$badgeClass = match ($status) {
											    'active' => 'bg-success',
											    'inactive' => 'bg-secondary',
											    default => 'bg-secondary',
											};
										@endphp
										<span class="badge w-100 {{ $badgeClass }}">{{ $status }}</span>
									</td>
									<td class="d-flex justify-content-center gap-2">
										<a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info"><i class="bx bx-info-circle"></i>
											Lihat</a>
										<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning"><i class="bx bx-pencil"></i>
											Ubah</a>
										@if (auth()->id() !== $user->id)
											<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
												data-bs-target="#modalCenter{{ $user->id }}"><i class="bx bx-trash"></i> Hapus</button>
										@else
											<button type="button" class="btn btn-secondary btn-sm" disabled title="Tidak dapat menghapus akun sendiri"><i
													class="bx bx-trash"></i> Hapus</button>
										@endif
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="6" class="text-center text-muted py-4">
										<i class="bi bi-person-x fs-4 d-block mb-2"></i>
										Tidak ada data user.
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				@foreach ($users as $user)
					@if (auth()->id() !== $user->id)
						<div class="modal fade" id="modalCenter{{ $user->id }}" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalCenterTitle">Konfirmasi</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<p>Apakah anda yakin ingin menghapus <strong>{{ Str::limit($user->name, 15, '...') }}</strong>?<br><br>Semua
											data yang pernah dibuat oleh pengguna ini akan terhapus juga.</p>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
											<form action="{{ route('admin.users.destroy', $user) }}" method="POST">
												@csrf
												@method('DELETE')
												<button class="btn btn-danger"><i class="bx bx-trash"></i> Hapus</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif
				@endforeach
				<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
					<div class="small text-muted">
						Halaman <strong>{{ $currentPage }}</strong> dari <strong>{{ $lastPage }}</strong><br>
						Menampilkan <strong>{{ $perPage }}</strong> data per halaman (total <strong>{{ $total }}</strong>
						user)
					</div>
					<div>
						{{ $users->links() }}
					</div>
				</div>
			</div>
		</div>

		<!-- Card: Accordion User Pending/Rejected -->
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 mb-2">
				<button class="w-100 d-flex align-items-center justify-content-between border-0 bg-transparent p-0" type="button"
					data-bs-toggle="collapse" data-bs-target="#pendingAccordion" aria-expanded="false" aria-controls="pendingAccordion"
					id="pendingAccordionBtn" style="outline:none;">
					<h5 class="card-title fw-semibold mb-0">Daftar Data Pengajuan Akun <span
							class="badge bg-warning text-dark ms-2">{{ $pendingCount }}</span></h5>
					<i class="bi bi-chevron-down ms-auto"></i>
				</button>
			</div>
			<div class="collapse" id="pendingAccordion">
				<div class="card-body" id="pendingAccordionBody">
					<div class="text-center text-muted py-4 d-none" id="pending-loading">
						<div class="spinner-border text-warning m-2" role="status"><span class="visually-hidden">Loading...</span></div>
						<div> Memuat data...</div>
					</div>
					<div id="pending-table-container"></div>
				</div>
			</div>
		</div>

		@push('scripts')
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					let loaded = false;
					const pendingAccordion = document.getElementById('pendingAccordion');
					const pendingTableContainer = document.getElementById('pending-table-container');
					const pendingLoading = document.getElementById('pending-loading');
					const authId = parseInt(document.body.getAttribute('data-auth-id'));

					function renderActions(user) {
						return `
						<a href="/admin/users/${user.id}" class="btn btn-sm btn-info"><i class="bx bx-info-circle"></i> Lihat</a>
						<a href="/admin/users/${user.id}/edit" class="btn btn-sm btn-warning"><i class="bx bx-pencil"></i> Ubah</a>
						${authId !== user.id ? `<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalCenter${user.id}"><i class="bx bx-trash"></i> Hapus</button>` : `<button type="button" class="btn btn-secondary btn-sm" disabled title="Tidak dapat menghapus akun sendiri"><i class="bx bx-trash"></i> Hapus</button>`}
					`;
					}

					function renderTable(users, meta) {
						if (!users.length) {
							return `<div class="text-center text-muted py-4"><i class="bi bi-person-x fs-4 d-block mb-2"></i>Tidak ada data pengajuan akun.</div>`;
						}
						return `
						<div class="table-responsive text-nowrap">
							<table class="table table-hover">
								<thead>
									<tr class="text-start">
										<th>#</th>
										<th>Nama</th>
										<th>Email</th>
										<th>Peran</th>
										<th class="text-center">Status</th>
										<th class="text-center">Aksi</th>
									</tr>
								</thead>
								<tbody>
									${users.map((user, idx) => {
										let badgeClass = user.status === 'pending' ? 'bg-warning text-dark' : (user.status === 'rejected' ? 'bg-danger' : 'bg-secondary');
										let number = meta && meta.from ? (meta.from + idx) : (idx + 1);
										return `
																												<tr>
																													<td>${number}</td>
																													<td>${user.name}</td>
																													<td>${user.email}</td>
																													<td>${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</td>
																													<td><span class="badge w-100 ${badgeClass}">${user.status}</span></td>
																													<td class="d-flex justify-content-center gap-2">${renderActions(user)}</td>
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
							<div class='small text-muted'>Halaman <strong>${meta.current_page}</strong> dari <strong>${meta.last_page}</strong><br>Menampilkan <strong>${meta.per_page}</strong> data per halaman (total <strong>${meta.total}</strong> user)</div>
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

					function loadPendingTable(url = '/admin/users/pending-list') {
						showLoading(true);
						window.axios.get(url)
							.then(function(response) {
								const users = response.data.users.data;
								const meta = response.data.users;
								const links = response.data.links;
								let html = renderTable(users, meta) + renderPagination(meta, links);
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
	</div>
@endsection
