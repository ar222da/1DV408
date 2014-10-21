<?php

class LoginModel {

    public function __construct() {
        
    }
    
    public function getUserName()
    {
        return $_SESSION["userName"];
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
            $_SESSION["succeededLogin"] = false;
            $_SESSION["failedLoginMessage"] = "Användarnamn saknas";
            
        }
        
        else if (trim($password, " ") == "")
        {
            $_SESSION["failedLogin"] = true;
            $_SESSION["succeededLogin"] = false;
            $_SESSION["failedLoginMessage"] = "Lösenord saknas";
        }
        
        else
        {
            $users = @file("Users.txt");
            
            foreach ($users as $user)
            {
                $userCredentials = explode("::", $user);
            
                if (($userCredentials[0] === $userName) && ($userCredentials[1] === $password) ||
                (($userCredentials[0] === $userName) && (md5($userCredentials[1]) === $password)))
                {
                    $_SESSION["succeededLogin"] = true;
                    $_SESSION["failedLogin"] = false;
                    $_SESSION["isLoggedIn"] = true;
                    $_SESSION["userName"] = $userName;
                    break;
                }
                
                else if (($userCredentials[0] !== $userName) || ($userCredentials[1] !== $password))
                {
                    $_SESSION["failedLogin"] = true;
                    $_SESSION["succeededLogin"] = false;
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
        $_SESSION["userName"] = "";
        setcookie("LoginView::UserName", "", -240);
        setcookie("LoginView::Password", "", -240);
    }
    
    public function saveCookieToFile($userName, $password, $expirationTime)
    {
        $cookies = @file("Cookies.txt");
        $newCookies = "";
        foreach ($cookies as $cookie)
        {
            $cookieFileColumns = explode("::", $cookie);
            if ($cookieFileColumns[0] != $userName && (trim($cookieFileColumns[0], " ") == ""))
            {
                $newCookies .= $cookieFileColumns[0];
                $newCookies .= "::";
                $newCookies .= $cookieFileColumns[1];
                $newCookies .= "::";
                $newCookies .= $cookieFileColumns[2];
                $newCookies .= "\n";
            }
        }
        $newCookies .= $userName;
        $newCookies .= "::";
        $newCookies .= $password;
        $newCookies .= "::";
        $newCookies .= $expirationTime;
        $newCookies .= "\n";
        file_put_contents("Cookies.txt", $newCookies);
    }
    
    public function deleteCookieFromFile($userName)
    {
        $cookies = @file("Cookies.txt");
        $newCookies = "";
        foreach ($cookies as $cookie)
        {
            $cookieFileColumns = explode("::", $cookie);
            if ($cookieFileColumns[0] != $userName)
            {
                $newCookies .= $cookieFileColumns[0];
                $newCookies .= "::";
                $newCookies .= $cookieFileColumns[1];
                $newCookies .= "::";
                $newCookies .= $cookieFileColumns[2];
                $newCookies .= "\n";
            }
        }
        file_put_contents("Cookies.txt", $newCookies);
    }
    
    public function isCookieExpired($userName, $time)
    {
        $cookies = @file("Cookies.txt");
        
        $detected = false;
        foreach ($cookies as $cookie)
        {
            $cookieFileColumns = explode("::", $cookie);
            if ($cookieFileColumns[0] === $userName)
            {
                if ($time > $cookieFileColumns[2])
                {
                    $detected = true;
                    break;
                }
            }
        }
        return $detected;
    }
    
    public function saveSession($userName, $userSessions)
    {
        $sessions = @file("Sessions.txt");
        $newSessions = "";
        foreach ($sessions as $session)
        {
            $sessionFileColumns = explode("::", $session);
            if ($sessionFileColumns[0] != $userName && (trim($sessionFileColumns[0], " ") == ""))
            {
                $newSessions .= $sessionFileColumns[0];
                $newSessions .= "::";
                $newSessions .= $sessionFileColumns[1];
                $newSessions .= "\n";
            }
        }
        $newSessions .= $userName;
        $newSessions .= "::";
        $newSessions .= $userSessions;
        $newSessions .= "::";
        $newSessions .= "\n";
        file_put_contents("Sessions.txt", $newSessions);
    }
    
    public function isSessionHijacked($userName, $userSessions)
    {
        $sessions = @file("Sessions.txt");
        $userFound = false;
        foreach ($sessions as $session)
        {
            $sessionFileColumns = explode("::", $session);
            if ($sessionFileColumns[0] === $userName)
            {
                $userFound = true;
                break;
            }
        }
        
        if ($userFound === true)
        {
            $detected = false;
            foreach ($sessions as $session)
            {
                $sessionFileColumns = explode("::", $session);
                if ($sessionFileColumns[0] === $userName && $sessionFileColumns[1] != $userSessions)
                {
                    $detected = true;
                    break;
                }
            }
            return $detected;
        }
        else if ($userFound === false)
        {
            return true;
        }
    }
   
    public function deleteSession($userName)
    {
        $sessions = @file("Sessions.txt");
        $newSessions = "";
        foreach ($sessions as $session)
        {
            $sessionFileColumns = explode("::", $session);
            if ($sessionFileColumns[0] != $userName && (trim($sessionFileColumns[0], " ") == ""))
            {
                $newSessions .= $sessionFileColumns[0];
                $newSessions .= "::";
                $newSessions .= $sessionFileColumns[1];
                $newSessions .= "\n";
            }
        }
        file_put_contents("Sessions.txt", $newSessions);
    } 
    
}