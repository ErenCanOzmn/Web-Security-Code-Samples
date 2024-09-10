<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedi Sorgulama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script>
        function getParameterByName(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, '\\$&');
            let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
            let results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        function displayUserInput() {
            const userInput = getParameterByName('catName');
            if (userInput) {
                document.getElementById('userInput').innerHTML = "Aranan kedi adı: " + userInput;
            }
        }
    </script>
</head>
<body onload="displayUserInput()">
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Kedi Sorgulama</h1>
                </div>
                <div class="col-md-6 text-end">
                    <nav>
                        <ul class="nav">
                        <li class="nav-item"><a href="../anasayfa/anasayfa.html" class="nav-link">Ana Sayfa</a></li>
                            <li class="nav-item"><a href="../search/search.php" class="nav-link">Doktor Arama</a></li>
                            <li class="nav-item"><a href="../ticket/ticket.php" class="nav-link">Şikayet</a></li>
                            <li class="nav-item"><a href="../hospitals/hospital.php" class="nav-link">Hastane Sorgulama</a></li>
                            <li class="nav-item"><a href="../cats/cats.php" class="nav-link">Kedi Sorgulama</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Kedi Sorgulama Formu</h2>
                <form method="get" action="cats.php">
                    <div class="mb-3">
                        <label for="catName" class="form-label">Kedi Adı</label>
                        <input type="text" class="form-control" id="catName" name="catName" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ara</button>
                </form>
                <div id="userInput" class="mt-3"></div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Sonuç</h2>
                <div id="output">
                    <?php
                    if (isset($_GET['catName'])) {
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "hospital";

                        // Veritabanı bağlantısı oluştur
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Bağlantıyı kontrol et
                        if ($conn->connect_error) {
                            die("Bağlantı hatası: " . $conn->connect_error);
                        }

                        $catName = $conn->real_escape_string($_GET['catName']);

                        $sql = "SELECT * FROM cats WHERE name LIKE '%$catName%'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<div class='cat'>";
                                echo "<h5>" . htmlspecialchars($row["name"]) . "</h5>";
                                echo "<p>Tür: " . htmlspecialchars($row["breed"]) . "</p>";
                                echo "<p>Yaş: " . htmlspecialchars($row["age"]) . "</p>";
                                echo "<p>Sahibi: " . htmlspecialchars($row["owner"]) . "</p>";
                                echo "</div>";
                            }
                        } else {
                            echo "Bu isimde bir kedi bulunmamaktadır.";
                        }

                        $conn->close();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
