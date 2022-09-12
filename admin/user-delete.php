<?php
session_start();
require "../config/config.php";

$stmt = $pdo->prepare("DELETE FROM users WHERE id=". $_GET["id"]);
$stmt->execute();



header('Location: userlist.php');

