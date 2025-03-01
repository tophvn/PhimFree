<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Sắp Chiếu</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Sắp Chiếu</h1>

        <?php
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $api_url = "https://ophim1.com/danh-sach/phim-moi-cap-nhat?page={$page}";
        $data = fetch_api($api_url);

        if ($data && isset($data['items'])) {
            echo '<div class="movie-container">';
            $found_count = 0; // Đếm số phim sắp chiếu tìm thấy
            $checked_count = 0; // Đếm số phim được kiểm tra

            foreach ($data['items'] as $movie) {
                $checked_count++;
                $isTrailer = false;
                if (isset($movie['status']) && $movie['status'] === 'trailer') {
                    $isTrailer = true;
                    error_log("Detected Trailer for {$movie['name']}: " . $movie['status']); // Debug
                } else {
                    error_log("No Trailer for {$movie['name']}, status: " . ($movie['status'] ?? 'N/A')); // Debug
                }

                if ($isTrailer) {
                    $found_count++;
                    $title = htmlspecialchars($movie['name']);
                    $slug = $movie['slug'];
                    $thumbnail = fix_image_url($movie['thumb_url']);
                    $year = $movie['year'] ?? 'N/A';
                    echo "
                        <div class='movie-card'>
                            <a href='chitietphim.php?slug={$slug}'>
                                <img src='{$thumbnail}' alt='{$title}' onerror=\"this.onerror=null; this.src='https://via.placeholder.com/200x300?text=Error';\">
                                <div class='info'>
                                    <h3>{$title}</h3>
                                    <p>Năm: {$year}</p>
                                </div>
                            </a>
                        </div>
                    ";
                }
            }
            echo '</div>';

            // Cập nhật tổng số trang từ API
            $total_items = $data['pagination']['totalItems'] ?? 0;
            $items_per_page = $data['pagination']['totalItemsPerPage'] ?? 24;
            $total_pages = ceil($total_items / $items_per_page);
            echo '<div class="pagination">';
            if ($page > 1) echo "<a href='?page=" . ($page - 1) . "'>Trang trước</a>";
            echo " <span>Trang $page / $total_pages (Kiểm tra $checked_count phim, Tìm thấy $found_count Sắp Chiếu)</span> ";
            if ($page < $total_pages) echo "<a href='?page=" . ($page + 1) . "'>Trang sau</a>";
            echo '</div>';

            if ($found_count == 0) {
                echo '<p>Không tìm thấy phim sắp chiếu trong trang này. Vui lòng kiểm tra các trang khác.</p>';
            }
        } else {
            echo '<p>Không thể tải danh sách phim. Vui lòng kiểm tra kết nối.</p>';
        }
        ?>
    </div>
</body>
</html>