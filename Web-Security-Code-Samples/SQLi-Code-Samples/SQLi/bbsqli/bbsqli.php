<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_example";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function checkUserExists($id) {
    global $conn;
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (checkUserExists($id)) {
        $message = "User exists.";
    } else {
        $message = "No user found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blind SQLi Example</title>
    <style>
        body {
            background: url('../bg.png') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: black;
        }
        h2 {
            text-align: center;
            margin-top: 80px;
        }
        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(102, 51, 153, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid white;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #28a745;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        input[type="submit"]:hover {
            background: black;
        }
        .result {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(102, 51, 153, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid white;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Blind SQLi Example</h2>
    <form method="get" action="">
        <label for="id">User ID:</label>
        <input type="text" id="id" name="id">
        <input type="submit" value="Submit">
    </form>

    <?php if (isset($message)): ?>
        <div class="result">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
</body>
</html>
