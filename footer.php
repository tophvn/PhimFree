<?php
// Khởi tạo hoặc tăng lượt truy cập
$counter_file = 'counter.txt';
$visits = 0;

if (file_exists($counter_file)) {
    $visits = (int)file_get_contents($counter_file);
}
$visits++;
file_put_contents($counter_file, $visits);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* CSS cho Footer */
        .footer {
            background-color: #1a1a1a;
            color: #fff;
            padding: 40px 20px;
            margin-top: 20px;
            border-top: 2px solid #e50914;
            text-align: center;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
        }

        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #e50914;
            text-transform: uppercase;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #e50914;
        }

        .social-links a {
            color: #fff;
            font-size: 20px;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .social-links a:hover {
            color: #e50914;
        }

        .footer-bottom {
            margin-top: 20px;
            font-size: 14px;
            color: #999;
            border-top: 1px solid #333;
            padding-top: 10px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .visit-counter {
            color: #e50914;
            font-weight: bold;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .footer-section {
                margin-bottom: 20px;
            }

            .social-links a {
                margin: 0 5px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .footer-section h3 {
                font-size: 16px;
            }

            .footer-section ul li {
                font-size: 14px;
            }

            .social-links a {
                font-size: 18px;
            }

            .footer-bottom {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Về Chúng Tôi</h3>
                <ul>
                    <li><a href="gioi-thieu.php">Giới thiệu</a></li>
                    <li><a href="lien-he.php">Liên hệ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Hỗ Trợ</h3>
                <ul>
                    <li><a href="dieu-khoan-su-dung.php">Điều khoản sử dụng</a></li>
                    <li><a href="chinh-sach-bao-mat.php">Chính sách bảo mật</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Kết Nối Với Chúng Tôi</h3>
                <div class="social-links">
                    <a href="https://www.facebook.com/tophvn" target="_blank">Facebook</a>
                    <a href="https://www.youtube.com/@tophhai" target="_blank">Youtube</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Phimfree. Tất cả quyền được bảo lưu.</p>
            <p>Tổng lượt truy cập: <span class="visit-counter"><?php echo number_format($visits); ?></span></p>
        </div>
    </footer>
</body>
</html>