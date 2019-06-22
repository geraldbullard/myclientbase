-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2019 at 03:22 PM
-- Server version: 5.5.62-cll
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psd_jlab`
--

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `languages_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `charset` varchar(32) NOT NULL,
  `date_format_short` varchar(32) NOT NULL,
  `date_format_long` varchar(32) NOT NULL,
  `time_format` varchar(32) NOT NULL,
  `text_direction` varchar(12) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `numeric_separator_decimal` varchar(12) NOT NULL,
  `numeric_separator_thousands` varchar(12) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`languages_id`, `name`, `code`, `locale`, `charset`, `date_format_short`, `date_format_long`, `time_format`, `text_direction`, `currencies_id`, `numeric_separator_decimal`, `numeric_separator_thousands`, `parent_id`, `sort_order`) VALUES
(1, 'English', 'en_US', 'en_US.UTF-8,en_US,english', 'utf-8', '%m/%d/%Y', '%A %B %d, %Y at %H:%M', '%H:%M:%S', 'ltr', 1, '.', ',', 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `languages_definitions`
--

CREATE TABLE `languages_definitions` (
  `id` int(11) NOT NULL,
  `languages_id` int(11) NOT NULL,
  `content_group` varchar(255) NOT NULL,
  `definition_key` varchar(255) NOT NULL,
  `definition_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages_definitions`
--

INSERT INTO `languages_definitions` (`id`, `languages_id`, `content_group`, `definition_key`, `definition_value`) VALUES
(58, 1, 'core', 'text_country', 'Country'),
(42, 1, 'core', 'text_config_file_writeable', 'I am able to write to the configuration file. This is a potential security risk - please set the right user permissions on this file.'),
(31, 1, 'core', 'text_search', 'Search'),
(105, 1, 'core', 'text_submit', 'Submit'),
(33, 1, 'core', 'text_model', 'Model'),
(106, 1, 'core', 'text_user', 'User'),
(35, 1, 'core', 'text_price', 'Price'),
(36, 1, 'core', 'text_weight', 'Weight'),
(37, 1, 'core', 'text_show', 'Show'),
(38, 1, 'core', 'text_change_password', 'Change Password'),
(39, 1, 'core', 'text_personal_details', 'Personal Details'),
(40, 1, 'core', 'text_address', 'Address'),
(41, 1, 'core', 'text_install_directory_exists', 'Installation directory exists. Please remove this directory for security reasons.'),
(67, 1, 'core', 'text_comments', 'Comments'),
(108, 1, 'core', 'text_existing', 'Existing'),
(19, 1, 'core', 'text_close', 'Close'),
(20, 1, 'core', 'text_confirm', 'Confirm'),
(21, 1, 'core', 'text_continue', 'Continue'),
(22, 1, 'core', 'text_delete', 'Delete'),
(23, 1, 'core', 'text_edit', 'Edit'),
(2, 1, 'core', 'text_privacy', 'Privacy Policy'),
(3, 1, 'core', 'text_terms_conditions', 'Terms & Conditions'),
(4, 1, 'core', 'text_sitemap', 'Sitemap'),
(5, 1, 'core', 'text_toggle_navigation', 'Toggle Navigation'),
(6, 1, 'core', 'text_my_account', 'My Account'),
(7, 1, 'core', 'text_my_password', 'My Password'),
(8, 1, 'core', 'text_home', 'Home'),
(9, 1, 'core', 'text_sign_in', 'Sign In'),
(10, 1, 'core', 'text_sign_out', 'Sign Out'),
(11, 1, 'core', 'text_login', 'Login'),
(12, 1, 'core', 'text_logout', 'Logout'),
(13, 1, 'core', 'text_male', 'Male'),
(14, 1, 'core', 'text_female', 'Female'),
(15, 1, 'core', 'text_please_select', 'Please Select'),
(16, 1, 'core', 'text_required_information', '* Required information'),
(17, 1, 'core', 'text_back', 'Back'),
(18, 1, 'core', 'text_details', 'Details'),
(1, 1, 'core', 'text_contact_us', 'Contact Us'),
(43, 1, 'core', 'text_close_window', 'Close Window'),
(65, 1, 'core', 'text_new_password', 'New Password'),
(61, 1, 'core', 'text_newsletter', 'Newsletter'),
(62, 1, 'core', 'text_password', 'Password'),
(63, 1, 'core', 'text_password_confirmation', 'Password Confirmation'),
(64, 1, 'core', 'text_current_password', 'Current Password'),
(55, 1, 'core', 'text_zip_code', 'Zip Code'),
(56, 1, 'core', 'text_city', 'City'),
(57, 1, 'core', 'text_state', 'State'),
(27, 1, 'core', 'text_number', 'Number'),
(49, 1, 'core', 'text_email_address', 'E-Mail Address'),
(51, 1, 'core', 'text_company_name', 'Company Name'),
(52, 1, 'core', 'text_street_address', 'Street Address'),
(53, 1, 'core', 'text_suburb', 'Suburb'),
(54, 1, 'core', 'text_post_code', 'Postal Code'),
(46, 1, 'core', 'text_last_name', 'Last Name'),
(44, 1, 'core', 'text_gender', 'Gender'),
(45, 1, 'core', 'text_first_name', 'First Name'),
(104, 1, 'core', 'text_user_search', 'User Search'),
(66, 1, 'core', 'text_no_image', 'No Image'),
(47, 1, 'core', 'text_date_of_birth', 'Date of Birth'),
(29, 1, 'core', 'text_status', 'Status'),
(28, 1, 'core', 'text_date', 'Date'),
(59, 1, 'core', 'text_telephone_number', 'Telephone Number'),
(60, 1, 'core', 'text_fax_number', 'Fax Number'),
(107, 1, 'core', 'text_users', 'Users'),
(24, 1, 'core', 'text_save', 'Save'),
(25, 1, 'core', 'text_apply', 'Apply'),
(26, 1, 'core', 'text_view', 'View'),
(68, 1, 'core', 'text_items', 'Items'),
(69, 1, 'core', 'text_item', 'Item'),
(70, 1, 'core', 'text_quantity', 'Quantity'),
(71, 1, 'core', 'text_description', 'Description'),
(72, 1, 'core', 'text_more', 'More'),
(73, 1, 'core', 'text_information', 'Information'),
(74, 1, 'core', 'text_name', 'Name'),
(75, 1, 'core', 'text_print', 'Print'),
(76, 1, 'core', 'text_update', 'Update'),
(77, 1, 'core', 'text_qty', 'Qty'),
(78, 1, 'core', 'text_remove', 'Remove'),
(79, 1, 'core', 'text_navigation', 'Navigation'),
(80, 1, 'core', 'text_feature_not_available', 'Feature not available.'),
(81, 1, 'core', 'text_maintenance_message', 'The site is temporarily offline for maintenance.'),
(82, 1, 'core', 'text_dashboard', 'Dashboard'),
(83, 1, 'core', 'text_cancel', 'Cancel'),
(84, 1, 'core', 'text_site', 'Site'),
(85, 1, 'core', 'text_help', 'Help'),
(86, 1, 'core', 'text_slogan', 'Slogan'),
(87, 1, 'core', 'text_sales', 'Sales'),
(88, 1, 'core', 'text_email', 'Email'),
(89, 1, 'core', 'text_phone', 'Phone'),
(90, 1, 'core', 'text_support', 'Support'),
(91, 1, 'core', 'text_admin_session_active', 'ADMIN SESSION ACTIVE'),
(92, 1, 'core', 'text_file', 'File'),
(93, 1, 'core', 'text_files', 'Files'),
(94, 1, 'core', 'text_share', 'Share'),
(95, 1, 'core', 'text_facebook', 'Facebook'),
(96, 1, 'core', 'text_tweet', 'Tweet'),
(97, 1, 'core', 'text_twitter', 'Twitter'),
(98, 1, 'core', 'text_google', 'Google'),
(99, 1, 'core', 'text_plus_1', '1'),
(101, 1, 'core', 'text_linkedin', 'LinkedIn'),
(102, 1, 'core', 'text_pinterest', 'Pinterest'),
(103, 1, 'core', 'text_tumblr', 'tumblr'),
(109, 1, 'core', 'text_new', 'New'),
(110, 1, 'core', 'text_create', 'Create'),
(111, 1, 'core', 'text_admin', 'Admin'),
(112, 1, 'core', 'text_role', 'Role'),
(113, 1, 'core', 'text_roles', 'Roles'),
(114, 1, 'core', 'text_hidden', 'Hidden'),
(115, 1, 'core', 'text_global', 'Global');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` tinyint(3) NOT NULL,
  `role_id` tinyint(3) NOT NULL,
  `module` varchar(63) NOT NULL,
  `view` varchar(31) DEFAULT NULL,
  `access` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `role_id`, `module`, `view`, `access`) VALUES
(1, 1, 'admin', 'index', 5),
(2, 1, 'user', 'index', 5),
(3, 1, 'user', 'edit', 5),
(4, 1, 'user', 'new', 5),
(5, 1, 'roles', 'index', 5),
(6, 1, 'roles', 'edit', 5),
(7, 1, 'roles', 'new', 5);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `global` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `hidden`, `global`) VALUES
(1, 'Developer', 1, 1),
(2, 'Admin', 0, 0),
(3, 'User', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `define` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `edit` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `system` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `define`, `title`, `summary`, `value`, `edit`, `system`) VALUES
(1, 'siteName', 'Site Name', 'The name to be displayed on your site pages.', 'jLab MVC', 0, 1),
(2, 'siteRoot', 'Site URL', 'The root url for your web site.', 'www.prositedemos.com/jlab/', 0, 1),
(7, 'sessionExpire', 'Admin Session Timeout', 'The time in minutes that your admin session will last before timing out and forcing you to login again.', '30', 0, 1),
(3, 'siteTheme', 'Site Theme', 'This is the name of your site theme', 'bootstrap', 0, 1),
(8, 'googleAnalytics', 'Google Analytics', 'The ID of your Google Anayltics account', 'UA-', 0, 1),
(4, 'siteWidth', 'Site Width', 'The width of your site', '1170px', 0, 1),
(5, 'siteDescription', 'Site Description', 'This is a site wide description. It will also get used in the event that you do not enter any meta tag description for any of your pages.', 'This is my site description.', 0, 1),
(6, 'siteKeywords', 'Site Keywords', 'These are site wide keywords. They will also get used in the event that you do not enter any meta tag keywords for any of your pages.', 'these, are, my, site, keywords', 0, 1),
(9, 'showHelp', 'Show Help Tab', 'Show or hide the help tab in the site admin upper right corner. (yes or no)', 'no', 0, 1),
(10, 'defaultLang', 'Default Admin Language', 'The default language code of the site admin', 'en', 0, 1),
(11, 'sitemapPriority', 'Sitemap Priority', 'The Content Priority for the Sitemap Generation (0.0 - 1.0)', '0.7', 0, 0),
(12, 'sitemapChangeFrequency', 'Sitemap Change Frequency', 'The Content Change Frequency for the Sitemap Generation (always, hourly, daily, weekly, monthly, yearly, never)', 'daily', 0, 0),
(13, 'siteSlogan', 'Site Slogan', 'Site Slogan', 'A truly simple, yet powerful MVC Framework', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `firstname` varchar(128) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(128) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `username` varchar(48) CHARACTER SET utf8 NOT NULL,
  `password` varchar(64) CHARACTER SET utf8 NOT NULL,
  `gender` varchar(1) CHARACTER SET utf8 NOT NULL,
  `role_id` smallint(5) UNSIGNED NOT NULL DEFAULT '1',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `gender`, `role_id`, `status`) VALUES
(1, 'Gerald', 'Bullard Jr', 'gerald.bullard@gmail.com', 'owner', 'a827ac71f7870cc2eabc94e21431b7c63f8a19662ec9bec77e12444f7a3076aa', 'm', 1, 1),
(6, 'Joe', 'Tester', 'j.test@mail.com', 'j.test@mail.com', 'ccbd41cf19c334dd860e953bdaac45007134223d5c389df7547cffb5fd2a7931', '', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`languages_id`);

--
-- Indexes for table `languages_definitions`
--
ALTER TABLE `languages_definitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_LANGUAGES_DEFINITIONS_LANGUAGES` (`languages_id`),
  ADD KEY `IDX_LANGUAGES_DEFINITIONS` (`languages_id`,`content_group`),
  ADD KEY `IDX_LANGUAGES_DEFINITIONS_GROUPS` (`content_group`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`module`,`access`,`view`,`role_id`),
  ADD KEY `fk_permissions_roles1_idx` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`,`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`,`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `languages_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages_definitions`
--
ALTER TABLE `languages_definitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
