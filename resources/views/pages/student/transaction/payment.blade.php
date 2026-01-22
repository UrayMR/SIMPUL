@extends('layouts.app')

@section('title', 'Pembayaran Transaksi')

@section('content')
	<section class="py-5 bg-light">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="text-center mb-3">
						<div class="mb-3">
							<img src="{{ asset('assets/img/logo/Logo Simpul.svg') }}" alt="Logo" style="width:64px;height:64px;"
								class="rounded-circle shadow-sm border">
						</div>

						<h3 class="fw-bold mb-1">
							Pembayaran Kursus
						</h3>

						<p class="text-muted mb-0">
							Selesaikan pembayaran untuk mengakses kursus
						</p>
					</div>

					{{-- DETAIL Kursus --}}
					<div class="card border-0 shadow-sm rounded-4 mb-4">
						<div class="card-body p-4">

							<h5 class="fw-bold mb-3 d-flex align-items-center gap-3">
								<i class="bi bi-card-text text-app-primary"></i>
								{{ $course->title ?? 'Judul Kursus' }}

							</h5>
							<div class="text-muted small mb-3">
								Mentor: {{ $course->teacher->user->name ?? '-' }}
							</div>

							<div class="row g-3">
								<div class="col-md-6">
									<div class="text-muted small">Harga Kursus</div>
									<div class="fw-semibold fs-5">
										Rp {{ number_format($course->price ?? 0, 0, ',', '.') }}
									</div>
								</div>

								<div class="col-md-6">
									<div class="text-muted small">Tanggal Transaksi</div>
									<div class="fw-semibold">
										{{ $payment->created_at->translatedFormat('d F Y H:i') }} WIB
									</div>
								</div>
							</div>

						</div>
					</div>

					{{-- INFO REKENING --}}
					<div class="card border-0 shadow-sm rounded-4 mb-4">
						<div class="card-body p-4">

							<h5 class="fw-bold mb-3 d-flex align-items-center gap-3">
								<i class="bi bi-bank text-app-primary"></i>
								Informasi Pembayaran
							</h5>

							<div class="row g-3">
								<div class="col-md-4">
									<div class="text-muted small">Bank</div>
									<div class="fw-semibold fs-5">BCA</div>
								</div>
								<div class="col-md-4">
									<div class="text-muted small">Nomor Rekening</div>
									<div class="fw-semibold fs-5">880940124144</div>
								</div>
								<div class="col-md-4">
									<div class="text-muted small">Atas Nama</div>
									<div class="fw-semibold fs-5">PT Simpul Digital</div>
								</div>
							</div>

							<div class="alert alert-warning mt-4 mb-0 small d-flex gap-2">
								<i class="bi bi-exclamation-triangle"></i>
								<span>
									Pastikan transfer sesuai nominal dan unggah bukti pembayaran.
								</span>
							</div>

						</div>
					</div>

					{{-- UPLOAD BUKTI --}}
					<div class="card border-0 shadow-sm rounded-4">
						<div class="card-body p-4">

							<h5 class="fw-bold mb-3 d-flex align-items-center gap-3">
								<i class="bi bi-upload text-app-primary"></i>
								Upload Bukti Pembayaran
							</h5>

							{{-- STATUS PEMBAYARAN --}}
							@php
								$status = $payment->status ?? null;
							@endphp

							@if ($status === 'pending' && empty($payment->payment_proof_path))
								<div class="alert alert-secondary d-flex align-items-center gap-2 small">
									<i class="bi bi-info-circle"></i>
									<span>Anda belum mengunggah bukti pembayaran.</span>
								</div>
							@elseif($status === 'pending' && !empty($payment->payment_proof_path))
								<div class="alert alert-warning d-flex align-items-center gap-2 small">
									<i class="bi bi-hour glass-split"></i>
									<span>Bukti pembayaran sudah diunggah. Menunggu verifikasi admin.</span>
								</div>
							@elseif($status === 'approved')
								<div class="alert alert-success d-flex align-items-center gap-2 small">
									<i class="bi bi-check-circle-fill"></i>
									<span>Pembayaran telah diverifikasi. Terima kasih.</span>
								</div>
							@elseif($status === 'rejected')
								<div class="alert alert-danger d-flex align-items-center gap-2 small">
									<i class="bi bi-x-circle-fill"></i>
									<span>Bukti pembayaran ditolak. Silakan unggah ulang.</span>
								</div>
							@endif

							{{-- FORM --}}

							@if (empty($payment->payment_proof_path))
								<form action="{{ route('student.payment.apply') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="payment_token" value="{{ $payment->payment_token ?? '' }}">
									<input type="hidden" name="course_id" value="{{ $course->id ?? '' }}">

									<div class="mb-4">
										<label class="form-label fw-semibold">
											Bukti Transfer
										</label>
										<input type="file" name="payment_proof_file" class="form-control" accept="image/*"
											{{ $status === 'approved' ? 'disabled' : '' }} onchange="previewImage(event)">
										<div class="form-text">
											JPG / PNG, maksimal 2MB
										</div>
									</div>

									{{-- PREVIEW IMAGE --}}
									<div class="mb-4 d-none" id="preview-wrapper">
										<label class="form-label fw-semibold">
											Preview Bukti
										</label>
										<div class="border rounded-3 p-3 text-center bg-light">
											<img id="preview-image" class="img-fluid rounded-3" style="max-height: 300px;">
										</div>
									</div>

									@if ($status !== 'approved')
										<button type="submit" class="btn btn-app-primary w-100 py-2">
											Bayar Sekarang
										</button>
									@endif

									@if (!empty($payment->payment_token_expires_at))
										<div class="mt-3 text-end text-muted small">
											Waktu Kadaluarsa Pembayaran :
											<span id="countdown-expiry"></span>
										</div>
										<script>
											document.addEventListener('DOMContentLoaded', function() {
												var expiry = @json($payment->payment_token_expires_at->format('Y-m-d H:i:s'));
												var countdownEl = document.getElementById('countdown-expiry');

												function updateCountdown() {
													var now = new Date().getTime();
													var expireTime = new Date(expiry.replace(/-/g, '/')).getTime();
													var distance = expireTime - now;
													if (distance <= 0) {
														countdownEl.innerHTML = '<span class="text-danger">Kadaluarsa</span>';
														clearInterval(timer);
														return;
													}
													var days = Math.floor(distance / (1000 * 60 * 60 * 24));
													var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
													var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
													var seconds = Math.floor((distance % (1000 * 60)) / 1000);
													var str = '';
													if (days > 0) str += days + ' hari ';
													str += hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ':' + seconds
														.toString().padStart(2, '0');
													countdownEl.textContent = str;
												}
												updateCountdown();
												var timer = setInterval(updateCountdown, 1000);
											});
										</script>
									@endif
								</form>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script>
		function previewImage(event) {
			const wrapper = document.getElementById('preview-wrapper');
			const image = document.getElementById('preview-image');

			image.src = URL.createObjectURL(event.target.files[0]);
			wrapper.classList.remove('d-none');
		}
	</script>
@endsection
