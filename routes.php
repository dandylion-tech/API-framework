<?php
    require_once "vendor/autoload.php";
    use Dandylion\Route;
    Route::route("/posts","posts.php");
    Route::route("/users","users.php");
    Route::route("/users/{id}","user.php");