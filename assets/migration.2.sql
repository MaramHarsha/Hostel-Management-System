UPDATE `tbl_dhpms_options` SET `opt_value` = '2.0.0' WHERE `tbl_dhpms_options`.`id` = 8;

CREATE TABLE `tbl_branches` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `branch_address` text NOT NULL,
  `branch_contact` varchar(10) NOT NULL,
  `branch_currency` varchar(10) NOT NULL,
  `branch_currency_symbol` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tbl_branches`
  ADD PRIMARY KEY (`id`);

CREATE TABLE `tbl_languages` (
  `id` int(11) NOT NULL,
  `lang_name` varchar(150) NOT NULL,
  `lang_abbr` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tbl_languages`
  ADD PRIMARY KEY (`id`);

INSERT INTO `tbl_languages` (`id`, `lang_name`, `lang_abbr`) VALUES
(1, 'English', 'en'),
(2, 'Spanish', 'es'),
(5, 'French', 'fr'),
(6, 'German', 'de');

ALTER TABLE `tbl_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `tbl_branches` (`id`, `branch_name`, `branch_address`, `branch_contact`, `branch_currency`, `branch_currency_symbol`) VALUES
(1, 'Head Branch', '', '9876543210', 'USD', '$');

ALTER TABLE `tbl_users` ADD `user_branch` VARCHAR(5) NOT NULL AFTER `user_type`;

ALTER TABLE `tbl_users` CHANGE `user_type` `user_type` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `tbl_rooms` ADD `room_branch` VARCHAR(5) NOT NULL AFTER `room_details`;

UPDATE `tbl_rooms` SET `room_branch` = '1';

ALTER TABLE `tbl_tenants` ADD `ten_branch` VARCHAR(10) NOT NULL AFTER `ten_bed`;

UPDATE `tbl_tenants` SET `ten_branch` = '1';

ALTER TABLE `tbl_extra_services` ADD `es_branch` VARCHAR(10) NOT NULL AFTER `es_details`;

UPDATE `tbl_extra_services` SET `es_branch` = '1';

ALTER TABLE `tbl_notices` ADD `notice_branch` VARCHAR(10) NOT NULL AFTER `notice_details`;

INSERT INTO `tbl_dhpms_options` (`id`, `opt_key`, `opt_value`) VALUES (NULL, 'tax_num_label', ''), (NULL, 'tax_num', '');

INSERT INTO `tbl_dhpms_options` (`id`, `opt_key`, `opt_value`) VALUES (NULL, 'invoice_footer', '');

INSERT INTO `tbl_dhpms_options` (`id`, `opt_key`, `opt_value`) VALUES (NULL, 'lang', 'english');
