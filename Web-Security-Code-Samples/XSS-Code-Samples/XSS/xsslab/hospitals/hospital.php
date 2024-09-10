<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hastane Sorgulama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Hastane Sorgulama</h1>
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
                <h2>Hastane Sorgulama Formu</h2>
                <form method="post" action="hospital.php">
                    <div class="mb-3">
                        <label for="city" class="form-label">Şehir</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ara</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Hastaneler</h2>
                <div id="hospitals">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $city = $_POST['city'];

                        // Özel karakterlerin kontrolü
                        if (strpos($city, '<') !== false || strpos($city, '>') !== false || strpos($city, '&') !== false) {
                            $ip_address = $_SERVER['REMOTE_ADDR'];
                            $user_agent = $_SERVER['HTTP_USER_AGENT'];
                            echo "<div class='alert alert-danger'>Kendini çok zeki sandın galiba :) Şikayet edileceksin! \n\nIP adresin: $ip_address, Kullanıcı Agentin: $user_agent Mahkemede görüşürüz</div>";
                        } else {
                            $servername = "localhost";
                            $username = "root2";
                            $password = "123";
                            $dbname = "hospital";

                            // Veritabanı bağlantısı oluştur
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Bağlantıyı kontrol et
                            if ($conn->connect_error) {
                                die("Bağlantı hatası: " . $conn->connect_error);
                            }

                            $sql = "SELECT * FROM hospitals WHERE city = '$city'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<div class='hospital'>";
                                    echo "<h5>" . $row["name"] . "</h5>";
                                    echo "<p>Adres: " . $row["address"] . "</p>";
                                    echo "<p>Telefon: " . $row["phone"] . "</p>";
                                    echo "</div>";
                                }
                            } else {
                                echo "Bu şehirde bir hastane bulunmamaktadır.";
                            }

                            $conn->close();
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
