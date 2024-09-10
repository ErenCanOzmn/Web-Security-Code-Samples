<?php
class Database {
    private $MYSQL_HOST = "localhost";
    private $MYSQL_USER = 'root';
    private $MYSQL_PASS = '';
    private $MYSQL_DB = 'xss_example';
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

    public function saveMessage($username, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO messages (username, message) VALUES (:username, :message)");
        $stmt->execute(['username' => $username, 'message' => $message]);
    }

    public function getMessages() {
        $stmt = $this->pdo->query("SELECT * FROM messages");
        return $stmt->fetchAll();
    }
}

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username']) && isset($_GET['message'])) {
    $username = $_GET['username'];
    $message = $_GET['message'];
    $db->saveMessage($username, $message);
    // Kullanıcı girişini HTTP başlığına ekle
    header("X-User-Input-Username: " . $username);
    header("X-User-Input-Message: " . $message);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stored XSS Örneği</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="container-top">
    <h1>Dızmana'nın Stored XSS'li Yeri</h1>
    <form method="GET" action="">
        <div class="form">
            <label for="username" class="form-label">Kullanıcı Adı</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="form">
            <label for="message" class="form-label">Mesaj</label>
            <textarea id="message" name="message" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gönder</button>
    </form>

    <h2 class="messages">Mesajlar</h2>
    <ul class="list-group">
        <?php
        $messages = $db->getMessages();
        foreach ($messages as $message) {
            echo '<li class="list-group-item"><strong>' . htmlspecialchars($message->username, ENT_QUOTES, 'UTF-8') . ':</strong> ' . htmlspecialchars($message->message, ENT_QUOTES, 'UTF-8') . '</li>';
        }
        ?>
    </ul>

    <script>
        // Kullanıcı girişini HTTP başlıklarından almak
        function getHeader(name) {
            var headers = {};
            document.cookie.split(';').forEach(function(cookie) {
                var parts = cookie.split('=');
                headers[parts.shift().trim()] = decodeURI(parts.join('='));
            });
            return headers[name];
        }

        var username = getHeader('X-User-Input-Username');
        var message = getHeader('X-User-Input-Message');

        // DOM'a tehlikeli bir şekilde kullanıcı girişini enjekte etmek
        if (username && message) {
            document.body.innerHTML += "<div>Merhaba, " + username + "! Mesajınız: " + message + "</div>";
        }
    </script>
</body>
</html>
