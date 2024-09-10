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

    <script>
        // PHP ile kullanıcı girişini almak
        <?php
        if (isset($_GET['userInput'])) {
            $userInput = $_GET['userInput'];
            echo "var userInput = " . json_encode($userInput) . ";";
        } else {
            echo "var userInput = '';";
        }
        ?>

        if (userInput) {
            document.getElementById('display').innerHTML = "Merhaba, " + userInput;
        }
    </script>
</body>
</html>
