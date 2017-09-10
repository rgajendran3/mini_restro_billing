<?php

if(isset($_POST['id'])){
	if(!isset($_SESSION)){
		session_start();
	}
	
	if(!isset($_SESSION['cart'])){
		$_SESSION['cart'] = array();
	}
	$sess = count($_SESSION['cart']);
	$_SESSION['cart'][randomTokenNstatic()] = $_POST['id'];
}else if(isset($_POST['remove'])){
	if(!isset($_SESSION)){
		session_start();
	}
	unset($_SESSION['cart'][$_POST['remove']]);
}else if(isset($_POST['amount'])){
	if(!isset($_SESSION)){
		session_start();
	}
	include 'connection.php';
	$amount = $_POST['amount'];
	$timestamp = date("Y-m-d H:i:s");
	if($amount > 0){
		$result = mysqli_query($connection, "INSERT INTO total (TIMESTAMP, PRICE) VALUES ('$timestamp','$amount')");
		if($result){
			unset($_SESSION['cart']);
		}		
	}
}else if(isset($_POST['del'])){
	include 'connection.php';
	$id = $_POST['del'];
	mysqli_query($connection, "DELETE FROM total WHERE ID='$id'");
}else if(isset($_POST['mdelid'])){
	include 'connection.php';
	$id = $_POST['mdelid'];
	mysqli_query($connection, "DELETE FROM items WHERE ID='$id'");
}else if(isset($_POST['vname']) && isset($_POST['vprice'])){
	include 'connection.php';
	$name = $_POST['vname'];
	$price = $_POST['vprice'];
	mysqli_query($connection, "INSERT INTO items (PRODUCT, PRICE) VALUES ('$name','$price')");
}

function randomTokenNstatic() {
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $password = array(); 
    $letterLength = strlen($letters) - 1; 
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $letterLength);
        $password[] = $letters[$n];
    }
    return implode($password); 
}
?>