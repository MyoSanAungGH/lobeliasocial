<?php 
include('db.php');
session_start();
if(isset($_POST['comment']) && isset($_POST['post_id']))
{
	include('request.php');
	$comment = $_POST['comment'];
	$post_id = $_POST['post_id'];
	mysqli_query($conn,"INSERT INTO comments (comment,post_id,user_id,created_date,modified_date) VALUES ('$comment','$post_id','".$_SESSION['id']."',now(),now())");
}
?>