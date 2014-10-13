<?php

class LoginView {
    private $model;
    private $statusMessage;
    private $loginMessage;
    private $form;
    private $formMessage;
    private $registerButton;
    private $logoutButton;
   
    public function __construct(LoginModel $model)
    {
        $this->model = $model;
    }
    
    public function didUserSubmit()
    {
        if (isset($_POST["login"]))
            return true;
        return false;
    }
    
    public function didUserChoseToBeKeptLoggedIn()                      
    {
        if (isset($_POST["keepmeloggedin"]))
            return true;
        return false;
    }
    
    public function didUserLogout()
    {
        if (isset($_GET["logout"]))
            return true;
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

    public function setStatusMessage($message)
    {
        $this->statusMessage = $message;
    }
   
    public function setLoginMessage($message)
    {
        $this->loginMessage = $message;
    }
    
    public function setFormMessage($message)
    {
        $this->formMessage = $message;
    }

    public function setForm()
    {
        $this->form =  "<form action='?login' method='post'>
                        <fieldset>
                        <legend>Login - skriv in användarnamn och lösenord</legend>";
        if (!empty($this->formMessage))
                        {
                            $this->form .="<p>";
                            $this->form .= $this->formMessage;
                            $this->form .="</p>";
                        }
        $userName = $this->getUserName();
        $this->form .="
                        Användarnamn: <input type=text name=username value='$userName'>
                        Lösenord: <input type=password name=password>
                        Håll mig inloggad: <input type=checkbox name=keepmeloggedin>
                        <br>
                            <input type='submit' value='Logga in' name='login'/>
                        </fieldset>
                        </form>";
    }

    public function setRegisterButton()
    {
        $this->registerButton = "<a href=''>Registrera ny användare</a>";
    }
    
    public function setLogoutButton()
    {
        $this->logoutButton = "<a href='index.php?logout'>Logga ut</a>"; 
    }
       
    public function showScreen()
    {
       // Innehållet i HTML-strängen
        $ret = "                                                           
            <h1>Laborationskod ar222da</h1>";
            
        if (!empty($this->registerButton))
        {
            $ret .= $this->registerButton;
        }
        
        $ret .= "<h2>";
        $ret .= $this->statusMessage;
        $ret .= "</h2>";
        
        if (!empty($this->loginMessage))
        {
            $ret .="<p>";
            $ret .= $this->loginMessage;
            $ret .="</p>";
        }
        
        if (!empty($this->form))
        {
            $ret .= $this->form;
        }
        
        if (!empty($this->logoutButton))
        {
            $ret .= $this->logoutButton;
        }

        return $ret;
    }

    
}