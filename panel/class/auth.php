<?php

class Auth
{
    private $conn;

    public function __construct()
    {
        require_once('./config/loader.php');
        $this->conn = $conn;
    }

    public function login($key, $password)
    {
        try {
            $query = "SELECT * FROM users WHERE (email = :key OR username = :key)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':key', htmlspecialchars($key));
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_OBJ);
            if ($data && password_verify($password, $data->password)) {
                session_start();
                $_SESSION['user_id'] = $data->id;
                $_SESSION['user_name'] = $data->username;
                $_SESSION['email'] = $data->email;
                $_SESSION['role'] = $data->role;


                header('location: ./index.php?dashboard=ok&login=ok');
            } else {
                header('location: ./login.php?hasuser=no&message=wrong email or username or password');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            header('location: ./error.php');
        }
    }

    public function register($username, $email, $password)
    {
        try {
            $query1 = "SELECT * FROM users WHERE username = :username OR email = :email";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->bindValue(':username', htmlspecialchars($username));
            $stmt1->bindValue(':email', htmlspecialchars($email));
            $stmt1->execute();

            $has_data = $stmt1->rowCount();

            if ($has_data) {
                header("location: ./register.php?hasuser=ok&message=username or email already exists");
            } else {
                $query2 = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->bindValue(':username', htmlspecialchars($username));
                $stmt2->bindValue(':email', htmlspecialchars($email));
                $stmt2->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
                $stmt2->execute();

                header("location: ./login.php?register=ok&message=account created, please login");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            header('location: ./error.php');
        }
    }

    public function is_login()
    {
        if(!isset($_SESSION['user_id'])){
            header('location: ./login.php');
        }

    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('location: ./login.php?logout=ok');
    }

    public function __destruct()
    {
        $this->conn = null; // Close the database connection
    }
}


