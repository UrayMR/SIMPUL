@php
    $toastTypes = [
        'success' => ['label' => config('app.name'), 'gradient' => 'linear-gradient(to right,#32bb71, #2a9d8f)'],
        'error' => ['label' => config('app.name'), 'gradient' => 'linear-gradient(to right,#f6743e, #d42525)'],
        'info' => ['label' => config('app.name'), 'gradient' => 'linear-gradient(to right,#2d82b2, #329abb)'],
    ];
@endphp

@foreach ($toastTypes as $type => $style)
    @if (session($type))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
            <div class="bs-toast toast fade bg-dark" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header text-white" style="background: {{ $style['gradient'] }};">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">{{ $style['label'] }}</div>
                    <small>{{ now()->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>

                <div class="toast-body text-white pt-2" style="background: {{ $style['gradient'] }};">
                    {{ session($type) }}
                </div>
            </div>
        </div>
    @endif
@endforeach

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toastElList = document.querySelectorAll('.toast');

        toastElList.forEach(function(toastEl) {
            const toast = new bootstrap.Toast(toastEl, {
                autohide: false
            });

            // Animasi masuk
            toastEl.classList.add("animate-in");
            toast.show();

            // Setelah 3 detik, animasi keluar
            setTimeout(() => {
                toastEl.classList.remove("animate-in");
                toastEl.classList.add("animate-out");

                toastEl.addEventListener("animationend", () => {
                    toast.hide();
                }, {
                    once: true
                });

            }, 3000);
        });
    });
</script>

<style>
    /* Toast wrapper */
    .toast,
    .bs-toast {
        border-radius: 6px !important;
        overflow: visible !important;
    }

    /* Header */
    .toast .toast-header {
        border-top-left-radius: 6px !important;
        border-top-right-radius: 6px !important;
        overflow: visible !important;
    }

    /* Body */
    .toast .toast-body {
        border-bottom-left-radius: 6px !important;
        border-bottom-right-radius: 6px !important;
        overflow: hidden;
    }

    /* Animasi masuk */
    .toast.animate-in {
        animation: slideIn 0.45s ease-out forwards;
    }

    @keyframes slideIn {
        from {
            transform: translateX(120%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Animasi keluar */
    .toast.animate-out {
        animation: slideOut 1s ease-in forwards;
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(120%);
            opacity: 0;
        }
    }

    /* Tombol X */
    .toast .btn-close {
        filter: none !important;
        opacity: .50 !important;
    }
</style>
