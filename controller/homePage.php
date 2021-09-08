<?php
echo 'Hello from the controller';
include './view/homepage.html';
include './model/classes/Users.php';

$user1 = new User();

var_dump($user1);