<?php 
include('../db.php');
if(isset($_POST))
{
	$id = $_POST['id'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$old_photo = $_POST['old_photo'];
	$delete_photo =$_POST['delete_photo'];
	$photo = $_FILES['photo']['name'];
	$tmp = $_FILES['photo']['tmp_name'];
	if($photo)
	{
		unlink('../img/'.$old_photo);
		$photo = uniqid()."_".$photo;
		move_uploaded_file($tmp,"../img/$photo");
		mysqli_query($conn,"UPDATE posts SET title='$title',description='$description',post_photo='$photo',modified_date=now() WHERE id='$id'");
	}else if($delete_photo){
		unlink('../img/'.$delete_photo);
		mysqli_query($conn,"UPDATE posts SET title='$title',description='$description',post_photo='',modified_date=now() WHERE id='$id'");
	}else{
		mysqli_query($conn,"UPDATE posts SET title='$title',description='$description',modified_date=now() WHERE id='$id'");
	}
	header("location:../home.php");
}
?>