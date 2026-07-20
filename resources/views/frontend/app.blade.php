<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Connectly - A modern social platform for real conversations and meaningful connections.')">
    <title>@yield('title', 'Connectly')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-KOKx7/j+fNU1R1H9lKDz9EwT5PpFKF4P4FQn8vHCEa8l/HzIhM+fq0Iu6iX2QzYeb6gi3W4Z2Zob/nkZfgF+pQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    @include('frontend.partials.menu')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ===== GLOBAL IMAGE LIGHTBOX ===== --}}
<div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="background:transparent !important;border:none !important;box-shadow:none !important;">
            <div class="modal-body text-center p-0" style="position:relative;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;top:10px;right:10px;z-index:10;filter:invert(1);opacity:0.8;"></button>
                <img id="lightboxImage" src="" alt="Full size image" class="img-fluid rounded" style="max-height:90vh;box-shadow:0 20px 80px rgba(0,0,0,0.4);border-radius:12px;">
            </div>
        </div>
    </div>
</div>

<script>
// Global image lightbox opener - available on all pages
function openImageModal(src) {
    const modal = document.getElementById('imageLightboxModal');
    const img = document.getElementById('lightboxImage');
    if (modal && img) {
        img.src = src;
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }
}


</script>

</body>
</html>
