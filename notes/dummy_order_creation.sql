# DELIMITER //
# CREATE PROCEDURE generate_orders()
# BEGIN
#     DECLARE i INT DEFAULT 0;
#     DECLARE order_date DATE;
#     DECLARE item_code INT;
#     DECLARE customer_id INT;
#     DECLARE price INT;
#     DECLARE quantity INT;
#     DECLARE order_no INT;
#
#     WHILE i < 2000
#         DO
#             SET order_date = '2022-01-01' + INTERVAL FLOOR(RAND() * (DATEDIFF('2023-05-10', '2022-01-01') + 1)) DAY;
#             SET item_code = FLOOR(1 + RAND() * 5);
#             SET customer_id = ELT(FLOOR(1 + RAND() * 5), 9, 13, 16, 3, 4);
#             SET price = ELT(item_code, 2000000, 1494000, 1559000, 1800000, 1400000);
# #             SET price = (SELECT price FROM (SELECT 1 AS item_code, 2000000 AS price UNION SELECT 2, 1494000 UNION SELECT 3, 1559000 UNION SELECT 4, 1800000 UNION SELECT 5, 1400000) AS prices WHERE item_code = item_code);
#             SET quantity = FLOOR(1 + RAND() * 10);
#
#             INSERT INTO `order` (status, ordered_date_time, created_at, customer_confirmed_date_time, fulfilled,
#                                  customer_id)
#             VALUES ('CustomerConfirmed', order_date, order_date, order_date + INTERVAL FLOOR(RAND() * (31)) DAY, TRUE,
#                     customer_id);
#             SET order_no = LAST_INSERT_ID();
#             INSERT INTO orderhasproduct (item_code, order_no, quantity, price_at_order)
#             VALUES (item_code, order_no, quantity, price);
#
#             SET i = i + 1;
#         END WHILE;
# END//
# DELIMITER ;
#
# CALL generate_orders();