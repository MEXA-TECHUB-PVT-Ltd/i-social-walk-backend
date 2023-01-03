<?php
include('../include/connection.php');

$EncodeData = file_get_contents('php://input');
$data = json_decode($EncodeData, true);

$challenge_id = $data['challenge_id'];

$sql12 = "Select *  from challenges where id='$challenge_id'";
$query = mysqli_query($conn, $sql12);
if (mysqli_num_rows($query) > 0) {
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $challenge_type = $row['challenge_type'];
        }
    }

    $sql1 = "Delete from challenges where id='$challenge_id'";
    $query = mysqli_query($conn, $sql1);
    if ($query) {
        $response[] = array(
            "message" => 'Successfully Deleted challenge',
            "challenge" => $challenge_id,

            "error" => false

        );
        if ($challenge_type == "group") {

            $sql = "delete from challenges_participants where challenge_id='$challenge_id'";
            $querychallenge = mysqli_query($conn, $sql);
            if ($querychallenge) {
                $sql = "delete from challenges_groups where challenge_id='$challenge_id'";
                $querychallenge1 = mysqli_query($conn, $sql);
                if ($querychallenge1) {
                    $sql = "delete from group_challenge_notification where challenge_id='$challenge_id'";
                    $querychallengefinal = mysqli_query($conn, $sql);
                    if ($querychallengefinal) {
                        $response[] = array(
                            "message" => 'Deleted Group Challenege ',

                            "error" => false

                        );
                    }
                }
            }
        } else {

            $sql = "delete from challenges_participants where challenge_id='$challenge_id'";
            $querychallenge = mysqli_query($conn, $sql);
            if ($querychallenge) {
                $sql = "delete from challenges_groups where challenge_id='$challenge_id'";
                $querychallenge1 = mysqli_query($conn, $sql);
                if ($querychallenge1) {
                    $sql = "delete from individual_challenge_notification where challenge_id='$challenge_id'";
                    $querychallengefinal = mysqli_query($conn, $sql);
                    if ($querychallengefinal) {
                        $response[] = array(
                            "message" => 'Deleted Group Challenege ',

                            "error" => false

                        );
                    }
                }
            }
        }
    }
} else {
    $response[] = array(
        "message" => 'This Challenege doesnot exist',

        "error" => false

    );
}
echo json_encode($response);
