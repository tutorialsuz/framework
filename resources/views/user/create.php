<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToPHP framework | Users create sample</title>
</head>
<body>
<form action="http://127.0.0.1:90/users" method="POST">
    <?= csrf_token() ?>
    <?= flash('email') ?>
    <input type="text" name="email" placeholder="email">
    <?= flash('phone') ?>
    <input type="text" name="phone" placeholder="phone">
    <input type="submit" value="Submit">
</form>
</body>
</html>