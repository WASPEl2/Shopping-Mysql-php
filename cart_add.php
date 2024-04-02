<?php
	include 'includes/session.php';
	include 'includes/conn.php';

	$conn = $pdo->open();

	$output = array('error'=>false);

	$id = $_POST['id'];
	$quantity = $_POST['quantity'];

	if(isset($_SESSION['user'])){
		$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id=:user_id AND product_id=:product_id");
		$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$id]);
		$row = $stmt->fetch();
		if($row){
			try{
				$new_quantity = $quantity; // Add the new quantity to the existing quantity
				$stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE user_id=:user_id AND product_id=:product_id");
				$stmt->execute(['quantity'=>$new_quantity, 'user_id'=>$user['id'], 'product_id'=>$id]);
				$output['message'] = 'Item quantity updated in cart';
			}
			catch(PDOException $e){
				$output['error'] = true;
				$output['message'] = $e->getMessage();
			}
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
				$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$id, 'quantity'=>$quantity]);
				$output['message'] = 'Item added to cart';
			}
			catch(PDOException $e){
				$output['error'] = true;
				$output['message'] = $e->getMessage();
			}
		}
	}
	else{
		if(!isset($_SESSION['cart'])){
			$_SESSION['cart'] = array();
		}

		$exist = false;

		foreach($_SESSION['cart'] as &$row){
			if($row['productid'] == $id){
				$row['quantity'] = $quantity; // Update the quantity of the existing product
				$exist = true;
				break;
			}
		}

		if(!$exist){
			$data['productid'] = $id;
			$data['quantity'] = $quantity;
			array_push($_SESSION['cart'], $data); // Add new product to the cart
		}

		$output['message'] = 'Item added to cart';
	}

	$pdo->close();
	echo json_encode($output);

?>
