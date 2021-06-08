<?php
include_once('pdo.php');
include_once('utility.php');

session_start();

if(isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

if(!empty($_POST)) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    if(isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['email']) and isset($_POST['headline']) and isset($_POST['summary'])){
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
        // it's time to insert into database
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

        // added position into the database
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
        


        $_SESSION['success'] = "profile added";
        header("Location: index.php");
        return;      
    }
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

            <div class="form-group">
                <label for="addPosition">Position</label>
                <button id="addPosition" class="btn btn-secondary">+</button>
            </div>

            <div id="addingPositionField">
            </div>
            <!-- new added field goes here -->


            <button type="submit" value="submitted">Add</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            const maxAddedNumber = 9;
            let count = 0;
            
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

                // setting click event on each subPosition button
                for(let i = 1; i <= count; i++) {
                    $('#subPosition' + i).click(function(e) {
                        e.preventDefault();
                        $('#positions' + i).remove();
                    })
                }

            })
        });
    </script>
</body>
</html>