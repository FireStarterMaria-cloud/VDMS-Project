<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Velora — Vehicle Management System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <style>
    :root {
      --p: #696cff; --pd: #5f61e6; --pl: #e7e7ff;
      --bg: #f5f5f9; --dark: #2b2c40; --text: #566a7f;
      --success: #71dd37; --warning: #ffab00; --info: #03c3ec;
    }
    *{margin:0;padding:0;box-sizing:border-box}
    html{scroll-behavior:smooth}
    body{font-family:'Public Sans',sans-serif;background:#fff;overflow-x:hidden}

    .cursor-glow{position:fixed;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(105,108,255,0.08) 0%,transparent 70%);pointer-events:none;z-index:0;transform:translate(-50%,-50%);transition:left .1s,top .1s}

    /* NAV */
    .nav{position:fixed;top:0;left:0;right:0;z-index:999;background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);border-bottom:1px solid rgba(105,108,255,0.1);transition:all .3s}
    .nav.scrolled{box-shadow:0 4px 20px rgba(0,0,0,0.08)}
    .nav-inner{max-width:1200px;margin:0 auto;padding:14px 24px;display:flex;align-items:center;justify-content:space-between}
    .nav-brand{display:flex;align-items:center;gap:10px;text-decoration:none}
    .nav-brand img{height:36px}
    .nav-brand-text{font-size:20px;font-weight:700;color:var(--dark)}
    .nav-brand-text span{color:var(--p)}
    .nav-links{display:flex;align-items:center;gap:28px}
    .nav-links a{color:var(--text);text-decoration:none;font-size:14px;font-weight:500;transition:color .2s;position:relative;cursor:pointer}
    .nav-links a::after{content:'';position:absolute;bottom:-4px;left:0;right:0;height:2px;background:var(--p);border-radius:2px;transform:scaleX(0);transition:transform .2s}
    .nav-links a:hover,.nav-links a.active{color:var(--p)}
    .nav-links a:hover::after,.nav-links a.active::after{transform:scaleX(1)}
    .btn-login{background:var(--p);color:#fff!important;padding:10px 24px;border-radius:8px;font-weight:600;font-size:14px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .2s;box-shadow:0 4px 15px rgba(105,108,255,.35)}
    .btn-login:hover{background:var(--pd);transform:translateY(-1px);box-shadow:0 6px 20px rgba(105,108,255,.45)}
    .nav-toggle{display:none;background:none;border:none;font-size:26px;color:var(--dark);cursor:pointer}

    /* MOBILE MENU */
    .mobile-overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;opacity:0;pointer-events:none;transition:opacity .3s}
    .mobile-overlay.open{opacity:1;pointer-events:all}
    .mobile-menu{position:fixed;top:0;right:-300px;width:280px;height:100vh;background:#fff;z-index:1001;transition:right .3s;padding:0;box-shadow:-10px 0 40px rgba(0,0,0,.15)}
    .mobile-menu.open{right:0}
    .mobile-menu-header{padding:20px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f0f0f0}
    .mobile-menu-header span{font-weight:700;color:var(--dark);font-size:16px}
    .mobile-menu-header button{background:none;border:none;font-size:22px;cursor:pointer;color:var(--text)}
    .mobile-menu a{display:block;padding:16px 24px;color:var(--dark);text-decoration:none;font-weight:500;border-bottom:1px solid #f9f9f9;transition:all .2s}
    .mobile-menu a:hover{color:var(--p);padding-left:32px;background:var(--pl)}
    .mobile-menu .btn-login{margin:20px 24px;display:flex;justify-content:center}

    /* HERO */
    .hero{min-height:100vh;background:linear-gradient(135deg,#2b2c40 0%,#3d3e5c 40%,#2b2c40 100%);display:flex;align-items:center;padding-top:80px;position:relative;overflow:hidden}
    .hero-circle1{position:absolute;top:-100px;right:-100px;width:500px;height:500px;background:radial-gradient(circle,rgba(105,108,255,.2) 0%,transparent 70%);border-radius:50%;animation:fl1 6s ease-in-out infinite}
    .hero-circle2{position:absolute;bottom:-150px;left:-100px;width:400px;height:400px;background:radial-gradient(circle,rgba(145,85,253,.15) 0%,transparent 70%);border-radius:50%;animation:fl2 8s ease-in-out infinite}
    .hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(105,108,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(105,108,255,.05) 1px,transparent 1px);background-size:50px 50px}
    @keyframes fl1{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(-20px,20px) scale(1.05)}}
    @keyframes fl2{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(20px,-20px) scale(1.05)}}
    .hero-inner{max-width:1200px;margin:0 auto;padding:80px 24px;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;position:relative;z-index:1}
    .hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(105,108,255,.15);border:1px solid rgba(105,108,255,.3);color:#a8aaff;padding:7px 18px;border-radius:50px;font-size:13px;font-weight:500;margin-bottom:24px;opacity:0;animation:fiu .6s ease .1s forwards}
    .hero-title{font-size:50px;font-weight:800;color:#fff;line-height:1.15;margin-bottom:20px;letter-spacing:-1px;opacity:0;animation:fiu .7s ease .2s forwards}
    .hl{background:linear-gradient(135deg,#696cff,#9155fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
    .hero-desc{font-size:16px;color:rgba(255,255,255,.65);line-height:1.8;margin-bottom:36px;opacity:0;animation:fiu .8s ease .3s forwards}
    .hero-btns{display:flex;gap:14px;flex-wrap:wrap;opacity:0;animation:fiu .9s ease .4s forwards}
    .btn-hero-p{background:linear-gradient(135deg,var(--p),#9155fd);color:#fff;padding:14px 32px;border-radius:10px;text-decoration:none;font-weight:600;font-size:15px;display:inline-flex;align-items:center;gap:8px;transition:all .3s;box-shadow:0 6px 20px rgba(105,108,255,.4)}
    .btn-hero-p:hover{transform:translateY(-3px);box-shadow:0 10px 30px rgba(105,108,255,.5);color:#fff}
    .btn-hero-s{background:rgba(255,255,255,.08);color:rgba(255,255,255,.85);padding:14px 32px;border-radius:10px;text-decoration:none;font-weight:500;font-size:15px;display:inline-flex;align-items:center;gap:8px;border:1px solid rgba(255,255,255,.15);transition:all .3s;cursor:pointer}
    .btn-hero-s:hover{background:rgba(255,255,255,.14);color:#fff;transform:translateY(-2px)}
    .hero-stats{display:flex;gap:36px;margin-top:48px;padding-top:36px;border-top:1px solid rgba(255,255,255,.08);opacity:0;animation:fiu 1s ease .5s forwards}
    .stat-n{cursor:pointer;transition:transform .2s}
    .stat-n:hover{transform:scale(1.1)}
    .stat-n h3{font-size:30px;font-weight:800;color:#fff;line-height:1}
    .stat-n h3 span{color:var(--p)}
    .stat-n p{font-size:12px;color:rgba(255,255,255,.45);margin-top:4px;text-transform:uppercase;letter-spacing:.5px}
    .hero-mockup{opacity:0;animation:fir .8s ease .3s forwards}
    .mockup-win{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.1);border-radius:20px;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,.4);cursor:pointer;transition:transform .4s}
    .mockup-win:hover{transform:scale(1.02) translateY(-4px)}
    .mockup-top{background:rgba(255,255,255,.06);padding:14px 18px;display:flex;align-items:center;gap:12px;border-bottom:1px solid rgba(255,255,255,.06)}
    .dots{display:flex;gap:6px}
    .dots span{width:10px;height:10px;border-radius:50%}
    .d1{background:#ff5f57}.d2{background:#febc2e}.d3{background:#28c840}
    .murl{flex:1;background:rgba(255,255,255,.06);border-radius:6px;padding:5px 12px;font-size:11px;color:rgba(255,255,255,.4)}
    .mbody{padding:16px}
    .mcards{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:14px}
    .mc{padding:14px;border-radius:12px;position:relative;overflow:hidden;transition:transform .3s}
    .mc:hover{transform:translateY(-3px)}
    .mc::before{content:'';position:absolute;top:-20px;right:-20px;width:60px;height:60px;border-radius:50%;background:rgba(255,255,255,.1)}
    .mc-p{background:linear-gradient(135deg,#696cff,#9155fd)}
    .mc-s{background:linear-gradient(135deg,#71dd37,#40c100)}
    .mc-w{background:linear-gradient(135deg,#ffab00,#e09600)}
    .mc-i{background:linear-gradient(135deg,#03c3ec,#0095b8)}
    .mc h4{font-size:22px;font-weight:700;color:#fff}
    .mc p{font-size:11px;color:rgba(255,255,255,.75);margin-top:2px}
    .mc i{font-size:22px;color:rgba(255,255,255,.5);float:right;margin-top:-28px}
    .mtable{background:rgba(255,255,255,.04);border-radius:10px;overflow:hidden}
    .mth{display:grid;grid-template-columns:2fr 1fr 1fr;padding:8px 14px;background:rgba(255,255,255,.06);font-size:10px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.5px}
    .mtr{display:grid;grid-template-columns:2fr 1fr 1fr;padding:9px 14px;font-size:12px;color:rgba(255,255,255,.7);border-bottom:1px solid rgba(255,255,255,.04);align-items:center}
    .mtr:last-child{border-bottom:none}
    .mb{display:inline-block;padding:2px 8px;border-radius:4px;font-size:10px;font-weight:600}
    .mb-a{background:rgba(113,221,55,.2);color:#71dd37}
    .mb-r{background:rgba(255,171,0,.2);color:#ffab00}
    .mb-s{background:rgba(255,62,29,.2);color:#ff6b6b}
    @keyframes fiu{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    @keyframes fir{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}

    /* REVEAL */
    .reveal{opacity:0;transform:translateY(30px);transition:opacity .6s ease,transform .6s ease}
    .reveal.visible{opacity:1;transform:translateY(0)}

    /* SECTION COMMONS */
    .sw{max-width:1200px;margin:0 auto;padding:0 24px}
    .chip{display:inline-block;background:var(--pl);color:var(--p);padding:5px 16px;border-radius:50px;font-size:12px;font-weight:600;letter-spacing:.5px;text-transform:uppercase;margin-bottom:14px}
    .sh{font-size:36px;font-weight:700;color:var(--dark);margin-bottom:12px;letter-spacing:-.5px}
    .ss{font-size:15px;color:var(--text);line-height:1.8;max-width:540px;margin-bottom:56px}

    /* FEATURES */
    .features{padding:100px 0;background:var(--bg)}
    .feat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .fc{background:#fff;border-radius:16px;padding:28px;border:1px solid rgba(105,108,255,.08);transition:all .3s;cursor:pointer;position:relative;overflow:hidden;text-decoration:none;display:block}
    .fc::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--p),#9155fd);transform:scaleX(0);transition:transform .3s;transform-origin:left}
    .fc:hover{transform:translateY(-6px);box-shadow:0 12px 40px rgba(105,108,255,.12);border-color:rgba(105,108,255,.2)}
    .fc:hover::before{transform:scaleX(1)}
    .fi{width:52px;height:52px;background:var(--pl);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:18px;transition:all .3s}
    .fc:hover .fi{background:var(--p)}
    .fi i{font-size:24px;color:var(--p);transition:color .3s}
    .fc:hover .fi i{color:#fff}
    .fc h4{font-size:16px;font-weight:600;color:var(--dark);margin-bottom:8px}
    .fc p{font-size:13px;color:var(--text);line-height:1.7}

    /* MODULES */
    .modules{padding:100px 0;background:#fff}
    .mod-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:48px}
    .mod-card{background:var(--bg);border-radius:14px;padding:24px 20px;border:1px solid rgba(105,108,255,.08);transition:all .3s;cursor:pointer;text-align:center;text-decoration:none;display:block}
    .mod-card:hover{background:var(--pl);border-color:var(--p);transform:translateY(-5px);box-shadow:0 10px 30px rgba(105,108,255,.15)}
    .mod-icon{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:26px;color:var(--p);background:var(--pl);transition:all .3s}
    .mod-card:hover .mod-icon{background:var(--p);color:#fff}
    .mod-card h5{font-size:14px;font-weight:600;color:var(--dark);margin-bottom:6px}
    .mod-card p{font-size:12px;color:var(--text);line-height:1.6}

    /* BRANCHES */
    .branches-s{padding:80px 0;background:var(--bg)}
    .branch-flex{display:flex;justify-content:center;gap:16px;flex-wrap:wrap;margin-top:48px}
    .bcard{display:flex;align-items:center;gap:12px;background:#fff;border:1px solid rgba(105,108,255,.1);border-radius:14px;padding:16px 24px;transition:all .3s;cursor:pointer}
    .bcard:hover{background:var(--pl);border-color:var(--p);transform:translateY(-4px);box-shadow:0 8px 25px rgba(105,108,255,.15)}
    .bnum{width:36px;height:36px;background:var(--p);color:#fff;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px}
    .bcard h5{font-size:15px;font-weight:600;color:var(--dark);margin:0}
    .bcard p{font-size:12px;color:var(--text);margin:0}

    /* STATS */
    .stats-s{padding:80px 0;background:linear-gradient(135deg,#2b2c40,#3d3e5c)}
    .stats-g{display:grid;grid-template-columns:repeat(4,1fr);gap:32px;text-align:center}
    .si h3{font-size:42px;font-weight:800;color:#fff;line-height:1}
    .si h3 span{color:var(--p)}
    .si p{font-size:14px;color:rgba(255,255,255,.5);margin-top:8px;text-transform:uppercase;letter-spacing:.5px}
    .si i{font-size:36px;color:var(--p);margin-bottom:12px;display:block}
    .si{cursor:pointer;transition:transform .3s}
    .si:hover{transform:scale(1.08)}

    /* ROLES */
    .roles-s{padding:100px 0;background:var(--bg)}
    .roles-g{display:grid;grid-template-columns:repeat(5,1fr);gap:20px;margin-top:48px}
    .rc{background:#fff;border-radius:16px;padding:28px 16px;text-align:center;border:1px solid rgba(105,108,255,.08);transition:all .3s;cursor:pointer}
    .rc:hover{transform:translateY(-6px);box-shadow:0 12px 35px rgba(105,108,255,.12);border-color:var(--p)}
    .ri{width:60px;height:60px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:26px;transition:all .3s}
    .rc:hover .ri{transform:scale(1.1)}
    .r1{background:rgba(105,108,255,.1);color:var(--p)}
    .r2{background:rgba(145,85,253,.1);color:#9155fd}
    .r3{background:rgba(113,221,55,.1);color:#4caf00}
    .r4{background:rgba(255,171,0,.1);color:var(--warning)}
    .r5{background:rgba(3,195,236,.1);color:var(--info)}
    .rc h5{font-size:13px;font-weight:600;color:var(--dark);margin-bottom:6px}
    .rc p{font-size:12px;color:var(--text);line-height:1.6}

    /* PWA SECTION */
    .pwa-s{padding:80px 0;background:#fff}
    .pwa-inner{display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
    .pwa-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(113,221,55,.1);border:1px solid rgba(113,221,55,.3);color:#4caf00;padding:7px 18px;border-radius:50px;font-size:13px;font-weight:500;margin-bottom:20px}
    .pwa-list{list-style:none;margin-top:24px}
    .pwa-list li{display:flex;align-items:center;gap:12px;padding:10px 0;font-size:14px;color:var(--text);border-bottom:1px solid #f0f0f0}
    .pwa-list li:last-child{border-bottom:none}
    .pwa-list i{font-size:20px;color:var(--p)}
    .pwa-visual{background:linear-gradient(135deg,#2b2c40,#3d3e5c);border-radius:20px;padding:32px;text-align:center}
    .pwa-icon-big{font-size:80px;color:var(--p);display:block;margin-bottom:16px}
    .pwa-visual h4{color:#fff;font-size:20px;font-weight:700;margin-bottom:8px}
    .pwa-visual p{color:rgba(255,255,255,.6);font-size:14px;line-height:1.7}
    .pwa-tags{display:flex;gap:8px;justify-content:center;flex-wrap:wrap;margin-top:16px}
    .pwa-tag{background:rgba(105,108,255,.2);color:#a8aaff;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:500}

    /* CTA */
    .cta-s{padding:100px 0;background:linear-gradient(135deg,#2b2c40,#3d3e5c);text-align:center;position:relative;overflow:hidden}
    .cta-s::before{content:'';position:absolute;top:-50%;left:50%;transform:translateX(-50%);width:600px;height:600px;background:radial-gradient(circle,rgba(105,108,255,.1) 0%,transparent 70%);border-radius:50%}
    .cta-inner{max-width:700px;margin:0 auto;padding:0 24px;position:relative;z-index:1}
    .cta-inner h2{font-size:42px;font-weight:700;color:#fff;margin-bottom:16px}
    .cta-inner p{font-size:17px;color:rgba(255,255,255,.65);margin-bottom:36px;line-height:1.7}
    .cta-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}

    /* FOOTER */
    .footer{background:#0d0d1a;padding:40px 0}
    .footer-inner{max-width:1200px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:gap}
    .footer p{color:rgba(255,255,255,.4);font-size:14px}
    .footer span{color:var(--p)}
    .footer-links{display:flex;gap:20px}
    .footer-links a{color:rgba(255,255,255,.4);font-size:13px;text-decoration:none;transition:color .2s}
    .footer-links a:hover{color:var(--p)}

    @media(max-width:992px){.nav-links{display:none}.nav-toggle{display:block}}
    @media(max-width:768px){
      .hero-inner{grid-template-columns:1fr}.hero-mockup{display:none}.hero-title{font-size:34px}
      .feat-grid{grid-template-columns:1fr}
      .mod-grid{grid-template-columns:repeat(2,1fr)}
      .roles-g{grid-template-columns:repeat(2,1fr)}
      .stats-g{grid-template-columns:repeat(2,1fr)}
      .pwa-inner{grid-template-columns:1fr}
      .footer-inner{flex-direction:column;gap:16px;text-align:center}
    }
    .vh-slide{position:relative;min-height:100vh;display:flex;align-items:center;overflow:hidden}
.vh-slide .vbg{position:absolute;inset:0;background-size:cover;background-position:center;background-repeat:no-repeat;transition:transform 8s ease}
.vh-slide:hover .vbg{transform:scale(1.05)}
.vh-slide .overlay{position:absolute;inset:0}
.vh-slide .vcontent{position:relative;z-index:2;max-width:1200px;margin:0 auto;padding:120px 24px 80px}
  </style>
</head>
<body>

<div class="cursor-glow" id="cursorGlow"></div>
<div class="mobile-overlay" id="mo" onclick="closeMM()"></div>
<div class="mobile-menu" id="mm">
  <div class="mobile-menu-header">
    <span>Velora VMS</span>
    <button onclick="closeMM()"><i class='bx bx-x'></i></button>
  </div>
  <a href="#features" onclick="closeMM()"><i class='bx bx-star me-2'></i>Features</a>
  <a href="#modules" onclick="closeMM()"><i class='bx bx-grid-alt me-2'></i>Modules</a>
  <a href="#branches" onclick="closeMM()"><i class='bx bx-map-pin me-2'></i>Branches</a>
  <a href="#roles" onclick="closeMM()"><i class='bx bx-shield me-2'></i>Roles</a>
  <a href="#pwa" onclick="closeMM()"><i class='bx bx-wifi me-2'></i>Offline PWA</a>
  <a href="{{ route('login') }}" class="btn-login"><i class='bx bx-log-in'></i> Login</a>
</div>

{{-- NAVBAR --}}
<nav class="nav" id="mainNav">
  <div class="nav-inner">
    <a href="{{ url('/') }}" class="nav-brand">
      <img src="{{ asset('assets/img/logo/velora_logo.svg') }}" alt="Velora">
      <span class="nav-brand-text">Velora <span>VMS</span></span>
    </a>
    <div class="nav-links">
      <a href="#features">Features</a>
      <a href="#modules">Modules</a>
      <a href="#branches">Branches</a>
      <a href="#roles">Roles</a>
      <a href="#pwa">PWA</a>
      <a href="{{ route('login') }}" class="btn-login"><i class='bx bx-log-in'></i> Login</a>
    </div>
    <button class="nav-toggle" onclick="openMM()"><i class='bx bx-menu'></i></button>
  </div>
</nav>

{{-- HERO --}}

{{-- SLIDE 1 --}}
<section class="vh-slide" id="home">
  <div class="vbg" style="background-image:url('https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=1600&q=80')"></div>
  <div class="overlay" style="background:linear-gradient(135deg,rgba(43,44,64,0.92) 0%,rgba(105,108,255,0.3) 100%)"></div>
  <div class="vcontent" style="width:100%">
    <div style="max-width:650px">
      <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(105,108,255,.2);border:1px solid rgba(105,108,255,.4);color:#a8aaff;padding:7px 18px;border-radius:50px;font-size:13px;font-weight:500;margin-bottom:28px;opacity:0;animation:fiu .6s ease .1s forwards">
        <i class='bx bx-map-pin'></i> 5 branches across Pakistan
      </div>
      <h1 style="font-size:58px;font-weight:800;color:#fff;line-height:1.1;margin-bottom:20px;letter-spacing:-1px;opacity:0;animation:fiu .7s ease .2s forwards">
        Pakistan's premier<br><span style="background:linear-gradient(135deg,#696cff,#9155fd);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Toyota dealer</span><br>management system
      </h1>
      <p style="font-size:17px;color:rgba(255,255,255,.75);line-height:1.8;margin-bottom:36px;max-width:520px;opacity:0;animation:fiu .8s ease .3s forwards">
        Velora VMS manages your entire Toyota dealership network — inventory, sales, invoices, branch transfers and more from one powerful platform.
      </p>
      <div style="display:flex;gap:14px;flex-wrap:wrap;opacity:0;animation:fiu .9s ease .4s forwards">
        <a href="{{ route('login') }}" class="btn-hero-p"><i class='bx bx-log-in'></i> Access dashboard</a>
        <a href="#features" class="btn-hero-s" onclick="smoothTo('features')"><i class='bx bx-play-circle'></i> Explore features</a>
      </div>
      <div style="display:flex;gap:40px;margin-top:48px;padding-top:32px;border-top:1px solid rgba(255,255,255,.15);opacity:0;animation:fiu 1s ease .5s forwards">
        <div class="stat-n" onclick="smoothTo('branches')"><div style="font-size:32px;font-weight:800;color:#fff">5<span style="color:#696cff">+</span></div><div style="font-size:12px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-top:4px">Branches</div></div>
        <div class="stat-n" onclick="smoothTo('modules')"><div style="font-size:32px;font-weight:800;color:#fff">12<span style="color:#696cff">+</span></div><div style="font-size:12px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-top:4px">Modules</div></div>
        <div class="stat-n" onclick="smoothTo('roles')"><div style="font-size:32px;font-weight:800;color:#fff">5</div><div style="font-size:12px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-top:4px">User roles</div></div>
        <div class="stat-n" onclick="smoothTo('features')"><div style="font-size:32px;font-weight:800;color:#fff">100<span style="color:#696cff">%</span></div><div style="font-size:12px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.5px;margin-top:4px">Role-based</div></div>
      </div>
    </div>
  </div>
</section>

{{-- SLIDE 2 - Features over vehicle --}}
<section class="vh-slide" id="features" style="min-height:80vh">
  <div class="vbg" style="background-image:url('https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=1600&q=80')"></div>
  <div class="overlay" style="background:linear-gradient(to right,rgba(43,44,64,0.97) 50%,rgba(43,44,64,0.4) 100%)"></div>
  <div class="vcontent" style="width:100%">
    <div style="max-width:560px">
      <span class="chip reveal">Why Velora?</span>
      <h2 class="sh reveal" style="color:#fff">Everything your dealership needs</h2>
      <p style="color:rgba(255,255,255,.65);font-size:15px;line-height:1.8;margin-bottom:40px" class="reveal">From vehicle inventory to sales, payments, branch transfers and analytics — all in one place.</p>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <a href="{{ route('login') }}" style="background:rgba(255,255,255,.06);border:1px solid rgba(105,108,255,.2);border-radius:14px;padding:18px;text-decoration:none;transition:all .3s;display:block" class="reveal" onmouseover="this.style.background='rgba(105,108,255,.15)';this.style.borderColor='rgba(105,108,255,.5)'" onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.borderColor='rgba(105,108,255,.2)'">
          <i class='bx bx-car' style="font-size:24px;color:#696cff;display:block;margin-bottom:8px"></i>
          <div style="color:#fff;font-weight:600;font-size:14px;margin-bottom:4px">Vehicle Inventory</div>
          <div style="color:rgba(255,255,255,.5);font-size:12px">Track all vehicles with QR codes</div>
        </a>
        <a href="{{ route('login') }}" style="background:rgba(255,255,255,.06);border:1px solid rgba(105,108,255,.2);border-radius:14px;padding:18px;text-decoration:none;transition:all .3s;display:block" class="reveal" onmouseover="this.style.background='rgba(105,108,255,.15)';this.style.borderColor='rgba(105,108,255,.5)'" onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.borderColor='rgba(105,108,255,.2)'">
          <i class='bx bx-receipt' style="font-size:24px;color:#696cff;display:block;margin-bottom:8px"></i>
          <div style="color:#fff;font-weight:600;font-size:14px;margin-bottom:4px">Sales Management</div>
          <div style="color:rgba(255,255,255,.5);font-size:12px">Track every sale in real-time</div>
        </a>
        <a href="{{ route('login') }}" style="background:rgba(255,255,255,.06);border:1px solid rgba(105,108,255,.2);border-radius:14px;padding:18px;text-decoration:none;transition:all .3s;display:block" class="reveal" onmouseover="this.style.background='rgba(105,108,255,.15)';this.style.borderColor='rgba(105,108,255,.5)'" onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.borderColor='rgba(105,108,255,.2)'">
          <i class='bx bx-file' style="font-size:24px;color:#696cff;display:block;margin-bottom:8px"></i>
          <div style="color:#fff;font-weight:600;font-size:14px;margin-bottom:4px">Invoices & Payments</div>
          <div style="color:rgba(255,255,255,.5);font-size:12px">Email, WhatsApp & print</div>
        </a>
        <a href="{{ route('login') }}" style="background:rgba(255,255,255,.06);border:1px solid rgba(105,108,255,.2);border-radius:14px;padding:18px;text-decoration:none;transition:all .3s;display:block" class="reveal" onmouseover="this.style.background='rgba(105,108,255,.15)';this.style.borderColor='rgba(105,108,255,.5)'" onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.borderColor='rgba(105,108,255,.2)'">
          <i class='bx bx-shield' style="font-size:24px;color:#696cff;display:block;margin-bottom:8px"></i>
          <div style="color:#fff;font-weight:600;font-size:14px;margin-bottom:4px">Role-Based Access</div>
          <div style="color:rgba(255,255,255,.5);font-size:12px">5 roles, branch isolation</div>
        </a>
      </div>
      <a href="{{ route('login') }}" class="btn-hero-p reveal" style="display:inline-flex;margin-top:28px"><i class='bx bx-arrow-right'></i> View all features</a>
    </div>
  </div>
</section>

{{-- SLIDE 3 - Vehicles showcase over car image --}}
<section class="vh-slide" id="vehicles-showcase" style="min-height:80vh">
  <div class="vbg" style="background-image:url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1600&q=80')"></div>
  <div class="overlay" style="background:linear-gradient(to bottom,rgba(43,44,64,0.85) 0%,rgba(43,44,64,0.95) 100%)"></div>
  <div class="vcontent" style="width:100%;text-align:center">
    <span class="chip reveal" style="background:rgba(105,108,255,.2);color:#a8aaff">Our inventory</span>
    <h2 style="font-size:42px;font-weight:700;color:#fff;margin-bottom:12px;letter-spacing:-.5px" class="reveal">Vehicles across our network</h2>
    <p style="color:rgba(255,255,255,.6);font-size:15px;margin-bottom:48px;max-width:540px;margin-left:auto;margin-right:auto" class="reveal">Browse available Toyota vehicles across all 5 branches — click any card to view full details.</p>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px" class="reveal">
      <a href="{{ route('login') }}" style="background:rgba(255,255,255,.06);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.1);border-radius:20px;overflow:hidden;text-decoration:none;transition:all .3s;display:block" onmouseover="this.style.transform='translateY(-8px)';this.style.borderColor='rgba(105,108,255,.5)'" onmouseout="this.style.transform='';this.style.borderColor='rgba(255,255,255,.1)'">
        <div style="background:linear-gradient(135deg,#696cff,#9155fd);height:160px;display:flex;align-items:center;justify-content:center;position:relative">
          <i class='bx bx-car' style="font-size:70px;color:rgba(255,255,255,.2)"></i>
          <span style="position:absolute;top:12px;right:12px;background:#71dd37;color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600">Available</span>
          <span style="position:absolute;bottom:12px;left:12px;color:rgba(255,255,255,.7);font-size:11px;font-weight:500">Lahore Branch</span>
        </div>
        <div style="padding:18px">
          <div style="color:#fff;font-weight:700;font-size:15px;margin-bottom:4px">Toyota Yaris GLi</div>
          <div style="color:rgba(255,255,255,.5);font-size:12px;margin-bottom:12px">Sedan · 2024 · Manual · Petrol</div>
          <div style="display:flex;justify-content:space-between;align-items:center">
            <span style="color:#696cff;font-weight:700;font-size:17px">Rs. 4.8M</span>
            <span style="color:#696cff;font-size:13px;font-weight:600">Details →</span>
          </div>
        </div>
      </a>
      <a href="{{ route('login') }}" style="background:rgba(255,255,255,.06);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.1);border-radius:20px;overflow:hidden;text-decoration:none;transition:all .3s;display:block" onmouseover="this.style.transform='translateY(-8px)';this.style.borderColor='rgba(105,108,255,.5)'" onmouseout="this.style.transform='';this.style.borderColor='rgba(255,255,255,.1)'">
        <div style="background:linear-gradient(135deg,#1a1a2e,#2b2c40);height:160px;display:flex;align-items:center;justify-content:center;position:relative">
          <i class='bx bx-car' style="font-size:70px;color:rgba(255,171,0,.3)"></i>
          <span style="position:absolute;top:12px;right:12px;background:#ffab00;color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600">Reserved</span>
          <span style="position:absolute;bottom:12px;left:12px;color:rgba(255,255,255,.5);font-size:11px">Karachi Branch</span>
        </div>
        <div style="padding:18px">
          <div style="color:#fff;font-weight:700;font-size:15px;margin-bottom:4px">Toyota Hilux XLi</div>
          <div style="color:rgba(255,255,255,.5);font-size:12px;margin-bottom:12px">Pickup · 2024 · Manual · Diesel</div>
          <div style="display:flex;justify-content:space-between;align-items:center">
            <span style="color:#ffab00;font-weight:700;font-size:17px">Rs. 9.2M</span>
            <span style="color:#ffab00;font-size:13px;font-weight:600">Details →</span>
          </div>
        </div>
      </a>
      <a href="{{ route('login') }}" style="background:rgba(255,255,255,.06);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.1);border-radius:20px;overflow:hidden;text-decoration:none;transition:all .3s;display:block" onmouseover="this.style.transform='translateY(-8px)';this.style.borderColor='rgba(105,108,255,.5)'" onmouseout="this.style.transform='';this.style.borderColor='rgba(255,255,255,.1)'">
        <div style="background:linear-gradient(135deg,#0f3460,#16213e);height:160px;display:flex;align-items:center;justify-content:center;position:relative">
          <i class='bx bx-car' style="font-size:70px;color:rgba(3,195,236,.3)"></i>
          <span style="position:absolute;top:12px;right:12px;background:#696cff;color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600">Available</span>
          <span style="position:absolute;bottom:12px;left:12px;color:rgba(255,255,255,.5);font-size:11px">Islamabad Branch</span>
        </div>
        <div style="padding:18px">
          <div style="color:#fff;font-weight:700;font-size:15px;margin-bottom:4px">Land Cruiser GR</div>
          <div style="color:rgba(255,255,255,.5);font-size:12px;margin-bottom:12px">SUV · 2025 · Automatic · Petrol</div>
          <div style="display:flex;justify-content:space-between;align-items:center">
            <span style="color:#03c3ec;font-weight:700;font-size:17px">Rs. 38M</span>
            <span style="color:#03c3ec;font-size:13px;font-weight:600">Details →</span>
          </div>
        </div>
      </a>
    </div>
    <a href="{{ route('login') }}" class="btn-hero-p reveal" style="display:inline-flex;margin-top:36px"><i class='bx bx-grid-alt'></i> View all vehicles</a>
  </div>
</section>

{{-- MODULES --}}
<section class="modules" id="modules">
  <div class="sw" style="text-align:center">
    <span class="chip reveal">System modules</span>
    <h2 class="sh reveal">12+ powerful modules</h2>
    <p class="ss reveal" style="margin:0 auto 0">Everything in one system — no third-party integrations needed.</p>
    <div class="mod-grid">
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-car'></i></div>
        <h5>Vehicles</h5>
        <p>Full inventory management with images, documents & QR codes</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-receipt'></i></div>
        <h5>Sales</h5>
        <p>Record and track every sale with customer details</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-user'></i></div>
        <h5>Customers</h5>
        <p>Complete CRM with CNIC and purchase history</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-money'></i></div>
        <h5>Payments</h5>
        <p>Cash, cheque and bank transfer records</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-file'></i></div>
        <h5>Invoices</h5>
        <p>Professional invoices with email & WhatsApp sharing</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-purchase-tag-alt'></i></div>
        <h5>Purchases</h5>
        <p>Track supplier purchases and costs</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-transfer'></i></div>
        <h5>Branch transfers</h5>
        <p>Approve/reject vehicle movement between branches</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-line-chart'></i></div>
        <h5>Analytics</h5>
        <p>Charts, revenue by branch and sales trends</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-buildings'></i></div>
        <h5>Branches</h5>
        <p>Multi-city branch management and settings</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-group'></i></div>
        <h5>Users</h5>
        <p>Manage staff, roles and access per branch</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-list-check'></i></div>
        <h5>Audit logs</h5>
        <p>Full activity trail — who did what and when</p>
      </a>
      <a href="{{ route('login') }}" class="mod-card reveal">
        <div class="mod-icon"><i class='bx bx-cog'></i></div>
        <h5>Settings</h5>
        <p>System configuration and preferences</p>
      </a>
    </div>
  </div>
</section>

{{-- BRANCHES --}}
<section class="branches-s" id="branches">
  <div class="sw" style="text-align:center">
    <span class="chip reveal">Our network</span>
    <h2 class="sh reveal">5 branches across Pakistan</h2>
    <p class="ss reveal" style="margin:0 auto 48px">From Lahore to Abbottabad — seamless coordination across all locations.</p>
    <div class="branch-flex">
      <div class="bcard reveal" onclick="smoothTo('modules')"><div class="bnum">1</div><div><h5>Lahore</h5><p>Punjab HQ</p></div></div>
      <div class="bcard reveal" onclick="smoothTo('modules')"><div class="bnum">2</div><div><h5>Islamabad</h5><p>Capital branch</p></div></div>
      <div class="bcard reveal" onclick="smoothTo('modules')"><div class="bnum">3</div><div><h5>Multan</h5><p>South Punjab</p></div></div>
      <div class="bcard reveal" onclick="smoothTo('modules')"><div class="bnum">4</div><div><h5>Karachi</h5><p>Sindh branch</p></div></div>
      <div class="bcard reveal" onclick="smoothTo('modules')"><div class="bnum">5</div><div><h5>Abbottabad</h5><p>KPK branch</p></div></div>
    </div>
  </div>
</section>

{{-- STATS --}}
<section class="stats-s" id="stats">
  <div class="sw">
    <div class="stats-g">
      <div class="si reveal" onclick="smoothTo('features')"><i class='bx bx-car'></i><h3><span id="c1">0</span></h3><p>Vehicles managed</p></div>
      <div class="si reveal" onclick="smoothTo('branches')"><i class='bx bx-buildings'></i><h3><span id="c2">0</span></h3><p>Active branches</p></div>
      <div class="si reveal" onclick="smoothTo('roles')"><i class='bx bx-group'></i><h3><span id="c3">0</span></h3><p>System users</p></div>
      <div class="si reveal" onclick="smoothTo('features')"><i class='bx bx-shield-check'></i><h3><span id="c4">0</span>%</h3><p>Role-based security</p></div>
    </div>
  </div>
</section>

{{-- ROLES --}}
<section class="roles-s" id="roles">
  <div class="sw">
    <span class="chip reveal">Access control</span>
    <h2 class="sh reveal">5 roles, perfect access</h2>
    <p class="ss reveal">Every team member gets exactly the access they need — no more, no less.</p>
    <div class="roles-g">
      <div class="rc reveal" onclick="window.location.href='{{ route('login') }}'">
        <div class="ri r1"><i class='bx bx-crown'></i></div>
        <h5>Super Admin</h5>
        <p>Full system access across all branches and modules</p>
      </div>
      <div class="rc reveal" onclick="window.location.href='{{ route('login') }}'">
        <div class="ri r2"><i class='bx bx-building'></i></div>
        <h5>HO Admin</h5>
        <p>Head office management, reporting and oversight</p>
      </div>
      <div class="rc reveal" onclick="window.location.href='{{ route('login') }}'">
        <div class="ri r3"><i class='bx bx-user-check'></i></div>
        <h5>Branch Manager</h5>
        <p>Manage vehicles, staff and operations at branch</p>
      </div>
      <div class="rc reveal" onclick="window.location.href='{{ route('login') }}'">
        <div class="ri r4"><i class='bx bx-store'></i></div>
        <h5>Sales Staff</h5>
        <p>Process sales and manage customer relationships</p>
      </div>
      <div class="rc reveal" onclick="window.location.href='{{ route('login') }}'">
        <div class="ri r5"><i class='bx bx-calculator'></i></div>
        <h5>Accountant</h5>
        <p>Payments, invoices and all financial records</p>
      </div>
    </div>
  </div>
</section>

{{-- PWA OFFLINE --}}
<section class="pwa-s" id="pwa">
  <div class="sw">
    <div class="pwa-inner">
      <div>
        <div class="pwa-badge"><i class='bx bx-wifi'></i> Offline-first technology</div>
        <h2 class="sh reveal">Works without internet</h2>
        <p style="color:var(--text);font-size:15px;line-height:1.8;" class="reveal">
          Velora VMS is a Progressive Web App — branch staff can keep working even when the internet goes down. Data saves locally and syncs automatically when reconnected.
        </p>
        <ul class="pwa-list reveal">
          <li><i class='bx bx-check-circle'></i> Add vehicles and fill forms while offline</li>
          <li><i class='bx bx-check-circle'></i> Cached pages load instantly without internet</li>
          <li><i class='bx bx-check-circle'></i> Auto-sync when connection is restored</li>
          <li><i class='bx bx-check-circle'></i> Install as a desktop or mobile app</li>
          <li><i class='bx bx-check-circle'></i> Dashboard shows pending sync count</li>
        </ul>
      </div>
      <div class="pwa-visual reveal">
        <i class='bx bx-wifi-off pwa-icon-big'></i>
        <h4>Still working offline</h4>
        <p>Your data is safe. Everything will sync when you reconnect to the internet.</p>
        <div class="pwa-tags">
          <span class="pwa-tag">PWA</span>
          <span class="pwa-tag">Offline-first</span>
          <span class="pwa-tag">Auto sync</span>
          <span class="pwa-tag">Installable</span>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- VEHICLES SHOWCASE --}}
<section style="padding:100px 0;background:var(--bg)" id="vehicles-showcase">
  <div class="sw">
    <span class="chip reveal">Our inventory</span>
    <h2 class="sh reveal">Vehicles across our network</h2>
    <p class="ss reveal">Browse available Toyota vehicles across all 5 branches — updated in real-time.</p>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:48px" class="reveal">
      <a href="{{ route('login') }}" style="background:#fff;border-radius:16px;overflow:hidden;border:1px solid rgba(105,108,255,.1);transition:all .3s;text-decoration:none;display:block" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(105,108,255,.15)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="background:linear-gradient(135deg,#2b2c40,#3d3e5c);height:180px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden">
          <i class='bx bx-car' style="font-size:80px;color:rgba(105,108,255,.3)"></i>
          <span style="position:absolute;top:12px;right:12px;background:#71dd37;color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600">Available</span>
          <span style="position:absolute;bottom:12px;left:12px;background:rgba(105,108,255,.2);color:#a8aaff;padding:4px 12px;border-radius:20px;font-size:11px">Lahore Branch</span>
        </div>
        <div style="padding:20px">
          <h4 style="color:var(--dark);font-size:16px;font-weight:700;margin-bottom:4px">Toyota Yaris GLi</h4>
          <p style="color:var(--text);font-size:13px;margin-bottom:12px">Sedan · 2024 · Manual · Petrol</p>
          <div style="display:flex;justify-content:space-between;align-items:center">
            <span style="color:var(--p);font-size:18px;font-weight:700">Rs. 4,800,000</span>
            <span style="color:var(--p);font-size:13px;font-weight:600">Details →</span>
          </div>
        </div>
      </a>
      <a href="{{ route('login') }}" style="background:#fff;border-radius:16px;overflow:hidden;border:1px solid rgba(105,108,255,.1);transition:all .3s;text-decoration:none;display:block" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(105,108,255,.15)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="background:linear-gradient(135deg,#1a1a2e,#2b2c40);height:180px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden">
          <i class='bx bx-car' style="font-size:80px;color:rgba(113,221,55,.2)"></i>
          <span style="position:absolute;top:12px;right:12px;background:#ffab00;color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600">Reserved</span>
          <span style="position:absolute;bottom:12px;left:12px;background:rgba(113,221,55,.2);color:#71dd37;padding:4px 12px;border-radius:20px;font-size:11px">Karachi Branch</span>
        </div>
        <div style="padding:20px">
          <h4 style="color:var(--dark);font-size:16px;font-weight:700;margin-bottom:4px">Toyota Hilux XLi</h4>
          <p style="color:var(--text);font-size:13px;margin-bottom:12px">Pickup · 2024 · Manual · Diesel</p>
          <div style="display:flex;justify-content:space-between;align-items:center">
            <span style="color:var(--p);font-size:18px;font-weight:700">Rs. 9,200,000</span>
            <span style="color:var(--p);font-size:13px;font-weight:600">Details →</span>
          </div>
        </div>
      </a>
      <a href="{{ route('login') }}" style="background:#fff;border-radius:16px;overflow:hidden;border:1px solid rgba(105,108,255,.1);transition:all .3s;text-decoration:none;display:block" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 40px rgba(105,108,255,.15)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
        <div style="background:linear-gradient(135deg,#0f3460,#16213e);height:180px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden">
          <i class='bx bx-car' style="font-size:80px;color:rgba(3,195,236,.2)"></i>
          <span style="position:absolute;top:12px;right:12px;background:#696cff;color:#fff;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600">Available</span>
          <span style="position:absolute;bottom:12px;left:12px;background:rgba(3,195,236,.2);color:#03c3ec;padding:4px 12px;border-radius:20px;font-size:11px">Islamabad Branch</span>
        </div>
        <div style="padding:20px">
          <h4 style="color:var(--dark);font-size:16px;font-weight:700;margin-bottom:4px">Land Cruiser GR</h4>
          <p style="color:var(--text);font-size:13px;margin-bottom:12px">SUV · 2025 · Automatic · Petrol</p>
          <div style="display:flex;justify-content:space-between;align-items:center">
            <span style="color:var(--p);font-size:18px;font-weight:700">Rs. 38,000,000</span>
            <span style="color:var(--p);font-size:13px;font-weight:600">Details →</span>
          </div>
        </div>
      </a>
    </div>
    <div style="text-align:center;margin-top:36px" class="reveal">
      <a href="{{ route('login') }}" class="btn-hero-p" style="display:inline-flex"><i class='bx bx-grid-alt'></i> View all vehicles</a>
    </div>
  </div>
</section>

{{-- CTA --}}
<section class="cta-s">
  <div class="cta-inner">
    <span class="chip reveal" style="background:rgba(105,108,255,.2);color:#a8aaff">Get started</span>
    <h2 class="reveal">Ready to go live?</h2>
    <p class="reveal">Log in to your Velora VMS dashboard and manage your Toyota dealership network with confidence and clarity.</p>
    <div class="cta-btns reveal">
      <a href="{{ route('login') }}" class="btn-hero-p"><i class='bx bx-log-in'></i> Access dashboard</a>
      <a href="#features" class="btn-hero-s" onclick="smoothTo('features')"><i class='bx bx-info-circle'></i> Learn more</a>
    </div>
  </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
  <div class="footer-inner">
    <p>&copy; {{ date('Y') }} <span>Velora VMS</span> — Vehicle Management System. All rights reserved.</p>
    <div class="footer-links">
      <a href="#features" onclick="smoothTo('features')">Features</a>
      <a href="#modules" onclick="smoothTo('modules')">Modules</a>
      <a href="#branches" onclick="smoothTo('branches')">Branches</a>
      <a href="{{ route('login') }}">Login</a>
    </div>
  </div>
</footer>

<script>
const glow = document.getElementById('cursorGlow');
document.addEventListener('mousemove', e => { glow.style.left = e.clientX+'px'; glow.style.top = e.clientY+'px'; });

function openMM(){ document.getElementById('mm').classList.add('open'); document.getElementById('mo').classList.add('open'); }
function closeMM(){ document.getElementById('mm').classList.remove('open'); document.getElementById('mo').classList.remove('open'); }

function smoothTo(id){ const el=document.getElementById(id); if(el) el.scrollIntoView({behavior:'smooth'}); }

document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', function(e){
    const href = this.getAttribute('href');
    if(href.startsWith('#') && href.length > 1){
      const t = document.querySelector(href);
      if(t){ e.preventDefault(); t.scrollIntoView({behavior:'smooth'}); }
    }
  });
});

window.addEventListener('scroll', () => {
  const nav = document.getElementById('mainNav');
  nav.classList.toggle('scrolled', window.scrollY > 50);
  const sections = ['features','modules','branches','stats','roles','pwa'];
  let cur = '';
  sections.forEach(id => { const el=document.getElementById(id); if(el && window.scrollY >= el.offsetTop-150) cur=id; });
  document.querySelectorAll('.nav-links a').forEach(a => {
    const href = a.getAttribute('href');
    a.classList.toggle('active', href === '#'+cur);
  });
});

const ro = new IntersectionObserver(entries => {
  entries.forEach((e,i) => { if(e.isIntersecting){ setTimeout(()=>e.target.classList.add('visible'), i*80); ro.unobserve(e.target); } });
}, {threshold:0.1});
document.querySelectorAll('.reveal').forEach(el => ro.observe(el));

const so = new IntersectionObserver(entries => {
  if(entries[0].isIntersecting){
    const counter = (id,target) => {
      let n=0; const step=Math.ceil(target/40);
      const t=setInterval(()=>{ n+=step; if(n>=target){n=target;clearInterval(t);} document.getElementById(id).textContent=n; },40);
    };
    counter('c1',20); counter('c2',5); counter('c3',19); counter('c4',100);
    so.disconnect();
  }
}, {threshold:0.3});
so.observe(document.querySelector('.stats-s'));
</script>
</body>
</html>