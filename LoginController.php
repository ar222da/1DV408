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
            $this->model->authenticateUser($userName, $password);
        }
        
        else if ($this->view->didUserLogout())
        {
            $this->model->deauthenticateUser();
         }
        

        return $this->view->showScreen();

    }
    
    
}