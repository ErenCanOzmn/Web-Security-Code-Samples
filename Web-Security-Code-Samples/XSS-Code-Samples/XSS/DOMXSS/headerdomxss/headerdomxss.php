<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DOM XSS Örneği</title>
</head>
<body>
    <h1>DOM XSS Örneği</h1>
    <form method="get" action="">
        <input type="text" name="userInput" placeholder="Adınızı girin">
        <button type="submit">Gönder</button>
    </form>
    <div id="display"></div>

    <?php
    if (isset($_GET['userInput'])) {
        $userInput = $_GET['userInput'];
        // Kullanıcı girdisini HTTP header'ına eklemek
        header("X-User-Input: " . $userInput);
    }
    ?>

    <script>
        // HTTP header'dan kullanıcı girdisini almak
        function getHeader(name) {
            var headers = new Headers(document.location.protocol + '//' + document.location.host + document.location.pathname);
            var value = headers.get(name);
            return value;
        }

        var userInput = getHeader('X-User-Input');

        // DOM'a tehlikeli bir şekilde kullanıcı girişini enjekte etmek
        if (userInput) {
            document.getElementById('display').innerHTML = "Merhaba, " + userInput;
        }
    </script>
</body>
</html>
