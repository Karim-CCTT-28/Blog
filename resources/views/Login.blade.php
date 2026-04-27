<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>

</head>
<style>
  html,  body{
        height: 100%;
        display: flex;
        gap: 50px;
    }
</style>
<body>


    <h1>/secret-gate-login</h1>
    <form method="POST" action="/login">
        @csrf

        <input type="email" name="email" placeholder="email"><br><br>

        <input name="password" type="password" placeholder="password"><br>

        <button type="submit">Save</button>
    </form>


</body>
</html>