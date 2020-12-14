<?php
require('simple_html_dom.php');
$teks_asli = $_GET['q'];
$hasil = str_replace([' '], ['-'], $teks_asli);
$url='https://www.google.com/search?q='.$hasil.'-youtube&tbm=vid&tbs=srcf:H4sIAAAAAAAAAC2MQQ6AIBDEfsPFhD8B7mEizBJ20fh7DXpr2qTbrdNnlli0hUNbT7awkOCuFENawgfyJOX6u1rTrhWe-IqIPYAmwyvOb_1YASGYprloAAAA&lr=lang_id';
// Create DOM from URL or file
$html = file_get_html($url);


$videos = [];


$i = 1;
foreach ($html->find('div[class=ZINbbc xpd O9g5cc uUPGi]') as $video) {
        if ($i > 10) {
                break;
        }


        $videoDetails = $video->find('div.kCrYT', 0);


        $videoTitle = str_replace(' - YouTube','', $videoDetails->find('h3', 0)->plaintext);


        $videoUrl = urldecode($videoDetails->find('a', 0)->href);
        $videUrl = explode("=",$videoUrl);
        $videoUrl = str_replace("&sa", "", $videUrl[2]);
        $videoDatee = $video->find('div[class=BNeawe s3v9rd AP7Wnd]', 0);
        $videoDate = $videoDatee->find('span', 0)->plaintext;

        $videos[] = [
                'title' => $videoTitle,
                'url' => $videoUrl,
                'date' => $videoDate
        ];

        $i++;
}

echo json_encode($videos, JSON_UNESCAPED_UNICODE);

//echo $html;
?>
