<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Posts</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

</head>

<body>



    <h1>/posts</h1>
    <form method="POST" action="/Articles" enctype="multipart/form-data">
        @csrf

        <textarea id="editor" name="content"></textarea>
        <input type="text" name="title">
        <!-- <input type="file" multiple name="images[]"> -->
        <button type="submit">Save</button>
    </form>

    <script>
        ClassicEditor
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
            });


            
    </script>
</body>

</html>