<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'مدوّنتي') — لوحة التحكم</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            /* Classic black & white theme (keep shapes/sizes intact) */
            --bg: #ffffff; --bg2: #ffffff; --bg3: #ffffff;
            --card: rgba(0,0,0,.03); --card-border: rgba(0,0,0,.12);
            --accent: #000000; --accent-glow: rgba(0,0,0,.18);
            --accent2: #000000; --gold: #000000;
            --text: #000000; --muted: rgba(0,0,0,.60); --muted2: rgba(0,0,0,.75);
            --error: #000000; --success: #000000;
        }
        body { font-family: 'Cairo', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        /* Navbar */
        .navbar {
            background: rgba(255,255,255,.92); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--card-border);
            position: sticky; top: 0; z-index: 100;
            padding: 0 2rem;
        }
        .navbar-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 64px; }
        .nav-logo { font-size: 1.4rem; font-weight: 900; color: var(--text); text-decoration:none; }
        .nav-links { display: flex; gap: 0.25rem; align-items: center; }
        .nav-link {
            padding: .5rem 1rem; border-radius: 8px; text-decoration: none;
            color: var(--muted2); font-size: .9rem; font-weight: 600;
            transition: all .2s ease;
        }
        .nav-link:hover { background: var(--card); color: var(--text); }
        .nav-link.active { background: rgba(0,0,0,.06); color: var(--text); }
        .nav-btn {
            padding: .5rem 1.25rem; background: #000;
            border: none; border-radius: 8px; color: #fff;
            font-family: 'Cairo',sans-serif; font-size: .9rem; font-weight: 700;
            cursor: pointer; text-decoration: none; transition: all .2s ease;
        }
        .nav-btn:hover { box-shadow: 0 4px 15px var(--accent-glow); transform: translateY(-1px); }

        /* Page content */
        .page-content { max-width: 1200px; margin: 0 auto; padding: 2.5rem 2rem; }

        /* Toast */
        #toast {
            position:fixed; top:1.5rem; left:50%; transform:translateX(-50%) translateY(-80px);
            background:#fff; border:1px solid var(--card-border); border-radius:12px;
            padding:.9rem 1.5rem; color:var(--text); font-size:.95rem;
            box-shadow:0 20px 60px rgba(0,0,0,.4);
            transition:transform .4s cubic-bezier(.34,1.56,.64,1); z-index:9999;
            font-family:'Cairo',sans-serif;
        }
        #toast.show { transform:translateX(-50%) translateY(0); }
    </style>
    @stack('styles')
</head>
<body>
<div id="toast"></div>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="/Articles" class="nav-logo">✦ مدوّنتي</a>
        <div class="nav-links">
            <a href="/Articles" class="nav-link @yield('nav-articles')">📰 المقالات</a>
            <a href="/add" class="nav-link @yield('nav-add')">✏️ مقال جديد</a>
            <form method="POST" action="/logout" style="margin:0">
                @csrf
                <button type="submit" class="nav-btn">خروج</button>
            </form>
        </div>
    </div>
</nav>

<div class="page-content">
    @yield('content')
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
