<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velora Group — Company</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --purple: #696cff;
            --purple-dark: #4a4dcc;
            --purple-glow: rgba(105, 108, 255, 0.35);
            --gold: #f0c060;
            --bg: #07070f;
            --bg2: #0d0d1a;
            --bg3: #121220;
            --glass: rgba(105, 108, 255, 0.06);
            --glass-border: rgba(105, 108, 255, 0.18);
            --text: #f0f0ff;
            --text-muted: #7a7a9a;
            --text-dim: #3a3a5a;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            cursor: none;
        }

        /* ── CURSOR ── */
        #cursor-dot {
            width: 8px; height: 8px;
            background: var(--purple);
            border-radius: 50%;
            position: fixed; top: 0; left: 0;
            pointer-events: none; z-index: 9999;
            transform: translate(-50%, -50%);
            transition: transform 0.1s;
        }
        #cursor-ring {
           width: 22px; height: 22px;
            border: 1.5px solid var(--purple-glow);
            border-radius: 50%;
            position: fixed; top: 0; left: 0;
            pointer-events: none; z-index: 9998;
            transform: translate(-50%, -50%);
            transition: all 0.12s ease;
        }
        #cursor-glow {
            width: 300px; height: 300px;
            background: radial-gradient(circle, var(--purple-glow) 0%, transparent 70%);
            border-radius: 50%;
            position: fixed; top: 0; left: 0;
            pointer-events: none; z-index: 9990;
            transform: translate(-50%, -50%);
            transition: all 0.25s ease;
            opacity: 0.5;
        }

        /* ── NAV ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.2rem 4rem;
            background: rgba(7, 7, 15, 0.7);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
        }
        .nav-logo {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none;
        }
        .nav-logo img { height: 32px; }
        .nav-logo span {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem; color: var(--text);
            letter-spacing: 0.04em;
        }
        .nav-links { display: flex; gap: 2rem; align-items: center; }
        .nav-links a {
            color: var(--text-muted); text-decoration: none;
            font-size: 0.85rem; letter-spacing: 0.05em;
            transition: color 0.3s;
        }
        .nav-links a:hover { color: var(--purple); }
        .nav-cta {
            background: var(--purple);
            color: #fff !important;
            padding: 0.5rem 1.4rem;
            border-radius: 50px;
            font-size: 0.82rem !important;
            transition: box-shadow 0.3s, transform 0.2s !important;
        }
        .nav-cta:hover {
            box-shadow: 0 0 20px var(--purple-glow);
            transform: translateY(-1px);
            color: #fff !important;
        }

        /* ── HERO ── */
        #hero {
            min-height: 100vh;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center;
            padding: 8rem 2rem 4rem;
            position: relative; overflow: hidden;
        }
        .hero-bg-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(105,108,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(105,108,255,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);
        }
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .orb1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(105,108,255,0.25) 0%, transparent 70%);
            top: -100px; left: 50%; transform: translateX(-50%);
            animation: orb-float 8s ease-in-out infinite;
        }
        .orb2 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(240,192,96,0.1) 0%, transparent 70%);
            bottom: 100px; right: 5%;
            animation: orb-float 10s ease-in-out infinite reverse;
        }
        @keyframes orb-float {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-30px); }
        }
        .hero-eyebrow {
            font-size: 0.75rem; letter-spacing: 0.25em;
            color: var(--purple); text-transform: uppercase;
            margin-bottom: 1.5rem;
            opacity: 0; animation: fade-up 0.8s 0.2s forwards;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 8vw, 7rem);
            line-height: 1.05;
            background: linear-gradient(135deg, #ffffff 0%, #c8c8ff 50%, var(--purple) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            opacity: 0; animation: fade-up 0.8s 0.4s forwards;
        }
        .hero-sub {
            font-size: 1.1rem; color: var(--text-muted);
            max-width: 560px; line-height: 1.7;
            margin-bottom: 3rem;
            opacity: 0; animation: fade-up 0.8s 0.6s forwards;
        }
        .hero-btns {
            display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;
            opacity: 0; animation: fade-up 0.8s 0.8s forwards;
        }
        .btn-primary {
            background: var(--purple);
            color: #fff; padding: 0.85rem 2.2rem;
            border-radius: 50px; font-size: 0.9rem;
            text-decoration: none; font-weight: 500;
            transition: box-shadow 0.3s, transform 0.2s;
            border: none; cursor: none;
        }
        .btn-primary:hover {
            box-shadow: 0 0 30px var(--purple-glow), 0 0 60px rgba(105,108,255,0.2);
            transform: translateY(-2px);
        }
        .btn-ghost {
            background: transparent;
            color: var(--text-muted); padding: 0.85rem 2.2rem;
            border-radius: 50px; font-size: 0.9rem;
            text-decoration: none; font-weight: 400;
            border: 1px solid var(--glass-border);
            transition: border-color 0.3s, color 0.3s;
            cursor: none;
        }
        .btn-ghost:hover { border-color: var(--purple); color: var(--text); }
        .scroll-indicator {
            position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            opacity: 0; animation: fade-up 1s 1.2s forwards;
        }
        .scroll-indicator span { font-size: 0.7rem; letter-spacing: 0.15em; color: var(--text-dim); }
        .scroll-line {
            width: 1px; height: 50px;
            background: linear-gradient(to bottom, var(--purple), transparent);
            animation: scroll-pulse 2s ease-in-out infinite;
        }
        @keyframes scroll-pulse {
            0%, 100% { opacity: 0.3; transform: scaleY(1); }
            50% { opacity: 1; transform: scaleY(1.2); }
        }
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── STATS ── */
        #stats {
            padding: 5rem 4rem;
            background: var(--bg2);
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem; max-width: 1000px; margin: 0 auto;
        }
        .stat-card {
            text-align: center;
            padding: 2rem 1rem;
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            background: var(--glass);
            transition: border-color 0.3s, transform 0.3s;
            position: relative; overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 60%; height: 1px;
            background: linear-gradient(90deg, transparent, var(--purple), transparent);
        }
        .stat-card:hover { border-color: var(--purple); transform: translateY(-4px); }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem; font-weight: 700;
            color: var(--purple);
            line-height: 1;
        }
        .stat-suffix { font-size: 1.5rem; color: var(--gold); }
        .stat-label {
            font-size: 0.75rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: var(--text-muted);
            margin-top: 0.5rem;
        }

        /* ── SECTION HEADERS ── */
        .section-header {
            text-align: center; margin-bottom: 4rem;
        }
        .section-eyebrow {
            font-size: 0.7rem; letter-spacing: 0.25em;
            color: var(--purple); text-transform: uppercase;
            margin-bottom: 1rem; display: block;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            background: linear-gradient(135deg, #fff 0%, #c8c8ff 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .section-line {
            width: 60px; height: 2px;
            background: linear-gradient(90deg, var(--purple), var(--gold));
            margin: 1.5rem auto 0;
            border-radius: 2px;
        }

        /* ── SHOWROOMS ── */
        #showrooms { padding: 6rem 4rem; }
        .showrooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem; max-width: 1100px; margin: 0 auto;
        }
        .showroom-card {
            background: var(--bg3);
            border: 1px solid var(--glass-border);
            border-radius: 20px; overflow: hidden;
            transition: transform 0.4s, box-shadow 0.4s, border-color 0.3s;
            position: relative;
        }
        .showroom-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(105,108,255,0.15);
            border-color: var(--purple);
        }
        .showroom-card-top {
            padding: 2rem 2rem 1.5rem;
            border-bottom: 1px solid var(--glass-border);
            position: relative;
        }
        .showroom-number {
            position: absolute; top: 1.5rem; right: 1.5rem;
            font-size: 4rem; font-weight: 900;
            color: rgba(105,108,255,0.08);
            font-family: 'Playfair Display', serif;
            line-height: 1;
            user-select: none;
        }
        .showroom-icon {
            width: 48px; height: 48px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin-bottom: 1rem;
        }
        .showroom-name {
            font-size: 1.3rem; font-weight: 600;
            color: var(--text); margin-bottom: 0.25rem;
        }
        .showroom-city {
            font-size: 0.82rem; color: var(--purple);
            letter-spacing: 0.08em;
        }
        .showroom-card-body { padding: 1.5rem 2rem 2rem; }
        .showroom-info-row {
            display: flex; align-items: center; gap: 10px;
            font-size: 0.82rem; color: var(--text-muted);
            margin-bottom: 0.8rem;
        }
        .showroom-info-row i { color: var(--purple); font-size: 1rem; }
        .branches-label {
            font-size: 0.7rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: var(--text-dim);
            margin: 1.2rem 0 0.8rem;
        }
        .branch-pills { display: flex; flex-wrap: wrap; gap: 8px; }
        .branch-pill {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 50px; padding: 0.3rem 0.9rem;
            font-size: 0.75rem; color: var(--text-muted);
            transition: border-color 0.2s, color 0.2s;
        }
        .branch-pill:hover { border-color: var(--purple); color: var(--purple); }
        .showroom-actions {
            display: flex; gap: 8px; margin-top: 1.5rem;
        }
        .btn-sm {
            padding: 0.45rem 1rem; border-radius: 50px;
            font-size: 0.75rem; font-weight: 500;
            text-decoration: none; cursor: none;
            transition: all 0.2s; border: none;
        }
        .btn-sm-primary {
            background: var(--purple); color: #fff;
        }
        .btn-sm-primary:hover { box-shadow: 0 0 16px var(--purple-glow); }
        .btn-sm-ghost {
            background: var(--glass); color: var(--text-muted);
            border: 1px solid var(--glass-border);
        }
        .btn-sm-ghost:hover { border-color: var(--purple); color: var(--purple); }

        /* ── TEAM ── */
        #team {
            padding: 6rem 4rem;
            background: var(--bg2);
            border-top: 1px solid var(--glass-border);
        }
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem; max-width: 1100px; margin: 0 auto;
        }
        .team-card {
            background: var(--bg3);
            border: 1px solid var(--glass-border);
            border-radius: 16px; padding: 1.8rem;
            text-align: center;
            transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
            position: relative; overflow: hidden;
        }
        .team-card::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, var(--purple), var(--gold));
            transform: scaleX(0); transition: transform 0.3s;
        }
        .team-card:hover { transform: translateY(-6px); border-color: var(--purple); box-shadow: 0 16px 40px rgba(105,108,255,0.12); }
        .team-card:hover::after { transform: scaleX(1); }
        .team-avatar {
            width: 64px; height: 64px; border-radius: 50%;
            background: var(--glass); border: 2px solid var(--glass-border);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin: 0 auto 1rem;
            font-family: 'Playfair Display', serif;
            color: var(--purple); font-weight: 700;
            transition: border-color 0.3s;
        }
        .team-card:hover .team-avatar { border-color: var(--purple); }
        .team-role {
            font-size: 0.7rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: var(--purple);
            margin-bottom: 0.4rem;
        }
        .team-name {
            font-size: 1rem; font-weight: 500; color: var(--text);
            margin-bottom: 0.3rem;
        }
        .team-branch {
            font-size: 0.78rem; color: var(--text-muted);
        }
        .team-contact {
            margin-top: 1rem; padding-top: 1rem;
            border-top: 1px solid var(--glass-border);
            font-size: 0.75rem; color: var(--text-dim);
        }

        /* ── STORY TIMELINE ── */
        #story { padding: 6rem 4rem; }
        .timeline {
            max-width: 800px; margin: 0 auto;
            position: relative;
        }
        .timeline::before {
            content: '';
            position: absolute; left: 50%; top: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, var(--purple), transparent);
            transform: translateX(-50%);
        }
        .timeline-item {
            display: flex; gap: 3rem;
            margin-bottom: 4rem;
            align-items: center;
        }
        .timeline-item:nth-child(even) { flex-direction: row-reverse; }
        .timeline-content {
            flex: 1;
            background: var(--bg3);
            border: 1px solid var(--glass-border);
            border-radius: 16px; padding: 1.8rem;
            transition: border-color 0.3s, transform 0.3s;
        }
        .timeline-content:hover { border-color: var(--purple); transform: scale(1.02); }
        .timeline-year {
            font-size: 0.7rem; letter-spacing: 0.2em;
            color: var(--purple); margin-bottom: 0.6rem;
        }
        .timeline-heading {
            font-size: 1.1rem; font-weight: 600; color: var(--text);
            margin-bottom: 0.5rem;
        }
        .timeline-text { font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; }
        .timeline-dot {
            width: 14px; height: 14px; border-radius: 50%;
            background: var(--purple);
            box-shadow: 0 0 0 4px rgba(105,108,255,0.2);
            flex-shrink: 0;
            position: relative; z-index: 1;
        }
        .timeline-spacer { flex: 1; }

        /* ── CHAIRWOMAN PANEL ── */
        #chairwoman-panel {
            padding: 4rem;
            background: linear-gradient(135deg, rgba(105,108,255,0.08), rgba(240,192,96,0.04));
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
        }
        .panel-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(105,108,255,0.15);
            border: 1px solid var(--purple);
            border-radius: 50px; padding: 0.4rem 1rem;
            font-size: 0.75rem; color: var(--purple);
            letter-spacing: 0.08em; margin-bottom: 2rem;
        }
        .mgmt-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem; max-width: 900px;
        }
        .mgmt-card {
            background: var(--bg3);
            border: 1px solid var(--glass-border);
            border-radius: 12px; padding: 1.4rem;
            text-decoration: none;
            transition: all 0.3s;
            display: flex; flex-direction: column; gap: 8px;
        }
        .mgmt-card:hover { border-color: var(--purple); transform: translateY(-3px); box-shadow: 0 10px 30px rgba(105,108,255,0.1); }
        .mgmt-icon { font-size: 1.5rem; color: var(--purple); }
        .mgmt-title { font-size: 0.9rem; font-weight: 500; color: var(--text); }
        .mgmt-desc { font-size: 0.75rem; color: var(--text-muted); }

        /* ── CONTACT ── */
        #contact {
            padding: 6rem 4rem;
            background: var(--bg2);
            border-top: 1px solid var(--glass-border);
        }
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem; max-width: 1000px; margin: 0 auto;
        }
        .contact-card {
            background: var(--bg3);
            border: 1px solid var(--glass-border);
            border-radius: 16px; padding: 2rem;
            transition: border-color 0.3s, transform 0.3s;
        }
        .contact-card:hover { border-color: var(--purple); transform: translateY(-4px); }
        .contact-card-name {
            font-size: 1.1rem; font-weight: 600; color: var(--text);
            margin-bottom: 1.2rem; padding-bottom: 1rem;
            border-bottom: 1px solid var(--glass-border);
        }
        .contact-row {
            display: flex; align-items: flex-start; gap: 10px;
            font-size: 0.82rem; color: var(--text-muted);
            margin-bottom: 0.8rem;
        }
        .contact-row i { color: var(--purple); font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

        /* ── FOOTER ── */
        footer {
            padding: 2rem 4rem;
            border-top: 1px solid var(--glass-border);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 1rem;
        }
        .footer-logo {
            display: flex; align-items: center; gap: 10px;
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; color: var(--text);
        }
        .footer-logo img { height: 24px; }
        .footer-copy { font-size: 0.75rem; color: var(--text-dim); }
        .footer-links { display: flex; gap: 1.5rem; }
        .footer-links a {
            font-size: 0.78rem; color: var(--text-muted);
            text-decoration: none; transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--purple); }

        /* ── SCROLL REVEAL ── */
        .reveal {
            opacity: 0; transform: translateY(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        @media (max-width: 768px) {
            nav { padding: 1rem 1.5rem; }
            #hero, #showrooms, #team, #story, #contact, #stats, #chairwoman-panel { padding: 4rem 1.5rem; }
            .timeline::before { left: 20px; }
            .timeline-item, .timeline-item:nth-child(even) { flex-direction: column; padding-left: 3rem; }
            .timeline-dot { position: absolute; left: 14px; }
            footer { padding: 2rem 1.5rem; flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

{{-- CURSOR --}}
<div id="cursor-dot"></div>
<div id="cursor-ring"></div>
<div id="cursor-glow"></div>

{{-- NAV --}}
<nav>
    <a href="{{ url('/') }}" class="nav-logo">
        <img src="{{ asset('assets/img/logo/velora_logo.svg') }}" alt="Velora">
        <span>Velora</span>
    </a>
    <div class="nav-links">
        <a href="#showrooms" class="nav-anchor">Showrooms</a>
        <a href="#team" class="nav-anchor">Team</a>
        <a href="#vlogs" class="nav-anchor">Vlogs</a>
        <a href="#story" class="nav-anchor">Story</a>
        <a href="#contact" class="nav-anchor">Contact</a>
        @auth
            <a href="{{ url('/dashboard') }}" class="nav-cta">Dashboard</a>
        @else
            <a href="{{ url('/login') }}" class="nav-cta">Sign In</a>
        @endauth
    </div>
</nav>

{{-- HERO --}}
<section id="hero">
    <div class="hero-bg-grid"></div>
    <div class="hero-orb orb1"></div>
    <div class="hero-orb orb2"></div>

    <p class="hero-eyebrow">Pakistan's Premier Automotive Group</p>
    <h1 class="hero-title">Velora Group</h1>
    <p class="hero-sub">
        Redefining the vehicle ownership experience through innovation,
        integrity, and an uncompromising standard of excellence.
    </p>
    <div class="hero-btns">
        <a href="#showrooms" class="btn-primary">Explore Showrooms</a>
        <a href="#story" class="btn-ghost">Our Story</a>
    </div>
    <div class="scroll-indicator">
        <span>SCROLL</span>
        <div class="scroll-line"></div>
    </div>
</section>

{{-- STATS --}}
<section id="stats">
    <div class="stats-grid">
        <div class="stat-card reveal">
            <div class="stat-num" data-target="{{ $stats['showrooms'] }}">0</div>
            <div class="stat-label">Showrooms</div>
        </div>
        <div class="stat-card reveal reveal-delay-1">
            <div class="stat-num" data-target="{{ $stats['branches'] }}">0</div>
            <div class="stat-label">Branches</div>
        </div>
        <div class="stat-card reveal reveal-delay-2">
            <div class="stat-num" data-target="{{ $stats['vehicles'] }}">0</div>
            <div class="stat-label">Vehicles</div>
        </div>
        <div class="stat-card reveal reveal-delay-3">
            <div class="stat-num" data-target="{{ $stats['sales'] }}">0</div>
            <div class="stat-label">Sales Completed</div>
        </div>
        <div class="stat-card reveal reveal-delay-4">
            <div class="stat-num" data-target="{{ $stats['staff'] }}">0</div>
            <div class="stat-label">Team Members</div>
        </div>
    </div>
</section>

{{-- MOVING VEHICLES SHOWCASE --}}
<section id="vehicles-road" style="padding: 5rem 0; background: var(--bg2); border-top: 1px solid var(--glass-border); border-bottom: 1px solid var(--glass-border); overflow: hidden;">
    <div style="text-align:center; margin-bottom: 3rem;">
        <span style="font-size: 0.7rem; letter-spacing: 0.25em; color: var(--purple); text-transform: uppercase; display:block; margin-bottom: 0.8rem;">Our Fleet</span>
        <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 3vw, 2.5rem); background: linear-gradient(135deg, #fff 0%, #c8c8ff 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Vehicles Across Our Network</h2>
        <div style="width: 60px; height: 2px; background: linear-gradient(90deg, var(--purple), var(--gold)); margin: 1rem auto 0; border-radius: 2px;"></div>
    </div>

    {{-- ROAD SECTION --}}
    <div class="road-wrapper" style="position: relative; width: 100%; overflow: hidden;">

        {{-- Road background --}}
        <div style="position: relative; width: 100%; height: 220px; background: linear-gradient(to bottom, #0a0a14 0%, #111122 40%, #0d0d1a 100%);">

            {{-- Road surface --}}
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 90px; background: #1a1a2e; border-top: 2px solid rgba(105,108,255,0.3);">
                {{-- Road dashes --}}
                <div class="road-dashes" style="position: absolute; top: 44px; left: 0; right: 0; height: 3px; overflow: hidden;">
                    <div style="display: flex; gap: 0; width: 200%; animation: dash-move 3s linear infinite;">
                        @for($i = 0; $i < 40; $i++)
                        <div style="width: 60px; height: 3px; background: var(--gold); margin-right: 60px; flex-shrink: 0; opacity: 0.6; border-radius: 2px;"></div>
                        @endfor
                    </div>
                </div>
                {{-- Road edge lines --}}
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 2px; background: rgba(255,255,255,0.08);"></div>
                <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: rgba(255,255,255,0.05);"></div>
            </div>

            {{-- Stars / sky --}}
            @for($i = 0; $i < 20; $i++)
            <div style="position: absolute; width: {{ rand(1,2) }}px; height: {{ rand(1,2) }}px; background: white; border-radius: 50%; top: {{ rand(5, 55) }}%; left: {{ rand(0, 100) }}%; opacity: {{ rand(2,6)/10 }};"></div>
            @endfor

            {{-- VEHICLES LANE --}}
            <div style="position: absolute; bottom: 8px; left: 0; right: 0; height: 70px; display: flex; align-items: center;">

                {{-- Vehicle 1 — Toyota Yaris --}}
                <div class="vehicle-move v1" style="position: absolute; bottom: 12px; display: flex; flex-direction: column; align-items: center; animation: car-move1 12s linear infinite;">
                    <div style="font-size: 0.6rem; color: var(--purple); letter-spacing: 0.1em; margin-bottom: 4px; white-space: nowrap; opacity: 0.9;">TOYOTA YARIS</div>
                    <div style="position: relative;">
                        <svg width="90" height="38" viewBox="0 0 90 38">
                            <rect x="10" y="18" width="70" height="16" rx="4" fill="#696cff"/>
                            <rect x="18" y="8" width="45" height="14" rx="5" fill="#4a4dcc"/>
                            <rect x="22" y="10" width="12" height="9" rx="2" fill="rgba(150,200,255,0.4)"/>
                            <rect x="37" y="10" width="12" height="9" rx="2" fill="rgba(150,200,255,0.4)"/>
                            <rect x="52" y="10" width="8" height="9" rx="2" fill="rgba(150,200,255,0.3)"/>
                            <circle cx="22" cy="34" r="6" fill="#222" stroke="#555" stroke-width="1.5"/>
                            <circle cx="22" cy="34" r="3" fill="#444"/>
                            <circle cx="68" cy="34" r="6" fill="#222" stroke="#555" stroke-width="1.5"/>
                            <circle cx="68" cy="34" r="3" fill="#444"/>
                            <rect x="10" y="22" width="6" height="4" rx="1" fill="#f0c060" opacity="0.9"/>
                            <rect x="74" y="22" width="6" height="4" rx="1" fill="#ff4444" opacity="0.7"/>
                            <ellipse cx="14" cy="24" rx="8" ry="3" fill="rgba(240,192,96,0.15)" transform="rotate(180 14 24)"/>
                        </svg>
                        {{-- Ground shadow --}}
                        <div style="width: 80px; height: 4px; background: radial-gradient(ellipse, rgba(105,108,255,0.4) 0%, transparent 70%); margin: 0 auto; margin-top: -2px;"></div>
                    </div>
                </div>

                {{-- Vehicle 2 — Toyota Corolla --}}
                <div class="vehicle-move v2" style="position: absolute; bottom: 12px; display: flex; flex-direction: column; align-items: center; animation: car-move2 16s linear infinite; animation-delay: -6s;">
                    <div style="font-size: 0.6rem; color: var(--gold); letter-spacing: 0.1em; margin-bottom: 4px; white-space: nowrap; opacity: 0.9;">TOYOTA COROLLA</div>
                    <div style="position: relative;">
                        <svg width="96" height="38" viewBox="0 0 96 38">
                            <rect x="8" y="18" width="80" height="16" rx="4" fill="#c8960a"/>
                            <rect x="16" y="8" width="52" height="14" rx="5" fill="#a07808"/>
                            <rect x="20" y="10" width="14" height="9" rx="2" fill="rgba(150,200,255,0.4)"/>
                            <rect x="38" y="10" width="14" height="9" rx="2" fill="rgba(150,200,255,0.4)"/>
                            <rect x="55" y="10" width="9" height="9" rx="2" fill="rgba(150,200,255,0.3)"/>
                            <circle cx="24" cy="34" r="6" fill="#222" stroke="#555" stroke-width="1.5"/>
                            <circle cx="24" cy="34" r="3" fill="#444"/>
                            <circle cx="72" cy="34" r="6" fill="#222" stroke="#555" stroke-width="1.5"/>
                            <circle cx="72" cy="34" r="3" fill="#444"/>
                            <rect x="8" y="22" width="6" height="4" rx="1" fill="#f0c060" opacity="0.9"/>
                            <rect x="82" y="22" width="6" height="4" rx="1" fill="#ff4444" opacity="0.7"/>
                            <ellipse cx="12" cy="24" rx="10" ry="3" fill="rgba(240,192,96,0.12)" transform="rotate(180 12 24)"/>
                        </svg>
                        <div style="width: 86px; height: 4px; background: radial-gradient(ellipse, rgba(240,192,96,0.35) 0%, transparent 70%); margin: 0 auto; margin-top: -2px;"></div>
                    </div>
                </div>

                {{-- Vehicle 3 — Land Cruiser (SUV) --}}
                <div class="vehicle-move v3" style="position: absolute; bottom: 10px; display: flex; flex-direction: column; align-items: center; animation: car-move3 14s linear infinite; animation-delay: -3s;">
                    <div style="font-size: 0.6rem; color: #5dcaa5; letter-spacing: 0.1em; margin-bottom: 4px; white-space: nowrap; opacity: 0.9;">LAND CRUISER</div>
                    <div style="position: relative;">
                        <svg width="100" height="44" viewBox="0 0 100 44">
                            <rect x="5" y="18" width="90" height="22" rx="5" fill="#0e5e48"/>
                            <rect x="12" y="6" width="60" height="16" rx="5" fill="#0a4535"/>
                            <rect x="16" y="8" width="14" height="10" rx="2" fill="rgba(150,220,255,0.45)"/>
                            <rect x="34" y="8" width="14" height="10" rx="2" fill="rgba(150,220,255,0.45)"/>
                            <rect x="52" y="8" width="14" height="10" rx="2" fill="rgba(150,220,255,0.35)"/>
                            <circle cx="24" cy="40" r="7" fill="#1a1a1a" stroke="#444" stroke-width="2"/>
                            <circle cx="24" cy="40" r="3.5" fill="#333"/>
                            <circle cx="76" cy="40" r="7" fill="#1a1a1a" stroke="#444" stroke-width="2"/>
                            <circle cx="76" cy="40" r="3.5" fill="#333"/>
                            <rect x="5" y="24" width="7" height="5" rx="1" fill="#f0c060" opacity="0.9"/>
                            <rect x="88" y="24" width="7" height="5" rx="1" fill="#ff4444" opacity="0.7"/>
                            <rect x="72" y="14" width="20" height="5" rx="2" fill="#0a4535"/>
                            <ellipse cx="10" cy="28" rx="12" ry="4" fill="rgba(93,202,165,0.12)" transform="rotate(180 10 28)"/>
                        </svg>
                        <div style="width: 90px; height: 5px; background: radial-gradient(ellipse, rgba(93,202,165,0.35) 0%, transparent 70%); margin: 0 auto; margin-top: -2px;"></div>
                    </div>
                </div>

                {{-- Vehicle 4 — Hilux --}}
                <div class="vehicle-move v4" style="position: absolute; bottom: 10px; display: flex; flex-direction: column; align-items: center; animation: car-move4 18s linear infinite; animation-delay: -9s;">
                    <div style="font-size: 0.6rem; color: #e06060; letter-spacing: 0.1em; margin-bottom: 4px; white-space: nowrap; opacity: 0.9;">TOYOTA HILUX</div>
                    <div style="position: relative;">
                        <svg width="110" height="42" viewBox="0 0 110 42">
                            <rect x="5" y="20" width="100" height="18" rx="4" fill="#7a2020"/>
                            <rect x="10" y="10" width="44" height="14" rx="5" fill="#5a1818"/>
                            <rect x="14" y="12" width="14" height="9" rx="2" fill="rgba(150,200,255,0.4)"/>
                            <rect x="32" y="12" width="14" height="9" rx="2" fill="rgba(150,200,255,0.4)"/>
                            <rect x="55" y="14" width="48" height="10" rx="3" fill="#6a1818"/>
                            <circle cx="25" cy="38" r="7" fill="#1a1a1a" stroke="#444" stroke-width="2"/>
                            <circle cx="25" cy="38" r="3.5" fill="#333"/>
                            <circle cx="85" cy="38" r="7" fill="#1a1a1a" stroke="#444" stroke-width="2"/>
                            <circle cx="85" cy="38" r="3.5" fill="#333"/>
                            <rect x="5" y="25" width="7" height="5" rx="1" fill="#f0c060" opacity="0.9"/>
                            <rect x="98" y="25" width="7" height="5" rx="1" fill="#ff4444" opacity="0.7"/>
                            <ellipse cx="10" cy="28" rx="12" ry="4" fill="rgba(240,96,96,0.1)" transform="rotate(180 10 28)"/>
                        </svg>
                        <div style="width: 100px; height: 5px; background: radial-gradient(ellipse, rgba(220,80,80,0.3) 0%, transparent 70%); margin: 0 auto; margin-top: -2px;"></div>
                    </div>
                </div>

            </div>
            {{-- /vehicles lane --}}

        </div>
        {{-- /road --}}

    </div>
    {{-- /road wrapper --}}

</section>

<style>
@keyframes dash-move {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
@keyframes car-move1 {
    0%   { left: -120px; }
    100% { left: 110%; }
}
@keyframes car-move2 {
    0%   { left: -130px; }
    100% { left: 110%; }
}
@keyframes car-move3 {
    0%   { left: -140px; }
    100% { left: 110%; }
}
@keyframes car-move4 {
    0%   { left: -150px; }
    100% { left: 110%; }
}
</style>

{{-- CINEMATIC VEHICLE SHOWCASE --}}
<section id="vehicles-road" style="position:relative; width:100%; height:100vh; background:#07070f; overflow:hidden; display:flex; flex-direction:column; align-items:center; justify-content:center;">

    {{-- STARS --}}
    <div id="stars-layer" style="position:absolute;inset:0;pointer-events:none;"></div>

    {{-- CITY SILHOUETTE --}}
    <svg style="position:absolute;bottom:220px;left:0;right:0;width:100%;pointer-events:none;" height="160" viewBox="0 0 1440 160" preserveAspectRatio="none">
        <rect x="0" y="60" width="60" height="100" fill="#0d0d1a"/>
        <rect x="10" y="30" width="40" height="130" fill="#0d0d1a"/>
        <rect x="55" y="80" width="80" height="80" fill="#0a0a14"/>
        <rect x="70" y="50" width="50" height="110" fill="#0a0a14"/>
        <rect x="140" y="70" width="70" height="90" fill="#0d0d1a"/>
        <rect x="155" y="40" width="40" height="120" fill="#0d0d1a"/>
        <rect x="220" y="90" width="55" height="70" fill="#0a0a14"/>
        <rect x="230" y="60" width="35" height="100" fill="#0a0a14"/>
        <rect x="1200" y="60" width="60" height="100" fill="#0d0d1a"/>
        <rect x="1210" y="30" width="40" height="130" fill="#0d0d1a"/>
        <rect x="1260" y="80" width="80" height="80" fill="#0a0a14"/>
        <rect x="1275" y="50" width="50" height="110" fill="#0a0a14"/>
        <rect x="1340" y="70" width="70" height="90" fill="#0d0d1a"/>
        <rect x="1355" y="40" width="40" height="120" fill="#0d0d1a"/>
        <rect x="600" y="100" width="240" height="60" fill="#0a0a14"/>
        <rect x="650" y="70" width="140" height="90" fill="#0d0d1a"/>
        <rect x="680" y="40" width="80" height="120" fill="#0a0a14"/>
        {{-- Building windows --}}
        <rect x="18" y="40" width="6" height="8" fill="rgba(255,230,100,0.35)"/>
        <rect x="28" y="40" width="6" height="8" fill="rgba(105,108,255,0.4)"/>
        <rect x="18" y="56" width="6" height="8" fill="rgba(105,108,255,0.3)"/>
        <rect x="28" y="56" width="6" height="8" fill="rgba(255,230,100,0.5)"/>
        <rect x="663" y="52" width="8" height="10" fill="rgba(255,230,100,0.3)"/>
        <rect x="678" y="52" width="8" height="10" fill="rgba(105,108,255,0.4)"/>
        <rect x="693" y="52" width="8" height="10" fill="rgba(255,230,100,0.25)"/>
        <rect x="663" y="68" width="8" height="10" fill="rgba(105,108,255,0.5)"/>
        <rect x="693" y="68" width="8" height="10" fill="rgba(255,230,100,0.4)"/>
        <rect x="1218" y="40" width="6" height="8" fill="rgba(255,230,100,0.35)"/>
        <rect x="1228" y="56" width="6" height="8" fill="rgba(105,108,255,0.4)"/>
        <rect x="1363" y="52" width="8" height="10" fill="rgba(255,230,100,0.3)"/>
    </svg>

    {{-- ROAD --}}
    <div style="position:absolute;bottom:0;left:0;right:0;height:220px;">
        {{-- Road surface --}}
        <div style="position:absolute;bottom:0;left:0;right:0;height:220px;background:linear-gradient(180deg,#1a1a28 0%,#111118 100%);border-top:2px solid rgba(105,108,255,0.2);"></div>
        {{-- Road texture lines --}}
        <div style="position:absolute;bottom:0;left:0;right:0;height:220px;background:repeating-linear-gradient(90deg,transparent,transparent 3px,rgba(255,255,255,0.01) 3px,rgba(255,255,255,0.01) 4px);"></div>
        {{-- Center lane dashes --}}
        <div style="position:absolute;bottom:110px;left:0;right:0;height:4px;overflow:hidden;">
            <div id="dashLine" style="display:flex;width:400%;height:4px;animation:dashAnim 2s linear infinite;">
                @for($i=0;$i<60;$i++)
                <div style="width:80px;height:4px;background:#f0c060;opacity:0.5;border-radius:2px;margin-right:80px;flex-shrink:0;"></div>
                @endfor
            </div>
        </div>
        {{-- Road edge markings --}}
        <div style="position:absolute;bottom:195px;left:0;right:0;height:2px;background:rgba(255,255,255,0.06);"></div>
        <div style="position:absolute;bottom:18px;left:0;right:0;height:2px;background:rgba(255,255,255,0.04);"></div>
        {{-- Road purple glow --}}
        <div style="position:absolute;bottom:0;left:0;right:0;height:120px;background:radial-gradient(ellipse 60% 50% at 50% 100%,rgba(105,108,255,0.1),transparent);pointer-events:none;"></div>
    </div>

    {{-- PHASE LABEL --}}
    <div id="vr-label" style="position:absolute;top:32px;left:50%;transform:translateX(-50%);font-size:11px;letter-spacing:.2em;color:rgba(105,108,255,0.85);text-transform:uppercase;white-space:nowrap;background:rgba(7,7,15,0.85);padding:6px 20px;border-radius:20px;border:1px solid rgba(105,108,255,0.2);font-family:'Inter',sans-serif;transition:opacity 0.4s;">
        Velora Fleet
    </div>

    {{-- VEHICLE WRAPPER --}}
    <div id="vr-car" style="position:absolute;bottom:128px;left:-700px;transition:left 0s;width:420px;">

        {{-- SOLD BADGE --}}
        <div id="vr-sold" style="position:absolute;top:-60px;left:50%;transform:translateX(-50%) scale(0);background:linear-gradient(135deg,#696cff,#9155fd);color:#fff;font-size:20px;font-weight:700;letter-spacing:.12em;padding:10px 32px;border-radius:10px;box-shadow:0 0 40px rgba(105,108,255,0.7),0 0 80px rgba(105,108,255,0.3);transition:transform .6s cubic-bezier(.34,1.56,.64,1);white-space:nowrap;font-family:'Playfair Display',serif;">
            ✦ SOLD
        </div>

        {{-- PRICE TAG --}}
        <div id="vr-price" style="position:absolute;top:-36px;left:50%;transform:translateX(-50%);background:rgba(240,192,96,0.12);border:1px solid rgba(240,192,96,0.5);color:#f0c060;font-size:13px;font-weight:600;padding:5px 18px;border-radius:20px;opacity:0;transition:opacity .5s;white-space:nowrap;font-family:'Inter',sans-serif;letter-spacing:.05em;">
            Rs. 4,800,000
        </div>

        {{-- REAL CAR IMAGE --}}
        <div style="position:relative;">
            {{-- Headlight glow --}}
            <div id="vr-headlight" style="position:absolute;left:-60px;top:50%;transform:translateY(-50%);width:80px;height:40px;background:radial-gradient(ellipse,rgba(240,220,120,0.6) 0%,rgba(240,220,120,0.1) 50%,transparent 100%);border-radius:50%;opacity:0;transition:opacity 1s;pointer-events:none;"></div>
            {{-- Taillight glow --}}
            <div style="position:absolute;right:-40px;top:55%;transform:translateY(-50%);width:50px;height:25px;background:radial-gradient(ellipse,rgba(255,60,60,0.5) 0%,transparent 100%);border-radius:50%;pointer-events:none;"></div>
            {{-- Car image --}}
            <img id="vr-img"
                src="https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=700&q=85&auto=format"
                alt="Toyota vehicle"
                style="width:420px;height:auto;display:block;filter:brightness(0.95) saturate(1.1);border-radius:4px;position:relative;z-index:2;"
                onerror="this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=700&q=80&auto=format'"
            />
            {{-- Ground reflection --}}
            <div style="position:absolute;bottom:-18px;left:10%;right:10%;height:18px;background:radial-gradient(ellipse,rgba(105,108,255,0.25) 0%,transparent 70%);border-radius:50%;filter:blur(4px);z-index:1;"></div>
            {{-- Ground shadow --}}
            <div style="position:absolute;bottom:-22px;left:5%;right:5%;height:10px;background:radial-gradient(ellipse,rgba(0,0,0,0.6) 0%,transparent 70%);border-radius:50%;filter:blur(6px);"></div>
        </div>

        {{-- CAR NAME TAG --}}
        <div id="vr-nametag" style="text-align:center;margin-top:10px;opacity:0;transition:opacity .5s;">
            <span style="font-size:10px;letter-spacing:.2em;color:rgba(105,108,255,0.7);text-transform:uppercase;font-family:'Inter',sans-serif;">Toyota Corolla Altis</span>
        </div>
    </div>

    {{-- CUSTOMER --}}
    <div id="vr-customer" style="position:absolute;bottom:128px;right:80px;opacity:0;transition:opacity .6s;display:flex;flex-direction:column;align-items:center;gap:0;">
        {{-- Speech bubble --}}
        <div id="vr-bubble" style="background:rgba(105,108,255,0.15);border:1px solid rgba(105,108,255,0.4);color:#c8caff;font-size:11px;padding:6px 14px;border-radius:10px;white-space:nowrap;margin-bottom:8px;opacity:0;transition:opacity .4s;font-family:'Inter',sans-serif;letter-spacing:.03em;">
            I want this car!
        </div>
        {{-- Person SVG --}}
        <svg width="44" height="80" viewBox="0 0 44 80">
            <circle cx="22" cy="12" r="10" fill="#c8a882"/>
            <rect x="8" y="26" width="28" height="36" rx="6" fill="#696cff"/>
            <rect x="2" y="28" width="10" height="28" rx="5" fill="#c8a882"/>
            <rect x="32" y="28" width="10" height="28" rx="5" fill="#c8a882"/>
            <rect x="10" y="62" width="10" height="18" rx="4" fill="#2a2a4a"/>
            <rect x="24" y="62" width="10" height="18" rx="4" fill="#2a2a4a"/>
        </svg>
        <div style="font-size:9px;color:rgba(255,255,255,0.35);letter-spacing:.12em;margin-top:4px;font-family:'Inter',sans-serif;">CUSTOMER</div>
    </div>

    {{-- HANDSHAKE --}}
    <div id="vr-shake" style="position:absolute;bottom:200px;right:180px;font-size:32px;opacity:0;transform:scale(0);transition:all .5s cubic-bezier(.34,1.56,.64,1);">🤝</div>

    {{-- VELORA BADGE --}}
    <div style="position:absolute;bottom:24px;left:50%;transform:translateX(-50%);font-size:10px;letter-spacing:.2em;color:rgba(105,108,255,0.4);font-family:'Inter',sans-serif;text-transform:uppercase;">Velora VMS — Live Fleet</div>

    {{-- REPLAY BUTTON --}}
    <button id="vr-replay" onclick="vrStart()" style="position:absolute;bottom:20px;right:24px;background:rgba(105,108,255,0.12);border:1px solid rgba(105,108,255,0.3);color:#a8aaff;font-size:11px;padding:7px 18px;border-radius:20px;cursor:pointer;opacity:0;transition:all .3s;font-family:'Inter',sans-serif;letter-spacing:.06em;">
        ↺ Watch again
    </button>

</section>

<style>
@keyframes dashAnim {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}
</style>

<script>
(function(){
    // Stars
    const starsLayer = document.getElementById('stars-layer');
    if(starsLayer) {
        for(let i=0;i<80;i++){
            const s = document.createElement('div');
            const size = Math.random()*1.5+0.5;
            s.style.cssText = `position:absolute;width:${size}px;height:${size}px;border-radius:50%;background:#fff;left:${Math.random()*100}%;top:${Math.random()*60}%;opacity:${Math.random()*0.6+0.1};animation:twinkle ${2+Math.random()*3}s ease-in-out infinite;animation-delay:${Math.random()*3}s;`;
            starsLayer.appendChild(s);
        }
    }

    function label(txt, delay=0) {
        return new Promise(r => setTimeout(()=>{
            const el = document.getElementById('vr-label');
            if(el){ el.style.opacity='0'; setTimeout(()=>{ el.textContent=txt; el.style.opacity='1'; },300); }
            r();
        }, delay));
    }

    function show(id, delay=0) {
        return new Promise(r => setTimeout(()=>{
            const el = document.getElementById(id);
            if(el) el.style.opacity='1';
            r();
        }, delay));
    }

    function hide(id, delay=0) {
        return new Promise(r => setTimeout(()=>{
            const el = document.getElementById(id);
            if(el) el.style.opacity='0';
            r();
        }, delay));
    }

    window.vrStart = async function() {
        const car    = document.getElementById('vr-car');
        const sold   = document.getElementById('vr-sold');
        const price  = document.getElementById('vr-price');
        const cust   = document.getElementById('vr-customer');
        const bubble = document.getElementById('vr-bubble');
        const shake  = document.getElementById('vr-shake');
        const replay = document.getElementById('vr-replay');
        const light  = document.getElementById('vr-headlight');
        const nametag= document.getElementById('vr-nametag');

        // Reset
        replay.style.opacity = '0';
        car.style.transition  = 'none';
        car.style.left        = '-700px';
        sold.style.transform  = 'translateX(-50%) scale(0)';
        price.style.opacity   = '0';
        cust.style.opacity    = '0';
        bubble.style.opacity  = '0';
        bubble.textContent    = 'I want this car!';
        shake.style.opacity   = '0';
        shake.style.transform = 'scale(0)';
        light.style.opacity   = '0';
        nametag.style.opacity = '0';

        await new Promise(r=>setTimeout(r,200));

        // Phase 1 — drive in
        await label('Velora Fleet — Toyota Corolla Altis', 0);
        car.style.transition = 'left 3.5s cubic-bezier(.25,.46,.45,.94)';
        car.style.left = 'calc(50% - 210px)';
        light.style.opacity = '1';

        await new Promise(r=>setTimeout(r,1200));
        await show('vr-nametag');

        await new Promise(r=>setTimeout(r,2400));

        // Phase 2 — customer appears
        await label('Customer arriving...', 0);
        cust.style.opacity = '1';
        await new Promise(r=>setTimeout(r,700));
        bubble.style.opacity = '1';

        await new Promise(r=>setTimeout(r,1500));

        // Phase 3 — price shown
        await label('Negotiating price...', 0);
        price.style.opacity = '1';
        bubble.textContent = 'Deal! Let\'s do it!';

        await new Promise(r=>setTimeout(r,1400));

        // Phase 4 — handshake
        await label('Sale confirmed — updating Velora VMS...', 0);
        bubble.style.opacity = '0';
        shake.style.opacity  = '1';
        shake.style.transform = 'scale(1)';

        await new Promise(r=>setTimeout(r,900));

        // Phase 5 — SOLD
        price.style.opacity  = '0';
        sold.style.transform = 'translateX(-50%) scale(1)';

        await new Promise(r=>setTimeout(r,1400));

        // Phase 6 — drive off
        await label('Vehicle delivered. Record saved. ✦', 0);
        shake.style.opacity  = '0';
        cust.style.opacity   = '0';
        light.style.opacity  = '0';

        car.style.transition = 'left 2.2s ease-in';
        car.style.left       = '110%';

        await new Promise(r=>setTimeout(r,2400));
        replay.style.opacity = '1';
        await label('Velora Fleet', 0);
    };

    // Autostart
    setTimeout(window.vrStart, 600);
})();
</script>

{{-- SHOWROOMS --}}
<section id="showrooms">
    <div class="section-header reveal">
        <span class="section-eyebrow">Our Presence</span>
        <h2 class="section-title">Showrooms & Branches</h2>
        <div class="section-line"></div>
    </div>
    <div class="showrooms-grid">
        @foreach($showrooms as $i => $showroom)
        <div class="showroom-card reveal reveal-delay-{{ ($i % 4) + 1 }}">
            <div class="showroom-card-top">
                <div class="showroom-number">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="showroom-icon"><i class='bx bx-building-house'></i></div>
                <div class="showroom-name">{{ $showroom->name }}</div>
                <div class="showroom-city">{{ $showroom->city }}{{ $showroom->country ? ', ' . $showroom->country : '' }}</div>
            </div>
            <div class="showroom-card-body">
                @if($showroom->phone)
                <div class="showroom-info-row">
                    <i class='bx bx-phone'></i>
                    <span>{{ $showroom->phone }}</span>
                </div>
                @endif
                @if($showroom->email)
                <div class="showroom-info-row">
                    <i class='bx bx-envelope'></i>
                    <span>{{ $showroom->email }}</span>
                </div>
                @endif
                @if($showroom->address)
                <div class="showroom-info-row">
                    <i class='bx bx-map'></i>
                    <span>{{ $showroom->address }}</span>
                </div>
                @endif

                @if($showroom->branches->count() > 0)
                <div class="branches-label">Branches</div>
                <div class="branch-pills">
                    @foreach($showroom->branches as $branch)
                    <span class="branch-pill">
                        <i class='bx bx-git-branch' style="font-size:0.75rem; vertical-align:-1px;"></i>
                        {{ $branch->name }}
                    </span>
                    @endforeach
                </div>
                @endif

                @if($isChairwoman)
                <div class="showroom-actions">
                    <a href="{{ url('/showrooms/' . $showroom->id . '/edit') }}" class="btn-sm btn-sm-primary">
                        <i class='bx bx-edit-alt'></i> Manage
                    </a>
                    <a href="{{ url('/branches?showroom_id=' . $showroom->id) }}" class="btn-sm btn-sm-ghost">
                        View Branches
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- TEAM --}}
<section id="team">
    <div class="section-header reveal">
        <span class="section-eyebrow">The People</span>
        <h2 class="section-title">Our Team</h2>
        <div class="section-line"></div>
    </div>
    <div class="team-grid">
        @foreach($teamByRole as $role => $members)
            @foreach($members as $i => $member)
            <div class="team-card reveal reveal-delay-{{ ($i % 4) + 1 }}">
                <div class="team-avatar">
                    {{ $isChairwoman ? strtoupper(substr($member->name, 0, 2)) : strtoupper(substr($role, 0, 2)) }}
                </div>
                <div class="team-role">{{ str_replace('_', ' ', $role) }}</div>
                @if($isChairwoman)
                    <div class="team-name">{{ $member->name }}</div>
                    <div class="team-branch">{{ $member->branch?->name ?? 'All Showrooms' }}</div>
                    @if($member->phone || $member->email)
                    <div class="team-contact">
                        @if($member->email) <div>{{ $member->email }}</div> @endif
                        @if($member->phone) <div>{{ $member->phone }}</div> @endif
                    </div>
                    @endif
                @else
                    <div class="team-name">{{ str_replace('_', ' ', $role) }}</div>
                    <div class="team-branch">{{ $member->branch?->name ?? '—' }}</div>
                @endif
            </div>
            @endforeach
        @endforeach
    </div>
</section>


{{-- VLOGS --}}
<section id="vlogs" style="padding: 6rem 4rem; background: var(--bg);">
    <div class="section-header reveal">
        <span class="section-eyebrow">Behind The Scenes</span>
        <h2 class="section-title">Velora Vlogs</h2>
        <div class="section-line"></div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 1100px; margin: 0 auto;">

        {{-- Vlog Card 1 --}}
        <div class="reveal reveal-delay-1" style="background: var(--bg3); border: 1px solid var(--glass-border); border-radius: 20px; overflow: hidden; transition: transform 0.4s, border-color 0.3s, box-shadow 0.4s;" onmouseenter="this.style.transform='translateY(-8px)'; this.style.borderColor='var(--purple)'; this.style.boxShadow='0 20px 60px rgba(105,108,255,0.15)';" onmouseleave="this.style.transform=''; this.style.borderColor='var(--glass-border)'; this.style.boxShadow='';">
            <div style="position:relative; height: 200px; background: linear-gradient(135deg, #0d0d1a, #1a1a2e); display:flex; align-items:center; justify-content:center; overflow:hidden;">
                <div style="position:absolute; inset:0; background: radial-gradient(circle at 50% 50%, rgba(105,108,255,0.2), transparent 70%);"></div>
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(105,108,255,0.2); border: 2px solid var(--purple); display:flex; align-items:center; justify-content:center; z-index:1; transition: transform 0.3s;" onmouseenter="this.style.transform='scale(1.1)'" onmouseleave="this.style.transform=''">
                    <i class='bx bx-play' style="color: var(--purple); font-size: 1.8rem; margin-left: 4px;"></i>
                </div>
                <div style="position:absolute; top: 12px; right: 12px; background: rgba(105,108,255,0.8); border-radius: 50px; padding: 3px 10px; font-size: 0.7rem; color: #fff; letter-spacing: 0.05em;">NEW</div>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.7rem; letter-spacing: 0.15em; color: var(--purple); margin-bottom: 0.6rem; text-transform: uppercase;">Showroom Tour</div>
                <div style="font-size: 1rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem;">Inside Velora — Our Flagship Location</div>
                <div style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">Go behind the scenes of our flagship showroom. See how we prepare every vehicle to meet Velora's standard of perfection.</div>
                <div style="display:flex; align-items:center; gap: 12px; font-size: 0.75rem; color: var(--text-dim);">
                    <span><i class='bx bx-time-five' style="vertical-align:-1px; margin-right:3px;"></i>8 min</span>
                    <span><i class='bx bx-show' style="vertical-align:-1px; margin-right:3px;"></i>2.4K views</span>
                </div>
            </div>
        </div>

        {{-- Vlog Card 2 --}}
        <div class="reveal reveal-delay-2" style="background: var(--bg3); border: 1px solid var(--glass-border); border-radius: 20px; overflow: hidden; transition: transform 0.4s, border-color 0.3s, box-shadow 0.4s;" onmouseenter="this.style.transform='translateY(-8px)'; this.style.borderColor='var(--purple)'; this.style.boxShadow='0 20px 60px rgba(105,108,255,0.15)';" onmouseleave="this.style.transform=''; this.style.borderColor='var(--glass-border)'; this.style.boxShadow='';">
            <div style="position:relative; height: 200px; background: linear-gradient(135deg, #0f0a1a, #1a0d2e); display:flex; align-items:center; justify-content:center; overflow:hidden;">
                <div style="position:absolute; inset:0; background: radial-gradient(circle at 50% 50%, rgba(240,192,96,0.15), transparent 70%);"></div>
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(240,192,96,0.15); border: 2px solid var(--gold); display:flex; align-items:center; justify-content:center; z-index:1;">
                    <i class='bx bx-play' style="color: var(--gold); font-size: 1.8rem; margin-left: 4px;"></i>
                </div>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.7rem; letter-spacing: 0.15em; color: var(--gold); margin-bottom: 0.6rem; text-transform: uppercase;">Team Story</div>
                <div style="font-size: 1rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem;">Meet The Team Behind Velora</div>
                <div style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">From Chairwoman to Sales Staff — the people who make Velora what it is. Real stories, real passion.</div>
                <div style="display:flex; align-items:center; gap: 12px; font-size: 0.75rem; color: var(--text-dim);">
                    <span><i class='bx bx-time-five' style="vertical-align:-1px; margin-right:3px;"></i>12 min</span>
                    <span><i class='bx bx-show' style="vertical-align:-1px; margin-right:3px;"></i>1.8K views</span>
                </div>
            </div>
        </div>

        {{-- Vlog Card 3 --}}
        <div class="reveal reveal-delay-3" style="background: var(--bg3); border: 1px solid var(--glass-border); border-radius: 20px; overflow: hidden; transition: transform 0.4s, border-color 0.3s, box-shadow 0.4s;" onmouseenter="this.style.transform='translateY(-8px)'; this.style.borderColor='var(--purple)'; this.style.boxShadow='0 20px 60px rgba(105,108,255,0.15)';" onmouseleave="this.style.transform=''; this.style.borderColor='var(--glass-border)'; this.style.boxShadow='';">
            <div style="position:relative; height: 200px; background: linear-gradient(135deg, #0a1010, #0d1a1a); display:flex; align-items:center; justify-content:center; overflow:hidden;">
                <div style="position:absolute; inset:0; background: radial-gradient(circle at 50% 50%, rgba(93,202,165,0.15), transparent 70%);"></div>
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(93,202,165,0.15); border: 2px solid #5dcaa5; display:flex; align-items:center; justify-content:center; z-index:1;">
                    <i class='bx bx-play' style="color: #5dcaa5; font-size: 1.8rem; margin-left: 4px;"></i>
                </div>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.7rem; letter-spacing: 0.15em; color: #5dcaa5; margin-bottom: 0.6rem; text-transform: uppercase;">Tech & Process</div>
                <div style="font-size: 1rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem;">How Velora VMS Powers The Business</div>
                <div style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem;">A deep dive into the technology that runs Velora — vehicle management, invoicing, analytics and more.</div>
                <div style="display:flex; align-items:center; gap: 12px; font-size: 0.75rem; color: var(--text-dim);">
                    <span><i class='bx bx-time-five' style="vertical-align:-1px; margin-right:3px;"></i>15 min</span>
                    <span><i class='bx bx-show' style="vertical-align:-1px; margin-right:3px;"></i>3.1K views</span>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- STORY TIMELINE --}}
<section id="story">
    <div class="section-header reveal">
        <span class="section-eyebrow">Our Journey</span>
        <h2 class="section-title">The Velora Story</h2>
        <div class="section-line"></div>
    </div>
    <div class="timeline">
        <div class="timeline-item reveal">
            <div class="timeline-content">
                <div class="timeline-year">THE BEGINNING</div>
                <div class="timeline-heading">A Vision for Excellence</div>
                <div class="timeline-text">Velora was founded with a singular mission — to transform how Pakistan experiences vehicle ownership. From day one, the standard was set uncompromisingly high.</div>
            </div>
            <div class="timeline-dot"></div>
            <div class="timeline-spacer"></div>
        </div>
        <div class="timeline-item reveal reveal-delay-1">
            <div class="timeline-spacer"></div>
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <div class="timeline-year">GROWTH</div>
                <div class="timeline-heading">First Showroom Launched</div>
                <div class="timeline-text">Our flagship showroom opened its doors, introducing a new benchmark for automotive retail in the region. Customers arrived for vehicles — and stayed for the experience.</div>
            </div>
        </div>
        <div class="timeline-item reveal reveal-delay-2">
            <div class="timeline-content">
                <div class="timeline-year">EXPANSION</div>
                <div class="timeline-heading">Multi-Showroom Network</div>
                <div class="timeline-text">Growing demand led to expansion across cities. Velora's multi-branch architecture ensures every customer — regardless of location — receives the same world-class service.</div>
            </div>
            <div class="timeline-dot"></div>
            <div class="timeline-spacer"></div>
        </div>
        <div class="timeline-item reveal reveal-delay-3">
            <div class="timeline-spacer"></div>
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <div class="timeline-year">TODAY</div>
                <div class="timeline-heading">Technology Meets Luxury</div>
                <div class="timeline-text">Velora VMS — our proprietary management system — digitises every aspect of the dealership experience. From vehicle tracking to invoicing, the future is already here.</div>
            </div>
        </div>
    </div>
</section>

{{-- CHAIRWOMAN MANAGEMENT PANEL --}}
@if($isChairwoman)
<section id="chairwoman-panel">
    <div class="panel-badge">
        <i class='bx bx-shield-quarter'></i>
        Chairwoman Access — Management Console
    </div>
    <div class="section-header" style="text-align:left; margin-bottom:2rem;">
        <h2 class="section-title" style="font-size:1.8rem;">Quick Management</h2>
    </div>
    <div class="mgmt-grid">
        <a href="{{ url('/showrooms') }}" class="mgmt-card">
            <div class="mgmt-icon"><i class='bx bx-building'></i></div>
            <div class="mgmt-title">Manage Showrooms</div>
            <div class="mgmt-desc">Add, edit, or deactivate showrooms</div>
        </a>
        <a href="{{ url('/branches') }}" class="mgmt-card">
            <div class="mgmt-icon"><i class='bx bx-git-branch'></i></div>
            <div class="mgmt-title">Manage Branches</div>
            <div class="mgmt-desc">Branch assignments and settings</div>
        </a>
        <a href="{{ url('/users') }}" class="mgmt-card">
            <div class="mgmt-icon"><i class='bx bx-group'></i></div>
            <div class="mgmt-title">Manage Team</div>
            <div class="mgmt-desc">Users, roles, and permissions</div>
        </a>
        <a href="{{ url('/analytics') }}" class="mgmt-card">
            <div class="mgmt-icon"><i class='bx bx-bar-chart-alt-2'></i></div>
            <div class="mgmt-title">Analytics</div>
            <div class="mgmt-desc">Revenue, performance, trends</div>
        </a>
        <a href="{{ url('/audit-logs') }}" class="mgmt-card">
            <div class="mgmt-icon"><i class='bx bx-history'></i></div>
            <div class="mgmt-title">Audit Logs</div>
            <div class="mgmt-desc">Full activity trail</div>
        </a>
        <a href="{{ url('/dashboard') }}" class="mgmt-card">
            <div class="mgmt-icon"><i class='bx bx-layout'></i></div>
            <div class="mgmt-title">Dashboard</div>
            <div class="mgmt-desc">Live system overview</div>
        </a>
    </div>
</section>
@endif

{{-- CONTACT --}}
<section id="contact">
    <div class="section-header reveal">
        <span class="section-eyebrow">Get In Touch</span>
        <h2 class="section-title">Find Us</h2>
        <div class="section-line"></div>
    </div>
    <div class="contact-grid">
        @foreach($showrooms as $showroom)
        <div class="contact-card reveal">
            <div class="contact-card-name">
                <i class='bx bx-building-house' style="color:var(--purple); margin-right:8px;"></i>
                {{ $showroom->name }}
            </div>
            @if($showroom->address)
            <div class="contact-row"><i class='bx bx-map'></i><span>{{ $showroom->address }}</span></div>
            @endif
            @if($showroom->phone)
            <div class="contact-row"><i class='bx bx-phone'></i><span>{{ $showroom->phone }}</span></div>
            @endif
            @if($showroom->email)
            <div class="contact-row"><i class='bx bx-envelope'></i><span>{{ $showroom->email }}</span></div>
            @endif
            @if($showroom->city)
            <div class="contact-row"><i class='bx bx-current-location'></i><span>{{ $showroom->city }}{{ $showroom->country ? ', ' . $showroom->country : '' }}</span></div>
            @endif
        </div>
        @endforeach
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="footer-logo">
        <img src="{{ asset('assets/img/logo/velora_logo.svg') }}" alt="Velora">
        Velora Group
    </div>
    <div class="footer-links">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/investor') }}">Investors</a>
        @auth <a href="{{ url('/dashboard') }}">Dashboard</a> @endauth
    </div>
    <div class="footer-copy">© {{ date('Y') }} Velora Group. All rights reserved.</div>
</footer>

<script>
// Cursor
const dot = document.getElementById('cursor-dot');
const ring = document.getElementById('cursor-ring');
const glow = document.getElementById('cursor-glow');
document.addEventListener('mousemove', e => {
    dot.style.left = e.clientX + 'px';
    dot.style.top = e.clientY + 'px';
    ring.style.left = e.clientX + 'px';
    ring.style.top = e.clientY + 'px';
    glow.style.left = e.clientX + 'px';
    glow.style.top = e.clientY + 'px';
});
document.querySelectorAll('a, button').forEach(el => {
    el.addEventListener('mouseenter', () => {
        ring.style.transform = 'translate(-50%, -50%) scale(1.8)';
        ring.style.borderColor = 'var(--purple)';
        dot.style.transform = 'translate(-50%, -50%) scale(0.5)';
    });
    el.addEventListener('mouseleave', () => {
        ring.style.transform = 'translate(-50%, -50%) scale(1)';
        ring.style.borderColor = 'var(--purple-glow)';
        dot.style.transform = 'translate(-50%, -50%) scale(1)';
    });
});

// Scroll reveal
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.15 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// Count-up
const countObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = parseInt(el.dataset.target);
        let current = 0;
        const duration = 1800;
        const step = Math.ceil(target / (duration / 16));
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = current.toLocaleString();
            if (current >= target) clearInterval(timer);
        }, 16);
        countObserver.unobserve(el);
    });
}, { threshold: 0.5 });
document.querySelectorAll('[data-target]').forEach(el => countObserver.observe(el));


</script>

<script>
// Smooth scroll — URL mein # nahi aayega
document.querySelectorAll('.nav-anchor').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>
</body>
</html>