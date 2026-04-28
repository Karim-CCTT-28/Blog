@extends('layouts.main')

@section('title', ($article->title ?? 'مقال'))
@section('nav-articles', 'active')

@push('styles')
    <style>
        .article-wrap {
            background: var(--bg2);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            overflow: hidden;
        }

        .article-top {
            padding: 1.5rem;
            border-bottom: 1px solid var(--card-border);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .article-title {
            font-size: 1.7rem;
            font-weight: 900;
            color: var(--text);
            line-height: 1.35;
            margin-bottom: .5rem;
        }

        .article-meta {
            display: flex;
            gap: .6rem;
            align-items: center;
            color: var(--muted);
            font-size: .9rem;
            flex-wrap: wrap;
        }

        .meta-badge {
            padding: .2rem .6rem;
            border-radius: 999px;
            border: 1px solid var(--card-border);
            background: var(--card);
            color: var(--text);
            font-weight: 700;
            font-size: .82rem;
        }

        .article-actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 38px;
            padding: 0 12px;
            border-radius: 10px;
            border: 1px solid var(--card-border);
            background: var(--card);
            color: var(--text);
            text-decoration: none;
            font-weight: 700;
            transition: all .2s ease;
        }

        .article-actions a:hover {
            background: var(--bg);
        }

        .article-body {
            padding: 1.8rem 1.5rem;
            color: var(--text);
            line-height: 2;
            font-size: 1.05rem;
        }

        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            border: 1px solid var(--card-border);
        }

        .article-body a {
            color: var(--text);
            text-decoration: underline;
        }

        .article-body blockquote {
            border-right: 4px solid var(--text);
            padding: .75rem 1rem;
            margin: 1rem 0;
            background: var(--card);
            border-radius: 0 8px 8px 0;
        }
    </style>
@endpush

@section('content')
    <div class="article-wrap">
        <div class="article-top">
            <div>
                <div class="article-title">{{ $article->title ?? 'بدون عنوان' }}</div>
                <div class="article-meta">
                    <span class="meta-badge">{{ $article->by ?? 'admin' }}</span>
                    <span>{{ $article->updated_at }}</span>
                </div>
            </div>
            <div class="article-actions">
                <a href="/Articles">رجوع</a>
            </div>
        </div>
        <div class="article-body">
            {!! $article->content !!}
        </div>
    </div>
@endsection

<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Posts</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

</head>

<body> -->



    <!-- <h1>/posts</h1>
    <form method="POST" action="/Articles" enctype="multipart/form-data">
        @csrf

        <textarea id="editor" name="content"></textarea>
        <input type="text" name="title">
        <button type="submit">Save</button>
    </form>

    <script> -->
        <!-- ClassicEditor
            .create(document.querySelector('#editor'), {
                simpleUpload: {
                    uploadUrl: '/upload-image',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            })
            .catch(error => {
                console.error(error);
            }); -->

<!-- 
            
    </script>
</body>

</html> -->