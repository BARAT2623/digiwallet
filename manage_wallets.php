<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Wallets</title>
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
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .danger {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Wallets</h1>
        <a class="button" href="index.php">Back to Dashboard</a>
        
        <h2>Existing Wallets</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';

                $sql = "SELECT * FROM wallets";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>₹{$row['amount']}</td>";
                        echo "<td><span class='danger' onclick='deleteWallet({$row['id']})'>Delete</span></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No wallets found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function deleteWallet(walletId) {
            if (confirm("Are you sure you want to delete this wallet?")) {
                // Redirect to delete_wallet.php with walletId as parameter
                window.location.href = `delete_wallet.php?id=${walletId}`;
            }
        }
    </script>
</body>
</html>
