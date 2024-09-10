<?php
class Database {
    private $MYSQL_HOST = "localhost";
    private $MYSQL_USER = 'root';
    private $MYSQL_PASS = '';
    private $MYSQL_DB = 'car_example';
    private $CHARSET = 'utf8';
    private $COLLATION = 'utf8_general_ci';
    public $pdo = null;

    public function __construct() {
        $SQL = "mysql:host=" . $this->MYSQL_HOST . ";dbname=" . $this->MYSQL_DB . ";charset=" . $this->CHARSET;

        try {
            $this->pdo = new \PDO($SQL, $this->MYSQL_USER, $this->MYSQL_PASS);
            $this->pdo->exec("SET NAMES '" . $this->CHARSET . "' COLLATE '" . $this->COLLATION . "'");
            $this->pdo->exec("SET CHARACTER SET '" . $this->CHARSET . "'");
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            die("\PDO ile veritabanına ulaşılamadı: " . $e->getMessage());
        }
    }

    public function __destruct() {
        $this->pdo = null;
    }

    // SQL Enjeksiyon zafiyeti içeren metod
    public function searchCars($brand, $year) {
        $sql = "SELECT brand, model, year, price FROM cars WHERE 1=1";
        
        if (!empty($brand)) {
            $sql .= " AND brand = '$brand'";
        }
    
        if (!empty($year)) {
            $sql .= " AND year = $year";
        }
    
        try {
            $result = $this->pdo->query($sql);
            return [$sql, $result->fetchAll(), ''];
        } catch (\PDOException $e) {
            // Hata tabanlı SQL enjeksiyon için hatayı döndür
            return [$sql, [], $e->getMessage()];
        }
    }
}

$db = new Database();

$cars = [];
$sql = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $brand = $_GET['brand'] ?? '';
    $year = $_GET['year'] ?? '';

    list($sql, $cars, $error) = $db->searchCars($brand, $year);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Araba Sorgulama Formu</title>
    <style>
        body {
            background: url('../bg.png') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: black;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
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
        input[type="text"],
        input[type="number"] {
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
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: rgba(102, 51, 153, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid white;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: rgba(102, 51, 153, 0.8);
        }
        tr:nth-child(even) {
            background: rgba(102, 51, 153, 0.8);
        }
        tr:hover {
            background: #f1f1f1;
        }
    </style>
</head>
<body>
    <h2>Araba Sorgulama Formu</h2>
    <form method="GET" action="">
        <input type="hidden" name="search" value="1">
        <label for="brand">Marka:</label>
        <input type="text" id="brand" name="brand">
        <br>
        <label for="year">Yıl:</label>
        <input type="number" id="year" name="year">
        <br>
        <input type="submit" value="Ara">
    </form>

    <?php if (!empty($error)): ?>
        <div class="error">
            <h3>SQL Hatası:</h3>
            <p><?php echo htmlspecialchars($error); ?></p>
        </div>
    <?php endif; ?>

    <?php if (!empty($cars)): ?>
        <h2>Arama Sonuçları</h2>
        <table border="1">
            <tr>
                <th>Marka</th>
                <th>Model</th>
                <th>Yıl</th>
                <th>Fiyat</th>
            </tr>
            <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?php echo !empty($car->brand) ? htmlspecialchars($car->brand) : ''; ?></td>
                    <td><?php echo !empty($car->model) ? htmlspecialchars($car->model) : ''; ?></td>
                    <td><?php echo !empty($car->year) ? htmlspecialchars($car->year) : ''; ?></td>
                    <td><?php echo !empty($car->price) ? htmlspecialchars($car->price) : ''; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
