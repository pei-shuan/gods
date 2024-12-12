<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>地景GIS平台 - 神明</title>
    <!-- FontAwesome CDN for search icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #FDF8F1;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* 導覽列 */
        .navbar {
            background-color: #F2D3A4;
            position: fixed;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar a {
            color: black;
            text-decoration: none;
            margin: 0 15px;
            font-weight: normal;
        }

        .navbar a:hover {
            background-color: white;
            padding: 5px;
        }

        .navbar a.active {
            font-weight: bold;
        }

        .navbar .logo {
            font-size: 20px;
            font-weight: bold;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -250px;
            width: 250px;
            height: 100%;
            background-color: #F2D3A4;
            color: black;
            transition: right 0.3s ease;
            z-index: 1500;
            padding-top: 60px;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
        }

        .sidebar a {
            padding: 15px 25px;
            display: block;
            font-size: 16px;
            color: black;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .sidebar a i {
            margin-right: 8px;
        }

        .sidebar a:hover {
            background-color: #EEE;
        }

        .sidebar .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }

        /* 主體內容 */
        .content {
            flex: 1;
            padding: 70px 20px 60px;
            display: flex;
            justify-content: center;
        }

        /* 查詢區域 */
        .search-section {
            width: 97.5%;
            max-width: 1500px;
            background-color: white;
            margin-top: 2.5%;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* 標題切換區 */
        .title-switch {
            display: flex;
            justify-content: flex-start;
            /* 將標題移到左邊 */
            margin-bottom: 20px;
            margin-top: -10px;
            /* 調整與頂部距離 */
        }

        .title-switch h2 {
            cursor: pointer;
            padding: 10px 20px;
            margin: 0;
            /* 去掉間距 */
            border-bottom: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .title-switch h2.active {
            border-color: #000;
            /* 高亮顏色 */
        }

        /* 查詢區塊與標題的定位調整 */
        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-wrapper input {
            flex: 1;
            padding: 10px;
            padding-right: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-wrapper .fa-search {
            position: absolute;
            right: 10px;
            color: #007bff;
            cursor: pointer;
        }

        /* 資料列表 */
        .data-header,
        .data-row {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .data-header {
            font-weight: bold;
            background-color: #eee;
        }

        .data-row:hover {
            background-color: #ddd;
        }

        /* 將欄位內容首字對齊 */
        .data-row div,
        .data-header div {
            text-align: left;
            flex: 1;
        }

        /* 分頁 */
        .pagination {
            margin-top: 20px;
            text-align: right;
        }

        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            text-decoration: none;
            background-color: #EEA970;
            color: white;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #555;
        }

        .pagination a.active {
            background-color: #555;
            color: white;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- 導覽列 -->
    <div class="navbar">
        <a href="homepage.html"><img src="Img/logo.png" style=" width: 7%; height: 15%;">
            <img src="Img/Gis of gods.png" style=" width: 15%; height: 12%; margin-right: 76%; margin-top: 1.5%;">
        </a>
        <div>
            <a href="homepage.html">首頁</a>
            <a href="count_gods.php" class="active">崇敬對象</a>
            <a href="gods_chatroom.html">問事</a>
            <i class="fas fa-bars" id="menu-icon" style="cursor: pointer; color: black;"></i>
        </div>
    </div>

    <!-- 側邊欄 -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" id="close-btn">&times;</span>
        <a href="manager_login.html"><i class="fas fa-user-cog"></i> 管理者</a>
        <a href="#">設定</a>
        <a href="#">幫助</a>
        <a href="#">聯繫我們</a>
    </div>

    <!-- 主要內容 -->
    <div class="content">
    <!-- 查詢區塊內的標題切換 -->
    <div class="search-section">
        <div class="title-switch">
            <h2 id="worship-title" class="active">崇敬對象</h2>
            <h2 id="temple-title">廟宇查詢</h2>
        </div>

        <!-- 崇敬對象查詢區塊 -->
        <div class="search-section" id="worship-section">
            <div class="search-wrapper">
                <input type="text" id="searchKeyword" placeholder="名稱搜尋">
                <button onclick="searchWorshipData()"><i class="fas fa-search"></i></button>
            </div>

            <!-- 崇敬對象資料列表 -->
            <div class="data-header">
                <div>編號</div>
                <div>名稱</div>
                <div>其他資料</div>
            </div>
            <div id="worship-data-list"></div>

            <!-- 崇敬對象分頁 -->
            <div class="pagination" id="worship-pagination"></div>
        </div>

        <!-- 廟宇查詢區塊 -->
        <div class="search-section" id="temple-section" style="display: none;">
            <div class="search-wrapper">
                <input type="text" id="templeKeyword" placeholder="廟宇名稱搜尋">
                <button onclick="searchTempleData()"><i class="fas fa-search"></i></button>
            </div>

            <!-- 廟宇資料列表 -->
            <div class="data-header">
                <div>廟宇名稱</div>
                <div>地區</div>
                <div>建築年份</div>
            </div>
            <div id="temple-data-list"></div>

            <!-- 廟宇分頁 -->
            <div class="pagination" id="temple-pagination"></div>
        </div>
    </div>
</div>

<script>
    let currentPage = 1;
    const itemsPerPage = 8;

    // 切換顯示的區塊
    document.getElementById('worship-title').addEventListener('click', () => {
        document.getElementById('worship-section').style.display = 'block';
        document.getElementById('temple-section').style.display = 'none';
        document.getElementById('worship-title').classList.add('active');
        document.getElementById('temple-title').classList.remove('active');
        fetchWorshipData(currentPage);
    });

    document.getElementById('temple-title').addEventListener('click', () => {
        document.getElementById('worship-section').style.display = 'none';
        document.getElementById('temple-section').style.display = 'block';
        document.getElementById('temple-title').classList.add('active');
        document.getElementById('worship-title').classList.remove('active');
        fetchTempleData(currentPage);
    });

    // 查詢崇敬對象資料
    function searchWorshipData() {
        const keyword = document.getElementById('searchKeyword').value;
        fetchWorshipData(1, keyword); // 重置到第1頁
    }

    // 查詢廟宇資料
    function searchTempleData() {
    const keyword = document.getElementById('templeKeyword').value.trim(); // 獲取輸入的搜尋關鍵字
    currentPage = 1; // 重置到第一頁
    fetchTempleData(currentPage, keyword); // 傳遞關鍵字到後端
}

function fetchTempleData(page, keyword = "") {
    fetch(`getTempleData.php?keyword=${encodeURIComponent(keyword)}`)
        .then(response => response.json())
        .then(data => {
            displayTempleData(data, page);
            setupPagination(data.length, 'temple-pagination', data, displayTempleData);
        })
        .catch(error => console.error('Error fetching temple data:', error));
}

    // 從資料庫抓取崇敬對象資料
    function fetchWorshipData(page, keyword = '') {
        fetch(`getWorshipData.php?keyword=${encodeURIComponent(keyword)}`)
            .then(response => response.json())
            .then(data => {
                displayWorshipData(data, page);
                setupPagination(data.length, 'worship-pagination', data, displayWorshipData);
            })
            .catch(error => console.error('Error fetching worship data:', error));
    }

    // 顯示崇敬對象的資料
    function displayWorshipData(data, page) {
        const dataList = document.getElementById('worship-data-list');
        dataList.innerHTML = '';

        // 計算顯示資料的範圍
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;