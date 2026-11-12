<?php
header("Content-Type: application/json; charset=UTF-8");

$mode = $_GET['mode'] ?? 'safe';
$username = $_GET['username'] ?? '';

if (!in_array($mode, ['safe', 'unsafe'], true)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Mode must be safe or unsafe"
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo = new PDO("sqlite::memory:");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec(
        "CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL
        )"
    );

    $insert = $pdo->prepare("INSERT INTO users (username) VALUES (:username)");

    $users = ["admin", "alice", "bob"];

    foreach ($users as $user) {
        $insert->execute(["username" => $user]);
    }

    if ($mode === "unsafe") {
        $sql = "SELECT id, username FROM users WHERE username = '$username'";
        $statement = $pdo->query($sql);
    } else {
        $statement = $pdo->prepare(
            "SELECT id, username FROM users WHERE username = :username"
        );
        $statement->execute(["username" => $username]);
    }

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "mode" => $mode,
        "username" => $username,
        "result_count" => count($results),
        "users" => $results,
        "message" => $mode === "safe"
            ? "The input was treated as data using a prepared statement."
            : "Unsafe demonstration: input was inserted directly into the SQL query."
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (PDOException $error) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "A database operation failed."
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>