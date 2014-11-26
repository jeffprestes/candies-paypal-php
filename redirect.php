<?php
session_start();

$_SESSION['location'] = $_POST['location'];

header("Location: " . $_SESSION['approvalUrl']);
?>
