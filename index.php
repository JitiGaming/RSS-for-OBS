<!DOCTYPE html>
<html>
<head>
<title>Actualités jeux vidéo</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<meta http-equiv="refresh" content="1800">
</head>
<body>
<div id="news-container">
<?php
ini_set('display_errors',0);
$feeds = array(

	'https://www.canardpc.com/feed' => 'Canard PC',
	'https://www.xboxygen.com/spip.php?page=backend' => 'Xboxygen',
	'https://www.liberation.fr/arc/outboundfeeds/rss-all/category/culture/jeux-video/?outputType=xml' => 'Libération',
	'https://kotaku.com/rss' => 'Kotaku',
	'https://insider-gaming.com/feed' => 'Insider Gaming',
	'https://www.eurogamer.net/feed' => 'Eurogamer',
	'https://jiti.me/feed' => 'Jiti.Me'
			
		);

        $data = array();

        foreach ($feeds as $url => $siteName) {
            $rss = simplexml_load_file($url);
            $count = 0; // Counter for limiting to 2 items per site
            foreach ($rss->channel->item as $item) {
                if ($count < 2) {
                    $data[] = array('title' => (string)$item->title, 'date' => date_create($item->pubDate), 'site' => $siteName);
                    $count++;
                }
            }
        }

        $date = array_column($data, 'date');
        array_multisort($date, SORT_DESC, $data);

        foreach ($data as $value) {
            echo '<div class="news-title">' . $value['title'] . ' (' . $value['site'] . ')</div>';
        }
        ?>
    </div>

    <script>
        const newsContainer = document.getElementById('news-container');
        const newsTitles = newsContainer.getElementsByClassName('news-title');
        let currentIndex = 0;

        function showNextTitle() {
            newsTitles[currentIndex].style.display = 'none';
            currentIndex = (currentIndex + 1) % newsTitles.length;
            newsTitles[currentIndex].style.display = 'block';
        }

        for (let i = 1; i < newsTitles.length; i++) {
            newsTitles[i].style.display = 'none';
        }

        setInterval(showNextTitle, 10000);
    </script>
</body>
</html>
