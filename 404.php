<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Trang không tìm thấy (404)</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error-container {
            max-width: 1200px;
            margin: 80px auto 20px;
            padding: 20px;
            background-color: #222;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            color: #fff;
            text-align: center;
            line-height: 1.6;
        }

        .error-container h1 {
            font-size: 2em;
            color: #e50914;
            margin-bottom: 20px;
        }

        .error-container p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .error-container a {
            color: #e50914;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .error-container a:hover {
            color: #f40612;
        }

        @media (max-width: 768px) {
            .error-container {
                margin: 70px 10px 20px;
                padding: 15px;
            }

            .error-container h1 {
                font-size: 1.5em;
            }

            .error-container p {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .error-container {
                margin: 60px 5px 10px;
                padding: 10px;
            }

            .error-container h1 {
                font-size: 1.3em;
            }

            .error-container p {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="error-container">
        <h1>404 - Trang không tìm thấy</h1>
        <p>Rất tiếc, trang bạn yêu cầu không tồn tại hoặc đã bị xóa. Vui lòng kiểm tra lại URL hoặc trở về <a href="index.php">trang chủ</a>.</p>
        <p>Nếu cần hỗ trợ, hãy liên hệ với chúng tôi qua <a href="lien-he.php">liên hệ</a>.</p>
    </div>

    <?php include 'Footer.php'; ?>
</body>
</html>