<?php 
include('vendor/autoload.php');
$options = array(
    'cluster' => 'ap1',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '430a7325dd73b0ea2384',
    'cc609da7db55fda3bbae',
    '1332530',
    $options
  );

  $data['message'] = 'hello world';
  $pusher->trigger('my-channel', 'my-event', $data);
?>