<style>
    .site-theme {
        background: #fff !important;
        color: #111;
        font-family: "Plus Jakarta Sans", Inter, sans-serif;
    }
    .site-theme h1,
    .site-theme h2,
    .site-theme h3,
    .site-theme .font-serif {
        font-family: Poppins, "Plus Jakarta Sans", sans-serif !important;
        color: #111;
        letter-spacing: -0.02em;
    }
    .site-theme .bg-white {
        background: #fbf9f6 !important;
        border-color: #efeeeb !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }
    .site-theme .bg-\[\#f2f2f2\] {
        background: #fbf9f6 !important;
        border-color: #efeeeb !important;
    }
    .site-theme .text-\[\#D4AF37\],
    .site-theme .text-\[\#735A12\],
    .site-theme a {
        color: #89351d;
    }
    .site-theme a:hover,
    .site-theme .hover\:text-\[\#b8922a\]:hover,
    .site-theme .group:hover .group-hover\:text-\[\#D4AF37\] {
        color: #b36855 !important;
    }
    .site-theme .bg-\[\#D4AF37\]\/10,
    .site-theme .from-\[\#D4AF37\]\/10 {
        background: rgba(137, 53, 29, 0.08) !important;
        background-image: none !important;
    }
    .site-theme .hover\:bg-\[\#D4AF37\]\/20:hover {
        background: rgba(137, 53, 29, 0.14) !important;
    }
    .site-theme .border-\[\#D4AF37\]\/15,
    .site-theme .border-\[\#D4AF37\]\/20 {
        border-color: #efeeeb !important;
    }
    .site-theme .hover\:border-\[\#D4AF37\]:hover {
        border-color: #b36855 !important;
    }
    .site-theme label .fas,
    .site-theme label .fa-solid,
    .site-theme h3 > .fas,
    .site-theme h3 .fas {
        color: #89351d;
    }
    .site-kicker {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 12px;
    }
    .site-kicker.center { justify-content: center; }
    .site-kicker > span {
        width: 24px;
        height: 2px;
        background: #89351d;
        flex: none;
    }
    .site-kicker p {
        margin: 0;
        color: #89351d;
        font-family: "Space Grotesk", sans-serif;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1.1px;
        line-height: 16px;
        text-transform: uppercase;
    }
    .site-theme input:not([type="checkbox"]):not([type="radio"]):not([type="hidden"]),
    .site-theme textarea,
    .site-theme select {
        background: #fff !important;
        border: 1px solid #d5cec2 !important;
        border-radius: 12px !important;
        color: #1b1c1a;
        font-family: "Plus Jakarta Sans", Inter, sans-serif;
        box-shadow: none;
    }
    .site-theme input:not([type="checkbox"]):not([type="radio"]):focus,
    .site-theme textarea:focus,
    .site-theme select:focus {
        outline: none;
        border-color: #b36855 !important;
        box-shadow: 0 0 0 3px rgba(179, 104, 85, 0.18) !important;
    }
    .site-theme input[type="checkbox"],
    .site-theme input[type="radio"] {
        accent-color: #b36855;
    }
    .site-theme button[type="submit"] {
        background: #b36855 !important;
        background-image: none !important;
        color: #faf7f2 !important;
        border-radius: 9999px !important;
        font-family: "Plus Jakarta Sans", Inter, sans-serif;
        font-weight: 700;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.12), 0 2px 4px -2px rgba(0, 0, 0, 0.43) !important;
    }
    .site-theme button[type="submit"]:hover { filter: brightness(1.05); }
    .site-theme button[type="submit"] i,
    .site-theme button[type="submit"] .fas {
        color: #faf7f2 !important;
    }
    .site-theme .site-menu-btn {
        border: 1px solid #d5cec2 !important;
        border-radius: 9999px !important;
        background: #fff !important;
        color: #1b1c1a;
        box-shadow: none !important;
    }
    .site-theme .site-menu-btn:hover,
    .site-theme .site-menu-btn:focus {
        border-color: #b36855 !important;
        box-shadow: 0 0 0 3px rgba(179, 104, 85, 0.18) !important;
    }
    .site-theme .site-option:hover {
        background: rgba(179, 104, 85, 0.1);
    }
    .site-theme .site-option .text-\[\#D4AF37\],
    .site-theme .site-option i {
        color: #b36855 !important;
    }
    .legal-body > * + * { margin-top: 1.25rem; }
    .legal-body h2,
    .legal-body h3 {
        font-family: Poppins, "Plus Jakarta Sans", sans-serif;
        color: #111;
        font-weight: 600;
        line-height: 1.25;
        margin-top: 2rem;
    }
    .legal-body h2 { font-size: 1.5rem; }
    .legal-body h3 { font-size: 1.2rem; }
    .legal-body a { color: #89351d; text-decoration: underline; }
    .legal-body ul,
    .legal-body ol { padding-left: 1.25rem; }
    .legal-body ul { list-style: disc; }
    .legal-body ol { list-style: decimal; }
    .legal-body blockquote {
        border-left: 3px solid #b36855;
        padding-left: 1rem;
        color: #5f5e5e;
    }
    .legal-body strong,
    .legal-body b { font-weight: 700; color: #111; }

    .library-page {
        min-height: 100vh;
        padding: 128px 24px 80px;
        background: #fff;
        color: #111;
        font-family: "Plus Jakarta Sans", Inter, sans-serif;
    }
    .library-wrap { width: min(1180px, 100%); margin: 0 auto; }
    .library-article { width: min(760px, 100%); margin: 0 auto; }
    .library-page h1,
    .library-page h2,
    .library-page h3 {
        font-family: Poppins, "Plus Jakarta Sans", sans-serif;
        color: #111;
        letter-spacing: -0.02em;
    }
    .library-page h1 {
        margin: 0;
        font-size: clamp(36px, 5vw, 56px);
        font-weight: 600;
        line-height: 1.1;
    }
    .library-lead {
        max-width: 680px;
        margin: 16px auto 0;
        color: #5f5e5e;
        font-size: 17px;
        line-height: 1.65;
    }
    .library-pills {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
        margin: 36px 0 32px;
    }
    .library-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 43px;
        padding: 0 21px;
        border: 1px solid #d5cec2;
        border-radius: 9999px;
        background: transparent;
        color: #59554f;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        text-decoration: none;
        cursor: pointer;
    }
    .library-pill.is-active {
        border-color: #2a2929;
        background: #2a2929;
        color: #faf7f2;
        font-weight: 600;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.12), 0 2px 4px -2px rgba(0, 0, 0, 0.43);
    }
    .library-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }
    @media (min-width: 768px) {
        .library-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (min-width: 1024px) {
        .library-grid.cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    .library-card {
        display: flex;
        flex-direction: column;
        min-width: 0;
        overflow: hidden;
        border-radius: 24px;
        background: #fbf9f6;
        color: #1b1c1a;
        text-decoration: none;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .library-media {
        position: relative;
        display: block;
        aspect-ratio: 563.333 / 253.424;
        overflow: hidden;
        background: #eae8e5;
        cursor: pointer;
    }
    .library-media img,
    .library-media video {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .library-play {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.12));
        cursor: pointer;
    }
    .library-play span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #b36855;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.28);
    }
    .library-play i { margin-left: 3px; color: #faf7f2; font-size: 18px; }
    .library-chip,
    .research-chip {
        display: inline-flex;
        align-items: center;
        margin: 0;
        padding: 4px 12px;
        border-radius: 9999px;
        background: rgba(251, 249, 246, 0.9);
        color: #89351d;
        font-family: "Space Grotesk", sans-serif;
        font-size: 10px;
        font-weight: 700;
        line-height: 14px;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
    }
    .library-chip {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 3;
        pointer-events: none;
    }
    .library-flag {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
        padding: 4px 10px;
        border-radius: 9999px;
        background: #b36855;
        color: #faf7f2;
        font-family: "Space Grotesk", sans-serif;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .library-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 12px;
        padding: 24px;
    }
    .library-date,
    .library-meta {
        margin: 0;
        color: #5f5e5e;
        font-family: "Space Grotesk", sans-serif;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }
    .library-card h3 {
        margin: 0;
        color: #1b1c1a;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 22px;
        font-weight: 600;
        line-height: 28px;
        letter-spacing: 0;
    }
    .library-excerpt {
        display: -webkit-box;
        margin: 0;
        overflow: hidden;
        color: #5f5e5e;
        font-size: 16px;
        line-height: 22px;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }
    .library-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: auto;
    }
    .library-read {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0;
        border: 0;
        background: transparent;
        color: #89351d;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1.32px;
        line-height: 16px;
        text-decoration: none;
        text-transform: uppercase;
        cursor: pointer;
    }
    .library-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border: 1px solid #d5cec2;
        border-radius: 9999px;
        background: #fff;
        color: #89351d;
        text-decoration: none;
        cursor: pointer;
    }
    .library-search {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 8px;
    }
    .library-search input,
    .library-field {
        width: 100%;
        min-height: 48px;
        padding: 12px 16px;
        border: 1px solid #d5cec2;
        border-radius: 12px;
        background: #fff;
        color: #1b1c1a;
        font-family: "Plus Jakarta Sans", Inter, sans-serif;
    }
    .library-search input { flex: 1; min-width: 220px; }
    .library-search input:focus,
    .library-field:focus {
        outline: none;
        border-color: #b36855;
        box-shadow: 0 0 0 3px rgba(179, 104, 85, 0.18);
    }
    .library-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 48px;
        padding: 0 22px;
        border: 0;
        border-radius: 9999px;
        background: #b36855;
        color: #faf7f2;
        font-family: "Plus Jakarta Sans", sans-serif;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.12), 0 2px 4px -2px rgba(0, 0, 0, 0.43);
    }
    .library-cta.block { width: 100%; min-height: 56px; justify-content: space-between; }
    .library-ghost {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 0 18px;
        border: 1px solid #d5cec2;
        border-radius: 9999px;
        background: #fff;
        color: #59554f;
        text-decoration: none;
    }
    .library-back { margin-top: 48px; text-align: center; color: #5f5e5e; }
    .library-back a { color: #89351d; font-weight: 700; text-decoration: none; }
    .library-empty { grid-column: 1 / -1; padding: 48px 16px; text-align: center; color: #5f5e5e; }
    .research-card.is-hidden { display: none !important; }
    .library-page .pagination { display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; margin-top: 40px; }
    .library-page .pagination .page-link {
        padding: 8px 14px;
        border: 1px solid #d5cec2;
        border-radius: 9999px;
        background: #fff;
        color: #59554f;
        text-decoration: none;
    }
    .library-page .pagination .page-link:hover { border-color: #b36855; color: #89351d; }
    .library-page .pagination .active .page-link { background: #2a2929; border-color: #2a2929; color: #faf7f2; }
    .library-page .pagination .disabled .page-link { opacity: 0.45; pointer-events: none; }
    .library-panel {
        margin-top: 16px;
        padding: 24px;
        border: 1px solid #efeeeb;
        border-radius: 24px;
        background: #fbf9f6;
    }
    .library-avatar {
        display: flex;
        flex: none;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 9999px;
        background: #89351d;
        color: #faf7f2;
        font-weight: 700;
    }
    .library-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 24px; }
    .library-tags span {
        padding: 6px 12px;
        border-radius: 9999px;
        background: #fbf9f6;
        color: #89351d;
        font-size: 13px;
    }

    .research-modal-panel {
        background: #fff;
        border-radius: 28px;
        color: #1b1c1a;
        font-family: "Plus Jakarta Sans", Inter, sans-serif;
    }
    .research-close {
        position: sticky;
        top: 16px;
        z-index: 2;
        float: right;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        margin: 16px 16px 0 12px;
        border: 1px solid #efeeeb;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.95);
        color: #59554f;
        cursor: pointer;
    }
    .research-close:hover { color: #89351d; border-color: #b36855; }
    .research-detail { padding: 8px 28px 32px; }
    .research-detail-title {
        margin: 8px 48px 18px 0;
        color: #111;
        font-family: Poppins, "Plus Jakarta Sans", sans-serif;
        font-size: clamp(28px, 4vw, 40px);
        font-weight: 600;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }
    .research-detail-media {
        margin: 0 0 22px;
        overflow: hidden;
        border-radius: 18px;
        background: #111;
    }
    .research-detail-media img,
    .research-detail-media video,
    .research-detail-media iframe {
        display: block;
        width: 100%;
        max-height: 420px;
        object-fit: cover;
    }
    .research-detail-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
    }
    .research-kicker {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 10px;
        color: #89351d;
        font-family: "Space Grotesk", sans-serif;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1.1px;
        line-height: 16px;
        text-transform: uppercase;
    }
    .research-kicker span { width: 24px; height: 2px; background: #89351d; flex: none; }
    .research-detail-copy {
        margin: 0;
        color: #5f5e5e;
        font-size: 16px;
        line-height: 1.7;
    }
    .research-block + .research-block { margin-top: 22px; }
    .research-rich h2,
    .research-rich h3 {
        margin: 1.2rem 0 0.5rem;
        color: #111;
        font-family: Poppins, "Plus Jakarta Sans", sans-serif;
        font-weight: 600;
        letter-spacing: -0.02em;
    }
    .research-rich p { margin: 0 0 0.8rem; }
    .research-rich a { color: #89351d; }
    .research-rich ul, .research-rich ol { margin: 0 0 0.8rem; padding-left: 1.25rem; }
    .research-link { margin-top: 22px; }
    #researchDetailContent::-webkit-scrollbar { width: 6px; }
    #researchDetailContent::-webkit-scrollbar-thumb { background: #b36855; border-radius: 999px; }
</style>
