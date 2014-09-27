<?php

class LoginView {
    private $model;
   
    public function __construct(LoginModel $model)
    {
        $this->model = $model;
    }
    
    public function didUserSubmit()                                     // Har användaren skickat iväg formuläret?
    {
        if (isset($_POST["login"]))
        {
            $_GET["logout"] = NULL;
            return true;
        }
        return false;
    }
    
    public function didUserLogout()                                     // Har användaren klickat på länken "logga ut"?
    {
        if (isset($_GET["logout"]))
        {
           return true;
        }
        return false;
    }
    
   public function getUserName()                                        // Hämta ut användarnamnet från input-fält i formuläret
   {
       $userName = $_POST["username"];
       return $userName;
   }
   
   public function getPassword()                                        // Hämta ut lösenord från input-fält i formuläret

   {
       $password = $_POST["password"];
       return $password;
   }
    
    public function showScreen()
    {
                                                                        // OBS! Här görs faktiskt en extra HTTP-request varje gång
                                                                        // Viktigt att tänka på när man använder kontroller som använder sig 
                                                                        // av räknare för antal sidbesök i session
        $urlWithParameters = $_SERVER['REQUEST_URI'];                   // Efter att man har loggat genom att ha tryckt på länken
        $url = $_SERVER['PHP_SELF'];                                    // så blir parametrarna som skickas med kvar i URL-fältet
                                                                        // Detta som följer tar bort parametrarna
        if ($urlWithParameters != $url)
        {
            header('Location:'.$url);                                   // En ny HTTP-request          
        }
      
        // Innehållet i HTML-strängen, beror på vad som hämtas från model vad som ska ingå i strängen
        $ret = "                                                           
            <h1>Laborationskod ar222da</h1>";
                                                        
            
            if ($this->model->userAuthenticated())                      // Användare inloggad? Denna returnerar status från $_SESSION
            {
                $ret .= "<h2>Admin är inloggad</h2>";
                
                $numberOfVisitsAsAuthenticated = $this->model->getNumberOfVisitsAsAuthenticated();
                
                if ($numberOfVisitsAsAuthenticated === 1)               // "Inloggning lyckades" ska bara skrivas ut om det är första  
                {                                                       // gången för sessionen som användaren är inloggad.   
                    $ret .= "<p>Inloggning lyckades</p>";               
                }
                
                $ret .= "<a href='?logout'>Logga ut</a>";

            }
            
            else                                                        // Om inte inloggad
            {
               $ret .= "<a href=>Registrera ny användare</a>
                <h2>Ej inloggad</h2>
                <form action='' method='post'>
                    <fieldset>
                    <legend>Login - skriv in användarnamn och lösenord</legend>";
                    $this->model->getNumberOfVisitsAsDeauthenticated();
                    
                                                                        // Skriv ut eventuella felmeddelanden eller statusmeddelande
                    $message = $this->model->getMessage();              // efter utloggning.
                    
                    if (!empty($message))
                    {
                        $ret .="<p>";
                        $ret .=$message;
                        $ret .="</p>";
                    }
                    
                    $userName = $this->getUserName();
                    $ret .="
                    Användarnamn: <input type=text name=username value=$userName>
                    Lösenord: <input type=password name=password>
                    Håll mig inloggad: <input type=checkbox name=keepmeloggedin>
                    <br>
                    <input type='submit' value='Logga in' name='login'/>
                    </fieldset>
                </form>";
            }
        
        return $ret;
    }

}

