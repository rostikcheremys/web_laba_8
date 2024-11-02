<?php
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $url = "https://www.foxtrot.com.ua/uk/search?query=" . urlencode($query);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Помилка: " . curl_error($ch);
    } else {
        $dom = new DOMDocument();
        @$dom->loadHTML($response);
        $xpath = new DOMXPath($dom);

        $articles = $xpath->query('//article');

        $items = '';

        foreach ($articles as $article) {
            $titleElement = $xpath->query('.//div[@class="card__head "]', $article);
            $title = $titleElement->length > 0 ? $titleElement->item(0)->getAttribute('data-title') : 'Назва не знайдена';

            $imageElement = $xpath->query('.//img[@class="align-self-center r-img "]', $article);
            $image = $imageElement->length > 0 ? $imageElement->item(0)->getAttribute('src') : 'Зображення не знайдено';

            $priceElement = $xpath->query('.//div[@class="card-price"]', $article);
            $price = $priceElement->length > 0 ? trim($priceElement->item(0)->textContent) : 'Ціна не знайдена';

            $items .= "<section class='item'>
                                <img id='item-image' src='$image' alt='$title'>
                                
                                <div class='item-info'>
                                    <p id='item-name'>$title</p>
                                    <p id='item-price'>$price</p>          
                                </div>
                       </section>";
        }
        echo $items;
    }

    curl_close($ch);
    exit;
}