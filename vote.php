<?php

session_start();
    // …
    $ac = $_GET['accessCode'];

    echo '<!DOCTYPE html>
<html>
<head><title>Vote </title></head>
<body>
<form action="voteUpdate.php" enctype="multipart/form-data" method="post">
Value between 1 and 5 : <input type="text" name="rate" id="rate">
Access Code <input type="text" id="ac" name="ac" value="'.$ac.'">
<input type = "submit" value="vote">

</form>
</body>
</html>';

?>

