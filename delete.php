<?php
require_once 'db.php';

if (!isset($_GET['id'])) {
    echo "User ID nahi mili.";
    exit;
}

$id = intval($_GET['id']);

$sql = "DELETE FROM users WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Delete karte waqt error: " . $conn->error;
}
?>
