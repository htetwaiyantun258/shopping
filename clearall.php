<?php
session_start();

if(!empty($_SESSION['cart'])){
    unset($_SESSION['cart']);
}
header("Location: index.php");