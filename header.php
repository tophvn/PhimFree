<header>
    <div class="container">
        <div class="logo"><a href="index.php">Phimfree</a></div>
        <button class="hamburger" onclick="toggleMenu()">☰</button>
        <nav>
            <form action="tim-kiem.php" method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="Tìm kiếm phim..." required>
                <button type="submit">🔍</button>
            </form>
            <a href="phim-bo.php">Phim Bộ</a>
            <a href="phim-le.php">Phim Lẻ</a>
            <a href="tv-shows.php">Shows</a>
            <a href="hoat-hinh.php">Hoạt Hình</a>
            <div class="custom-dropdown">
                <button class="dropdown-btn" onclick="toggleDropdown()">Thể Loại</button>
                <div class="dropdown-content" id="category-dropdown">
                    <?php
                    $categories = [
                        ["name" => "Hành Động", "slug" => "hanh-dong"],
                        ["name" => "Tình Cảm", "slug" => "tinh-cam"],
                        ["name" => "Hài Hước", "slug" => "hai-huoc"],
                        ["name" => "Cổ Trang", "slug" => "co-trang"],
                        ["name" => "Tâm Lý", "slug" => "tam-ly"],
                        ["name" => "Hình Sự", "slug" => "hinh-su"],
                        ["name" => "Chiến Tranh", "slug" => "chien-tranh"],
                        ["name" => "Thể Thao", "slug" => "the-thao"],
                        ["name" => "Võ Thuật", "slug" => "vo-thuat"],
                        ["name" => "Viễn Tưởng", "slug" => "vien-tuong"],
                        ["name" => "Phiêu Lưu", "slug" => "phieu-luu"],
                        ["name" => "Khoa Học", "slug" => "khoa-hoc"],
                        ["name" => "Kinh Dị", "slug" => "kinh-di"],
                        ["name" => "Âm Nhạc", "slug" => "am-nhac"],
                        ["name" => "Thần Thoại", "slug" => "than-thoai"],
                        ["name" => "Tài Liệu", "slug" => "tai-lieu"],
                        ["name" => "Gia Đình", "slug" => "gia-dinh"],
                        ["name" => "Chính Kịch", "slug" => "chinh-kich"],
                        ["name" => "Bí Ẩn", "slug" => "bi-an"],
                        ["name" => "Học Đường", "slug" => "hoc-duong"],
                        ["name" => "Kinh Điển", "slug" => "kinh-dien"],
                        ["name" => "Phim 18+", "slug" => "phim-18"]
                    ];
                    echo '<div class="grid-container">';
                    foreach ($categories as $index => $category) {
                        echo '<a href="the-loai.php?slug=' . htmlspecialchars($category['slug']) . '">' . htmlspecialchars($category['name']) . '</a>';
                        if (($index + 1) % 6 === 0 && $index < count($categories) - 1) {
                            echo '</div><div class="grid-container">';
                        }
                    }
                    echo '</div>';
                    ?>
                </div>
            </div>
        </nav>
    </div>
</header>

<?php include 'functions.php'; ?>

<script>
function toggleDropdown() {
    const dropdown = document.getElementById('category-dropdown');
    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
}

function toggleMenu() {
    const nav = document.querySelector('nav');
    nav.style.display = (nav.style.display === 'flex') ? 'none' : 'flex';
}

document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('category-dropdown');
    const btn = document.querySelector('.dropdown-btn');
    if (!btn.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});
</script>