<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet Transactions</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Transactions of a Wallet</h1>
        <form action="" method="post">
            <label for="transaction-wallet">Select Wallet:</label>
            <select id="transaction-wallet" name="transaction-wallet" required>
                <?php
                include 'db.php';

                $sql = "SELECT * FROM wallets";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                } else {
                    echo "<option value=''>No wallets found</option>";
                }

                $conn->close();
                ?>
            </select>
            <button class="button" type="submit" name="view-transactions">View Transactions</button>
        </form>
        <?php
        if (isset($_POST['view-transactions'])) {
            $walletId = $_POST['transaction-wallet'];

            include 'db.php';

            // Fetch initial amount from the time of wallet creation
            $walletSql = "SELECT name, amount FROM wallets WHERE id = $walletId";
            $walletResult = $conn->query($walletSql);
            $wallet = $walletResult->fetch_assoc();
            $initialAmount = $wallet['amount'];

            // Fetch transactions
            $transactionsSql = "SELECT particulars, amount, created_at FROM expenses WHERE wallet_id = $walletId ORDER BY created_at DESC";
            $transactionsResult = $conn->query($transactionsSql);

            if ($transactionsResult->num_rows > 0) {
                echo "<h3>Transactions for Wallet: {$wallet['name']}</h3>";
                echo "<p>Initial Amount: ₹{$initialAmount}</p>";
                echo "<table>
                    <thead>
                        <tr>
                            <th>Particulars</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>";
                $currentAmount = $initialAmount;
                while ($row = $transactionsResult->fetch_assoc()) {
                    echo "<tr><td>{$row['particulars']}</td><td>₹{$row['amount']}</td><td>{$row['created_at']}</td></tr>";
                    $currentAmount -= $row['amount'];
                }
                echo "</tbody></table>";
                echo "<p>Currently Available Amount: ₹{$currentAmount}</p>";
            } else {
                echo "<p>No transactions found for this wallet.</p>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>
