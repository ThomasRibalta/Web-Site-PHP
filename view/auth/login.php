<?php
$title = 'Login';
require dirname(__DIR__) . '/../vendor/autoload.php';
use App\Auth;
use App\dbManager\DBManager;
$auth = new Auth(DBManager::pdoConnexion());
if ($auth->getUser()) {
    header('Location: /');
    exit();
}

if (!empty($_POST)) {
    $users = $auth->login($_POST['username'], $_POST['password']);
    if ($users) {
        header('Location: /');
        exit();
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <h3 class="text-center">Login</h3>
        <form method="post" action="/login">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
</div>