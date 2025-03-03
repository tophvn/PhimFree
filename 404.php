<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Trang không tìm thấy (404)</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1a1a1a;
            color: #fff;
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #000;
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #333;
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo a {
            font-size: 24px;
            font-weight: bold;
            color: #e50914;
            text-decoration: none;
            transition: color 0.3s;
        }

        .logo a:hover {
            color: #ff0a1a;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
            padding: 8px 12px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #e50914;
            color: #fff;
            border-radius: 4px;
        }

        .banner {
            width: 100%;
            height: 300px;
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.2)), url('https://via.placeholder.com/1200x300?text=Banner+404');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            padding: 0 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .banner-content {
            max-width: 600px;
            text-align: center;
        }

        .banner-content h1 {
            font-size: 48px;
            margin-bottom: 10px;
            color: #e50914;
        }

        .banner-content p {
            font-size: 18px;
            color: #ccc;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #e50914;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #f40612;
        }

        .error-404 {
            text-align: center;
            padding: 50px 20px;
            background: #2d2d2d;
            border-radius: 8px;
        }

        .error-404 h2 {
            font-size: 120px;
            color: #e50914;
            margin-bottom: 20px;
        }

        .error-404 p {
            font-size: 18px;
            color: #bbb;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="error-404">
            <h2>404</h2>
            <p>Xin lỗi, chúng tôi không thể tìm thấy trang bạn yêu cầu.</p>
            <p>Có thể trang này đã bị xóa, đổi tên, hoặc không tồn tại.</p>
            <a href="index" class="btn">Quay Lại Trang Chủ</a>
        </div>
    </div>
</body>
</html>