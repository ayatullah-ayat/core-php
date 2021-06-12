<?php
include_once('pdo.php');
include_once('utility.php');
session_start();


if(!isset($_SESSION['user_id'])) {
    die('ACCESS DENIED');
}
if(isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
        $msg = validateProfile($_POST);
        if(is_string($msg)){
            $_SESSION['errors'] = $msg;
            header('Location: edit.php?profile_id=' . $_GET['profile_id']);
            return;
        }
        $msg = validatePosition($_POST);
        if(is_string($msg)) {
            $_SESSION['errors'] = $msg;
            header('Location: edit.php?profile_id=' . $_GET['profile_id']);
            return;
        }
        $msg = validateEducation($_POST);
        if(is_string($msg)) {
            $_SESSION['errors'] = $msg;
            header('Location: edit.php?profile_id=' . $_GET['profile_id']);
            return;
        }
        // it's time to insert into database
        $sql = "UPDATE Profile SET first_name = :fn, last_name = :ln, email = :em, headline = :hl, summary = :su WHERE profile_id = :pid";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':pid' => $_GET['profile_id'],
            'fn' => $_POST['first_name'],
            'ln' => $_POST['last_name'],
            'em' => $_POST['email'],
            'hl' => $_POST['headline'],
            'su' => $_POST['summary']
        ));

        
        // Delete position for this profile
        $stmt = $pdo->prepare('DELETE FROM Position WHERE profile_id = :pid');
        $stmt->execute(array(
            ':pid' => $_GET['profile_id']
        ));


        // added position into the database
        $rank = 1;
        for($i = 1; $i <= 9; $i++) {
            // skip if missing
            if(!isset($_POST['position-year' . $i]) or !isset($_POST['position-description' . $i])){continue;}

            $year = $_POST['position-year' . $i];
            $desc = $_POST['position-description' . $i];

            $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES (  :pid, :rank, :year, :desc)');

            $stmt->execute(array(
                ':pid' => $_GET['profile_id'],
                ':rank' => $rank,
                ':year' => $year,
                ':desc' => $desc)
            );
            $rank++;
        }

        // delete education for this profile
        $stmt = $pdo->prepare('DELETE FROM Education WHERE profile_id = :pid');
        $stmt->execute(array(
            ':pid' => $_GET['profile_id']
        ));
        
        // again insert this profile with a new manner
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
                    ':pid' => $_GET['profile_id'],
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

        $_SESSION['success'] = "Profile updated";
        header("Location: index.php");
        return;      
}

// profile
$stmt = $pdo->prepare('SELECT * FROM Profile WHERE profile_id = :pid');
$stmt->execute(array(
    ':pid' => $_GET['profile_id']
));

$profileData = $stmt->fetch(PDO::FETCH_ASSOC);

// position
$stmt = $pdo->prepare('SELECT * FROM Position WHERE profile_id = :pid');
$stmt->execute(array(
    ':pid' => $_GET['profile_id']
));
$positionData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Education
$stmt = $pdo->prepare('SELECT Education.year, Education.rank, Institution.name FROM Education INNER JOIN Institution ON Education.profile_id = :id AND Education.institution_id = Institution.institution_id');
$stmt->execute(array(
	':id' => $_GET['profile_id']
));
$eduRow = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <? if($profileData) { ?>
        <form method="post">
            <label for="firstName">First Name:</label>
            <input type="text" name="first_name" value="<?= $profileData['first_name'] ?>" id="firstName"><br/>

            <label for="lastName">Last Name:</label>
            <input type="text" name="last_name" value="<?= $profileData['last_name'] ?>" id="lastName"><br/>

            <label for="email">Email:</label>
            <input type="text" name="email" value="<?= $profileData['email'] ?>" id="email"><br/>

            <div class="form-group">
                <label for="headline">Headline:</label>
                <input class="form-control" type="text" name="headline" value="<?= $profileData['headline'] ?>" id="headline">
            </div>

            <div class="form-group">
                <label for="summary">Summary:</label>
                <textarea class="form-control" name="summary" rows="8" cols="40"><?= $profileData['summary'] ?></textarea>
            </div>

            <!-- education field -->
            <div class="form-group">
                <label for="addEducation">Education</label>
                <button id="addEducation" class="btn btn-secondary">+</button>
            </div>

            <div id="addingEducationField">
            <!-- education field populate here -->
            <? if($eduRow) { ?>
                <? foreach($eduRow as $row) { ?>
                    <div id="education<?= $row['rank'] ?>">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" name="education-year<?= $row['rank'] ?>" value="<?= $row['year'] ?>">
                                <button id="subEducation<?= $row['rank'] ?>" class="btn btn-secondary">-</button>
                            </div>
                            <div class="form-group row">
                                <input type="text" class="form-control col-md-6" id="school<?= $row['rank'] ?>" name="education-school<?= $row['rank'] ?>" value="<?= $row['name'] ?>">  
                            </div>
                         </div>
            <? } }?>

            </div>

            <div class="form-group">
                <label for="addPosition">Position</label>
                <button id="addPosition" class="btn btn-secondary">+</button>
            </div>

            <!--  -->
            <div id="addingPositionField">
                <? if($positionData) { ?>
                    <? foreach($positionData as $singleData) { ?>
                        <div id="positions<?= $singleData['rank'] ?>">
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <input type="text" name="position-year<?= $singleData['rank'] ?>" value="<?= $singleData['year'] ?>">
                                    <button id="subPosition<?= $singleData['rank'] ?>" class="btn btn-secondary">-</button>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="position-description<?= $singleData['rank'] ?>" rows="8" cols="40"><?= $singleData['description'] ?></textarea>  
                                </div>
                            </div>
                <? } } ?>
            </div>
            <!-- new added field goes here -->


            <button type="submit" value="Save">Save</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
        <? } ?>
    </div>

    <script>
        $(document).ready(function() {

            const maxAddedNumber = 9;
            <? if($positionData) { ?>
                let count = <?= count($positionData) ?>;
            <? } else { ?>
                let count = 0;
            <? } ?>
            
            $('#addPosition').click(function(e) {
                e.preventDefault();
                count++;
                const html = `<div id="positions${count}">
                                <div class="form-group">
                                    <p>${count}</p>
                                    <label for="year">Year</label>
                                    <input type="text" name="position-year${count}">
                                    <button id="subPosition${count}" class="btn btn-secondary">-</button>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="position-description${count}" rows="8" cols="40"></textarea>  
                                </div>
                            </div>`;
                
                if(count > maxAddedNumber) {
                    alert('You exceeded, You can add upto 9 positions tops');
                    return;
                }
                $('#addingPositionField').append(html);
                // setting click event on each subtract/remove(-) button
                for(let i = 1; i <= count; i++) {
                    $('#subPosition' + i).click(function(e) {
                        e.preventDefault();
                        $('#positions' + i).remove();
                    })
                }

            })
             // setting click event on each subtract/remove(-) button
             for(let i = 1; i <= maxAddedNumber; i++) {
                    $('#subPosition' + i).click(function(e) {
                        e.preventDefault();
                        $('#positions' + i).remove();
                    })
                }

            const eduMaxAddedNumber = 9;
            <? if($eduRow) { ?>
                let eduCount = <?= count($eduRow) ?>;
            <? } else { ?>
                let eduCount = 0;
            <? } ?>
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
            // end education added form field
            
                for(let i = 1; i <= 9; i++) {
                $('#subEducation' + i).click(function(e) {
                        e.preventDefault();
                        $('#education' + i).remove();
                    })
                $('#school' + i).autocomplete({ source: "school.php" });
                }
            
        });
    </script>
</body>
</html>