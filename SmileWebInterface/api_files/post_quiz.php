<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: authorization, content-type, x-requested-with');
require_once __DIR__ . '/config_api.php';

// Takes raw data from the request
$json = file_get_contents('php://input');

$responses = json_decode($json, true);

function checkAnswers($chapter_id, $responses){
    $db = new Connect;
    $quiz = array();
    $data = $db->prepare("SELECT * FROM quiz WHERE chapter_id = '$chapter_id'");
    $data->execute();
    $quiz= $data->fetch();
    $score = 0;
    for ($i=1; $i<=5; $i++) {
        if ($responses['answer' . $i] == $quiz['answer_' . $i]){
            $score++;
        }
    }
    return json_encode($score);

};

function quizStats($chapter_id, $responses){
    $db = new Connect;
    $stats = array();
    $data = $db->prepare("SELECT * FROM generalstats");
    $data->execute();
    $stats= $data->fetch();
    $quiz_points = $stats['total_count_achieved_quiz_points'];

    $score = json_decode(checkAnswers($chapter_id, $responses));
    $quiz_points += $score;

    $query1 = $db->prepare("UPDATE smiledatabase.generalstats
    SET total_count_achieved_quiz_points = '$quiz_points'
    WHERE total_count_achieved_quiz_points IS NOT NULL;");
    $query1->execute();
};

if (isset($_GET['chapter_id'])) {
    header('Content-Type: application/json');
    $chapter_id = $_GET['chapter_id'];
    echo checkAnswers($chapter_id, $responses);
    quizStats($chapter_id, $responses);
}

?>