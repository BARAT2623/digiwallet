<?php
include 'db.php';

// Fetch all wallets
$sql = "SELECT * FROM wallets";
$result = $conn->query($sql);

$wallets = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wallets[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($wallets);

$conn->close();
?>
