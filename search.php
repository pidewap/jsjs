<?php
require('simple_html_dom.php');
$teks_asli = $_GET['q'];
$hasil = str_replace([' '], ['-'], $teks_asli);
$url='https://www.google.co.id/search?q='.$hasil.'-youtube&tbm=vid';
// Create DOM from URL or file
$html = file_get_html($url);

// creating an array of elements
$videos = [];

// Find top ten videos
$i = 1;
foreach ($html->find('div[class=ZINbbc xpd O9g5cc uUPGi]') as $video) {
        if ($i > 10) {
                break;
        }

        // Find item link element
        $videoDetails = $video->find('div.kCrYT', 0);

        // get title attribute
        $videoTitle = str_replace(' - YouTube','', $videoDetails->find('h3', 0)->plaintext);

        // get href attribute
        $videoUrl = urldecode($videoDetails->find('a', 0)->href);
        $videUrl = explode("=",$videoUrl);
        $videoUrl = str_replace("&sa", "", $videUrl[2]);
        $videoDatee = $video->find('div[class=BNeawe s3v9rd AP7Wnd]', 0);
        $videoDate = $videoDatee->find('span', 0)->plaintext;
        // push to a list of videos
        $videos[] = [
                'title' => $videoTitle,
                'url' => $videoUrl,
                'date' => $videoDate
        ];

        $i++;
}

echo json_encode($videos, JSON_UNESCAPED_UNICODE);
?>
