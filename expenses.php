<?php
include 'db.php';

// Function to add a new expense
function addExpense($conn, $wallet_id, $particulars, $amount) {
    $sql = "INSERT INTO expenses (wallet_id, particulars, amount) VALUES ($wallet_id, '$particulars', $amount)";
    if ($conn->query($sql) === TRUE) {
        // Deduct expense amount from wallet balance
        $deductSql = "UPDATE wallets SET amount = amount - $amount WHERE id = $wallet_id";
        if ($conn->query($deductSql) === TRUE) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Close connection
$conn->close();
?>
