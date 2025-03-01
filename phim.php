<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phimfree - Chi tiết phim</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <?php
        // Lấy slug từ URL
        $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
        if (empty($slug)) {
            die('<p>Không tìm thấy phim. Vui lòng chọn phim từ trang chủ.</p>');
        }

        // Chuyển sang API mới
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

            // Chuẩn bị danh sách tập phim
            $episodes = [];
            if (!empty($movie_data['episodes'][0]['server_data'])) {
                foreach ($movie_data['episodes'][0]['server_data'] as $episode) {
                    $ep_name = htmlspecialchars($episode['name']);
                    $ep_link_embed = $episode['link_embed'] ?? '#';
                    $ep_link_m3u8 = $episode['link_m3u8'] ?? '#';
                    $episodes[$ep_name] = ['embed' => $ep_link_embed, 'm3u8' => $ep_link_m3u8];
                }
                // Sắp xếp theo thứ tự giảm dần (từ tập mới nhất)
                krsort($episodes);
            }

            echo "
                <div class='movie-detail'>
                    <div class='movie-header'>
                        <img src='{$poster}' alt='{$title}' onerror=\"this.onerror=null; this.src='https://via.placeholder.com/200x300?text=Error'; console.log('Lỗi tải ảnh: {$poster}');\">
                        <div class='movie-info'>
                            <h2>{$title}</h2>
                            <p><strong>Mô tả:</strong> {$description}</p>
                            <p><strong>Năm phát hành:</strong> {$year}</p>
                            <p><strong>Chất lượng:</strong> {$quality}</p>
                            <p><strong>Ngôn ngữ:</strong> {$lang}</p>
                            <p><strong>Tập hiện tại:</strong> {$episode_current} / {$episode_total}</p>
                            <p><strong>Diễn viên:</strong> {$actors}</p>
                            <p><strong>Đạo diễn:</strong> {$directors}</p>
                            <p><strong>Thể loại:</strong> " . implode(', ', $categories) . "</p>
                            <p><strong>Quốc gia:</strong> " . implode(', ', $countries) . "</p>
                        </div>
                    </div>
                    <h3>Xem Phim</h3>
                    <p><strong>Server:</strong> Vietsub #1</p>
                    <div class='episode-list'>";
            // Hiển thị nút cho từng tập
            foreach ($episodes as $ep_name => $links) {
                echo "<button class='episode-btn' onclick=\"playEpisode('{$links['embed']}')\"> {$ep_name}</button>";
            }
            echo "</div>
                    <div class='video-player' id='videoPlayer'>
                        <iframe id='videoFrame' src='' frameborder='0' allowfullscreen></iframe>
                        <div class='error-message' id='errorMessage'>Không thể phát video. Vui lòng kiểm tra lại hoặc liên hệ admin.</div>
                    </div>
                </div>
            ";
        } else {
            echo '<p>Không tìm thấy thông tin phim. Vui lòng thử lại.</p>';
            if (!$movie_data) {
                echo '<p>Lỗi API: Kiểm tra log server để biết chi tiết.</p>';
            }
        }
        ?>
    </div>

    <script>
        function playEpisode(source) {
            const videoPlayer = document.getElementById('videoPlayer');
            const videoFrame = document.getElementById('videoFrame');
            const errorMessage = document.getElementById('errorMessage');

            // Thử tải iframe
            videoFrame.src = source;
            videoPlayer.classList.add('active');

            // Tự động cuộn đến phần video
            videoPlayer.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Kiểm tra sau 2 giây nếu không load được
            setTimeout(() => {
                if (videoFrame.src && !videoFrame.contentWindow.document.body.innerHTML) {
                    videoPlayer.classList.remove('active');
                    errorMessage.classList.add('active');
                }
            }, 2000);
        }
    </script>
</body>
</html>