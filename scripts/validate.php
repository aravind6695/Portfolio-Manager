<?php
session_start();
$username = $_SESSION['username'];

require 'database.php';

$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$dow30_value = $row['dow30_value'];
$overseas_value = $row['overseas_value'];
$cash = $row['cash'];

$dow30_percent = round($dow30_value / ($dow30_value + $overseas_value) * 100);
$overseas_percent = round($overseas_value / ($dow30_value + $overseas_value) * 100);
$cash_percent = round($cash / ($dow30_value + $overseas_value) * 100);

$condition = true;
if (dow30_percent < 67 or dow30_percent > 73 or cash_percent > 10) {
    $condition = false; 
}

$message = "Domestic value: " . $dow30_percent . "%, Overseas value: " . $overseas_percent . "%, Cash value: " . $cash_percent . "%";
$_SESSION['display_alert'] = $message;
header("location: ../home.php");
exit();
?>