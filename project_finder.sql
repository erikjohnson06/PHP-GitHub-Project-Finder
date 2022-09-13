-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 13, 2022 at 02:26 AM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_finder_erikjohnson`
--
CREATE DATABASE IF NOT EXISTS `project_finder_erikjohnson` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `project_finder_erikjohnson`;

-- --------------------------------------------------------

--
-- Table structure for table `github_projects`
--

DROP TABLE IF EXISTS `github_projects`;
CREATE TABLE IF NOT EXISTS `github_projects` (
  `repository_id` int(11) NOT NULL,
  `name` varchar(250) CHARACTER SET utf8 NOT NULL,
  `html_url` varchar(250) CHARACTER SET utf8 NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `stargazers_count` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pushed_at` datetime NOT NULL,
  PRIMARY KEY (`repository_id`),
  UNIQUE KEY `repository_id` (`repository_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `github_projects`
--

INSERT INTO `github_projects` (`repository_id`, `name`, `html_url`, `description`, `stargazers_count`, `created_at`, `pushed_at`) VALUES
(137515, 'mockery', 'https://github.com/mockery/mockery', 'Mockery is a simple yet flexible PHP mock object framework for use in unit testing with PHPUnit, PHPSpec or any other testing framework. Its core goal is to offer a test double framework with a succinct API capable of clearly defining all possible object operations and interactions using a human readable Domain Specific Language (DSL).', 10255, '2009-02-25 19:25:09', '2022-09-07 15:33:35'),
(448045, 'phpunit', 'https://github.com/sebastianbergmann/phpunit', 'The PHP Unit Testing framework.', 18638, '2009-12-24 13:16:23', '2022-09-12 14:52:40'),
(458058, 'symfony', 'https://github.com/symfony/symfony', 'The Symfony PHP framework', 27415, '2010-01-04 14:21:21', '2022-09-13 00:07:08'),
(926544, 'Slim', 'https://github.com/slimphp/Slim', 'Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.', 11390, '2010-09-21 01:17:06', '2022-09-01 03:05:03'),
(1129010, 'jQuery-File-Upload', 'https://github.com/blueimp/jQuery-File-Upload', 'File Upload widget with multiple file selection, drag&drop support, progress bar, validation and preview images, audio and video for jQuery. Supports cross-domain, chunked and resumable file uploads. Works with any server-side platform (Google App Engine, PHP, Python, Ruby on Rails, Java, etc.) that supports standard HTML form file uploads.', 31066, '2010-12-01 15:35:32', '2021-09-30 11:44:03'),
(1280180, 'phabricator', 'https://github.com/phacility/phabricator', 'Effective June 1, 2021: Phabricator is no longer actively maintained.', 12281, '2011-01-21 22:08:29', '2022-06-14 17:12:36'),
(1305114, 'sage', 'https://github.com/roots/sage', 'WordPress starter theme with Laravel Blade components and templates, Tailwind CSS, and a modern development workflow', 11885, '2011-01-29 03:12:09', '2022-08-11 15:11:09'),
(1376664, 'monolog', 'https://github.com/Seldaek/monolog', 'Sends your logs to files, sockets, inboxes, databases and various web services', 19886, '2011-02-17 02:07:15', '2022-09-08 12:29:21'),
(1420053, 'guzzle', 'https://github.com/guzzle/guzzle', 'Guzzle, an extensible PHP HTTP client', 22076, '2011-02-28 02:44:05', '2022-09-06 16:31:18'),
(1548202, 'matomo', 'https://github.com/matomo-org/matomo', 'Liberating Web Analytics. Star us on Github? +1. Matomo is the leading open alternative to Google Analytics that gives you full control over your data. Matomo lets you easily collect data from websites & apps and visualise this data and extract insights. Privacy is built-in. We love Pull Requests! ', 16767, '2011-03-30 21:18:17', '2022-09-13 01:25:00'),
(1631570, 'PHP-Parser', 'https://github.com/nikic/PHP-Parser', 'A PHP parser written in PHP', 15644, '2011-04-18 17:03:47', '2022-09-11 20:06:47'),
(1863329, 'laravel', 'https://github.com/laravel/laravel', 'Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation for your next big idea — freeing you to create without sweating the small things.', 70938, '2011-06-08 03:06:08', '2022-09-11 14:36:50'),
(1864363, 'composer', 'https://github.com/composer/composer', 'Dependency Manager for PHP', 26899, '2011-06-08 08:53:00', '2022-09-12 20:41:39'),
(2234102, 'CodeIgniter', 'https://github.com/bcit-ci/CodeIgniter', 'Open Source PHP Framework (originally from EllisLab)', 18186, '2011-08-19 13:34:00', '2022-09-12 00:03:01'),
(2246815, 'DesignPatternsPHP', 'https://github.com/DesignPatternsPHP/DesignPatternsPHP', 'sample code for several design patterns in PHP 8', 20756, '2011-08-22 05:24:31', '2022-07-19 18:53:47'),
(2253830, 'PHPMailer', 'https://github.com/PHPMailer/PHPMailer', 'The classic email sending library for PHP', 18658, '2011-08-23 07:57:17', '2022-09-12 07:11:44'),
(2579314, 'Faker', 'https://github.com/fzaninotto/Faker', 'Faker is a PHP library that generates fake data for you', 26589, '2011-10-14 22:49:02', '2022-07-11 08:30:23'),
(2854337, 'cphalcon', 'https://github.com/phalcon/cphalcon', 'High performance, full-stack PHP framework delivered as a C extension.', 10616, '2011-11-26 05:52:50', '2022-09-08 17:26:32'),
(2884111, 'magento2', 'https://github.com/magento/magento2', 'All Submissions you make to Magento Inc. (\"Magento\") through GitHub are subject to the following terms and conditions: (1) You grant Magento a perpetual, worldwide, non-exclusive, no charge, royalty free, irrevocable license under your applicable copyrights and patents to reproduce, prepare derivative works of, display, publically perform, sublicense and distribute any feedback, ideas, code, or other information (“Submission\") you submit through GitHub. (2) Your Submission is an original work of authorship and you are the owner or are legally entitled to grant the license stated above. (3) You agree to the Contributor License Agreement found here:  https://github.com/magento/magento2/blob/master/CONTRIBUTOR_LICENSE_AGREEMENT.html', 10233, '2011-11-30 15:30:13', '2022-09-12 23:49:24'),
(2889328, 'WordPress', 'https://github.com/WordPress/WordPress', 'WordPress, Git-ified. This repository is just a mirror of the WordPress subversion repository. Please do not send pull requests. Submit pull requests to https://github.com/WordPress/wordpress-develop and patches to https://core.trac.wordpress.org/ instead.', 16610, '2011-12-01 07:05:17', '2022-09-12 23:52:05'),
(3431193, 'yii2', 'https://github.com/yiisoft/yii2', 'Yii 2: The Fast, Secure and Professional PHP Framework', 13987, '2012-02-13 15:32:36', '2022-09-12 11:59:33'),
(3482588, 'SecLists', 'https://github.com/danielmiessler/SecLists', 'SecLists is the security tester\'s companion. It\'s a collection of multiple types of lists used during security assessments, collected in one place. List types include usernames, passwords, URLs, sensitive data patterns, fuzzing payloads, web shells, and many more.', 41636, '2012-02-19 01:30:18', '2022-09-11 17:30:14'),
(4344257, 'PHP-CS-Fixer', 'https://github.com/FriendsOfPHP/PHP-CS-Fixer', 'A tool to automatically fix PHP Coding Standards issues', 11388, '2012-05-16 06:42:23', '2022-09-12 16:04:08'),
(4702560, 'PHPExcel', 'https://github.com/PHPOffice/PHPExcel', 'ARCHIVED', 11480, '2012-06-18 15:30:27', '2019-01-02 01:38:48'),
(4916869, 'uuid', 'https://github.com/ramsey/uuid', 'A PHP library for generating universally unique identifiers (UUIDs).', 11818, '2012-07-05 23:24:53', '2022-09-13 01:57:35'),
(5627682, 'Mobile-Detect', 'https://github.com/serbanghita/Mobile-Detect', 'Mobile_Detect is a lightweight PHP class for detecting mobile devices (including tablets). It uses the User-Agent string combined with specific HTTP headers to detect the mobile environment.', 10087, '2012-08-31 10:58:16', '2022-05-17 12:13:46'),
(5724990, 'Carbon', 'https://github.com/briannesbitt/Carbon', 'A simple PHP API extension for DateTime.', 15911, '2012-09-08 02:56:20', '2022-09-11 16:47:02'),
(6936773, 'log', 'https://github.com/php-fig/log', NULL, 10008, '2012-11-30 09:49:24', '2021-07-14 16:46:26'),
(7548986, 'framework', 'https://github.com/laravel/framework', 'The Laravel Framework.', 27822, '2013-01-10 21:27:28', '2022-09-12 23:18:16'),
(7549096, 'inflector', 'https://github.com/doctrine/inflector', 'Doctrine Inflector is a small library that can perform string manipulations with regard to uppercase/lowercase and singular/plural forms of words.', 10883, '2013-01-10 21:34:22', '2022-09-08 22:02:48'),
(7579180, 'lexer', 'https://github.com/doctrine/lexer', 'Base library for a lexer that can be used in Top-Down, Recursive Descent Parsers.', 10727, '2013-01-12 18:58:26', '2022-06-28 20:43:52'),
(7704544, 'image', 'https://github.com/Intervention/image', 'PHP Image Manipulation', 12821, '2013-01-19 15:05:32', '2022-08-23 18:21:40'),
(7769432, 'phpdotenv', 'https://github.com/vlucas/phpdotenv', 'Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.', 12135, '2013-01-23 06:57:12', '2022-07-06 04:46:37'),
(8678290, 'laravel-ide-helper', 'https://github.com/barryvdh/laravel-ide-helper', 'Laravel IDE Helper', 12570, '2013-03-10 00:12:55', '2022-09-12 12:31:38'),
(8708394, 'whoops', 'https://github.com/filp/whoops', 'PHP errors for cool kids ', 12829, '2013-03-11 16:58:27', '2022-07-04 15:35:24'),
(10157178, 'EmailValidator', 'https://github.com/egulias/EmailValidator', 'PHP Email address validator', 10802, '2013-05-19 15:23:00', '2022-09-10 06:15:17'),
(11323319, 'parsedown', 'https://github.com/erusev/parsedown', 'Better Markdown Parser in PHP', 14233, '2013-07-10 20:23:25', '2022-06-15 20:08:22'),
(12615154, 'laravel-debugbar', 'https://github.com/barryvdh/laravel-debugbar', 'Laravel Debugbar (Integrates PHP Debug Bar)', 14421, '2013-09-05 10:26:54', '2022-08-04 09:41:47'),
(13899674, 'flysystem', 'https://github.com/thephpleague/flysystem', 'Abstraction for local and remote filesystems', 12625, '2013-10-27 11:07:22', '2022-09-12 21:13:38'),
(14259390, 'Laravel-Excel', 'https://github.com/SpartnerNL/Laravel-Excel', '', 11019, '2013-11-09 15:28:40', '2022-07-10 08:33:02'),
(14732311, 'october', 'https://github.com/octobercms/october', 'Self-hosted CMS platform based on the Laravel PHP Framework.', 10793, '2013-11-26 23:30:43', '2022-09-12 02:35:54'),
(15020102, 'workerman', 'https://github.com/walkor/workerman', 'An asynchronous event driven PHP socket framework. Supports HTTP, Websocket, SSL and other custom protocols. PHP>=5.4.', 10042, '2013-12-08 07:49:28', '2022-09-09 03:21:30'),
(22553797, 'grav', 'https://github.com/getgrav/grav', 'Modern, Crazy Fast, Ridiculously Easy and Amazingly Powerful Flat-File CMS powered by PHP, Markdown, Twig, and Symfony', 13448, '2014-08-02 18:29:10', '2022-09-08 18:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `github_projects_request_manager`
--

DROP TABLE IF EXISTS `github_projects_request_manager`;
CREATE TABLE IF NOT EXISTS `github_projects_request_manager` (
  `is_running` tinyint(1) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `error_msg` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `github_projects_request_manager`
--

INSERT INTO `github_projects_request_manager` (`is_running`, `start_time`, `end_time`, `error_msg`) VALUES
(0, '2022-09-12 22:23:27', '2022-09-12 22:23:57', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
