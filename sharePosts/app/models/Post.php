<?php

class Post {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPosts() {
        $this->db->query('SELECT *, posts.id as postId, posts.created_at as postCreated FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC');
        return $this->db->resultSet();
    }
}