-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 22, 2025 at 03:04 AM
-- Server version: 10.3.39-MariaDB
-- PHP Version: 8.1.31
CREATE DATABASE IF NOT EXISTS lab-data-manager;
USE lab-data-manager;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shashika_portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `details`, `created_at`, `updated_at`) VALUES
(1, 'About Me ', 'My name is Shashi Kanta Das. DevOps Engineer with containerization, CI/CD pipelines, and cloud infrastructure expertise. Skilled in Docker, Kubernetes, AWS, Terraform, Jenkins, observability tools. Passionate about automating deployment and scaling production systems.\r\n', '2023-06-27 07:13:42', '2025-03-06 03:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `fullName`, `email`, `phone`, `message`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'johndoe@example.com', '123-456-7890', 'Hello, I\'m interested in your services.', '2023-06-27 16:39:12', '2023-06-27 16:39:12'),
(2, 'Shashi Kanta Das', 'skd.bsti@gmail.com', '01735431721', 'I am interested in your business', '2023-06-28 06:05:16', '2023-06-28 06:05:16'),
(3, 'Shashi Kanta Das', 'skd.bsti@gmail.com', '01735431721', 'I am interested in your business', '2023-06-28 06:08:04', '2023-06-28 06:08:04'),
(4, 'Shashi Kanta Das', 'skd.bsti@gmail.com', '01735431721', 'no', '2023-06-28 06:08:21', '2023-06-28 06:08:21'),
(5, 'Shashi Kanta Das', 'skd.bsti@gmail.com', '01735431721', 'I am interested in your meeting', '2023-06-28 06:16:47', '2023-06-28 06:16:47'),
(6, 'Shashi Kanta Das', 'skd.bsti@gmail.com', '01735431721', 'after sleep method', '2023-06-28 06:19:25', '2023-06-28 06:19:25'),
(7, 'Shashi Kanta Das', 'skd.bsti@gmail.com', '01735431721', 'mo', '2023-06-28 06:22:21', '2023-06-28 06:22:21'),
(8, 'Shashi Kanta Das', 'skd.bsti@gmail.com', '01735431721', 'kgg', '2023-06-28 06:22:39', '2023-06-28 06:22:39'),
(9, 'Shashi Kanta Das', 'skd.bsti@gmail.com', '01735431721', 'ggjhgjhg', '2023-06-28 13:29:21', '2023-06-28 13:29:21'),
(10, 'Shashi Kanta Das', 'shashidas95@gmail.com', '01735431721', 'hi', '2025-02-04 13:31:09', '2025-02-04 13:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `duration` varchar(50) NOT NULL,
  `institutionName` varchar(50) NOT NULL,
  `field` varchar(200) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `duration`, `institutionName`, `field`, `details`, `created_at`, `updated_at`) VALUES
(4, '2023-2024', 'DIPTI, Dhaka', 'Mastering in DevOps Engineering', '- Linux for DevOps & Cloud Engineer\r\n- Docker Certified Associate (DCA)\r\n- Git and GitHub for DevOps Engineer\r\n- Certified Kubernetes Administrator (CKA)\r\n- CI/CD Pipelines with Jenkins\r\n- AWS Solutions Architect\r\n', '2023-06-27 06:37:36', '2025-03-05 17:57:53'),
(7, '2022-2023', 'Online Learning Platform, Ostad, Dhaka', '\r\nFull Stack Web Development with PHP, Laravel & Vue.js\r\n\r\n', '\r\nCompleted an intensive web development program covering PHP, and  framework -Laravel and vue.Js', '2023-06-27 06:37:36', '2025-03-05 17:57:37'),
(8, '2019-2020', 'Online Learning Platform, Shikhbe Shobai, Dhaka', 'Full Stack Development', 'Took courses in intensive HTML, Javascript, PHP, and CSS.', '2023-06-27 06:37:36', '2025-03-05 17:56:50'),
(9, '2018-2019', 'Online Learning Platform, Shikhbe Shobai, Dhaka', 'Certificate in Graphic Design', 'Learned graphic design principles, typography, and software skills.', '2023-06-27 06:37:36', '2025-03-05 17:57:12'),
(10, '2005-2007', 'Shahjalal University of Science $ Technolgy', 'Chemical Engineering and Polymer Science', 'Studied a Bachelor of Science in Chemical Engineering and Polymer Science.', '2023-06-27 06:37:36', '2025-03-05 17:54:32');

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `duration` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `designation` varchar(500) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `organizationName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `duration`, `title`, `designation`, `details`, `created_at`, `updated_at`, `organizationName`) VALUES
(1, '2010-present', 'DevOps Engineer', 'Backend Developer', 'Worked as a backend developer, responsible for developing and maintaining server-side logic and APIs using PHP and Laravel framework. Collaborated with front-end developers to integrate user-facing elements with server-side logic.', '2023-06-27 06:10:19', '2025-03-06 02:49:18', 'BSTI,BD');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `heroproperties`
--

CREATE TABLE `heroproperties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keyLine` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `short_title` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `heroproperties`
--

INSERT INTO `heroproperties` (`id`, `keyLine`, `title`, `short_title`, `img`, `created_at`, `updated_at`) VALUES
(1, 'AUTOMATE · SCALE · SECURE', 'I can help your infrastructure to', 'Deploy faster and run smoother 🚀', 'https://www.shashikanta.com/assets/my_profile.png', '2023-06-27 07:07:57', '2025-03-06 04:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'HTML', '2023-06-27 06:55:28', '2023-06-27 06:55:28'),
(2, 'CSS', '2023-06-27 06:55:28', '2023-06-27 06:55:45'),
(3, 'JavaScript', '2023-06-27 06:55:28', '2023-06-27 06:55:28'),
(4, 'PHP', '2023-06-27 06:55:28', '2023-06-27 06:55:28'),
(5, 'Python', '2023-06-27 06:55:28', '2023-06-27 06:55:28');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_06_24_032626_create_contacts', 1),
(6, '2023_06_24_032707_create_abouts', 1),
(7, '2023_06_24_032707_create_educations', 1),
(8, '2023_06_24_032707_create_experiences', 1),
(9, '2023_06_24_032707_create_heroproperties', 1),
(10, '2023_06_24_032707_create_languages', 1),
(11, '2023_06_24_032707_create_resumes', 1),
(12, '2023_06_24_032707_create_seoproperties', 1),
(13, '2023_06_24_032707_create_skills', 1),
(14, '2023_06_24_032707_create_socials', 1),
(15, '2023_06_24_032708_create_projects', 1),
(16, '2023_06_29_024210_create_roles_table', 2),
(17, '2023_06_29_024220_create_user_role_table', 2),
(18, '2023_06_29_044045_change_column_type_in_projects_table', 3),
(19, '2023_06_29_084305_add_organization_name_to_experiences_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(500) NOT NULL,
  `previewLink` varchar(500) NOT NULL,
  `thumbnailLink` varchar(500) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `previewLink`, `thumbnailLink`, `details`, `created_at`, `updated_at`) VALUES
(1, 'Automate  Continuous Integration/Continuous Deployment (CI/CD) process ', 'https://medium.com/@shashidas95/configure-a-generic-webhook-trigger-in-jenkins-for-continuous-integration-649396ab5c85', 'https://miro.medium.com/v2/resize:fit:1400/0*jOwdRUQ8h3cESljZ', 'Do you want to automate your Continuous Integration/Continuous Deployment (CI/CD) process and save time? In this blog post, I’ll guide you through the steps to set up a generic webhook in Jenkins, allowing your projects to build automatically with every commit or pull request.\n\nBy the end of this guide, your Jenkins jobs will be triggered automatically by events from GitHub making your workflow much smoother and efficient. Let’s dive in!', '2023-06-27 04:43:39', '2025-03-05 13:36:45'),
(2, 'Automating AWS Infrastructure Deployment with Jenkins and Terraform', 'https://medium.com/@shashidas95/automating-aws-infrastructure-deployment-with-jenkins-and-terraform-197e7d569fe4', 'https://miro.medium.com/v2/resize:fit:1400/1*Q2ULHJB28fJvPQdmR-QlWg.jpeg', 'End-to-End CI/CD pipeline using Jenkins and Terraform to deploy a Node.js and MySQL-based application on AWS. We will provision an EC2 instance, S3 bucket, and RDS MySQL database using Terraform and automate the entire process with Jenkins running on macOS.', '2023-06-27 04:43:39', '2025-03-05 14:42:37'),
(3, 'Mobile Expense Tracker', 'https://dummyimage.com', 'https://dummyimage.com/300x400/343a40/6c757d', 'A mobile expense tracking app built for iOS and Android using React Native. The app enables users to track their expenses, set budgets, and generate reports for better financial management.', '2023-06-27 04:43:39', '2023-06-28 16:04:29'),
(4, 'Portfolio Website', 'https://dummyimage.com', 'https://dummyimage.com/300x400/343a40/6c757d', 'A personal portfolio website showcasing my work and skills. The website is built using HTML, CSS, and JavaScript, and it includes sections for projects, about me, and contact information.', '2023-06-27 04:43:39', '2023-06-28 16:04:18'),
(5, 'Task Management App', 'https://dummyimage.com', 'https://dummyimage.com/300x400/343a40/6c757d', 'A task management application developed using Django and Angular. The app allows users to create tasks, assign them to team members, track progress, and set deadlines for efficient project management.', '2023-06-27 04:43:39', '2023-06-28 16:04:07'),
(6, 'Music Streaming Service', 'https://dummyimage.com', 'https://dummyimage.com/300x400/343a40/6c757d', 'An online music streaming platform that provides access to a vast library of songs. The service offers features like personalized playlists, recommendations, and social sharing, built using technologies such as Node.js and MongoDB.', '2023-06-27 04:43:39', '2023-06-28 16:03:55'),
(7, 'Food Delivery App', 'https://dummyimage.com', 'https://dummyimage.com/300x400/343a40/6c757d', 'A food delivery application built for iOS and Android using Flutter. The app allows users to browse nearby restaurants, place orders, track deliveries in real-time, and make payments securely.', '2023-06-27 04:43:39', '2023-06-28 16:03:43'),
(8, 'Online Learning Platform', 'https://dummyimage.com', 'https://dummyimage.com/300x400/343a40/6c757d', 'An online learning platform offering courses on various subjects. The platform supports video lectures, quizzes, assignments, and discussion forums, and it is built using technologies like Ruby on Rails and PostgreSQL.', '2023-06-27 04:43:39', '2023-06-28 16:03:26'),
(9, 'Travel Booking Website', 'https://dummyimage.com', 'https://dummyimage.com/300x400/343a40/6c757d', 'A travel booking website that allows users to search for flights, hotels, and vacation packages. The website integrates with third-party APIs for real-time availability and booking, and it is developed using PHP and MySQL.', '2023-06-27 04:43:39', '2023-06-28 16:03:10'),
(10, 'Fitness Tracking App', 'https://dummyimage.com', 'https://dummyimage.com/300x400/343a40/6c757d', 'A fitness tracking app for monitoring workouts and progress. The app provides features such as exercise tracking, goal setting, workout history, and performance analytics, and it is built using Kotlin and Firebase.', '2023-06-27 04:43:39', '2023-06-28 16:02:52');

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `downloadLink` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`id`, `downloadLink`, `created_at`, `updated_at`) VALUES
(1, 'https://www.shashikanta.com/assets/shashi_resume.pdf', '2023-06-27 07:05:36', '2025-03-05 16:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seoproperties`
--

CREATE TABLE `seoproperties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pageName` enum('home','resume','projects','contacts') NOT NULL,
  `title` varchar(50) NOT NULL,
  `keywords` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `ogSiteName` varchar(100) NOT NULL,
  `ogUrl` varchar(100) NOT NULL,
  `ogTitle` varchar(100) NOT NULL,
  `ogDescription` varchar(500) NOT NULL,
  `ogImage` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seoproperties`
--

INSERT INTO `seoproperties` (`id`, `pageName`, `title`, `keywords`, `description`, `ogSiteName`, `ogUrl`, `ogTitle`, `ogDescription`, `ogImage`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Home Page Title', 'home, keywords, SEO', 'This is the description for the home page.', 'My Website', 'https://example.com', 'My Website - Home', 'Open Graph description for the home page.', 'image_url_for_home_page.jpg', '2023-06-30 02:23:31', '2023-06-30 02:23:31'),
(2, 'resume', 'Resume Page Title', 'resume, CV, experience', 'This is the description for the resume page.', 'My Website', 'https://example.com/resume', 'My Website - Resume', 'Open Graph description for the resume page.', 'image_url_for_resume_page.jpg', '2023-06-30 02:23:31', '2023-06-30 02:23:31'),
(5, 'projects', 'Projects Page Title', 'projects, portfolio, showcase', 'This is the description for the projects page.', 'My Website', 'https://example.com/projects', 'My Website - Projects', 'Open Graph description for the projects page.', 'image_url_for_projects_page.jpg', '2023-06-30 02:36:46', '2023-06-30 02:36:46'),
(6, 'contacts', 'Contacts Page Title', 'contacts, email, phone', 'This is the description for the contacts page.', 'My Website', 'https://example.com/contacts', 'My Website - Contacts', 'Open Graph description for the contacts page.', 'image_url_for_contacts_page.jpg', '2023-06-30 02:36:46', '2023-06-30 02:36:46');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Deployment & CI/CD: Docker, Jenkins, Terraform', '2023-06-27 06:27:19', '2025-03-05 16:53:03'),
(2, 'Cloud Platforms: AWS (EC2, S3, RDS)', '2023-06-27 06:27:19', '2025-03-05 16:53:03'),
(3, 'Container Orchestration: Kubernetes', '2023-06-27 06:27:19', '2025-03-05 16:53:03'),
(4, 'Monitoring & Automation Tools: Prometheus, Ansible, Grafana', '2023-06-27 06:27:19', '2025-03-05 16:53:03'),
(5, '\r\nInfrastructure as Code (IaC): Terraform', '2023-06-27 06:27:19', '2025-03-05 17:09:29'),
(6, 'Scripting: Shell Scripting, Python', '2023-06-27 06:27:19', '2025-03-05 17:09:29'),
(7, 'Languages & Frameworks: PHP,Python, Laravel\r\nFront-End Technologies: HTML, CSS, Tailwind CSS\r\n', '2023-06-27 06:27:19', '2025-03-05 17:09:29'),
(8, '\r\nDatabase Management: MySQL, MongoDB, SQLite', '2023-06-27 06:27:19', '2025-03-05 17:09:29'),
(9, 'Version Control: Git, GitHub', '2023-06-27 06:27:19', '2025-03-05 17:09:29'),
(10, '\r\nRESTful API Development\r\nTesting & Debugging: PHPUnit, Postman', '2023-06-27 06:52:39', '2025-03-05 17:09:29');

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `githubLink` varchar(300) NOT NULL,
  `twitterLink` varchar(300) NOT NULL,
  `linkedinLink` varchar(300) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `socials`
--

INSERT INTO `socials` (`id`, `githubLink`, `twitterLink`, `linkedinLink`, `created_at`, `updated_at`) VALUES
(1, 'https://github.com/shashidas95', 'https://twitter.com/example_user1', 'https://linkedin.com/in/example_user1', '2023-06-27 06:59:15', '2023-06-29 16:10:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `heroproperties`
--
ALTER TABLE `heroproperties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `seoproperties`
--
ALTER TABLE `seoproperties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_role_user_id_foreign` (`user_id`),
  ADD KEY `user_role_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `heroproperties`
--
ALTER TABLE `heroproperties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seoproperties`
--
ALTER TABLE `seoproperties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;


