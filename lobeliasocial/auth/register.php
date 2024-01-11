<?php 
include('../db.php');
if(isset($_POST))
{
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$dob = $_POST['dob'];
	$address = $_POST['address'];
	$cpassword = $_POST['cpassword'];
	$password = $_POST['password'];
	// $hpassword = hash('md5', $password);
	$gender = $_POST['gender'];
	$photo = $_FILES['photo']['name']; //type,size
	$tmp = $_FILES['photo']['tmp_name'];
	if($photo)
	{
		move_uploaded_file($tmp,"../img/$photo");
	}else{
		$photo = 'empty1.png';
	}
	$query = mysqli_query($conn,"SELECT * FROM user WHERE name='$name'");
	if(mysqli_num_rows($query)>0)
	{
		echo '<script>alert("Username already exist");location.href="../index.php"</script>';
	}else if($password == $cpassword)
	{
		mysqli_query($conn,"INSERT INTO user (name,email,password,phone,dob,gender,photo,address,created_date,modified_date) VALUES ('$name','$email','$password','$phone','$dob','$gender','$photo','$address',now(),now())");
		echo '<script>alert("Successfully registrated");location.href="../index.php"</script>';
	}else{
		echo '<script>alert("Passwords do not match");location.href="../index.php"</script>';
	}

	
}
?>