<!DOCTYPE html>
<html>
<head>
	<title>Lobelia</title>
	<style type="text/css">
	.comment_box{
	border:none;
    resize: none;
    width: 98%;
  	height: 34px;
    outline:none;
    padding:5px 15px;
	}
	.comment_area{
		height: 300px;
		overflow-y: scroll;
	}
	.comment_area::-webkit-scrollbar {
    display: none;
}



	</style>
	<?php include('cdn.php'); ?>

</head>
<body style="background:#E9EBEE;">
<?php include ('nav.php'); ?>
<div class="container-fluid" style="margin-top: 80px;">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-5">
	<?php 
	if(isset($_GET['pid']))
	{
		$id = $_GET['pid'];
		$post_sql = mysqli_query($conn,"SELECT posts.*,user.name,user.photo FROM posts INNER JOIN user ON posts.user_id=user.id WHERE posts.id='$id'");
		$post=mysqli_fetch_assoc($post_sql);
	}
	?>
			<div class="card">
				<div class="card-header bg-white">	
				<a href="" class="card-link text-dark">		
					<img src="img/<?php echo $post['photo'] ?>" height="30px" width="30px" class="rounded-circle mr-1">
					<b><?php echo $post['name'] ?></b></a>				
				</div>
				<div class="card-body">
					<h4><?php echo $post['title'] ?></h4>
					<p class="text-justify">
						<?php echo $post['description'] ?>	
					</p>
				<?php if($post['post_photo']){ ?>
					<img src="img/<?php echo $post['post_photo'] ?>" width="100%;">
				<?php } ?>
				</div>
			</div>


		</div>
		<div class="col-md-3">
			
			<div class="card">
				<div class="card-body">
					<div class="comment_area">
<?php 
	$comment_sql=mysqli_query($conn,"SELECT comments.*,user.photo,user.name FROM comments INNER JOIN user ON comments.user_id=user.id WHERE comments.post_id='$id'");
	while($comment=mysqli_fetch_assoc($comment_sql))
	{
		echo '<div class="media mb-2">
			  <div class="media-left">
			    <img src="img/'.$comment['photo'].'" class="media-object rounded-circle m-2" width="35px" height="35px">
			  </div>
			  <div class="media-body">
			  	<h6>'.$comment['name'].'</h6>
			    <p>'.$comment['comment'].'</p>
			  </div>
			</div>';
	}
?>
			

					</div>

					<div class="media pt-2 px-3 border-top">
  <img src="img/<?php echo $user['photo']; ?>" height="35px" width="35px" class="rounded-circle">
  					<div class="media-body">
    <input class="comment_box ml-2" placeholder="Write a comment..."></input>
  					</div>
				</div>

				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	$('.comment_box').change(function(){
		var comment = $(this).val()
		var post_id = '<?php echo $id; ?>'
		$.ajax({
			url:'comment_insert.php',
			method:'POST',
			data:{comment,post_id},
			success:function()
			{
				$('.comment_box').val('')
			}
		})
	})
</script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('430a7325dd73b0ea2384', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    var post_id = '<?php echo $id; ?>'
    channel.bind('my-event', function(data) {
      	$.ajax({
      		url:'comment_select.php',
      		method:'POST',
      		data:{post_id},
      		success:function(result)
      		{
      			$('.comment_area').html(result)
      		}
      	})
    });
  </script>

</body>
</html>