<header>
    <div class="container">
        <div class="logo"><a href="index.php">Phimfree</a></div>
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
            <!-- <a href="quoc-gia.php">Quốc Gia</a> -->
            <!-- <a href="sap-chieu.php">Sắp Chiếu</a> -->
        </nav>
    </div>
</header>
<?php
// Include functions.php
include 'functions.php';
?>
<script>
function toggleDropdown() {
    const dropdown = document.getElementById('category-dropdown');
    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
}

// Đóng dropdown khi nhấp ra ngoài
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('category-dropdown');
    const btn = document.querySelector('.dropdown-btn');
    if (!btn.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});
</script>
<style>
/* CSS chung cho header */


nav {
    display: flex;
    align-items: center;
    gap: 20px; /* Khoảng cách giữa các mục trong nav */
}

nav a {
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
    transition: color 0.3s;
}


/* CSS cho dropdown */
.custom-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-btn {
    background-color: #000;
    color: #fff;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.dropdown-btn:hover {
    background-color: #e50914;
    color: #fff;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #2d2d2d;
    min-width: 200px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    right: 0;
    left: auto;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
}

.dropdown-content a {
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    display: block;
    transition: background-color 0.3s;
}

.dropdown-content a:hover {
    background-color: #e50914;
}

.dropdown-content a:active {
    background-color: #f40612;
}

/* CSS cho thanh tìm kiếm */
.search-form {
    display: flex;
    align-items: center;
    height: 36px; /* Chiều cao cố định để đồng đều với các mục nav */
}

.search-form input[type="text"] {
    padding: 8px 12px;
    border: 1px solid #444; /* Viền nhẹ để nổi bật */
    border-right: none; /* Loại bỏ viền phải để nút liền mạch */
    border-radius: 4px 0 0 4px;
    outline: none;
    background-color: #fff;
    color: #000;
    width: 180px; /* Chiều rộng cố định */
    font-size: 14px;
    height: 100%; /* Đảm bảo đồng đều chiều cao */
    box-sizing: border-box; /* Bao gồm padding và border trong kích thước */
}

.search-form button {
    padding: 0 12px; /* Padding ngang để nút rộng vừa đủ */
    border: 1px solid #e50914; /* Viền khớp với màu nền */
    border-left: none; /* Loại bỏ viền trái để liền mạch với input */
    border-radius: 0 4px 4px 0;
    background-color: #e50914;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
    height: 100%; /* Đảm bảo đồng đều chiều cao */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px; /* Kích thước icon */
}

.search-form button:hover {
    background-color: #f40612;
}
</style>