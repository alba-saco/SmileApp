<?php
require_once __DIR__ . '/config_api.php';
class API {
    function SelectCategories(){
        $db = new Connect;
        $categories = array();
        $data = $db->prepare('SELECT * FROM category ORDER BY category_id');
        $data->execute();
        while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
            $categories[$OutputData['category_id']] = array(
                'category_id' => $OutputData['category_id'],
                'category_name' => $OutputData['category_name'],
                'category_image_url' => $OutputData['category_image_url']
            );
        }
        return json_encode($categories);
    }
}

$API = new API;
header('Content-Type: application/json');
echo $API->SelectCategories();
?>