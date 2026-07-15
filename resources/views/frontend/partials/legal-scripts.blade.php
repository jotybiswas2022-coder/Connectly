<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== SCROLL PROGRESS BAR =====
    const progressBar = document.getElementById('clLegalProgress');
    if (progressBar) {
        window.addEventListener('scroll', function() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            progressBar.style.width = ((scrollTop / docHeight) * 100) + '%';
        });
    }

    // ===== BACK TO TOP =====
    const backTop = document.getElementById('clLegalBackTop');
    if (backTop) {
        window.addEventListener('scroll', function() {
            backTop.classList.toggle('show', window.scrollY > 400);
        });
        backTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});
</script>
