<?php 
include('../db.php');
session_start();
if(isset($_POST))
{
	$title = $_POST['title'];
	$description = $_POST['description'];
	$photo = $_FILES['photo']['name'];
	$tmp = $_FILES['photo']['tmp_name'];
	if($photo)
	{
		$photo = uniqid()."_".$photo;
		move_uploaded_file($tmp,"../img/$photo");
	}
	mysqli_query($conn,"INSERT INTO posts (title,description,post_photo,user_id,created_date,modified_date) VALUES ('$title','$description','$photo','".$_SESSION['id']."',now(),now())");
	header("location:../home.php");
}
?>