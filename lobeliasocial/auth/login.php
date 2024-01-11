<?php 
include('../db.php');
date_default_timezone_set('Asia/Yangon');
if(isset($_POST['name']) && isset($_POST['password']))
{
	$name = $_POST['name'];
	$password = $_POST['password'];
	$query = mysqli_query($conn,"SELECT * FROM user WHERE name='$name' AND password='$password'");
	$row = mysqli_fetch_assoc($query);
	if(mysqli_num_rows($query)>0)
	{
		session_start();
		$_SESSION['id'] = $row['id'];
		$_SESSION['login_date'] = date('Y-m-d h:i:s');
		$time = time();
		mysqli_query($conn,"INSERT INTO online_users (user_id,login_date,active_date) VALUES ('".$_SESSION['id']."','".$_SESSION['login_date']."','$time')");
		header("location:../home.php");
	}else{
		echo '<script>alert("Login failed,try again");location.href="../index.php"</script>';
	}
}
?>