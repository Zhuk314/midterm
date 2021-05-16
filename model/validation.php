<?php

/**
 * Name validation
 * @param $name user's name
 * @return bool return the result does valid name
 */
function validName($name)
{
    return strlen(trim($name)) >= 1;
}

/**
 * Questions validation
 * @param $quest array of questions
 * @return bool return the result does valid questions
 */
function validQuestions($quest)
{
    $validQuestions = getQuestions();

    // loop through all questions
    foreach ($quest as $userChoice) {
        //if question is not in array of valid questions
        if (!in_array($userChoice, $validQuestions)) {
            return false;
        }
    }
    return true;
}