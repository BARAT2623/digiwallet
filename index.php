<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kutty Wallet </title>
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
        .section {
            display: none;
        }
        .visible {
            display: block;
        }
        .warning {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <center><h1>Wallet Dashboard</h1></center>
        <div>
           <center><button class="button" onclick="showSection('add-wallet-section')">Add Wallet</button><br></center>
           <center><a class="button" href="add_expense.php">Add Expense</a><br></center>
           <center> <button class="button" onclick="showSection('view-wallets-section')">View Existing Wallets</button><br></center>
           <center> <a class="button" href="transactions.php">View Transactions of a Wallet</a><br></center>
           <center> <a class="button" href="manage_wallets.php">Manage Wallet</a><br></center>
        </div>

        <!-- Add Wallet Section -->
        <div id="add-wallet-section" class="section">
            <h2>Add New Wallet</h2>
            <form action="" method="post">
                <label for="wallet-name">Wallet Name:</label>
                <input type="text" id="wallet-name" name="wallet-name" required>
                <label for="wallet-amount">Initial Amount:</label>
                <input type="number" id="wallet-amount" name="wallet-amount" min="0" step="0.01" required>
                <button type="submit" name="add-wallet">Add Wallet</button>
            </form>
            <?php
            if (isset($_POST['add-wallet'])) {
                $walletName = $_POST['wallet-name'];
                $walletAmount = $_POST['wallet-amount'];

                include 'db.php';

                $sql = "INSERT INTO wallets (name, amount) VALUES ('$walletName', $walletAmount)";
                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Wallet added successfully!");</script>';
                    echo '<script>window.location.href = "index.php";</script>';
                } else {
                    echo '<script>alert("Failed to add wallet. Please try again.");</script>';
                }

                $conn->close();
            }
            ?>
        </div>

        <!-- View Existing Wallets Section -->
        <div id="view-wallets-section" class="section">
            <h2>Existing Wallets</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Initial Amount</th>
                        <th>Current Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php';

                    $sql = "SELECT * FROM wallets";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $walletId = $row['id'];
                            $initialAmount = $row['amount'];

                            // Calculate current amount
                            $expenseSql = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE wallet_id = $walletId";
                            $expenseResult = $conn->query($expenseSql);
                            $expenseRow = $expenseResult->fetch_assoc();
                            $totalExpenses = $expenseRow['total_expenses'];
                            $currentAmount = $initialAmount - $totalExpenses;

                            echo "<tr><td>{$row['name']}</td><td>₹{$initialAmount}</td><td>₹{$currentAmount}</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No wallets found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.classList.remove('visible');
            });
            document.getElementById(sectionId).classList.add('visible');
        }
    </script>
</body>
</html>
