ALTER TABLE location ADD COLUMN temple_id INT;
INSERT INTO deity (deity_name, religion) VALUES 
('驪山姥姆大天尊', '道教'),
('驪山老母', '民間信仰'),
('樊梨花元帥', '民間信仰'),
('九天玄女娘娘', '民間信仰'),
('虛空地母娘娘', '民間信仰'),
('濟公活佛', '民間信仰'),
('五令旗', '民間信仰'),
('千手觀音', '民間信仰'),
('中壇元帥', '民間信仰'),
('福德正神', '民間信仰'),
('觀音菩薩', '佛教'),
('註生娘娘', '道教'),
('天上聖母', '道教'),
('三清', '道教') ;

INSERT INTO location (city, district, address, coordinates) VALUES 
('臺北市', '士林區', '臺北市士林區通河西街四段116巷9號', POINT(121.5053077, 25.0932239)),
('新北市', '新莊區', '新北市新莊區西盛街245巷27弄15號', POINT(121.429228, 25.016638)),
('新北市', '三重區', '新北市三重區河邊北街190號', POINT(121.502514, 25.073896)),
('新北市', '永和區', '新北市永和區永貞路70巷18號', POINT(121.5207954, 25.0070653)),
('新北市', '新店區', '新北市新店區中華路42巷25號', POINT(121.5408649, 24.9690533)),
('高雄市', '旗山區', '高雄市旗山區中洲里文和巷60號', POINT(120.4719442, 22.8454475)),
('高雄市', '旗山區', '高雄市旗山區大山里旗南二路120號', POINT(120.4657841, 22.8481528)),
('高雄市', '鳳山區', '高雄市鳳山區自立街68之2號', POINT(120.353767, 22.628595)) ;


INSERT INTO temple (location_id, temple_name, phone, opening_hours) VALUES 
(1, '社子無極梨武宮', NULL, NULL),
(2, '新莊樊元宮', NULL, NULL),
(3, '三重泓法慈靈宮', NULL, NULL),
(4, '永和驪山太元宮', NULL, '每週六下午2點至4點'),
(5, '先天受天宿鳳宮', NULL, NULL),
(6, '靈山紫南宮', NULL, NULL),
(7, '無極慈慧宮', NULL, NULL),
(8, '紫清宮', NULL, NULL) ;


INSERT INTO temple_deity (temple_id, deity_id, is_main_deity) VALUES 
(1, 1, 1), -- 社子無極梨武宮主祀驪山姥姆大天尊
(2, 2, 1), -- 新莊樊元宮主祀驪山老母
(2, 3, 0), -- 新莊樊元宮配祀樊梨花元帥
(3, 2, 1), -- 三重泓法慈靈宮主祀驪山老母
(4, 2, 1), -- 永和驪山太元宮主祀驪山老母
(4, 11, 0), -- 永和驪山太元宮配祀媽祖
(5, 2, 1), -- 先天受天宿鳳宮主祀驪山老母
(5, 4, 0), -- 先天受天宿鳳宮配祀九天玄女娘娘
(5, 5, 0), -- 先天受天宿鳳宮配祀虛空地母娘娘
(6, 2, 1), -- 靈山紫南宮主祀驪山老母
(6, 6, 0), -- 靈山紫南宮配祀濟公活佛
(6, 7, 0), -- 靈山紫南宮配祀五令旗
(6, 8, 0), -- 靈山紫南宮配祀千手觀音
(6, 9, 0), -- 靈山紫南宮配祀中壇元帥
(6, 10, 0), -- 靈山紫南宮配祀福德正神
(7, 2, 1), -- 無極慈慧宮主祀驪山老母
(8, 2, 1), -- 紫清宮主祀驪山老母
(8, 10, 0) ; -- 紫清宮配祀福德正神


INSERT INTO temple_history (temple_id, organization_type, established_date, historical_background, building_type, remarks, website, uploader) VALUES 
(1, '民間信仰', NULL, NULL, '平房、公寓、大樓等建物作為住家、工廠或其他用途之場所內', NULL, 'https://gisrl.ascdc.sinica.edu.tw/religiontw/?q=node/4333', '王方元'),
(2, '民間信仰', NULL, NULL, '平房、公寓、大樓等建物作為住家、工廠或其他用途之場所內', NULL, 'https://gisrl.ascdc.sinica.edu.tw/religiontw/?q=node/340', '楊士霈'),
(3, '民間信仰', NULL, NULL, '平房、公寓、大樓等建物作為住家、工廠或其他用途之場所內', '位於公寓一樓', 'https://gisrl.ascdc.sinica.edu.tw/religiontw/?q=node/1024', '王方元'),
(4, '民間信仰', NULL, '主祀神從台南南化葫蘆山的驪山老母宮總廟分靈而來。 配祀媽祖由斗南順安宮分靈而來。', '平房、公寓、大樓等建物作為住家、工廠或其他用途之場所內', NULL, 'https://gisrl.ascdc.sinica.edu.tw/religiontw/?q=node/5432', '洪季廷'),
(5, '民間信仰', NULL, NULL, '平房、公寓、大樓等建物作為住家、工廠或其他用途之場所內', NULL, 'https://gisrl.ascdc.sinica.edu.tw/religiontw/?q=node/6831', '鄒博翔'),
(6, '民間信仰', NULL, '位於民宅內，金爐位於對面，與廟相隔一條馬路。', '獨立或獨棟（獨立空間，如宮廟、寺院、壇觀、教會、教堂、禮拜堂等）', NULL, 'https://gisrl.ascdc.sinica.edu.tw/religiontw/?q=node/8179', '道宏'),
(7, '民間信仰', NULL, '屋主不允許入內拍照。', '平房、公寓、大樓等建物作為住家、工廠或其他用途之場所內', NULL, 'https://gisrl.ascdc.sinica.edu.tw/religiontw/?q=node/8643', '道宏'),
(8, '民間信仰', '1997', NULL, '平房、公寓、大樓等建物作為住家、工廠或其他用途之場所內', NULL, 'https://gisrl.ascdc.sinica.edu.tw/religiontw/?q=node/11294', '黃頎為') ;
