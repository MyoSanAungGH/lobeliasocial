<!DOCTYPE html>
<html>
<head>
	<title>Lobelia</title>
	<?php include('cdn.php'); ?>

<style type="text/css">
	.react{
		display: flex;
	}
	.react div{
		width: 33%;
		text-align: center;
	}
</style>

</head>
<body style="background:#E9EBEE;">
<?php include ('nav.php'); ?>
<div class="container-fluid" style="margin-top: 80px;">
	<div class="row">
		<div class="col-md-2">
			<?php include('leftside.php'); ?>
		</div>


		<div class="col-md-5">
				<div class="post_friend">
			<div class="card mb-3">
				<div class="card-header"><b>Create Posts</b></div>
				<div class="card-body">
					
				<div class="media">
				  <img src="img/<?php echo $user['photo']; ?>" width="50px;" height="50px" class="mr-3 rounded-circle" alt="...">
				  <div class="media-body">
				    <textarea class="form-control" data-toggle="modal" data-target="#create_post_Modal"></textarea>
				  </div>
				</div>

				</div>
				<div class="card-footer bg-white">
					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#create_post_Modal"><i class="fas fa-images mr-1"></i>Photo/Video</button>
					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#create_post_Modal"><i class="fas fa-plus-circle text-white mr-1"></i>Create</button>
					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#create_post_Modal"><i class="far fa-smile mr-1"></i>Feeling/Activity</button>
				</div>
			</div>
	<?php
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
	$post_sql = mysqli_query($conn,"SELECT posts.*,user.name,user.photo FROM posts INNER JOIN user ON posts.user_id=user.id WHERE posts.user_id='$id' ORDER BY posts.id DESC");
	}else{
	$post_sql = mysqli_query($conn,"SELECT posts.*,user.name,user.photo FROM posts INNER JOIN user ON posts.user_id=user.id ORDER BY posts.id DESC");	
	}
	while($post = mysqli_fetch_assoc($post_sql)){
	?>
			<div class="card mb-2">
				<div class="card-header bg-white">			
					<a href="" class="card-link text-dark"><img src="img/<?php echo $post['photo']; ?>" width="30px" height="30px" class="rounded-circle mr-1">
					<b><?php echo $post['name']; ?></b></a>				
					<div style="float: right;">
<?php if($_SESSION['id'] == $post['user_id']){ ?>
	<i class="ebtn fas fa-circle text-warning" data-toggle="modal" data-target="#edit_post_Modal" 
	title="<?php echo $post['title']; ?>"
	description="<?php echo $post['description']; ?>"
	post_id="<?php echo $post['id']; ?>"
	photo="<?php echo $post['post_photo'] ?>" ></i>
	<a href="posts/delete.php?id=<?php echo $post['id']; ?>"><i class="fas fa-times-circle text-danger"></i></a>
<?php } ?>
					</div>
				</div>
				<div class="card-body">
					<h3><?php echo $post['title']; ?></h3>
					<p class="text-justify"><?php echo $post['description']; ?></p>
		<?php if($post['post_photo']){ ?>
					<img src="img/<?php echo $post['post_photo']; ?>" width="100%;">
		<?php } ?>
				</div>
				<div class="card-footer react bg-white">
					<div>
<?php 
$sql2 = mysqli_query($conn,"SELECT * FROM like_data WHERE post_id='".$post['id']."' AND user_id='".$_SESSION['id']."'");
if(mysqli_num_rows($sql2)>0)
{ ?>
<i post_id="<?php echo $post['id']; ?>" class="unlike fas fa-thumbs-up mr-1 text-primary"></i>
<?php }else{ ?>
<i post_id="<?php echo $post['id']; ?>" class="like fas fa-thumbs-up mr-1"></i>
<?php } ?>

<span class="badge badge-light" id="like_here<?php echo $post['id']; ?>">
<?php 
$sql1 = mysqli_query($conn,"SELECT * FROM like_data WHERE post_id='".$post['id']."'");
echo mysqli_num_rows($sql1);
?>
</span>
</div>
<div><a href="comment.php?pid=<?php echo $post['id']; ?>" class="text-dark card-link"><i class="far fa-comment-alt mr-1"></i>Comment</a></div>
					<div><i class="fas fa-share mr-1"></i></i>Share</div>
				</div>
			</div>
				<?php } ?>
			</div>
		</div>


		<div class="col-md-3">
			<?php include('popular.php'); ?>	
		</div>

		<div class="col-md-2">
			<ul class="list-group side_right">
				 

			</ul>
		</div>
	</div>
</div>

<?php include('modal.php'); ?>
<script type="text/javascript">
	$('.ebtn').click(function(){
		$('.photo').show()
		$('.delete_photo').val("")
		var title = $(this).attr('title')
		var description = $(this).attr('description')
		var post_id = $(this).attr('post_id')
		var post_photo = $(this).attr('photo')
		$('.title').val(title)
		$('.description').val(description)
		$('.id').val(post_id)
		if(post_photo)
		{
		$('.old_photo').val(post_photo)
		$('.photo').attr('src','img/'+post_photo)
		$('.dp_btn').show()
		}else{
			$('.old_photo').val('')
			$('.dp_btn,.photo').hide()
		}
		$('.dp_btn').click(function(){
			$('.photo').hide()
			$('.delete_photo').val(post_photo)
		})
	})

	$(document).ready(function(){
		$('.like,.unlike').click(function(){
			var post_id = $(this).attr('post_id')
			$(this).toggleClass('text-primary')
			$.ajax({
				url:'like_data/like_unlike.php',
				method:'POST',
				data:{post_id},
				success:function()
				{
					likeCount(post_id)
				}
			})
		})

		function likeCount(id)
		{
			$.ajax({
				url:'like_data/count.php',
				method:'POST',
				data:{id},
				success:function(result)
				{
	$('#like_here'+id).text(result)
				}
			})
		}

	})
	$('body').mouseenter(function(){
		$.ajax({
			url:'request.php'
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
    channel.bind('my-event', function(data) {
      	$.ajax({
      		url:'online_select.php',
      		method:'POST',
      		success:function(result)
      		{
      			$('.side_right').html(result)
      		}
      	})
    });
  </script>
</body>
</html>