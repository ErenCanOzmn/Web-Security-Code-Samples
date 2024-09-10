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
        // URL parametresinden kullanıcı girişini almak
        function getParameterByName(name) {
            name = name.replace(/[\[\]]/g, '\\$&');
            var url = window.location.href;
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
            var results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        var userInput = getParameterByName('userInput');

        if (userInput) {
            document.getElementById('display').innerHTML = "Merhaba, " + userInput;
        }
    </script>
</body>
</html>
