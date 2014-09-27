<?php

class LoginModel {
    
    private $authenticated = false;
    private $message = "";

    public function __construct() {
        
    }
    
    public function userAuthenticated()                                     // Returnerar inloggningsstatus från $_SESSION
    {
        if ($_SESSION["authenticated"] === true)
            return true;
        return false;
    }
    
    public function getMessage()
    {
        if ($_SESSION["message"] === 1)
        {
            return "Användarnamn saknas";
        }
        
        else if ($_SESSION["message"] === 2)
        {
            return "Lösenord saknas";
        }

        else if ($_SESSION["message"] === 3)
        {
            return "Felaktigt användarnamn och/eller lösenord";
        }
        
        else if ($_SESSION["message"] === 4)
        {
            if ($_SESSION["counterAsDeauthenticated"] === 2)
                return "Du har nu loggat ut";
            return;
        }

    }

    public function authenticateUser($userName, $password)
    {
        
        if (trim($userName, " ") == "")
        {
            $_SESSION["message"] = 1;
            
        }
        
        else if (trim($password, " ") == "")
        {
            $_SESSION["message"] = 2;
        }
        
        else
        {
            $users = @file("Users.txt");
            
            foreach ($users as $user)
            {
                $userCredentials = explode("::", $user);
            
                if (($userCredentials[0] === $userName) && ($userCredentials[1] === $password))
                {
                    $_SESSION["authenticated"] = true;
                    $_SESSION["counterAsAuthenticated"] = 0;
                    break;
                }
                
                else if (($userCredentials[0] !== $userName) || ($userCredentials[1] !== $password))
                {
                    $_SESSION["message"] = 3;
                    $_SESSION["authenticated"] = false;
                }
            }
        }
    }
        
    public function deauthenticateUser()
    {
        $_SESSION["message"] = 4;
        $_SESSION["authenticated"] = false;
        $_SESSION["counterAsDeauthenticated"] = 0;
    }
    
    public function getNumberOfVisitsAsAuthenticated()
    {
        if (isset($_SESSION["counterAsAuthenticated"]))
        {
            $_SESSION["counterAsAuthenticated"] += 1;
        }
       
        return $_SESSION["counterAsAuthenticated"];
        
    }
    
    public function getNumberOfVisitsAsDeauthenticated()
    {
        if (isset($_SESSION["counterAsDeauthenticated"]))
        {
            $_SESSION["counterAsDeauthenticated"] += 1;
        }
       
        return $_SESSION["counterAsDeauthenticated"];
        
    }
    

}