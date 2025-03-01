<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Danh sách TV Shows</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Danh sách TV Shows</h1>

        <?php
        $start_time = microtime(true);
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 30; // Hiển thị 30 phim mỗi trang
        $api_url = "https://phimapi.com/v1/api/danh-sach/tv-shows?page={$page}&limit={$limit}";
        
        error_log("API URL (tv-shows.php): " . $api_url);
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
                            <img src='{$thumbnail}' alt='{$title}' onerror=\"this.src='{$fallback_thumbnail}'; console.log('Lỗi tải ảnh (tv-shows.php): {$thumbnail}');\">
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
            error_log("Phân trang (tv-shows.php): totalItems=$total_items, totalPages=$total_pages, currentPage=$page, itemsCount=" . count($movies));

            if ($total_pages > 1) {
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo "<a href='tv-shows.php?page=" . ($page - 1) . "'>Trang trước</a>";
                } else {
                    echo "<span class='disabled'>Trang trước</span>";
                }
                echo " <span>Trang $page / $total_pages</span> ";
                if ($page < $total_pages) {
                    echo "<a href='tv-shows.php?page=" . ($page + 1) . "'>Trang sau</a>";
                } else {
                    echo "<span class='disabled'>Trang sau</span>";
                }
                echo '</div>';
            }
        } else {
            echo '<p>Không thể tải danh sách TV Shows. Vui lòng kiểm tra kết nối hoặc liên hệ admin.</p>';
            error_log("Lỗi API tại tv-shows.php: " . json_encode($data));
        }

        $end_time = microtime(true);
        error_log("Thời gian xử lý tv-shows.php: " . ($end_time - $start_time) . " giây");
        ?>
    </div>
</body>
</html>