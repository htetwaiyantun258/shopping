<?php

session_start();
    require "config/config.php";
	require "config/common.php";
    

if($_POST){
    $id = $_POST['id'];
    $qty = $_POST['qty'];

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($qty > $result['quantity']){
        echo "<script>alert('not enough product');</script>";
    }else{
        if(!empty($_SESSION['cart']['id' . $id])){
            
            $_SESSION['cart']['id'. $id] += $qty;
            
        }else{
            $_SESSION['cart']['id'. $id] = $qty;
    
        }
        header("Location: cart.php");
    }

    
   
}