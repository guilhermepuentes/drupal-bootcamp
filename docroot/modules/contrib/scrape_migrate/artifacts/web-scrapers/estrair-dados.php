<?php

$content = file_get_contents('https://www.squadra.com.br', '/blog');

preg_match_all('/<div class="col-md-4 col-sm-6">(.*?)<\/div>/s', $content, $urldecode,);



?>

// #class="row mb-3 post-single
