<?php

$time = date('Y-m-d') . "T" . date('H:i:s') . "Z";

$tomorrow = date("Y-m-d", time() + 86400) . "T" . date('H:i:s') . "Z";

echo 'current: ' . $time;
echo 'tomorrow: ' . $tomorrow;

?>