<?php
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/config_api.php';
class API {
    function SelectContent($chapter_id){
        $db = new Connect;
        $content = array();
        $data = $db->prepare("SELECT * FROM content WHERE chapter_id = '$chapter_id'");
        $data->execute();
        $content= $data->fetch();
        return json_encode($content);
    }
}

$API = new API;
header('Content-Type: application/json');
$chapter_id = $_GET['chapter_id'];
echo $API->SelectContent($chapter_id);
?>