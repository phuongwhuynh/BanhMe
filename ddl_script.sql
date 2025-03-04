drop database if EXISTS banh_mi_db;
create database banh_mi_db;
use banh_mi_db;

drop table if exists accounts;
create table accounts (
	username varchar(255) primary key,
    password_hash varchar(255) not null,
    role ENUM('user','admin') not null,
    status ENUM('active','deleted') not null
);

insert into accounts (username,password_hash,role,status) values
('account','password','user','active');


drop table if exists menu;
create table menu (
	item_id int primary key AUTO_INCREMENT,
    name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	description TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    image_path VARCHAR(512), 
	price DECIMAL(10,2) NOT NULL CHECK (price >= 0)
);

INSERT INTO menu (name, description, image_path, price) VALUES
('Bánh Mì Pa Tê Chả Lụa', 'Bánh mì thơm giòn kết hợp với pa tê béo ngậy và chả lụa mềm mịn, thêm dưa leo, rau thơm và nước sốt đặc trưng.', 'images/banh_mi_pate_cha_lua.jpg', 15000),
('Bánh Mì Thịt Nướng', 'Bánh mì truyền thống với thịt nướng thơm lừng, rau sống tươi mát, đồ chua giòn giòn và nước sốt đậm đà.', 'images/banh_mi_thit_nuong.jpg', 30000),
('Bánh Mì Chả Cá', 'Bánh mì nóng giòn kẹp chả cá chiên vàng ruộm, ăn kèm với rau thơm, dưa leo và tương ớt cay nồng.', 'images/banh_mi_cha_ca.jpg', 15000),
('Bánh Mì Heo Quay', 'Thịt heo quay giòn bì, mềm ngọt bên trong, kết hợp với dưa leo, hành ngò và nước sốt đặc biệt trong ổ bánh mì giòn rụm.', 'images/banh_mi_heo_quay.jpg', 30000),
('Bánh Mì Xíu Mại', 'Bánh mì kẹp xíu mại viên mềm, sốt cà chua đậm đà, thêm hành ngò tạo hương vị thơm ngon khó cưỡng.', 'images/banh_mi_xiu_mai.jpg', 30000),
('Bánh Mì Nướng Bơ Tỏi', 'Bánh mì nướng giòn thấm đẫm bơ và tỏi thơm lừng, thích hợp làm món ăn vặt hấp dẫn.', 'images/banh_mi_nuong_bo_toi.jpg', 30000),
('Bánh Mì Chấm Sữa Đặc', 'Bánh mì giòn chấm sữa đặc béo ngậy, món ăn tuổi thơ gợi nhớ những ký ức đẹp.', 'images/banh_mi_cham_sua_dac.jpg', 10000),
('Bánh Mì Chảo', 'Bánh mì ăn kèm với chảo topping đa dạng như pate, trứng ốp la, xúc xích, thịt nguội và nước sốt đậm đà.', 'images/banh_mi_chao.jpg', 40000),
('Bánh Mì Cay Hải Phòng', 'Bánh mì mini giòn tan với nhân pate cay nồng, một đặc sản nổi tiếng của Hải Phòng.', 'images/banh_mi_cay.jpg', 15000),
('Bánh Mì Bột Lọc', 'Bánh mì kẹp bánh bột lọc dai dai, nhân tôm thịt đậm đà, hòa quyện với nước mắm chua ngọt.', 'images/banh_mi_bot_loc.jpg', 25000),
('Bánh Mì Ép Huế', 'Bánh mì ép giòn rụm, kẹp thịt, pate và rau, được ép nóng để tạo độ giòn đặc trưng.', 'images/banh_mi_ep_hue.jpg', 10000),
('Bánh Mì Gà Xé Đà Nẵng', 'Bánh mì Đà Nẵng với gà xé thơm ngon, rau răm, hành phi và nước sốt cay ngọt hấp dẫn.', 'images/banh_mi_ga_xe_da_nang.jpg', 20000),
('Bánh Mì Phá Lấu', 'Bánh mì kẹp phá lấu béo bùi, nước sốt đậm vị, ăn kèm dưa leo và rau thơm.', 'images/banh_mi_pha_lau.jpg', 30000),

('Bánh Mì Pa Tê Chả Lụa', 'Bánh mì thơm giòn kết hợp với pa tê béo ngậy và chả lụa mềm mịn, thêm dưa leo, rau thơm và nước sốt đặc trưng.', 'images/banh_mi_pate_cha_lua.jpg', 15000),
('Bánh Mì Thịt Nướng', 'Bánh mì truyền thống với thịt nướng thơm lừng, rau sống tươi mát, đồ chua giòn giòn và nước sốt đậm đà.', 'images/banh_mi_thit_nuong.jpg', 30000),
('Bánh Mì Chả Cá', 'Bánh mì nóng giòn kẹp chả cá chiên vàng ruộm, ăn kèm với rau thơm, dưa leo và tương ớt cay nồng.', 'images/banh_mi_cha_ca.jpg', 15000),
('Bánh Mì Heo Quay', 'Thịt heo quay giòn bì, mềm ngọt bên trong, kết hợp với dưa leo, hành ngò và nước sốt đặc biệt trong ổ bánh mì giòn rụm.', 'images/banh_mi_heo_quay.jpg', 30000),
('Bánh Mì Xíu Mại', 'Bánh mì kẹp xíu mại viên mềm, sốt cà chua đậm đà, thêm hành ngò tạo hương vị thơm ngon khó cưỡng.', 'images/banh_mi_xiu_mai.jpg', 30000),
('Bánh Mì Nướng Bơ Tỏi', 'Bánh mì nướng giòn thấm đẫm bơ và tỏi thơm lừng, thích hợp làm món ăn vặt hấp dẫn.', 'images/banh_mi_nuong_bo_toi.jpg', 30000),
('Bánh Mì Chấm Sữa Đặc', 'Bánh mì giòn chấm sữa đặc béo ngậy, món ăn tuổi thơ gợi nhớ những ký ức đẹp.', 'images/banh_mi_cham_sua_dac.jpg', 10000),
('Bánh Mì Chảo', 'Bánh mì ăn kèm với chảo topping đa dạng như pate, trứng ốp la, xúc xích, thịt nguội và nước sốt đậm đà.', 'images/banh_mi_chao.jpg', 40000),
('Bánh Mì Cay Hải Phòng', 'Bánh mì mini giòn tan với nhân pate cay nồng, một đặc sản nổi tiếng của Hải Phòng.', 'images/banh_mi_cay.jpg', 15000),
('Bánh Mì Bột Lọc', 'Bánh mì kẹp bánh bột lọc dai dai, nhân tôm thịt đậm đà, hòa quyện với nước mắm chua ngọt.', 'images/banh_mi_bot_loc.jpg', 25000),
('Bánh Mì Ép Huế', 'Bánh mì ép giòn rụm, kẹp thịt, pate và rau, được ép nóng để tạo độ giòn đặc trưng.', 'images/banh_mi_ep_hue.jpg', 10000),
('Bánh Mì Gà Xé Đà Nẵng', 'Bánh mì Đà Nẵng với gà xé thơm ngon, rau răm, hành phi và nước sốt cay ngọt hấp dẫn.', 'images/banh_mi_ga_xe_da_nang.jpg', 20000),
('Bánh Mì Phá Lấu', 'Bánh mì kẹp phá lấu béo bùi, nước sốt đậm vị, ăn kèm dưa leo và rau thơm.', 'images/banh_mi_pha_lau.jpg', 30000),
('Bánh Mì Pa Tê Chả Lụa', 'Bánh mì thơm giòn kết hợp với pa tê béo ngậy và chả lụa mềm mịn, thêm dưa leo, rau thơm và nước sốt đặc trưng.', 'images/banh_mi_pate_cha_lua.jpg', 15000),
('Bánh Mì Thịt Nướng', 'Bánh mì truyền thống với thịt nướng thơm lừng, rau sống tươi mát, đồ chua giòn giòn và nước sốt đậm đà.', 'images/banh_mi_thit_nuong.jpg', 30000),
('Bánh Mì Chả Cá', 'Bánh mì nóng giòn kẹp chả cá chiên vàng ruộm, ăn kèm với rau thơm, dưa leo và tương ớt cay nồng.', 'images/banh_mi_cha_ca.jpg', 15000),
('Bánh Mì Heo Quay', 'Thịt heo quay giòn bì, mềm ngọt bên trong, kết hợp với dưa leo, hành ngò và nước sốt đặc biệt trong ổ bánh mì giòn rụm.', 'images/banh_mi_heo_quay.jpg', 30000),
('Bánh Mì Xíu Mại', 'Bánh mì kẹp xíu mại viên mềm, sốt cà chua đậm đà, thêm hành ngò tạo hương vị thơm ngon khó cưỡng.', 'images/banh_mi_xiu_mai.jpg', 30000),
('Bánh Mì Nướng Bơ Tỏi', 'Bánh mì nướng giòn thấm đẫm bơ và tỏi thơm lừng, thích hợp làm món ăn vặt hấp dẫn.', 'images/banh_mi_nuong_bo_toi.jpg', 30000),
('Bánh Mì Chấm Sữa Đặc', 'Bánh mì giòn chấm sữa đặc béo ngậy, món ăn tuổi thơ gợi nhớ những ký ức đẹp.', 'images/banh_mi_cham_sua_dac.jpg', 10000),
('Bánh Mì Chảo', 'Bánh mì ăn kèm với chảo topping đa dạng như pate, trứng ốp la, xúc xích, thịt nguội và nước sốt đậm đà.', 'images/banh_mi_chao.jpg', 40000),
('Bánh Mì Cay Hải Phòng', 'Bánh mì mini giòn tan với nhân pate cay nồng, một đặc sản nổi tiếng của Hải Phòng.', 'images/banh_mi_cay.jpg', 15000),
('Bánh Mì Bột Lọc', 'Bánh mì kẹp bánh bột lọc dai dai, nhân tôm thịt đậm đà, hòa quyện với nước mắm chua ngọt.', 'images/banh_mi_bot_loc.jpg', 25000),
('Bánh Mì Ép Huế', 'Bánh mì ép giòn rụm, kẹp thịt, pate và rau, được ép nóng để tạo độ giòn đặc trưng.', 'images/banh_mi_ep_hue.jpg', 10000),
('Bánh Mì Gà Xé Đà Nẵng', 'Bánh mì Đà Nẵng với gà xé thơm ngon, rau răm, hành phi và nước sốt cay ngọt hấp dẫn.', 'images/banh_mi_ga_xe_da_nang.jpg', 20000),
('Bánh Mì Phá Lấu', 'Bánh mì kẹp phá lấu béo bùi, nước sốt đậm vị, ăn kèm dưa leo và rau thơm.', 'images/banh_mi_pha_lau.jpg', 30000),
('Bánh Mì Pa Tê Chả Lụa', 'Bánh mì thơm giòn kết hợp với pa tê béo ngậy và chả lụa mềm mịn, thêm dưa leo, rau thơm và nước sốt đặc trưng.', 'images/banh_mi_pate_cha_lua.jpg', 15000),
('Bánh Mì Thịt Nướng', 'Bánh mì truyền thống với thịt nướng thơm lừng, rau sống tươi mát, đồ chua giòn giòn và nước sốt đậm đà.', 'images/banh_mi_thit_nuong.jpg', 30000),
('Bánh Mì Chả Cá', 'Bánh mì nóng giòn kẹp chả cá chiên vàng ruộm, ăn kèm với rau thơm, dưa leo và tương ớt cay nồng.', 'images/banh_mi_cha_ca.jpg', 15000),
('Bánh Mì Heo Quay', 'Thịt heo quay giòn bì, mềm ngọt bên trong, kết hợp với dưa leo, hành ngò và nước sốt đặc biệt trong ổ bánh mì giòn rụm.', 'images/banh_mi_heo_quay.jpg', 30000),
('Bánh Mì Xíu Mại', 'Bánh mì kẹp xíu mại viên mềm, sốt cà chua đậm đà, thêm hành ngò tạo hương vị thơm ngon khó cưỡng.', 'images/banh_mi_xiu_mai.jpg', 30000),
('Bánh Mì Nướng Bơ Tỏi', 'Bánh mì nướng giòn thấm đẫm bơ và tỏi thơm lừng, thích hợp làm món ăn vặt hấp dẫn.', 'images/banh_mi_nuong_bo_toi.jpg', 30000),
('Bánh Mì Chấm Sữa Đặc', 'Bánh mì giòn chấm sữa đặc béo ngậy, món ăn tuổi thơ gợi nhớ những ký ức đẹp.', 'images/banh_mi_cham_sua_dac.jpg', 10000),
('Bánh Mì Chảo', 'Bánh mì ăn kèm với chảo topping đa dạng như pate, trứng ốp la, xúc xích, thịt nguội và nước sốt đậm đà.', 'images/banh_mi_chao.jpg', 40000),
('Bánh Mì Cay Hải Phòng', 'Bánh mì mini giòn tan với nhân pate cay nồng, một đặc sản nổi tiếng của Hải Phòng.', 'images/banh_mi_cay.jpg', 15000),
('Bánh Mì Bột Lọc', 'Bánh mì kẹp bánh bột lọc dai dai, nhân tôm thịt đậm đà, hòa quyện với nước mắm chua ngọt.', 'images/banh_mi_bot_loc.jpg', 25000),
('Bánh Mì Ép Huế', 'Bánh mì ép giòn rụm, kẹp thịt, pate và rau, được ép nóng để tạo độ giòn đặc trưng.', 'images/banh_mi_ep_hue.jpg', 10000),
('Bánh Mì Gà Xé Đà Nẵng', 'Bánh mì Đà Nẵng với gà xé thơm ngon, rau răm, hành phi và nước sốt cay ngọt hấp dẫn.', 'images/banh_mi_ga_xe_da_nang.jpg', 20000),
('Bánh Mì Phá Lấu', 'Bánh mì kẹp phá lấu béo bùi, nước sốt đậm vị, ăn kèm dưa leo và rau thơm.', 'images/banh_mi_pha_lau.jpg', 30000),
('Bánh Mì Pa Tê Chả Lụa', 'Bánh mì thơm giòn kết hợp với pa tê béo ngậy và chả lụa mềm mịn, thêm dưa leo, rau thơm và nước sốt đặc trưng.', 'images/banh_mi_pate_cha_lua.jpg', 15000),
('Bánh Mì Thịt Nướng', 'Bánh mì truyền thống với thịt nướng thơm lừng, rau sống tươi mát, đồ chua giòn giòn và nước sốt đậm đà.', 'images/banh_mi_thit_nuong.jpg', 30000),
('Bánh Mì Chả Cá', 'Bánh mì nóng giòn kẹp chả cá chiên vàng ruộm, ăn kèm với rau thơm, dưa leo và tương ớt cay nồng.', 'images/banh_mi_cha_ca.jpg', 15000),
('Bánh Mì Heo Quay', 'Thịt heo quay giòn bì, mềm ngọt bên trong, kết hợp với dưa leo, hành ngò và nước sốt đặc biệt trong ổ bánh mì giòn rụm.', 'images/banh_mi_heo_quay.jpg', 30000),
('Bánh Mì Xíu Mại', 'Bánh mì kẹp xíu mại viên mềm, sốt cà chua đậm đà, thêm hành ngò tạo hương vị thơm ngon khó cưỡng.', 'images/banh_mi_xiu_mai.jpg', 30000),
('Bánh Mì Nướng Bơ Tỏi', 'Bánh mì nướng giòn thấm đẫm bơ và tỏi thơm lừng, thích hợp làm món ăn vặt hấp dẫn.', 'images/banh_mi_nuong_bo_toi.jpg', 30000),
('Bánh Mì Chấm Sữa Đặc', 'Bánh mì giòn chấm sữa đặc béo ngậy, món ăn tuổi thơ gợi nhớ những ký ức đẹp.', 'images/banh_mi_cham_sua_dac.jpg', 10000),
('Bánh Mì Chảo', 'Bánh mì ăn kèm với chảo topping đa dạng như pate, trứng ốp la, xúc xích, thịt nguội và nước sốt đậm đà.', 'images/banh_mi_chao.jpg', 40000),
('Bánh Mì Cay Hải Phòng', 'Bánh mì mini giòn tan với nhân pate cay nồng, một đặc sản nổi tiếng của Hải Phòng.', 'images/banh_mi_cay.jpg', 15000),
('Bánh Mì Bột Lọc', 'Bánh mì kẹp bánh bột lọc dai dai, nhân tôm thịt đậm đà, hòa quyện với nước mắm chua ngọt.', 'images/banh_mi_bot_loc.jpg', 25000),
('Bánh Mì Ép Huế', 'Bánh mì ép giòn rụm, kẹp thịt, pate và rau, được ép nóng để tạo độ giòn đặc trưng.', 'images/banh_mi_ep_hue.jpg', 10000),
('Bánh Mì Gà Xé Đà Nẵng', 'Bánh mì Đà Nẵng với gà xé thơm ngon, rau răm, hành phi và nước sốt cay ngọt hấp dẫn.', 'images/banh_mi_ga_xe_da_nang.jpg', 20000),
('Bánh Mì Phá Lấu', 'Bánh mì kẹp phá lấu béo bùi, nước sốt đậm vị, ăn kèm dưa leo và rau thơm.', 'images/banh_mi_pha_lau.jpg', 30000),
('Bánh Mì Pa Tê Chả Lụa', 'Bánh mì thơm giòn kết hợp với pa tê béo ngậy và chả lụa mềm mịn, thêm dưa leo, rau thơm và nước sốt đặc trưng.', 'images/banh_mi_pate_cha_lua.jpg', 15000),
('Bánh Mì Thịt Nướng', 'Bánh mì truyền thống với thịt nướng thơm lừng, rau sống tươi mát, đồ chua giòn giòn và nước sốt đậm đà.', 'images/banh_mi_thit_nuong.jpg', 30000),
('Bánh Mì Chả Cá', 'Bánh mì nóng giòn kẹp chả cá chiên vàng ruộm, ăn kèm với rau thơm, dưa leo và tương ớt cay nồng.', 'images/banh_mi_cha_ca.jpg', 15000),
('Bánh Mì Heo Quay', 'Thịt heo quay giòn bì, mềm ngọt bên trong, kết hợp với dưa leo, hành ngò và nước sốt đặc biệt trong ổ bánh mì giòn rụm.', 'images/banh_mi_heo_quay.jpg', 30000),
('Bánh Mì Xíu Mại', 'Bánh mì kẹp xíu mại viên mềm, sốt cà chua đậm đà, thêm hành ngò tạo hương vị thơm ngon khó cưỡng.', 'images/banh_mi_xiu_mai.jpg', 30000),
('Bánh Mì Nướng Bơ Tỏi', 'Bánh mì nướng giòn thấm đẫm bơ và tỏi thơm lừng, thích hợp làm món ăn vặt hấp dẫn.', 'images/banh_mi_nuong_bo_toi.jpg', 30000),
('Bánh Mì Chấm Sữa Đặc', 'Bánh mì giòn chấm sữa đặc béo ngậy, món ăn tuổi thơ gợi nhớ những ký ức đẹp.', 'images/banh_mi_cham_sua_dac.jpg', 10000),
('Bánh Mì Chảo', 'Bánh mì ăn kèm với chảo topping đa dạng như pate, trứng ốp la, xúc xích, thịt nguội và nước sốt đậm đà.', 'images/banh_mi_chao.jpg', 40000),
('Bánh Mì Cay Hải Phòng', 'Bánh mì mini giòn tan với nhân pate cay nồng, một đặc sản nổi tiếng của Hải Phòng.', 'images/banh_mi_cay.jpg', 15000),
('Bánh Mì Bột Lọc', 'Bánh mì kẹp bánh bột lọc dai dai, nhân tôm thịt đậm đà, hòa quyện với nước mắm chua ngọt.', 'images/banh_mi_bot_loc.jpg', 25000),
('Bánh Mì Ép Huế', 'Bánh mì ép giòn rụm, kẹp thịt, pate và rau, được ép nóng để tạo độ giòn đặc trưng.', 'images/banh_mi_ep_hue.jpg', 10000),
('Bánh Mì Gà Xé Đà Nẵng', 'Bánh mì Đà Nẵng với gà xé thơm ngon, rau răm, hành phi và nước sốt cay ngọt hấp dẫn.', 'images/banh_mi_ga_xe_da_nang.jpg', 20000),
('Bánh Mì Phá Lấu', 'Bánh mì kẹp phá lấu béo bùi, nước sốt đậm vị, ăn kèm dưa leo và rau thơm.', 'images/banh_mi_pha_lau.jpg', 30000);


drop table if exists orders;
create table orders (
	order_id int primary key AUTO_INCREMENT,
    status ENUM('in progress','delivered') not null,
    total_price DECIMAL(12,0),
    username varchar(255),
    FOREIGN KEY(username) references accounts(username) on delete set null,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

drop table if exists orders_include_items;
create table orders_include_items (
	order_id int not null, 
    item_id int not null,
    quantity int check (quantity>0),
    note TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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

