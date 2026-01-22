@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}" class="text-decoration-none">Data
			Transaksi</a></li>
	<li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="card shadow-sm border-0 mb-4 p-3">
			<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 fw-semibold fs-4">Detail Transaksi</h5>
				<a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary border">
					Kembali
				</a>
			</div>
			<div class="card-body">
				<div class="row mb-2">
					<div class="col-md-6 mb-3">
						<div class="card border-0 shadow-sm h-100">
							<div class="card-header bg-white border-0 pb-1">
								<h6 class="fw-bold mb-0">Detail Pengguna</h6>
							</div>
							<div class="card-body pt-2 pb-2">
								<div class="mb-2"><strong>Nama:</strong> {{ $transaction->user->name ?? '-' }}</div>
								<div class="mb-2"><strong>Email:</strong> {{ $transaction->user->email ?? '-' }}</div>
								<div class="mb-2"><strong>Peran:</strong> {{ ucfirst($transaction->user->role ?? '-') }}</div>
								<div class="mb-2"><strong>Nomor Telepon:</strong> {{ $transaction->user->phone_number ?? '-' }}</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="card border-0 shadow-sm h-100">
							<div class="card-header bg-white border-0 pb-1">
								<h6 class="fw-bold mb-0">Detail Kursus</h6>
							</div>
							<div class="card-body pt-2 pb-2">
								<div class="mb-2"><strong>Judul:</strong> {{ $transaction->course->title ?? '-' }}</div>
								<div class="mb-2"><strong>Kategori:</strong> {{ $transaction->course->category->name ?? '-' }}</div>
								<div class="mb-2"><strong>Pengajar:</strong> {{ $transaction->course->teacher->user->name ?? '-' }}</div>
								<div class="mb-2"><strong>Harga Kursus:</strong>
									Rp{{ number_format($transaction->course->price ?? 0, 0, ',', '.') }}</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-12 mb-3">
						<label class="form-label text-start d-block">Bukti Pembayaran</label>
						@if ($transaction->payment_proof_path)
							<img src="{{ asset('storage/' . $transaction->payment_proof_path) }}" alt="Bukti Pembayaran"
								class="img-thumbnail shadow-sm"
								style="max-width: 350px; max-height: 350px; object-fit: contain; border: 2px solid #dee2e6;">
						@else
							<span class="text-muted">-</span>
						@endif
					</div>
				</div>
			</div>
			<div class="card-footer bg-white border-0 pt-0">
				<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
					<div class="fw-bold text-warning">
						Nominal Transaksi: Rp{{ number_format($transaction->amount, 0, ',', '.') }}
					</div>
					@if ($transaction->status === 'pending')
						<div class="d-flex justify-content-end gap-2 mt-3 mt-md-0">
							<button type="button" class="btn btn-success me-2" data-bs-toggle="modal"
								data-bs-target="#modalApproveTransaction">
								<i class="bi bi-check-circle"></i> Approve
							</button>
							<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalRejectTransaction">
								<i class="bi bi-x-circle"></i> Reject
							</button>
						</div>
					@endif
				</div>
				@if ($transaction->status === 'pending')
					<!-- Modal Approve -->
					<div class="modal fade" id="modalApproveTransaction" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content rounded-4 shadow-lg border-0 p-2">
								<div class="modal-header border-0 pb-0">
									<div class="d-flex align-items-center gap-2 w-100">
										<i class="bi bi-check-circle text-success fs-3 me-2"></i>
										<div class="flex-grow-1">
											<h5 class="modal-title mb-0 fw-bold text-success">Konfirmasi Approve</h5>
											<small class="text-muted">Transaksi akan disetujui</small>
										</div>
										<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
								</div>
								<div class="modal-body pt-3 pb-0 px-4">
									<p class="mb-3 fs-6">Approve transaksi <strong>{{ $transaction->user->name ?? '-' }}</strong> untuk kursus
										<strong>{{ $transaction->course->title ?? '-' }}</strong>?
									</p>
								</div>
								<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
									<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
									<form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" class="d-inline">
										@csrf
										@method('PATCH')
										<button type="submit" class="btn btn-success px-4 btn-approve-transaction">
											<span class="button-content"><i class="bi bi-check-circle me-1"></i> Approve</span>
											<span class="spinner-content d-none">
												<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
												Memproses...
											</span>
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal Reject -->
					<div class="modal fade" id="modalRejectTransaction" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content rounded-4 shadow-lg border-0 p-2">
								<div class="modal-header border-0 pb-0">
									<div class="d-flex align-items-center gap-2 w-100">
										<i class="bi bi-x-circle text-danger fs-3 me-2"></i>
										<div class="flex-grow-1">
											<h5 class="modal-title mb-0 fw-bold text-danger">Konfirmasi Reject</h5>
											<small class="text-muted">Transaksi akan ditolak</small>
										</div>
										<button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
								</div>
								<div class="modal-body pt-3 pb-0 px-4">
									<p class="mb-3 fs-6">Tolak transaksi <strong>{{ $transaction->user->name ?? '-' }}</strong> untuk kursus
										<strong>{{ $transaction->course->title ?? '-' }}</strong>?
									</p>
								</div>
								<div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
									<button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
									<form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" class="d-inline">
										@csrf
										@method('PATCH')
										<button type="submit" class="btn btn-danger px-4 btn-reject-transaction">
											<span class="button-content"><i class="bi bi-x-circle me-1"></i> Reject</span>
											<span class="spinner-content d-none">
												<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
												Memproses...
											</span>
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			document.querySelectorAll('.btn-approve-transaction').forEach(function(btn) {
				btn.closest('form').addEventListener('submit', function(e) {
					btn.disabled = true;
					btn.querySelector('.button-content').classList.add('d-none');
					btn.querySelector('.spinner-content').classList.remove('d-none');
				});
			});
			document.querySelectorAll('.btn-reject-transaction').forEach(function(btn) {
				btn.closest('form').addEventListener('submit', function(e) {
					btn.disabled = true;
					btn.querySelector('.button-content').classList.add('d-none');
					btn.querySelector('.spinner-content').classList.remove('d-none');
				});
			});
		});
	</script>
@endpush
