<?php

header('Content-Type: application/json; charset=utf-8');

$users = file_get_contents('../data/users.json');

// Check user role

echo $users;