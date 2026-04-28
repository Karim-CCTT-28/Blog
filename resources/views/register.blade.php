<!DOCTYPE html>
<html>
<head>
    <title>Admin Register</title>
    <meta charset="UTF-8">
</head>
<body>

<h2>Admin Register</h2>



<form method="POST" action="/register">
    @csrf

    <div>
        <label>Name</label><br>
        <input type="text" name="name">
    </div>
    <br>

    <div>
        <label>Email</label><br>
        <input type="email" name="email">
    </div>
    <br>

    <div>
        <label>Password</label><br>
        <input type="password" name="password">
    </div>
    <br>

    <button type="submit">Register</button>
</form>

</body>
</html>