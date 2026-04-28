<!DOCTYPE html>
<html>
<head>

<style>
    *{
        text-align: right;
    }
</style>
    <title>Articles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>

<body class="bg-gray-100">

<div class="max-w-5xl mx-auto py-10">

    <h1 class="text-3xl font-bold mb-8 text-center">
        📰 Articles List
    </h1>

    <div class="grid gap-6">

        @foreach($articles as $article)
            <div class="bg-white p-5 rounded-xl shadow">

                <h2 class="text-xl font-bold">
                    {{ $article->title ?? 'No Title' }}
                </h2>

                <p class="text-gray-600 mt-2">
                    {!! Str::limit($article->content, 150) !!}
                </p>

                <div class="text-sm text-gray-400 mt-3">
                    {{ $article->created_at }}
                </div>

            </div>
        @endforeach

    </div>

    <div class="mt-6">
        {{ $articles->links() }}
    </div>

</div>

</body>
</html>