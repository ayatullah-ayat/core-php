<?php

class Users extends Controller{

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register() {
        if(strtolower($_SERVER['REQUEST_METHOD']) == 'post' ) {
            // PROCESS FORM DATA
            echo "posted";
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // VALIDATE INPUT POST
            // name
            if(empty($data['name'])) {
                $data['name_err'] = 'Your name shouldn\'t be empty';
            }
            // email
            if(empty($data['email'])) {
                $data['email_err'] = 'Your email shouldn\'t be empty';
            }
            if($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email already exists';
            }
            // password checking
            if(empty($data['password'])) {
                $data['password_err'] = 'Enter your password';
            }else if(strlen($data['password']) <= 6) {
                $data['password_err'] = 'Password should at least 6 characters';
            }
            // confirm password checking
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Enter your confirm password password';
            }else if($data['confirm_password'] !== $data['password']) {
                $data['confirm_password_err'] = 'Your given password not matched';
            }

            // validated data verify
            if(empty($data['name_err']) and empty($data['email_err']) and empty($data['password_err']) and empty($data['confirm_password_err'])) {
                die('SUCCESS - No errors found');
            }else {
                $this->view('users/register', $data);
            }

        }
        else{
            echo 'register';
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('users/register', $data);
        }
    }

    public function login() {
        if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
            // process the form
            $data = [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'email_err' => '',
                'password_err' => ''
            ];

            // email
            if(empty($data['email'])) {
                $data['email_err'] = 'Your email shouldn\'t be empty';
            }
            // password checking
            if(empty($data['password'])) {
                $data['password_err'] = 'Enter your password';
            }else if(strlen($data['password']) <= 6) {
                $data['password_err'] = 'Password should at least 6 characters';
            }

            // validated data verifying....
            if(empty($data['email_err']) and empty($data['password_err'])) {
                // process data
                die('login success');
            }else{
                $this->view('users/login', $data);
            }


        }else{
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            $this->view('users/login', $data);
        }
    }
}