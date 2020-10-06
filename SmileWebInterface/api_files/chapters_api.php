<?php
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/config_api.php';
class API {
    function SelectChapters($category_id){
        $db = new Connect;
        $chapters = array();
        $data = $db->prepare("SELECT * FROM chapter WHERE category_id = '$category_id' ORDER BY chapter_number");
        $data->execute();
        $chapters=array();
        while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
            array_push($chapters, array('chapter_id' => $OutputData['chapter_id'], 'category_id' => $OutputData['category_id'], 'chapter_title' => $OutputData['chapter_title'], 'chapter_number' => $OutputData['chapter_number'], 'chapter_image_url' => $OutputData['chapter_image_url']));
        }
        return json_encode($chapters);
    }
    function SelectChapter($category_id, $chapter_id){
        $db = new Connect;
        $chapter = array();
        $data = $db->prepare("SELECT * FROM chapter WHERE category_id = '$category_id' AND chapter_id = '$chapter_id'");
        $data->execute();
        $chapter= $data->fetch();
        return json_encode($chapter);
    }
}

$API = new API;
header('Content-Type: application/json');
if (isset($_GET['chapter_id'])) {
    $category_id = $_GET['category_id'];
    $chapter_id = $_GET['chapter_id'];
    echo $API->SelectChapter($category_id, $chapter_id);
} else {
    $category_id = $_GET['category_id'];
    echo $API->SelectChapters($category_id);
}
?>