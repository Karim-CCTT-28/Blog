<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'مدوّنة') — لوحة الإدارة</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #080b1a; --bg2: #0d1128;
            --accent: #7c3aed; --accent-glow: rgba(124,58,237,0.35);
            --accent2: #06b6d4; --gold: #f59e0b;
            --text: #e2e8f0; --muted: #64748b;
            --error: #f87171; --success: #34d399;
            --card-border: rgba(255,255,255,0.08);
            --input-bg: rgba(255,255,255,0.06);
            --input-border: rgba(255,255,255,0.12);
        }
        body { font-family: 'Cairo', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        .auth-wrapper { display: flex; min-height: 100vh; }

        /* Brand Panel */
        .auth-brand {
            flex: 1; background: linear-gradient(135deg, #1a0533 0%, #0d1128 40%, #0c1445 100%);
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        .brand-content { position: relative; z-index: 2; text-align: center; }
        .brand-logo { font-size: 4rem; color: var(--gold); filter: drop-shadow(0 0 20px rgba(245,158,11,0.6)); animation: float 3s ease-in-out infinite; margin-bottom: 1.5rem; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        .brand-title {
            font-size: 2.8rem; font-weight: 900;
            background: linear-gradient(135deg, #fff 0%, #c4b5fd 50%, #7c3aed 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            margin-bottom: 0.75rem;
        }
        .brand-sub { color: var(--muted); font-size: 1rem; margin-bottom: 2.5rem; }
        .brand-dots { display: flex; justify-content: center; gap: 0.5rem; }
        .brand-dots span { width: 8px; height: 8px; border-radius: 50%; background: var(--accent); animation: pdot 1.5s ease-in-out infinite; }
        .brand-dots span:nth-child(2) { animation-delay:.2s; background:var(--accent2); }
        .brand-dots span:nth-child(3) { animation-delay:.4s; background:var(--gold); }
        @keyframes pdot { 0%,100%{opacity:.4;transform:scale(1)} 50%{opacity:1;transform:scale(1.4)} }
        .brand-bg-shapes { position: absolute; inset: 0; z-index: 1; }
        .shape { position: absolute; border-radius: 50%; filter: blur(80px); animation: drift 10s ease-in-out infinite; }
        .shape-1 { width:350px;height:350px;background:rgba(124,58,237,.25);top:-80px;right:-80px; }
        .shape-2 { width:250px;height:250px;background:rgba(6,182,212,.2);bottom:10%;left:10%;animation-delay:3s; }
        .shape-3 { width:200px;height:200px;background:rgba(245,158,11,.15);bottom:-60px;right:30%;animation-delay:6s; }
        @keyframes drift { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(30px,-20px) scale(1.05)} 66%{transform:translate(-20px,15px) scale(.95)} }

        /* Form Panel */
        .auth-form-panel {
            width: 480px; min-width: 480px;
            display: flex; align-items: center; justify-content: center; padding: 2rem;
            background: var(--bg2); border-right: 1px solid var(--card-border);
        }
        .auth-card { width: 100%; max-width: 420px; }
        .form-title { font-size: 1.9rem; font-weight: 800; margin-bottom: 0.4rem; }
        .form-subtitle { color: var(--muted); font-size: 0.95rem; margin-bottom: 2.5rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; color: var(--muted); font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; letter-spacing: .03em; }
        .form-input {
            width: 100%; padding: 0.85rem 1.1rem;
            background: var(--input-bg); border: 1px solid var(--input-border);
            border-radius: 12px; color: var(--text);
            font-family: 'Cairo', sans-serif; font-size: 1rem;
            transition: all .25s ease; outline: none;
        }
        .form-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(124,58,237,.3); background: rgba(124,58,237,.08); }
        .form-input::placeholder { color: var(--muted); }
        .btn-primary {
            width: 100%; padding: 0.9rem;
            background: linear-gradient(135deg, var(--accent), #5b21b6);
            border: none; border-radius: 12px; color: #fff;
            font-family: 'Cairo', sans-serif; font-size: 1.05rem; font-weight: 700;
            cursor: pointer; transition: all .3s ease; margin-top: .5rem;
            position: relative; overflow: hidden;
        }
        .btn-primary::before { content:''; position:absolute; top:0;left:-100%;right:0;bottom:0; background:linear-gradient(135deg,rgba(255,255,255,.15),transparent); transition:left .4s ease; }
        .btn-primary:hover::before { left: 100%; }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 25px var(--accent-glow); }
        .btn-primary:active { transform:translateY(0); }
        .btn-primary:disabled { opacity: .6; cursor: not-allowed; }
        .auth-link { text-align: center; margin-top: 1.5rem; color: var(--muted); font-size: .9rem; }
        .auth-link a { color: var(--accent); text-decoration: none; font-weight: 600; transition: color .2s; }
        .auth-link a:hover { color: #a78bfa; }
        .alert { padding: .8rem 1rem; border-radius: 10px; font-size: .9rem; margin-bottom: 1.25rem; }
        .alert-error { background:rgba(248,113,113,.1); border:1px solid rgba(248,113,113,.3); color:var(--error); }
        .alert-success { background:rgba(52,211,153,.1); border:1px solid rgba(52,211,153,.3); color:var(--success); }

        #toast {
            position:fixed; top:1.5rem; left:50%; transform:translateX(-50%) translateY(-80px);
            background:#1e293b; border:1px solid var(--card-border); border-radius:12px;
            padding:.9rem 1.5rem; color:var(--text); font-size:.95rem;
            box-shadow:0 20px 60px rgba(0,0,0,.4);
            transition:transform .4s cubic-bezier(.34,1.56,.64,1); z-index:9999;
        }
        #toast.show { transform:translateX(-50%) translateY(0); }

        @media(max-width:768px) {
            .auth-brand { display:none; }
            .auth-form-panel { width:100%; min-width:unset; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div id="toast"></div>
<div class="auth-wrapper">
    <div class="auth-form-panel">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>
    <div class="auth-brand">
        <div class="brand-bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        <div class="brand-content">
            <div class="brand-logo">✦</div>
            <h1 class="brand-title">مدوّنتي</h1>
            <p class="brand-sub">منصة المحتوى الاحترافية</p>
            <div class="brand-dots"><span></span><span></span><span></span></div>
        </div>
    </div>
</div>
<script>
function showToast(msg, type) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.style.borderColor = type === 'error' ? 'rgba(248,113,113,.4)' : 'rgba(52,211,153,.4)';
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3500);
}
</script>
@stack('scripts')
</body>
</html>
