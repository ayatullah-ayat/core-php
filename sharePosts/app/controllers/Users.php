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

            // validated data verifying........
            if(empty($data['name_err']) and empty($data['email_err']) and empty($data['password_err']) and empty($data['confirm_password_err'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // *******REGISTER DATA INTO DATABASE TABLE******
                if($this->userModel->register($data)) {
                    flash('register_success', 'You successfully registered');
                    redirect('users/login');
                }else{
                    die("Something went wrong");
                }
            }
            else {
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
                // LOGIN
                $row = $this->userModel->login($data['email'], $data['password']);
                if($row){
                    $this->createUserSession($row);
                }else{
                    $data['password_err'] = 'Incorrect password';
                    $this->view('users/login', $data);
                }
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

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;
        redirect('pages/index');
    }
    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();
        redirect('users/login');
    }
    public function isLoggedIn() {
        if(isset($_SESSION['user_name'])) {
            return true;
        }else{
            return false;
        }
    }
}