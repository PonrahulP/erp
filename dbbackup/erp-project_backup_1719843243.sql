

CREATE TABLE `b2c` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `balance` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO balance VALUES("14","Bank","99000","2024-07-01 19:41:55","2024-07-01 19:41:55");
INSERT INTO balance VALUES("15","Cash","99000","2024-07-01 19:41:26","2024-07-01 19:41:26");



CREATE TABLE `c2b` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`,`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO customers VALUES("2","2222"," Rahul","9751363453","COIMBATORE","rahul@gmail.com","2024-07-01 19:39:36","2024-07-01 19:39:36");



CREATE TABLE `expenses` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `expenses_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `amount` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO expenses VALUES("12","Office","Subbru","2024-07-01","1000","cash");



CREATE TABLE `income` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `amount` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO income VALUES("8","Ponraj","2024-07-01","1000","bank");



CREATE TABLE `payment` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `bill_no` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `pending_amount` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO payment VALUES("11","P-0000001","104000","4000","100000.00","2024-07-01","Bank","2024-07-01 19:39:10");



CREATE TABLE `products` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO products VALUES("10","APPLE","1234","GOOD","50000","152","mobile.jpg","2024-07-01 19:36:54","2024-07-01 19:38:39");
INSERT INTO products VALUES("11","CAR","5678","GOOD","500000","49","car 1.jpeg","2024-07-01 19:37:26","2024-07-01 19:40:14");



CREATE TABLE `purchase1` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `supplier_id` varchar(255) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `bill_img` varchar(255) NOT NULL,
  `purchase_date` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO purchase1 VALUES("22","11111","P-0000001","bill.jpg","2024-07-01","2024-07-01 19:38:39","2024-07-01 19:38:39");



CREATE TABLE `purchase2` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `bill_no` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `unit_price` varchar(255) NOT NULL,
  `cgst` varchar(255) NOT NULL,
  `sgst` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO purchase2 VALUES("22","P-0000001","1234","APPLE","2","50000","2","2","104000","2024-07-01 19:38:39","2024-07-01 19:38:39");



CREATE TABLE `receipt` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `bill_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `pending_amount` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO receipt VALUES("10","S-0000001","2024-07-01","545000.00","4000","541000.00","Bank","2024-07-01 19:40:58","2024-07-01 19:40:58");



CREATE TABLE `sales1` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `sales_date` date NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `cgst` varchar(255) NOT NULL,
  `cgst_amount` varchar(255) NOT NULL,
  `sgst` varchar(255) NOT NULL,
  `sgst_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `sales_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO sales1 VALUES("83","2222","S-0000001","IN-0000001","2024-07-01","500000.00","5","25000.00","5","25000.00","5000","545000.00","Bill to Bill","2024-07-01 19:40:14","2024-07-01 19:40:14");



CREATE TABLE `sales2` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `bill_no` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `unit_price` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `sales_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO sales2 VALUES("94","S-0000001","5678","CAR","1","500000","500000.00","Bill to Bill","2024-07-01 19:40:14","2024-07-01 19:40:14");



CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`,`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO suppliers VALUES("2","11111","Subbru","8428055208","CHENNAI","ragu@gmail.com","2024-07-01 19:37:47","2024-07-01 19:37:47");



CREATE TABLE `users` (
  `user_id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `opening_bank_balance` varchar(255) NOT NULL,
  `opening_cash_balance` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users VALUES("14","PONRAHULP","$2y$10$sydTEiMP1/vTOICYX49tsuQC2EwZL6iFlKAcHvi1SmtirR6cVRUPW","ponrahulp2018@gmail.com","7904955208","admin","car 2.jpg","250000","150000","2024-06-24 18:34:37","2024-06-24 18:34:37");
INSERT INTO users VALUES("15","PONRAHULP","$2y$10$aE8UTwrSbHqNK1I/dWdepOfuyJC.K1A0eyz8rudki4RHqADxppKSG","ponrahulp2018@gmail.com","7904955208","admin","car 2.jpg","250000","150000","2024-07-01 19:18:43","2024-07-01 19:18:43");

