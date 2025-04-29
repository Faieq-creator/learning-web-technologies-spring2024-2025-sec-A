<?php
require_once 'functions.php';

$term = isset($_GET['term']) ? trim($_GET['term']) : '';
$conn = getDBConnection();
$sql = "SELECT * FROM products WHERE display = 1 AND name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $term . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$output = '';
while ($product = $result->fetch_assoc()) {
    $output .= "<tr>";
    $output .= "<td>" . htmlspecialchars($product['name']) . "</td>";
    $output .= "<td>" . number_format($product['selling_price'] - $product['buying_price'], 2) . "</td>";
    $output .= "<td class='action-links'>";
    $output .= "<a href='edit.php?id=" . $product['id'] . "' class='edit'>edit</a>";
    $output .= "<a href='delete.php?id=" . $product['id'] . "' class='delete'>delete</a>";
    $output .= "</td>";
    $output .= "</tr>";
}

$stmt->close();
$conn->close();
echo $output;
?>