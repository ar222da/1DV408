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
        $userName = $this->model->getUserName();
        $userSession = $_SERVER['HTTP_USER_AGENT'];
        
        if ($this->view->didUserSubmit())
        {
            $userName = $this->view->getUserName();
            $password = $this->view->getPassword();
            $this->model->loginUser($userName, $password);
                if ($this->model->succeededLogin())
                {
                    $this->model->saveSession($userName, $userSession);
                    $this->view->setStatusMessage("Admin är inloggad");
                        if ($this->view->didUserChoseToBeKeptLoggedIn())
                        {
                            $this->view->setLoginMessage("Inloggning lyckades och vi kommer ihåg dig nästa gång");
                            $time = time();
                            $expirationTime = $time + 90;
                            setcookie('LoginView::UserName', $userName, $expirationTime);
                            setcookie('LoginView::Password', md5($password), $expirationTime);
                            $this->model->saveCookieToFile($userName, md5($password), $expirationTime);
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
            // Hämta ut användarnamn och lösenord från cookien
            $userName = $_COOKIE["LoginView::UserName"];
            $password = $_COOKIE["LoginView::Password"];
            $time = time();
            $this->model->loginUser($userName, $password);
            // Gör en ny kontroll i datalagret och inloggning, så att inte kakan har blivit manipulerad
            if ($this->model->isCookieExpired($userName, $time) === false && $this->model->succeededLogin())
            {            
                $this->view->setStatusMessage("Admin är inloggad");
                $this->view->setLoginMessage("Inloggning lyckades via cookies");
                $this->view->setLogoutButton();
            }
            else if ($this->model->isCookieExpired($userName, $time) || $this->model->failedLogin())
            {
                $this->model->deleteCookieFromFile($userName);
                $this->model->logoutUser();
                $this->view->setStatusMessage("Ej inloggad");
                $this->view->setFormMessage("Felaktig information i cookie");
                $this->view->setForm();
            }
        }
                
        else if ($this->view->didUserLogout())
        {
            if (isset($_COOKIE["LoginView::UserName"]) && isset($_COOKIE["LoginView::Password"]))
            {
                $userName = $_COOKIE["LoginView::UserName"];
                $password = $_COOKIE["LoginView::Password"];
                $this->model->deleteCookieFromFile($userName);
            }
            $userName = $this->model->getUserName();
            $this->model->deleteSession($userName);
            $this->model->logoutUser();
            $this->userNameFunc = "";
            $this->userSession = "";
            $this->view->setStatusMessage("Ej inloggad");
            $this->view->setRegisterButton();
            if ($this->model->isLoggedOut())
                $this->view->setFormMessage("Du har nu loggat ut");
            $this->view->setForm();
        }
        
        else if ($this->model->isLoggedIn() && $this->model->isSessionHijacked($userName, $userSession) === false)
        {
                $this->view->setStatusMessage("Admin är inloggad");
                $this->view->setLogoutButton();
        }
        
        else if ($this->model->isLoggedIn() === false || $this->model->firstVisitInSession() || 
        $this->model->isSessionHijacked($userName, $userSession === true))
        {
            $this->view->setStatusMessage("Ej inloggad");
            $this->view->setRegisterButton();
            $this->view->setForm();
        }
        
        $this->view->setDate();
        return $this->view->showScreen();    
            
    }
        
        
        
        
        
        
   
    
}