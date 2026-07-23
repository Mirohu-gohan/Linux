<?php
// 1. パラメータに class_id が入っているかチェック
if (!isset($_GET['class_id']) || empty($_GET['class_id'])) {
    die("エラー：class_idが指定されていません。");
}

$class_id = intval($_GET['class_id']);

// 2. データベース接続情報
$host = 'mysql';
$username = 'data_user';
$password = 'data';
$database = 'test_db'; 

try {
    // PDOで接続
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. 送られてきた class_id に一致するクラス情報を取得するSQL
    $stmt = $pdo->prepare("SELECT class_id, class_name FROM classes WHERE class_id = :class_id");
    $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $class_info = $stmt->fetch(PDO::FETCH_ASSOC);

    // 4. 画面に出力する（画像の右側と同じフォーマット）
    if ($class_info) {
        // ヘッダー（項目名）の表示
        echo "class_id class_name<br>";
        // データの表示
        echo htmlspecialchars($class_info['class_id']) . " " . htmlspecialchars($class_info['class_name']);
    } else {
        echo "該当するクラスが見つかりませんでした。";
    }

} catch (PDOException $e) {
    echo "データベースエラー: " . $e->getMessage();
}
?>