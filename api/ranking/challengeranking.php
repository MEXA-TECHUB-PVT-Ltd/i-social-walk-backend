<?php

header('Content-Type: application/json');
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$challenge_id = $DecodeData['challenge_id'];
$date = date('Y-m-d');
$sub = date('Y-m-d', strtotime('-7 days'));
$date = date("Y-m-d");
$sql = "SELECT * 
FROM challenges_participants 
where challenge_id='$challenge_id'";
$date = date('Y-m-d');
$finalsteps = 0;
$sub = date('Y-m-d', strtotime('-7 days'));
$run = mysqli_query($conn, $sql);
if (mysqli_num_rows($run)) {
    while ($row = mysqli_fetch_assoc($run)) {
        $user_id = $row['user_id'];
        $query = "Select sum(steps),user_id,id from daily_steps_records where date BETWEEN  '$sub' and '$date' AND user_id='$user_id'  ";
        $run2query = mysqli_query($conn, $query);
        print_r(mysqli_fetch_array($run2query));
        die();
        if (mysqli_num_rows($run2query) > 0) {

            while ($row2 = mysqli_fetch_assoc($run2query)) {

                $id = $row2['id'];
                $steps = $row2['sum(steps)'];
                $user_id = $row2['user_id'];
            }
            $sql = "SELECT first_name,last_name from users where id='$user_id'";
            $query1 = mysqli_query($conn, $sql);

            if ($query1) {
                while ($row = mysqli_fetch_assoc($query1)) {
                    $users[] = array(
                        "Name" => $row['first_name'] . ' ' . $row['last_name'],
                        "User Id" => $user_id,
                    );
                }
            }
            $response[] = array(
                "Users" => $users,
                "Steps id" =>  $id,


                "steps" => $steps,


            );
        } else {
            $response[] = array(

                "message" => 'No Record from previous seven days ',

                "error" => true,
            );
        }
    }
} else {
    $response[] = array(

        "message" => 'No Challenge Exists ',

        "error" => true,
    );
}


echo json_encode($response);
