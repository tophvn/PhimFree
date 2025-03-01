<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Xem phim online miễn phí</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="banner">
        <div class="banner-content">
            <h1>Phim Nổi Bật</h1>
            <p>Khám phá những bộ phim hay nhất đang chờ bạn!</p>
            <button class="btn">Xem ngay</button>
        </div>
    </div>

    <div class="container">
        <h1>Phim mới cập nhật</h1>

        <?php
        // Đo thời gian xử lý
        $start_time = microtime(true);

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $films_per_page = 24; // Số phim muốn hiển thị trên mỗi trang
        $items_per_api_page = 10; // Giả định API trả về 10 phim mỗi trang
        $pages_to_fetch = ceil($films_per_page / $items_per_api_page); // Số trang API cần gọi

        $all_movies = [];
        for ($i = 0; $i < $pages_to_fetch; $i++) {
            $api_page = ($page - 1) * $pages_to_fetch + $i + 1; // Tính số trang API tương ứng
            $api_url = "https://phimapi.com/danh-sach/phim-moi-cap-nhat?page={$api_page}";
            $data = fetch_api($api_url);

            if ($data && isset($data['items'])) {
                $all_movies = array_merge($all_movies, $data['items']);
            } else {
                error_log("Lỗi API tại trang {$api_page}: " . ($data === false ? 'Không kết nối được' : 'Dữ liệu không hợp lệ'));
                break;
            }
        }

        if (!empty($all_movies)) {
            echo '<div class="movie-container">';
            
            // Giới hạn số phim hiển thị đúng 24
            $all_movies = array_slice($all_movies, 0, $films_per_page);

            // Hiển thị danh sách phim với liên kết đến phim.php
            foreach ($all_movies as $movie) {
                $title = htmlspecialchars($movie['name']);
                $slug = $movie['slug'];
                $thumbnail = fix_image_url($movie['thumb_url']);
                $year = $movie['year'] ?? 'N/A';
                
                $fallback_thumbnail = 'https://via.placeholder.com/200x300?text=Error';
                echo "
                    <div class='movie-card'>
                        <a href='phim.php?slug={$slug}'>
                            <img src='{$thumbnail}' alt='{$title}' onerror=\"this.onerror=null; this.src='{$fallback_thumbnail}'; console.log('Lỗi tải ảnh (index.php): {$thumbnail}');\">
                            <div class='info'>
                                <h3>{$title}</h3>
                                <p>Năm: {$year}</p>
                            </div>
                        </a>
                    </div>
                ";
            }
            echo '</div>';

            // Phân trang
            $total_items = $data['pagination']['totalItems'] ?? count($all_movies); // Tổng số phim từ API
            $total_pages = ceil($total_items / $films_per_page); // Tổng số trang dựa trên số phim mong muốn
            echo '<div class="pagination">';
            if ($page > 1) {
                echo "<a href='?page=" . ($page - 1) . "'>Trang trước</a>";
            }
            echo " <span>Trang $page / $total_pages</span> ";
            if ($page < $total_pages) {
                echo "<a href='?page=" . ($page + 1) . "'>Trang sau</a>";
            }
            echo '</div>';
        } else {
            echo '<p>Không thể tải danh sách phim. Vui lòng kiểm tra kết nối hoặc liên hệ admin.</p>';
            echo '<p>Lỗi API: Kiểm tra log server để biết chi tiết.</p>';
        }

        // Đo thời gian hoàn thành
        $end_time = microtime(true);
        $execution_time = $end_time - $start_time;
        error_log("Thời gian xử lý index.php: " . $execution_time . " giây");
        ?>
    </div>
</body>
</html>