<div class="alert bg-white pop">
				<b>Popular Posts/Authors</b><hr>

<?php 
$pop_sql=mysqli_query($conn,"SELECT posts.*,user.name,user.photo FROM posts INNER JOIN like_data ON like_data.post_id=posts.id INNER JOIN user ON posts.user_id=user.id GROUP BY like_data.post_id ORDER BY count(like_data.post_id) DESC LIMIT 0,3");
while($pop=mysqli_fetch_assoc($pop_sql))
{ ?>
			<div class="media border mb-2">
				<a href="" class="card-link text-dark">
			  <div class="media-left">
			    <img src="img/<?php echo $pop['post_photo']; ?>" class="media-object my-2 ml-2" width="120px">
			  </div>
			  <div class="media-body ml-2">
			    <h6 class="media-heading mt-3"><?php echo $pop['title']; ?></h6>
<small><?php echo substr($pop['description'],0,50); ?></small></a><br>

			    <a href="" class="text-dark"><small>Posted by : <b><?php echo $pop['name']; ?></b></small>
			    <img src="img/<?php echo $pop['photo']; ?>" class="rounded-circle float-right mr-2 mb-1" width="30px" height="30px">
			    </a>
			  </div>
			</div>
<?php } ?>

</div>