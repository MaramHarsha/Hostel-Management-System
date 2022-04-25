-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2022 at 10:38 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostel`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beds`
--

CREATE TABLE `tbl_beds` (
  `id` int(11) NOT NULL,
  `bed_uid` int(11) NOT NULL,
  `bed_name` varchar(100) NOT NULL,
  `bed_room` varchar(10) NOT NULL,
  `bed_details` text NOT NULL,
  `bed_status` varchar(10) NOT NULL,
  `bed_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_beds`
--

INSERT INTO `tbl_beds` (`id`, `bed_uid`, `bed_name`, `bed_room`, `bed_details`, `bed_status`, `bed_added`) VALUES
(4, 1, 'Bed - 1', '1', '', '0', '2022-04-19 10:13:35'),
(5, 2, 'Bed - 2', '1', '', '0', '2022-04-19 10:13:45'),
(6, 3, 'Bed - 1', '2', '', '0', '2022-04-19 10:13:52'),
(7, 4, 'Bed - 2', '2', '', '0', '2022-04-19 10:14:00'),
(8, 5, 'Bed - 1', '3', '', '0', '2022-04-19 10:14:09'),
(9, 6, 'Bed - 2', '3', '', '0', '2022-04-19 10:14:17'),
(10, 7, 'Bed - 1', '4', '', '0', '2022-04-19 10:14:54'),
(11, 8, 'Bed - 2', '4', '', '0', '2022-04-19 10:15:01'),
(12, 9, 'Bed - 1', '5', '', '0', '2022-04-19 10:15:11'),
(13, 10, 'Bed - 2', '5', '', '0', '2022-04-19 10:15:20'),
(14, 11, 'Bed - 1', '6', '', '0', '2022-04-19 10:15:28'),
(15, 12, 'Bed - 2', '6', '', '0', '2022-04-19 10:15:35'),
(16, 13, 'Bed - 1', '7', '', '0', '2022-04-19 10:15:45'),
(17, 14, 'Bed - 2', '7', '', '0', '2022-04-19 10:15:54'),
(18, 15, 'Bed - 1', '8', '', '0', '2022-04-19 10:16:02'),
(19, 16, 'Bed - 2', '8', '', '0', '2022-04-19 10:16:10'),
(20, 17, 'Bed - 1', '9', '', '0', '2022-04-19 10:16:17'),
(21, 18, 'Bed - 2', '9', '', '0', '2022-04-19 10:16:25'),
(22, 19, 'Bed - 1', '10', '', '0', '2022-04-19 10:16:32'),
(23, 20, 'Bed - 2', '10', '', '0', '2022-04-19 10:16:41'),
(24, 21, 'Bed - 1', '11', '', '0', '2022-04-19 10:16:50'),
(25, 22, 'Bed - 2', '11', '', '0', '2022-04-19 10:16:58'),
(26, 23, 'Bed - 1', '12', '', '0', '2022-04-19 10:17:06'),
(27, 24, 'Bed - 2', '12', '', '0', '2022-04-19 10:17:14'),
(28, 25, 'Bed - 1', '13', '', '0', '2022-04-19 10:17:22'),
(29, 26, 'Bed - 2', '13', '', '0', '2022-04-19 10:17:33'),
(30, 27, 'Bed - 1', '14', '', '0', '2022-04-19 10:17:42'),
(31, 28, 'Bed - 2', '14', '', '0', '2022-04-19 10:17:53'),
(32, 29, 'Bed - 1', '15', '', '0', '2022-04-19 10:18:00'),
(33, 30, 'Bed - 2', '15', '', '0', '2022-04-19 10:18:09'),
(34, 31, 'Bed - 1', '16', '', '0', '2022-04-19 10:18:16'),
(35, 32, 'Bed - 2', '16', '', '0', '2022-04-19 10:18:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bed_assign`
--

CREATE TABLE `tbl_bed_assign` (
  `id` int(11) NOT NULL,
  `ten_uid` varchar(25) NOT NULL,
  `room_uid` varchar(25) NOT NULL,
  `bed_uid` varchar(25) NOT NULL,
  `total_amnt` float(10,2) NOT NULL,
  `lease_from` date NOT NULL,
  `lease_to` date NOT NULL,
  `assigned_on` datetime NOT NULL,
  `is_retrived` varchar(1) NOT NULL,
  `retrived_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

CREATE TABLE `tbl_blog` (
  `id` int(11) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_image` varchar(255) NOT NULL,
  `blog_content` text NOT NULL,
  `blog_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branches`
--

CREATE TABLE `tbl_branches` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `branch_address` text NOT NULL,
  `branch_contact` varchar(10) NOT NULL,
  `branch_currency` varchar(10) NOT NULL,
  `branch_currency_symbol` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_branches`
--

INSERT INTO `tbl_branches` (`id`, `branch_name`, `branch_address`, `branch_contact`, `branch_currency`, `branch_currency_symbol`) VALUES
(3, 'Hostel 1', 'Jaipur', '8888888888', '', ''),
(4, 'Hostel 2', 'Jaipur', '8888888888', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_complaints`
--

CREATE TABLE `tbl_complaints` (
  `id` int(11) NOT NULL,
  `complaint_title` varchar(255) NOT NULL,
  `complaint_text` text NOT NULL,
  `complaint_cat` varchar(10) NOT NULL,
  `complaint_tenant_uid` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_complaint_cat`
--

CREATE TABLE `tbl_complaint_cat` (
  `id` int(11) NOT NULL,
  `complaint_cat_name` varchar(250) NOT NULL,
  `complaint_cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dhpms_options`
--

CREATE TABLE `tbl_dhpms_options` (
  `id` int(11) NOT NULL,
  `opt_key` varchar(255) NOT NULL,
  `opt_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_dhpms_options`
--

INSERT INTO `tbl_dhpms_options` (`id`, `opt_key`, `opt_value`) VALUES
(1, 'dhp_name', 'JKLU Hostel Room Booking System'),
(2, 'app_footer', 'JKLU Hostel Room Booking System © 2022'),
(8, 'app_version', '3.0.0'),
(9, 'tid_start', '100'),
(10, 'currency_code', 'INR'),
(11, 'currency_symbol', '₹'),
(12, 'rid_start', '100'),
(13, 'contact_no', '9876543210'),
(14, 'email', 'admin@demo.com'),
(15, 'country', 'India'),
(16, 'state', 'Rajasthan'),
(17, 'city', 'Jaipur'),
(18, 'address', 'Mahapura'),
(19, 'bid_start', '105'),
(20, 'tax_name', 'SGST'),
(21, 'tax_per', '18'),
(22, 'tax_apply', '1'),
(23, 'tax2_name', 'CGST'),
(24, 'tax2_per', '12'),
(25, 'tax2_apply', '1'),
(31, 'smtp_host', ''),
(32, 'smtp_username', ''),
(33, 'smtp_pass', ''),
(34, 'smtp_port', ''),
(35, 'paypal_email', ''),
(36, 'app_logo', '28828a6060d6ea61728e41243a876d7d.png'),
(37, 'stripe_secret_key', ''),
(38, 'stripe_publishable_key', ''),
(39, 'lang', 'english'),
(40, 'tax_num_label', 'GST'),
(41, 'tax_num', 'XXXXXXXXXXXXX'),
(42, 'invoice_footer', 'This is invoice footer, you can edit this from configurations.'),
(43, 'payment_gtw', 'paystack'),
(44, 'paystack_secret_Key', ''),
(45, 'paystack_public_Key', ''),
(46, 'razp_web_key', ''),
(47, 'enable_registration', 'true'),
(48, 'enable_room_change_request', 'true'),
(49, 'url_rewrite', 'true'),
(50, 'web_template', 'default');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doc_type`
--

CREATE TABLE `tbl_doc_type` (
  `id` int(11) NOT NULL,
  `document_type` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_templates`
--

CREATE TABLE `tbl_email_templates` (
  `id` int(11) NOT NULL,
  `email_tpl_name` varchar(250) NOT NULL,
  `email_tpl_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_email_templates`
--

INSERT INTO `tbl_email_templates` (`id`, `email_tpl_name`, `email_tpl_content`) VALUES
(1, 'email_tenant_create', '<p>Hello {{ten_name}},</p>\n\n<p>Your account is successfully created in {{dhp_name}} - DHPMS system.<br />\nYou can log in now with bellow credentials:</p>\n\n<p>Email: {{ten_email}}</p>\n\n<p>Password: {{ten_email}}<br />\n<br />\nYou can change your password by logging into your account.</p>\n\n<p>&nbsp;</p>\n\n<p>Thank You,</p>\n\n<p>{{dhpm_name}} - DHPMS&nbsp;</p>\n'),
(2, 'room_asigned', '<p>Hello {{ten_name}},</p>\n\n<p>Please find below details about your accommodation at {{dhpm_name}},</p>\n\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\n	<tbody>\n		<tr>\n			<td>Room Name</td>\n			<td>{{room_name}}</td>\n		</tr>\n		<tr>\n			<td>Bed Name</td>\n			<td>{{bed_name}}</td>\n		</tr>\n		<tr>\n			<td>Total Amount</td>\n			<td>{{total_amount}}</td>\n		</tr>\n		<tr>\n			<td>Invoice Status</td>\n			<td>{{invoice_status}}</td>\n		</tr>\n	</tbody>\n</table>\n\n<p><br />\nPlease log in to your account for invoice details.</p>\n\n<p>&nbsp;</p>\n\n<p>Thank You,</p>\n\n<p>{{dhpm_name}} - DHPMS&nbsp;</p>\n'),
(3, 'es_assigned', '<p>Hello {{ten_name}},</p>\n\n<p>Please find below details about your extra service at {{dhpm_name}},</p>\n\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\n	<tbody>\n		<tr>\n			<td>Extra Service Name</td>\n			<td>{{es_name}}</td>\n		</tr>\n		<tr>\n			<td>Total Amount</td>\n			<td>{{total_amount}}</td>\n		</tr>\n		<tr>\n			<td>Invoice Status</td>\n			<td>{{invoice_status}}</td>\n		</tr>\n	</tbody>\n</table>\n\n<p><br />\nPlease log in to your account for invoice details.</p>\n\n<p>&nbsp;</p>\n\n<p>Thank You,</p>\n\n<p>{{dhpm_name}} - DHPMS&nbsp;</p>\n'),
(4, 'add_payment', '<p>Hello {{ten_name}},<br />\n&nbsp;</p>\n\n<p>We have received a payment of {{pay_amnt}} against the Invoice no. {{inv_number}} on {{pay_date}}.</p>\n\n<p>Please log in to your account for invoice details.</p>\n\n<p>&nbsp;</p>\n\n<p>Thank You,</p>\n\n<p>{{dhpm_name}} - DHPMS&nbsp;</p>\n');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_es_assign`
--

CREATE TABLE `tbl_es_assign` (
  `id` int(11) NOT NULL,
  `ten_uid` varchar(55) NOT NULL,
  `es_id` varchar(55) NOT NULL,
  `total_amnt` float(10,2) NOT NULL,
  `dt_from` date NOT NULL,
  `dt_to` date NOT NULL,
  `assigned_on` datetime NOT NULL,
  `retrived_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

CREATE TABLE `tbl_expenses` (
  `id` int(11) NOT NULL,
  `exp_name` varchar(255) NOT NULL,
  `exp_category` varchar(10) NOT NULL,
  `exp_amnt` float(10,2) NOT NULL,
  `exp_customer_details` text NOT NULL,
  `exp_payment_method` varchar(10) NOT NULL,
  `exp_ref_no` varchar(255) NOT NULL,
  `exp_date` date NOT NULL,
  `exp_receipt` varchar(255) NOT NULL,
  `exp_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exp_cat`
--

CREATE TABLE `tbl_exp_cat` (
  `id` int(11) NOT NULL,
  `exp_cat_name` varchar(250) NOT NULL,
  `exp_cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_extra_services`
--

CREATE TABLE `tbl_extra_services` (
  `id` int(11) NOT NULL,
  `es_name` varchar(255) NOT NULL,
  `es_price` varchar(25) NOT NULL,
  `es_details` text NOT NULL,
  `es_branch` varchar(10) NOT NULL,
  `es_added_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE `tbl_gallery` (
  `id` int(11) NOT NULL,
  `gal_img` varchar(255) NOT NULL,
  `gal_title` varchar(255) NOT NULL,
  `gal_slider_img` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_gallery`
--

INSERT INTO `tbl_gallery` (`id`, `gal_img`, `gal_title`, `gal_slider_img`) VALUES
(1, 'a08fd-bed-142517_1280.jpg', 'Welcome to Calgary HMS', 1),
(2, 'bfef4-flats-4417311_1280.jpg', 'Best Hostel management software', 1),
(3, '18298-room-3810680_1280.jpg', 'One application for Multiple Branches', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `id` int(11) NOT NULL,
  `inv_id` varchar(125) NOT NULL,
  `inv_for` varchar(125) NOT NULL,
  `inv_status` varchar(125) NOT NULL,
  `inv_amnt` float(10,2) NOT NULL,
  `inv_tax_per` float(10,2) NOT NULL,
  `inv_tax2_per` float(10,2) NOT NULL,
  `inv_tax` float(10,2) NOT NULL,
  `inv_tax2` float(10,2) NOT NULL,
  `inv_total` float(10,2) NOT NULL,
  `inv_ten_uid` varchar(55) NOT NULL,
  `inv_due_date` date NOT NULL,
  `inv_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`id`, `inv_id`, `inv_for`, `inv_status`, `inv_amnt`, `inv_tax_per`, `inv_tax2_per`, `inv_tax`, `inv_tax2`, `inv_total`, `inv_ten_uid`, `inv_due_date`, `inv_created`) VALUES
(5, '00001', 'Room / Bed Booking', 'PAID', 1000.00, 18.00, 12.00, 180.00, 120.00, 1300.00, '1', '0000-00-00', '2022-04-18'),
(6, '00006', 'Room / Bed Booking', 'UNPAID', 1000.00, 18.00, 12.00, 180.00, 120.00, 1300.00, '2', '0000-00-00', '2022-04-18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_items`
--

CREATE TABLE `tbl_invoice_items` (
  `id` int(11) NOT NULL,
  `inv_id` varchar(125) NOT NULL,
  `item_id` varchar(125) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_desc` text NOT NULL,
  `item_price` float(10,2) NOT NULL,
  `item_type` varchar(125) NOT NULL,
  `item_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_invoice_items`
--

INSERT INTO `tbl_invoice_items` (`id`, `inv_id`, `item_id`, `item_name`, `item_desc`, `item_price`, `item_type`, `item_added`) VALUES
(5, '00001', '634221727', 'Room / Bed Booking', 'Room Name: Test Room | Bed Name: Test Bed', 1000.00, 'Room / Bed', '2022-04-18'),
(6, '00006', '836335549', 'Room / Bed Booking', 'Room Name: Test Room | Bed Name: Bed 2', 1000.00, 'Room / Bed', '2022-04-18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_payments`
--

CREATE TABLE `tbl_invoice_payments` (
  `id` int(11) NOT NULL,
  `inv_id` varchar(125) NOT NULL,
  `payment_id` varchar(125) NOT NULL,
  `payment_method` varchar(125) NOT NULL,
  `payment_trans_id` varchar(255) NOT NULL,
  `payment_amnt` float(10,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_status` varchar(125) NOT NULL,
  `payment_details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_invoice_payments`
--

INSERT INTO `tbl_invoice_payments` (`id`, `inv_id`, `payment_id`, `payment_method`, `payment_trans_id`, `payment_amnt`, `payment_date`, `payment_status`, `payment_details`) VALUES
(1, '00001', '112179747', 'cash', '5096fdcb732a57d5d13386c6a7fb6df0', 1000.00, '2022-04-18 15:31:13', 'success', ''),
(2, '00001', '795112852', 'cash', '097fb16bda95716108bca0fb0b23d628', 300.00, '2022-04-18 15:34:40', 'success', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_languages`
--

CREATE TABLE `tbl_languages` (
  `id` int(11) NOT NULL,
  `lang_name` varchar(150) NOT NULL,
  `lang_abbr` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_languages`
--

INSERT INTO `tbl_languages` (`id`, `lang_name`, `lang_abbr`) VALUES
(1, 'English', 'en'),
(2, 'Spanish', 'es'),
(5, 'French', 'fr'),
(6, 'German', 'de');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notices`
--

CREATE TABLE `tbl_notices` (
  `id` int(11) NOT NULL,
  `notice_title` varchar(250) NOT NULL,
  `notice_details` text NOT NULL,
  `notice_branch` varchar(10) NOT NULL,
  `notice_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_requests`
--

CREATE TABLE `tbl_requests` (
  `id` int(11) NOT NULL,
  `request_type` varchar(50) NOT NULL,
  `request_ten_uid` varchar(10) NOT NULL,
  `request_bed_uid` varchar(10) NOT NULL,
  `request_room_uid` varchar(10) NOT NULL,
  `request_es_uid` varchar(10) NOT NULL,
  `request_create_date` datetime NOT NULL,
  `request_update_date` datetime NOT NULL,
  `request_status` varchar(10) NOT NULL,
  `request_notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_requests`
--

INSERT INTO `tbl_requests` (`id`, `request_type`, `request_ten_uid`, `request_bed_uid`, `request_room_uid`, `request_es_uid`, `request_create_date`, `request_update_date`, `request_status`, `request_notes`) VALUES
(3, 'BED', '1', '1', '1', '', '2022-04-18 15:27:08', '2022-04-18 15:28:02', 'APPROVED', ''),
(4, 'BED', '2', '2', '1', '', '2022-04-18 15:32:45', '0000-00-00 00:00:00', 'PENDING', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms`
--

CREATE TABLE `tbl_rooms` (
  `id` int(11) NOT NULL,
  `room_uid` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_details` text NOT NULL,
  `room_branch` varchar(5) NOT NULL,
  `room_price` float(10,2) NOT NULL,
  `room_status` varchar(2) NOT NULL,
  `room_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_rooms`
--

INSERT INTO `tbl_rooms` (`id`, `room_uid`, `room_name`, `room_details`, `room_branch`, `room_price`, `room_status`, `room_added`) VALUES
(3, 1, 'G - 001', 'G - Ground Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 1000.00, '', '2022-04-19 10:08:26'),
(4, 2, 'G - 002', 'G - Ground Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 1000.00, '', '2022-04-19 10:08:41'),
(5, 3, 'G - 003', 'G - Ground Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 1000.00, '', '2022-04-19 10:08:57'),
(6, 4, 'G - 004', 'G - Ground Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 1000.00, '', '2022-04-19 10:09:08'),
(7, 5, 'F1 - 101', 'F - First Floor, 1 - AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 2000.00, '', '2022-04-19 10:10:18'),
(8, 6, 'F1 - 102', 'F - First Floor, 1 - AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 2000.00, '', '2022-04-19 10:10:31'),
(9, 7, 'F1 - 103', 'F - First Floor, 1 - AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 2000.00, '', '2022-04-19 10:10:41'),
(10, 8, 'F1 - 104', 'F - First Floor, 1 - AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 2000.00, '', '2022-04-19 10:10:55'),
(11, 9, 'F2 - 201', 'F2 - Second Floor, 1 - AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 2000.00, '', '2022-04-19 10:11:26'),
(12, 10, 'F2 - 202', 'F2 - Second Floor, 1 - AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 2000.00, '', '2022-04-19 10:11:38'),
(13, 11, 'F2 - 203', 'F2 - Second Floor, 1 - AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 2000.00, '', '2022-04-19 10:11:54'),
(14, 12, 'F2 - 204', 'F2 - Second Floor, 1 - AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 2000.00, '', '2022-04-19 10:12:11'),
(15, 13, 'F3 - 301', 'F3 - Third Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 1000.00, '', '2022-04-19 10:12:35'),
(16, 14, 'F3 - 302', 'F3 - Third Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 1000.00, '', '2022-04-19 10:12:45'),
(17, 15, 'F3 - 303', 'F3 - Third Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 1000.00, '', '2022-04-19 10:12:59'),
(18, 16, 'F3 - 304', 'F3 - Third Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '3', 1000.00, '', '2022-04-19 10:13:10'),
(19, 17, 'G - 001', 'G - Ground Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '4', 1000.00, '', '2022-04-19 10:25:13'),
(20, 18, 'G - 002', 'G - Ground Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '4', 1000.00, '', '2022-04-19 10:25:35'),
(21, 19, 'G - 003', 'G - Ground Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 1000.00, '', '2022-04-19 10:25:50'),
(22, 20, 'G - 004', 'G - Ground Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 1000.00, '', '2022-04-19 10:26:04'),
(23, 21, 'F1 - 101', 'F1 - First Floor, 1 AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 2000.00, '', '2022-04-19 10:26:39'),
(24, 22, 'F1 - 102', 'F1 - First Floor, 1 AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 2000.00, '', '2022-04-19 10:26:49'),
(25, 23, 'F1 - 103', 'F1 - First Floor, 1 AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 2000.00, '', '2022-04-19 10:27:09'),
(26, 24, 'F1 - 103', 'F1 - First Floor, 1 AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 2000.00, '', '2022-04-19 10:27:21'),
(27, 25, 'F1 - 104', 'F1 - First Floor, 1 AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 2000.00, '', '2022-04-19 10:27:33'),
(28, 26, 'F2 - 201', 'F2 - Second Floor, 1 AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 2000.00, '', '2022-04-19 10:28:04'),
(29, 27, 'F2 - 202', 'F2 - Second Floor, 1 AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 2000.00, '', '2022-04-19 10:28:22'),
(30, 28, 'F2 - 203', 'F2 - Second Floor, 1 AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 2000.00, '', '2022-04-19 10:28:56'),
(31, 29, 'F2 - 204', 'F2 - Second Floor, 1 AC, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 2000.00, '', '2022-04-19 10:29:12'),
(32, 30, 'F3 - 301', 'F3 - Third Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.	', '4', 1000.00, '', '2022-04-19 10:29:43'),
(33, 31, 'F3 - 302', 'F3 - Third Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '4', 1000.00, '', '2022-04-19 10:30:02'),
(34, 32, 'F3 - 303', 'F3 - Third Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '4', 1000.00, '', '2022-04-19 10:30:17'),
(35, 33, 'F3 - 304', 'F3 - Third Floor, 2 Beds, 2 Almira, 2 Study Tables, 2 Chairs, 1 Side Table, 2 Fans, 2 Lights &amp; 2 Matrices.', '4', 1000.00, '', '2022-04-19 10:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tenants`
--

CREATE TABLE `tbl_tenants` (
  `id` int(11) NOT NULL,
  `ten_name` varchar(155) NOT NULL,
  `ten_email` varchar(155) NOT NULL,
  `ten_pass` varchar(155) NOT NULL,
  `ten_uid` int(11) NOT NULL,
  `ten_gender` varchar(10) NOT NULL,
  `ten_dob` date NOT NULL,
  `ten_address` varchar(255) NOT NULL,
  `ten_contact` varchar(15) NOT NULL,
  `ten_pic` varchar(155) NOT NULL,
  `ten_emc_name` varchar(100) NOT NULL,
  `ten_emc_contact` varchar(50) NOT NULL,
  `ten_tax_company_name` varchar(55) NOT NULL,
  `ten_tax_company_email` varchar(55) NOT NULL,
  `ten_tax_number` varchar(55) NOT NULL,
  `ten_room` varchar(10) NOT NULL,
  `ten_bed` varchar(10) NOT NULL,
  `ten_branch` varchar(10) NOT NULL,
  `ten_months_lease` varchar(10) NOT NULL,
  `ten_deposite_amnt` float(10,2) NOT NULL,
  `ten_rent` float(10,2) NOT NULL,
  `ten_comments` text NOT NULL,
  `ten_add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ten_lastlogin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ten_isactive` varchar(10) NOT NULL,
  `ten_pass_changed` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_timezones`
--

CREATE TABLE `tbl_timezones` (
  `id` int(11) NOT NULL,
  `tmz` varchar(150) DEFAULT NULL,
  `tmz_text` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_timezones`
--

INSERT INTO `tbl_timezones` (`id`, `tmz`, `tmz_text`) VALUES
(1, 'Etc/GMT+12', '(GMT-12:00) International Date Line West'),
(2, 'Pacific/Midway', '(GMT-11:00) Midway Island, Samoa'),
(3, 'Pacific/Honolulu', '(GMT-10:00) Hawaii'),
(4, 'US/Alaska', '(GMT-09:00) Alaska'),
(5, 'America/Los_Angeles', '(GMT-08:00) Pacific Time (US & Canada)'),
(6, 'America/Tijuana', '(GMT-08:00) Tijuana, Baja California'),
(7, 'US/Arizona', '(GMT-07:00) Arizona'),
(8, 'America/Chihuahua', '(GMT-07:00) Chihuahua, La Paz, Mazatlan'),
(9, 'US/Mountain', '(GMT-07:00) Mountain Time (US & Canada)'),
(10, 'America/Managua', '(GMT-06:00) Central America'),
(11, 'US/Central', '(GMT-06:00) Central Time (US & Canada)'),
(12, 'America/Mexico_City', '(GMT-06:00) Guadalajara, Mexico City, Monterrey'),
(13, 'Canada/Saskatchewan', '(GMT-06:00) Saskatchewan'),
(14, 'America/Bogota', '(GMT-05:00) Bogota, Lima, Quito, Rio Branco'),
(15, 'US/Eastern', '(GMT-05:00) Eastern Time (US & Canada)'),
(16, 'US/East-Indiana', '(GMT-05:00) Indiana (East)'),
(17, 'Canada/Atlantic', '(GMT-04:00) Atlantic Time (Canada)'),
(18, 'America/Caracas', '(GMT-04:00) Caracas, La Paz'),
(19, 'America/Manaus', '(GMT-04:00) Manaus'),
(20, 'America/Santiago', '(GMT-04:00) Santiago'),
(21, 'Canada/Newfoundland', '(GMT-03:30) Newfoundland'),
(22, 'America/Sao_Paulo', '(GMT-03:00) Brasilia'),
(23, 'America/Argentina/Buenos_Aires', '(GMT-03:00) Buenos Aires, Georgetown'),
(24, 'America/Godthab', '(GMT-03:00) Greenland'),
(25, 'America/Montevideo', '(GMT-03:00) Montevideo'),
(26, 'America/Noronha', '(GMT-02:00) Mid-Atlantic'),
(27, 'Atlantic/Cape_Verde', '(GMT-01:00) Cape Verde Is.'),
(28, 'Atlantic/Azores', '(GMT-01:00) Azores'),
(29, 'Africa/Casablanca', '(GMT+00:00) Casablanca, Monrovia, Reykjavik'),
(30, 'Etc/Greenwich', '(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London'),
(31, 'Europe/Amsterdam', '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna'),
(32, 'Europe/Belgrade', '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague'),
(33, 'Europe/Brussels', '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris'),
(34, 'Europe/Sarajevo', '(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb'),
(35, 'Africa/Lagos', '(GMT+01:00) West Central Africa'),
(36, 'Asia/Amman', '(GMT+02:00) Amman'),
(37, 'Europe/Athens', '(GMT+02:00) Athens, Bucharest, Istanbul'),
(38, 'Asia/Beirut', '(GMT+02:00) Beirut'),
(39, 'Africa/Cairo', '(GMT+02:00) Cairo'),
(40, 'Africa/Harare', '(GMT+02:00) Harare, Pretoria'),
(41, 'Europe/Helsinki', '(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius'),
(42, 'Asia/Jerusalem', '(GMT+02:00) Jerusalem'),
(43, 'Europe/Minsk', '(GMT+02:00) Minsk'),
(44, 'Africa/Windhoek', '(GMT+02:00) Windhoek'),
(45, 'Asia/Kuwait', '(GMT+03:00) Kuwait, Riyadh, Baghdad'),
(46, 'Europe/Moscow', '(GMT+03:00) Moscow, St. Petersburg, Volgograd'),
(47, 'Africa/Nairobi', '(GMT+03:00) Nairobi'),
(48, 'Asia/Tbilisi', '(GMT+03:00) Tbilisi'),
(49, 'Asia/Tehran', '(GMT+03:30) Tehran'),
(50, 'Asia/Muscat', '(GMT+04:00) Abu Dhabi, Muscat'),
(51, 'Asia/Baku', '(GMT+04:00) Baku'),
(52, 'Asia/Yerevan', '(GMT+04:00) Yerevan'),
(53, 'Asia/Kabul', '(GMT+04:30) Kabul'),
(54, 'Asia/Yekaterinburg', '(GMT+05:00) Yekaterinburg'),
(55, 'Asia/Karachi', '(GMT+05:00) Islamabad, Karachi, Tashkent'),
(56, 'Asia/Calcutta', '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi'),
(57, 'Asia/Calcutta', '(GMT+05:30) Sri Jayawardenapura'),
(58, 'Asia/Katmandu', '(GMT+05:45) Kathmandu'),
(59, 'Asia/Almaty', '(GMT+06:00) Almaty, Novosibirsk'),
(60, 'Asia/Dhaka', '(GMT+06:00) Astana, Dhaka'),
(61, 'Asia/Rangoon', '(GMT+06:30) Yangon (Rangoon)'),
(62, 'Asia/Bangkok', '(GMT+07:00) Bangkok, Hanoi, Jakarta'),
(63, 'Asia/Krasnoyarsk', '(GMT+07:00) Krasnoyarsk'),
(64, 'Asia/Hong_Kong', '(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi'),
(65, 'Asia/Kuala_Lumpur', '(GMT+08:00) Kuala Lumpur, Singapore'),
(66, 'Asia/Irkutsk', '(GMT+08:00) Irkutsk, Ulaan Bataar'),
(67, 'Australia/Perth', '(GMT+08:00) Perth'),
(68, 'Asia/Taipei', '(GMT+08:00) Taipei'),
(69, 'Asia/Tokyo', '(GMT+09:00) Osaka, Sapporo, Tokyo'),
(70, 'Asia/Seoul', '(GMT+09:00) Seoul'),
(71, 'Asia/Yakutsk', '(GMT+09:00) Yakutsk'),
(72, 'Australia/Adelaide', '(GMT+09:30) Adelaide'),
(73, 'Australia/Darwin', '(GMT+09:30) Darwin'),
(74, 'Australia/Brisbane', '(GMT+10:00) Brisbane'),
(75, 'Australia/Canberra', '(GMT+10:00) Canberra, Melbourne, Sydney'),
(76, 'Australia/Hobart', '(GMT+10:00) Hobart'),
(77, 'Pacific/Guam', '(GMT+10:00) Guam, Port Moresby'),
(78, 'Asia/Vladivostok', '(GMT+10:00) Vladivostok'),
(79, 'Asia/Magadan', '(GMT+11:00) Magadan, Solomon Is., New Caledonia'),
(80, 'Pacific/Auckland', '(GMT+12:00) Auckland, Wellington'),
(81, 'Pacific/Fiji', '(GMT+12:00) Fiji, Kamchatka, Marshall Is.'),
(82, 'Pacific/Tongatapu', '(GMT+13:00) Nuku\'alofa'),
(83, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_email` varchar(155) NOT NULL,
  `user_joindate` date NOT NULL,
  `user_lastlogin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_name` varchar(155) NOT NULL,
  `user_pass` varchar(155) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `user_branch` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_email`, `user_joindate`, `user_lastlogin`, `user_name`, `user_pass`, `user_type`, `user_branch`) VALUES
(2, 'admin@spykra.com', '2020-02-17', '2020-02-23 17:30:20', 'Super Administrator', '21232f297a57a5a743894a0e4a801fc3', 'admin', '1'),
(8, 'branch@spykra.com', '2020-02-23', '2020-02-23 17:30:30', 'Branch', '341eb9710730e0bfc224e47d076bb63a', 'branch admin', '1'),
(9, 'admin@spykra.com', '2020-06-02', '2020-06-02 14:15:39', 'Administrator', '21232f297a57a5a743894a0e4a801fc3', 'admin', ''),
(10, 'admin@demo.com', '2022-04-18', '2022-04-18 09:41:26', 'Administrator', '21232f297a57a5a743894a0e4a801fc3', 'admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_utility_bill_cat`
--

CREATE TABLE `tbl_utility_bill_cat` (
  `id` int(11) NOT NULL,
  `utility_bill_cat_name` varchar(250) NOT NULL,
  `utility_bill_cat_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_pages`
--

CREATE TABLE `tbl_web_pages` (
  `id` int(11) NOT NULL,
  `web_page_name` varchar(250) NOT NULL,
  `show_in_menu` tinyint(1) NOT NULL,
  `web_page_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_web_pages`
--

INSERT INTO `tbl_web_pages` (`id`, `web_page_name`, `show_in_menu`, `web_page_content`) VALUES
(1, 'Home Page', 1, '<h2>What is Lorem Ipsum?</h2>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n\n<h2>Why do we use it?</h2>\n\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\n\n<p>&nbsp;</p>\n\n<h2>Where does it come from?</h2>\n\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>\n\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\n\n<h2>Where can I get some?</h2>\n\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `tbl_beds`
--
ALTER TABLE `tbl_beds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bed_assign`
--
ALTER TABLE `tbl_bed_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_branches`
--
ALTER TABLE `tbl_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_complaints`
--
ALTER TABLE `tbl_complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_complaint_cat`
--
ALTER TABLE `tbl_complaint_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_dhpms_options`
--
ALTER TABLE `tbl_dhpms_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_doc_type`
--
ALTER TABLE `tbl_doc_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_templates`
--
ALTER TABLE `tbl_email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_es_assign`
--
ALTER TABLE `tbl_es_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_exp_cat`
--
ALTER TABLE `tbl_exp_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_extra_services`
--
ALTER TABLE `tbl_extra_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_invoice_items`
--
ALTER TABLE `tbl_invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_invoice_payments`
--
ALTER TABLE `tbl_invoice_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_languages`
--
ALTER TABLE `tbl_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notices`
--
ALTER TABLE `tbl_notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_requests`
--
ALTER TABLE `tbl_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tenants`
--
ALTER TABLE `tbl_tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_uid` (`ten_uid`) USING BTREE;

--
-- Indexes for table `tbl_timezones`
--
ALTER TABLE `tbl_timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_utility_bill_cat`
--
ALTER TABLE `tbl_utility_bill_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_web_pages`
--
ALTER TABLE `tbl_web_pages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_beds`
--
ALTER TABLE `tbl_beds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_bed_assign`
--
ALTER TABLE `tbl_bed_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_branches`
--
ALTER TABLE `tbl_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_complaints`
--
ALTER TABLE `tbl_complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_complaint_cat`
--
ALTER TABLE `tbl_complaint_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_dhpms_options`
--
ALTER TABLE `tbl_dhpms_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_doc_type`
--
ALTER TABLE `tbl_doc_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_email_templates`
--
ALTER TABLE `tbl_email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_es_assign`
--
ALTER TABLE `tbl_es_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_exp_cat`
--
ALTER TABLE `tbl_exp_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_extra_services`
--
ALTER TABLE `tbl_extra_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_gallery`
--
ALTER TABLE `tbl_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_invoice_items`
--
ALTER TABLE `tbl_invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_invoice_payments`
--
ALTER TABLE `tbl_invoice_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_languages`
--
ALTER TABLE `tbl_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_notices`
--
ALTER TABLE `tbl_notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_requests`
--
ALTER TABLE `tbl_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_tenants`
--
ALTER TABLE `tbl_tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_timezones`
--
ALTER TABLE `tbl_timezones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_utility_bill_cat`
--
ALTER TABLE `tbl_utility_bill_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_web_pages`
--
ALTER TABLE `tbl_web_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
