<?php
   header('Access-Control-Allow-Origin: *');

//Import the database connection
require_once __DIR__ . "/db_connection.php";

// Check only the data once the data has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $key  = $obj->key;
        $total_count_message_A = $obj->total_count_message_A;
        $Q1_count_message_A = $obj->Q1_count_message_A;
        $Q2_count_message_A = $obj->Q2_count_message_A;
        $Q4_count_message_A = $obj->Q4_count_message_A;
        $Q5_count_message_A = $obj->Q5_count_message_A;
        $Q6_count_message_A = $obj->Q6_count_message_A;
        $Q7_count_message_C = $obj->Q7_count_message_C;
        $Q8_count_message_D = $obj->Q8_count_message_D;

        // Prepare a SQL query to update the stats
        $query = "UPDATE selfdiagnosisstats
                  SET
                  total_count=total_count + 1,
                  total_count_message_A=total_count_message_A + $total_count_message_A,
                  Q1_count_message_A=Q1_count_message_A + $Q1_count_message_A,
                  Q2_count_message_A=Q2_count_message_A + $Q2_count_message_A,
                  Q4_count_message_A=Q4_count_message_A + $Q4_count_message_A,
                  Q5_count_message_A=Q5_count_message_A + $Q5_count_message_A,
                  Q6_count_message_A=Q6_count_message_A + $Q6_count_message_A,
                  Q7_count_message_C=Q7_count_message_C + $Q7_count_message_C,
                  Q8_count_message_D=Q8_count_message_D + $Q8_count_message_D
                  WHERE
                  id=1";

        $queryResult = mysqli_query($link, $query);
        echo json_encode(array("success"=> true));
};

// Close the connection
mysqli_close($link);

?>
