<?php
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/config_api.php';
class API {
    function SelectCategories(){
        $db = new Connect;
        $categories = array();
        $data = $db->prepare('SELECT * FROM category ORDER BY category_id');
        $data->execute();
        $categories=array();
        while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
            array_push($categories, array('category_id' => $OutputData['category_id'], 'category_name' => $OutputData['category_name'],'category_image_url' => $OutputData['category_image_url']));
        }
        return json_encode($categories);
    }
    function SelectCategory($category_id){
        $db = new Connect;
        $category = array();
        $data = $db->prepare("SELECT * FROM category WHERE category_id = '$category_id'");
        $data->execute();
        $category= $data->fetch();
        return json_encode($category);
    }
}

$API = new API;
header('Content-Type: application/json');
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    echo $API->SelectCategory($category_id);
} else {
    echo $API->SelectCategories();
}
?>