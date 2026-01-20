 <style>
     .course-card {
         height: 410px;
         /* FIX TINGGI CARD */
         border-radius: 1rem;
         overflow: hidden;

         display: flex;
         flex-direction: column;
     }

     /* HEADER */
     .course-header {
         height: 200px;
         flex-shrink: 0;
         position: relative;
         overflow: hidden;
     }

     .course-card .card-body {
         flex: 1;
         /* isi sisa tinggi */
         display: flex;
         flex-direction: column;
     }

     .course-card .card-body button {
         margin-top: auto;
         /* dorong ke bawah */
     }

     /* IMAGE WRAPPER */
     .course-image-wrapper {
         width: 100%;
         height: 100%;
         overflow: hidden;
     }

     /* IMAGE */
     .course-image {
         width: 100%;
         height: 100%;
         object-fit: cover;
         transition: transform 0.5s ease;
     }

     .course-card-link {
         display: block;
     }

     .course-card {
         height: 410;
         border-radius: 1rem;
         overflow: hidden;
         display: flex;
         flex-direction: column;
         transition: all 0.35s ease;
     }

     /* HOVER CARD */
     .course-card-link:hover .course-card {
         transform: translateY(-8px);
         box-shadow: 0 18px 40px rgba(0, 0, 0, 0.15);
     }

     /* OPTIONAL: sedikit efek di header */
     .course-card-link:hover .course-header {
         filter: brightness(0.95);
     }

     .course-card-link:focus-visible .course-card {
         outline: 3px solid #008080;
     }



     /* BADGE LEVEL (VERTIKAL) */
     .badge-level {
         position: absolute;
         right: -32px;
         top: 20px;
         background: #008080;
         color: #fff;
         padding: 0.35rem 1rem;
         transform: rotate(90deg);
         border-radius: 0.5rem;
         font-size: 0.75rem;
         text-transform: uppercase;
     }

     /* BADGE MATERI */
     .badge-material {
         position: absolute;
         bottom: 10px;
         left: 10px;
         background: #fff;
         color: #333;
         border-radius: 0.5rem;
         padding: 0.3rem 0.6rem;
         font-size: 0.75rem;
         box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
     }

     .course-footer {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* PRICE */
.course-price {
    font-weight: 700;
    font-size: 1rem;
    white-space: nowrap;          /* tetap satu baris */
    overflow: hidden;
    text-overflow: ellipsis;      /* ... kalau kepanjangan */
    max-width: 100%;
       color: #111;


}


 </style>

 <a href="/" class="course-card-link text-decoration-none text-dark d-block">

     <div class="card course-card shadow-sm border-0">
         <!-- IMAGE / HEADER -->
         <div class="course-header">
             <div class="course-image-wrapper">
                 <img src="{{ asset('assets/img/' . $image) }}" alt="{{ $title }}" class="course-image">
             </div>
         </div>

         <!-- BODY -->
         <div class="card-body">
             <h5 class="fw-bold mb-3">
                 {{ Str::limit($title, 72, '...') }}
             </h5>

             <div class="d-flex justify-content-between align-items-center">
                 <div class="text-muted small">{{ $category }}</div>
                 <div class="text-muted small">
                     <i class="bi bi-bar-chart-fill text-success"></i> 10.000
                 </div>
             </div>

             <div class="mt-auto course-footer">

                 <div class="course-price {{ (float) $price === 0.0 ? 'text-danger' : 'text-dark' }}">

                     {{ (float) $price === 0.0 ? 'GRATIS' : 'Rp ' . number_format((float) $price, 0, ',', '.') }}
                 </div>

                 <button class="btn btn-app-secondary w-100">
                     Beli
                 </button>

             </div>


         </div>
     </div>

 </a>
