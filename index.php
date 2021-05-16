<?php
/*
 * Author: Yurii Zhuk
 * Date:05/15/2021
 */

//This is my controller for the midterm project

//Turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require necessary files
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');
require_once ('model/validation.php');


//Instantiate Fat-Free
$f3 = Base::instance();

//Define default route
$f3->route('GET /', function(){

    //Display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

//Define survey route
$f3->route('GET|POST /midSurvey', function($f3){

    //Get the questions from the Model and send them to the View
    $f3->set('questions', getQuestions());

    //Display the survey form
    $view = new Template();
    echo $view->render('views/survey.html');
});

//Run Fat-Free
$f3->run();