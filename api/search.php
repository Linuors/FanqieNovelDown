<?php
if (isset($_GET['q'])) {
    $q = $_GET['q'];

    $api_url = "https://fq-down-api.sediacademy.ca/search?aid=1967&q=" . urlencode($q);

    $response = file_get_contents($api_url);

    if ($response !== false) {
        $data = json_decode($response, true);

        if ($data !== null && isset($data['code']) && $data['code'] === 0 && isset($data['data']['ret_data'])) {
            $books = $data['data']['ret_data'];

            echo "<html>";
            echo "<head><title>关键词 $q 搜索结果</title></head>";
            echo "<body>";

            foreach ($books as $book) {
                $thumb_url = $book["audio_thumb_uri"];

                echo "<div class='book'>";
                echo "<h2>{$book["title"]}</h2>";
                echo "<img src='$thumb_url' height='200' width='150' alt='{$book["title"]}'>";
                echo "<p><strong>bookid:</strong> {$book["book_id"]}</p>";
                echo "<p><strong>作者:</strong> {$book["author"]}</p>";
                echo "<p><strong>简介:</strong> {$book["abstract"]}</p>";
                echo "</div>";
            }

            echo "</body>";
            echo "</html>";
        } else {
            echo "没有找到";
        }
    } else {
        echo "API请求失败";
    }
} else {
    echo "加上q进行搜索";
}
?>
