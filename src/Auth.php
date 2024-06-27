<?php

namespace App;
use App\model\User;

/**
 * Auth : this class is used to manage the user authentication.
 */
class Auth {

    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * getUser this fonction get the user in database with his session id.
     * if the user is not connected, it return null.
     *
     * @return User
     */
    public function getUser(): ?User {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_SESSION['auth'] ?? null;
        if ($id === null) {
            return null;
        }
        $query = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $query->execute(['id' => $id]);
        $user = $query->fetchObject(User::class);
        if ($user === false) {
            return null;
        }
        return $user;
    }
    
    /**
     * requireRole this function check if the user is connected and if he has the right role to acces on any page.
     *
     * @param  mixed $roles
     * @return void
     */
    public function requireRole(string ...$roles): void {
        $user = $this->getUser();
        if ($user === null || in_array($user->role, $roles) === false){
            header('Location: /login.php');
            exit();
        }
    }
    
    /**
     * login function check if the user is in the database and if the password is correct.
     *
     * @param  mixed $username
     * @param  mixed $password
     * @return User
     */
    public function login(string $username, string $password): ?User {
        $query = $this->pdo->prepare('SELECT * FROM USERS WHERE username = :username');
        $query->execute(['username' => $username]);
        $user = $query->fetchObject(User::class);
        if ($user === false) {
            return null;
        }
        if (password_verify($password, $user->password)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['auth'] = $user->id;
            return $user;
        }
        return null;
    }

}