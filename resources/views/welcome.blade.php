<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300;1,600&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #03020a;
            --text: #f0ece4;
            --muted: rgba(240,236,228,0.4);
            --accent: #7b5ea7;
            --gold: #c9a84c;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Syne', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== CANVAS PARTICLES ===== */
        #canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* ===== AURORA BG ===== */
        .aurora {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .aurora-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.18;
            animation: drift 12s ease-in-out infinite alternate;
        }

        .aurora-blob:nth-child(1) {
            width: 700px; height: 700px;
            background: #7b5ea7;
            top: -200px; left: -100px;
            animation-delay: 0s;
        }

        .aurora-blob:nth-child(2) {
            width: 500px; height: 500px;
            background: #3a8ec9;
            top: 30%; right: -150px;
            animation-delay: -4s;
        }

        .aurora-blob:nth-child(3) {
            width: 400px; height: 400px;
            background: #c9a84c;
            bottom: -100px; left: 30%;
            animation-delay: -8s;
            opacity: 0.1;
        }

        @keyframes drift {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(60px, 40px) scale(1.1); }
        }

        /* ===== LAYOUT ===== */
        .wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== NAV ===== */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.8rem 4rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            background: rgba(3,2,10,0.5);
            backdrop-filter: blur(20px);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.8s cubic-bezier(0.16,1,0.3,1) both;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #7b5ea7, #3a8ec9);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 0 24px rgba(123,94,167,0.5);
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            background: linear-gradient(90deg, var(--text), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-right {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .btn {
            font-family: 'Syne', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 0.55rem 1.4rem;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.12);
            color: var(--muted);
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn:hover {
            color: var(--text);
            border-color: rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.05);
        }

        .btn-glow {
            background: linear-gradient(135deg, #7b5ea7, #3a8ec9);
            border: none;
            color: white;
            box-shadow: 0 0 24px rgba(123,94,167,0.5), 0 4px 12px rgba(0,0,0,0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.15), transparent);
            transform: rotate(45deg) translateX(-100%);
            transition: transform 0.6s ease;
        }

        .btn-glow:hover::before { transform: rotate(45deg) translateX(100%); }

        .btn-glow:hover {
            box-shadow: 0 0 40px rgba(123,94,167,0.7), 0 4px 20px rgba(0,0,0,0.5);
            transform: translateY(-1px);
        }

        /* ===== HERO ===== */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 8rem 2rem 5rem;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--gold);
            background: rgba(201,168,76,0.08);
            border: 1px solid rgba(201,168,76,0.25);
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            margin-bottom: 3rem;
            animation: fadeUp 0.8s 0.3s both;
        }

        .pill-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--gold);
            animation: blink 1.6s infinite;
        }

        @keyframes blink {
            0%,100% { opacity:1; box-shadow: 0 0 6px var(--gold); }
            50% { opacity:0.2; box-shadow: none; }
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(4rem, 10vw, 9rem);
            font-weight: 300;
            line-height: 1;
            letter-spacing: -0.02em;
            margin-bottom: 0.3rem;
            animation: fadeUp 0.9s 0.4s both;
        }

        .hero-title-italic {
            font-style: italic;
            font-weight: 600;
            background: linear-gradient(135deg, #b57bee 0%, #5ab0e8 50%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            animation: fadeUp 0.9s 0.5s both;
        }

        .hero-sub {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            color: var(--muted);
            max-width: 500px;
            line-height: 1.8;
            margin: 2.5rem auto 4rem;
            animation: fadeUp 0.9s 0.6s both;
        }

        /* ===== CARDS ===== */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            max-width: 960px;
            width: 100%;
            margin: 0 auto;
            animation: fadeUp 0.9s 0.7s both;
        }

        .card {
            position: relative;
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            padding: 2.2rem 1.8rem;
            text-decoration: none;
            color: inherit;
            overflow: hidden;
            transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), border-color 0.3s, box-shadow 0.4s;
            cursor: pointer;
            transform-style: preserve-3d;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(123,94,167,0.1), rgba(58,142,201,0.05));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .card:hover {
            border-color: rgba(123,94,167,0.4);
            box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 40px rgba(123,94,167,0.15);
        }

        .card:hover::before { opacity: 1; }

        .card-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            font-weight: 300;
            line-height: 1;
            color: rgba(255,255,255,0.04);
            position: absolute;
            top: 1rem; right: 1.5rem;
            user-select: none;
        }

        .card-icon-wrap {
            width: 48px; height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1.5rem;
        }

        .card:nth-child(1) .card-icon-wrap { background: rgba(123,94,167,0.15); }
        .card:nth-child(2) .card-icon-wrap { background: rgba(58,142,201,0.15); }
        .card:nth-child(3) .card-icon-wrap { background: rgba(201,168,76,0.15); }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            margin-bottom: 0.75rem;
        }

        .card-desc {
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.7;
        }

        .card-arrow {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.2);
            margin-top: 1.5rem;
            transition: color 0.3s, gap 0.3s;
        }

        .card:hover .card-arrow { color: var(--text); gap: 0.7rem; }

        /* ===== FOOTER ===== */
        footer {
            padding: 2rem 4rem;
            border-top: 1px solid rgba(255,255,255,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: var(--muted);
            letter-spacing: 0.06em;
            animation: fadeUp 0.6s 0.9s both;
        }

        .version-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .version-badge::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 8px #4ade80;
        }

        /* ===== CURSOR GLOW ===== */
        .cursor-glow {
            position: fixed;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(123,94,167,0.1) 0%, transparent 70%);
            pointer-events: none;
            transform: translate(-50%, -50%);
            transition: left 0.1s ease, top 0.1s ease;
            z-index: 0;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            nav { padding: 1.2rem 1.5rem; }
            .cards-grid { grid-template-columns: 1fr; max-width: 400px; }
            footer { flex-direction: column; gap: 0.5rem; padding: 1.5rem; }
        }

        @media (max-width: 480px) {
            .brand-name { display: none; }
        }
    </style>
</head>
<body>

    <div class="aurora">
        <div class="aurora-blob"></div>
        <div class="aurora-blob"></div>
        <div class="aurora-blob"></div>
    </div>

    <div class="cursor-glow" id="cursorGlow"></div>
    <canvas id="canvas"></canvas>

    <div class="wrapper">

        <!-- NAV -->
        <nav>
            <div class="brand">
                <div class="brand-mark">L</div>
                <span class="brand-name">Laravel</span>
            </div>

            @if (Route::has('login'))
            <div class="nav-right">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-glow">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-glow">Commencer →</a>
                    @endif
                @endauth
            </div>
            @endif
        </nav>

        <!-- HERO -->
        <main class="hero">

            <div class="pill">
                <div class="pill-dot"></div>
                Nouveau projet · Laravel {{ app()->version() }}
            </div>

            <h1 class="hero-title">
                Bienvenue dans<br>
                <span class="hero-title-italic">l'excellence.</span>
            </h1>

            <p class="hero-sub">
                Un framework PHP élégant, expressif et puissant.<br>
                Construis des applications web que le monde remarquera.
            </p>

            <div class="cards-grid">

                <a href="https://laravel.com/docs" target="_blank" class="card">
                    <div class="card-num">01</div>
                    <div class="card-icon-wrap">📖</div>
                    <div class="card-title">Documentation</div>
                    <div class="card-desc">Guides complets, références API et tutoriels pour maîtriser chaque aspect du framework.</div>
                    <div class="card-arrow">Lire la doc <span>→</span></div>
                </a>

                <a href="https://laracasts.com" target="_blank" class="card">
                    <div class="card-num">02</div>
                    <div class="card-icon-wrap">🎬</div>
                    <div class="card-title">Laracasts</div>
                    <div class="card-desc">Des milliers de tutoriels vidéo sur Laravel, PHP moderne et l'écosystème JavaScript.</div>
                    <div class="card-arrow">Voir les vidéos <span>→</span></div>
                </a>

                <a href="https://forge.laravel.com" target="_blank" class="card">
                    <div class="card-num">03</div>
                    <div class="card-icon-wrap">🚀</div>
                    <div class="card-title">Déployer</div>
                    <div class="card-desc">Mets ton application en ligne en quelques minutes avec Laravel Forge ou Vapor.</div>
                    <div class="card-arrow">Déployer <span>→</span></div>
                </a>

            </div>
        </main>

        <!-- FOOTER -->
        <footer>
            <span>© {{ date('Y') }} Laravel · Crafted with elegance</span>
            <span class="version-badge">PHP {{ PHP_MAJOR_VERSION }}.{{ PHP_MINOR_VERSION }} · Laravel {{ app()->version() }} · Opérationnel</span>
        </footer>

    </div>

    <script>
        // Cursor glow follow
        const glow = document.getElementById('cursorGlow');
        document.addEventListener('mousemove', e => {
            glow.style.left = e.clientX + 'px';
            glow.style.top  = e.clientY + 'px';
        });

        // Floating particles
        const canvas = document.getElementById('canvas');
        const ctx    = canvas.getContext('2d');
        let W, H, particles = [];

        function resize() {
            W = canvas.width  = window.innerWidth;
            H = canvas.height = window.innerHeight;
        }
        resize();
        window.addEventListener('resize', resize);

        const COLORS = ['rgba(123,94,167,', 'rgba(58,142,201,', 'rgba(201,168,76,'];

        class Particle {
            constructor() { this.reset(); }
            reset() {
                this.x     = Math.random() * W;
                this.y     = Math.random() * H;
                this.vx    = (Math.random() - 0.5) * 0.4;
                this.vy    = (Math.random() - 0.5) * 0.4 - 0.2;
                this.r     = Math.random() * 1.5 + 0.5;
                this.alpha = Math.random() * 0.5 + 0.1;
                this.color = COLORS[Math.floor(Math.random() * COLORS.length)];
            }
            update() {
                this.x += this.vx;
                this.y += this.vy;
                if (this.y < -10 || this.x < -10 || this.x > W + 10) this.reset();
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
                ctx.fillStyle = this.color + this.alpha + ')';
                ctx.fill();
            }
        }

        for (let i = 0; i < 120; i++) particles.push(new Particle());

        (function loop() {
            ctx.clearRect(0, 0, W, H);
            particles.forEach(p => { p.update(); p.draw(); });
            requestAnimationFrame(loop);
        })();

        // 3D Card tilt on hover
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const cx   = rect.left + rect.width  / 2;
                const cy   = rect.top  + rect.height / 2;
                const dx   = (e.clientX - cx) / (rect.width  / 2);
                const dy   = (e.clientY - cy) / (rect.height / 2);
                card.style.transform = `translateY(-8px) rotateX(${-dy * 6}deg) rotateY(${dx * 6}deg) scale(1.01)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });
    </script>

</body>
</html>
