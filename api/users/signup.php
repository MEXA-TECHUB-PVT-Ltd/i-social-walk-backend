<?php
include('../include/connection.php');
// Headers

$Data = json_decode(file_get_contents("php://input"), true);
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$email = $DecodeData['email'];
$password = $DecodeData['password'];
$first_name = $DecodeData['first_name'];
$last_name = $DecodeData['last_name'];
$phoneno = $DecodeData['phoneno'];
$created_date = date('d-m-Y');
$devicetoken = rand(1000, 9000);
$sql_checkemail = "SELECT * FROM users";
$run_checkemail = mysqli_query($conn, $sql_checkemail);
$checkemail_result = 0;
while ($row_checkemail = mysqli_fetch_assoc($run_checkemail)) {
    if ($row_checkemail['email'] == $email) {
        $checkemail_result = 1;
        break;
    }
}
$GoalMessage = "";
if ($checkemail_result == 1) {
    $message = 'Email Already Exist';
    $response[] = array(
        "message" => $message,
        "error" => true,

    );
    echo json_encode($response);
} else {
    $password = md5($password);
    $sql = "INSERT INTO users(email,password,phoneno,first_name,last_name,status,device_token,created_at,Role) 
	VALUES ('$email','$password','$phoneno','$first_name','$last_name','active','$devicetoken','$created_date','U')";
    $run = mysqli_query($conn, $sql);

    if ($run) {
        $uniqid = uniqid();
        $created_date = date('Y-m-d');
        $sql_id = "SELECT * FROM users";
        $run_id = mysqli_query($conn, $sql_id);
        $id_result = 0;
        while ($row_id = mysqli_fetch_assoc($run_id)) {
            if ($row_id['email'] == $email) {
                $id_result = $row_id['id'];
                $quergoals = "INSERT INTO goals(user_id,daily_goal_steps,weekly_goal_steps,date,week_uniq_id)VALUES('$id_result','1200','1200','$created_date','$uniqid')";
                $run_id = mysqli_query($conn, $quergoals);
                if ($run_id) {

                    $GoalMessage = "Your Goals are Updated,You can Update";
                }
                break;
            } else {
                continue;
            }
        }
    } else {
        $message = 'error';
    }

    $_SESSION["email"] = $email;
    $_SESSION["id"] = $id_result;

    $response[] = array(
        "GoalMessage" => $GoalMessage,
        "message" => 'Signup Successful',
        "email" => $email,
        "password" => $password,
        "id" => $id_result,
        "first_name" => $first_name,
        "last_name" => $last_name,
        "devicetoken" => $devicetoken,
        "error" => false,
    );
    echo json_encode($response);
}
