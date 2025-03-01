<?php
// filter.php
?>

<div class="filter-form" style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
    <!-- Thời gian -->
    <select name="sort_field" onchange="this.form.submit()">
        <option value="">Thời gian</option>
        <option value="modified.time" <?php echo isset($_GET['sort_field']) && $_GET['sort_field'] == 'modified.time' ? 'selected' : ''; ?>>Thời gian cập nhật</option>
        <option value="created_at" <?php echo isset($_GET['sort_field']) && $_GET['sort_field'] == 'created_at' ? 'selected' : ''; ?>>Thời gian đăng</option>
        <option value="year" <?php echo isset($_GET['sort_field']) && $_GET['sort_field'] == 'year' ? 'selected' : ''; ?>>Thời gian sản xuất</option>
    </select>

    <!-- Ngôn ngữ -->
    <select name="sort_lang" onchange="this.form.submit()">
        <option value="">Toàn bộ ngôn ngữ</option>
        <option value="thuyet-minh" <?php echo isset($_GET['sort_lang']) && $_GET['sort_lang'] == 'thuyet-minh' ? 'selected' : ''; ?>>Phim Thuyết Minh</option>
        <option value="vietsub" <?php echo isset($_GET['sort_lang']) && $_GET['sort_lang'] == 'vietsub' ? 'selected' : ''; ?>>Phim Vietsub</option>
        <option value="long-tieng" <?php echo isset($_GET['sort_lang']) && $_GET['sort_lang'] == 'long-tieng' ? 'selected' : ''; ?>>Phim lồng tiếng</option>
    </select>

    <!-- Thể loại -->
    <select name="category" onchange="this.form.submit()">
        <option value="">Toàn bộ thể loại</option>
        <option value="hanh-dong" <?php echo isset($_GET['category']) && $_GET['category'] == 'hanh-dong' ? 'selected' : ''; ?>>Hành Động</option>
        <option value="tinh-cam" <?php echo isset($_GET['category']) && $_GET['category'] == 'tinh-cam' ? 'selected' : ''; ?>>Tình Cảm</option>
        <option value="hai-huoc" <?php echo isset($_GET['category']) && $_GET['category'] == 'hai-huoc' ? 'selected' : ''; ?>>Hài Hước</option>
        <option value="co-trang" <?php echo isset($_GET['category']) && $_GET['category'] == 'co-trang' ? 'selected' : ''; ?>>Cổ Trang</option>
        <option value="tam-ly" <?php echo isset($_GET['category']) && $_GET['category'] == 'tam-ly' ? 'selected' : ''; ?>>Tâm Lý</option>
        <option value="hinh-su" <?php echo isset($_GET['category']) && $_GET['category'] == 'hinh-su' ? 'selected' : ''; ?>>Hình Sự</option>
        <option value="chien-tranh" <?php echo isset($_GET['category']) && $_GET['category'] == 'chien-tranh' ? 'selected' : ''; ?>>Chiến Tranh</option>
        <option value="the-thao" <?php echo isset($_GET['category']) && $_GET['category'] == 'the-thao' ? 'selected' : ''; ?>>Thể Thao</option>
        <option value="vo-thuat" <?php echo isset($_GET['category']) && $_GET['category'] == 'vo-thuat' ? 'selected' : ''; ?>>Võ Thuật</option>
        <option value="vien-tuong" <?php echo isset($_GET['category']) && $_GET['category'] == 'vien-tuong' ? 'selected' : ''; ?>>Viễn Tưởng</option>
        <option value="phieu-luu" <?php echo isset($_GET['category']) && $_GET['category'] == 'phieu-luu' ? 'selected' : ''; ?>>Phiêu Lưu</option>
        <option value="khoa-hoc" <?php echo isset($_GET['category']) && $_GET['category'] == 'khoa-hoc' ? 'selected' : ''; ?>>Khoa Học</option>
        <option value="kinh-di" <?php echo isset($_GET['category']) && $_GET['category'] == 'kinh-di' ? 'selected' : ''; ?>>Kinh Dị</option>
        <option value="am-nhac" <?php echo isset($_GET['category']) && $_GET['category'] == 'am-nhac' ? 'selected' : ''; ?>>Âm Nhạc</option>
        <option value="than-thoai" <?php echo isset($_GET['category']) && $_GET['category'] == 'than-thoai' ? 'selected' : ''; ?>>Thần Thoại</option>
        <option value="tai-lieu" <?php echo isset($_GET['category']) && $_GET['category'] == 'tai-lieu' ? 'selected' : ''; ?>>Tài Liệu</option>
        <option value="gia-dinh" <?php echo isset($_GET['category']) && $_GET['category'] == 'gia-dinh' ? 'selected' : ''; ?>>Gia Đình</option>
        <option value="chinh-kich" <?php echo isset($_GET['category']) && $_GET['category'] == 'chinh-kich' ? 'selected' : ''; ?>>Chính Kịch</option>
        <option value="bi-an" <?php echo isset($_GET['category']) && $_GET['category'] == 'bi-an' ? 'selected' : ''; ?>>Bí Ẩn</option>
        <option value="hoc-duong" <?php echo isset($_GET['category']) && $_GET['category'] == 'hoc-duong' ? 'selected' : ''; ?>>Học Đường</option>
        <option value="kinh-dien" <?php echo isset($_GET['category']) && $_GET['category'] == 'kinh-dien' ? 'selected' : ''; ?>>Kinh Điển</option>
        <option value="phim-18" <?php echo isset($_GET['category']) && $_GET['category'] == 'phim-18' ? 'selected' : ''; ?>>Phim 18+</option>
    </select>

    <!-- Quốc gia -->
    <select name="country" onchange="this.form.submit()">
        <option value="">Toàn bộ quốc gia</option>
        <option value="trung-quoc" <?php echo isset($_GET['country']) && $_GET['country'] == 'trung-quoc' ? 'selected' : ''; ?>>Trung Quốc</option>
        <option value="han-quoc" <?php echo isset($_GET['country']) && $_GET['country'] == 'han-quoc' ? 'selected' : ''; ?>>Hàn Quốc</option>
        <option value="nhat-ban" <?php echo isset($_GET['country']) && $_GET['country'] == 'nhat-ban' ? 'selected' : ''; ?>>Nhật Bản</option>
        <option value="thai-lan" <?php echo isset($_GET['country']) && $_GET['country'] == 'thai-lan' ? 'selected' : ''; ?>>Thái Lan</option>
        <option value="dai-loan" <?php echo isset($_GET['country']) && $_GET['country'] == 'dai-loan' ? 'selected' : ''; ?>>Đài Loan</option>
        <option value="hong-kong" <?php echo isset($_GET['country']) && $_GET['country'] == 'hong-kong' ? 'selected' : ''; ?>>Hồng Kông</option>
        <option value="an-do" <?php echo isset($_GET['country']) && $_GET['country'] == 'an-do' ? 'selected' : ''; ?>>Ấn Độ</option>
        <option value="anh" <?php echo isset($_GET['country']) && $_GET['country'] == 'anh' ? 'selected' : ''; ?>>Anh</option>
        <option value="phap" <?php echo isset($_GET['country']) && $_GET['country'] == 'phap' ? 'selected' : ''; ?>>Pháp</option>
        <option value="canada" <?php echo isset($_GET['country']) && $_GET['country'] == 'canada' ? 'selected' : ''; ?>>Canada</option>
        <option value="duc" <?php echo isset($_GET['country']) && $_GET['country'] == 'duc' ? 'selected' : ''; ?>>Đức</option>
        <option value="tay-ban-nha" <?php echo isset($_GET['country']) && $_GET['country'] == 'tay-ban-nha' ? 'selected' : ''; ?>>Tây Ban Nha</option>
        <option value="tho-nhi-ky" <?php echo isset($_GET['country']) && $_GET['country'] == 'tho-nhi-ky' ? 'selected' : ''; ?>>Thổ Nhĩ Kỳ</option>
        <option value="ha-lan" <?php echo isset($_GET['country']) && $_GET['country'] == 'ha-lan' ? 'selected' : ''; ?>>Hà Lan</option>
        <option value="indonesia" <?php echo isset($_GET['country']) && $_GET['country'] == 'indonesia' ? 'selected' : ''; ?>>Indonesia</option>
        <option value="nga" <?php echo isset($_GET['country']) && $_GET['country'] == 'nga' ? 'selected' : ''; ?>>Nga</option>
        <option value="mexico" <?php echo isset($_GET['country']) && $_GET['country'] == 'mexico' ? 'selected' : ''; ?>>Mexico</option>
        <option value="ba-lan" <?php echo isset($_GET['country']) && $_GET['country'] == 'ba-lan' ? 'selected' : ''; ?>>Ba Lan</option>
        <option value="uc" <?php echo isset($_GET['country']) && $_GET['country'] == 'uc' ? 'selected' : ''; ?>>Úc</option>
        <option value="thuy-dien" <?php echo isset($_GET['country']) && $_GET['country'] == 'thuy-dien' ? 'selected' : ''; ?>>Thụy Điển</option>
        <option value="malaysia" <?php echo isset($_GET['country']) && $_GET['country'] == 'malaysia' ? 'selected' : ''; ?>>Malaysia</option>
        <option value="brazil" <?php echo isset($_GET['country']) && $_GET['country'] == 'brazil' ? 'selected' : ''; ?>>Brazil</option>
        <option value="philippines" <?php echo isset($_GET['country']) && $_GET['country'] == 'philippines' ? 'selected' : ''; ?>>Philippines</option>
        <option value="bo-dao-nha" <?php echo isset($_GET['country']) && $_GET['country'] == 'bo-dao-nha' ? 'selected' : ''; ?>>Bồ Đào Nha</option>
        <option value="y" <?php echo isset($_GET['country']) && $_GET['country'] == 'y' ? 'selected' : ''; ?>>Ý</option>
        <option value="dan-mach" <?php echo isset($_GET['country']) && $_GET['country'] == 'dan-mach' ? 'selected' : ''; ?>>Đan Mạch</option>
        <option value="uae" <?php echo isset($_GET['country']) && $_GET['country'] == 'uae' ? 'selected' : ''; ?>>UAE</option>
        <option value="na-uy" <?php echo isset($_GET['country']) && $_GET['country'] == 'na-uy' ? 'selected' : ''; ?>>Na Uy</option>
        <option value="thuy-si" <?php echo isset($_GET['country']) && $_GET['country'] == 'thuy-si' ? 'selected' : ''; ?>>Thụy Sĩ</option>
        <option value="nam-phi" <?php echo isset($_GET['country']) && $_GET['country'] == 'nam-phi' ? 'selected' : ''; ?>>Nam Phi</option>
        <option value="ukraina" <?php echo isset($_GET['country']) && $_GET['country'] == 'ukraina' ? 'selected' : ''; ?>>Ukraina</option>
        <option value="a-rap-xe-ut" <?php echo isset($_GET['country']) && $_GET['country'] == 'a-rap-xe-ut' ? 'selected' : ''; ?>>Ả Rập Xê Út</option>
        <option value="bi" <?php echo isset($_GET['country']) && $_GET['country'] == 'bi' ? 'selected' : ''; ?>>Bỉ</option>
        <option value="ireland" <?php echo isset($_GET['country']) && $_GET['country'] == 'ireland' ? 'selected' : ''; ?>>Ireland</option>
        <option value="colombia" <?php echo isset($_GET['country']) && $_GET['country'] == 'colombia' ? 'selected' : ''; ?>>Colombia</option>
        <option value="phan-lan" <?php echo isset($_GET['country']) && $_GET['country'] == 'phan-lan' ? 'selected' : ''; ?>>Phần Lan</option>
        <option value="viet-nam" <?php echo isset($_GET['country']) && $_GET['country'] == 'viet-nam' ? 'selected' : ''; ?>>Việt Nam</option>
        <option value="chile" <?php echo isset($_GET['country']) && $_GET['country'] == 'chile' ? 'selected' : ''; ?>>Chile</option>
        <option value="hy-lap" <?php echo isset($_GET['country']) && $_GET['country'] == 'hy-lap' ? 'selected' : ''; ?>>Hy Lạp</option>
        <option value="nigeria" <?php echo isset($_GET['country']) && $_GET['country'] == 'nigeria' ? 'selected' : ''; ?>>Nigeria</option>
        <option value="argentina" <?php echo isset($_GET['country']) && $_GET['country'] == 'argentina' ? 'selected' : ''; ?>>Argentina</option>
        <option value="singapore" <?php echo isset($_GET['country']) && $_GET['country'] == 'singapore' ? 'selected' : ''; ?>>Singapore</option>
    </select>

    <!-- Năm -->
    <select name="year" onchange="this.form.submit()">
        <option value="">Toàn bộ năm</option>
        <?php for ($y = 2010; $y <= 2026; $y++) {
            echo "<option value='$y' " . (isset($_GET['year']) && $_GET['year'] == $y ? 'selected' : '') . ">$y</option>";
        } ?>
    </select>

    <button type="submit" style="background-color: purple; color: white; padding: 5px 10px; border: none; border-radius: 4px;">Đặt phim</button>
</form>

<?php
$start_time = microtime(true);
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 30; // Hiển thị 30 phim mỗi trang

// Lấy tham số lọc từ form
$sort_field = isset($_GET['sort_field']) ? $_GET['sort_field'] : '';
$sort_type = 'desc'; // Mặc định giảm dần
$sort_lang = isset($_GET['sort_lang']) ? $_GET['sort_lang'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$country = isset($_GET['country']) ? $_GET['country'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';

// Xây dựng URL API
$api_url = "https://phimapi.com/v1/api/danh-sach/hoat-hinh?page={$page}&limit={$limit}";
if ($sort_field) $api_url .= "&sort_field={$sort_field}&sort_type={$sort_type}";
if ($sort_lang) $api_url .= "&sort_lang={$sort_lang}";
if ($category) $api_url .= "&category={$category}";
if ($country) $api_url .= "&country={$country}";
if ($year) $api_url .= "&year={$year}";
error_log("API URL (hoat-hinh.php): " . $api_url);

$data = fetch_api($api_url);

if ($data && isset($data['data']['items']) && !empty($data['data']['items'])) {
    $movies = $data['data']['items'];

    echo '<div class="movie-container">';
    foreach ($movies as $movie) {
        $title = htmlspecialchars($movie['name'] ?? 'Không có tiêu đề');
        $slug = htmlspecialchars($movie['slug'] ?? '');
        $thumbnail = !empty($movie['thumb_url']) ? 'https://phimimg.com/' . ltrim($movie['thumb_url'], '/') : 'https://via.placeholder.com/200x300?text=No+Image';
        $year = htmlspecialchars($movie['year'] ?? 'N/A');

        $fallback_thumbnail = 'https://via.placeholder.com/200x300?text=Error';
        echo "
            <div class='movie-card'>
                <a href='phim.php?slug={$slug}'>
                    <img src='{$thumbnail}' alt='{$title}' onerror=\"this.src='{$fallback_thumbnail}'; console.log('Lỗi tải ảnh (hoat-hinh.php): {$thumbnail}');\">
                    <div class='info'>
                        <h3>{$title}</h3>
                        <p>Năm: {$year}</p>
                    </div>
                </a>
            </div>
        ";
    }
    echo '</div>';

    $total_items = isset($data['data']['pagination']['totalItems']) ? (int)$data['data']['pagination']['totalItems'] : count($movies);
    $total_pages = isset($data['data']['pagination']['totalPages']) ? (int)$data['data']['pagination']['totalPages'] : ceil($total_items / $limit);

    echo "<p>Tổng phim: $total_items | Trang hiện tại: $page | Tổng trang: $total_pages</p>";
    error_log("Phân trang (hoat-hinh.php): totalItems=$total_items, totalPages=$total_pages, currentPage=$page, itemsCount=" . count($movies));

    if ($total_pages > 1) {
        echo '<div class="pagination">';
        if ($page > 1) {
            echo "<a href='hoat-hinh.php?page=" . ($page - 1) . "&sort_field=" . urlencode($sort_field) . "&sort_lang=" . urlencode($sort_lang) . "&category=" . urlencode($category) . "&country=" . urlencode($country) . "&year=" . urlencode($year) . "'>Trang trước</a>";
        } else {
            echo "<span class='disabled'>Trang trước</span>";
        }
        echo " <span>Trang $page / $total_pages</span> ";
        if ($page < $total_pages) {
            echo "<a href='hoat-hinh.php?page=" . ($page + 1) . "&sort_field=" . urlencode($sort_field) . "&sort_lang=" . urlencode($sort_lang) . "&category=" . urlencode($category) . "&country=" . urlencode($country) . "&year=" . urlencode($year) . "'>Trang sau</a>";
        } else {
            echo "<span class='disabled'>Trang sau</span>";
        }
        echo '</div>';
    }
} else {
    echo '<p>Không thể tải danh sách hoạt hình. Vui lòng kiểm tra kết nối hoặc liên hệ admin.</p>';
    error_log("Lỗi API tại hoat-hinh.php: " . json_encode($data));
}

$end_time = microtime(true);
error_log("Thời gian xử lý hoat-hinh.php: " . ($end_time - $start_time) . " giây");
?>

<style>
    .filter-form select, .filter-form button {
    padding: 5px 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    background-color: #fff;
}
.filter-form button {
    background-color: purple;
    color: white;
    border: none;
    cursor: pointer;
}
.filter-form button:hover {
    background-color: darkviolet;
}
</style>