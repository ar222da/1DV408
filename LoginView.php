<?php

class LoginView {
    private $model;
    private $statusMessage;
    private $loginMessage;
    private $form;
    private $formMessage;
    private $registerButton;
    private $logoutButton;
    private $dateTime;
   
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
    
    public function setDate()
    {
        $d = date('D');
        if ($d === "Mon")
            $sd = "Måndag";
        if ($d === "Tue")
            $sd = "Tisdag";
        if ($d === "Wed")
            $sd = "Onsdag";
        if ($d === "Thu")
            $sd = "Torsdag";
        if ($d === "Fri")
            $sd = "Fredag";
        if ($d === "Sat")
            $sd = "Lördag";
        if ($d === "Sun")
            $sd = "Söndag";
            
        $dn = date('j');
        
        $m = date('M');
        if ($m === "Jan")
            $sm = "Januari";
        if ($m === "Feb")
            $sm = "Februari";
        if ($m === "Mar")
            $sm = "Mars";
        if ($m === "Apr")
            $sm = "April";
        if ($m === "May")
            $sm = "Maj";
        if ($m === "Jun")
            $sm = "Juni";
        if ($m === "Jul")
            $sm = "Juli";
        if ($m === "Aug")
            $sm = "Augusti";
        if ($m === "Sep")
            $sm = "September";
        if ($m === "Oct")
            $sm = "Oktober";
        if ($m === "Nov")
            $sm = "November";
        if ($m === "Dec")
            $sm = "December";
            
        $y = date('Y');
        
        $h = date('H');
        $m = date('i');
        $s = date('s');
        
        $this->dateTime = $sd;
        $this->dateTime .= ", den ";
        $this->dateTime .= $dn;
        $this->dateTime .= " ";
        $this->dateTime .= $sm;
        $this->dateTime .= " år ";
        $this->dateTime .= $y;
        $this->dateTime .=". Klockan är ";
        $this->dateTime .= "[";
        $this->dateTime .= $h;
        $this->dateTime .= ":";
        $this->dateTime .= $m;
        $this->dateTime .= ":";
        $this->dateTime .= $s;
        $this->dateTime .= "].";
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
            $ret .= "<br>";
        }
        
        if (!empty($this->logoutButton))
        {
            $ret .= $this->logoutButton;
            $ret .= "<br><br>";
        }
        
        $ret .= $this->dateTime;

        return $ret;
    }

    
}