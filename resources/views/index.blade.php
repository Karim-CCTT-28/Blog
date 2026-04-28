@extends('layouts.main')

@section('title', 'المقالات')
@section('nav-articles', 'active')

@push('styles')
    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.5rem;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-header span {
            color: var(--muted);
            font-size: 0.95rem;
        }

        .btn-new {
            padding: .65rem 1.4rem;
            background: linear-gradient(135deg, var(--accent), #5b21b6);
            border-radius: 10px;
            color: #fff;
            font-family: 'Cairo', sans-serif;
            font-size: .9rem;
            font-weight: 700;
            text-decoration: none;
            transition: all .25s ease;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .btn-new:hover {
            box-shadow: 0 6px 20px var(--accent-glow);
            transform: translateY(-2px);
        }

        /* Article grid */
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
        }

        .article-card {
            background: var(--bg2);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            overflow: hidden;
            transition: transform .3s ease, box-shadow .3s ease;
            display: flex;
            flex-direction: column;
        }

        .article-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, .4);
        }

        .article-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .card-accent {
            height: 6px;
            background: linear-gradient(90deg, var(--clr-a), var(--clr-b));
        }

        .card-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-meta {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .78rem;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        .card-meta .badge {
            padding: .2rem .6rem;
            border-radius: 20px;
            background: rgba(124, 58, 237, .15);
            color: #a78bfa;
            font-weight: 600;
            font-size: .75rem;
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .75rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-content {
            font-size: .9rem;
            color: var(--muted2, #94a3b8);
            line-height: 1.7;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-author {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .82rem;
            color: var(--muted);
        }

        .author-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .7rem;
            font-weight: 700;
            color: #fff;
        }

        .card-actions {
            display: flex;
            gap: .4rem;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--card-border);
            background: var(--card);
            color: var(--muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            transition: all .2s ease;
            text-decoration: none;
        }

        .btn-icon:hover {
            background: rgba(124, 58, 237, .15);
            color: #a78bfa;
            border-color: rgba(124, 58, 237, .3);
        }

        .btn-icon.danger:hover {
            background: rgba(248, 113, 113, .1);
            color: var(--error);
            border-color: rgba(248, 113, 113, .3);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            color: var(--muted);
        }

        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: .4;
        }

        .empty-state h2 {
            font-size: 1.3rem;
            margin-bottom: .5rem;
            color: var(--text);
        }

        /* Pagination */
        .pagination-wrap {
            margin-top: 2.5rem;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: .4rem;
            list-style: none;
        }

        .pagination .page-item .page-link {
            padding: .5rem .9rem;
            border-radius: 8px;
            background: var(--bg2);
            border: 1px solid var(--card-border);
            color: var(--muted2, #94a3b8);
            font-family: 'Cairo', sans-serif;
            font-size: .9rem;
            text-decoration: none;
            transition: all .2s ease;
            display: block;
        }

        .pagination .page-item.active .page-link,
        .pagination .page-item .page-link:hover {
            background: rgba(124, 58, 237, .2);
            border-color: rgba(124, 58, 237, .4);
            color: #a78bfa;
        }

        .pagination .page-item.disabled .page-link {
            opacity: .4;
            pointer-events: none;
        }
    </style>
@endpush
@section('content')

    <div class="page-header">
        <div>
            <h1>📰 المقالات</h1>
            {{-- الوصول لعدد المقالات الكلي من الكائن --}}
            <span>{{ $articles->total() }} مقال منشور</span>
        </div>
        <a href="/add" class="btn-new">✏️ مقال جديد</a>
    </div>

    {{-- نتحقق إذا كان الكائن يحتوي على مقالات --}}
    @if($articles->count() > 0)
        <div class="articles-grid">
            @php
                $gradients = [
                    ['#7c3aed', '#06b6d4'],
                    ['#f59e0b', '#ef4444'],
                    ['#10b981', '#06b6d4'],
                    ['#ec4899', '#8b5cf6']
                ];
            @endphp

            @foreach($articles as $article)
                @php $g = $gradients[$loop->index % count($gradients)]; @endphp

                <div class="article-card" style="--clr-a:{{ $g[0] }};--clr-b:{{ $g[1] }}">
                    <a class="article-link" href="/Articles/{{ $article->id }}">
                        <div class="card-accent"></div>
                        <div class="card-body">
                            <div class="card-meta">
                                {{-- استخدام -> للوصول للخصائص لأنها الآن Objects --}}
                                <span class="badge">{{ $article->by ?? 'admin' }}</span>
                                <span>{{ $article->updated_at }}</span>
                            </div>
                            <h2 class="card-title">{{ $article->title ?? 'بدون عنوان' }}</h2>
                            {{-- تنظيف المحتوى من وسوم HTML وعرض جزء منه --}}
                            <div class="card-content">{!! \Illuminate\Support\Str::limit(strip_tags($article->content), 150) !!}</div>
                        </div>
                    </a>
                    <div class="card-footer">
                        <div class="card-author">
                            <div class="author-avatar">{{ mb_substr($article->by ?? 'A', 0, 1) }}</div>
                            <span>{{ $article->by ?? 'admin' }}</span>
                        </div>
                        <div class="card-actions">
                            {{-- زر الحذف يمرر الـ ID --}}
                            <button class="btn-icon danger" onclick="deleteArticle({{ $article->id }}, this)" title="حذف">
                                🗑
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- عرض أزرار التنقل بين الصفحات --}}
        <div class="pagination-wrap">
            @if ($articles->hasPages())
                @php
                    $current = $articles->currentPage();
                    $last = $articles->lastPage();
                    $window = 2; // عدد الصفحات قبل/بعد الصفحة الحالية
                    $start = max(1, $current - $window);
                    $end = min($last, $current + $window);
                @endphp

                <ul class="pagination">
                    {{-- Previous --}}
                    <li class="page-item {{ $articles->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $articles->previousPageUrl() ?? '#' }}" aria-label="Previous">
                            ‹
                        </a>
                    </li>

                    {{-- First + leading dots --}}
                    @if ($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $articles->url(1) }}">1</a>
                        </li>
                        @if ($start > 2)
                            <li class="page-item disabled"><span class="page-link">…</span></li>
                        @endif
                    @endif

                    {{-- Page numbers --}}
                    @for ($page = $start; $page <= $end; $page++)
                        <li class="page-item {{ $page === $current ? 'active' : '' }}">
                            <a class="page-link" href="{{ $articles->url($page) }}">{{ $page }}</a>
                        </li>
                    @endfor

                    {{-- Trailing dots + last --}}
                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <li class="page-item disabled"><span class="page-link">…</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $articles->url($last) }}">{{ $last }}</a>
                        </li>
                    @endif

                    {{-- Next --}}
                    <li class="page-item {{ $articles->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $articles->nextPageUrl() ?? '#' }}" aria-label="Next">
                            ›
                        </a>
                    </li>
                </ul>
            @endif
        </div>
    @else
        <div class="empty-state">
            <div class="icon">📭</div>
            <h2>لا توجد مقالات بعد</h2>
            <p>ابدأ بإضافة مقالاتك الأولى</p>
        </div>
    @endif

@endsection
@push('scripts')
    <script>
        async function deleteArticle(id, btn) {
            if (!confirm('هل أنت متأكد من حذف هذا المقال؟')) return;
            btn.textContent = '⏳';
            btn.disabled = true;
            try {
                const res = await fetch(`/Articles/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (res.ok) {
                    showToast('تم الحذف بنجاح', 'success');
                    btn.closest('.article-card').style.opacity = '0';
                    btn.closest('.article-card').style.transition = 'opacity .4s';
                    setTimeout(() => btn.closest('.article-card').remove(), 400);
                } else {
                    showToast('فشل الحذف', 'error');
                    btn.textContent = '🗑'; btn.disabled = false;
                }
            } catch {
                showToast('حدث خطأ', 'error');
                btn.textContent = '🗑'; btn.disabled = false;
            }
        }
    </script>
@endpush