<?php
session_start();
include 'db.php';

function esc($c, $v) { return mysqli_real_escape_string($c, trim($v)); }

// دخول / خروج
if (isset($_POST['login'])) {

   $hashed = '$2y$12$Ac./.Ot8UhLcw6uTCJCpeupGv1wAn8AHZ89Eu/UWaU0QTb62NPyZq';

   if ($_POST['user'] === 'admin' && password_verify($_POST['pass'], $hashed)) {

        //  حماية إضافية للجلسة
        session_regenerate_id(true);

        $_SESSION['is_admin'] = true;

        header("Location: admin.php");
        exit();

    } else {

        $error = "خطأ في بيانات الدخول";

    }
}
if (isset($_GET['logout'])) { session_destroy(); header("Location: admin.php"); exit(); }
// حساب الإحصائيات لعرضها في الداش
$c_videos  = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM videos_content"));
$c_tools   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM medical_tools"));
$c_centers = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM centers_services"));
$c_users   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='user'"));
// شاشة الدخول
if (!isset($_SESSION['is_admin'])) { ?>
<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="UTF-8">
<title>دخول المسؤول</title>
<link rel="icon" type="image/png" href="img_2.png">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo&display=swap');
    body { background:#0e4a43; display:flex; justify-content:center; align-items:center; height:100vh; font-family:'Cairo',sans-serif; margin:0; }
    .login-card { background:#fff; padding:40px; border-radius:20px; box-shadow:0 10px 30px rgba(0,0,0,0.3); text-align:center; width:350px; }
    h2 { color:#0e4a43; margin-bottom:25px; }
    input { width:100%; padding:12px; margin-bottom:15px; border:1px solid #81d8d0; border-radius:10px; outline:none; }
    button { width:100%; padding:12px; background:#198e80; color:#fff; border:none; border-radius:10px; font-weight:bold; cursor:pointer; transition:0.3s; }
    button:hover { background:#0e4a43; }
</style></head>
<body><div class="login-card"><h2>شفاء موف</h2>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="POST">
    <input name="user" placeholder="اسم المستخدم" required>
    <input name="pass" type="password" placeholder="كلمة المرور" required>
    <button name="login">دخول</button>
</form></div></body></html>
<?php exit(); }


if (isset($_POST['edit_video'])) {
    $id     = (int)$_POST['edit_id'];
    $title  = esc($conn, $_POST['video_title']);
    $source = esc($conn, $_POST['video_source']);
    $url    = esc($conn, $_POST['video_url']);
    mysqli_query($conn, "UPDATE videos_content SET video_title='$title', video_source='$source', video_url='$url' WHERE id=$id");
    header("Location: admin.php#ex"); exit();
}

//  أداة
if (isset($_POST['edit_tool'])) {
    $id   = (int)$_POST['edit_id'];
    $name = esc($conn, $_POST['tool_name']);
    $desc = esc($conn, $_POST['tool_desc']);
    mysqli_query($conn, "UPDATE medical_tools SET tool_name='$name', tool_desc='$desc' WHERE id=$id");
    header("Location: admin.php#tl"); exit();
}

//  مركز
if (isset($_POST['edit_center'])) {
    $id    = (int)$_POST['edit_id'];
    $title = esc($conn, $_POST['center_title']);
    $phone = esc($conn, $_POST['center_phone']);
    mysqli_query($conn, "UPDATE centers_services SET title='$title', phone='$phone' WHERE id=$id");
    header("Location: admin.php#cn"); exit();
}

// إضافة تمرين
if (isset($_POST['add_video'])) {
    $title  = esc($conn, $_POST['video_title']);
    $source = esc($conn, $_POST['video_source']);
    $url    = esc($conn, $_POST['video_url']);
    mysqli_query($conn, "INSERT INTO videos_content (video_title, video_source, video_url) VALUES ('$title', '$source', '$url')");
    header("Location: admin.php#ex"); exit();
}

// إضافة أداة
if (isset($_POST['add_tool'])) {
    $name = esc($conn, $_POST['tool_name']);
    $desc = esc($conn, $_POST['tool_desc']);
    mysqli_query($conn, "INSERT INTO medical_tools (tool_name, tool_desc) VALUES ('$name', '$desc')");
    header("Location: admin.php#tl"); exit();
}

// إضافة مركز
if (isset($_POST['add_center'])) {
    $title = esc($conn, $_POST['center_title']);
    $phone = esc($conn, $_POST['center_phone']);
    mysqli_query($conn, "INSERT INTO centers_services (title, phone) VALUES ('$title', '$phone')");
    header("Location: admin.php#cn"); exit();
}

// إضافة مستخدم
if (isset($_POST['add_user'])) {
    $name  = esc($conn, $_POST['user_name']);
    $email = esc($conn, $_POST['user_email']);
    $pass  = password_hash($_POST['user_pass'], PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (user_name, email, password, role) VALUES ('$name', '$email', '$pass', 'user')");
    header("Location: admin.php#us"); exit();
}

// تعطيل / تفعيل مستخدم
if (isset($_GET['toggle_status']) && isset($_GET['current_status'])) {
    $id         = (int)$_GET['toggle_status'];
    $new_status = ($_GET['current_status'] === 'active') ? 'inactive' : 'active';
    mysqli_query($conn, "UPDATE users SET status='$new_status' WHERE id=$id");
    header("Location: admin.php#us"); exit();
}

// حذف
if (isset($_GET['del']) && isset($_GET['type'])) {
    $id  = (int)$_GET['del'];
    $t   = $_GET['type'];
    $tbl = ($t=='ex') ? 'videos_content' :
           (($t=='tl') ? 'medical_tools' :
           (($t=='cn') ? 'centers_services' :
           (($t=='ms') ? 'contact_messages' :
           (($t=='us') ? 'users' :
           (($t=='fav') ? 'favorites' : '')))));
    if ($tbl) mysqli_query($conn, "DELETE FROM $tbl WHERE id = $id");
    header("Location: admin.php#$t"); exit();
}

// إحصائيات
$c_videos  = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM videos_content"));
$c_tools   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM medical_tools"));
$c_centers = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM centers_services"));
$c_users   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='user'"));
$c_msgs    = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM contact_messages"));
$c_favs    = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM favorites"));

// جلب البيانات
$favs  = mysqli_query($conn, "SELECT f.*, u.user_name, v.video_title, t.tool_name 
 FROM favorites f 
 LEFT JOIN users u ON f.user_id = u.id 
 LEFT JOIN videos_content v ON f.video_id = v.id 
 LEFT JOIN medical_tools t ON f.tool_id = t.id 
ORDER BY f.added_at DESC");
$msgs  = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY created_at DESC");
$users = mysqli_query($conn, "SELECT * FROM users WHERE role='user' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>لوحة التحكم | شفاء موف</title>
<link rel="icon" type="image/png" href="img_2.png">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');

    :root {
        --dark: #0e4a43;
        --green: #198e80;
        --tiffany: #81d8d0;
        --bg: #f0fafa;
    }

    * { margin:0; padding:0; box-sizing:border-box; font-family:'Cairo',sans-serif; }
    body { display:flex; background:var(--bg); }

    /* ===== SIDEBAR ===== */
    .sidebar {
        width: 240px;
        background: var(--dark);
        height: 100vh;
        position: fixed;
        right: 0;
        padding: 25px;
        color: #fff;
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    }

    .sidebar h2 {
        color: var(--tiffany);
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 1px solid #198e80;
        padding-bottom: 15px;
    }

    .sidebar a {
        display: block;
        color: #c8f0ec;
        text-decoration: none;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 8px;
        transition: 0.3s;
    }

    .sidebar a:hover { background: var(--green); }

    .sidebar .out {
        margin-top: 40px;
        color: #ffb3b3;
        border: 1px solid #ffb3b3;
        text-align: center;
    }

    /* ===== MAIN ===== */
    .main-content {
        margin-right: 240px;
        padding: 35px;
        width: 100%;
    }

    .welcome-msg {
        margin-bottom: 30px;
        border-right: 6px solid var(--tiffany);
        padding-right: 20px;
    }

    .welcome-msg h1 { color: var(--dark); }
    .welcome-msg p  { color: #666; margin-top: 5px; }

    /* ===== BOX ===== */
    .box {
        background: #fff;
        padding: 25px;
        border-radius: 18px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.04);
        margin-bottom: 30px;
    }

    .box h3 {
        color: var(--dark);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 18px;
    }

    /* ===== FORM ===== */
    .add-form {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .add-form input {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid #81d8d0;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        min-width: 150px;
    }

    .add-form input:focus { border-color: var(--green); }

    .btn-add {
        padding: 10px 20px;
        background: var(--green);
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-family: inherit;
        font-size: 14px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-add:hover { background: var(--dark); }

    /* ===== TABLE ===== */
    table { width:100%; border-collapse:collapse; }

    th {
        background: #f9fdfd;
        color: var(--dark);
        padding: 13px;
        text-align: center;
        border-bottom: 3px solid var(--tiffany);
        font-weight: 700;
    }

    td {
        padding: 13px;
        text-align: center;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    tr:hover td { background: #f9fdfd; }

    /* ===== ACTION BUTTONS ===== */
    .btn-del {
        color: #ff4d4d;
        text-decoration: none;
        border: 1px solid #ff4d4d;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 13px;
        transition: 0.3s;
        font-weight: bold;
        display: inline-block;
    }
    .btn-del:hover { background:#ff4d4d; color:#fff; }

    .btn-edit {
        color: #1976d2;
        text-decoration: none;
        border: 1px solid #1976d2;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 13px;
        transition: 0.3s;
        font-weight: bold;
        cursor: pointer;
        background: none;
        font-family: inherit;
        display: inline-block;
        margin-left: 5px;
    }
    .btn-edit:hover { background: #1976d2; color: #fff; }

    .btn-reply {
        color: var(--green);
        border: 1px solid var(--green);
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 13px;
        transition: 0.3s;
        font-weight: bold;
        cursor: pointer;
        background: none;
        font-family: inherit;
        margin-left: 5px;
        display: inline-block;
    }
    .btn-reply:hover { background: var(--green); color: #fff; }

    /* ===== زر التعطيل / التفعيل المحسّن ===== */
    .btn-toggle {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        font-family: inherit;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        white-space: nowrap;
    }

    .btn-toggle.deactivate {
        background: linear-gradient(135deg, #ff9800, #f57c00);
        color: #fff;
    }
    .btn-toggle.deactivate:hover {
        background: linear-gradient(135deg, #f57c00, #e65100);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(255,152,0,0.4);
    }

    .btn-toggle.activate {
        background: linear-gradient(135deg, #4caf50, #388e3c);
        color: #fff;
    }
    .btn-toggle.activate:hover {
        background: linear-gradient(135deg, #388e3c, #2e7d32);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(76,175,80,0.4);
    }

    /* شارة الحالة */
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: bold;
    }
    .status-active   { background:#e8f5e9; color:#2e7d32; }
    .status-inactive { background:#fff3e0; color:#e65100; }

    .badge-user {
        background: var(--dark);
        color: #fff;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
    }

    .badge-type {
        background: var(--tiffany);
        color: var(--dark);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-role {
        background: #e0f2f1;
        color: var(--dark);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
    }

    /* ===== MODAL (مشترك) ===== */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
        justify-content: center;
        align-items: center;
    }
    .modal-overlay.open { display: flex; }

    .modal-box {
        background: #fff;
        padding: 30px;
        border-radius: 18px;
        width: 500px;
        max-width: 95%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .modal-box h3 {
        color: var(--dark);
        margin-bottom: 20px;
        border-bottom: 2px solid var(--tiffany);
        padding-bottom: 10px;
    }

    .modal-box label {
        font-size: 13px;
        color: #666;
        display: block;
        margin-bottom: 5px;
        margin-top: 12px;
    }

    .modal-box input,
    .modal-box textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #81d8d0;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        outline: none;
    }
    .modal-box textarea { resize: vertical; height: 120px; }

    .modal-footer {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn-cancel {
        padding: 10px 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: none;
        cursor: pointer;
        font-family: inherit;
    }

    /* فاصل الأزرار */
    .actions { display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; }

    /* ===== زر تشغيل الفيديو ===== */
    .btn-play {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        background: linear-gradient(135deg, #198e80, #0e4a43);
        color: #fff;
        border: none;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.25s;
        box-shadow: 0 2px 8px rgba(14,74,67,0.3);
    }
    .btn-play:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(14,74,67,0.4);
    }

    /* ===== رفع الملف ===== */
    .file-label {
        display: inline-flex;
        align-items: center;
        gap: 0;
        flex: 1;
        min-width: 180px;
        cursor: pointer;
    }
    .file-label span {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid #81d8d0;
        border-radius: 8px;
        background: #f9fdfd;
        font-size: 14px;
        color: #555;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: border-color 0.2s;
    }
    .file-label:hover span { border-color: var(--green); }
    .file-label input[type="file"] { display: none; }

    /* ===== القائمة المنسدلة للجداول ===== */
    .toggle-list-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 20px;
        background: #f0fafa;
        border: 2px solid var(--tiffany);
        border-radius: 10px;
        color: var(--dark);
        font-family: inherit;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.25s ease;
        margin-bottom: 14px;
    }
    .toggle-list-btn:hover {
        background: var(--tiffany);
        color: var(--dark);
    }
    .toggle-list-btn .arrow {
        display: inline-block;
        transition: transform 0.3s ease;
        font-style: normal;
    }
    .toggle-list-btn.open .arrow { transform: rotate(180deg); }

    .collapsible-table {
        display: none;
        animation: fadeSlide 0.3s ease;
    }
    .collapsible-table.open { display: block; }

    @keyframes fadeSlide {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .list-count {
        background: var(--green);
        color: #fff;
        border-radius: 20px;
        font-size: 12px;
        padding: 2px 9px;
        font-weight: bold;
    }
</style>
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <h2>شفاء موف</h2>
    <a href="index.php">🏠 الصفحة الرئيسية</a>
    <a href="#chart-box">📊 الإحصائيات</a>
    <a href="#ex">🎥 التمارين</a>
    <a href="#tl">🩺 الأدوات</a>
    <a href="#cn">📍 المراكز</a>
    <a href="#us">👥 المستخدمين</a>
    <a href="#ms">💬 الرسائل</a>
    <a href="#fav">⭐ المفضلات</a>
    <a href="admin.php?logout=1" class="out">🚪 خروج</a>
</div>

<!-- ===== MAIN ===== -->
<div class="main-content">

    <div class="welcome-msg">
        <h1>لوحة التحكم</h1>
        <p>إدارة بيانات منصة شفاء موف</p>
    </div>

    <!-- الإحصائيات -->
    <div class="box" id="chart-box">
        <h3>📊 إحصائيات</h3>
        <canvas id="chart" height="70"></canvas>
    </div>

    <!-- ===== التمارين ===== -->
    <div class="box" id="ex">
        <h3>🎥 التمارين والفيديوهات</h3>
        <form method="POST" class="add-form">
            <input name="video_title"  placeholder="عنوان الفيديو" required>
            <input name="video_source" placeholder="المصدر" required>
            <input name="video_url" placeholder="اسم الملف مثل: video_1.mp4" required>
            <button class="btn-add" name="add_video">➕ إضافة</button>
        </form>

        <?php
        $videos    = mysqli_query($conn, "SELECT * FROM videos_content ORDER BY id DESC");
        $cnt_videos = mysqli_num_rows($videos);
        ?>
        <button class="toggle-list-btn" onclick="toggleList('list-videos', this)">
            📋 عرض القائمة
            <span class="list-count"><?= $cnt_videos ?></span>
            <i class="arrow">▼</i>
        </button>

        <div class="collapsible-table" id="list-videos">
        <table>
            <tr><th>العنوان</th><th>المصدر</th><th>الرابط</th><th>إجراء</th></tr>
            <?php while($v = mysqli_fetch_assoc($videos)): ?>
            <tr>
                <td><b><?= htmlspecialchars($v['video_title']) ?></b></td>
                <td><?= htmlspecialchars($v['video_source']) ?></td>
                <td>
                    <?php $vfile = 'Vid/' . $v['video_url']; ?>
                    <button class="btn-play" onclick="playVideo('<?= htmlspecialchars($vfile, ENT_QUOTES) ?>')">
                        ▶ تشغيل
                    </button>
                </td>
                <td>
                    <div class="actions">
                        <button class="btn-edit" onclick="openEditVideo(
                            <?= $v['id'] ?>,
                            '<?= htmlspecialchars($v['video_title'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($v['video_source'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($v['video_url'], ENT_QUOTES) ?>'
                        )">✏️ تعديل</button>
                        <a href="admin.php?del=<?= $v['id'] ?>&type=ex" class="btn-del" onclick="return confirm('حذف؟')">🗑 حذف</a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        </div>
    </div>

    <!-- ===== الأدوات ===== -->
    <div class="box" id="tl">
        <h3>🩺 الأدوات الطبية</h3>
        <form method="POST" class="add-form">
            <input name="tool_name" placeholder="اسم الأداة" required>
            <input name="tool_desc" placeholder="الوصف" required>
            <button class="btn-add" name="add_tool">➕ إضافة</button>
        </form>

        <?php
        $tools     = mysqli_query($conn, "SELECT * FROM medical_tools ORDER BY id DESC");
        $cnt_tools = mysqli_num_rows($tools);
        ?>
        <button class="toggle-list-btn" onclick="toggleList('list-tools', this)">
            📋 عرض القائمة
            <span class="list-count"><?= $cnt_tools ?></span>
            <i class="arrow">▼</i>
        </button>

        <div class="collapsible-table" id="list-tools">
        <table>
            <tr><th>اسم الأداة</th><th>الوصف</th><th>تاريخ الإضافة</th><th>إجراء</th></tr>
            <?php while($t = mysqli_fetch_assoc($tools)): ?>
            <tr>
                <td><b><?= htmlspecialchars($t['tool_name']) ?></b></td>
                <td><?= htmlspecialchars($t['tool_desc']) ?></td>
                <td style="font-size:12px; color:#888;">
                    <?= isset($t['created_at']) ? date('Y/m/d', strtotime($t['created_at'])) : '—' ?>
                </td>
                <td>
                    <div class="actions">
                        <button class="btn-edit" onclick="openEditTool(
                            <?= $t['id'] ?>,
                            '<?= htmlspecialchars($t['tool_name'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($t['tool_desc'], ENT_QUOTES) ?>'
                        )">✏️ تعديل</button>
                        <a href="admin.php?del=<?= $t['id'] ?>&type=tl" class="btn-del" onclick="return confirm('حذف؟')">🗑 حذف</a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        </div>
    </div>

    <!-- ===== المراكز ===== -->
    <div class="box" id="cn">
        <h3>📍 مراكز العلاج</h3>
        <form method="POST" class="add-form">
            <input name="center_title" placeholder="اسم المركز" required>
            <input name="center_phone" placeholder="الهاتف" required>
            <button class="btn-add" name="add_center">➕ إضافة</button>
        </form>

        <?php
        $centers     = mysqli_query($conn, "SELECT * FROM centers_services ORDER BY id DESC");
        $cnt_centers = mysqli_num_rows($centers);
        ?>
        <button class="toggle-list-btn" onclick="toggleList('list-centers', this)">
            📋 عرض القائمة
            <span class="list-count"><?= $cnt_centers ?></span>
            <i class="arrow">▼</i>
        </button>

        <div class="collapsible-table" id="list-centers">
        <table>
            <tr><th>اسم المركز</th><th>الهاتف</th><th>إجراء</th></tr>
            <?php while($c = mysqli_fetch_assoc($centers)): ?>
            <tr>
                <td><b><?= htmlspecialchars($c['title']) ?></b></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td>
                    <div class="actions">
                        <button class="btn-edit" onclick="openEditCenter(
                            <?= $c['id'] ?>,
                            '<?= htmlspecialchars($c['title'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($c['phone'], ENT_QUOTES) ?>'
                        )">✏️ تعديل</button>
                        <a href="admin.php?del=<?= $c['id'] ?>&type=cn" class="btn-del" onclick="return confirm('حذف؟')">🗑 حذف</a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        </div>
    </div>

    <!-- ===== المستخدمين ===== -->
    <div class="box" id="us">
        <h3>👥 المستخدمين</h3>
        <table>
            <tr><th>الاسم</th><th>البريد</th><th>الدور</th><th>الحالة</th><th>تاريخ التسجيل</th><th>إجراء</th></tr>
            <?php while($u = mysqli_fetch_assoc($users)): 
                $status     = $u['status'] ?? 'active';
                $is_active  = ($status === 'active');
            ?>
            <tr>
                <td><b><?= htmlspecialchars($u['user_name']) ?></b></td>
                <td style="font-size:12px; color:#666;"><?= htmlspecialchars($u['email']) ?></td>
                <td><span class="badge-role"><?= htmlspecialchars($u['role']) ?></span></td>
                <td>
                    <span class="status-badge <?= $is_active ? 'status-active' : 'status-inactive' ?>">
                        <?= $is_active ? '✅ مفعّل' : '🚫 معطّل' ?>
                    </span>
                </td>
                <td style="font-size:12px; color:#888;">
                    <?= isset($u['created_at']) ? date('Y/m/d', strtotime($u['created_at'])) : '—' ?>
                </td>
                <td>
                    <div class="actions">
                        <a href="admin.php?toggle_status=<?= $u['id'] ?>&current_status=<?= $status ?>"
                           class="btn-toggle <?= $is_active ? 'deactivate' : 'activate' ?>"
                           onclick="return confirm('<?= $is_active ? 'تعطيل هذا المستخدم؟' : 'تفعيل هذا المستخدم؟' ?>')">
                            <?= $is_active ? '🔒 تعطيل' : '🔓 تفعيل' ?>
                        </a>
                        <a href="admin.php?del=<?= $u['id'] ?>&type=us" class="btn-del" onclick="return confirm('حذف؟')">🗑 حذف</a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- ===== الرسائل ===== -->
    <div class="box" id="ms">
        <h3>💬 رسائل التواصل</h3>
        <table>
            <tr>
                <th>الاسم</th>
                <th>البريد</th>
                <th>الموضوع</th>
                <th>الرسالة</th>
                <th>التاريخ</th>
                <th>إجراء</th>
            </tr>
            <?php if(mysqli_num_rows($msgs) > 0): ?>
                <?php while($m = mysqli_fetch_assoc($msgs)): ?>
                <tr>
                    <td><?= htmlspecialchars($m['full_name']) ?></td>
                    <td style="font-size:12px; color:#666;"><?= htmlspecialchars($m['email']) ?></td>
                    <td><?= htmlspecialchars($m['subject'] ?? '—') ?></td>
                    <td style="text-align:right; max-width:200px;"><?= htmlspecialchars($m['message'] ?? '') ?></td>
                    <td style="font-size:12px; color:#888;">
                        <?= isset($m['created_at']) ? date('Y/m/d H:i', strtotime($m['created_at'])) : '—' ?>
                    </td>
                    <td>
                        <div class="actions">
                            <button class="btn-reply" onclick="openReply(
                                '<?= htmlspecialchars($m['email'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($m['full_name'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($m['message'] ?? '', ENT_QUOTES) ?>'
                            )">↩ رد</button>
                            <a href="admin.php?del=<?= $m['id'] ?>&type=ms" class="btn-del" onclick="return confirm('حذف؟')">🗑 حذف</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="color:#888;">لا توجد رسائل</td></tr>
            <?php endif; ?>
        </table>
    </div>

    <!-- ===== المفضلات ===== -->
    <div class="box" id="fav" style="border-top:6px solid var(--green);">
        <h3 style="color:var(--green);">⭐ سجل مفضلات المستخدمين</h3>
        <table>
            <tr>
                <th>المستخدم</th>
                <th>نوع المحتوى</th>
                <th>الاسم المختار</th>
                <th>إجراء</th>
            </tr>
            <?php if(mysqli_num_rows($favs) > 0): ?>
                <?php while($f = mysqli_fetch_assoc($favs)): ?>
                <tr>
                    <td><span class="badge-user"><?= htmlspecialchars($f['user_name'] ?? 'مستخدم عام') ?></span></td>
                    <td><span class="badge-type"><?= !empty($f['video_id']) ? 'تمرين فيديو' : 'أداة طبية' ?></span></td>
                    <td><b><?= htmlspecialchars($f['video_title'] ?? $f['tool_name'] ?? '—') ?></b></td>
                    <td><a href="admin.php?del=<?= $f['id'] ?>&type=fav" class="btn-del" onclick="return confirm('حذف؟')">🗑 حذف</a></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="color:#888;">لا توجد سجلات مفضلات</td></tr>
            <?php endif; ?>
        </table>
    </div>

</div>

<!-- ===== مودال تشغيل الفيديو ===== -->
<div class="modal-overlay" id="video-player-modal">
    <div class="modal-box" style="width:700px; background:#000; padding:15px; border-radius:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
            <span style="color:#81d8d0; font-weight:bold; font-size:15px;">▶ مشغّل الفيديو</span>
            <button onclick="closeVideo()" style="background:none; border:none; color:#fff; font-size:22px; cursor:pointer; line-height:1;">✕</button>
        </div>
        <video id="main-video-player" width="100%" controls style="border-radius:10px; max-height:420px; display:block;">
            
        </video>
    </div>
</div>

<!-- ===== مودال تعديل فيديو ===== -->
<div class="modal-overlay" id="edit-video-modal">
    <div class="modal-box">
        <h3>✏️ تعديل الفيديو</h3>
        <form method="POST">
            <input type="hidden" name="edit_id" id="ev-id">
            <label>عنوان الفيديو</label>
            <input type="text" name="video_title" id="ev-title" required>
            <label>المصدر</label>
            <input type="text" name="video_source" id="ev-source" required>
            <label>رابط الفيديو</label>
            <input type="url" name="video_url" id="ev-url" required>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('edit-video-modal')">إلغاء</button>
                <button type="submit" class="btn-add" name="edit_video">💾 حفظ التعديل</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== مودال تعديل أداة ===== -->
<div class="modal-overlay" id="edit-tool-modal">
    <div class="modal-box">
        <h3>✏️ تعديل الأداة الطبية</h3>
        <form method="POST">
            <input type="hidden" name="edit_id" id="et-id">
            <label>اسم الأداة</label>
            <input type="text" name="tool_name" id="et-name" required>
            <label>الوصف</label>
            <input type="text" name="tool_desc" id="et-desc" required>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('edit-tool-modal')">إلغاء</button>
                <button type="submit" class="btn-add" name="edit_tool">💾 حفظ التعديل</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== مودال تعديل مركز ===== -->
<div class="modal-overlay" id="edit-center-modal">
    <div class="modal-box">
        <h3>✏️ تعديل المركز</h3>
        <form method="POST">
            <input type="hidden" name="edit_id" id="ec-id">
            <label>اسم المركز</label>
            <input type="text" name="center_title" id="ec-title" required>
            <label>الهاتف</label>
            <input type="text" name="center_phone" id="ec-phone" required>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('edit-center-modal')">إلغاء</button>
                <button type="submit" class="btn-add" name="edit_center">💾 حفظ التعديل</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== مودال الرد على رسالة ===== -->
<div class="modal-overlay" id="reply-modal">
    <div class="modal-box">
        <h3>↩ رد على الرسالة</h3>
        <div id="orig-msg" style="background:#f0fafa; border-right:4px solid var(--tiffany); padding:12px; border-radius:8px; font-size:13px; color:#444; margin-bottom:10px;"></div>
        <label>إلى:</label>
        <input type="email" id="reply-to" readonly>
        <label>الموضوع:</label>
        <input type="text" id="reply-sub">
        <label>نص الرد:</label>
        <textarea id="reply-body"></textarea>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('reply-modal')">إلغاء</button>
            <button class="btn-add" onclick="sendReply()">إرسال ✉️</button>
        </div>
    </div>
</div>

<script>
// ===== مشغّل الفيديو =====
function playVideo(src) {
    const player = document.getElementById('main-video-player');
    player.src = src;
    player.load();
    openModal('video-player-modal');
}
function closeVideo() {
    const player = document.getElementById('main-video-player');
    player.pause();
    player.src = '';
    closeModal('video-player-modal');
}

// ===== القائمة المنسدلة =====
function toggleList(listId, btn) {
    const list = document.getElementById(listId);
    list.classList.toggle('open');
    btn.classList.toggle('open');
    btn.childNodes.forEach(n => {
        if (n.nodeType === 3 && n.textContent.trim()) {
            n.textContent = list.classList.contains('open') ? ' إخفاء القائمة ' : ' عرض القائمة ';
        }
    });
}

// ===== الرسم البياني =====
new Chart(document.getElementById('chart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: ['التمارين', 'الأدوات', 'المراكز', 'المستخدمين', 'الرسائل', 'المفضلات'],
        datasets: [{
            data: [<?= $c_videos ?>, <?= $c_tools ?>, <?= $c_centers ?>, <?= $c_users ?>, <?= $c_msgs ?>, <?= $c_favs ?>],
            backgroundColor: ['#81d8d0','#198e80','#0e4a43','#44969F','#c8f0ec','#198e80'],
            borderColor: '#0e4a43',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        scales: { y: { beginAtZero: true } },
        plugins: { legend: { display: false } }
    }
});

// ===== دوال مشتركة =====
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

// إغلاق بالضغط خارج المودال
document.querySelectorAll('.modal-overlay').forEach(function(m) {
    m.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

// ===== تعديل فيديو =====
function openEditVideo(id, title, source, url) {
    document.getElementById('ev-id').value     = id;
    document.getElementById('ev-title').value  = title;
    document.getElementById('ev-source').value = source;
    document.getElementById('ev-url').value    = url;
    openModal('edit-video-modal');
}

// ===== تعديل أداة =====
function openEditTool(id, name, desc) {
    document.getElementById('et-id').value   = id;
    document.getElementById('et-name').value = name;
    document.getElementById('et-desc').value = desc;
    openModal('edit-tool-modal');
}

// ===== تعديل مركز =====
function openEditCenter(id, title, phone) {
    document.getElementById('ec-id').value    = id;
    document.getElementById('ec-title').value = title;
    document.getElementById('ec-phone').value = phone;
    openModal('edit-center-modal');
}

// ===== الرد على رسالة =====
function openReply(email, name, msg) {
    document.getElementById('reply-to').value  = email;
    document.getElementById('reply-sub').value = 'ردّ على رسالتك';
    document.getElementById('reply-body').value = '';
    document.getElementById('orig-msg').innerHTML = '<strong>رسالة ' + name + ':</strong><br>' + msg;
    openModal('reply-modal');
}

function sendReply() {
    const body = document.getElementById('reply-body').value.trim();
    if (!body) { alert('اكتبي نص الرد'); return; }
    const to  = document.getElementById('reply-to').value;
    const sub = document.getElementById('reply-sub').value;
    window.location.href = 'mailto:' + to + '?subject=' + encodeURIComponent(sub) + '&body=' + encodeURIComponent(body);
    closeModal('reply-modal');
}
</script>

</body>
</html>