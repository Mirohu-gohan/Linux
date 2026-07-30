<?php
$host = 'mysql';
$username = 'data_user';
$password = 'data';
$database = 'test_db';

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データベースから生徒一覧を取得
    $sql = "SELECT student_id, student_name, class_id FROM students";
    $stmt = $conn->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "DB Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>students</title>
</head>
<body>
    <h1>student_list</h1>
    <?php if (count($data) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>student_id</th>
                    <th>student_name</th>
                    <th>class_id</th>
                    <th>delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_id']) ?></td>
                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                        <td>
                            <a href="http://localhost/get_class.php?class_id=<?= htmlspecialchars($row['class_id']) ?>">
                                <?= htmlspecialchars($row['class_id']) ?>
                            </a>
                        </td>
                        <td>
                            <form method="post" action="delete_student.php" style="display:inline;">
                                <input type="hidden" name="student_id" value="<?= htmlspecialchars($row['student_id']) ?>">
                                <button type="submit" onclick="return confirm('ID: <?= htmlspecialchars($row['student_id']) ?> delete?');">DELETE</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>no data</p>
    <?php endif; ?>
</body>
</html>