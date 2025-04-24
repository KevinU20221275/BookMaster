<?php
session_start();
if ($_SESSION['user_name'] == ""){
    header("Location: ../index.php");
    exit();
}

session_destroy();
header("Location: ../index.php");
?>

?>