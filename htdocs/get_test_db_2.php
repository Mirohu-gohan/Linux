<?php
//データベースへ接続するために必要な情報
//ホストはDBコンテナ
$host ='mysql';
//mysql接続用のユーザー
$username='data_user';
$password ='data';
$database='test_db';

try{
    //PDOでMySQLに接続
    $pdo =new PDO("mysql:host=$host;dbname=$darabase;charset=utf8",$username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //データの取得
    $stmt =$pdo->query("SELECT*FROM test_table");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 取得したデータをセッションに保存
    session_start();
    $_SESSION['data'] = $results;

    // リダイレクト
    header("Location: display_test_db_2.php");
    exit();

} catch (PDOException $e) {
    // エラー処理
    echo "データベースエラー: " . $e->getMessage();
}
?>

<head>
    <title>display_data</title>
</head>
<body>
    <h1>data_list</h1>
    <?php
        if (isset($_SESSION['data'])) {
            $data = $_SESSION['data'];
            if (count($data) > 0) {
                echo "<table>";
                echo "<thead><tr>";
                foreach (array_keys($data[0]) as $column) {
                    echo "<th>" . htmlspecialchars($column) . "</th>";
                }
                echo "</tr></thead>";
                echo "<tbody>";
                foreach ($data as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>no data1</p>";
            }
            unset($_SESSION['data']);
        } else {
            echo "<p>no data2</p>";
        }
    ?>
</body>
</html>

<head>
    <title>display_data</title>
</head>
<body>
    <h1>data_list</h1>
    <?php
        if (isset($_SESSION['data'])) {
            $data = $_SESSION['data'];
            if (count($data) > 0) {
                echo "<table>";
                echo "<thead><tr>";
                foreach (array_keys($data[0]) as $column) {
                    echo "<th>" . htmlspecialchars($column) . "</th>";
                }
                echo "</tr></thead>";
                echo "<tbody>";
                foreach ($data as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>no data1</p>";
            }
            unset($_SESSION['data']);
        } else {
            echo "<p>no data2</p>";
        }
    ?>
</body>
</html>


