CREATE DATABASE gis;
USE gis;
-- 1. 先創建 location 表
CREATE TABLE location (
    location_id INT PRIMARY KEY AUTO_INCREMENT,       -- 地點ID，主鍵
    city VARCHAR(255) NOT NULL,                       -- 城市
    district VARCHAR(255) NOT NULL,                   -- 區
    address VARCHAR(255) NOT NULL,                    -- 地址
    coordinates POINT                                 -- 坐標（經緯度）
);

-- 2. 創建 temple_history 表
CREATE TABLE temple_history (
    temple_history_id INT PRIMARY KEY AUTO_INCREMENT,  -- 廟宇歷史ID，主鍵
    temple_id INT,                                     -- 廟宇ID
    organization_type VARCHAR(255),                    -- 組織形式
    established_date DATE,                             -- 創建日期
    historical_background TEXT,                        -- 歷史背景
    building_type VARCHAR(255),                        -- 建築類型
    appearance TEXT,                                   -- 外觀描述
    remarks TEXT,                                      -- 備註
    website VARCHAR(255),                              -- 網站
    uploader VARCHAR(255),                             -- 上傳者
    image VARCHAR(255)                                 -- 圖片
);

-- 3. 創建 temple 表（現在可以正常引用 location 和 temple_history 表）
CREATE TABLE temple (
    temple_id INT PRIMARY KEY AUTO_INCREMENT,        -- 廟宇ID，主鍵
    location_id INT,                                 -- 地點ID，外鍵
    temple_name VARCHAR(255) NOT NULL,               -- 廟宇名稱
    temple_deity VARCHAR(255),                       -- 廟宇主祀神祇
    temple_history_id INT,                           -- 廟宇歷史ID，外鍵
    phone VARCHAR(20),                               -- 電話
    opening_hours VARCHAR(255),                      -- 開放時間
    FOREIGN KEY (location_id) REFERENCES location(location_id),    -- 外鍵關聯 location 表
    FOREIGN KEY (temple_history_id) REFERENCES temple_history(temple_history_id)  -- 外鍵關聯 temple_history 表
);

-- 4. 創建 deity 表
CREATE TABLE deity (
    deity_id INT PRIMARY KEY AUTO_INCREMENT,         -- 神祇ID，主鍵
    deity_name VARCHAR(255) NOT NULL,                -- 神祇名稱
    religion VARCHAR(255)                            -- 所屬宗教
);

-- 5. 創建 temple_deity 表
CREATE TABLE temple_deity (
    temple_deity_id INT PRIMARY KEY AUTO_INCREMENT,  -- 廟宇神祇ID，主鍵
    temple_id INT,                                   -- 廟宇ID，外鍵
    deity_id INT,                                    -- 神祇ID，外鍵
    is_main_deity TINYINT(1) NOT NULL,               -- 是否為主祀神祇（1=主祀，0=配祀）
    FOREIGN KEY (temple_id) REFERENCES temple(temple_id),   -- 外鍵關聯 temple 表
    FOREIGN KEY (deity_id) REFERENCES deity(deity_id)      -- 外鍵關聯 deity 表
);
