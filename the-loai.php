<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Thể loại <?php echo htmlspecialchars($category_name ?? $_GET['slug'] ?? ''); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- <div class="banner">
        <div class="banner-content">
            <h1>Thể loại: <?php echo htmlspecialchars($category_name ?? $_GET['slug'] ?? 'Không xác định'); ?></h1>
            <p>Khám phá những bộ phim thuộc thể loại này!</p>
            <a href="#" class="btn">Xem ngay</a>
        </div>
    </div> -->

    <div class="container"><br><br><br><br><br>
        <!-- <h2>Danh sách phim thể loại <?php echo htmlspecialchars($category_name ?? $_GET['slug'] ?? ''); ?></h2> -->

        <?php
        // Đo thời gian xử lý
        $start_time = microtime(true);

        // Lấy slug thể loại từ URL và cố định nó
        $original_slug = isset($_GET['slug']) ? $_GET['slug'] : '';
        if (empty($original_slug)) {
            die('<p>Không tìm thấy thể loại. Vui lòng chọn thể loại từ menu.</p>');
        }

        // Ánh xạ slug sang name dựa trên danh sách bạn cung cấp
        $category_mapping = [
            'hanh-dong' => 'Hành Động',
            'tinh-cam' => 'Tình Cảm',
            'hai-huoc' => 'Hài Hước',
            'co-trang' => 'Cổ Trang',
            'tam-ly' => 'Tâm Lý',
            'hinh-su' => 'Hình Sự',
            'chien-tranh' => 'Chiến Tranh',
            'the-thao' => 'Thể Thao',
            'vo-thuat' => 'Võ Thuật',
            'vien-tuong' => 'Viễn Tưởng',
            'phieu-luu' => 'Phiêu Lưu',
            'khoa-hoc' => 'Khoa Học',
            'kinh-di' => 'Kinh Dị',
            'am-nhac' => 'Âm Nhạc',
            'than-thoai' => 'Thần Thoại',
            'tai-lieu' => 'Tài Liệu',
            'gia-dinh' => 'Gia Đình',
            'chinh-kich' => 'Chính kịch',
            'bi-an' => 'Bí ẩn',
            'hoc-duong' => 'Học Đường',
            'kinh-dien' => 'Kinh Điển',
            'phim-18' => 'Phim 18+'
        ];
        $category_name = $category_mapping[$original_slug] ?? $original_slug; // Sử dụng slug ban đầu

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $films_per_page = 24; // Số phim hiển thị trên mỗi trang
        $limit = $films_per_page; // Giới hạn kết quả từ API

        // Các tham số tùy chọn
        $sort_field = 'modified.time';
        $sort_type = 'desc';
        $sort_lang = '';
        $country = '';
        $year = '';

        // Xây dựng URL API cho thể loại với slug ban đầu
        $api_url = "https://phimapi.com/v1/api/the-loai/{$original_slug}?page={$page}&limit={$limit}";
        if ($sort_field) $api_url .= "&sort_field={$sort_field}";
        if ($sort_type) $api_url .= "&sort_type={$sort_type}";
        if ($sort_lang) $api_url .= "&sort_lang={$sort_lang}";
        if ($country) $api_url .= "&country={$country}";
        if ($year) $api_url .= "&year={$year}";

        // Gọi API và debug phản hồi
        $data = fetch_api($api_url);
        error_log("API Response (the-loai.php, page $page, slug $original_slug): " . json_encode($data));

        $all_movies = [];

        if ($data && isset($data['data']['items'])) {
            $all_movies = $data['data']['items'];
            $cdn_image_domain = $data['data']['APP_DOMAIN_CDN_IMAGE'] ?? 'https://phimimg.com'; // Lấy domain CDN từ API

            echo '<div class="movie-grid">';
            foreach ($all_movies as $movie) {
                $title = htmlspecialchars($movie['name']);
                $slug = $movie['slug'];
                $thumbnail_raw = $movie['thumb_url'] ?? '';
                $thumbnail = !empty($thumbnail_raw) ? $cdn_image_domain . '/' . ltrim($thumbnail_raw, '/') : 'https://via.placeholder.com/200x300?text=No+Image';
                $year = $movie['year'] ?? 'N/A';
                $episode = isset($movie['episode_current']) ? $movie['episode_current'] : 'N/A'; // Thêm trường episode nếu có
                // Kiểm tra và thay các giá trị type
                $type = $movie['type'] ?? 'N/A';
                if ($type === 'series') {
                    $type = 'Phim Bộ';
                } elseif ($type === 'hoathinh') {
                    $type = 'Hoạt Hình';
                } elseif ($type === 'single') {
                    $type = 'Phim Lẻ';
                }
                $modified_time = isset($movie['modified']['time']) ? date('Y-m-d', strtotime($movie['modified']['time'])) : 'N/A';

                error_log("Thumbnail URL (the-loai.php): " . $thumbnail);

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

            // Phân trang
            $total_items = isset($data['data']['pagination']['totalItems']) 
                ? (int)$data['data']['pagination']['totalItems'] 
                : (isset($data['data']['params']['pagination']['totalItems']) ? (int)$data['data']['params']['pagination']['totalItems'] : count($all_movies));
            $total_pages = isset($data['data']['pagination']['totalPages']) 
                ? (int)$data['data']['pagination']['totalPages'] 
                : (isset($data['data']['params']['pagination']['totalPages']) ? (int)$data['data']['params']['pagination']['totalPages'] : ceil($total_items / $films_per_page));
            
            // Debug phân trang
            error_log("Pagination Debug - total_items: $total_items, total_pages: $total_pages, page: $page, slug: $original_slug");

            echo '<div class="pagination">';
            if ($page > 1) {
                echo "<a href='the-loai.php?slug={$original_slug}&page=" . ($page - 1) . "' class='page-link'>Trang trước</a>";
            }
            echo " <span>Trang $page / $total_pages</span> ";
            if ($page < $total_pages) {
                echo "<a href='the-loai.php?slug={$original_slug}&page=" . ($page + 1) . "' class='page-link'>Trang sau</a>";
            }
            echo '</div>';
        } else {
            echo '<p>Không thể tải danh sách phim cho thể loại này. Vui lòng kiểm tra lại.</p>';
            if (!$data) {
                echo '<p>Lỗi API: Kiểm tra log server để biết chi tiết.</p>';
                error_log("Lỗi API tại the-loai.php: " . ($data === false ? 'Không kết nối được' : 'Dữ liệu không hợp lệ: ' . json_encode($data)));
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