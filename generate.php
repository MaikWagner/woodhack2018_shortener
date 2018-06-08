<?php
require_once('./LinkShrink.php');
$ls = new LinkShrink();
echo $ls->generateShortLink('https://www.sevenval.com/de/competences/');
$urls = $ls->shrinkUrls('https://www.sevenval.com/de/competences', 'source', 'medium', 'name', 'term', 'cntent');
