<?php
include 'includes/conn.php';
include 'includes/session.php';

$conn = $pdo->open();
  $salesid = $_GET['id'];
  try{
    $stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
    $stmt->execute(['user_id'=>$user['id']]);

    foreach($stmt as $row){
      $stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
      $stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);
    }

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
    $stmt->execute(['user_id'=>$user['id']]);

    $pdo->close();

    $_SESSION['success'] = 'Waiting for the item to be delivered. Thank you.';

  }
  catch(PDOException $e){
    $_SESSION['error'] = $e->getMessage();
  }

?>