<?php
	include 'includes/session.php';
	include 'includes/conn.php';
	$conn = $pdo->open();

	if(isset($_POST['login'])){
		
		$email = $_POST['email'];
		$password = $_POST['password'];

		try{

			$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			
			if($row['id'] > 0){
				if(password_verify($password, $row['password'])){
					if($row['type']){
						$_SESSION['admin'] = $row['id'];
					}
					else{
						$_SESSION['user'] = $row['id'];
					}
				}
				else{
					$_SESSION['error'] = 'Incorrect Password';
				}
			}
			else{
				$_SESSION['error'] = 'Email not found';
			}
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

	}
	else{
		$_SESSION['error'] = 'Input login credentails first';
	}

	$pdo->close();

	header('location: login.php');

?>