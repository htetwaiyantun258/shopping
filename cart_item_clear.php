<?php
session_start();

if(!empty($_SESSION['cart'])){
    unset($_SESSION['cart']['id'.$_GET['pid']]);
}
header("Location: index.php");