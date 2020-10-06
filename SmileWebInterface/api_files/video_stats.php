<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: authorization, content-type, x-requested-with');
require_once __DIR__ . '/config_api.php';

$json = file_get_contents('php://input');

$add = json_decode($json);

function addStat($add){
    $db = new Connect;
    $stats = array();
    $data = $db->prepare("SELECT * FROM generalstats");
    $data->execute();
    $stats= $data->fetch();
    $videos = $stats['total_count_videos_accessed'];
    $videos += $add;

    $query = $db->prepare("UPDATE smiledatabase.generalstats
    SET total_count_videos_accessed = '$videos'
    WHERE total_count_videos_accessed IS NOT NULL;");
    $query->execute();
};

addStat($add);

?>