<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Liên hệ</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .content {
            max-width: 1200px;
            margin: 80px auto 20px;
            padding: 20px;
            background-color: #222;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            color: #fff;
            line-height: 1.6;
        }

        .content h1 {
            font-size: 2em;
            color: #e50914;
            margin-bottom: 20px;
            text-align: center;
        }

        .content p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .contact-info {
            margin-top: 20px;
            text-align: left;
        }

        .contact-info p {
            margin: 5px 0;
        }

        .contact-form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            width: 100%;
        }

        .contact-form button {
            padding: 10px;
            background-color: #e50914;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .contact-form button:hover {
            background-color: #f40612;
        }

        @media (max-width: 768px) {
            .content {
                margin: 70px 10px 20px;
                padding: 15px;
            }

            .content h1 {
                font-size: 1.5em;
            }

            .content p {
                font-size: 14px;
            }

            .contact-form {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .content {
                margin: 60px 5px 10px;
                padding: 10px;
            }

            .content h1 {
                font-size: 1.3em;
            }

            .content p {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="content">
        <br><h1>Liên hệ với chúng tôi</h1>
        <p>Nếu bạn có bất kỳ câu hỏi nào hoặc cần hỗ trợ, đừng ngần ngại liên hệ với chúng tôi. Phimfree luôn sẵn sàng lắng nghe và phục vụ bạn!</p>
        <div class="contact-info">
            <p><strong>Email:</strong> phimfree17@gmail.com</p>
        </div>
        <div class="contact-form">
            <input type="text" placeholder="Họ và tên" required>
            <input type="email" placeholder="Email" required>
            <textarea placeholder="Lời nhắn" rows="5" required></textarea>
            <button type="submit">Gửi liên hệ</button>
        </div>
    </div>

    <?php include 'Footer.php'; ?>
</body>
</html>