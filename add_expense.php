<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Expense</h1>
        <form action="" method="post">
            <label for="expense-wallet">Wallet:</label>
            <select id="expense-wallet" name="expense-wallet" required>
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
            <label for="expense-particulars">Particulars:</label>
            <input type="text" id="expense-particulars" name="expense-particulars" required>
            <label for="expense-amount">Amount:</label>
            <input type="number" id="expense-amount" name="expense-amount" min="0" step="0.01" required>
            <button type="submit" name="add-expense">Add Expense</button>
        </form>
        <?php
        if (isset($_POST['add-expense'])) {
            $walletId = $_POST['expense-wallet'];
            $particulars = $_POST['expense-particulars'];
            $amount = $_POST['expense-amount'];

            include 'db.php';

            $sql = "INSERT INTO expenses (wallet_id, particulars, amount) VALUES ($walletId, '$particulars', $amount)";
            if ($conn->query($sql) === TRUE) {
                echo '<script>alert("Expense added successfully!");</script>';
                echo '<script>window.location.href = "add_expense.php";</script>';
            } else {
                echo '<script>alert("Failed to add expense. Please try again.");</script>';
            }

            $conn->close();
        }
        ?>
        <br>
        <a class="button" href="index.php">Back to Dashboard</a>
    </div>
</body>
</html>
