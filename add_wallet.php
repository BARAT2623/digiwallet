<?php
include 'db.php';

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$amount = $data['amount'];

// Insert new wallet
$sql = "INSERT INTO wallets (name, amount) VALUES ('$name', $amount)";
if ($conn->query($sql) === TRUE) {
    $response = array('success' => true);
} else {
    $response = array('success' => false);
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
