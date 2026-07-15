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

    // ===== TABLE OF CONTENTS ACTIVE STATE =====
    const tocLinks = document.querySelectorAll('.cl-legal-toc-list a');
    const sections = document.querySelectorAll('.cl-legal-body section[id]');
    function updateToc() {
        let current = '';
        sections.forEach(s => {
            if (window.scrollY >= (s.offsetTop - 120)) current = s.id;
        });
        tocLinks.forEach(l => {
            l.classList.toggle('active', l.getAttribute('href') === '#' + current);
        });
    }
    if (tocLinks.length) {
        window.addEventListener('scroll', updateToc);
        updateToc();
        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const t = document.querySelector(this.getAttribute('href'));
                if (t) t.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }
});
</script>
