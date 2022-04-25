UPDATE `tbl_dhpms_options` SET `opt_value` = '2.0.1' WHERE `tbl_dhpms_options`.`id` = 8;

ALTER TABLE `tbl_tenants` ADD `ten_tax_company_name` VARCHAR(55) NOT NULL AFTER `ten_emc_contact`, ADD `ten_tax_company_email` VARCHAR(55) NOT NULL AFTER `ten_tax_company_name`, ADD `ten_tax_number` VARCHAR(55) NOT NULL AFTER `ten_tax_company_email`;

