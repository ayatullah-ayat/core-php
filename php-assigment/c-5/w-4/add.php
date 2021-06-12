<?php
include_once('pdo.php');
include_once('utility.php');

session_start();

if(isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
        $msg = validateProfile($_POST);
        if(is_string($msg)){
            $_SESSION['errors'] = $msg;
            header('Location: add.php');
            return;
        }
        $msg = validatePosition($_POST);
        if(is_string($msg)) {
            $_SESSION['errors'] = $msg;
            header('Location: add.php');
            return;
        }
        $msg = validateEducation($_POST);
        if(is_string($msg)) {
            $_SESSION['errors'] = $msg;
            header('Location: add.php');
            return;
        }

        // Now all data is validated. Now we can insert confidently

        // insert profile into the database
        $sql = "INSERT INTO profile(user_id, first_name, last_name, email, headline, summary) 
        VALUES(:uid, :fn, :ln, :em, :hl, :su) ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            'uid' => $_SESSION['user_id'],
            'fn' => $_POST['first_name'],
            'ln' => $_POST['last_name'],
            'em' => $_POST['email'],
            'hl' => $_POST['headline'],
            'su' => $_POST['summary']
        ));

        $profile_id = $pdo->lastInsertId();

        // insert position into the database
        $rank = 1;
        for($i = 1; $i <= 9; $i++) {
            if(!isset($_POST['position-year' . $i]) or !isset($_POST['position-description' . $i])){continue;}

            $year = $_POST['position-year' . $i];
            $desc = $_POST['position-description' . $i];

            $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES (  :pid, :rank, :year, :desc)');

            $stmt->execute(array(
                ':pid' => $profile_id,
                ':rank' => $rank,
                ':year' => $year,
                ':desc' => $desc)
            );
            $rank++;
        }

        // insert education into the database
        $rank = 1;
        for($i = 1; $i <= 9; $i++) {
            if(!isset($_POST['education-year' . $i]) or !isset($_POST['education-school' . $i])){continue;}

            $year = $_POST['education-year' . $i];
            $school = $_POST['education-school' . $i];

            // look for school id from the institution table - if found then insert into the education table, otherwise show session error
            $stmt = $pdo->prepare("SELECT * FROM Institution WHERE name = :school");
            $stmt->execute(array(
                ':school' => $school
            ));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // if found then insert into the education database table
            if($row) {
                $institution_id = $row['institution_id'];

                $stmt = $pdo->prepare('INSERT INTO Education (profile_id, institution_id, rank, year) VALUES(:pid, :iid, :rank, :year)');

                $stmt->execute(array(
                    ':pid' => $profile_id,
                    ':iid' => $institution_id,
                    ':rank' => $rank,
                    ':year' => $year
                ));
            }else {
                $_SESSION['errors'] = 'Education is not inserted';
                header('Location: add.php');
                return;
            }
            $rank++;
        }

        $_SESSION['success'] = "profile added";
        header("Location: index.php");
        return;      

}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Ayatullah Khamini</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
    <h1>Adding Profile for <?= $_SESSION['name'] ?></h1>

    <div class="container">
    <?php 
        if(isset($_SESSION['errors'])) {
            echo '<p class="text-warning">'. $_SESSION['errors']. '</p>';
            unset($_SESSION['errors']);
        }
    ?>
        <form method="post">
            <label for="firstName">First Name:</label>
            <input type="text" name="first_name" id="firstName"><br/>

            <label for="lastName">Last Name:</label>
            <input type="text" name="last_name" id="lastName"><br/>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email"><br/>

            <div class="form-group">
                <label for="headline">Headline:</label>
                <input class="form-control" type="text" name="headline" id="headline">
            </div>

            <div class="form-group">
                <label for="summary">Summary:</label>
                <textarea class="form-control" name="summary" rows="8" cols="40"></textarea>
            </div>

            <!-- education field -->
            <div class="form-group">
                <label for="addEducation">Education</label>
                <button id="addEducation" class="btn btn-secondary">+</button>
            </div>

            <div id="addingEducationField">
            <!-- education field populate here -->
            </div>

            <!-- position field -->
            <div class="form-group">
                <label for="addPosition">Position</label>
                <button id="addPosition" class="btn btn-secondary">+</button>
            </div>

            <div id="addingPositionField">
            <!-- position field populate here -->
            </div>


            <!-- submitting -->
            <button type="submit" value="submitted">Add</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            function printMe($text) {
                window.console && console.log($text);
            }
            const posMaxAddedNumber = 9;
            let posCount = 0;
            
            $('#addPosition').click(function(e) {
                e.preventDefault();
                printMe('click');
                posCount++;
                const html = `<div id="positions${posCount}">
                                <div class="form-group">
                                    <p>${posCount}</p>
                                    <label for="year">Year</label>
                                    <input type="text" name="position-year${posCount}">
                                    <button id="subPosition${posCount}" class="btn btn-secondary">-</button>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="position-description${posCount}" rows="8" cols="40"></textarea>  
                                </div>
                            </div>`;
                
                if(posCount > posMaxAddedNumber) {
                    alert('You exceeded, You can add upto 9 positions tops');
                    return;
                }
                $('#addingPositionField').append(html);

                // setting click event on each subPosition button
                for(let i = 1; i <= posCount; i++) {
                    $('#subPosition' + i).click(function(e) {
                        e.preventDefault();
                        $('#positions' + i).remove();
                    })
                }

            })

            // Adding Education Field
            const eduMaxAddedNumber = 9;
            let eduCount = 0;
            $('#addEducation').click(function(e) {
                e.preventDefault();
                eduCount++;
                const html = `<div id="education${eduCount}">
                                <div class="form-group">
                                    <p>${eduCount}</p>
                                    <label for="year">Year</label>
                                    <input type="text" name="education-year${eduCount}">
                                    <button id="subEducation${eduCount}" class="btn btn-secondary">-</button>
                                </div>
                                <div class="form-group row">
                                    <input type="text" class="form-control col-md-6" id="school${eduCount}" name="education-school${eduCount}">  
                                </div>
                            </div>`;

                if(eduCount > eduMaxAddedNumber) {
                    alert('You exceeded, You can add upto 9 positions tops');
                    return;
                }
                
                $('#addingEducationField').append(html);

                for(let i = 1; i <= eduCount; i++) {
                    // added click eventlistener to remove the education field
                    $('#subEducation' + i).click(function(e) {
                        e.preventDefault();
                        $('#education' + i).remove();
                    });
                    // added autocomplete to institution field
                    $('#school' + i).autocomplete({ source: "school.php" });
                }
                
            });
        });
    </script>
</body>
</html>