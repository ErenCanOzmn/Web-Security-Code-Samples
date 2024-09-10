<!DOCTYPE html>
<html>
<head>
    <title>Reflected XSS Örneği</title>
</head>
<body>
    <h1>Arama Sayfası</h1>
    <form method="GET" action="">
        <label for="query">Arama:</label>
        <input type="text" id="query" name="query">
        <input type="submit" value="Ara">
    </form>

    <?php
    if (isset($_GET['query'])) {
        $query = $_GET['query'];
        echo "<p>Arama Sonucu: " . $query . "</p>";
    }
    ?>
</body>
</html>
