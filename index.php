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

    <div class="container"><br><br><br><br><br>
        <h2>PHIM MỚI CẬP NHẬT</h2><br>

        <?php
        // Đo thời gian xử lý
        $start_time = microtime(true);

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $films_per_page = 24; // Số phim hiển thị trên mỗi trang
        $items_per_api_page = 10; // Giả định API trả về 10 phim mỗi trang
        $pages_to_fetch = ceil($films_per_page / $items_per_api_page); // Số trang API cần gọi

        $all_movies = [];
        for ($i = 0; $i < $pages_to_fetch; $i++) {
            $api_page = ($page - 1) * $pages_to_fetch + $i + 1; // Tính số trang API
            // Sử dụng API V2 để lấy dữ liệu đầy đủ hơn
            $api_url = "https://phimapi.com/danh-sach/phim-moi-cap-nhat-v2?page={$api_page}";
            $data = fetch_api($api_url);
            error_log("Dữ liệu API thô (index.php) - Trang {$api_page}: " . json_encode($data)); // Ghi log dữ liệu thô

            if ($data && isset($data['items'])) {
                $all_movies = array_merge($all_movies, $data['items']);
            } else {
                error_log("Lỗi API tại trang {$api_page}: " . ($data === false ? 'Không kết nối được' : 'Dữ liệu không hợp lệ'));
                break;
            }
        }

        if (!empty($all_movies)) {
            echo '<div class="movie-grid">';
            $all_movies = array_slice($all_movies, 0, $films_per_page);

            foreach ($all_movies as $movie) {
                $title = htmlspecialchars($movie['name']);
                $slug = $movie['slug'];
                $thumbnail = fix_image_url($movie['thumb_url']);
                $type = $movie['type'] ?? 'Mới';
                $modified_time = date('Y-m-d', strtotime($movie['modified']['time'] ?? 'N/A'));

                // Kiểm tra episode_current từ API danh sách
                $episode_current = $movie['episode_current'] ?? '';
                if (empty($episode_current)) {
                    // Nếu không có episode_current, gọi API chi tiết phim
                    $detail_url = "https://phimapi.com/phim/{$slug}";
                    $detail_data = fetch_api($detail_url);
                    if ($detail_data && isset($detail_data['movie']['episode_current'])) {
                        $episode_current = $detail_data['movie']['episode_current'];
                    }
                }

                // Xử lý số tập dựa trên loại phim
                if (in_array($type, ['series', 'tvshows']) && !empty($episode_current)) {
                    $episode = $episode_current; // Hiển thị tập hiện tại cho phim bộ
                } elseif ($type === 'single') {
                    $episode = 'Full'; // Hiển thị "Full" cho phim lẻ
                } else {
                    $episode = 'Mới'; // Trường hợp không xác định
                }

                // Ghi log để kiểm tra giá trị thực tế
                error_log("Movie: {$title}, Type: {$type}, Episode: " . ($episode_current ?: 'Không có episode_current'));

                $fallback_thumbnail = 'https://via.placeholder.com/200x300?text=Error';
                echo "
                    <div class='movie-item'>
                        <a href='phim.php?slug={$slug}' class='movie-link'>
                            <img src='{$thumbnail}' alt='{$title}' onerror=\"this.onerror=null; this.src='{$fallback_thumbnail}'; console.log('Lỗi tải ảnh (index.php): {$thumbnail}');\">
                            <span class='episode-label'>{$episode}</span>
                            <div class='movie-info'>
                                <h3>{$title}</h3>
                                <p>Cập nhật: {$modified_time}</p>
                            </div>
                        </a>
                    </div>
                ";
            }
            echo '</div>';

            // Phân trang
            $total_items = $data['pagination']['totalItems'] ?? count($all_movies);
            $total_pages = ceil($total_items / $films_per_page);
            echo '<div class="pagination">';
            if ($page > 1) {
                echo "<a href='?page=" . ($page - 1) . "' class='page-link'>Trang trước</a>";
            }
            echo "<span>Trang $page / $total_pages</span>";
            if ($page < $total_pages) {
                echo "<a href='?page=" . ($page + 1) . "' class='page-link'>Trang sau</a>";
            }
            echo '</div>';
        } else {
            echo '<p>Không thể tải danh sách phim. Vui lòng kiểm tra kết nối hoặc liên hệ admin.</p>';
            echo '<p>Lỗi API: Kiểm tra log server để biết chi tiết.</p>';
        }

        $end_time = microtime(true);
        $execution_time = $end_time - $start_time;
        error_log("Thời gian xử lý index.php: " . $execution_time . " giây");
        ?>
    </div>
</body>
</html>