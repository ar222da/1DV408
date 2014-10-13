<?php

require_once("LoginModel.php");
require_once("LoginView.php");

class LoginController {
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new LoginModel();
        $this->view = new LoginView($this->model);
    }
    
    public function doLogin()
    {
        if ($this->view->didUserSubmit())
        {
            $userName = $this->view->getUserName();
            $password = $this->view->getPassword();
            $this->model->loginUser($userName, $password);
                if ($this->model->succeededLogin())
                {
                    $this->view->setStatusMessage("Admin är inloggad");
                        if ($this->view->didUserChoseToBeKeptLoggedIn())
                        {
                            $this->view->setLoginMessage("Inloggning lyckades och vi kommer ihåg dig nästa gång");
                            setcookie('LoginView::UserName', $userName, time()+240);
                            setcookie('LoginView::Password', md5($password), time()+240);
                        }
                        else
                        {
                            $this->view->setLoginMessage("Inloggning lyckades");
                        }
                        $this->view->setLogoutButton();
                }
                else if ($this->model->failedLogin())
                {
                    $this->view->setStatusMessage("Ej inloggad");
                    $this->view->setRegisterButton();
                    $message = $this->model->getFailedLoginMessage();
                    $this->view->setFormMessage($message);
                    $this->view->setForm();
                }
        }
        
        else if (isset($_COOKIE["LoginView::UserName"]) && isset($_COOKIE["LoginView::Password"]) && $this->model->firstVisitInSession())
        {
            $userName = $_COOKIE["LoginView::UserName"];
            $password = $_COOKIE["LoginView::Password"];
            var_dump($password);
            // Gör en ny kontroll i datalagret och inloggning, så att inte kakan har blivit manipulerad
            $this->model->loginUser($userName, $password);
            if ($this->model->succeededLogin())
            {
                $this->view->setStatusMessage("Admin är inloggad");
                $this->view->setLoginMessage("Inloggning lyckades via cookies");
                $this->view->setLogoutButton();
            }
            else if ($this->model->failedLogin())
            {
                $this->view->setStatusMessage("Ej inloggad");
                
                //Manipulerad kaka
                //$this->view->setFormMessage($message);
            }
        }
                
        else if ($this->view->didUserLogout())
        {
            $this->model->logoutUser();
            $this->view->setStatusMessage("Ej inloggad");
            $this->view->setRegisterButton();
            if ($this->model->isLoggedOut())
                $this->view->setFormMessage("Du har nu loggat ut");
            $this->view->setForm();
        }

        else
        {
            if ($this->model->isLoggedIn())
            {
                $this->view->setStatusMessage("Admin är inloggad");
                $this->view->setLogoutButton();
            }
            else if ($this->model->isLoggedIn() === false || $this->model->firstVisitInSession())
            {
                $this->view->setStatusMessage("Ej inloggad");
                $this->view->setRegisterButton();
                $this->view->setForm();
            }
            
        }

        return $this->view->showScreen();    
            
    }
        
        
        
        
        
        
   
    
}