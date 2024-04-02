<?php
	include 'includes/session.php';
	include 'includes/conn.php';


	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];

	$_SESSION['firstname'] = $firstname;
	$_SESSION['lastname'] = $lastname;
	$_SESSION['email'] = $email;

	if($password != $repassword){
		$_SESSION['error'] = 'Passwords did not match';
		header('location: signup.php');
	}
	else{
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();
		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email already taken';
			header('location: signup.php');
		}
		else{
			$now = date('Y-m-d');
			$password = password_hash($password, PASSWORD_DEFAULT);

			//generate code
			$set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$code=substr(str_shuffle($set), 0, 12);

			try{
				$stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, created_on) VALUES (:email, :password, :firstname, :lastname, :now)");
				$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'now'=>$now]);
				$userid = $conn->lastInsertId();

				unset($_SESSION['firstname']);
				unset($_SESSION['lastname']);
				unset($_SESSION['email']);

				$_SESSION['success'] = 'Account created. Check your email to activate.';
				header('location: login.php');

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
				header('location: signup.php');
			}

			$pdo->close();

		}

	}

?>