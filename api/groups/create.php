<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);
$created_by_user_id = $data['created_by_user_id'];
$name = $data['name'];
$group_privacy = $data['group_privacy'];
$group_visibility = $data['group_visibility'];
$created_date = date('d-m-Y');
$sql = "SELECT * FROM users WHERE  id='$created_by_user_id' ";
$resultquery = mysqli_query($conn, $sql);
$rowcount = mysqli_num_rows($resultquery);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($resultquery)) {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $profile_image = $row['profile_image'];
        $email = $row['email'];
    }
}

$sql = "Insert into user_groups(created_by_user_id,name,group_privacy,group_visibility,created_at) Values ('{$created_by_user_id}','{$name}','{$group_privacy}','{$group_visibility}','{$created_date}')";

if (mysqli_query($conn, $sql)) {
    $sql = "SELECT * from user_groups where  created_by_user_id='$created_by_user_id' ORDER BY id desc limit 1";
    $group_query = mysqli_query($conn, $sql);
    if ($group_query) {
        while ($row = mysqli_fetch_assoc($group_query)) {
            $id = $row['id'];
            $created_at = $row['created_at'];
            $userid = $row['created_by_user_id'];
            $image = $row['image'];
            $group_visibility = $row['group_visibility'];
            $group_privacy = $row['group_privacy'];
        }
        $sqlfinal = "INSERT into group_member (group_id,user_id,status,created_at)VALUES('$id','$userid','membered','$created_date')";
        $myfinal = mysqli_query($conn, $sqlfinal);


        echo json_encode(array(
            'id' => $id,
            'name' => $name,
            'Group Image' => $image,
            'created at' => $created_at,
            'created_by_user_id' => $created_by_user_id,
            'group_privacy' => $group_privacy,
            'created_at' => $created_date,
            'group_visibility' => $group_visibility,
            'message' => 'Group Created',
            'error' => false, 'First Name' =>
            $first_name, 'Last Name' => $last_name,
            'profile_image' => $profile_image,
            'email' => $email
        ));
    } else {
        echo json_encode(array('message' => 'Not Created', 'error' => true));
    }
}
