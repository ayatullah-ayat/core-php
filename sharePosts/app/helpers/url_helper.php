<?php
// url helper function

function redirect($page) {
    header('Location: ' . URLROOT . '/' . $page);
}