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

//Define route for survey.html
$f3->route('GET|POST /midSurvey', function($f3){

    //Initialize variables for user input
    $userQuestions = array();
    $userName = "";

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);
        //Get user input
        $userQuestions = $_POST['quest'];
        $userName = $_POST['name'];

        // Validate information
        //If name is valid, store data
        if(validName($userName)) {
            $_SESSION['name'] = $userName;
        }
        //Otherwise, set an error variable in the hive
        else {
            $f3->set('errors["name"]', 'Name is not valid');
        }

        if (!empty($userQuestions)) {
            //If questions are valid AND NOT EMPTY
            if (validQuestions($userQuestions) && !empty($userQuestions)) {
                $_SESSION['quest'] = implode(", ", $userQuestions);
                echo "<h1>Here1</h1>";
            } else {
                $f3->set('errors["quest"]', 'Invalid selection');
                echo "<h1>Here2</h1>";
            }
        }else{
            $f3->set('errors["quest"]', 'Invalid selection');
            echo "<h1>Here3</h1>";
        }

        // redirect to summary route
        if (empty($f3->get('errors'))) {
            header('location: summary');
        }
    }

    //Get the questions from the Model and send them to the View
    $f3->set('questions', getQuestions());

    //Add the user data to the hive
    $f3->set('userQuestions', $userQuestions);

    //Display the survey form
    $view = new Template();
    echo $view->render('views/survey.html');


});

//Define route for summary
$f3->route('GET|POST /summary', function($f3){

    //Display the survey form
    $view = new Template();
    echo $view->render('views/summary.html');
});


//Run Fat-Free
$f3->run();