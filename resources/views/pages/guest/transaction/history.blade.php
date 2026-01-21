@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
	<style>
		html,
		body {
			overflow-x: hidden;
		}
	</style>

	{{-- HERO SECTION --}}
	<section class="bg-app-primary text-white py-5 py-lg-6 mb-0">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-lg-8">
					<span class="badge bg-white text-app-primary px-3 py-2 rounded-pill mb-3 fw-semibold">
						Riwayat Transaksi
					</span>
					<h1 class="fw-extrabold display-5 mb-3 lh-sm text-white">
						Daftar Transaksi Kelas Anda
					</h1>
					<p class="fs-5 opacity-75 mb-0">
						Lihat riwayat pembelian kelas yang pernah Anda lakukan di SIMPUL.
					</p>
				</div>
			</div>
		</div>
	</section>

	{{-- TABEL RIWAYAT TRANSAKSI --}}
	<section class="py-5 bg-light">
		<div class="container">
			<div class="text-center mb-5">
				<h3 class="fw-bold mb-2">
					Riwayat Pembelian Kelas
				</h3>
				<p class="text-muted">
					Berikut adalah daftar transaksi pembelian kelas Anda di SIMPUL
				</p>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div class="border-0 rounded-4">
						<div class="card-body p-4">
							<div class="table-responsive">
								<table class="table table-hover align-middle mb-0">
									<thead>
										<tr>
											<th>No</th>
											<th>Kelas</th>
											<th>Tanggal</th>
											<th>Metode</th>
											<th>Total</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										@forelse ($transactions as $trx)
											<tr class="transaction-row" style="cursor:pointer"
												data-href="{{ route('student.payment.index', ['course_id' => $trx->course_id]) }}">
												<td>{{ $transactions->firstItem() + $loop->index }}</td>
												<td>
													<div class="fw-semibold">{{ $trx->course->title }}</div>
													<small class="text-muted">
														Pengajar: {{ $trx->course->teacher->user->name }}
													</small>
												</td>
												<td>
													{{ $trx->created_at->translatedFormat('d F Y') }}<br>
													<small class="text-muted">
														{{ $trx->created_at->format('H:i') }} WIB
													</small>
												</td>
												<td>Transfer Bank</td>
												<td class="fw-semibold">
													Rp {{ number_format($trx->amount, 0, ',', '.') }}
												</td>
												<td>
													@if ($trx->status === 'pending')
														<span
															class="badge rounded-pill px-3 py-2 bg-warning-subtle text-warning d-inline-flex align-items-center gap-1">
															<i class="bi bi-clock-fill"></i>
															Menunggu
														</span>
													@elseif ($trx->status === 'approved')
														<span
															class="badge rounded-pill px-3 py-2 bg-success-subtle text-success d-inline-flex align-items-center gap-1">
															<i class="bi bi-check-circle-fill"></i>
															Berhasil
														</span>
													@else
														<span
															class="badge rounded-pill px-3 py-2 bg-danger-subtle text-danger d-inline-flex align-items-center gap-1">
															<i class="bi bi-x-circle-fill"></i>
															Ditolak
														</span>
													@endif
												</td>
											</tr>
										@empty
											<tr>
												<td colspan="7" class="text-center py-5 text-muted">
													<i class="bi bi-receipt fs-1 d-block mb-2"></i>
													Belum ada transaksi
												</td>
											</tr>
										@endforelse
									</tbody>

									@push('scripts')
										<script>
											document.addEventListener('DOMContentLoaded', function() {
												document.querySelectorAll('.transaction-row').forEach(function(row) {
													row.addEventListener('click', function(e) {
														// Prevent click if user selects text
														if (window.getSelection().toString().length === 0) {
															window.location.href = row.getAttribute('data-href');
														}
													});
												});
											});
										</script>
									@endpush

								</table>
							</div>
							@if ($transactions->count() > 0)
								<div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
									<div class="pagination-info">
										Menampilkan
										{{ $transactions->firstItem() }}–{{ $transactions->lastItem() }}
										dari
										{{ $transactions->total() }}
										data
									</div>
									<div>
										{{ $transactions->links('pagination::bootstrap-4') }}
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	{{-- CTA SECTION --}}
	<section class="pt-1 pb-5 bg-white">
		<div class="container">
			<div class="card border shadow-sm rounded-4" data-aos="zoom-in" data-aos-delay="150">
				<div class="card-body p-5 text-center">
					<h3 class="fw-bold mb-2">
						Ingin Beli Kelas Lagi?
					</h3>
					<p class="text-muted mb-4">
						Temukan kelas menarik lainnya dan tingkatkan keahlian Anda bersama SIMPUL.
					</p>
					<a href="{{ route('beranda') }}#courses" class="btn btn-app-primary px-5 py-2 fw-semibold rounded-3"
						data-aos="zoom-in" data-aos-delay="300">
						Lihat Kelas Lainnya
					</a>
				</div>
			</div>
		</div>
	</section>
@endsection
