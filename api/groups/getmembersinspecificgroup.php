
<?php

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
include('../include/connection.php');

$sql = "Select * from groups WHERE  id='$id'";
$result1 = mysqli_query($conn, $sql);
$rowcount = mysqli_num_rows($result1);
if ($rowcount > 0) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $sql = "Select * from group_member WHERE group_id='$id' AND status='membered' ";

        $result = mysqli_query($conn, $sql);

        $rowcount = mysqli_num_rows($result);
        if ($rowcount > 0) {
            $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {

            $response[] = array(
                "message" => 'No Members found',

                "error" => false

            );
        }
    }
    $response[] = array(
        "message" => 'Members',

        "Members" =>  $output,
        "error" => false

    );
} else {

    $response[] = array(
        "message" => 'No Members found',

        "error" => false

    );
}
echo json_encode($response);
?>
