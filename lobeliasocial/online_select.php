<?php 
include('db.php');
session_start();
$time=time();
mysqli_query($conn,"UPDATE online_users SET active_date='$time' WHERE user_id='".$_SESSION['id']."' AND login_date='".$_SESSION['login_date']."'");
$online_sql = mysqli_query($conn,"SELECT online_users.*,user.name,user.photo FROM online_users INNER JOIN user ON online_users.user_id=user.id WHERE online_users.active_date >$time-5 GROUP BY online_users.user_id  ");
$num = mysqli_num_rows($online_sql);
$data="";
$data.='<li class="list-group-item"><i class="fas fa-circle text-danger" style="font-size:12px;"></i> <b>Active Users</b> <span class="badge badge-info">'.$num.'</span></li>';
while($online=mysqli_fetch_assoc($online_sql))
{
	$data.='<li class="list-group-item border-top-0 border-bottom-0"><img src="img/'.$online['photo'].'" class="rounded-circle" width="35px" >'.$online['name'].'</li>';
}
echo $data;
?>