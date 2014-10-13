<?php

class LoginModel {

    public function __construct() {
        
    }
    
    public function isLoggedIn()
    {
        return $_SESSION["isLoggedIn"];
    }
    
    public function isLoggedOut()
    {
        return $_SESSION["isLoggedOut"];
    }
    
    public function firstVisitInSession()
    {
        if (isset($_SESSION["isLoggedIn"]))
            return false;
        return true;
    }
    
    public function succeededLogin()
    {
        return $_SESSION["succeededLogin"];
    }
    
    public function failedLogin()
    {
        return $_SESSION["failedLogin"];
    }
    
    public function getFailedLoginMessage()
    {
       return $_SESSION["failedLoginMessage"];
    }

    public function loginUser($userName, $password)
    {
        if (trim($userName, " ") == "")
        {
            $_SESSION["failedLogin"] = true;
            $_SESSION["failedLoginMessage"] = "Användarnamn saknas";
            
        }
        
        else if (trim($password, " ") == "")
        {
            $_SESSION["failedLogin"] = true;
            $_SESSION["failedLoginMessage"] = "Lösenord saknas";
        }
        
        else
        {
            $users = @file("Users.txt");
            
            foreach ($users as $user)
            {
                $userCredentials = explode("::", $user);
            
                if (($userCredentials[0] === $userName) && ($userCredentials[1] === $password))
                {
                    $_SESSION["succeededLogin"] = true;
                    $_SESSION["failedLogin"] = false;
                    $_SESSION["isLoggedIn"] = true;
                    break;
                }
                
                else if (($userCredentials[0] !== $userName) || ($userCredentials[1] !== $password))
                {
                    $_SESSION["failedLogin"] = true;
                    $_SESSION["failedLoginMessage"] = "Felaktigt användarnamn och/eller lösenord";
                }
            }
        }
    }
    
    public function logoutUser()
    {
        if ($_SESSION["isLoggedIn"])
        {
            $_SESSION["isLoggedIn"] = false;
            $_SESSION["isLoggedOut"] = true;
        }
        else
        {
            $_SESSION["isLoggedOut"] = false;
        }
        //setcookie("LoginView::UserName", "", -240);
        //setcookie("LoginView::Password", "", -240);
    }
}