<?php

?>

<html>
<head>
</head>
<body>
    <p>Change the contents of the text field and 
    then tab away from the field
    to trigger the change event. Do not use
    Enter or the form will get submitted.</p>

    <form id="target">
        <input type="text" name="message" id="message" value="Hello">
        <img id="spinner" src="images/spinner.gif" height="24" style="vertical-align:middle; display:none" alt="Loading...">
    </form>

    <div id="result"></div>


    <script src="js/jquery.min.js"></script>
    <script src="js/autopost.js"></script>
</body>