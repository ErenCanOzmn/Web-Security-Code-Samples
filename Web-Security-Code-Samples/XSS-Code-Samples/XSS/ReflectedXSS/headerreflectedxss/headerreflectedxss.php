<!DOCTYPE html>
<html>
<head>
    <title>Reflected XSS Örneği (Header)</title>
</head>
<body>
    <h1>Hoş Geldiniz</h1>

    <?php
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        echo "<p>Tarayıcı Bilgisi: " . $userAgent . "</p>";
    }
    ?>
</body>
</html>
