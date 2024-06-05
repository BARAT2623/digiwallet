<?php
if (!isset($_GET['id'])) {
    echo '<script>alert("Wallet ID is required.");</script>';
    echo '<script>window.location.href = "manage_wallets.php";</script>';
    exit;
}

$walletId = $_GET['id'];

include 'db.php';

// Delete expenses related to the wallet
$deleteExpensesSql = "DELETE FROM expenses WHERE wallet_id = $walletId";
if ($conn->query($deleteExpensesSql) === TRUE) {
    // Now delete the wallet
    $deleteWalletSql = "DELETE FROM wallets WHERE id = $walletId";
    if ($conn->query($deleteWalletSql) === TRUE) {
        echo '<script>alert("Wallet deleted successfully!");</script>';
    } else {
        echo '<script>alert("Failed to delete wallet. Please try again.");</script>';
    }
} else {
    echo '<script>alert("Failed to delete expenses. Please try again.");</script>';
}

$conn->close();

echo '<script>window.location.href = "manage_wallets.php";</script>';
?>
