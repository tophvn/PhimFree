<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Danh sách phim theo thể loại</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Danh sách phim theo thể loại</h1>

        <?php
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if (empty($category)) {
            echo '<p>Vui lòng chọn một thể loại từ dropdown trong header.</p>';
        } else {
            $api_url = "https://ophim1.com/danh-sach/phim-moi-cap-nhat?page={$page}";
            $data = fetch_api($api_url);

            if ($data && isset($data['items'])) {
                echo '<div class="movie-container">';
                $found_count = 0;
                foreach ($data['items'] as $movie) {
                    if (isset($movie['category']) && in_array($category, array_column($movie['category'], 'name'))) {
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

                $total_items = $data['pagination']['totalItems'] ?? 0;
                $items_per_page = $data['pagination']['totalItemsPerPage'] ?? 24;
                $total_pages = ceil($total_items / $items_per_page);
                echo '<div class="pagination">';
                if ($page > 1) echo "<a href='?page=" . ($page - 1) . "&category=" . urlencode($category) . "'>Trang trước</a>";
                echo " <span>Trang $page / $total_pages (Tìm thấy $found_count phim)</span> ";
                if ($page < $total_pages) echo "<a href='?page=" . ($page + 1) . "&category=" . urlencode($category) . "'>Trang sau</a>";
                echo '</div>';

                if ($found_count == 0) {
                    echo '<p>Không tìm thấy phim cho thể loại "' . htmlspecialchars($category) . '". Vui lòng thử thể loại khác.</p>';
                }
            } else {
                echo '<p>Không thể tải danh sách phim. Vui lòng kiểm tra kết nối.</p>';
                error_log("Lỗi tải dữ liệu cho thể loại $category: " . ($data ? 'Không có items' : 'API lỗi'));
            }
        }
        ?>
    </div>
</body>
</html>