<?php

require_once ('./config/loader.php');
class auth
{
    
    
    
    public function __construct()
    {
        
        
        
    }
    
    
    
    public function login($key,$password){

        try {
            $query = "SELECT * FROM users (WHERE email =:key OR username=:key) AND password=:password";
            $stmt = $conn->prepare($query);
            $stmt->bindvalue(':key',$key);
            $stmt->bindvalue(':password',$password);
            $stmt->execute();
            $hasuser=$stmt->rowcount();
            $data=$stmt->fetch(PDO::FETCH_OBJ);


            if ($hasuser){
                
                session_start();
                $_SESSION['user_id']=$data->id;
                $_SESSION['user_name']=$data->username;
                $_SESSION['email']=$data->email;
                
                header('location: ./panel/index.php?login=ok');


            }
            
        }catch (Exception $e){
            echo $e->getMessage();
        }
        

        
        
        
    }
    
    
    public function register($username,$email,$password)
    {
        
        
        try {
            $query1= "SELECT * FROM users (WHERE email =:key OR username=:key)";
            $stmt = $conn->prepare($query1);
            $stmt->bindvalue(':key',$username);
            $stmt->bindvalue(':key',$email);
            $stmt->execute(); 
            $has_data=$stmt->rowcount();
            
            if ($has_data){
                header("location: ../panel/login.php?has_data=ok&message= username or email already exists");
            }else{
                $query2="INSERT INTO users SET username=? , email=? , password=?";
                $stmt=$conn->prepare($query2);
                $stmt->bindvalue(1,$username);
                $stmt->bindvalue(2,$email);
                $stmt->bindvalue(1,$password);

                header("location: ../panel/register.php?register=ok&message=account created");



            }
            
        }catch (Exception $e){
            echo $e->getMessage();
        }
        

    }
    
    public function is_logged_in()
    {
        session_start();
        if (isset($_SESSION['user_id'])){
        return true;
        
        }else{
            return false;
        }
    }
    
    
    public function logout()
    {
        
        
        
    }
    

}