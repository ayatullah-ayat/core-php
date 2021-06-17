<?php

class Pages extends Controller{

    public function __construct()
    {
        $this->postMethod = $this->model('Post');
    }

    public function index() {
        $posts = $this->postMethod->getPosts();
        $data = ['title' => 'welcome', 'posts' => $posts];
        $this->view('pages/index', $data);
    }
    public function about() {
        $this->view('pages/about');
    }
    
}