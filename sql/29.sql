ALTER TABLE `courier_service` ADD `payments` VARCHAR(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0000' AFTER `is_new`;

CREATE TABLE `payment_methods` (
`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `account_holder` int(11) NOT NULL COMMENT 'member id/organisation id',
  `holder_type` tinyint(1) NOT NULL COMMENT '1=user 2=organisation',
  `account_type` tinyint(1) NOT NULL COMMENT '1=pre-paid 2=post-paid',
  `credit` float NOT NULL,
  `deposit` float NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=new, 2=approved',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approved_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `payment_account_details` (
  `account_id` int(11) NOT NULL,
  `contact_name` varchar(30) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address_line1` varchar(200) NOT NULL,
  `address_line2` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(3) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `invoice_attention` varchar(100) NOT NULL,
  `company_reg_no` varchar(40) NOT NULL,
  `deliveries_per_month` int(11) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
