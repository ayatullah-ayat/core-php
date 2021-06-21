<?php

class Posts extends Controller {

    public function __construct()
    {
        if(!isLoggedIn()) {
            redirect('users/login');
        }
        $this->postModel = $this->model('Post');
    }
    public function index() {
        $data = $this->postModel->getPosts();
        $this->view('posts/index', $data);
    }
}