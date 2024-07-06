<?php
    function get(){
        $users = array(
            array('id' => 1, 'name' => 'John Doe'),
            array('id' => 2, 'name' => 'Jane Doe')
        );
        return reset(array_filter($users, function($user){
            return $user['id'] == $_GET['id'];
        }));
    }