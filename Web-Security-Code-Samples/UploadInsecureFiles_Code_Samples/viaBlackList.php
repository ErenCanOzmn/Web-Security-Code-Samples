<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dosya Yükleme Zafiyeti</title>
    <style>
        * {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            padding: 0;
            margin: 0;
        }

        body {
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            background: url(bg.jpeg);
            background-size: 220vh;
            background-position: center;
            text-align: center;
        }

        .upload-container {
            position: absolute;
            left: 36.5%;
            top: 32%;
            padding: 50px;
            padding-left: 120px;
            padding-right: 120px;
            color: whitesmoke;
            border-radius: 10px;
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.5);
            z-index: 2;
            background: transparent;
            backdrop-filter: blur(30px);
            border: solid #fcfcfc;
            text-align: center;
        }

        .upload-container ul {
            list-style-type: none;
            padding: 0;
        }

        .upload-container ul li a {
            text-decoration: none;
            color: white;
        }

        .upload-container h2 {
            color: white;
            padding-top: 15px;
            margin-top: 0;
        }

        .upload-container input[type="file"] {
            margin: 10px 0;
        }

        .upload-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .upload-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h2>Dosya Yükleme Formu</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="file">Dosya seç:</label>
            <input type="file" name="file" id="file">
            <input type="submit" value="Yükle" name="submit">
        </form>

        <?php
        if (isset($_POST["submit"])) {
            $target_dir = "uploads/";
            // uploads dizini yoksa oluştur
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $message = "";

            // uploads/allowed_types.txt dosyasından kabul edilen dosya türlerini oku
            $allowedTypesFile = $target_dir . 'allowed_types.txt';
            $allowedTypes = file($allowedTypesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Content-Type kontrolü
            $fileType = $_FILES["file"]["type"];

            if (!in_array($fileType, $allowedTypes)) {
                $message = "Üzgünüz, sadece izin verilen dosya türlerine izin verilmektedir.";
                $uploadOk = 0;
            }

            // Eğer her şey yolundaysa dosyayı yükle
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $message = "Dosyanız " . htmlspecialchars(basename($_FILES["file"]["name"])) . " başarıyla yüklendi.";
                    $message_class = "success";
                } else {
                    $message = "Üzgünüz, dosyanızı yüklerken bir hata oluştu.";
                    $message_class = "error";
                }
            } else {
                $message_class = "error";
            }

            echo "<div class='message $message_class'>$message</div>";
        }
        ?>
    </div>
</body>
</html>
