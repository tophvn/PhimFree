<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Tìm kiếm: <?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    

    <div class="container"><br><br><br><br><br>
        <h2>Kết quả tìm kiếm cho "<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>"</h2><br>

        <?php
        // Đo thời gian xử lý
        $start_time = microtime(true);

        // Lấy từ khóa từ URL
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        if (empty($keyword)) {
            die('<p>Vui lòng nhập từ khóa tìm kiếm.</p>');
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $films_per_page = 24; // Số phim hiển thị trên mỗi trang
        $limit = $films_per_page; // Giới hạn kết quả từ API

        // Các tham số tùy chọn
        $sort_field = 'modified.time';
        $sort_type = 'desc';
        $sort_lang = '';
        $category = '';
        $country = '';
        $year = '';

        // Xây dựng URL API tìm kiếm
        $api_url = "https://phimapi.com/v1/api/tim-kiem?keyword=" . urlencode($keyword) . "&page={$page}&limit={$limit}";
        if ($sort_field) $api_url .= "&sort_field={$sort_field}";
        if ($sort_type) $api_url .= "&sort_type={$sort_type}";
        if ($sort_lang) $api_url .= "&sort_lang={$sort_lang}";
        if ($category) $api_url .= "&category={$category}";
        if ($country) $api_url .= "&country={$country}";
        if ($year) $api_url .= "&year={$year}";

        $data = fetch_api($api_url);
        $all_movies = [];

        if ($data && isset($data['data']['items'])) {
            $all_movies = $data['data']['items'];
            $cdn_image_domain = $data['data']['APP_DOMAIN_CDN_IMAGE'] ?? 'https://phimimg.com'; // Lấy domain CDN từ API

            if (empty($all_movies)) {
                echo '<p>Không tìm thấy phim nào phù hợp với từ khóa "' . htmlspecialchars($keyword) . '".</p>';
            } else {
                echo '<div class="movie-grid">';
                foreach ($all_movies as $movie) {
                    $title = htmlspecialchars($movie['name']);
                    $slug = $movie['slug'];
                    $thumbnail_raw = $movie['thumb_url'] ?? '';
                    $thumbnail = !empty($thumbnail_raw) ? $cdn_image_domain . '/' . ltrim($thumbnail_raw, '/') : 'https://via.placeholder.com/200x300?text=No+Image';
                    $year = $movie['year'] ?? 'N/A';
                    $episode = isset($movie['episode_current']) ? $movie['episode_current'] : 'N/A'; // Thêm trường episode nếu có
                    $type = $movie['type'] ?? 'N/A'; // Loại phim
                    $modified_time = isset($movie['modified']['time']) ? date('Y-m-d', strtotime($movie['modified']['time'])) : 'N/A';

                    error_log("Thumbnail URL (tim-kiem.php): " . $thumbnail);

                    $fallback_thumbnail = 'https://via.placeholder.com/200x300?text=Error';
                    echo "
                <div class='movie-item'>
                    <a href='phim.php?slug={$slug}' class='movie-link'>
                        <img src='{$thumbnail}' alt='{$title}' onerror=\"this.onerror=null; this.src='{$fallback_thumbnail}'; console.log('Lỗi tải ảnh (phim-bo.php): {$thumbnail}');\">
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
                $total_items = $data['data']['pagination']['totalItems'] ?? count($all_movies);
                $total_pages = $data['data']['pagination']['totalPages'] ?? ceil($total_items / $films_per_page);
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo "<a href='tim-kiem.php?keyword=" . urlencode($keyword) . "&page=" . ($page - 1) . "' class='page-link'>Trang trước</a>";
                }
                echo " <span>Trang $page / $total_pages</span> ";
                if ($page < $total_pages) {
                    echo "<a href='tim-kiem.php?keyword=" . urlencode($keyword) . "&page=" . ($page + 1) . "' class='page-link'>Trang sau</a>";
                }
                echo '</div>';
            }
        } else {
            echo '<p>Không thể tải kết quả tìm kiếm. Vui lòng kiểm tra lại.</p>';
            if (!$data) {
                echo '<p>Lỗi API: Kiểm tra log server để biết chi tiết.</p>';
                error_log("Lỗi API tại tim-kiem.php: " . ($data === false ? 'Không kết nối được' : 'Dữ liệu không hợp lệ'));
            }
        }

        // Đo thời gian hoàn thành
        $end_time = microtime(true);
        $execution_time = $end_time - $start_time;
        error_log("Thời gian xử lý tim-kiem.php: " . $execution_time . " giây");
        ?>
    </div>
</body>
</html>