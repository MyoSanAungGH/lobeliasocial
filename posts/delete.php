<?php 
include('../db.php');
if(isset($_GET['id']))
{
	$id = $_GET['id'];

	$query = mysqli_query($conn,"SELECT post_photo FROM posts WHERE id='$id'");
	$row=mysqli_fetch_assoc($query);
	unlink('../img/'.$row['post_photo']);

	mysqli_query($conn,"DELETE FROM posts WHERE id='$id'");
	header("location:../home.php");
}
?>