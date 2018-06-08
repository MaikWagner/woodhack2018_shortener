<?php
require_once('./LinkShrink.php');
$searchLink = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$ls = new LinkShrink();
$destinationUrl = $ls->expandUrl($searchLink);
header('Location: ' . $destinationUrl);
