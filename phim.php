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
                display: block !important; /* Đảm bảo video hiển thị khi active */
                height: 300px; /* Giữ chiều cao như trong CSS */
            }
        }
        @media (max-width: 480px) {
            .video-player.active {
                display: block !important; /* Đảm bảo video hiển thị khi active */
                height: 200px; /* Giữ chiều cao như trong CSS */
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
                    $episodes[$ep_name] = ['embed' => $ep_link_embed, 'm3u8' => $ep_link_m3u8];
                }
                krsort($episodes);
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
                        <h3>Xem Phim</h3>
                        <p class='server-info'><strong>Server:</strong> Vietsub #1</p>
                        <div class='player-container'>
                            <div class='loading-message' id='loadingMessage'>Phim đang được tải, vui lòng chờ trong <span id='countdown'>5</span> giây...</div>
                            <div class='video-player' id='videoPlayer'>
                                <iframe id='videoFrame' src='' frameborder='0' allowfullscreen></iframe>
                                <div class='error-message' id='errorMessage'>Không thể phát video. Vui lòng kiểm tra lại hoặc liên hệ admin.</div>
                            </div>
                        </div>
                        <div class='episode-list'>";
            foreach ($episodes as $ep_name => $links) {
                echo "<a href='#' class='episode-btn' onclick=\"playEpisode('{$links['embed']}'); return false;\">{$ep_name}</a>";
            }
            echo "      </div>
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

            clearInterval(countdown);
            countdown = setInterval(() => {
                timeLeft--;
                countdownSpan.textContent = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    loadingMessage.classList.remove('active');
                    videoPlayer.classList.add('active');
                    // Cuộn đến video player sau khi hiển thị
                    videoPlayer.scrollIntoView({ behavior: 'smooth', block: 'start' });
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