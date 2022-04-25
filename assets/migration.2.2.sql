UPDATE `tbl_dhpms_options` SET `opt_value` = '2.2.0' WHERE `tbl_dhpms_options`.`id` = 8;

INSERT INTO `tbl_dhpms_options` (`id`, `opt_key`, `opt_value`) VALUES
(43, 'payment_gtw', 'razorpay'),
(44, 'paystack_secret_Key', ''),
(45, 'paystack_public_Key', ''),
(46, 'razp_web_key', '');