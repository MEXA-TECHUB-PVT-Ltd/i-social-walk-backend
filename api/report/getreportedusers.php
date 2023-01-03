<?php
include('../include/functions.php');
include('../include/connection.php');
$EncodeData = file_get_contents('php://input');
$DecodeData = json_decode($EncodeData, true);
$reported_by = $DecodeData['reported_by'];

$sql = "Select * from reportusers where reported_by='$reported_by'  ";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = array(
            'Reported User' => $row['report_user'],
            "comments" => $row['comments'],
            "reported_by" => $row['reported_by'],
        );
    }
} else {
    $response[] = array('message' => 'You Did not reported', 'error' => 'true');
}
echo json_encode($response);
