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

    <div class="container">
        <h1>Danh sách Phim Bộ</h1>
        <?php
        $start_time = microtime(true);
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 30; // Hiển thị 30 phim mỗi trang

        // Lấy tham số lọc từ form
        $sort_field = isset($_GET['sort_field']) && !empty($_GET['sort_field']) ? $_GET['sort_field'] : '';
        $sort_type = 'desc'; // Mặc định giảm dần
        $sort_lang = ''; // Có thể mở rộng với input nếu cần
        $category = ''; // Có thể mở rộng với dropdown
        $country = ''; // Có thể mở rộng với dropdown
        $year = ''; // Có thể mở rộng với input số

        // Xây dựng URL API
        $api_url = "https://phimapi.com/v1/api/danh-sach/phim-bo?page={$page}&limit={$limit}";
        if ($sort_field) $api_url .= "&sort_field={$sort_field}&sort_type={$sort_type}";
        error_log("API URL (phim-bo.php): " . $api_url);

        $data = fetch_api($api_url);

        if ($data && isset($data['data']['items']) && !empty($data['data']['items'])) {
            $movies = $data['data']['items'];

            echo '<div class="movie-container">';
            foreach ($movies as $movie) {
                $title = htmlspecialchars($movie['name'] ?? 'Không có tiêu đề');
                $slug = htmlspecialchars($movie['slug'] ?? '');
                $thumbnail = !empty($movie['thumb_url']) ? 'https://phimimg.com/' . ltrim($movie['thumb_url'], '/') : 'https://via.placeholder.com/200x300?text=No+Image';
                $year = htmlspecialchars($movie['year'] ?? 'N/A');

                $fallback_thumbnail = 'https://via.placeholder.com/200x300?text=Error';
                echo "
                    <div class='movie-card'>
                        <a href='phim.php?slug={$slug}'>
                            <img src='{$thumbnail}' alt='{$title}' onerror=\"this.src='{$fallback_thumbnail}'; console.log('Lỗi tải ảnh (phim-bo.php): {$thumbnail}');\">
                            <div class='info'>
                                <h3>{$title}</h3>
                                <p>Năm: {$year}</p>
                            </div>
                        </a>
                    </div>
                ";
            }
            echo '</div>';

            $total_items = isset($data['data']['pagination']['totalItems']) ? (int)$data['data']['pagination']['totalItems'] : count($movies);
            $total_pages = isset($data['data']['pagination']['totalPages']) ? (int)$data['data']['pagination']['totalPages'] : ceil($total_items / $limit);

            echo "<p>Tổng phim: $total_items | Trang hiện tại: $page | Tổng trang: $total_pages</p>";
            error_log("Phân trang (phim-bo.php): totalItems=$total_items, totalPages=$total_pages, currentPage=$page, itemsCount=" . count($movies));

            if ($total_pages > 1) {
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo "<a href='phim-bo.php?page=" . ($page - 1) . "&sort_field={$sort_field}'>Trang trước</a>";
                } else {
                    echo "<span class='disabled'>Trang trước</span>";
                }
                echo " <span>Trang $page / $total_pages</span> ";
                if ($page < $total_pages) {
                    echo "<a href='phim-bo.php?page=" . ($page + 1) . "&sort_field={$sort_field}'>Trang sau</a>";
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
</body>
</html>