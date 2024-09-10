<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şikayet Bölümü</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Şikayet Bölümü</h1>
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
                <h2>Şikayet Formu</h2>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $complaint = $_POST['complaint'];

                    $sql = "INSERT INTO complaints (name, email, complaint) VALUES ('$name', '$email', '$complaint')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Şikayet başarıyla kaydedildi.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Hata: " . $sql . "<br>" . $conn->error . "</div>";
                    }

                    $conn->close();
                }
                ?>
                <form method="post" action="ticket.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Adınız</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-posta</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="complaint" class="form-label">Şikayetiniz</label>
                        <textarea class="form-control" id="complaint" name="complaint" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Şikayetler</h2>
                <div id="complaints">
                    <?php
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

                    $sql = "SELECT * FROM complaints ORDER BY created_at DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='complaint'>";
                            echo "<h5>" . ($row["name"]) . "</h5>";
                            echo "<p>" . ($row["complaint"]) . "</p>";
                            echo "<small>" . $row["created_at"] . "</small>";
                            echo "</div>";
                        }
                    } else {
                        echo "Henüz bir şikayet bulunmamaktadır.";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
