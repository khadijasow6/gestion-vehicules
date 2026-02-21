<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription · Laravel</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300;1,600&family=Syne:wght@400;500;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #03020a;
            --card-bg: #ffffff;
            --card-text: #1a1a2e;
            --card-muted: #6b6b8a;
            --card-border: #e8e4f0;
            --surface: #f4f2f9;
            --border: rgba(255,255,255,0.07);
            --text: #f0ece4;
            --muted: rgba(240,236,228,0.4);
            --accent: #7b5ea7;
            --gold: #c9a84c;
            --blue: #3a8ec9;
            --error: #e53e3e;
            --success: #2f855a;
        }

        html, body {
            min-height: 100%;
            background: var(--bg);
            color: var(--text);
            font-family: 'Syne', sans-serif;
            overflow-x: hidden;
        }

        /* ===== AURORA ===== */
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
            filter: blur(110px);
            animation: drift 14s ease-in-out infinite alternate;
        }

        .aurora-blob:nth-child(1) {
            width: 650px; height: 650px;
            background: #7b5ea7;
            opacity: 0.13;
            top: -180px; left: -120px;
            animation-delay: 0s;
        }

        .aurora-blob:nth-child(2) {
            width: 500px; height: 500px;
            background: #3a8ec9;
            opacity: 0.10;
            bottom: -80px; right: -100px;
            animation-delay: -5s;
        }

        .aurora-blob:nth-child(3) {
            width: 350px; height: 350px;
            background: #c9a84c;
            opacity: 0.07;
            top: 40%; left: 55%;
            animation-delay: -9s;
        }

        @keyframes drift {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(50px, 35px) scale(1.1); }
        }

        /* ===== PARTICLES ===== */
        #canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* ===== CURSOR GLOW ===== */
        .cursor-glow {
            position: fixed;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(123,94,167,0.1) 0%, transparent 70%);
            pointer-events: none;
            transform: translate(-50%, -50%);
            transition: left 0.12s ease, top 0.12s ease;
            z-index: 0;
        }

        /* ===== LAYOUT ===== */
        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ===== LEFT PANEL ===== */
        .left-panel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem 4rem;
            border-right: 1px solid var(--border);
            animation: fadeLeft 0.9s cubic-bezier(0.16,1,0.3,1) both;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            text-decoration: none;
        }

        .logo-mark {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--accent), var(--blue));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 1.4rem;
            color: white;
            box-shadow: 0 0 24px rgba(123,94,167,0.4);
            flex-shrink: 0;
        }

        .logo-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            background: linear-gradient(90deg, var(--text), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .left-center {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem 0;
        }

        .left-quote {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.8rem, 4vw, 4.5rem);
            font-weight: 300;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 2rem;
        }

        .left-quote em {
            font-style: italic;
            font-weight: 600;
            background: linear-gradient(135deg, #b57bee, #5ab0e8, var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .left-desc {
            font-size: 0.9rem;
            color: var(--muted);
            line-height: 1.8;
            max-width: 380px;
        }

        /* Steps */
        .steps {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            margin-top: 3rem;
        }

        .step {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            animation: fadeUp 0.6s both;
        }

        .step:nth-child(1) { animation-delay: 0.5s; }
        .step:nth-child(2) { animation-delay: 0.65s; }
        .step:nth-child(3) { animation-delay: 0.8s; }

        .step-num {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(123,94,167,0.12);
            border: 1px solid rgba(123,94,167,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--accent);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .step-text {
            font-size: 0.82rem;
            color: var(--muted);
            line-height: 1.6;
        }

        .step-text strong {
            display: block;
            color: rgba(240,236,228,0.7);
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.1rem;
        }

        .left-footer {
            font-size: 0.72rem;
            color: rgba(240,236,228,0.2);
            letter-spacing: 0.06em;
        }

        /* ===== RIGHT PANEL ===== */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 4rem;
            animation: fadeRight 0.9s cubic-bezier(0.16,1,0.3,1) both;
        }

        /* ===== FORM BOX ===== */
        .form-box {
            width: 100%;
            max-width: 460px;
            background: var(--card-bg);
            border-radius: 24px;
            padding: 2.8rem 3rem;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(123,94,167,0.12), 0 0 60px rgba(123,94,167,0.1);
            color: var(--card-text);
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-eyebrow {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-eyebrow::before {
            content: '';
            width: 20px; height: 1px;
            background: var(--gold);
            opacity: 0.5;
        }

        .form-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 600;
            line-height: 1.1;
            letter-spacing: -0.01em;
            color: var(--card-text);
        }

        .form-title em {
            font-style: italic;
            font-weight: 300;
            color: var(--accent);
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 0.9rem 1.2rem;
            border-radius: 12px;
            font-size: 0.82rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .alert-error {
            background: rgba(229,62,62,0.08);
            border: 1px solid rgba(229,62,62,0.25);
            color: var(--error);
        }

        /* ===== 2-COL GRID ===== */
        .fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .field-full { grid-column: 1 / -1; }

        /* ===== FIELDS ===== */
        .field { margin-bottom: 0; }

        label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--card-muted);
            margin-bottom: 0.45rem;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.85rem;
            opacity: 0.5;
            pointer-events: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: var(--surface);
            border: 1.5px solid var(--card-border);
            border-radius: 12px;
            padding: 0.8rem 0.9rem 0.8rem 2.6rem;
            color: var(--card-text);
            font-family: 'Syne', sans-serif;
            font-size: 0.88rem;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s, background 0.3s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(123,94,167,0.12);
            background: #fff;
        }

        input::placeholder { color: #bbb; }

        /* Password strength bar */
        .strength-bar {
            height: 3px;
            border-radius: 4px;
            background: var(--card-border);
            margin-top: 6px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 4px;
            transition: width 0.4s ease, background 0.4s ease;
        }

        .error-msg {
            font-size: 0.72rem;
            color: var(--error);
            margin-top: 0.35rem;
            padding-left: 0.1rem;
        }

        /* ===== SUBMIT ===== */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--blue) 100%);
            color: white;
            font-family: 'Syne', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            margin-top: 1.6rem;
            box-shadow: 0 0 30px rgba(123,94,167,0.35), 0 8px 24px rgba(0,0,0,0.3);
            transition: box-shadow 0.3s, transform 0.2s;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: -50%; left: -60%;
            width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.12), transparent);
            transform: rotate(45deg);
            transition: left 0.6s ease;
        }

        .btn-submit:hover::before { left: 60%; }

        .btn-submit:hover {
            box-shadow: 0 0 50px rgba(123,94,167,0.55), 0 8px 32px rgba(0,0,0,0.4);
            transform: translateY(-1px);
        }

        .btn-submit:active { transform: translateY(0); }

        /* ===== LOGIN LINK ===== */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.6rem 0 1.2rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--card-border);
        }

        .divider span {
            font-size: 0.7rem;
            color: var(--card-muted);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .login-cta {
            text-align: center;
            font-size: 0.82rem;
            color: var(--card-muted);
        }

        .login-cta a {
            text-decoration: none;
            font-weight: 700;
            background: linear-gradient(135deg, #7b5ea7, #3a8ec9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: opacity 0.2s;
        }

        .login-cta a:hover { opacity: 0.7; }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeRight {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .page { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.5rem; min-height: 100vh; }
        }

        @media (max-width: 480px) {
            .fields-grid { grid-template-columns: 1fr; }
            .form-box { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

    <div class="aurora">
        <div class="aurora-blob"></div>
        <div class="aurora-blob"></div>
        <div class="aurora-blob"></div>
    </div>

    <canvas id="canvas"></canvas>
    <div class="cursor-glow" id="cursorGlow"></div>

    <div class="page">

        <!-- ===== LEFT PANEL ===== -->
        <div class="left-panel">
            <a href="{{ url('/') }}" class="logo">
                <div class="logo-mark">L</div>
                <span class="logo-name">Laravel</span>
            </a>

            <div class="left-center">
                <div class="left-quote">
                    Lance ton<br>
                    <em>aventure.</em>
                </div>
                <p class="left-desc">
                    Crée ton compte en quelques secondes et rejoins des milliers de développeurs qui construisent l'avenir avec Laravel.
                </p>

                <div class="steps">
                    <div class="step">
                        <div class="step-num">1</div>
                        <div class="step-text">
                            <strong>Crée ton compte</strong>
                            Remplis le formulaire en 30 secondes.
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-num">2</div>
                        <div class="step-text">
                            <strong>Accède au dashboard</strong>
                            Ton espace de travail t'attend.
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-num">3</div>
                        <div class="step-text">
                            <strong>Construis quelque chose d'incroyable</strong>
                            Laravel te donne tous les outils.
                        </div>
                    </div>
                </div>
            </div>

            <div class="left-footer">© {{ date('Y') }} Laravel · Crafted with elegance</div>
        </div>

        <!-- ===== RIGHT PANEL ===== -->
        <div class="right-panel">
            <div class="form-box">

                <div class="form-header">
                    <div class="form-eyebrow">Nouveau compte</div>
                    <h1 class="form-title">
                        Rejoins-nous,<br><em>c'est gratuit.</em>
                    </h1>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="fields-grid">

                        {{-- Name --}}
                        <div class="field field-full">
                            <label for="name">Nom complet</label>
                            <div class="input-wrap">
                                <span class="input-icon">👤</span>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Jean Dupont"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    class="{{ $errors->has('name') ? 'input-error' : '' }}"
                                >
                            </div>
                            @error('name')
                                <div class="error-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="field field-full">
                            <label for="email">Adresse e-mail</label>
                            <div class="input-wrap">
                                <span class="input-icon">✉</span>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="toi@exemple.com"
                                    required
                                    autocomplete="username"
                                    class="{{ $errors->has('email') ? 'input-error' : '' }}"
                                >
                            </div>
                            @error('email')
                                <div class="error-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="field">
                            <label for="password">Mot de passe</label>
                            <div class="input-wrap">
                                <span class="input-icon">🔑</span>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="new-password"
                                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                                >
                            </div>
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            @error('password')
                                <div class="error-msg">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="field">
                            <label for="password_confirmation">Confirmation</label>
                            <div class="input-wrap">
                                <span class="input-icon">🔒</span>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="new-password"
                                    class="{{ $errors->has('password_confirmation') ? 'input-error' : '' }}"
                                >
                            </div>
                            @error('password_confirmation')
                                <div class="error-msg">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <button type="submit" class="btn-submit">
                        Créer mon compte →
                    </button>

                    <div class="divider"><span>ou</span></div>

                    <div class="login-cta">
                        Déjà un compte ?
                        <a href="{{ route('login') }}">Se connecter</a>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        // Cursor glow
        const glow = document.getElementById('cursorGlow');
        document.addEventListener('mousemove', e => {
            glow.style.left = e.clientX + 'px';
            glow.style.top  = e.clientY + 'px';
        });

        // Particles
        const canvas = document.getElementById('canvas');
        const ctx    = canvas.getContext('2d');
        let W, H;

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
                this.vx    = (Math.random() - 0.5) * 0.35;
                this.vy    = (Math.random() - 0.5) * 0.35 - 0.15;
                this.r     = Math.random() * 1.4 + 0.4;
                this.alpha = Math.random() * 0.45 + 0.08;
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

        const particles = Array.from({ length: 100 }, () => new Particle());

        (function loop() {
            ctx.clearRect(0, 0, W, H);
            particles.forEach(p => { p.update(); p.draw(); });
            requestAnimationFrame(loop);
        })();

        // Password strength meter
        const pwInput = document.getElementById('password');
        const fill    = document.getElementById('strengthFill');

        pwInput.addEventListener('input', () => {
            const val = pwInput.value;
            let score = 0;
            if (val.length >= 8)  score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const pct   = (score / 4) * 100;
            const color = score <= 1 ? '#e53e3e' : score === 2 ? '#c9a84c' : score === 3 ? '#3a8ec9' : '#2f855a';
            fill.style.width      = pct + '%';
            fill.style.background = color;
        });

        // Input focus glow
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', () => {
                input.closest('.input-wrap').style.filter = 'drop-shadow(0 0 10px rgba(123,94,167,0.18))';
            });
            input.addEventListener('blur', () => {
                input.closest('.input-wrap').style.filter = '';
            });
        });
    </script>

</body>
</html>
