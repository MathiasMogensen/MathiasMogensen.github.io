<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2D2D2D" id="theme_color">
    <title>Login | Fashion Online</title>
    <!-- Bootstrap stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <!-- Custom styles (styled here to keep login screen not linked to anything) -->
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-content: center;
            justify-content: center;
        }
    </style>
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
</head>

<body class="col-xl-4 col-lg-5 col-md-7 col-sm-8 mx-auto">
    <form method="post">
        <div class="text-danger">@ERRORMSG@</div>
        <div class="form-group">
            <label for="login_user_name">Email</label>
            <input class="form-control" type="text" name="login_user_name" required>
        </div>
        <div class="form-group">
            <label for="login_password">Kodeord</label>
            <input class="form-control" type="password" name="login_password" required>
        </div>
        <button class="btn btn-secondary" type="submit">Login</button>
        <a class="btn btn-secondary" href="?action=register">Opret Bruger</a>
    </form>
</body>