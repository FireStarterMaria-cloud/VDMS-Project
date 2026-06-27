<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Invest in Velora VMS — Pakistan's Premier Auto Dealer Platform</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    :root {
      --purple:#696cff; --purple-dark:#4a4dcc;
      --purple-glow:rgba(105,108,255,0.35);
      --gold:#f0c060;
      --bg:#07070f; --bg2:#0d0d1a; --bg3:#121220;
      --glass:rgba(105,108,255,0.06);
      --glass-border:rgba(105,108,255,0.18);
      --text:#f0f0ff; --text-muted:#7a7a9a; --text-dim:#3a3a5a;
    }
    html { scroll-behavior:smooth; }
    body { background:var(--bg); color:var(--text); font-family:'Inter',sans-serif; overflow-x:hidden; cursor:none; }

    /* CURSOR */
    #cur-dot  { width:8px;height:8px;background:var(--purple);border-radius:50%;position:fixed;top:0;left:0;pointer-events:none;z-index:9999;transform:translate(-50%,-50%);transition:transform .1s; }
    #cur-ring { width:22px;height:22px;border:1.5px solid var(--purple-glow);border-radius:50%;position:fixed;top:0;left:0;pointer-events:none;z-index:9998;transform:translate(-50%,-50%);transition:all .12s ease; }
    #cur-glow { width:280px;height:280px;background:radial-gradient(circle,var(--purple-glow) 0%,transparent 70%);border-radius:50%;position:fixed;top:0;left:0;pointer-events:none;z-index:9990;transform:translate(-50%,-50%);transition:all .25s ease;opacity:0.45; }

    /* NAV */
    nav { position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:1.2rem 4rem;background:rgba(7,7,15,0.75);backdrop-filter:blur(20px);border-bottom:1px solid var(--glass-border); }
    .nav-logo { display:flex;align-items:center;gap:12px;text-decoration:none; }
    .nav-logo img { height:30px; }
    .nav-logo span { font-family:'Playfair Display',serif;font-size:1.2rem;color:var(--text); }
    .nav-links { display:flex;gap:2rem;align-items:center; }
    .nav-links a { color:var(--text-muted);text-decoration:none;font-size:0.82rem;letter-spacing:.05em;transition:color .3s; }
    .nav-links a:hover { color:var(--purple); }
    .nav-cta { background:var(--purple)!important;color:#fff!important;padding:.5rem 1.4rem;border-radius:50px;font-size:.8rem!important;transition:box-shadow .3s,transform .2s!important; }
    .nav-cta:hover { box-shadow:0 0 20px var(--purple-glow);transform:translateY(-1px); }

    /* HERO */
    #hero { min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:8rem 2rem 4rem;position:relative;overflow:hidden; }
    .hero-bg { position:absolute;inset:0;background-image:linear-gradient(rgba(105,108,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(105,108,255,.04) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,black 40%,transparent 100%); }
    <div style="position:absolute;inset:0;background:linear-gradient(to bottom, rgba(7,7,15,0.45) 0%, rgba(7,7,15,0.2) 40%, rgba(7,7,15,0.6) 100%);pointer-events:none;"></div>
    .hero-img { position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=1920&q=80') center/cover no-repeat;opacity:0.18; }
    .orb1 { position:absolute;width:500px;height:500px;background:radial-gradient(circle,rgba(105,108,255,.2) 0%,transparent 70%);border-radius:50%;top:-100px;left:50%;transform:translateX(-50%);animation:orb-float 8s ease-in-out infinite;pointer-events:none; }
    .orb2 { position:absolute;width:300px;height:300px;background:radial-gradient(circle,rgba(240,192,96,.08) 0%,transparent 70%);border-radius:50%;bottom:80px;right:5%;animation:orb-float 10s ease-in-out infinite reverse;pointer-events:none; }
    @keyframes orb-float { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(-30px)} }
    .hero-chip { display:inline-flex;align-items:center;gap:8px;background:rgba(105,108,255,.12);border:1px solid rgba(105,108,255,.3);color:#a8aaff;padding:7px 18px;border-radius:50px;font-size:.75rem;font-weight:500;letter-spacing:.08em;margin-bottom:2rem;opacity:0;animation:fade-up .7s .2s forwards; }
    .hero-title { font-family:'Playfair Display',serif;font-size:clamp(2.8rem,7vw,6rem);line-height:1.05;background:linear-gradient(135deg,#fff 0%,#c8c8ff 50%,var(--purple) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:1.5rem;opacity:0;animation:fade-up .8s .35s forwards; }
    .hero-title span { color:var(--gold);-webkit-text-fill-color:var(--gold); }
    .hero-sub { font-size:1.05rem;color:var(--text-muted);max-width:600px;line-height:1.8;margin-bottom:3rem;opacity:0;animation:fade-up .8s .5s forwards; }
    .hero-stats { display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;max-width:860px;width:100%;margin-bottom:3rem;opacity:0;animation:fade-up .9s .65s forwards; }
    .hstat { background:var(--glass);border:1px solid var(--glass-border);border-radius:16px;padding:1.8rem 1rem;text-align:center;position:relative;overflow:hidden;transition:border-color .3s,transform .3s; }
    .hstat::before { content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);width:60%;height:1px;background:linear-gradient(90deg,transparent,var(--purple),transparent); }
    .hstat:hover { border-color:var(--purple);transform:translateY(-4px); }
    .hstat i { font-size:1.6rem;color:var(--purple);display:block;margin-bottom:.6rem; }
    .hstat h3 { font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:700;color:#fff;line-height:1; }
    .hstat h3 span { color:var(--purple); }
    .hstat p { font-size:.7rem;color:var(--text-muted);margin-top:.4rem;text-transform:uppercase;letter-spacing:.1em; }
    .hero-btns { display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;opacity:0;animation:fade-up .8s .8s forwards; }
    .btn-primary { background:var(--purple);color:#fff;padding:.9rem 2.2rem;border-radius:50px;font-size:.9rem;text-decoration:none;font-weight:500;transition:box-shadow .3s,transform .2s;display:inline-flex;align-items:center;gap:8px; }
    .btn-primary:hover { box-shadow:0 0 30px var(--purple-glow),0 0 60px rgba(105,108,255,.2);transform:translateY(-2px); }
    .btn-ghost { background:transparent;color:var(--text-muted);padding:.9rem 2.2rem;border-radius:50px;font-size:.9rem;text-decoration:none;border:1px solid var(--glass-border);transition:border-color .3s,color .3s;display:inline-flex;align-items:center;gap:8px; }
    .btn-ghost:hover { border-color:var(--purple);color:var(--text); }
    @keyframes fade-up { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }

    /* SECTIONS */
    .sec { padding:6rem 4rem; }
    .sec-alt { background:var(--bg2); }
    .sec-header { text-align:center;margin-bottom:4rem; }
    .eyebrow { font-size:.7rem;letter-spacing:.25em;color:var(--purple);text-transform:uppercase;display:block;margin-bottom:1rem; }
    .sec-title { font-family:'Playfair Display',serif;font-size:clamp(1.8rem,3.5vw,2.8rem);background:linear-gradient(135deg,#fff 0%,#c8c8ff 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }
    .sec-line { width:60px;height:2px;background:linear-gradient(90deg,var(--purple),var(--gold));margin:1.2rem auto 0;border-radius:2px; }
    .sec-sub { font-size:.9rem;color:var(--text-muted);line-height:1.8;max-width:560px;margin:.8rem auto 0; }

    /* OPPORTUNITY */
    .opp-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.5rem;max-width:1000px;margin:0 auto; }
    .opp-card { background:var(--bg3);border:1px solid var(--glass-border);border-radius:20px;padding:2rem;transition:all .3s;position:relative;overflow:hidden; }
    .opp-card::before { content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--purple),transparent); }
    .opp-card:hover { border-color:var(--purple);transform:translateY(-6px);box-shadow:0 20px 50px rgba(105,108,255,.12); }
    .opp-icon { width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem;font-size:1.4rem; }
    .opp-card h4 { font-size:1rem;font-weight:600;color:var(--text);margin-bottom:.6rem; }
    .opp-card p { font-size:.83rem;color:var(--text-muted);line-height:1.7; }
    .stat-big { font-family:'Playfair Display',serif;font-size:2.8rem;font-weight:700;color:var(--purple);margin:.6rem 0 .2rem;line-height:1; }

    /* TECH */
    .tech-grid { display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;max-width:1000px;margin:0 auto; }
    .tech-list { list-style:none; }
    .tech-list li { display:flex;align-items:flex-start;gap:14px;padding:1rem 0;border-bottom:1px solid var(--glass-border); }
    .tech-list li:last-child { border-bottom:none; }
    .tech-list i { font-size:1.3rem;color:var(--purple);margin-top:2px;flex-shrink:0; }
    .tech-list h5 { font-size:.9rem;font-weight:600;color:var(--text);margin-bottom:.3rem; }
    .tech-list p { font-size:.8rem;color:var(--text-muted);line-height:1.6;margin:0; }
    .tech-visual { background:var(--bg3);border:1px solid var(--glass-border);border-radius:20px;padding:2.5rem;text-align:center; }
    .tech-visual i { font-size:4rem;color:var(--purple);display:block;margin-bottom:1rem; }
    .tech-visual h3 { font-family:'Playfair Display',serif;font-size:1.4rem;color:var(--text);margin-bottom:.6rem; }
    .tech-visual p { font-size:.83rem;color:var(--text-muted);line-height:1.7; }
    .tech-tags { display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:1.2rem; }
    .tech-tag { background:rgba(105,108,255,.12);color:#a8aaff;padding:4px 14px;border-radius:20px;font-size:.72rem;font-weight:500;border:1px solid var(--glass-border); }

    /* REVENUE */
    .rev-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1.5rem;max-width:900px;margin:0 auto; }
    .rev-card { background:var(--bg3);border:1px solid var(--glass-border);border-radius:20px;padding:2rem;text-align:center;transition:all .3s;position:relative;overflow:hidden; }
    .rev-card::after { content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--purple),var(--gold));transform:scaleX(0);transition:transform .3s; }
    .rev-card:hover { border-color:var(--purple);transform:translateY(-6px);box-shadow:0 20px 50px rgba(105,108,255,.12); }
    .rev-card:hover::after { transform:scaleX(1); }
    .rev-card i { font-size:2.5rem;color:var(--purple);display:block;margin-bottom:1rem; }
    .rev-card h4 { font-size:.95rem;font-weight:600;color:var(--text);margin-bottom:.6rem; }
    .rev-card p { font-size:.8rem;color:var(--text-muted);line-height:1.7; }

    /* ROADMAP */
    .road-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:3rem;position:relative; }
    .road-grid::before { content:'';position:absolute;top:28px;left:12.5%;right:12.5%;height:2px;background:linear-gradient(90deg,var(--purple),var(--gold));z-index:0; }
    .road-item { text-align:center;position:relative;z-index:1;padding:0 1rem; }
    .road-dot { width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.1rem;font-weight:700;border:2px solid var(--purple);transition:all .3s; }
    .road-dot.done { background:var(--purple);color:#fff; }
    .road-dot.active { background:var(--bg);color:var(--purple);box-shadow:0 0 0 6px rgba(105,108,255,.15); }
    .road-dot.soon { background:var(--bg3);color:var(--text-dim);border-color:var(--text-dim); }
    .road-item h5 { font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.4rem; }
    .road-item p { font-size:.75rem;color:var(--text-muted);line-height:1.6; }
    .road-badge { display:inline-block;padding:2px 10px;border-radius:20px;font-size:.68rem;font-weight:600;margin-bottom:.6rem; }
    .done-b { background:rgba(113,221,55,.1);color:#71dd37; }
    .active-b { background:rgba(105,108,255,.15);color:var(--purple); }
    .soon-b { background:rgba(255,255,255,.05);color:var(--text-dim);border:1px solid var(--glass-border); }

    /* CTA */
    #cta { padding:6rem 2rem;text-align:center;position:relative;overflow:hidden; }
    #cta::before { content:'';position:absolute;top:-50%;left:50%;transform:translateX(-50%);width:600px;height:600px;background:radial-gradient(circle,rgba(105,108,255,.08) 0%,transparent 70%);border-radius:50%;pointer-events:none; }
    #cta h2 { font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3rem);background:linear-gradient(135deg,#fff,#c8c8ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:1rem; }
    #cta p { font-size:1rem;color:var(--text-muted);line-height:1.8;max-width:580px;margin:0 auto 2.5rem; }

    /* FOOTER */
    footer { padding:1.8rem 4rem;border-top:1px solid var(--glass-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem; }
    .footer-logo { display:flex;align-items:center;gap:10px;font-family:'Playfair Display',serif;font-size:1rem;color:var(--text); }
    .footer-logo img { height:22px; }
    footer p { font-size:.75rem;color:var(--text-dim); }
    .footer-links { display:flex;gap:1.5rem; }
    .footer-links a { font-size:.78rem;color:var(--text-muted);text-decoration:none;transition:color .2s; }
    .footer-links a:hover { color:var(--purple); }

    /* REVEAL */
    .reveal { opacity:0;transform:translateY(40px);transition:opacity .7s ease,transform .7s ease; }
    .reveal.visible { opacity:1;transform:translateY(0); }
    .rd1{transition-delay:.1s}.rd2{transition-delay:.2s}.rd3{transition-delay:.3s}.rd4{transition-delay:.4s}

    @media(max-width:768px){
      nav{padding:1rem 1.5rem;}
      .sec{padding:4rem 1.5rem;}
      .hero-stats{grid-template-columns:repeat(2,1fr);}
      .tech-grid{grid-template-columns:1fr;}
      .road-grid{grid-template-columns:repeat(2,1fr);}
      .road-grid::before{display:none;}
      footer{padding:1.5rem;flex-direction:column;text-align:center;}
    }
  </style>
</head>
<body>

<div id="cur-dot"></div>
<div id="cur-ring"></div>
<div id="cur-glow"></div>

{{-- NAV --}}
<nav>
  <a href="{{ url('/') }}" class="nav-logo">
    <img src="{{ asset('assets/img/logo/velora_logo.svg') }}" alt="Velora">
    <span>Velora</span>
  </a>
  <div class="nav-links">
    <a href="#opportunity" class="nav-anchor">Opportunity</a>
    <a href="#technology" class="nav-anchor">Technology</a>
    <a href="#revenue" class="nav-anchor">Revenue</a>
    <a href="#roadmap" class="nav-anchor">Roadmap</a>
    @auth
      <a href="{{ route('dashboard') }}" class="nav-cta">Dashboard</a>
    @else
      <a href="{{ route('login') }}" class="nav-cta">Sign In</a>
    @endauth
  </div>
</nav>

{{-- HERO --}}
<section id="hero">
  <div class="hero-bg"></div>
  <div class="hero-img"></div>
  <div class="orb1"></div>
  <div class="orb2"></div>

  <div class="hero-chip"><i class='bx bx-trending-up'></i> Investment Opportunity 2026</div>
  <h1 class="hero-title">Pakistan's first <span>intelligent</span><br>auto dealership platform</h1>
  <p class="hero-sub">Velora VMS is disrupting Pakistan's Rs. 2.4 trillion automotive industry with the first cloud-based, offline-capable, multi-tenant dealership management platform.</p>

  <div class="hero-stats">
    <div class="hstat">
      <i class='bx bx-buildings'></i>
      <h3>2<span>+</span></h3>
      <p>Showrooms live</p>
    </div>
    <div class="hstat">
      <i class='bx bx-car'></i>
      <h3>20<span>+</span></h3>
      <p>Vehicles managed</p>
    </div>
    <div class="hstat">
      <i class='bx bx-group'></i>
      <h3>19<span>+</span></h3>
      <p>Active users</p>
    </div>
    <div class="hstat">
      <i class='bx bx-money'></i>
      <h3>Rs.<span>2.4T</span></h3>
      <p>Market size</p>
    </div>
  </div>

  <div class="hero-btns">
    <a href="#opportunity" class="btn-primary nav-anchor"><i class='bx bx-trending-up'></i> View Opportunity</a>
    <a href="{{ url('/') }}" class="btn-ghost"><i class='bx bx-home'></i> Back to Home</a>
  </div>
</section>

{{-- OPPORTUNITY --}}
<section id="opportunity" class="sec sec-alt">
  <div class="sec-header reveal">
    <span class="eyebrow">Market Opportunity</span>
    <h2 class="sec-title">Why now? Why Pakistan?</h2>
    <div class="sec-line"></div>
    <p class="sec-sub">Pakistan's automotive market is rapidly digitizing — yet 95% of dealerships still use manual processes.</p>
  </div>
  <div class="opp-grid">
    <div class="opp-card reveal rd1">
      <div class="opp-icon" style="background:rgba(105,108,255,.1)"><i class='bx bx-car' style="color:#696cff;font-size:1.4rem;"></i></div>
      <h4>Massive Market</h4>
      <div class="stat-big">Rs. 2.4T</div>
      <p style="font-size:.72rem;color:var(--text-dim);margin-bottom:.6rem;">Pakistan automotive industry annual size</p>
      <p>Over 300,000 vehicles sold annually across Pakistan with minimal digital infrastructure.</p>
    </div>
    <div class="opp-card reveal rd2">
      <div class="opp-icon" style="background:rgba(113,221,55,.08)"><i class='bx bx-trending-up' style="color:#4caf00;font-size:1.4rem;"></i></div>
      <h4>Zero Competition</h4>
      <div class="stat-big">95%</div>
      <p style="font-size:.72rem;color:var(--text-dim);margin-bottom:.6rem;">of dealerships using manual processes</p>
      <p>No comparable multi-tenant, offline-capable platform exists in Pakistan's market today.</p>
    </div>
    <div class="opp-card reveal rd3">
      <div class="opp-icon" style="background:rgba(3,195,236,.08)"><i class='bx bx-globe' style="color:#03c3ec;font-size:1.4rem;"></i></div>
      <h4>Scalable Globally</h4>
      <div class="stat-big">50+</div>
      <p style="font-size:.72rem;color:var(--text-dim);margin-bottom:.6rem;">countries with similar market gaps</p>
      <p>Architecture supports multi-country, multi-currency expansion without code changes.</p>
    </div>
  </div>
</section>

{{-- CINEMATIC VEHICLE SLIDESHOW --}}
<section id="vehicle-slides" style="position:relative;width:100%;height:100vh;overflow:hidden;background:#07070f;">

    {{-- SLIDES --}}
    <div id="slide-track" style="position:absolute;inset:0;">

        {{-- Slide 1 — Corolla --}}
        <div class="vslide active" style="position:absolute;inset:0;opacity:1;transition:opacity 1.5s ease;">
            <div class="vslide-bg" style="position:absolute;inset:-10%;background:url('https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=1920&q=90') center/cover no-repeat;animation:kenburns1 8s ease-in-out forwards;"></div>
            <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(7,7,15,0.75) 0%,rgba(7,7,15,0.4) 50%,rgba(7,7,15,0.7) 100%);"></div>
            <div class="slide-info">
                <div class="slide-eyebrow">Our Fleet — 01 / 04</div>
                <div class="slide-model">Toyota Corolla Altis</div>
                <div class="slide-detail">Sedan &nbsp;·&nbsp; 2024 &nbsp;·&nbsp; Automatic &nbsp;·&nbsp; Petrol</div>
                <div class="slide-price">Rs. 4,800,000</div>
                <div class="slide-badge available">● Available</div>
            </div>
        </div>

        {{-- Slide 2 — Hilux --}}
        <div class="vslide" style="position:absolute;inset:0;opacity:0;transition:opacity 1.5s ease;">
            <div class="vslide-bg" style="position:absolute;inset:-10%;background:url('https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=1920&q=90') center/cover no-repeat;animation:kenburns2 8s ease-in-out forwards;"></div>
            <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(7,7,15,0.8) 0%,rgba(7,7,15,0.35) 60%,rgba(7,7,15,0.75) 100%);"></div>
            <div class="slide-info">
                <div class="slide-eyebrow">Our Fleet — 02 / 04</div>
                <div class="slide-model">Toyota Hilux Revo</div>
                <div class="slide-detail">Pickup &nbsp;·&nbsp; 2024 &nbsp;·&nbsp; Manual &nbsp;·&nbsp; Diesel</div>
                <div class="slide-price">Rs. 9,200,000</div>
                <div class="slide-badge reserved">● Reserved</div>
            </div>
        </div>

        {{-- Slide 3 — Land Cruiser --}}
        <div class="vslide" style="position:absolute;inset:0;opacity:0;transition:opacity 1.5s ease;">
            <div class="vslide-bg" style="position:absolute;inset:-10%;background:url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920&q=90') center/cover no-repeat;animation:kenburns1 8s ease-in-out forwards;"></div>
            <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(7,7,15,0.7) 0%,rgba(7,7,15,0.3) 60%,rgba(7,7,15,0.8) 100%);"></div>
            <div class="slide-info">
                <div class="slide-eyebrow">Our Fleet — 03 / 04</div>
                <div class="slide-model">Land Cruiser GR</div>
                <div class="slide-detail">SUV &nbsp;·&nbsp; 2025 &nbsp;·&nbsp; Automatic &nbsp;·&nbsp; Petrol</div>
                <div class="slide-price">Rs. 38,000,000</div>
                <div class="slide-badge available">● Available</div>
            </div>
        </div>

        {{-- Slide 4 — Yaris --}}
        <div class="vslide" style="position:absolute;inset:0;opacity:0;transition:opacity 1.5s ease;">
            <div class="vslide-bg" style="position:absolute;inset:-10%;background:url('https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=1920&q=90') center/cover no-repeat;animation:kenburns2 8s ease-in-out forwards;"></div>
            <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(7,7,15,0.75) 0%,rgba(7,7,15,0.4) 50%,rgba(7,7,15,0.7) 100%);"></div>
            <div class="slide-info">
                <div class="slide-eyebrow">Our Fleet — 04 / 04</div>
                <div class="slide-model">Toyota Yaris GLi</div>
                <div class="slide-detail">Sedan &nbsp;·&nbsp; 2024 &nbsp;·&nbsp; Manual &nbsp;·&nbsp; Petrol</div>
                <div class="slide-price">Rs. 3,900,000</div>
                <div class="slide-badge available">● Available</div>
            </div>
        </div>

    </div>

    {{-- PROGRESS BARS --}}
    <div style="position:absolute;bottom:40px;left:50%;transform:translateX(-50%);display:flex;gap:10px;z-index:10;">
        <div class="sprog active-prog" data-idx="0"></div>
        <div class="sprog" data-idx="1"></div>
        <div class="sprog" data-idx="2"></div>
        <div class="sprog" data-idx="3"></div>
    </div>

    {{-- NAV ARROWS --}}
    <button onclick="slideGo(-1)" style="position:absolute;left:24px;top:50%;transform:translateY(-50%);z-index:10;background:rgba(105,108,255,0.12);border:1px solid rgba(105,108,255,0.3);color:#a8aaff;width:44px;height:44px;border-radius:50%;font-size:1.2rem;cursor:pointer;transition:all .3s;display:flex;align-items:center;justify-content:center;" onmouseenter="this.style.background='rgba(105,108,255,0.3)'" onmouseleave="this.style.background='rgba(105,108,255,0.12)'">&#8592;</button>
    <button onclick="slideGo(1)"  style="position:absolute;right:24px;top:50%;transform:translateY(-50%);z-index:10;background:rgba(105,108,255,0.12);border:1px solid rgba(105,108,255,0.3);color:#a8aaff;width:44px;height:44px;border-radius:50%;font-size:1.2rem;cursor:pointer;transition:all .3s;display:flex;align-items:center;justify-content:center;" onmouseenter="this.style.background='rgba(105,108,255,0.3)'" onmouseleave="this.style.background='rgba(105,108,255,0.12)'">&#8594;</button>

    {{-- VELORA TAG --}}
    <div style="position:absolute;top:28px;right:32px;font-size:10px;letter-spacing:.2em;color:rgba(105,108,255,0.5);font-family:'Inter',sans-serif;text-transform:uppercase;z-index:10;">Velora VMS — Live Fleet</div>

</section>

<style>
.vslide-bg { will-change:transform; }

@keyframes kenburns1 {
    0%   { transform:scale(1)    translateX(0)     translateY(0); }
    100% { transform:scale(1.12) translateX(-2%)   translateY(-1%); }
}
@keyframes kenburns2 {
    0%   { transform:scale(1.08) translateX(-1%)   translateY(0); }
    100% { transform:scale(1)    translateX(1%)    translateY(-2%); }
}

.slide-info {
    position:absolute;
    bottom:90px; left:60px;
    z-index:5;
    opacity:0;
    transform:translateY(24px);
    transition:opacity .8s ease, transform .8s ease;
}
.vslide.active .slide-info {
    opacity:1;
    transform:translateY(0);
}
.slide-eyebrow {
    font-size:.7rem; letter-spacing:.25em;
    color:rgba(105,108,255,0.8);
    text-transform:uppercase;
    font-family:'Inter',sans-serif;
    margin-bottom:.8rem;
}
.slide-model {
    font-family:'Playfair Display',serif;
    font-size:clamp(2rem,5vw,4rem);
    color:#fff;
    font-weight:700;
    line-height:1.05;
    margin-bottom:.6rem;
    text-shadow:0 4px 30px rgba(0,0,0,0.5);
}
.slide-detail {
    font-size:.85rem;
    color:rgba(255,255,255,0.55);
    font-family:'Inter',sans-serif;
    letter-spacing:.08em;
    margin-bottom:1rem;
}
.slide-price {
    font-size:1.4rem;
    font-weight:700;
    color:var(--gold);
    font-family:'Playfair Display',serif;
    margin-bottom:.8rem;
}
.slide-badge {
    display:inline-block;
    font-size:.72rem;
    font-weight:600;
    padding:5px 16px;
    border-radius:50px;
    letter-spacing:.08em;
    font-family:'Inter',sans-serif;
}
.available  { background:rgba(113,221,55,.12); color:#71dd37; border:1px solid rgba(113,221,55,.3); }
.reserved   { background:rgba(255,171,0,.12);  color:#ffab00; border:1px solid rgba(255,171,0,.3); }

.sprog {
    width:32px; height:3px;
    background:rgba(255,255,255,0.2);
    border-radius:2px;
    cursor:pointer;
    transition:all .3s;
    position:relative;
    overflow:hidden;
}
.sprog.active-prog {
    width:56px;
    background:rgba(105,108,255,0.4);
}
.sprog.active-prog::after {
    content:'';
    position:absolute; top:0; left:0; bottom:0;
    background:var(--purple);
    border-radius:2px;
    animation:prog-fill 5s linear forwards;
}
@keyframes prog-fill {
    from { width:0%; }
    to   { width:100%; }
}
</style>

<script>
(function(){
    let cur = 0;
    const slides = document.querySelectorAll('.vslide');
    const progs  = document.querySelectorAll('.sprog');
    let timer;

    function goTo(idx) {
        slides[cur].classList.remove('active');
        slides[cur].style.opacity = '0';
        progs[cur].classList.remove('active-prog');

        cur = (idx + slides.length) % slides.length;

        slides[cur].classList.add('active');
        slides[cur].style.opacity = '1';
        progs[cur].classList.add('active-prog');

        // Restart kenburns on bg
        const bg = slides[cur].querySelector('.vslide-bg');
        if(bg){ bg.style.animation='none'; void bg.offsetWidth; bg.style.animation=''; }

        clearInterval(timer);
        timer = setInterval(()=>goTo(cur+1), 5000);
    }

    progs.forEach((p,i)=>p.addEventListener('click',()=>goTo(i)));
    window.slideGo = (dir) => goTo(cur + dir);

    timer = setInterval(()=>goTo(cur+1), 5000);
})();
</script>

{{-- FOOTER --}}
<footer>
  <div class="footer-logo">
    <img src="{{ asset('assets/img/logo/velora_logo.svg') }}" alt="Velora">
    Velora Group
  </div>
  <div class="footer-links">
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/company') }}">Company</a>
    @auth <a href="{{ route('dashboard') }}">Dashboard</a> @endauth
  </div>
  <p>&copy; {{ date('Y') }} Velora Group — Confidential Investment Document.</p>
</footer>

<style>
@keyframes dashAnim2 { from{transform:translateX(0)} to{transform:translateX(-50%)} }
</style>

<script>
// Cursor
const dot=document.getElementById('cur-dot'),ring=document.getElementById('cur-ring'),glow=document.getElementById('cur-glow');
document.addEventListener('mousemove',e=>{dot.style.left=e.clientX+'px';dot.style.top=e.clientY+'px';ring.style.left=e.clientX+'px';ring.style.top=e.clientY+'px';glow.style.left=e.clientX+'px';glow.style.top=e.clientY+'px';});
document.querySelectorAll('a,button').forEach(el=>{el.addEventListener('mouseenter',()=>{ring.style.transform='translate(-50%,-50%) scale(1.8)';ring.style.borderColor='var(--purple)';dot.style.transform='translate(-50%,-50%) scale(0.5)';});el.addEventListener('mouseleave',()=>{ring.style.transform='translate(-50%,-50%) scale(1)';ring.style.borderColor='var(--purple-glow)';dot.style.transform='translate(-50%,-50%) scale(1)';});});

// Smooth scroll - no hash in URL
document.querySelectorAll('.nav-anchor').forEach(a=>{a.addEventListener('click',function(e){e.preventDefault();const t=document.querySelector(this.getAttribute('href'));if(t)t.scrollIntoView({behavior:'smooth',block:'start'});});});

// Reveal
const ro=new IntersectionObserver(entries=>{entries.forEach((e,i)=>{if(e.isIntersecting){setTimeout(()=>e.target.classList.add('visible'),i*80);ro.unobserve(e.target);}});},{threshold:0.12});
document.querySelectorAll('.reveal').forEach(el=>ro.observe(el));

// Stars
(function(){const layer=document.getElementById('inv-stars');if(!layer)return;for(let i=0;i<70;i++){const s=document.createElement('div');const sz=Math.random()*1.4+0.4;s.style.cssText=`position:absolute;width:${sz}px;height:${sz}px;border-radius:50%;background:#fff;left:${Math.random()*100}%;top:${Math.random()*55}%;opacity:${Math.random()*0.5+0.1};animation:twinkle2 ${2+Math.random()*3}s ease-in-out infinite;animation-delay:${Math.random()*3}s;`;layer.appendChild(s);}})();

// Car animation
function invLabel(txt,delay=0){return new Promise(r=>setTimeout(()=>{const el=document.getElementById('inv-label');if(el){el.style.opacity='0';setTimeout(()=>{el.textContent=txt;el.style.opacity='1';},300);}r();},delay));}

window.invStart=async function(){
  const car=document.getElementById('inv-car'),sold=document.getElementById('inv-sold'),price=document.getElementById('inv-price'),cust=document.getElementById('inv-customer'),bubble=document.getElementById('inv-bubble'),shake=document.getElementById('inv-shake'),replay=document.getElementById('inv-replay'),light=document.getElementById('inv-light'),name=document.getElementById('inv-name');
  replay.style.opacity='0';car.style.transition='none';car.style.left='-700px';sold.style.transform='translateX(-50%) scale(0)';price.style.opacity='0';cust.style.opacity='0';bubble.style.opacity='0';bubble.textContent='Interested in this fleet!';shake.style.opacity='0';shake.style.transform='scale(0)';light.style.opacity='0';name.style.opacity='0';
  await new Promise(r=>setTimeout(r,200));
  await invLabel('Velora Fleet — Toyota Hilux',0);
  car.style.transition='left 3.5s cubic-bezier(.25,.46,.45,.94)';car.style.left='calc(50% - 210px)';light.style.opacity='1';
  await new Promise(r=>setTimeout(r,1400));name.style.opacity='1';
  await new Promise(r=>setTimeout(r,2200));
  await invLabel('Investor viewing fleet...',0);cust.style.opacity='1';
  await new Promise(r=>setTimeout(r,700));bubble.style.opacity='1';
  await new Promise(r=>setTimeout(r,1500));
  await invLabel('Negotiating deal...',0);price.style.opacity='1';bubble.textContent='I\'ll invest in this!';
  await new Promise(r=>setTimeout(r,1400));
  await invLabel('Investment confirmed — Velora VMS updated',0);bubble.style.opacity='0';shake.style.opacity='1';shake.style.transform='scale(1)';
  await new Promise(r=>setTimeout(r,900));
  price.style.opacity='0';sold.style.transform='translateX(-50%) scale(1)';
  await new Promise(r=>setTimeout(r,1400));
  await invLabel('Deal recorded. Platform updated. ✦',0);shake.style.opacity='0';cust.style.opacity='0';light.style.opacity='0';
  car.style.transition='left 2.2s ease-in';car.style.left='110%';
  await new Promise(r=>setTimeout(r,2400));replay.style.opacity='1';await invLabel('Velora Fleet',0);
};

setTimeout(invStart,600);
</script>
<style>
@keyframes twinkle2{0%,100%{opacity:.2}50%{opacity:.8}}
</style>
</body>
</html>