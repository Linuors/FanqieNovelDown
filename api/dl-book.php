<?php
set_time_limit(0);

    include 'config.php';
    
    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("数据库连接失败: " . $conn->connect_error);
    }
    
    
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
    $chapterApiUrl = "https://fq-down-api.sediacademy.ca/detail/?book_id=$bookId";
    $chapterApiResponse = file_get_contents($chapterApiUrl);
    if (strlen($bookId) !== 19) {
        echo "这他妈不是正常的bookid，触发:key作废";
        exit();
    }
    
    if ($chapterApiResponse !== false) {
        $chapterData = json_decode($chapterApiResponse, true);
        if (isset($chapterData['data']['item_list'])) {
            $chapterIds = $chapterData['data']['item_list'];
            $book_name = $chapterData['data']['book_info']['book_name']; 
            $sql="UPDATE `book_data` SET `name` = '$book_name' WHERE `book_data`.`bookid` = '$bookId';";
            $mergedContent = fopen("$book_name.txt", "w");
            foreach ($chapterIds as $chapterId) {
                $contentApiUrl = "https://fq-down-api.sediacademy.ca/item/?aid=2329&item_id=$chapterId";
                $contentApiResponse = file_get_contents($contentApiUrl);
                if ($contentApiResponse !== false) {
                    $contentData = json_decode($contentApiResponse, true);
                    if (isset($contentData['data']['content'])) {
                        $chapterContent = $contentData['data']['content'];
                        preg_match('/<div class="tt-title">(.*?)<\/div>/', $chapterContent, $matches);
                        $chapterTitle = $matches[1];
                        $chapterContent = str_replace($matches[0], '', $chapterContent);
                        $chapterContent = str_replace('</p>', "\n", $chapterContent);
                        $chapterContent = strip_tags($chapterContent);
                        $chapterContent = trim($chapterContent);

                        if (!empty($chapterContent)) {
                            fwrite($mergedContent, $chapterTitle . "\n" . $chapterContent . "\n");
                        }
                    }
                }
            }
            fclose($mergedContent);
            $result=$conn->query($sql);
        } else {
            echo "没有找到";
        }
    } else {
        echo "API请求失败";
    }
} else {
    echo "请填写BookId";
}
