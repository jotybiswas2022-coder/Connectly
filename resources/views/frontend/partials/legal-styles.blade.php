<style>
/* ============================================================
   LEGAL PAGES — PREMIUM DARK DESIGN SYSTEM
   ============================================================ */
.cl-legal-page {
    --clr-primary: #2563EB;
    --clr-light: #60A5FA;
    --clr-dark: #1E40AF;
    --clr-bg: #0B1120;
    --clr-surface: rgba(255,255,255,0.04);
    --clr-card: rgba(255,255,255,0.03);
    --clr-border: rgba(255,255,255,0.06);
    --clr-text: #f1f5f9;
    --clr-muted: #94a3b8;
    --clr-heading: #ffffff;

    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--clr-bg);
    color: var(--clr-text);
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
}

/* ===== BACKGROUND ORBS & GRID ===== */
.cl-legal-bg {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}
.cl-legal-bg-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
}
.cl-legal-bg-orb-1 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(37,99,235,0.08), transparent 70%);
    top: -200px; right: -100px;
    animation: clLegalOrb1 14s ease-in-out infinite;
}
.cl-legal-bg-orb-2 {
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(96,165,250,0.06), transparent 70%);
    bottom: -150px; left: -100px;
    animation: clLegalOrb2 16s ease-in-out infinite;
}
.cl-legal-bg-orb-3 {
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(30,64,175,0.06), transparent 70%);
    top: 40%; left: 60%;
    animation: clLegalOrb3 18s ease-in-out infinite;
}
@keyframes clLegalOrb1 {
    0%,100% { transform: translate(0,0) scale(1); }
    50% { transform: translate(60px,-50px) scale(1.1); }
}
@keyframes clLegalOrb2 {
    0%,100% { transform: translate(0,0) scale(1); }
    50% { transform: translate(-40px,60px) scale(1.08); }
}
@keyframes clLegalOrb3 {
    0%,100% { transform: translate(0,0) scale(1); }
    50% { transform: translate(40px,40px) scale(1.15); }
}

.cl-legal-grid {
    position: fixed; inset: 0;
    background-image:
        linear-gradient(rgba(37,99,235,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(37,99,235,0.025) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none; z-index: 0;
    mask-image: radial-gradient(ellipse at 50% 0%, black 40%, transparent 75%);
    -webkit-mask-image: radial-gradient(ellipse at 50% 0%, black 40%, transparent 75%);
}

/* ===== SCROLL PROGRESS BAR ===== */
.cl-legal-progress {
    position: fixed;
    top: 0; left: 0;
    width: 0%;
    height: 3px;
    background: linear-gradient(90deg, var(--clr-primary), var(--clr-light));
    z-index: 9999;
    transition: width 0.1s linear;
    border-radius: 0 2px 2px 0;
}

/* ===== MAIN WRAPPER ===== */
.cl-legal-wrapper {
    position: relative;
    z-index: 1;
    max-width: 1100px;
    margin: 0 auto;
    padding: 140px 24px 60px;
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 40px;
    align-items: start;
}

/* ===== TABLE OF CONTENTS (SIDEBAR) ===== */
.cl-legal-toc {
    position: sticky;
    top: 100px;
    background: var(--clr-card);
    border: 1px solid var(--clr-border);
    border-radius: 16px;
    padding: 24px 20px;
    max-height: calc(100vh - 140px);
    overflow-y: auto;
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.cl-legal-toc-title {
    font-size: 0.72rem;
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--clr-border);
}
.cl-legal-toc-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.cl-legal-toc-list li a {
    display: block;
    padding: 6px 10px;
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--clr-muted);
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.2s ease;
    border-left: 2px solid transparent;
}
.cl-legal-toc-list li a:hover {
    color: var(--clr-light);
    background: rgba(37,99,235,0.06);
    border-left-color: var(--clr-primary);
}
.cl-legal-toc-list li a.active {
    color: var(--clr-light);
    background: rgba(37,99,235,0.1);
    border-left-color: var(--clr-primary);
    font-weight: 600;
}

/* ===== MAIN CONTENT CARD ===== */
.cl-legal-card {
    background: var(--clr-card);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid var(--clr-border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}

/* ===== HEADER ===== */
.cl-legal-header {
    padding: 40px 44px 32px;
    border-bottom: 1px solid var(--clr-border);
    position: relative;
    background: linear-gradient(180deg, rgba(37,99,235,0.04), transparent);
}
.cl-legal-header-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}
.cl-legal-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--clr-muted);
    text-decoration: none;
    transition: all 0.25s ease;
    padding: 8px 14px;
    border-radius: 10px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--clr-border);
}
.cl-legal-back:hover {
    color: var(--clr-light);
    background: rgba(37,99,235,0.08);
    border-color: rgba(37,99,235,0.2);
    gap: 12px;
}
.cl-legal-back svg { transition: transform 0.25s ease; }
.cl-legal-back:hover svg { transform: translateX(-3px); }

.cl-legal-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px;
    background: rgba(37,99,235,0.1);
    border: 1px solid rgba(37,99,235,0.15);
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--clr-light);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.cl-legal-badge::before {
    content: '';
    width: 5px; height: 5px;
    border-radius: 50%;
    background: #22c55e;
    animation: clLegalPulse 2s ease-in-out infinite;
}
@keyframes clLegalPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.6); }
    50% { box-shadow: 0 0 0 6px rgba(34,197,94,0); }
}

.cl-legal-title {
    font-size: 2.6rem;
    font-weight: 900;
    line-height: 1.15;
    letter-spacing: -0.03em;
    color: var(--clr-heading);
    margin-bottom: 8px;
}
.cl-legal-title .cl-legal-title-accent {
    background: linear-gradient(135deg, var(--clr-light), var(--clr-primary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.cl-legal-date {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8rem;
    color: var(--clr-muted);
    margin: 0;
}
.cl-legal-date::before {
    content: '';
    width: 4px; height: 4px;
    border-radius: 50%;
    background: var(--clr-muted);
    opacity: 0.4;
}

/* ===== CONTENT BODY ===== */
.cl-legal-body {
    padding: 36px 44px 44px;
}

.cl-legal-body section {
    margin-bottom: 0;
    padding: 28px 0;
    border-bottom: 1px solid var(--clr-border);
    scroll-margin-top: 100px;
}
.cl-legal-body section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.cl-legal-body h2 {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--clr-heading);
    margin-bottom: 16px;
    letter-spacing: -0.02em;
    display: flex;
    align-items: center;
    gap: 12px;
}
.cl-legal-body h2 .cl-legal-section-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px; height: 28px;
    background: linear-gradient(135deg, rgba(37,99,235,0.15), rgba(37,99,235,0.05));
    border: 1px solid rgba(37,99,235,0.15);
    border-radius: 8px;
    font-size: 0.72rem;
    font-weight: 800;
    color: var(--clr-light);
    flex-shrink: 0;
}

.cl-legal-body h3 {
    font-size: 1.02rem;
    font-weight: 600;
    color: var(--clr-heading);
    margin: 22px 0 10px;
}

.cl-legal-body p {
    font-size: 0.92rem;
    line-height: 1.8;
    color: var(--clr-muted);
    margin-bottom: 10px;
}

/* ===== LISTS ===== */
.cl-legal-list {
    list-style: none;
    padding: 0;
    margin: 14px 0;
}
.cl-legal-list li {
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--clr-muted);
    padding: 7px 0 7px 28px;
    position: relative;
}
.cl-legal-list li::before {
    content: '';
    position: absolute;
    left: 4px;
    top: 15px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--clr-primary);
    opacity: 0.4;
    box-shadow: 0 0 6px rgba(37,99,235,0.2);
}

/* ===== LINKS ===== */
.cl-legal-body a {
    color: var(--clr-light);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    position: relative;
}
.cl-legal-body a:hover {
    color: #fff;
}

/* ===== BACK TO TOP ===== */
.cl-legal-back-top {
    position: fixed;
    bottom: 32px;
    right: 32px;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--clr-primary), var(--clr-dark));
    color: #fff;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px);
    transition: all 0.3s cubic-bezier(.16,1,.3,1);
    box-shadow: 0 4px 16px rgba(37,99,235,0.3);
    z-index: 100;
}
.cl-legal-back-top.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
.cl-legal-back-top:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.45);
}
.cl-legal-back-top svg { display: block; }

/* ================================================================
   R E S P O N S I V E
   ================================================================ */

/* --- Tablets (≤ 1024px) --- */
@media (max-width: 1024px) {
    .cl-legal-wrapper {
        grid-template-columns: 1fr;
        padding: 120px 20px 40px;
    }
    .cl-legal-toc {
        position: relative;
        top: 0;
        max-height: none;
        padding: 18px 16px;
    }
    .cl-legal-toc-list {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 4px;
    }
    .cl-legal-toc-list li a {
        font-size: 0.75rem;
        padding: 5px 10px;
        border-left: none;
        border-bottom: 2px solid transparent;
        border-radius: 0;
    }
    .cl-legal-toc-list li a.active {
        border-left-color: transparent;
        border-bottom-color: var(--clr-primary);
    }
    .cl-legal-title {
        font-size: 2.2rem;
    }
    .cl-legal-back-top {
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
    }
}

/* --- Small Tablets / Large Phones (≤ 768px) --- */
@media (max-width: 768px) {
    .cl-legal-wrapper {
        padding: 100px 16px 32px;
        gap: 24px;
    }
    .cl-legal-header {
        padding: 28px 24px 24px;
    }
    .cl-legal-body {
        padding: 24px 24px 32px;
    }
    .cl-legal-title {
        font-size: 1.8rem;
    }
    .cl-legal-header-top {
        flex-direction: column;
        align-items: flex-start;
    }
    .cl-legal-body section {
        padding: 22px 0;
    }
    .cl-legal-body h2 {
        font-size: 1.15rem;
    }
    .cl-legal-body h2 .cl-legal-section-num {
        width: 24px;
        height: 24px;
        font-size: 0.65rem;
    }
    .cl-legal-body h3 {
        font-size: 0.95rem;
    }
    .cl-legal-body p {
        font-size: 0.87rem;
    }
    .cl-legal-list li {
        font-size: 0.85rem;
        padding-left: 24px;
    }
    .cl-legal-list li::before {
        width: 5px;
        height: 5px;
        top: 14px;
    }
    .cl-legal-toc-list li a {
        font-size: 0.72rem;
    }
}

/* --- Small Phones (≤ 480px) --- */
@media (max-width: 480px) {
    .cl-legal-wrapper {
        padding: 90px 12px 24px;
        gap: 18px;
    }
    .cl-legal-header {
        padding: 22px 18px 20px;
    }
    .cl-legal-body {
        padding: 18px 18px 28px;
    }
    .cl-legal-title {
        font-size: 1.5rem;
    }
    .cl-legal-date {
        font-size: 0.72rem;
    }
    .cl-legal-badge {
        font-size: 0.65rem;
        padding: 4px 10px;
    }
    .cl-legal-back {
        font-size: 0.78rem;
        padding: 6px 12px;
    }
    .cl-legal-body section {
        padding: 18px 0;
    }
    .cl-legal-body h2 {
        font-size: 1.05rem;
        gap: 8px;
    }
    .cl-legal-body h2 .cl-legal-section-num {
        width: 22px;
        height: 22px;
        font-size: 0.6rem;
    }
    .cl-legal-body p {
        font-size: 0.82rem;
        line-height: 1.75;
    }
    .cl-legal-list li {
        font-size: 0.8rem;
        padding: 5px 0 5px 20px;
    }
    .cl-legal-list li::before {
        width: 4px;
        height: 4px;
        top: 12px;
        left: 2px;
    }
    .cl-legal-toc {
        padding: 14px 12px;
    }
    .cl-legal-toc-title {
        font-size: 0.65rem;
        margin-bottom: 10px;
    }
    .cl-legal-toc-list {
        gap: 2px;
    }
    .cl-legal-toc-list li a {
        font-size: 0.68rem;
        padding: 4px 8px;
    }
    .cl-legal-back-top {
        bottom: 16px;
        right: 16px;
        width: 36px;
        height: 36px;
    }
}

/* --- Very Small Phones (≤ 375px) --- */
@media (max-width: 375px) {
    .cl-legal-wrapper {
        padding: 85px 10px 20px;
    }
    .cl-legal-header {
        padding: 18px 14px 16px;
    }
    .cl-legal-body {
        padding: 14px 14px 24px;
    }
    .cl-legal-title {
        font-size: 1.3rem;
    }
    .cl-legal-body h2 {
        font-size: 0.95rem;
    }
    .cl-legal-body p {
        font-size: 0.78rem;
    }
    .cl-legal-list li {
        font-size: 0.78rem;
    }
}

/* --- Landscape on small screens --- */
@media (max-height: 500px) and (orientation: landscape) {
    .cl-legal-wrapper {
        padding: 80px 16px 20px;
    }
    .cl-legal-toc {
        max-height: 40vh;
        overflow-y: auto;
    }
    .cl-legal-bg-orb-1 { width: 200px; height: 200px; }
    .cl-legal-bg-orb-2 { width: 150px; height: 150px; }
    .cl-legal-bg-orb-3 { display: none; }
    .cl-legal-grid { background-size: 30px 30px; }
}

/* --- Reduced Motion --- */
@media (prefers-reduced-motion: reduce) {
    .cl-legal-page *,
    .cl-legal-page *::before,
    .cl-legal-page *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
    .cl-legal-bg-orb, .cl-legal-grid { display: none; }
}
</style>
