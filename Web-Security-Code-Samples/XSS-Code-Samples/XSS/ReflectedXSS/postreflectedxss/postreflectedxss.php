<!DOCTYPE html>
<html>
<head>
    <title>Reflected XSS Örneği (POST)</title>
</head>
<body>
    <h1>Arama Sayfası</h1>
    <form method="POST" action="">
        <label for="query">Arama:</label>
        <input type="text" id="query" name="query">
        <input type="submit" value="Ara">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
        $query = $_POST['query'];
        echo "<p>Arama Sonucu: " . $query . "</p>";
    }
    ?>
</body>
</html>
