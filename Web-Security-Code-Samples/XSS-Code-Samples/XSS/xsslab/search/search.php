<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hastane Doktor Arama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Hastane Doktor Arama</h1>
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
        <div class="row justify-content-center">
            <div class="col-md-8 search-container">
                <form method="post" class="input-group mb-3">
                    <input type="text" name="searchTerm" class="form-control" placeholder="Doktor adı veya uzmanlık alanı">
                    <button class="btn btn-primary" type="submit">Ara</button>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 result-container">
                <h2>Doktor Listesi</h2>
                <div class="table-wrapper">
                    <table class="fl-table">
                        <thead>
                        <tr>
                            <th>İsim</th>
                            <th>Uzmanlık</th>
                            <th>Telefon</th>
                        </tr>
                        </thead>
                        <tbody id="result">
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $servername = "localhost";
                                $username = "root2"; // Veritabanı kullanıcı adı
                                $password = "123"; // Veritabanı şifresi
                                $dbname = "hospital";

                                // Veritabanı bağlantısı oluştur
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // Bağlantıyı kontrol et
                                if ($conn->connect_error) {
                                    die("Bağlantı hatası: " . $conn->connect_error);
                                }

                                $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';

                                if (!empty($searchTerm)) {
                                    // XSS açığı: Kullanıcıdan gelen girdiyi doğrudan ekrana yazdır
                                    echo "<p>Arama terimi: " . $searchTerm . "</p>";

                                    $sql = "SELECT * FROM doctors WHERE name LIKE '%$searchTerm%' OR specialty LIKE '%$searchTerm%'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["name"] . "</td>";
                                            echo "<td>" . $row["specialty"] . "</td>";
                                            echo "<td>" . $row["phone"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>0 sonuç bulundu</td></tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>Lütfen aramak istediğiniz terimi girin.</td></tr>";
                                }

                                $conn->close();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>