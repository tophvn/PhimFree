<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Thể loại <?php echo htmlspecialchars($_GET['slug'] ?? ''); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- <div class="banner">
        <div class="banner-content">
            <h1>Thể loại: <?php echo htmlspecialchars($_GET['slug'] ?? 'Không xác định'); ?></h1>
            <p>Khám phá những bộ phim thuộc thể loại này!</p>
            <button class="btn">Xem ngay</button>
        </div>
    </div> -->

    <div class="container">
        <h1>Danh sách phim thể loại <?php echo htmlspecialchars($_GET['slug'] ?? ''); ?></h1>

        <?php
        // Đo thời gian xử lý
        $start_time = microtime(true);

        // Lấy slug thể loại từ URL
        $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
        if (empty($slug)) {
            die('<p>Không tìm thấy thể loại. Vui lòng chọn thể loại từ menu.</p>');
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $films_per_page = 24; // Số phim hiển thị trên mỗi trang
        $limit = $films_per_page; // Giới hạn kết quả từ API

        // Các tham số tùy chọn
        $sort_field = 'modified.time';
        $sort_type = 'desc';
        $sort_lang = '';
        $country = '';
        $year = '';

        // Xây dựng URL API cho thể loại
        $api_url = "https://phimapi.com/v1/api/the-loai/{$slug}?page={$page}&limit={$limit}";
        if ($sort_field) $api_url .= "&sort_field={$sort_field}";
        if ($sort_type) $api_url .= "&sort_type={$sort_type}";
        if ($sort_lang) $api_url .= "&sort_lang={$sort_lang}";
        if ($country) $api_url .= "&country={$country}";
        if ($year) $api_url .= "&year={$year}";

        $data = fetch_api($api_url);
        $all_movies = [];

        if ($data && isset($data['data']['items'])) {
            $all_movies = $data['data']['items'];
            $cdn_image_domain = $data['data']['APP_DOMAIN_CDN_IMAGE'] ?? 'https://phimimg.com'; // Lấy domain CDN từ API

            echo '<div class="movie-container">';
            foreach ($all_movies as $movie) {
                $title = htmlspecialchars($movie['name']);
                $slug = $movie['slug'];
                // Ghép domain CDN với thumb_url
                $thumbnail_raw = $movie['thumb_url'] ?? '';
                $thumbnail = !empty($thumbnail_raw) ? $cdn_image_domain . '/' . ltrim($thumbnail_raw, '/') : 'https://via.placeholder.com/200x300?text=No+Image';
                $year = $movie['year'] ?? 'N/A';
                
                // Debug URL ảnh
                error_log("Thumbnail URL (the-loai.php): " . $thumbnail);

                $fallback_thumbnail = 'https://via.placeholder.com/200x300?text=Error';
                echo "
                    <div class='movie-card'>
                        <a href='phim.php?slug={$slug}'>
                            <img src='{$thumbnail}' alt='{$title}' onerror=\"this.onerror=null; this.src='{$fallback_thumbnail}'; console.log('Lỗi tải ảnh (the-loai.php): {$thumbnail}');\">
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
            $total_items = $data['data']['pagination']['totalItems'] ?? count($all_movies);
            $total_pages = $data['data']['pagination']['totalPages'] ?? ceil($total_items / $films_per_page);
            echo '<div class="pagination">';
            if ($page > 1) {
                echo "<a href='the-loai.php?slug={$slug}&page=" . ($page - 1) . "'>Trang trước</a>";
            }
            echo " <span>Trang $page / $total_pages</span> ";
            if ($page < $total_pages) {
                echo "<a href='the-loai.php?slug={$slug}&page=" . ($page + 1) . "'>Trang sau</a>";
            }
            echo '</div>';
        } else {
            echo '<p>Không thể tải danh sách phim cho thể loại này. Vui lòng kiểm tra lại.</p>';
            if (!$data) {
                echo '<p>Lỗi API: Kiểm tra log server để biết chi tiết.</p>';
                error_log("Lỗi API tại the-loai.php: " . ($data === false ? 'Không kết nối được' : 'Dữ liệu không hợp lệ'));
            }
        }

        // Đo thời gian hoàn thành
        $end_time = microtime(true);
        $execution_time = $end_time - $start_time;
        error_log("Thời gian xử lý the-loai.php: " . $execution_time . " giây");
        ?>
    </div>
</body>
</html>