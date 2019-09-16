<?php header('Access-Control-Allow-Origin: *'); ?>
<?php

$host = "localhost"; 
$user = "antongek_form"; 
$password = "antongloom777"; 
$dbusername = "antongek_form"; 

$conn = mysqli_connect($host, $user, $password,$dbusername);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$res = array('error' => false);

$action = 'read';

if(isset($_GET['action'])){
	$action = $_GET['action'];
}


if($action == 'read'){
	$result = $conn->query("SELECT * FROM `form`");
	$users = array();

	while($row = $result->fetch_assoc()){
	$row['img'] = 'data:image/jpeg;base64,'.base64_encode($row['img']);
		array_push($users, $row);
	}
	$res['users'] = $users;
}



if($action == 'create'){

	$username = $_POST['username'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$img_type = substr($_FILES['img']['type'], 0, 5);
	$img_size = 2*1024*1024;
	if(!empty($_FILES['img']['tmp_name']) and $img_type === 'image' and $_FILES['img']['size'] <= $img_size){ 
	$img = addslashes(file_get_contents($_FILES['img']['tmp_name']));
	}

	$result = $conn->query("INSERT INTO `form` (`username`, `email`, `mobile`, `img`) VALUES ('$username', '$email', '$mobile', '$img') ");
	
	if($result){
		$res['message'] = "User added successfully";
	} else{
		$res['error'] = true;
		$res['message'] = "Could not insert user";
	}
}

if($action == 'update'){
	$id = $_POST['id'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];

	$result = $conn->query("UPDATE `form` SET `username` = '$username', `email` = '$email', `mobile` = '$mobile' WHERE `id` = '$id'");
	
	if($result){
		$res['message'] = "User updated successfully";
	} else{
		$res['error'] = true;
		$res['message'] = "Could not update user";
	}

}

if($action == 'delete'){
	$id = $_POST['id'];
	

	$result = $conn->query("DELETE FROM `form` WHERE `id` = '$id'");
	
	if($result){
		$res['message'] = "User deleted successfully";
	} else{
		$res['error'] = true;
		$res['message'] = "Could not delete user";
	}

}



$conn->close();

header("Content-type: application/json");
echo json_encode($res);
die();