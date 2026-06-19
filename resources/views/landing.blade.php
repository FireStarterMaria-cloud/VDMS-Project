<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Velora — Vehicle Dealer Management System</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

  <style>
    :root {
      --sneat-purple: #696cff;
      --sneat-purple-dark: #5f61e6;
      --sneat-purple-light: #e7e7ff;
      --sneat-bg: #f5f5f9;
      --sneat-dark: #2b2c40;
      --sneat-text: #566a7f;
      --sneat-white: #ffffff;
      --sneat-success: #71dd37;
      --sneat-warning: #ffab00;
      --sneat-info: #03c3ec;
      --sneat-danger: #ff3e1d;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Public Sans', sans-serif; background: var(--sneat-white); overflow-x: hidden; }

    /* ===== CURSOR GLOW ===== */
    .cursor-glow {
      position: fixed;
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(105,108,255,0.08) 0%, transparent 70%);
      pointer-events: none;
      z-index: 0;
      transform: translate(-50%, -50%);
      transition: left 0.1s ease, top 0.1s ease;
    }

    /* ===== NAVBAR ===== */
    .landing-nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 999;
      background: rgba(255,255,255,0.92);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(105,108,255,0.1);
      padding: 0;
    }
    .nav-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 14px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .nav-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }
    .nav-logo {
      width: 36px;
      height: 36px;
      background: linear-gradient(135deg, var(--sneat-purple), #9155fd);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .nav-logo i { color: white; font-size: 20px; }
    .nav-brand-text {
      font-size: 20px;
      font-weight: 700;
      color: var(--sneat-dark);
      letter-spacing: -0.3px;
    }
    .nav-brand-text span { color: var(--sneat-purple); }
    .nav-links {
      display: flex;
      align-items: center;
      gap: 32px;
    }
    .nav-links a {
      color: var(--sneat-text);
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: color 0.2s;
      position: relative;
    }
    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: -4px; left: 0; right: 0;
      height: 2px;
      background: var(--sneat-purple);
      border-radius: 2px;
      transform: scaleX(0);
      transition: transform 0.2s;
    }
    .nav-links a:hover { color: var(--sneat-purple); }
    .nav-links a:hover::after { transform: scaleX(1); }
    .btn-nav-login {
      background: var(--sneat-purple);
      color: white !important;
      padding: 10px 24px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 14px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
      box-shadow: 0 4px 15px rgba(105,108,255,0.35);
    }
    .btn-nav-login:hover {
      background: var(--sneat-purple-dark);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(105,108,255,0.45);
    }

    /* ===== HERO ===== */
    .hero {
      min-height: 100vh;
      background: linear-gradient(135deg, #2b2c40 0%, #3d3e5c 40%, #2b2c40 100%);
      display: flex;
      align-items: center;
      padding-top: 80px;
      position: relative;
      overflow: hidden;
    }
    .hero-bg-circle1 {
      position: absolute;
      top: -100px; right: -100px;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(105,108,255,0.2) 0%, transparent 70%);
      border-radius: 50%;
      animation: float1 6s ease-in-out infinite;
    }
    .hero-bg-circle2 {
      position: absolute;
      bottom: -150px; left: -100px;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(145,85,253,0.15) 0%, transparent 70%);
      border-radius: 50%;
      animation: float2 8s ease-in-out infinite;
    }
    .hero-bg-grid {
      position: absolute;
      inset: 0;
      background-image: linear-gradient(rgba(105,108,255,0.05) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(105,108,255,0.05) 1px, transparent 1px);
      background-size: 50px 50px;
    }
    @keyframes float1 {
      0%, 100% { transform: translate(0, 0) scale(1); }
      50% { transform: translate(-20px, 20px) scale(1.05); }
    }
    @keyframes float2 {
      0%, 100% { transform: translate(0, 0) scale(1); }
      50% { transform: translate(20px, -20px) scale(1.05); }
    }
    .hero-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 80px 24px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
      position: relative;
      z-index: 1;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(105,108,255,0.15);
      border: 1px solid rgba(105,108,255,0.3);
      color: #a8aaff;
      padding: 7px 18px;
      border-radius: 50px;
      font-size: 13px;
      font-weight: 500;
      margin-bottom: 24px;
      animation: fadeInDown 0.6s ease forwards;
    }
    .hero-badge i { font-size: 15px; }
    .hero-title {
      font-size: 50px;
      font-weight: 800;
      color: white;
      line-height: 1.15;
      margin-bottom: 20px;
      letter-spacing: -1px;
      animation: fadeInUp 0.7s ease forwards;
    }
    .hero-title .highlight {
      background: linear-gradient(135deg, #696cff, #9155fd);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .hero-desc {
      font-size: 16px;
      color: rgba(255,255,255,0.6);
      line-height: 1.8;
      margin-bottom: 36px;
      animation: fadeInUp 0.8s ease forwards;
    }
    .hero-btns {
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
      animation: fadeInUp 0.9s ease forwards;
    }
    .btn-primary-hero {
      background: linear-gradient(135deg, var(--sneat-purple), #9155fd);
      color: white;
      padding: 14px 32px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s;
      box-shadow: 0 6px 20px rgba(105,108,255,0.4);
    }
    .btn-primary-hero:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(105,108,255,0.5);
      color: white;
    }
    .btn-secondary-hero {
      background: rgba(255,255,255,0.08);
      color: rgba(255,255,255,0.85);
      padding: 14px 32px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 500;
      font-size: 15px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: 1px solid rgba(255,255,255,0.15);
      transition: all 0.3s;
    }
    .btn-secondary-hero:hover {
      background: rgba(255,255,255,0.14);
      color: white;
      transform: translateY(-2px);
    }
    .hero-stats {
      display: flex;
      gap: 36px;
      margin-top: 48px;
      padding-top: 36px;
      border-top: 1px solid rgba(255,255,255,0.08);
      animation: fadeInUp 1s ease forwards;
    }
    .stat h3 {
      font-size: 30px;
      font-weight: 800;
      color: white;
      line-height: 1;
    }
    .stat h3 span { color: var(--sneat-purple); }
    .stat p {
      font-size: 12px;
      color: rgba(255,255,255,0.45);
      margin-top: 4px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Dashboard Mockup */
    .hero-mockup {
      animation: fadeInRight 0.8s ease forwards;
    }
    .mockup-window {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 30px 80px rgba(0,0,0,0.4);
    }
    .mockup-topbar {
      background: rgba(255,255,255,0.06);
      padding: 14px 18px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .mockup-dots { display: flex; gap: 6px; }
    .mockup-dots span { width: 10px; height: 10px; border-radius: 50%; }
    .d1 { background: #ff5f57; }
    .d2 { background: #febc2e; }
    .d3 { background: #28c840; }
    .mockup-url {
      flex: 1;
      background: rgba(255,255,255,0.06);
      border-radius: 6px;
      padding: 5px 12px;
      font-size: 11px;
      color: rgba(255,255,255,0.4);
    }
    .mockup-body { padding: 16px; }
    .mockup-cards {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-bottom: 14px;
    }
    .m-card {
      padding: 14px;
      border-radius: 12px;
      position: relative;
      overflow: hidden;
    }
    .m-card::before {
      content: '';
      position: absolute;
      top: -20px; right: -20px;
      width: 60px; height: 60px;
      border-radius: 50%;
      background: rgba(255,255,255,0.1);
    }
    .m-card-purple { background: linear-gradient(135deg, #696cff, #9155fd); }
    .m-card-success { background: linear-gradient(135deg, #71dd37, #40c100); }
    .m-card-warning { background: linear-gradient(135deg, #ffab00, #e09600); }
    .m-card-info { background: linear-gradient(135deg, #03c3ec, #0095b8); }
    .m-card h4 { font-size: 22px; font-weight: 700; color: white; }
    .m-card p { font-size: 11px; color: rgba(255,255,255,0.75); margin-top: 2px; }
    .m-card i { font-size: 22px; color: rgba(255,255,255,0.5); float: right; margin-top: -28px; }
    .mockup-table-wrap {
      background: rgba(255,255,255,0.04);
      border-radius: 10px;
      overflow: hidden;
    }
    .m-table-head {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      padding: 8px 14px;
      background: rgba(255,255,255,0.06);
      font-size: 10px;
      color: rgba(255,255,255,0.4);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .m-table-row {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      padding: 9px 14px;
      font-size: 12px;
      color: rgba(255,255,255,0.7);
      border-bottom: 1px solid rgba(255,255,255,0.04);
      align-items: center;
    }
    .m-table-row:last-child { border-bottom: none; }
    .m-badge {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 4px;
      font-size: 10px;
      font-weight: 600;
    }
    .b-available { background: rgba(113,221,55,0.2); color: #71dd37; }
    .b-reserved { background: rgba(255,171,0,0.2); color: #ffab00; }
    .b-sold { background: rgba(255,62,29,0.2); color: #ff6b6b; }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInRight {
      from { opacity: 0; transform: translateX(30px); }
      to { opacity: 1; transform: translateX(0); }
    }

    /* ===== FEATURES ===== */
    .features {
      padding: 100px 0;
      background: var(--sneat-bg);
    }
    .section-wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
    }
    .section-chip {
      display: inline-block;
      background: var(--sneat-purple-light);
      color: var(--sneat-purple);
      padding: 5px 16px;
      border-radius: 50px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 14px;
    }
    .section-heading {
      font-size: 36px;
      font-weight: 700;
      color: var(--sneat-dark);
      margin-bottom: 12px;
      letter-spacing: -0.5px;
    }
    .section-sub {
      font-size: 15px;
      color: var(--sneat-text);
      line-height: 1.8;
      max-width: 540px;
      margin-bottom: 56px;
    }
    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }
    .feat-card {
      background: white;
      border-radius: 16px;
      padding: 28px;
      border: 1px solid rgba(105,108,255,0.08);
      transition: all 0.3s;
      cursor: default;
      position: relative;
      overflow: hidden;
    }
    .feat-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--sneat-purple), #9155fd);
      transform: scaleX(0);
      transition: transform 0.3s;
      transform-origin: left;
    }
    .feat-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 40px rgba(105,108,255,0.12);
      border-color: rgba(105,108,255,0.2);
    }
    .feat-card:hover::before { transform: scaleX(1); }
    .feat-icon {
      width: 52px;
      height: 52px;
      background: var(--sneat-purple-light);
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 18px;
      transition: all 0.3s;
    }
    .feat-card:hover .feat-icon {
      background: var(--sneat-purple);
    }
    .feat-icon i { font-size: 24px; color: var(--sneat-purple); transition: color 0.3s; }
    .feat-card:hover .feat-icon i { color: white; }
    .feat-card h4 {
      font-size: 16px;
      font-weight: 600;
      color: var(--sneat-dark);
      margin-bottom: 8px;
    }
    .feat-card p { font-size: 13px; color: var(--sneat-text); line-height: 1.7; }

    /* ===== BRANCHES ===== */
    .branches-section {
      padding: 80px 0;
      background: white;
    }
    .branches-flex {
      display: flex;
      justify-content: center;
      gap: 16px;
      flex-wrap: wrap;
      margin-top: 48px;
    }
    .branch-card {
      display: flex;
      align-items: center;
      gap: 12px;
      background: var(--sneat-bg);
      border: 1px solid rgba(105,108,255,0.1);
      border-radius: 14px;
      padding: 16px 24px;
      transition: all 0.3s;
      cursor: default;
    }
    .branch-card:hover {
      background: var(--sneat-purple-light);
      border-color: var(--sneat-purple);
      transform: translateY(-4px);
      box-shadow: 0 8px 25px rgba(105,108,255,0.15);
    }
    .branch-num {
      width: 36px;
      height: 36px;
      background: var(--sneat-purple);
      color: white;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 14px;
    }
    .branch-card h5 {
      font-size: 15px;
      font-weight: 600;
      color: var(--sneat-dark);
      margin: 0;
    }
    .branch-card p {
      font-size: 12px;
      color: var(--sneat-text);
      margin: 0;
    }

    /* ===== ROLES ===== */
    .roles-section {
      padding: 100px 0;
      background: var(--sneat-bg);
    }
    .roles-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 20px;
      margin-top: 48px;
    }
    .role-card {
      background: white;
      border-radius: 16px;
      padding: 28px 16px;
      text-align: center;
      border: 1px solid rgba(105,108,255,0.08);
      transition: all 0.3s;
    }
    .role-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 35px rgba(105,108,255,0.12);
      border-color: var(--sneat-purple);
    }
    .role-icon {
      width: 60px;
      height: 60px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
      font-size: 26px;
      transition: all 0.3s;
    }
    .role-card:hover .role-icon { transform: scale(1.1); }
    .r1 { background: rgba(105,108,255,0.1); color: var(--sneat-purple); }
    .r2 { background: rgba(145,85,253,0.1); color: #9155fd; }
    .r3 { background: rgba(113,221,55,0.1); color: #4caf00; }
    .r4 { background: rgba(255,171,0,0.1); color: var(--sneat-warning); }
    .r5 { background: rgba(3,195,236,0.1); color: var(--sneat-info); }
    .role-card h5 {
      font-size: 13px;
      font-weight: 600;
      color: var(--sneat-dark);
      margin-bottom: 6px;
    }
    .role-card p { font-size: 12px; color: var(--sneat-text); line-height: 1.6; }

    /* ===== STATS COUNTER ===== */
    .stats-section {
      padding: 80px 0;
      background: linear-gradient(135deg, #2b2c40, #3d3e5c);
    }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 32px;
      text-align: center;
    }
    .stats-item h3 {
      font-size: 42px;
      font-weight: 800;
      color: white;
      line-height: 1;
    }
    .stats-item h3 span { color: var(--sneat-purple); }
    .stats-item p {
      font-size: 14px;
      color: rgba(255,255,255,0.5);
      margin-top: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .stats-item i {
      font-size: 36px;
      color: var(--sneat-purple);
      margin-bottom: 12px;
      display: block;
    }

    /* ===== CTA ===== */
    .cta-section {
      padding: 100px 0;
      background: white;
      text-align: center;
    }
    .cta-box {
      max-width: 700px;
      margin: 0 auto;
      padding: 0 24px;
    }
    .cta-box h2 {
      font-size: 40px;
      font-weight: 700;
      color: var(--sneat-dark);
      margin-bottom: 16px;
    }
    .cta-box p {
      font-size: 16px;
      color: var(--sneat-text);
      line-height: 1.8;
      margin-bottom: 36px;
    }

    /* ===== FOOTER ===== */
    .landing-footer {
      background: var(--sneat-dark);
      padding: 32px 0;
      text-align: center;
    }
    .landing-footer p {
      color: rgba(255,255,255,0.4);
      font-size: 14px;
    }
    .landing-footer span { color: var(--sneat-purple); }

    /* ===== SCROLL REVEAL ===== */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }

    @media (max-width: 768px) {
      .hero-inner { grid-template-columns: 1fr; }
      .hero-mockup { display: none; }
      .hero-title { font-size: 34px; }
      .features-grid { grid-template-columns: 1fr; }
      .roles-grid { grid-template-columns: repeat(2, 1fr); }
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .nav-links { display: none; }
    }
  </style>
</head>
<body>

<div class="cursor-glow" id="cursorGlow"></div>

{{-- NAVBAR --}}
<nav class="landing-nav">
  <div class="nav-inner">
    <a href="{{ url('/') }}" class="nav-brand">
      <div class="nav-logo">
        <i class='bx bx-car'></i>
      </div>
      <span class="nav-brand-text">Velora <span>VMS</span></span>
    </a>
    <div class="nav-links">
      <a href="{{ url('/#features') }}">Features</a>
      <a href="{{ url('/#branches') }}">Branches</a>
      <a href="{{ url('/#roles') }}">Roles</a>
      <a href="{{ url('/#stats') }}">Stats</a>
      <a href="{{ route('login') }}" class="btn-nav-login">
        <i class='bx bx-log-in'></i> Login
      </a>
    </div>
  </div>
</nav>

{{-- HERO --}}
<section class="hero" id="home">
  <div class="hero-bg-grid"></div>
  <div class="hero-bg-circle1"></div>
  <div class="hero-bg-circle2"></div>
  <div class="hero-inner">
    <div class="hero-content">
      <div class="hero-badge">
        <i class='bx bx-map-pin'></i>
        5 Branches Across Pakistan
      </div>
      <h1 class="hero-title">
        Modern <span class="highlight">Vehicle</span><br>
        Dealer Management<br>
        <span class="highlight">Reimagined</span>
      </h1>
      <p class="hero-desc">
        Velora VMS is a powerful, multi-branch dealership management platform
        built for Toyota dealers across Pakistan — from inventory to invoices,
        all in one place.
      </p>
      <div class="hero-btns">
        <a href="{{ route('login') }}" class="btn-primary-hero">
          <i class='bx bx-log-in'></i> Access Dashboard
        </a>
        <a href="{{ url('/#features') }}" class="btn-secondary-hero">
          <i class='bx bx-play-circle'></i> Explore Features
        </a>
      </div>
      <div class="hero-stats">
        <div class="stat"><h3>5<span>+</span></h3><p>Branches</p></div>
        <div class="stat"><h3>10<span>+</span></h3><p>Modules</p></div>
        <div class="stat"><h3>5<span></span></h3><p>User Roles</p></div>
        <div class="stat"><h3>100<span>%</span></h3><p>Role-Based</p></div>
      </div>
    </div>
    <div class="hero-mockup">
      <div class="mockup-window">
        <div class="mockup-topbar">
          <div class="mockup-dots">
            <span class="d1"></span><span class="d2"></span><span class="d3"></span>
          </div>
          <div class="mockup-url">velora-vms.com/dashboard</div>
        </div>
        <div class="mockup-body">
          <div class="mockup-cards">
            <div class="m-card m-card-purple">
              <i class='bx bx-car'></i>
              <h4>20</h4><p>Total Vehicles</p>
            </div>
            <div class="m-card m-card-success">
              <i class='bx bx-check-circle'></i>
              <h4>12</h4><p>Available</p>
            </div>
            <div class="m-card m-card-warning">
              <i class='bx bx-buildings'></i>
              <h4>5</h4><p>Branches</p>
            </div>
            <div class="m-card m-card-info">
              <i class='bx bx-group'></i>
              <h4>19</h4><p>Users</p>
            </div>
          </div>
          <div class="mockup-table-wrap">
            <div class="m-table-head">
              <span>Vehicle</span><span>Branch</span><span>Status</span>
            </div>
            <div class="m-table-row">
              <span>Toyota Yaris GLi</span><span>Lahore</span>
              <span class="m-badge b-available">Available</span>
            </div>
            <div class="m-table-row">
              <span>Toyota Hilux XLi</span><span>Karachi</span>
              <span class="m-badge b-reserved">Reserved</span>
            </div>
            <div class="m-table-row">
              <span>Land Cruiser</span><span>Islamabad</span>
              <span class="m-badge b-sold">Sold</span>
            </div>
            <div class="m-table-row">
              <span>Toyota Corolla</span><span>Multan</span>
              <span class="m-badge b-available">Available</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- FEATURES --}}
<section class="features" id="features">
  <div class="section-wrap">
    <span class="section-chip reveal">Why Velora?</span>
    <h2 class="section-heading reveal">Everything Your Dealership Needs</h2>
    <p class="section-sub reveal">From vehicle inventory to sales, payments, branch transfers and analytics — Velora VMS has every module covered.</p>
    <div class="features-grid">
      <div class="feat-card reveal">
        <div class="feat-icon"><i class='bx bx-car'></i></div>
        <h4>Vehicle Inventory</h4>
        <p>Track every vehicle across all branches with registration, VIN, status, pricing and full history.</p>
      </div>
      <div class="feat-card reveal">
        <div class="feat-icon"><i class='bx bx-receipt'></i></div>
        <h4>Sales Management</h4>
        <p>Record sales, manage customer details, apply discounts and monitor payment status in real-time.</p>
      </div>
      <div class="feat-card reveal">
        <div class="feat-icon"><i class='bx bx-user'></i></div>
        <h4>Customer Database</h4>
        <p>Maintain complete customer profiles with CNIC, contact info and full purchase history.</p>
      </div>
      <div class="feat-card reveal">
        <div class="feat-icon"><i class='bx bx-transfer'></i></div>
        <h4>Branch Transfers</h4>
        <p>Request and approve vehicle transfers between branches with a complete audit trail.</p>
      </div>
      <div class="feat-card reveal">
        <div class="feat-icon"><i class='bx bx-file'></i></div>
        <h4>Invoices & Payments</h4>
        <p>Generate professional invoices and track payments across multiple payment methods.</p>
      </div>
      <div class="feat-card reveal">
        <div class="feat-icon"><i class='bx bx-shield'></i></div>
        <h4>Role-Based Access</h4>
        <p>5 user roles with branch-level data isolation — every team member sees only what they need.</p>
      </div>
      <div class="feat-card reveal">
        <div class="feat-icon"><i class='bx bx-line-chart'></i></div>
        <h4>Analytics & Reports</h4>
        <p>Insights into sales performance, vehicle availability and revenue broken down by branch.</p>
      </div>
      <div class="feat-card reveal">
        <div class="feat-icon"><i class='bx bx-purchase-tag-alt'></i></div>
        <h4>Purchase Management</h4>
        <p>Record vehicle purchases from suppliers with complete payment tracking and references.</p>
      </div>
      <div class="feat-card reveal">
        <div class="feat-icon"><i class='bx bx-globe'></i></div>
        <h4>Globally Scalable</h4>
        <p>Add new branches, cities or countries — zero code changes needed. Built for growth.</p>
      </div>
    </div>
  </div>
</section>

{{-- BRANCHES --}}
<section class="branches-section" id="branches">
  <div class="section-wrap" style="text-align:center;">
    <span class="section-chip reveal">Our Network</span>
    <h2 class="section-heading reveal">5 Branches Across Pakistan</h2>
    <p class="section-sub reveal" style="margin: 0 auto 48px;">From Lahore to Abbottabad — Velora VMS manages Toyota dealerships nationwide with seamless coordination.</p>
    <div class="branches-flex">
      <div class="branch-card reveal">
        <div class="branch-num">1</div>
        <div><h5>Lahore</h5><p>Punjab HQ</p></div>
      </div>
      <div class="branch-card reveal">
        <div class="branch-num">2</div>
        <div><h5>Islamabad</h5><p>Capital Branch</p></div>
      </div>
      <div class="branch-card reveal">
        <div class="branch-num">3</div>
        <div><h5>Multan</h5><p>South Punjab</p></div>
      </div>
      <div class="branch-card reveal">
        <div class="branch-num">4</div>
        <div><h5>Karachi</h5><p>Sindh Branch</p></div>
      </div>
      <div class="branch-card reveal">
        <div class="branch-num">5</div>
        <div><h5>Abbottabad</h5><p>KPK Branch</p></div>
      </div>
    </div>
  </div>
</section>

{{-- STATS --}}
<section class="stats-section" id="stats">
  <div class="section-wrap">
    <div class="stats-grid">
      <div class="stats-item reveal">
        <i class='bx bx-car'></i>
        <h3><span id="c1">0</span></h3>
        <p>Vehicles Managed</p>
      </div>
      <div class="stats-item reveal">
        <i class='bx bx-buildings'></i>
        <h3><span id="c2">0</span></h3>
        <p>Active Branches</p>
      </div>
      <div class="stats-item reveal">
        <i class='bx bx-group'></i>
        <h3><span id="c3">0</span></h3>
        <p>System Users</p>
      </div>
      <div class="stats-item reveal">
        <i class='bx bx-shield-check'></i>
        <h3><span id="c4">0</span>%</h3>
        <p>Role-Based Security</p>
      </div>
    </div>
  </div>
</section>

{{-- ROLES --}}
<section class="roles-section" id="roles">
  <div class="section-wrap">
    <span class="section-chip reveal">Access Control</span>
    <h2 class="section-heading reveal">5 Roles, Perfect Access</h2>
    <p class="section-sub reveal">Every team member gets exactly the access they need — no more, no less.</p>
    <div class="roles-grid">
      <div class="role-card reveal">
        <div class="role-icon r1"><i class='bx bx-crown'></i></div>
        <h5>Super Admin</h5>
        <p>Full system access across all branches and modules</p>
      </div>
      <div class="role-card reveal">
        <div class="role-icon r2"><i class='bx bx-building'></i></div>
        <h5>HO Admin</h5>
        <p>Head Office management, reporting and oversight</p>
      </div>
      <div class="role-card reveal">
        <div class="role-icon r3"><i class='bx bx-user-check'></i></div>
        <h5>Branch Manager</h5>
        <p>Manage vehicles, staff and operations at branch</p>
      </div>
      <div class="role-card reveal">
        <div class="role-icon r4"><i class='bx bx-store'></i></div>
        <h5>Sales Staff</h5>
        <p>Process sales and manage customer relationships</p>
      </div>
      <div class="role-card reveal">
        <div class="role-icon r5"><i class='bx bx-calculator'></i></div>
        <h5>Accountant</h5>
        <p>Payments, invoices and all financial records</p>
      </div>
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="cta-section">
  <div class="cta-box">
    <span class="section-chip reveal">Get Started</span>
    <h2 class="reveal">Ready to Go Live?</h2>
    <p class="reveal">Log in to your Velora VMS dashboard and manage your Toyota dealership network with confidence and clarity.</p>
    <a href="{{ route('login') }}" class="btn-primary-hero reveal" style="display:inline-flex;">
      <i class='bx bx-log-in'></i> Access Dashboard
    </a>
  </div>
</section>

{{-- FOOTER --}}
<footer class="landing-footer">
  <div>
    <p>&copy; {{ date('Y') }} <span>Velora VMS</span> — Vehicle Management System. All rights reserved.</p>
  </div>
</footer>

<script>
  // Cursor glow
  const glow = document.getElementById('cursorGlow');
  document.addEventListener('mousemove', (e) => {
    glow.style.left = e.clientX + 'px';
    glow.style.top = e.clientY + 'px';
  });

  // Scroll reveal
  const reveals = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.classList.add('visible');
        }, i * 80);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  reveals.forEach(el => observer.observe(el));

  // Counter animation
  function animateCounter(el, target, suffix = '') {
    let current = 0;
    const step = Math.ceil(target / 40);
    const timer = setInterval(() => {
      current += step;
      if (current >= target) { current = target; clearInterval(timer); }
      el.textContent = current + suffix;
    }, 40);
  }

  const statsObserver = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
      animateCounter(document.getElementById('c1'), 20);
      animateCounter(document.getElementById('c2'), 5);
      animateCounter(document.getElementById('c3'), 19);
      animateCounter(document.getElementById('c4'), 100);
      statsObserver.disconnect();
    }
  }, { threshold: 0.3 });
  statsObserver.observe(document.querySelector('.stats-section'));

  // Smooth scroll for nav links
  document.querySelectorAll('a[href*="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      const hashIndex = href.indexOf('#');
      if (hashIndex !== -1) {
        const id = href.substring(hashIndex + 1);
        const target = document.getElementById(id);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth' });
        }
      }
    });
  });
</script>

</body>
</html>

