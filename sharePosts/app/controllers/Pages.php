<?php

class Pages extends Controller{

    public function __construct()
    {
        
    }

    public function index() {
        $data = [
            'title' => 'sharePosts',
            'description' => 'Simple social network built on the ayatmvc PHP framework'
        ];
        $this->view('pages/index', $data);
    }
    public function about() {
        $data = [
            'title' => 'About Page',
            'description' => 'Use to share user posts'
        ];
        $this->view('pages/about', $data);
    }
    
}