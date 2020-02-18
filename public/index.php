<?php

require_once '../app/start.php';

// Allowed accesses
$Router->add('errors'); //Load Default Errors
$Router->add('questionnaire'); //Load Questions
$Router->add('register');
$Router->add('register_user');

$_GET['path'] = (empty($_GET['path'])) ? 'questionnaire' : $_GET['path']; // Set Default page
$Router->dispatch($_GET['path']);