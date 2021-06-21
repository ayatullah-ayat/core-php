<?php

class Posts extends Controller {

    public function __construct()
    {
        if(!isLoggedIn()) {
            redirect('users/login');
        }
    }
    public function index() {
        $this->view('posts/index');
    }
}