drop database if EXISTS banh_mi_db;
create database banh_mi_db;
use banh_mi_db;

drop table if exists accounts;
create table accounts (
	user_id int unsigned primary key auto_increment primary key,
	username varchar(50) unique not null,
    password_hash varchar(255) not null,
    role ENUM('user','admin') not null,
    status ENUM('active','deleted') default 'active' not null
);

-- username: admin, password:Admin123.
insert into accounts (username, password_hash, role) values 
('admin','$2a$10$l1YwamIKF6FTsbzJ86WFW.HRWqBzccwiv88qRovaucD.D2B51jZm.', 'admin');


drop table if exists menu;
create table menu (
	item_id int unsigned primary key AUTO_INCREMENT,
    name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
    cate enum('sweet','savory','raw') not null,
	description TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
    image_path VARCHAR(512), 
	price DECIMAL(10,2) NOT NULL CHECK (price >= 0),
    status enum('active','delete') not null DEFAULT 'active'
);

INSERT INTO menu (name, cate, description, image_path, price) VALUES
('Bánh Mì Pa Tê Chả Lụa', 'savory','Bánh mì thơm giòn kết hợp với pa tê béo ngậy và chả lụa mềm mịn, thêm dưa leo, rau thơm và nước sốt đặc trưng.', 'images/banh_mi_pate_cha_lua.jpg', 15000),
('Bánh Mì Thịt Nướng', 'savory','Bánh mì truyền thống với thịt nướng thơm lừng, rau sống tươi mát, đồ chua giòn giòn và nước sốt đậm đà.', 'images/banh_mi_thit_nuong.jpg', 30000),
('Bánh Mì Chả Cá', 'savory', 'Bánh mì nóng giòn kẹp chả cá chiên vàng ruộm, ăn kèm với rau thơm, dưa leo và tương ớt cay nồng.', 'images/banh_mi_cha_ca.jpg', 15000),
('Bánh Mì Heo Quay', 'savory', 'Thịt heo quay giòn bì, mềm ngọt bên trong, kết hợp với dưa leo, hành ngò và nước sốt đặc biệt trong ổ bánh mì giòn rụm.', 'images/banh_mi_heo_quay.jpg', 30000),
('Bánh Mì Xíu Mại', 'savory', 'Bánh mì kẹp xíu mại viên mềm, sốt cà chua đậm đà, thêm hành ngò tạo hương vị thơm ngon khó cưỡng.', 'images/banh_mi_xiu_mai.jpg', 30000),
('Bánh Mì Nướng Bơ Tỏi', 'savory', 'Bánh mì nướng giòn thấm đẫm bơ và tỏi thơm lừng, thích hợp làm món ăn vặt hấp dẫn.', 'images/banh_mi_nuong_bo_toi.jpeg', 30000),
('Bánh Mì Chấm Sữa Đặc', 'sweet', 'Bánh mì giòn chấm sữa đặc béo ngậy, món ăn tuổi thơ gợi nhớ những ký ức đẹp.', 'images/banh_mi_cham_sua_dac.png', 10000),
('Bánh Mì Chảo', 'savory', 'Bánh mì ăn kèm với chảo topping đa dạng như pate, trứng ốp la, xúc xích, thịt nguội và nước sốt đậm đà.', 'images/banh_mi_chao.jpg', 40000),
('Bánh Mì Cay Hải Phòng', 'savory', 'Bánh mì mini giòn tan với nhân pate cay nồng, một đặc sản nổi tiếng của Hải Phòng.', 'images/banh_mi_cay_hai_phong.jpg', 15000),
('Bánh Mì Bột Lọc', 'savory', 'Bánh mì kẹp bánh bột lọc dai dai, nhân tôm thịt đậm đà, hòa quyện với nước mắm chua ngọt.', 'images/banh_mi_bot_loc.jpg', 25000),
('Bánh Mì Ép Huế', 'savory', 'Bánh mì ép giòn rụm, kẹp thịt, pate và rau, được ép nóng để tạo độ giòn đặc trưng.', 'images/banh_mi_ep_hue.jpg', 10000),
('Bánh Mì Gà Xé Đà Nẵng','savory', 'Bánh mì Đà Nẵng với gà xé thơm ngon, rau răm, hành phi và nước sốt cay ngọt hấp dẫn.', 'images/banh_mi_ga_xe_da_nang.jpg', 20000),
('Bánh Mì Phá Lấu', 'savory', 'Bánh mì kẹp phá lấu béo bùi, nước sốt đậm vị, ăn kèm dưa leo và rau thơm.', 'images/banh_mi_pha_lau.jpg', 30000),
('Bánh Mì Hoa Cúc','sweet','Kết cấu mềm, xốp, có bơ thơm béo', 'images/banh_mi_hoa_cuc.jpg',30000),
('Bánh Mì Bơ Đường','sweet','Lớp bơ và đường tan chảy trên mặt bánh tạo độ giòn nhẹ', 'images/banh_mi_bo_duong.jpg',30000),
('Bánh mì nhân kem','sweet','Nhân kem trứng mịn, béo ngậy, có vị sữa dừa', 'images/banh_mi_nhan_kem.jpg',20000),
('Bánh mì nho khô','sweet','Bánh mì mềm kết hợp với vị chua ngọt nhẹ của nho khô', 'images/banh_mi_nho_kho.png',20000),
('Bánh mì kẹp kem','sweet','Sự kết hợp giữa bánh mì giòn rụm và kem lạnh mát, tạo nên sự hòa quyện giữa nóng - lạnh, giòn - mềm vô cùng thú vị', 'images/banh_mi_kep_kem.jpg',15000);




drop table if exists orders;
create table orders (
	order_id int unsigned primary key AUTO_INCREMENT,
    total_price DECIMAL(12,0),
    user_id int unsigned,
    FOREIGN KEY(user_id) references accounts(user_id) on delete set null,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

drop table if exists orders_include_items;
create table orders_include_items (
	order_id int unsigned not null, 
    item_id int unsigned not null,
    quantity int check (quantity>0),
	PRIMARY KEY(order_id,item_id),
	FOREIGN KEY(order_id) references orders(order_id),
    FOREIGN KEY(item_id) references menu(item_id)
);

DELIMITER //

CREATE TRIGGER update_total_price
AFTER INSERT ON orders_include_items
FOR EACH ROW
BEGIN
    UPDATE orders 
    SET total_price = (
        SELECT SUM(quantity * price) 
        FROM orders_include_items oi
        JOIN menu m ON oi.item_id = m.item_id
        WHERE oi.order_id = NEW.order_id
    )
    WHERE order_id = NEW.order_id;
END;

//

DELIMITER ;

drop table if exists in_cart;
create table in_cart (
	user_id int unsigned,
    item_id int unsigned,
    quantity int,
    primary key(user_id,item_id),
    foreign key(user_id) references accounts(user_id) on delete cascade,
    foreign key(item_id) references menu(item_id) on delete cascade
);



SELECT 
	oi.order_id, 
	t.total_price, 
	t.created_at, 
	oi.item_id, 
	i.name AS item_name, 
	i.image_path, 
	i.price, 
	oi.quantity
FROM  
	(SELECT 
		o.order_id, 
		o.total_price, 
		o.created_at
	FROM orders o
	ORDER BY o.created_at DESC
	LIMIT 10 OFFSET 0) t 
JOIN orders_include_items oi ON t.order_id = oi.order_id 
JOIN menu i ON oi.item_id = i.item_id
