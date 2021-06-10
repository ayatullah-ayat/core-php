<?php


function validLoginUser($email, $password) {
    if(!$email || !$password) {
		return "Email and Password are required";
	}
    if (strpos($_POST['email'], "@") === false) {
        return "Email must have an at-sign (@)";
    }

    return true;
}

function validateProfile($enterredData) {
    if(empty($enterredData['first_name']) or empty($enterredData['last_name']) or empty($enterredData['email']) or empty($enterredData['headline']) or empty($enterredData['summary'])) {
        return "All fields are required";
    }
    if(!strpos($enterredData['email'], '@')) {
        return "Email address must contain @";
    }

    return true;
}

function validatePosition($enterredData) {
    for($i = 1; $i <= 9; $i++) {
        if(!isset($enterredData['position-year' . $i]) or !isset($enterredData['position-description' . $i])) { continue; }

        $year = $enterredData['position-year'. $i];
        $description = $enterredData['position-description'. $i];

        if(empty($year) or empty($description)) {
            return "All fields are required";
        }
        if(!is_numeric($year)) {
            return "Position year must be numeric";
        }
    }
    return true;
}

function debug($enterredData) {
    echo "<pre>";
    print_r($enterredData);
    echo "</pre>";
}