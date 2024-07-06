<?php
    $GLOBALS["posts"] = array(
        (object)array('id' => 1, 'title' => 'Post 1', 'content' => 'Content 1'),
        (object)array('id' => 2, 'title' => 'Post 2', 'content' => 'Content 2')
    );
    function get(){
        global $posts;
        return $posts;
    }
    function post(){
        global $posts;
        $posts[] = $_POST;
        return $posts;
    }