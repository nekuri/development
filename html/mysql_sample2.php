<html>
<body>
<?php
    //mysqlに接続
    $link = mysqli_connect('localhost','root','vagrant');
    //DBの選択
    $db_selected = mysqli_select_db($link, 'oneline_bbs');
    //SQL文の発行
    $result = mysqli_query($link, 'select * from test_table');
    //結果を連想配列に変換
    $row = mysqli_fetch_assoc($result);
    echo '<pre>';
    //表示
    var_dump($row);
    echo '</pre>';
    //close処理
    $close_flag = mysqli_close($link);

?>
</body>
</html>

