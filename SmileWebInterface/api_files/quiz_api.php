<?php
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/config_api.php';
class API {
    function SelectQuiz($chapter_id){
        $db = new Connect;
        $quiz = array();
        $data = $db->prepare("SELECT * FROM quiz WHERE chapter_id = '$chapter_id'");
        $data->execute();
        $quiz= $data->fetch();
        return json_encode($quiz);
    }
}

$API = new API;
header('Content-Type: application/json');
$chapter_id = $_GET['chapter_id'];
echo $API->SelectQuiz($chapter_id);
?>