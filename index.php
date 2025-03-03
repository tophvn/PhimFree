<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Xem phim online miễn phí</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Banner trượt */
        .banner {
            width: 100%;
            height: 400px;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        .banner-slide {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
        }

        .banner-slide.active {
            opacity: 1;
        }

        .banner-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.7; /* Làm mờ ảnh để chữ nổi bật */
        }

        .banner-text {
            position: absolute;
            color: #fff;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            padding: 20px;
            background: rgba(0, 0, 0, 0.5); /* Nền mờ cho chữ */
            border-radius: 10px;
        }

        .banner-text h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .banner-buttons {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .banner-btn {
            width: 12px;
            height: 12px;
            background-color: #fff;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            opacity: 0.5;
            transition: opacity 0.3s;
        }

        .banner-btn.active {
            opacity: 1;
        }

        /* Thẻ nổi bật */
        .featured-tags {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .tag {
            background-color: #333;
            color: #fff;
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .tag:hover {
            background-color: #555;
        }

        /* Cải thiện giao diện phim */
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .movie-item {
            background-color: #222;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .movie-item:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.5);
        }

        .movie-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .movie-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: opacity 0.3s;
        }

        .movie-item:hover img {
            opacity: 0.8;
        }

        .episode-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #e50914;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            z-index: 2;
        }

        .movie-info {
            padding: 15px;
            text-align: center;
            background: linear-gradient(to bottom, #222, #1a1a1a);
        }

        .movie-info h3 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #e50914;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .movie-info p {
            font-size: 14px;
            margin: 0;
            color: #ddd;
        }

        /* Top Phim Xem Nhiều */
        .top-movies {
            margin-top: 30px;
            padding: 20px;
            background-color: #222;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .top-title {
            font-size: 22px;
            color: #e50914;
            margin-bottom: 15px;
            text-align: center;
            text-transform: uppercase;
        }

        .top-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .top-item {
            text-align: center;
            transition: transform 0.3s;
            position: relative;
        }

        .top-item:hover {
            transform: scale(1.05);
        }

        .top-item img {
            width: 100%;
            height: 225px;
            object-fit: cover;
            border-radius: 5px;
        }

        .top-item h4 {
            font-size: 16px;
            margin: 5px 0;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .top-item a {
            color: #e50914;
            text-decoration: none;
            transition: color 0.3s;
        }

        .top-item a:hover {
            color: #f40612;
        }

        .top-rank {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #e50914;
            color: #fff;
            padding: 5px 10px;
            border-radius: 50%;
            font-size: 14px;
            font-weight: bold;
            z-index: 2;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .banner {
                height: 250px;
            }

            .banner-text h1 {
                font-size: 1.8em;
            }

            .movie-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .movie-item img {
                height: 225px;
            }

            .featured-tags {
                flex-direction: column;
                align-items: center;
            }

            .tag {
                width: 80%;
                text-align: center;
            }

            .top-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .top-item img {
                height: 180px;
            }
        }

        @media (max-width: 480px) {
            .banner {
                height: 180px;
            }

            .banner-text h1 {
                font-size: 1.5em;
            }

            .movie-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .movie-item img {
                height: 180px;
            }

            .featured-tags {
                gap: 10px;
            }

            .tag {
                width: 90%;
            }

            .top-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }

            .top-item img {
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <!-- Banner trượt với ảnh tĩnh -->
        <div class="banner">
            <?php
            $banner_images = [
                'image/Banner1.jpg',
                'image/Banner2.jpg',
                'image/Banner3.jpg'
            ];
            $banner_titles = [
                '',
                '',
                ''
            ];
            for ($index = 0; $index < 3; $index++) {
                echo "<div class='banner-slide' style='background-image: url({$banner_images[$index]});' data-index='{$index}'>
                        
                      </div>";
            }
            ?>
            <div class="banner-buttons">
                <?php for ($i = 0; $i < 3; $i++) echo "<button class='banner-btn' data-index='{$i}'></button>"; ?>
            </div>
        </div>

        <script>
            let currentSlide = 0;
            const slides = document.querySelectorAll('.banner-slide');
            const buttons = document.querySelectorAll('.banner-btn');

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.remove('active');
                    buttons[i].classList.remove('active');
                    if (i === index) {
                        slide.classList.add('active');
                        buttons[i].classList.add('active');
                    }
                });
            }

            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    currentSlide = parseInt(button.getAttribute('data-index'));
                    showSlide(currentSlide);
                });
            });

            setInterval(() => {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }, 5000); // Tự động chuyển slide sau 5 giây
        </script>

        <!-- Thẻ nổi bật -->
        <div class="featured-tags">
            <a href="#" class="tag">Phim Hot</a>
            <a href="#" class="tag">Phim Mới</a>
            <a href="#" class="tag">Phim Lẻ</a>
            <a href="#" class="tag">Phim Bộ</a>
        </div>

        <h2 class="category-title">PHIM MỚI CẬP NHẬT</h2>
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
            $api_url = "https://phimapi.com/danh-sach/phim-moi-cap-nhat-v2?page={$api_page}";
            $data = fetch_api($api_url);
            error_log("Dữ liệu API thô (index.php) - Trang {$api_page}: " . json_encode($data));

            if ($data && isset($data['items'])) {
                $all_movies = array_merge($all_movies, $data['items']);
            } else {
                error_log("Lỗi API tại trang {$api_page}: " . ($data === false ? 'Không kết nối được' : 'Dữ liệu không hợp lệ'));
                break;
            }
        }

        // Top Phim Xem Nhiều
        $top_movies = [];
        if (!empty($all_movies)) {
            $all_movies_copy = $all_movies; // Sao chép mảng
            shuffle($all_movies_copy); // Xáo trộn ngẫu nhiên để mô phỏng top
            $top_movies = array_slice($all_movies_copy, 0, 6); // Lấy 6 phim ngẫu nhiên
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

                $episode_current = $movie['episode_current'] ?? '';
                if (empty($episode_current)) {
                    $detail_url = "https://phimapi.com/phim/{$slug}";
                    $detail_data = fetch_api($detail_url);
                    if ($detail_data && isset($detail_data['movie']['episode_current'])) {
                        $episode_current = $detail_data['movie']['episode_current'];
                    }
                }

                if (in_array($type, ['series', 'tvshows']) && !empty($episode_current)) {
                    $episode = $episode_current;
                } elseif ($type === 'single') {
                    $episode = 'Full';
                } else {
                    $episode = 'Mới';
                }

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

        // Hiển thị Top Phim Xem Nhiều
        if (!empty($top_movies)) {
            echo '<div class="top-movies">';
            echo '<h2 class="top-title">TOP PHIM XEM NHIỀU</h2>';
            echo '<div class="top-grid">';
            $rank = 1;
            foreach ($top_movies as $top_movie) {
                $top_title = htmlspecialchars($top_movie['name']);
                $top_slug = $top_movie['slug'];
                $top_thumbnail = fix_image_url($top_movie['thumb_url']);
                echo "
                    <div class='top-item'>
                        <span class='top-rank'>{$rank}</span>
                        <a href='phim.php?slug={$top_slug}'>
                            <img src='{$top_thumbnail}' alt='{$top_title}' onerror=\"this.onerror=null; this.src='https://via.placeholder.com/150x225?text=Error'; console.log('Lỗi tải ảnh top: {$top_thumbnail}');\">
                            <h4>{$top_title}</h4>
                        </a>
                    </div>";
                $rank++;
            }
            echo '</div>';
            echo '</div>';
        }

        $end_time = microtime(true);
        $execution_time = $end_time - $start_time;
        error_log("Thời gian xử lý index.php: " . $execution_time . " giây");
        ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>