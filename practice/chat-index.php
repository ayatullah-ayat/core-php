





<!DOCTYPE html>
<html>
<head>
    <title>Ayatullah Khamini</title>
    
    <script src="./js/jquery.min.js"></script>
    <?php require_once "./css/bootstrap.php"; ?>
</head>
<body>
    <div class="container">
        <h2>Chat</h2>
        <form method = "post" action = "post-chat.php">
            <div class="form-group">
                <input class="form-control" type="text" name="message" id="message">
                <input type="submit" value="chat">
                <input type="submit" name="reset" value="reset">
            </div>
            <div id="chatContent">
                <img src="./images/spinner.gif" alt="Loading...">
            </div>
        </form>
    </div>
    <!-- custom js/jquery -->
    <script>
        
        $(document).ready(function() {
            $.ajaxSetup({
                cache: false
            });
            function printMe(message) {
                window.console && console.log(message);
            }
            function singleChat(item) {
                $('#chatContent').append('<p>' + item[0] + '</br>' + item[1]);
            }

            function updateMessage() {
                printMe('Requesting JSON...');
                $.getJSON('chatlist.php', function(data) {
                    printMe('Recieving JSON...');
                    $("#chatContent").empty();
                    data.forEach(singleChat);

                    setTimeout(updateMessage, 4000);
                })
                
            }
            updateMessage();
        })
    </script>
</body>

</html>