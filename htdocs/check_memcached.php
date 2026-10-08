<?php
//データベースへ接続するために必要な情報
//ホストはDBコンテナ
$host ='mysql';
//mysql接続用のユーザー
$username ='data_user';
$password='data';
$databse='data_master';

//キャッシュへの接続情報
$memcachedHost='memcache';
$memcachedPort=11211;

$cacheKey ='all_students_data';
$expireSeconds=60;

$memcached =new Memcached();
$memcached->addServer($memcachedHost,$memcachedPort);

echo"<h1>MySQL Data Caching with Memcached</h1>";

$cachedData =$memcached->get($cacheKey);

if($cachedData){
    echo "<p>Data retrieved from Memcached(cache hit!).</p>";
    echo "<pre>";
    print_r(json_decode($cachedData,true));
    echo "</pre>";

} else {
    echo "<p>Data not found in Memcached (cache miss). Retrieving from MySQL...</p>";

    try {
    // PDOでMySQLに接続
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // データの取得
        $stmt = $pdo->query("SELECT * FROM students");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // データをMemcachedに保存
        $memcached->set($cacheKey, json_encode($results), $expireSeconds);

        echo "<p>Data retrieved from MySQL and saved to Memcached.</p>";
        echo "<pre>";
        print_r($results);
        echo "</pre>";

    } catch (PDOException $e) {
        echo "<p>Error connecting to MySQL or fetching data: " . $e->getMessage() . "</p>";
    }
}

echo "<p>Current time:".date('Y-m-d H:i:s')."</p>";
echo "<p><a href='?clear_cache=1'>Clear Cache (and reloard to see cache miss)</a></p>";

if(isset($_GET['clear_cache'])&& $_GET['clear_cache']==1){
    if($memcached->delete($cacheKey)){
        echo"<p>Cache for '$cacheKey'cleared!</p>";
    }else{
        echo "<p>Failed to clear cache for '$cacheKey'.</p>";
    }
}
?>
