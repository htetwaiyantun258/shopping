<?php
session_start();
require "config/config.php";

$stmt = $pdo->prepare("DELETE FROM categories WHERE id=". $_GET["id"]);
$stmt->execute();



header('Location: category.php');

