<?php
set_time_limit(0);
if (isset($_GET['key']) && isset($_GET['id'])) {
    $key = $_GET['key'];
    $bookId = $_GET['id'];

    include 'config.php';

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("数据库连接失败: " . $conn->connect_error);
    }

    $query = "SELECT bookid FROM book_data WHERE `key` = '$key'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bookIdFromDB = $row['bookid'];

        if ($bookIdFromDB === null) {
            $updateQuery = "UPDATE book_data SET bookid = '$bookId' WHERE `key` = '$key'";
            if ($conn->query($updateQuery) === false) {
                echo "数据库连接失败";
            } else {
                include("dl-book.php");
            }
        } else {
            echo "已经使用过的key！使用的bookid: $bookIdFromDB";
        }
    } else {
        echo "无效的key";
    }

    $conn->close();
} else {
    echo "未提供有效的key和bookid";
}
?>
