UPDATE `tbl_dhpms_options` SET `opt_value` = '3.0.1' WHERE `tbl_dhpms_options`.`id` = 8;

ALTER TABLE `tbl_tenants` CHANGE `ten_uid` `ten_uid` INT(11) NOT NULL;

ALTER TABLE `tbl_rooms` CHANGE `room_uid` `room_uid` INT(11) NOT NULL;

ALTER TABLE `tbl_beds` CHANGE `bed_uid` `bed_uid` INT(11) NOT NULL;

CREATE TABLE `tbl_blog` (
  `id` int(11) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_image` varchar(255) NOT NULL,
  `blog_content` text NOT NULL,
  `blog_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tbl_blog`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `tbl_dhpms_options` (`id`, `opt_key`, `opt_value`) VALUES
(47, 'enable_registration', 'true'),
(48, 'enable_room_change_request', 'true'),
(49, 'url_rewrite', 'true'),
(50, 'web_template', 'default');

CREATE TABLE `tbl_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `tbl_gallery` (
  `id` int(11) NOT NULL,
  `gal_img` varchar(255) NOT NULL,
  `gal_title` varchar(255) NOT NULL,
  `gal_slider_img` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_gallery` (`id`, `gal_img`, `gal_title`, `gal_slider_img`) VALUES
(1, 'a08fd-bed-142517_1280.jpg', 'Welcome to Calgary HMS', 1),
(2, 'bfef4-flats-4417311_1280.jpg', 'Best Hostel management software', 1),
(3, '18298-room-3810680_1280.jpg', 'One application for Multiple Branches', 1);

ALTER TABLE `tbl_gallery`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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

ALTER TABLE `tbl_requests`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

INSERT INTO `tbl_web_pages` (`web_page_name`, `show_in_menu`, `web_page_content`) VALUES
('Home Page', 1, '<h2>What is Lorem Ipsum?</h2>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\n\n<h2>Why do we use it?</h2>\n\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\n\n<p>&nbsp;</p>\n\n<h2>Where does it come from?</h2>\n\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>\n\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\n\n<h2>Where can I get some?</h2>\n\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\n');

