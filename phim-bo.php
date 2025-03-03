<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Danh sách Phim Bộ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container"><br><br><br><br><br>
        <h2>PHIM BỘ MỚI CẬP NHẬT</h2><br>

        <?php
        $start_time = microtime(true);
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 30; // Hiển thị 30 phim mỗi trang

        // Lấy tham số lọc từ form (nếu có)
        $sort_field = isset($_GET['sort_field']) && !empty($_GET['sort_field']) ? $_GET['sort_field'] : '';
        $sort_type = 'desc'; // Mặc định giảm dần

        // Xây dựng URL API
        $api_url = "https://phimapi.com/v1/api/danh-sach/phim-bo?page={$page}&limit={$limit}";
        if ($sort_field) $api_url .= "&sort_field={$sort_field}&sort_type={$sort_type}";
        error_log("API URL (phim-bo.php): " . $api_url);

        // Gọi API
        $data = fetch_api($api_url);
        // Kiểm tra dữ liệu trả về từ API
        if ($data && isset($data['status']) && $data['status'] === 'success' && isset($data['data']['items']) && !empty($data['data']['items'])) {
            $movies = $data['data']['items'];

            echo '<div class="movie-grid">';
            foreach ($movies as $movie) {
                $title = htmlspecialchars($movie['name'] ?? 'Không có tiêu đề');
                $slug = htmlspecialchars($movie['slug'] ?? '');
                $thumbnail = !empty($movie['thumb_url']) ? 'https://phimimg.com/' . ltrim($movie['thumb_url'], '/') : 'https://via.placeholder.com/200x300?text=No+Image';
                $year = htmlspecialchars($movie['year'] ?? 'N/A');
                $episode = isset($movie['episode_current']) ? $movie['episode_current'] : 'Tập N/A'; // Thêm trường episode nếu có
                // Kiểm tra và thay 'series' thành 'Phim Bộ'
                $type = $movie['type'] ?? 'Phim Bộ';
                if ($type === 'series') {
                    $type = 'Phim Bộ';
                }
                $modified_time = isset($movie['modified']['time']) ? date('Y-m-d', strtotime($movie['modified']['time'])) : 'N/A';

                $fallback_thumbnail = 'https://via.placeholder.com/200x300?text=Error';
                echo "
                <div class='movie-item'>
                    <a href='phim.php?slug={$slug}' class='movie-link'>
                        <img src='{$thumbnail}' alt='{$title}' onerror=\"this.onerror=null; this.src='{$fallback_thumbnail}'; console.log('Lỗi tải ảnh (phim-bo.php): {$thumbnail}');\">
                        <span class='episode-label'>{$episode}</span>
                        <div class='movie-info'>
                            <h3>{$title}</h3>
                            <p>Loại: {$type}</p>
                            <p>Cập nhật: {$modified_time}</p>
                        </div>
                    </a>
                </div>
            ";
            }
            echo '</div>';

            // Xử lý phân trang
            $total_items = isset($data['data']['params']['pagination']['totalItems']) ? (int)$data['data']['params']['pagination']['totalItems'] : count($movies);
            $total_pages = isset($data['data']['params']['pagination']['totalItemsPerPage']) 
                ? ceil($total_items / $data['data']['params']['pagination']['totalItemsPerPage']) 
                : ceil($total_items / $limit);

            echo "<p>Tổng phim: $total_items | Trang hiện tại: $page | Tổng trang: $total_pages</p>";
            error_log("Phân trang (phim-bo.php): totalItems=$total_items, totalPages=$total_pages, currentPage=$page, itemsCount=" . count($movies));

            // Hiển thị liên kết phân trang
            if ($total_pages > 1) {
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo "<a href='phim-bo.php?page=" . ($page - 1) . "&sort_field={$sort_field}' class='page-link'>Trang trước</a>";
                } else {
                    echo "<span class='disabled'>Trang trước</span>";
                }
                echo " <span>Trang $page / $total_pages</span> ";
                if ($page < $total_pages) {
                    echo "<a href='phim-bo.php?page=" . ($page + 1) . "&sort_field={$sort_field}' class='page-link'>Trang sau</a>";
                } else {
                    echo "<span class='disabled'>Trang sau</span>";
                }
                echo '</div>';
            }
        } else {
            echo '<p>Không thể tải danh sách phim bộ. Vui lòng kiểm tra kết nối hoặc liên hệ admin.</p>';
            error_log("Lỗi API tại phim-bo.php: " . json_encode($data));
        }

        $end_time = microtime(true);
        error_log("Thời gian xử lý phim-bo.php: " . ($end_time - $start_time) . " giây");
        ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>