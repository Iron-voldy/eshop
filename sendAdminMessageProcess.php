<?php
session_start();

require "connection.php";

$msg_txt = $_POST["t"];

if (isset($_POST["r"])) {
    $receiver = $_POST["r"];
} else {
    $admin_name = Database::search("SELECT `email` FROM `admin`");
    $admin_email = $admin_name->fetch_assoc();
    $receiver_ad = $admin_email["email"];
}

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

if (isset($_SESSION["u"])) {
    $sender = $_SESSION["u"]["email"];
} else if (isset($_SESSION["au"])) {
    $sender = $_SESSION["au"]["email"];
}

if (!empty($receiver)) {
    Database::iud("INSERT INTO `chat`(`content`, `date_time`, `status`, `from`, `to`) VALUES('" . $msg_txt . "','" . $date . "','0','" . $sender . "','" . $receiver . "')");
    echo ("success1");
} else {
    Database::iud("INSERT INTO `chat`(`content`, `date_time`, `status`, `from`, `to`) VALUES('" . $msg_txt . "','" . $date . "','0','" . $sender . "','" . $receiver_ad . "')");
    echo ("success2");
}
?>