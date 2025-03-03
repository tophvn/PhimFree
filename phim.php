<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Chi tiết phim</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Sửa lỗi video không hiện trên mobile */
        @media (max-width: 768px) {
            .video-player.active {
                display: block !important;
                height: 300px;
            }
        }
        @media (max-width: 480px) {
            .video-player.active {
                display: block !important;
                height: 200px;
            }
        }

        /* Sửa danh sách tập phim thẳng hàng và đều nhau */
        .episode-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }

        .episode-btn {
            width: 80px;
            text-align: center;
            padding: 10px 0;
            box-sizing: border-box;
        }

        /* Nút Xem từ đầu */
        .play-from-start {
            background-color: #e50914;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .play-from-start:hover {
            background-color: #f40612;
        }

        /* Container cho danh sách tập với thanh cuộn dọc */
        .episode-scroll-container {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #1a1a1a;
        }

        /* Responsive cho danh sách tập trên điện thoại */
        @media (max-width: 768px) {
            .episode-list {
                display: grid;
                grid-template-columns: repeat(2, 1fr); 
                gap: 10px;
                justify-content: flex-start;
            }

            .episode-btn {
                width: 100%; 
                max-width: 120px; 
            }

            .episode-scroll-container {
                max-height: 300px;
            }
        }

        @media (max-width: 480px) {
            .episode-list {
                grid-template-columns: repeat(2, 1fr); 
            }

            .episode-scroll-container {
                max-height: 250px; 
            }
        }

        /* Phần phim đề xuất */
        .suggested-movies {
            margin-top: 30px;
            padding: 20px;
            background-color: #222;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .suggested-title {
            font-size: 22px;
            color: #e50914;
            margin-bottom: 15px;
            text-align: center;
            text-transform: uppercase;
        }

        .suggested-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .suggested-item {
            text-align: center;
            transition: transform 0.3s;
        }

        .suggested-item:hover {
            transform: scale(1.05);
        }

        .suggested-item img {
            width: 100%;
            height: 225px;
            object-fit: cover;
            border-radius: 5px;
        }

        .suggested-item h4 {
            font-size: 16px;
            margin: 5px 0;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .suggested-item a {
            color: #e50914;
            text-decoration: none;
            transition: color 0.3s;
        }

        .suggested-item a:hover {
            color: #f40612;
        }

        /* Responsive cho phim đề xuất */
        @media (max-width: 768px) {
            .suggested-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .suggested-item img {
                height: 180px;
            }
        }

        @media (max-width: 480px) {
            .suggested-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }

            .suggested-item img {
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <?php
        $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
        if (empty($slug)) {
            die('<p>Không tìm thấy phim. Vui lòng chọn phim từ trang chủ.</p>');
        }

        $movie_url = "https://phimapi.com/phim/{$slug}";
        $movie_data = fetch_api($movie_url);

        if ($movie_data && isset($movie_data['movie'])) {
            $movie = $movie_data['movie'];
            $title = htmlspecialchars($movie['name']);
            $description = htmlspecialchars($movie['content']);
            $poster = fix_image_url($movie['poster_url']);
            $year = $movie['year'] ?? 'N/A';
            $quality = $movie['quality'] ?? 'N/A';
            $lang = $movie['lang'] ?? 'N/A';
            $episode_current = $movie['episode_current'] ?? 'N/A';
            $episode_total = $movie['episode_total'] ?? 'N/A';
            $actors = implode(', ', $movie['actor'] ?? ['Chưa cập nhật']);
            $directors = implode(', ', $movie['director'] ?? ['Chưa cập nhật']);
            $categories = array_map(function($cat) { return $cat['name']; }, $movie['category'] ?? []);
            $countries = array_map(function($country) { return $country['name']; }, $movie['country'] ?? []);

            $episodes = [];
            if (!empty($movie_data['episodes'][0]['server_data'])) {
                foreach ($movie_data['episodes'][0]['server_data'] as $episode) {
                    $ep_name = htmlspecialchars($episode['name']);
                    $ep_link_embed = $episode['link_embed'] ?? '#';
                    $ep_link_m3u8 = $episode['link_m3u8'] ?? '#';
                    $ep_number = preg_replace('/[^0-9]/', '', $ep_name); // Lấy số từ tên tập
                    $episodes[$ep_number] = ['name' => $ep_name, 'embed' => $ep_link_embed, 'm3u8' => $ep_link_m3u8];
                }
                krsort($episodes); // Sắp xếp giảm dần theo số tập (tập lớn nhất lên đầu)
            }

            $first_episode_link = !empty($episodes) ? end($episodes)['embed'] : '#'; // Lấy tập 1

            // Lấy phim đề xuất ngẫu nhiên
            $suggested_movies = [];
            $suggested_api_url = "https://phimapi.com/danh-sach/phim-moi-cap-nhat-v2?page=1";
            $suggested_data = fetch_api($suggested_api_url);
            if ($suggested_data && isset($suggested_data['items'])) {
                $all_suggested = $suggested_data['items'];
                shuffle($all_suggested); // Xáo trộn ngẫu nhiên
                foreach ($all_suggested as $suggested_movie) {
                    if ($suggested_movie['slug'] !== $slug) { // Loại bỏ phim hiện tại
                        $suggested_movies[] = $suggested_movie;
                        if (count($suggested_movies) >= 6) break; // Lấy tối đa 6 phim
                    }
                }
            }

            echo "
                <div class='movie-detail'>
                    <div class='movie-header'>
                        <div class='movie-poster'>
                            <img src='{$poster}' alt='{$title}' onerror=\"this.onerror=null; this.src='https://via.placeholder.com/300x450?text=Error'; console.log('Lỗi tải ảnh: {$poster}');\">
                        </div>
                        <div class='movie-info'>
                            <h1 class='movie-title'>{$title}</h1>
                            <div class='movie-meta'>
                                <span class='meta-item'><strong>Năm:</strong> {$year}</span>
                                <span class='meta-item'><strong>Chất lượng:</strong> {$quality}</span>
                                <span class='meta-item'><strong>Ngôn ngữ:</strong> {$lang}</span>
                                <span class='meta-item'><strong>Tập:</strong> {$episode_current} / {$episode_total}</span>
                            </div>
                            <p class='movie-description' style='text-align: left;'><strong>Mô tả:</strong> {$description}</p>
                            <p style='text-align: left;'><strong>Diễn viên:</strong> {$actors}</p>
                            <p style='text-align: left;'><strong>Đạo diễn:</strong> {$directors}</p>
                            <p style='text-align: left;'><strong>Thể loại:</strong> " . implode(', ', $categories) . "</p>
                            <p style='text-align: left;'><strong>Quốc gia:</strong> " . implode(', ', $countries) . "</p>
                        </div>
                    </div>
                    <div class='movie-player-section'>
                        <h3>Xem Phim: <button class='play-from-start' onclick=\"playEpisode('$first_episode_link')\">Xem từ đầu</button></h3>
                        <p class='server-info' id='serverInfo'><strong>Server:</strong> Vietsub #1</p>
                        <div class='player-container'>
                            <div class='loading-message' id='loadingMessage'>Phim đang được tải, vui lòng chờ trong <span id='countdown'>5</span> giây...</div>
                            <div class='video-player' id='videoPlayer'>
                                <iframe id='videoFrame' src='' frameborder='0' allowfullscreen></iframe>
                                <div class='error-message' id='errorMessage'>Không thể phát video. Vui lòng kiểm tra lại hoặc liên hệ admin.</div>
                            </div>
                        </div>
                        <div class='episode-scroll-container'>
                            <div class='episode-list'>";
            foreach ($episodes as $ep_number => $data) {
                echo "<a href='#' class='episode-btn' onclick=\"playEpisode('{$data['embed']}'); return false;\">{$data['name']}</a>";
            }
            echo "          </div>
                        </div>
                    </div>
                    <!-- Phim đề xuất -->
                    <div class='suggested-movies'>
                        <h2 class='suggested-title'>PHIM ĐỀ XUẤT</h2>
                        <div class='suggested-grid'>";
            foreach ($suggested_movies as $suggested_movie) {
                $suggested_title = htmlspecialchars($suggested_movie['name']);
                $suggested_slug = $suggested_movie['slug'];
                $suggested_thumbnail = fix_image_url($suggested_movie['thumb_url']);
                echo "
                    <div class='suggested-item'>
                        <a href='phim.php?slug={$suggested_slug}'>
                            <img src='{$suggested_thumbnail}' alt='{$suggested_title}' onerror=\"this.onerror=null; this.src='https://via.placeholder.com/150x225?text=Error'; console.log('Lỗi tải ảnh đề xuất: {$suggested_thumbnail}');\">
                            <h4>{$suggested_title}</h4>
                        </a>
                    </div>";
            }
            echo "        </div>
                    </div>
                </div>";
        } else {
            echo '<p>Không tìm thấy thông tin phim. Vui lòng thử lại.</p>';
            if (!$movie_data) {
                echo '<p>Lỗi API: Kiểm tra log server để biết chi tiết.</p>';
            }
        }
        ?>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        let countdown;

        function playEpisode(source) {
            const videoPlayer = document.getElementById('videoPlayer');
            const videoFrame = document.getElementById('videoFrame');
            const errorMessage = document.getElementById('errorMessage');
            const loadingMessage = document.getElementById('loadingMessage');
            const countdownSpan = document.getElementById('countdown');

            loadingMessage.classList.add('active');
            videoPlayer.classList.remove('active');
            errorMessage.classList.remove('active');

            let timeLeft = 5;
            countdownSpan.textContent = timeLeft;

            // Bỏ tự động cuộn
            // Không có dòng scrollIntoView

            clearInterval(countdown);
            countdown = setInterval(() => {
                timeLeft--;
                countdownSpan.textContent = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    loadingMessage.classList.remove('active');
                    videoPlayer.classList.add('active');
                }
            }, 1000);

            videoFrame.src = source;

            setTimeout(() => {
                if (videoFrame.src && !videoFrame.contentWindow.document.body.innerHTML) {
                    videoPlayer.classList.remove('active');
                    errorMessage.classList.add('active');
                    clearInterval(countdown);
                    loadingMessage.classList.remove('active');
                }
            }, 2000);
        }
    </script>
</body>
</html>