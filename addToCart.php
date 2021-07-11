<?php

session_start();
include ('config/config.php');

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
}

if ($_POST){
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($quantity > $result['quantity']){
        echo "<script>alert('Not enough Stock');window.location.href='product_detail.php?id=$id'</script>";
    }else{
        if (isset($_SESSION['cart']['id'.$id])){
            $_SESSION['cart']['id'.$id] += $quantity;
        }else{
            $_SESSION['cart']['id'.$id] = $quantity;
        }
        echo "<script>alert('Item Added to Cart')</script>";
        header('location:cart.php?id='.$id);
    }
}