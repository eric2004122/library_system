<?php
require_once('../config.php');
header('Content-Type: application/json');

$sql = "SELECT id, name, borrow_period FROM categories";
$result = $conn->query($sql);
$categories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
echo json_encode($categories);
?>