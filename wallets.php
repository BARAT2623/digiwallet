<?php
include 'db.php';

// Function to fetch all wallets
function getWallets($conn) {
    $sql = "SELECT * FROM wallets";
    $result = $conn->query($sql);

    $wallets = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wallets[] = $row;
        }
    }
    return $wallets;
}

// Function to add a new wallet
function addWallet($conn, $name, $amount) {
    $sql = "INSERT INTO wallets (name, amount) VALUES ('$name', $amount)";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Close connection
$conn->close();
?>
