-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2024 at 05:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cwdgkp_pk`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor_categories`
--

CREATE TABLE `contractor_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractor_categories`
--

INSERT INTO `contractor_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'PK-C-A', '2024-08-28 07:18:03', '2024-08-28 07:18:03'),
(2, 'PK-C-B', '2024-08-28 07:18:13', '2024-08-28 07:18:13'),
(3, 'PK-C-1', '2024-08-28 07:18:22', '2024-08-28 07:18:22'),
(4, 'PK-C-2', '2024-08-28 07:18:33', '2024-08-28 07:18:33'),
(5, 'PK-C-3', '2024-08-28 07:18:39', '2024-08-28 07:18:39'),
(6, 'PK-C-4', '2024-08-28 07:18:42', '2024-08-28 07:18:42'),
(7, 'PK-C-5', '2024-08-28 07:19:04', '2024-08-28 07:19:04'),
(8, 'PK-C-6', '2024-08-28 07:19:09', '2024-08-28 07:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_registrations`
--

CREATE TABLE `contractor_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contractor_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(45) DEFAULT NULL,
  `cnic` varchar(45) NOT NULL,
  `district` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pec_number` varchar(100) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `category_applied` varchar(45) NOT NULL,
  `pec_category` varchar(45) NOT NULL,
  `fbr_ntn` varchar(45) DEFAULT NULL,
  `kpra_reg_no` varchar(45) DEFAULT NULL,
  `pre_enlistment` varchar(255) DEFAULT NULL,
  `is_limited` varchar(45) NOT NULL DEFAULT 'no',
  `cnic_front_attachment` varchar(255) DEFAULT NULL,
  `cnic_back_attachment` varchar(255) DEFAULT NULL,
  `fbr_attachment` varchar(255) DEFAULT NULL,
  `kpra_attachment` varchar(255) DEFAULT NULL,
  `pec_attachment` varchar(255) DEFAULT NULL,
  `form_h_attachment` varchar(255) DEFAULT NULL,
  `pre_enlistment_attachment` varchar(255) DEFAULT NULL,
  `is_agreed` varchar(45) NOT NULL DEFAULT 'no',
  `defer_status` tinyint(1) NOT NULL DEFAULT 0,
  `approval_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contractor_registrations`
--

INSERT INTO `contractor_registrations` (`id`, `contractor_name`, `email`, `mobile_number`, `cnic`, `district`, `address`, `pec_number`, `owner_name`, `category_applied`, `pec_category`, `fbr_ntn`, `kpra_reg_no`, `pre_enlistment`, `is_limited`, `cnic_front_attachment`, `cnic_back_attachment`, `fbr_attachment`, `kpra_attachment`, `pec_attachment`, `form_h_attachment`, `pre_enlistment_attachment`, `is_agreed`, `defer_status`, `approval_status`, `created_at`, `updated_at`) VALUES
(7008, 'M/S KARIM DAD NINGOLAI ', 'karimdadningolai@gmail.com', '0343-9631927', '15602-0359466-5', 'Karim Dad', 'Village Ningoai Tehsil Kabal District swat.', 'swat', 'C/4  10949', 'PK-C-4', 'PK-C-4', '1560203594665', '5267952-0', NULL, 'no', 'CNIC-56aab540.jpeg', NULL, 'FBR-7867572f.jpeg', 'KIPRA-fc66f450.jpeg', 'PEC2020-0e327c88.jpeg', '', 'PE-b55c11fa.jpeg', 'no', 0, 1, '2021-06-30 01:06:03', '2024-08-18 05:16:52'),
(7011, 'M/S KARIM DAD NINGOLAI ', 'muhammad.rafiq53@gmail.com', '0343-9631927', '15602-0359466-5', 'Karim Dad', 'Village Nigolai Tehsil Kabal District swat', 'swat', 'C/4  10949', 'PK-C-4', 'PK-C-4', '1560203594665', '5267952-0', NULL, 'no', 'CNIC-aa420e61.jpeg', NULL, 'FBR-f3e6cb7d.jpeg', 'KIPRA-d37764ab.jpeg', 'PEC2020-4775a618.jpeg', '', 'PE-891db6e6.jpeg', 'no', 1, 1, '2021-06-29 21:06:15', '2024-08-18 05:17:42'),
(7012, 'M/S MUHAMMAD SALIM SHAH', 'msalimshah.co@gmail.com', '0333-9523777', '15601-0986136-1', 'Muhammad Salim Shah ', 'Village Syed Abad Chuprial Tehsil Matta District swat.', 'swat', 'C/5 11563', 'PK-C-5', 'PK-C-5', '1560109861361', '7506215-8', NULL, 'no', 'CNIC-a1600f2a.jpeg', NULL, 'FBR-da83a706.jpeg', 'KIPRA-e2625799.jpeg', 'PEC2020-aa6074f4.jpeg', '', 'PE-04f26a32.jpeg', 'no', 2, 0, '2021-06-29 23:06:45', '2024-08-18 05:22:36'),
(7014, 'Bergalli Construction Company', 'Engr.abdmengal@gmail.com', '03469801518', '1620208979685', 'Himmat Zaman', 'Swabi', 'Swabi', '24156', 'PK-C-5', 'PK-C-5', '8252911-1', 'K8252911-1', NULL, 'no', 'CNIC-040a6b46.jpeg', NULL, 'FBR-dbee8390.jpeg', 'KIPRA-42931f94.jpeg', 'PEC2020-9c662f4c.jpeg', '', '', 'no', 3, 0, '2021-07-01 01:07:43', '2024-08-18 05:23:40'),
(7016, 'Mian Wazir Muhammad', 'mianwazirmardan2021@gmail.com', '03119519880', '1610212410703', 'Mian Wazir Muhammad', 'Mardan', 'Mardan', '24121', 'PK-C-5', 'PK-C-5', '3285526-5', 'K3285526-5', NULL, 'no', 'CNIC-ffad7803.jpeg', NULL, 'FBR-64afc05b.jpeg', 'KIPRA-625ef64b.jpeg', 'PEC2020-0c28372b.jpeg', '', '', 'no', 0, 1, '2021-07-01 01:07:13', '2024-08-18 05:51:40'),
(7019, 'New Fazal Khan & Co', 'fazalmalakandc5@gmail.com', '03449649711', '1540107051499', 'Fazal Khan', 'Malakand', 'Malakand', '24158', 'PK-C-5', 'PK-C-5', '7544607-6', 'K7544607-6', NULL, 'no', 'CNIC-b7d04d21.jpeg', NULL, 'FBR-801da0af.jpeg', 'KIPRA-34d75305.jpeg', 'PEC2020-16dc5564.jpeg', '', '', 'no', 3, 0, '2021-07-02 02:07:01', '2024-08-19 04:47:25'),
(7024, 'S.MUHAMMAD HUSSAIN', 'na@gmail.com', '0312-9834677', '21303-2241999-9', 'SYED MUHAMMAD HUSSAIN', 'C/O GLOBAL SUPER STORE PDA BUILDING PHASE-5 HAYATABAD\r\nCity', 'Peshawar', '12546', 'PK-C-5', 'PK-C-5', '2130322419999', 'K82356737', NULL, 'no', 'CNIC-25befe48.jpeg', NULL, 'FBR-3ba01dc7.jpeg', 'KIPRA-723bafec.jpeg', 'PEC2020-5895aaf9.jpeg', '', '', 'no', 2, 0, '2021-07-02 22:07:49', '2024-08-21 07:02:54'),
(7027, 'FAZAL-E-RAZIQ', 'fazliraziq54@gmail.com', '0344-2402008', '15401-6837176-1', '	FAZAL-E-RAZIQ', 'VILL SAKHA KOT MALAKAND', 'MALAKAND AGENCY', '22841', 'PK-C-5', 'PK-C-5', '1540168371761', 'K7545650-5', NULL, 'no', 'CNIC-6c201f8e.jpeg', NULL, 'FBR-2a2a65ce.jpeg', 'KIPRA-e092a9fb.jpeg', 'PEC2020-7a354ae2.jpeg', '', 'PE-8fce1cf8.jpeg', 'no', 1, 1, '2021-07-05 01:07:15', '2024-08-18 05:52:01'),
(7028, 'Tahir khan shinwari', 'Khantahir787@yahoo.com', '03339610978', '1430141328877', 'Tahir khan', 'Village and p.p. Jungle khel, chowk medan moh shinwari kohat', 'Kohat', '6530', 'PK-C-3', 'PK-C-3', '1430141328877', '1430141328877', NULL, 'no', 'CNIC-77e80c77.jpeg', NULL, 'FBR-20ab5f85.jpeg', 'KIPRA-ebb234c9.jpeg', 'PEC2020-96c4b613.jpeg', '', 'PE-8f60940b.jpeg', 'no', 1, 1, '2021-07-05 03:07:54', '2024-08-21 07:03:04'),
(7029, 'Rahimzay Construction Company', 'Rahimzay91@gmail.com', '03339366392', '1730135599953', 'Muzammil Rahim', 'Peshawar', 'Peshawar', '15320', 'PK-C-4', 'PK-C-4', '7372932-6', 'K7372932-6', NULL, 'no', 'CNIC-6f36cd87.jpeg', NULL, 'FBR-fd53f0d5.jpeg', 'KIPRA-78b8956d.jpeg', 'PEC2020-2ca63224.jpeg', '', '', 'no', 0, 0, '2021-07-05 03:07:59', '2024-08-18 04:59:37'),
(7030, 'Rahimzay Construction Company', 'Rahimzay91@gmail.com', '03339366392', '1730135599953', 'Muzammil Rahim', 'Peshawar', 'Peshawar', '15320', 'PK-C-4', 'PK-C-4', '7372932-6', 'K7372932-6', NULL, 'no', 'CNIC-4eac0695.jpeg', NULL, 'FBR-647dde72.jpeg', 'KIPRA-0c7346eb.jpeg', 'PEC2020-8720e5b2.jpeg', '', '', 'no', 2, 0, '2021-07-05 03:07:03', '2024-08-26 04:37:47'),
(7031, 'Rahimzay Construction Company', 'Rahimzay91@gmail.com', '03339366392', '1730135599953', 'Muzammil Rahim', 'Peshawar', 'Peshawar', '15320', 'PK-C-4', 'PK-C-4', '7372932-6', 'K7372932-6', NULL, 'no', 'CNIC-e182c889.jpeg', NULL, 'FBR-2465c43f.jpeg', 'KIPRA-606c7e5c.jpeg', 'PEC2020-394eb165.jpeg', '', '', 'no', 2, 1, '2021-07-05 03:07:30', '2024-09-01 14:18:43'),
(7032, 'SHAH BROTHERS CONSTRUCTION COMPANY', 'usmashah@gmail.com', '0303-8249334', '42501-2603728-3', 'HAZRAT USMAN SHAH', 'KHAR TEH. KHAR DISTT. BAJAUR AGENCY', 'BAJAUR AGENCY', '15254', 'PK-C-4', 'PK-C-4', '4250126037283', 'ka3405317', NULL, 'no', 'CNIC-987f0603.jpeg', NULL, 'FBR-013c9e91.jpeg', 'KIPRA-8ec3a083.jpeg', 'PEC2020-61ccc79f.jpeg', '', '', 'no', 0, 0, '2021-07-05 05:07:26', '2024-08-18 05:14:06'),
(7034, 'AMJAD & BROTHER', 'info@amjadbrothers.com.pk', '0333-8983043', '17301-4351089-3', 'AMJAD ALI', 'MOH. KHALIL ABAD BASHIR ABAD PAJJAGAI ROAD', 'Peshawar', '23914', 'PK-C-5', 'PK-C-5', '17301-4351089-3', 'k30946719', NULL, 'no', 'CNIC-d2751b3e.jpeg', NULL, 'FBR-3573126d.jpeg', 'KIPRA-ce544b44.jpeg', 'PEC2020-b2a62dd9.jpeg', '', '', 'no', 0, 0, '2021-07-04 22:07:06', '2024-08-19 08:07:01'),
(7035, 'M/s Shahryar builders Peshawar', 'Shahryar799@gmail.com', '03239500644', '17101-0399140-1', ' Shahryar Khan', 'Office No.206, Block-A city tower University road Peshawar.', 'PESHAWAR', '1658', 'PK-C-1', 'PK-C-1', '5082708', 'K5082708-3', NULL, 'no', 'CNIC-c401ad85.jpeg', NULL, 'FBR-7a14c69c.jpeg', 'KIPRA-aa51170f.jpeg', 'PEC2020-abbad3f2.jpeg', '', 'PE-94bcdaa3.jpeg', 'no', 0, 0, '2021-07-06 03:07:42', '2024-08-19 08:07:01'),
(7036, 'M/S SAKHI SULTAN & SONS (PVT) LTD', 'zahidkhan6767750@gmail.com', '0345-9484952', '13503-0563855-5', 'SAKHI SULTAN', 'HOUSE NO. 61, SECTOR-D, TOWNSHIP GHAZIKOT, MANSEHRA.', 'MANSEHRA', '311', 'PK-C-B', 'PK-C-B', '7326630-0', 'K7326630-0', NULL, 'no', 'CNIC-0307b8b4.jpeg', NULL, 'FBR-7f378893.jpeg', 'KIPRA-457cdf48.jpeg', 'PEC2020-6a97d2f8.jpeg', '', 'PE-ba529533.jpeg', 'no', 0, 0, '2021-07-06 05:07:00', '2024-08-19 08:07:01'),
(7042, 'Relacom Pakistan Private Limited', 'waqar.ali@relacom.com.pk', '0320-4143056', '35202-7621776-1', 'Waqar Ali', 'PLOT NO. 27, SARAH PLAZA, E11/3/ISLAMABAD', 'Islamabad', '5222', 'PK-C-3', 'PK-C-3', '2276246', 'K2276246-9', NULL, 'no', 'CNIC-37953a80.png', NULL, 'FBR-7bc1e14b.png', 'KIPRA-f13f6513.png', 'PEC2020-6bb08625.png', 'Form-H-b661ace8.png', '', 'no', 0, 0, '2021-07-06 00:07:00', '2024-08-19 08:07:01'),
(7044, 'Rahman Construction and Engineering co', 'malakand73@gmail.com', '03459287850', '1540169066921', 'LAL RAHMAN', 'Sardar photo copy c/o Faisal ,Shop#5 GF Mehmood Plaza Fazal Haq Road Blue Area Islamabad.', 'MALAKAND', '57652', 'PK-C-6', 'PK-C-6', '4237435-9', 'K4237435-9', NULL, 'no', 'CNIC-9a65df12.jpeg', NULL, 'FBR-a6e0e16e.jpeg', 'KIPRA-554633ce.png', 'PEC2020-7fa1551a.jpeg', '', 'PE-76fbffab.jpeg', 'no', 0, 0, '2021-07-07 02:07:09', '2024-08-19 08:07:01'),
(7045, 'Iceberg Industries', 'sales.pshr@icebergindustries.net', '0333-9197137', '42000-7747585-1', 'Imran Jamil', '51-D, Commercial Area \"A\", Phase-II, D.H.A., Karachi, Pakistan', 'Karachi', '3348', 'PK-C-2', 'PK-C-2', '2232692-8', 'K2232692-8', NULL, 'no', 'CNIC-2b0ac1a3.jpeg', NULL, 'FBR-f673efff.jpeg', 'KIPRA-71b6fa1f.jpeg', 'PEC2020-3b41feab.jpeg', 'Form-H-fa74acb9.jpeg', 'PE-cd3eea76.jpeg', 'no', 0, 0, '2021-07-07 03:07:25', '2024-08-19 08:07:01'),
(7047, 'SHAFIQUE AND SONS', 'ovais.shafique@gmail.com', '0300-9119836', '13101-3774350-5', 'Muhammad Awais Shafique', 'Mohallah Khoi Wala Sheikh ul Bandi,Tehsil & District Abbottabad', 'Abbottabad', '23241', 'PK-C-5', 'PK-C-5', '13101-3774350-5', 'K8093685-3', NULL, 'no', 'CNIC-d51d4800.jpeg', NULL, 'FBR-51107781.jpeg', 'KIPRA-4f817ad2.jpeg', 'PEC2020-f9002df7.jpeg', '', '', 'no', 0, 0, '2021-07-07 04:07:08', '2024-08-19 08:07:01'),
(7048, 'm/s Bangash yousafzai Construction co', 'muhammadkamil2024@gmail.com', '03469399078', '15306-7374687-1', 'sanaullah', 'house#2 street #1 khwaja town Bashir abad near atv boster pajagi road peshawar', 'Dir lower', 'C1/1553', 'PK-C-1', 'PK-C-1', '3285365-3', 'k3285365-3', NULL, 'no', 'CNIC-e5d31316.jpeg', NULL, 'FBR-a4ec45d1.jpeg', 'KIPRA-cf0c3576.jpeg', 'PEC2020-12b7545f.jpeg', '', '', 'no', 0, 0, '2021-07-07 07:07:10', '2024-08-19 08:07:01'),
(7049, 'm/s Bangash yousafzai Construction co', 'muhammadkamil2024@gmail.com', '03469399078', '15306-7374687-1', 'sanaullah', 'house#2 street #1 khwaja town Bashir abad near atv boster pajagi road peshawar', 'Dir lower', 'C1/1553', 'PK-C-1', 'PK-C-1', '3285365-3', 'k3285365-3', NULL, 'no', 'CNIC-b0c88497.jpeg', NULL, 'FBR-9f8c8127.jpeg', 'KIPRA-21c74d84.jpeg', 'PEC2020-060b74ab.jpeg', 'Form-H-f2d0d823.jpeg', 'PE-648fd86c.jpeg', 'no', 0, 0, '2021-07-07 07:07:18', '2024-08-19 08:07:01'),
(7050, 'Hexa Construction and Builders', 'Hexa.builders06@gmail.com', '03069171284', '2303-2894833-5', 'Musawir Hussain', 'Office No.24, Hussain Khan Plaza Parachinar', 'Kurram', '15322', 'PK-C-4', 'PK-C-4', '6930792', '6930792', NULL, 'no', 'CNIC-574a411c.jpeg', NULL, 'FBR-428a3b6e.jpeg', 'KIPRA-2e73fa12.jpeg', 'PEC2020-82b7f937.jpeg', 'Form-H-8b0ee5a8.jpeg', 'PE-89ca2fc9.jpeg', 'no', 0, 0, '2021-07-06 21:07:08', '2024-08-19 08:07:01'),
(7051, 'Walayat Khan Wazir Construction Company Pvt Ltd', 'Walayatwazirrconstruction@gmail.com', '0333-9333324', '1410179414275', 'M', 'Peshawar', 'Peshawar', '1569', 'PK-C-1', 'PK-C-1', '4320740-5', 'K4320740-5', NULL, 'no', 'CNIC-4d087c18.jpeg', NULL, 'FBR-737d7c6e.jpeg', 'KIPRA-64154fa4.jpeg', 'PEC2020-491c68ec.jpeg', '', '', 'no', 0, 0, '2021-07-06 22:07:51', '2024-08-19 08:07:01'),
(7055, 'Sajid and aman government contractor', 'sajid.khan81973@yahoo.com', '03415375933', '1560165865479', 'Sajid ullah', 'Village Baidara, Tehsil matta, swat', 'Swat', 'Civil/44061', 'PK-C-5', 'PK-C-5', 'A255514-4', 'KA255514-4', NULL, 'no', 'CNIC-073d39ed.png', NULL, 'FBR-7bfcbd4d.jpeg', 'KIPRA-9743349f.jpeg', 'PEC2020-37a1bc41.jpeg', '', '', 'no', 0, 0, '2021-07-08 02:07:11', '2024-08-19 08:07:01'),
(7056, 'ITR CREATIVE CONSTRUCTION COMPANY', 'nawaztariq430@gmail.com', '0317-9694589', '17301-7346435-9', 'Tariq Nawaz', 'KOHISTAN GAT TEHSIL BABUZAI SWAT', 'karak', '23465', 'PK-C-5', 'PK-C-5', '8482822-7', 'K8482822-7', NULL, 'no', 'CNIC-825ecd74.jpeg', NULL, 'FBR-f8b7892c.jpeg', 'KIPRA-98954ef1.jpeg', 'PEC2020-28e1453a.jpeg', '', '', 'no', 0, 0, '2021-07-08 02:07:33', '2024-08-19 08:07:01'),
(7058, 'AKHTAR MUNIR & BROTHERS', 'akhtarmunir.1010@gmail.com', '0345-5855744', '13403-6731375-5', 'AKHTAR MUNIR', 'VILL & P.O PATTAN TEH PATTAN DISTT:', 'KOHISTAN', '22839', 'PK-C-5', 'PK-C-5', '72292105', 'k72297843', NULL, 'no', 'CNIC-8933fd1d.jpeg', NULL, 'FBR-8c7168ce.jpeg', 'KIPRA-c5dc9a86.jpeg', 'PEC2020-1acd3762.jpeg', 'Form-H-fbc368cc.jpeg', 'PE-58a156a6.jpeg', 'no', 0, 0, '2021-07-08 00:07:45', '2024-08-19 08:07:01'),
(7059, 'SHAHRYAR BUILDERS PESHAWAR', 'abc@pec.org.pk', '0345-9292656', '17101-0399140-1', 'SHAHRYAR KHAN', 'OFFICE NO. 206 BLOCK-A, CITY TOWER', 'Peshawar', '1658', 'PK-C-1', 'PK-C-1', '5082708', 'k50827083', NULL, 'no', 'CNIC-dfc4cda3.jpeg', NULL, 'FBR-c9ecf681.jpeg', 'KIPRA-148179fa.jpeg', 'PEC2020-c2038b96.jpeg', '', 'PE-bcb95ce2.jpeg', 'no', 0, 0, '2021-07-08 00:07:47', '2024-08-19 08:07:01'),
(7060, 'MUHAMMAD ASLAM KHAN BHITTANI & BROTHERS', 'aslamkhanbhettani@gmail.com', '0345-9848163', '12201-5847852-1', 'Muhammad Aslam Khan', 'C/o: BAKHTA KHAN BHITTANI HOUSE GALI BAGH WALI DISTT', 'DERA ISMAIL KHAN', '489', 'PK-C-A', 'PK-C-A', '1220158478521', 'k23981032', NULL, 'no', 'CNIC-5e24004c.jpeg', NULL, 'FBR-c7c5b4ed.jpeg', 'KIPRA-72c7d75b.jpeg', 'PEC2020-9a33a69b.jpeg', '', 'PE-a9853836.jpeg', 'no', 0, 0, '2021-07-08 00:07:20', '2024-08-19 08:07:01'),
(7061, 'HAIDER ALI', 'haidercontractor99@gmail.com', '0313-9944470', '17301-6214927-3', 'HAIDER ALI', 'VILL. REGI MOH: KANDARAY', 'Peshawar', '14327', 'PK-C-4', 'PK-C-4', '28909330', '17301-6214927-3', NULL, 'no', 'CNIC-db329d11.jpeg', NULL, 'FBR-8db7dc4c.jpeg', 'KIPRA-f9dcb4b0.jpeg', 'PEC2020-0c4428e4.jpeg', '', 'PE-470d3e4b.jpeg', 'no', 0, 0, '2021-07-08 01:07:21', '2024-08-19 08:07:01'),
(7062, 'FAISAL CONSTRUCTION CO', 'faisalconstructioncompany@gmail.com', '0344-1197899', '15302-6380606-5', 'JUNAID HAYAT', 'faisC/O FAISAL PHOTOSTATE NEAR NBP BALAMBAT BAZAR', 'DIR', '1636', 'PK-C-1', 'PK-C-1', '3531764', 'k3531764-7', NULL, 'no', 'CNIC-12eba004.jpeg', NULL, 'FBR-c2d3afcb.jpeg', 'KIPRA-e1159b28.jpeg', 'PEC2020-d2d84b1f.jpeg', 'Form-H-e8f42131.jpeg', 'PE-f592c5f8.jpeg', 'no', 0, 0, '2021-07-08 01:07:16', '2024-08-19 08:07:01'),
(7063, 'WAQAR AHMAD BUILDERS', 'waqarahmadbuilders16@gmail.com', '0301-8188848', '16101-3309960-7', 'Waqar Ahmad', 'POST OFFICE QULANDI, QULANDI BALA TEHSIL AND DISTRICT, DIR', 'DIR', '24117', 'PK-C-5', 'PK-C-5', 'A238017', 'KA238017-3', NULL, 'no', 'CNIC-1383fba1.jpeg', NULL, 'FBR-80efc65c.jpeg', 'KIPRA-09d85a30.jpeg', 'PEC2020-9a11fa62.jpeg', '', '', 'no', 0, 0, '2021-07-09 01:07:44', '2024-08-19 08:07:01'),
(7065, 'ASMAR KHAN', 'asmarkhan1313@gmail.com', '0300-8041313', '15202-0822810-1', 'ASMAR KHAN', 'C/O GREEN MEDICAL STORE 12- SOEKARNO SQUARE KHYBER', 'Peshawar', '1610', 'PK-C-1', 'PK-C-1', '15202-0822810-1', '50525212', NULL, 'no', 'CNIC-cd18efeb.jpeg', NULL, 'FBR-734b2de4.jpeg', 'KIPRA-2cd209ea.jpeg', 'PEC2020-eb79a893.jpeg', '', 'PE-d5abb1ff.jpeg', 'no', 0, 0, '2021-07-09 02:07:39', '2024-08-19 08:07:01'),
(7068, 'M.ADNAN CONSTRUCTION CO', 'Salmankhanjasmine@gmail.com', '0345-9526189', '15602-4425455-7', 'MUHAMMAD ADNAN', 'Mohallah khwaja kheil,village Gogdara,post office Tariq Abad, Tesil Babozai, Distt Swat, kpk', 'SWAT', '22709', 'PK-C-5', 'PK-C-5', '4308260-2', 'K-4308260-2', NULL, 'no', 'CNIC-b59641f0.jpeg', NULL, 'FBR-de80c5e3.jpeg', 'KIPRA-d2b07d49.jpeg', 'PEC2020-01ecc49f.jpeg', '', 'PE-2100b592.jpeg', 'no', 0, 0, '2021-07-10 00:07:22', '2024-08-19 08:07:01'),
(7069, 'DUBAI GROUP OF CONSTRUCTION', 'dubai.group.construction@gmail.com', '0345-9332430', '16102-1212040-3', 'Hazrat Umar', 'ST#5, MAZDOOR ABAD, TAKHT BHAI, MARDAN ', 'Mardan', '24118', 'PK-C-5', 'PK-C-5', '7585614-0', 'K7585614-0', NULL, 'no', 'CNIC-ef95a85f.jpeg', NULL, '', 'KIPRA-0fea75d4.jpeg', 'PEC2020-3b498cbc.jpeg', '', '', 'no', 0, 0, '2021-07-10 21:07:05', '2024-08-19 08:07:01'),
(7072, 'KASIB BUILDERS AND DEVELOPERS (PRIVATE LIMITED)', 'mubeenabbas778@gmail.com', '0342-8333268', '54400-6010948-3', 'Mohammad Awais Ali', 'OFFICE 102 PLOT NO 25 IST FLOOR SAVOY ARCADE HILAL ROAD F11 MARKAZ ISLAMABAD ', 'Islamabad', 'CA/482', 'PK-C-A', 'PK-C-A', '5249129', 'K5249129-5 ', NULL, 'no', 'CNIC-2ce28b26.jpeg', NULL, 'FBR-59c58f88.jpeg', 'KIPRA-e8673964.jpeg', 'PEC2020-761b7a2b.jpeg', '', '', 'no', 0, 0, '2021-07-12 02:07:19', '2024-08-19 08:07:01'),
(7073, 'm/s azmatullah construction company (acc)', 'azmatullah.icp@gmail.com', '0304-9396411', '21302-1643216-3', 'azmatullah', 'Mindar khan house st#3, upper sateen, sadda kurram agency', 'kurram', '491073', 'PK-C-4', 'PK-C-4', '21302-1643216-3', 'k7249640', NULL, 'no', 'CNIC-07476386.jpeg', NULL, 'FBR-e3d13c98.jpeg', 'KIPRA-5ee806ca.jpeg', 'PEC2020-6f9e3cf3.jpeg', '', 'PE-bbb2eeb7.jpeg', 'no', 0, 0, '2021-07-12 06:07:08', '2024-08-19 08:07:01'),
(7075, 'AL-HABIB & SONS ENTERPRISES', 'alhabibandsonsenterprises@gmail.com', '0307-8060003', '13401-1506779-7', 'Sabir Hussain', '	KOHISTAN SAW TEH: DASSU', 'KOHISTAN', '22844', 'PK-C-5', 'PK-C-5', '8721393', '2983002-8', NULL, 'no', 'CNIC-ba686aed.jpeg', NULL, 'FBR-f7614f48.jpeg', 'KIPRA-7eb5aa67.jpeg', 'PEC2020-8c688fad.jpeg', '', 'PE-00ee9a31.jpeg', 'no', 0, 0, '2021-07-13 00:07:48', '2024-08-19 08:07:01'),
(7077, 'MUHAMMAD SAJJAD KHAN MALIK DIN KHEL', 'sajjadafr@gmail.com', '0335-9382806', '17301-7161304-9', 'MUHAMMAD SAJJAD KHAN', 'ABDUL MAJEED ELECTRICAL WORKS AJMAL MARKET SHOP# 13 RING', 'Peshawar', '24123', 'PK-C-5', 'PK-C-5', '7391873', '7391873-2', NULL, 'no', 'CNIC-5fae2ece.jpeg', NULL, 'FBR-94fbc862.jpeg', 'KIPRA-176ce400.jpeg', 'PEC2020-38f2d97f.jpeg', '', 'PE-14de97c9.jpeg', 'no', 0, 0, '2021-07-13 01:07:54', '2024-08-19 08:07:01'),
(7078, 'Tehseen Mujtaba & Co', 'tmujtaba1@gmail.com', '0347-3286037', '17301-5500787-1', 'Tehseen Mujtaba & Co', 'House # 5,Muhallah Saadullah Jan,Near Sahibzada School,Haji Camp Ada,Peshawar ', 'Peshawar ', 'C6/63692', 'PK-C-6', 'PK-C-6', '4375465-1', 'K-4375465', NULL, 'no', 'CNIC-9e46024b.png', NULL, 'FBR-9e4f35b3.png', 'KIPRA-d5af425a.png', 'PEC2020-85665883.jpeg', '', '', 'no', 0, 0, '2021-07-13 02:07:28', '2024-08-19 08:07:01'),
(7079, 'AFSAR KHAN BUILDERS', 'ilafsar-khan47@gmail.com', '0333-9896087', '16101-7235447-7', 'AFSAR KHAN', 'GUL MANZIL SADDAR BAZAR MARDAN CANTT', 'Mardan', '15004', 'PK-C-4', 'PK-C-4', '5024698', '	K5024698-7', NULL, 'no', 'CNIC-37b11834.jpeg', NULL, 'FBR-a10de92a.jpeg', 'KIPRA-8c3834ba.jpeg', 'PEC2020-fa259839.jpeg', '', 'PE-5b9adda3.jpeg', 'no', 0, 0, '2021-07-13 03:07:03', '2024-08-19 08:07:01'),
(7082, 'Nz Enterprisess', 'nz.enterprisespk@gmail.com', '0333-9730922', '22201-6708873-3', 'Niazmat Ullah Khan', 'Kot Habib Noor Khadri Muhammad Khel Wazir Bannu.', 'Bannu', '6973', 'PK-C-3', 'PK-C-3', '5071837', '39292967', NULL, 'no', 'CNIC-efc48006.jpeg', NULL, 'FBR-fe3344ea.jpeg', 'KIPRA-4c5bb636.jpeg', 'PEC2020-74c5a55c.jpeg', 'Form-H-1fc77152.jpeg', 'PE-10f305c1.jpeg', 'no', 0, 0, '2021-07-13 06:07:45', '2024-08-19 08:07:01'),
(7083, 'NIAZ MOHAMMAD KHAN & SONS', 'na@gmail.com', '0300-9157071', '14301-7754379-3', 'YOUNAS KHAN', 'VILL. CHARGHARI TEH & DISTT KOHAT', 'KOHAT', '3282', 'PK-C-2', 'PK-C-2', '2230851', 'k2230851-2', NULL, 'no', 'CNIC-f543d88c.jpeg', NULL, 'FBR-35b1cb8f.jpeg', 'KIPRA-3ad86d9d.jpeg', 'PEC2020-de14da51.jpeg', 'Form-H-38d1ca68.jpeg', 'PE-2656ea89.jpeg', 'no', 0, 0, '2021-07-13 06:07:43', '2024-08-19 08:07:01'),
(7084, 'ABID ALI & BROTHERS', 'ABIDALI1940@GMAIL.COM', '0313-9866659', '15402-1416927-9', 'Abid Ali', 'VILL. KOZ CHAM DHERI JULAGRAM P.O. DHERI.', 'SWAT', '7043', 'PK-C-3', 'PK-C-3', '1540214169279', 'k51920335', NULL, 'no', 'CNIC-28089ae1.jpeg', NULL, 'FBR-3539e8fa.jpeg', 'KIPRA-f66eac50.jpeg', 'PEC2020-2e3fb778.jpeg', '', 'PE-f84bcf19.jpeg', 'no', 0, 0, '2021-07-13 06:07:57', '2024-08-19 08:07:01'),
(7086, 'M/S RAJA ISHTIAQ & BROTHERS', 'rajaishtiaq562@gmail.com', '0313-8883611', '135030-514590-9', 'RAJA ISHTIAQ AHMED', 'NEAR KING ABDULLAH HOSPITAL, ABBOTTABAD ROAD MANSEHRA', 'MANSEHRA', '23028', 'PK-C-5', 'PK-C-5', '8958257-8', 'K8958257-8', NULL, 'no', 'CNIC-b5b5b3dc.jpeg', NULL, 'FBR-7640c37c.jpeg', 'KIPRA-d0efa729.jpeg', 'PEC2020-ea2fd196.jpeg', '', 'PE-ca744868.jpeg', 'no', 0, 0, '2021-07-13 07:07:53', '2024-08-19 08:07:01'),
(7087, 'AK CONSTRUCTOR & BUILDERS', 'amirullahkhan195@gmail.com', '0311-9362400', '17102-7640243-7', 'Engr Amirullah', 'OFFICE#401-BLOCK B, CITY TOWER UNIVERSITY ROAD PESHAWAR', 'Charsadda', '24382', 'PK-C-5', 'PK-C-5', 'A253760-5', 'KA253760-5', NULL, 'no', 'CNIC-076bb3f2.jpeg', NULL, '', 'KIPRA-d17808e3.jpeg', 'PEC2020-28450ac8.jpeg', '', '', 'no', 0, 0, '2021-07-12 23:07:06', '2024-08-19 08:07:01'),
(7088, 'SARDAR ILTAF HUSSAIN', 'sardariltafhussain@gmail.com', '03115635043', '1310108884821', 'SARDAR ILTAF HUSSAIN ', 'Near umer masjid link road narriah abbottabad', 'Abbottabad', '22842', 'PK-C-5', 'PK-C-5', '2569443', '2569443', NULL, 'no', 'CNIC-29e1f4c0.jpeg', NULL, 'FBR-8e2c09c3.jpeg', 'KIPRA-56b9618e.jpeg', 'PEC2020-fe3ca33b.jpeg', '', '', 'no', 0, 0, '2021-07-13 03:07:14', '2024-08-19 08:07:01'),
(7090, 'SARDAR ILTAF HUSSAIN', 'sardariltafhussain@gmail.com', '0311-5635043', '13101-0888482-1', 'ALTAF HUSSAIN', 'NEAR UMER MASJID LINK ROAD NARRIAN NARRIAN ABBOTTABAD', ' ABBOTTABAD', '22842', 'PK-C-5', 'PK-C-5', '2569443-0', 'k2569443-0', NULL, 'no', 'CNIC-c0dd3016.jpeg', NULL, 'FBR-f5a9959c.jpeg', 'KIPRA-5151f102.jpeg', 'PEC2020-8058e366.jpeg', '', '', 'no', 0, 0, '2021-07-14 00:07:11', '2024-08-19 08:07:01'),
(7091, 'M/S Janson Construction Company ', 'jansonconstructioncompany@gmail.co', '03458500099', '16102-9381665-9', 'Zahoor Ahmad', 'Janson Construction Company office # 3 4th Floor Block A jawad tower university road peshawar', 'Peshawar', 'C1/E 1194', 'PK-C-1', 'PK-C-1', '4236024-2', 'K4236024-2', NULL, 'no', 'CNIC-8042481e.jpeg', NULL, 'FBR-8bd5387c.png', 'KIPRA-a3ecd84a.png', 'PEC2020-59c3ecd5.jpeg', '', 'PE-60917413.jpeg', 'no', 0, 0, '2021-07-14 02:07:41', '2024-08-19 08:07:01'),
(7092, 'M/S Janson Construction Company ', 'usama.humayun@outlook.com', '03458500099', '16102-9381665-9', 'Zahoor Ahmad', 'Janson Construction Company office # 3 4th Floor Block A jawad tower university road', 'Peshawar', 'C1/E 1194', 'PK-C-1', 'PK-C-1', '4236024-2', 'K4236024-2', NULL, 'no', 'CNIC-77294bde.jpeg', NULL, 'FBR-72e9eee2.png', 'KIPRA-09ce1db4.png', 'PEC2020-f37e0818.jpeg', '', 'PE-a07f097f.jpeg', 'no', 0, 0, '2021-07-14 02:07:54', '2024-08-19 08:07:01'),
(7096, 'MALIK SIRAJ UL HAQ & SONS CONSTRUCTION (PRIVATE) LIMITED', 'sirajhaq313@yahoo.com', '0333-9118741', '17301-1293302-5', 'siraj ul haq', 'VILL & P.O:TEHKAL BALA, MOH. MUGHAL ZAI,TEH & DISTT', 'Peshawar', '1614', 'PK-C-1', 'PK-C-1', '8913317', 'k89133175', NULL, 'no', 'CNIC-47ecbc3e.jpeg', NULL, 'FBR-bf8426d1.jpeg', 'KIPRA-0f5ce295.jpeg', 'PEC2020-e24f6267.jpeg', '', 'PE-49d3ad54.jpeg', 'no', 0, 0, '2021-07-13 22:07:54', '2024-08-19 08:07:01'),
(7097, 'YOUNAS KHAN GOVT CONTRACTOR', 'ab@gmail.com', '0300-9329371', '17301-1627321-3', 'YOUNAS KHAN', 'DAMAN HINDKI P O BOX PAKH AGHULAM', 'Peshawar', '23065', 'PK-C-5', 'PK-C-5', '17301-1627321-3', 'k20305052', NULL, 'no', 'CNIC-0084898d.jpeg', NULL, 'FBR-c987fef4.jpeg', 'KIPRA-425ee6ce.jpeg', 'PEC2020-cb9c7d22.jpeg', '', 'PE-388760b9.jpeg', 'no', 0, 0, '2021-07-13 22:07:53', '2024-08-19 08:07:01'),
(7098, 'PIONEER ENGINEERING WORKS', 'ashfaqkhali124@yahoo.com', '0300-5903592', '17301-5542602-9', 'ABDUL ALI JAN', '17-B RAILWAY HOUSING COLONY DANISH ABAD UNIVERSITY ROAD', 'Peshawar', '22855', 'PK-C-5', 'PK-C-5', '34177884', 'k24177884', NULL, 'no', 'CNIC-e07c07a7.jpeg', NULL, 'FBR-f48f0760.jpeg', 'KIPRA-dc0c661a.jpeg', 'PEC2020-193daccf.jpeg', '', 'PE-ea56ec7b.jpeg', 'no', 0, 0, '2021-07-13 22:07:23', '2024-08-19 08:07:01'),
(7099, 'SYED IQBAL HUSSAIN SHAH', 'syediqbalhussain_shah@yahoo.com', '0300-5756923', '13101-1187340-1', 'SYED IQBAL HUSSAIN SHAH', 'HOUSE NO. 532/3 JHANGI SYDIAN,MANSEHRA ROAD', 'ABBOTTABAD', '6665', 'PK-C-3', 'PK-C-3', '13101-1187340-1', 'k22376992', NULL, 'no', 'CNIC-b5a8aae9.jpeg', NULL, 'FBR-57a32886.jpeg', 'KIPRA-48b96e03.jpeg', 'PEC2020-de759baf.jpeg', '', '', 'no', 0, 0, '2021-07-13 23:07:26', '2024-08-19 08:07:01'),
(7100, 'FARMANULLAH & BROTHER', 'nu6832664@gmail.com', '03005818564', '1720121592119', 'Farman ullah', 'Village & p.o Rashakai Nowshera', 'Nowshera', '5600', 'PK-C-5', 'PK-C-5', '1720121592119', 'K1164691-8', NULL, 'no', 'CNIC-5581d90e.jpeg', NULL, 'FBR-af330c36.jpeg', 'KIPRA-66b07b4d.jpeg', 'PEC2020-496d0f07.jpeg', '', '', 'no', 0, 0, '2021-07-15 00:07:14', '2024-08-19 08:07:01'),
(7101, 'amtar ali & sons construction company', 'na@gamil', '0310-9074847', '14301-1219261-3', 'amtar ali', 'sher kot P.O. SHER KOT, TEH. & DISTT.\r\nCity	KOHAT', 'kohat', '15005', 'PK-C-4', 'PK-C-4', '4355752-0', 'K4355752-0', NULL, 'no', 'CNIC-4a421741.jpeg', NULL, 'FBR-bcd1054e.jpeg', 'KIPRA-8e9e81f2.jpeg', 'PEC2020-f6f8fe15.jpeg', '', '', 'no', 0, 0, '2021-07-15 00:07:16', '2024-08-19 08:07:01'),
(7102, 'AL SAIF GOMAL CONSTRUCTION CO', 'alsaifgomalcon@gmail.com', '0345-9834574', '12101-7034589-9', 'SAIF UR REHMAN', 'GOMAL KALAN TEH&DISTT: DERA ISMAIL KHAN', 'DERA ISMAIL KHAN', '20889', 'PK-C-5', 'PK-C-5', '3533227-1', 'K3533227-1', NULL, 'no', 'CNIC-ae62d11a.jpeg', NULL, 'FBR-6055613f.jpeg', 'KIPRA-d5c7b80a.jpeg', 'PEC2020-705f5403.jpeg', '', '', 'no', 0, 0, '2021-07-15 00:07:50', '2024-08-19 08:07:01'),
(7103, 'Sohail Rais Khan & Co ', 'sohailrais333@hotmail.com', '0333-9028020', '17201-2136444-3', 'Sohail Khan', 'Mohallah Haji Abad Village and  Po box Shaidu  Tehsil Jahangir District Nowshera ', 'Nowshera ', '11', 'PK-C-6', 'PK-C-6', '7045765-7', '7045765-7', NULL, 'no', 'CNIC-5c6d1cb3.jpeg', NULL, 'FBR-e6a13955.jpeg', 'KIPRA-807cf74f.jpeg', 'PEC2020-cfc86e25.jpeg', '', '', 'no', 0, 0, '2021-07-15 02:07:19', '2024-08-19 08:07:01'),
(7105, 'ZAKORI CONSTRUCTION COMPANY (PRIVATE) LIMITED', 'zccdik@gmail.com', '0345-9870370', '12101-0938910-7', 'Mr. Ishaq Ahmad Jan', 'ZAKORI SHARIF DARABAN ROAD DERA ISMAIL KHAN.', 'DERA ISMAIL KHAN', '324', 'PK-C-B', 'PK-C-B', '8369060-5', 'K8369060-5', NULL, 'no', 'CNIC-26a5c9e9.jpeg', NULL, 'FBR-0b4e9ef2.jpeg', 'KIPRA-3d4a4fd2.jpeg', 'PEC2020-2d706218.jpeg', '', 'PE-26205df1.jpeg', 'no', 0, 0, '2021-07-15 03:07:26', '2024-08-19 08:07:01'),
(7106, 'SAEEDULLAH CONSTRUCTION CO(SMC-PVT)LTD', 'jawadullah71@gmail.com', '0312-8887718', '17301-9484917-3', 'SAEEDULLAH', 'KANDAY BALA P.O.NAHQAI TEH & DISTT: Peshawar', 'Peshawar', '3210', 'PK-C-2', 'PK-C-2', '7209921', 'K8369060-5', NULL, 'no', 'CNIC-bcda3da6.jpeg', NULL, 'FBR-f974d3d5.jpeg', 'KIPRA-c1cae55d.jpeg', 'PEC2020-4e2ff611.jpeg', '', 'PE-1dd87f6a.jpeg', 'no', 0, 0, '2021-07-15 03:07:23', '2024-08-19 08:07:01'),
(7107, 'SAEEDULLAH CONSTRUCTION CO(SMC-PVT)LTD', 'jawadullah71@gmail.com', '0312-8887719', '17301-9484917-3', 'SAEEDULLAH', 'KANDAY BALA P.O.NAHQAI TEH & DISTT: Peshawar', 'Peshawar', '3210', 'PK-C-2', 'PK-C-2', '7209921', 'K7209921-3', NULL, 'no', 'CNIC-4f19cf75.jpeg', NULL, 'FBR-f0993d32.jpeg', 'KIPRA-e719d9be.jpeg', 'PEC2020-09355208.jpeg', '', 'PE-f6584428.jpeg', 'no', 0, 0, '2021-07-15 03:07:21', '2024-08-19 08:07:01'),
(7108, 'SAEEDULLAH CONSTRUCTION CO(SMC-PVT)LTD', 'jawadullah71@gmail.com', '0312-8887710', '17301-9484917-3', 'SAEEDULLAH', 'KANDAY BALA P.O.NAHQAI TEH & DISTT: Peshawar', 'Peshawar', '3210', 'PK-C-2', 'PK-C-2', '7209921', 'K7209921-3', NULL, 'no', 'CNIC-23477597.jpeg', NULL, 'FBR-1f43b7ab.jpeg', 'KIPRA-2cc939b2.jpeg', 'PEC2020-d482d72c.jpeg', '', 'PE-11eeddee.jpeg', 'no', 0, 0, '2021-07-15 03:07:28', '2024-08-19 08:07:01'),
(7111, 'RISE BUILDERS', 'akdkd@gmail.com', '0300-5875290', '17101-0390307-9', 'RAZA MUHAMMAD KHAN', 'MOH. SHERPAYAN TEH. & DISTT. P.O. CHARSADDA', 'CHARSADDA', '15321', 'PK-C-4', 'PK-C-4', '1710103903079', 'K2580604-1', NULL, 'no', 'CNIC-e3e05fb9.jpeg', NULL, 'FBR-f83ffe34.jpeg', 'KIPRA-c42c685b.jpeg', 'PEC2020-4194fab5.jpeg', '', 'PE-a7b364e4.jpeg', 'no', 0, 0, '2021-07-16 01:07:44', '2024-08-19 08:07:01'),
(7113, 'Mohammad Nisar', 'Aqeelkhanonline@hotmail.com', '03136914729', '1620164813027', 'Muhammad Nisar', 'Swabi', 'Swabi', '19134', 'PK-C-5', 'PK-C-5', '1428293-3', 'K1428293-3', NULL, 'no', 'CNIC-fd4e967e.jpeg', NULL, 'FBR-329ecb98.jpeg', 'KIPRA-d8b2570a.jpeg', 'PEC2020-3319e2b0.jpeg', '', '', 'no', 0, 0, '2021-07-16 02:07:38', '2024-08-19 08:07:01'),
(7114, 'ABDUL KABIR CONSTRUCTION COMPANY', 'khanimdad34@gmail.com', '0300-5883949', '17101-8296982-5', 'ABDUL KABIR', 'VILLAGE: SHEKHANO KALLI P.O. UMERZAI CHARSADDA', 'CHARSADDA', '1620', 'PK-C-1', 'PK-C-1', '1710182969825', '	K2582965-3', NULL, 'no', 'CNIC-768c59ab.jpeg', NULL, 'FBR-4f757a40.jpeg', 'KIPRA-f5516eb0.jpeg', 'PEC2020-f97c464e.jpeg', '', 'PE-4bd1b937.jpeg', 'no', 0, 0, '2021-07-16 02:07:39', '2024-08-19 08:07:01'),
(7115, 'TAHMEEDULLAH', 'na@gamil', '0345-9393470', '17101-0337161-7', 'TAHMEED ULLAH', 'Dab Banda, Kamran Killi, Tehsil & District Charsadda, Sheikho Charsadda Charsadda Peshawar Khyber Pakhtoonkha', 'CHARSADDA', '24288', 'PK-C-5', 'PK-C-5', '1710103371617', 'K7115434-7', NULL, 'no', 'CNIC-0e7568f3.jpeg', NULL, 'FBR-febaf01f.jpeg', 'KIPRA-b44c2f3d.jpeg', 'PEC2020-b4faf120.jpeg', '', '', 'no', 0, 0, '2021-07-16 02:07:52', '2024-08-19 08:07:01'),
(7116, 'Al Khaliq Construction Company', 'engrabdulkhaliq11@gmail.com', '03455861322', '1610174770837', 'Abdul Khaliq', 'Peshawar', 'Peshawar', '24315', 'PK-C-5', 'PK-C-5', '5379913-1', 'K5379913-1', NULL, 'no', 'CNIC-a7d06422.jpeg', NULL, 'FBR-3f4e7207.jpeg', 'KIPRA-8e804820.jpeg', 'PEC2020-f9a02ca5.jpeg', '', '', 'no', 0, 0, '2021-07-16 02:07:04', '2024-08-19 08:07:01'),
(7117, 'Rahimzay Construction Company', 'Rahimzay91@gmail.com', '03339366392', '1730135599953', 'Muzammil Rahim', 'Peshawar', 'Peshawar', '15320', 'PK-C-4', 'PK-C-4', '7372932-6', 'K7372932-6', NULL, 'no', 'CNIC-961793ec.jpeg', NULL, 'FBR-62f7aae8.jpeg', 'KIPRA-11b0fa75.jpeg', 'PEC2020-5243e694.jpeg', '', '', 'no', 0, 0, '2021-07-16 02:07:31', '2024-08-19 08:07:01'),
(7118, 'Arsalan Engineering & Construction', 'engr.arsalanacc@gmail.com', '03339233464', '1610140798503', 'Muhammad Arsalan Khan', 'Near pirano park , mohallah saddi khel , mardan khas, mardan.', 'Mardan', '24134', 'PK-C-5', 'PK-C-5', '1610140798503', '1610140798503', NULL, 'no', 'CNIC-244727ac.jpeg', NULL, '', 'KIPRA-606615c4.jpeg', 'PEC2020-3f2e47d3.jpeg', '', '', 'no', 0, 0, '2021-07-16 02:07:40', '2024-08-19 08:07:01'),
(7119, 'Rahimzay Construction Company', 'Rahimzay91@gmail.com', '03339366392', '1730135599953', 'Muzammil Rahim', 'Peshawar', 'Peshawar', '15320', 'PK-C-4', 'PK-C-4', '7372932-6', 'K7372932-6', NULL, 'no', 'CNIC-3f919a89.jpeg', NULL, 'FBR-fc4f9e49.jpeg', 'KIPRA-fc2e3e65.jpeg', 'PEC2020-e5ee840c.jpeg', '', '', 'no', 0, 0, '2021-07-16 02:07:21', '2024-08-19 08:07:01'),
(7120, 'NASIR JAMAL KHALIL', 'na@gamil', '0333-3333231', '17301-7816033-1', '	NASIR JAMAL', 'H#1 ST#8 SHINWARI TOWN NEAR DALAZAK ROAD\r\n	Peshawar', 'Peshawar', '23253', 'PK-C-5', 'PK-C-5', '1730178160331', 'K3969892-7', NULL, 'no', 'CNIC-9138702f.jpeg', NULL, 'FBR-9e5e31ae.jpeg', 'KIPRA-56581066.jpeg', 'PEC2020-563dbec4.jpeg', '', 'PE-4f85ddf8.jpeg', 'no', 0, 0, '2021-07-16 04:07:28', '2024-08-19 08:07:01'),
(7121, 'HAIDER KIRAR', 'na@gamil', '7412-8520222', '15201-0570962-5', 'HAIDER KIRAR', 'R/O VILLAGE WARIJUNE TEH MULKOW	CHITRAL', 'Chitral', '19445', 'PK-C-5', 'PK-C-5', '1520105709625', 'K5095531-1', NULL, 'no', 'CNIC-6a62ba28.jpeg', NULL, 'FBR-1dd62d8b.jpeg', 'KIPRA-ec4d263d.jpeg', 'PEC2020-fc3089d2.jpeg', '', 'PE-87f4e37a.jpeg', 'no', 0, 0, '2021-07-16 05:07:25', '2024-08-19 08:07:01'),
(7122, 'GOLDEN KEY CONSTRUCTION COMPANY & BUILDERS', 'hizbullahsherani647@gmail.com', '0333-6852008', '22301-5866319-3', 'ABDUL RAZZAQ', 'BDUL RAZZAQ SHIRANI HOUSE TRIBAL SUB DIVISION DISTT.\r\nDERA ISMAIL KHAN', 'DERA ISMAIL KHA', '15255', 'PK-C-4', 'PK-C-4', '2230158663193', 'K8088415-7', NULL, 'no', 'CNIC-565792de.jpeg', NULL, 'FBR-fd626fff.jpeg', 'KIPRA-66ab148c.jpeg', 'PEC2020-8f3d735f.jpeg', '', '', 'no', 0, 0, '2021-07-16 05:07:36', '2024-08-19 08:07:01'),
(7123, 'OBIDULLAH CONSTRUCTORS', 'obidullah1822@gmail.com', '0345-9255605', '15302-0898862-9', 'Abid Ullah', 'Faisal Photo State Balambat Timargara District Lower Dir ', 'Lower Dir', '14969', 'PK-C-4', 'PK-C-4', '7551563-5', 'K7551563-5', NULL, 'no', 'CNIC-7b9045d2.jpeg', NULL, 'FBR-8793de96.jpeg', 'KIPRA-e41df234.jpeg', 'PEC2020-a3bd48d1.jpeg', '', 'PE-c59fbb3e.jpeg', 'no', 0, 0, '2021-07-17 00:07:08', '2024-08-19 08:07:01'),
(7124, 'KHYBER STAR CONSTRUCTION COMPANY', 'yousafaridi8055@gmail.com', '0333-5454683', '17301-6615836-9', 'Muhammad Asif ', 'OFFICE NO.1 KAMRAN PLAZA NEAR MADINA GNG, PISHTAKHATA CHOWK, PESHAWAR', 'Khyber ', '22727', 'PK-C-5', 'PK-C-5', '1730166158369', 'K80633446-4', NULL, 'no', 'CNIC-94c1dedd.jpeg', NULL, 'FBR-f1c22413.jpeg', 'KIPRA-0d885928.jpeg', 'PEC2020-5dce7f33.jpeg', '', '', 'no', 0, 0, '2021-07-17 05:07:54', '2024-08-19 08:07:01'),
(7125, 'HAIDERZAI CONSTRUCTION COMPANY ENGINEERS & CONTRACTORS', 'attaullah.atta99@gmail.com', '0345-9555877', '17301-5396319-1', 'Atta Ullah', 'VILLAGE & P.O DEH BAHADAR MOHALLAH ACHER TEHSIL & DISTRICT PESHAWAR', 'PESHAWAR', '2978', 'PK-C-2', 'PK-C-2', '7413054-6', 'K7413054-6', NULL, 'no', 'CNIC-df7a101f.jpeg', NULL, 'FBR-acfb8c8e.jpeg', 'KIPRA-4974cae6.jpeg', 'PEC2020-36df8b22.jpeg', 'Form-H-e4c26c69.jpeg', 'PE-965d6f79.jpeg', 'no', 0, 0, '2021-07-17 07:07:27', '2024-08-19 08:07:01'),
(7129, 'Farhan Wahab & Company', 'farhanwahab2014@gmail.com', 'farhanwahab2', '17101-6167314-3', 'Abdul Wahab', 'Moh: Sheikh Malli Village Nista District Charsadda', 'Charsadda', '15330', 'PK-C-4', 'PK-C-4', '4303930', 'K4303930-8', NULL, 'no', 'CNIC-5d83f2d8.jpeg', NULL, 'FBR-a5afcf94.jpeg', 'KIPRA-8c3d4c7f.jpeg', 'PEC2020-a3fdf2b8.jpeg', '', 'PE-eeac73a5.jpeg', 'no', 0, 0, '2021-07-19 01:07:44', '2024-08-19 08:07:01'),
(7130, 'Aftab Ahmed & Co', 'aftabahmadandco@gmail.com', '0342-0000033', '12201-5342798-7', 'Aftab Ahmed', 'House No. 1134 Street No. 21, D-17 Multi Garden Sanjani Tarnol Islamabad', 'Tank', '7390', 'PK-C-3', 'PK-C-3', '3032556-7', '3032556-7', NULL, 'no', 'CNIC-536d8a1a.jpeg', NULL, 'FBR-d05f7acb.jpeg', 'KIPRA-ddeddf39.jpeg', 'PEC2020-605666dc.jpeg', '', '', 'no', 0, 0, '2021-07-19 02:07:52', '2024-08-19 08:07:01'),
(7134, 'Shakil Abbas Bhatti', 'shakil123@gmail.com', '0346-7995565', '12101-0314984-3', 'Shakil Abbas', 'Village & P.O Yarik, Distt: Dera Ismail Khan', 'Dera Ismail Khan', '64085', 'PK-C-6', 'PK-C-6', '5117151-3', '5117151-3', NULL, 'no', 'CNIC-cb3ae815.jpeg', NULL, 'FBR-d035ef37.jpeg', 'KIPRA-a2b5f125.jpeg', 'PEC2020-32e9b084.jpeg', '', '', 'no', 0, 0, '2021-07-19 04:07:39', '2024-08-19 08:07:01'),
(7135, 'Shahzain MSD Construction Company', 'shahzainmsd123@gmail.com', '0333-3336611', '12101-1823528-5', 'Azeem Ullah', 'H.No.169-B, Street No. 82, Sector G-6/1 Islamabad', 'Dera Ismail Khan', '15333', 'PK-C-4', 'PK-C-4', '3074259-5', '3074259-5', NULL, 'no', 'CNIC-c47a1332.jpeg', NULL, 'FBR-41724413.jpeg', 'KIPRA-a9da2b7e.jpeg', 'PEC2020-3373b451.jpeg', '', '', 'no', 0, 0, '2021-07-19 04:07:39', '2024-08-19 08:07:01'),
(7917, 'M/S KEFAL CONSTRUCTION COMPANY', 'kef****nst***tion@gmail.com', '0333-9712453', '14202-9318711-3', 'HASHIM DARAZ', 'KARAK', 'KARAK', '24245', 'PK-C-5', 'PK-C-5', '14202-9318711-3', 'K4356027-9', NULL, 'no', 'CNIC-1d8c3460.jpeg', NULL, 'FBR-9c6ce35c.jpeg', 'KIPRA-0955aa85.jpeg', 'PEC2020-6744b1c7.jpeg', '', '', 'no', 0, 0, '2021-07-20 00:07:34', '2024-08-19 08:07:01'),
(7918, 'NOUMAN ENGINEERING CONSTRUCTION', 'muh****dno***n677@gmail.com', '00923**095**', '1420301340245', 'Muhammad Nouman', 'Karak', 'KARAK', '24133', 'PK-C-5', 'PK-C-5', '1420301340245', 'k7634148-6', NULL, 'no', 'CNIC-8b6589c5.jpeg', NULL, 'FBR-5ee83b06.jpeg', 'KIPRA-b9672a5f.jpeg', 'PEC2020-c56dae43.jpeg', '', '', 'no', 0, 0, '2021-07-20 00:07:13', '2024-08-19 08:07:01'),
(7920, 'Deh Bahadar Associates ', 'dehbahadarassociates@gmail.com', '0333-9443244', '17301-9679324-7', 'Saadullah Khan', 'Mohallah Ibrahim Kheil Deh Bahadar Peshawar ', 'Peshawar ', '20475', 'PK-C-5', 'PK-C-5', '1730196793247', '4055366-3', NULL, 'no', 'CNIC-71cbb6b0.jpeg', NULL, 'FBR-65260188.jpeg', 'KIPRA-241747d5.jpeg', 'PEC2020-54a970d4.jpeg', '', '', 'no', 0, 0, '2021-07-23 06:07:27', '2024-08-19 08:07:01'),
(8767, 'ZUBAIR MAHSOOD & CO', 'zubairmahsoodandco99@gmail.com', '0345-9844270', '12201-7694406-3', 'zubair ahmad', 'NANO HOUSE SADA BAHAR COLONY WAZIR ABAD TANK', 'south waziristan', '7436', 'PK-C-3', 'PK-C-3', '35376917', 'K35376917', NULL, 'no', 'CNIC-2c293e81.jpeg', NULL, 'FBR-d35eb7d4.jpeg', 'KIPRA-9a5e0ac1.jpeg', 'PEC2020-19f5ace9.jpeg', '', '', 'no', 0, 0, '2021-07-25 05:07:45', '2024-08-19 08:07:01'),
(8768, 'SAMI ULLAH BUILDER & SUPPLIER', 'umarali9699@gmail.com', '0344-9702997', '15202-0831124-7', 'SAMI ULLAH', 'JANG BAZAR, PAYEEN CHITRAL', 'CHITRAL', '21166', 'PK-C-5', 'PK-C-5', '51072388', 'K51072388', NULL, 'no', 'CNIC-a06d4f06.jpeg', NULL, 'FBR-59b5d5e5.jpeg', 'KIPRA-24529c0e.jpeg', 'PEC2020-1dc47a60.jpeg', '', '', 'no', 0, 0, '2021-07-25 06:07:12', '2024-08-19 08:07:01'),
(8769, 'SUN RISING CONSTRUCTION CO', 'Fawadnowshera@hotmail.com', '0313-7793051', '17201-1104081-1', 'FAWAD ALI KHAN', 'MOH ABAKHEL NOWSHERA KALAN TEH & DISST NOWSHERA', 'NOWSHEHRA', '73411', 'PK-C-6', 'PK-C-6', '65247952', 'K65247952', NULL, 'no', 'CNIC-cf24b9ab.jpeg', NULL, 'FBR-f7c6723c.jpeg', 'KIPRA-744fc9c0.jpeg', 'PEC2020-9fcab959.jpeg', '', '', 'no', 0, 0, '2021-07-25 06:07:03', '2024-08-19 08:07:01'),
(8771, 'TANAWAL CONSTRUCTION COMPANY', 'tanawal@gmail.com', '0343-9548525', '1350379124731', 'Sherbaz khan', 'VILL & P.O:GANDHIAN, TEH & DISTT: MANSEHRA', 'MANSEHRA', '20029', 'PK-C-5', 'PK-C-5', '1350379124731', 'K2973155-7', NULL, 'no', 'CNIC-81c72213.jpeg', NULL, 'FBR-dc954eeb.jpeg', 'KIPRA-120d18ae.jpeg', 'PEC2020-90a7e8b3.jpeg', '', 'PE-76a09a98.jpeg', 'no', 0, 0, '2021-07-26 00:07:19', '2024-08-19 08:07:01'),
(8772, 'GHULAM MUSTAFA & BROTHERS', 'gmbrothers75@gmail.com', '0321-9801033', '13101-0846509-7', 'GHULAM MURTAZA', 'H.# T-108, THE MALL KARIMPURA, ABBOTTABAD', 'ABBOTTABAD', '2865', 'PK-C-2', 'PK-C-2', '6292815', 'K6292815-6', NULL, 'no', 'CNIC-20cc3c47.jpeg', NULL, 'FBR-d829f0b7.jpeg', 'KIPRA-44df2f1f.jpeg', 'PEC2020-389ab3f5.jpeg', '', '', 'no', 0, 0, '2021-07-26 01:07:22', '2024-08-19 08:07:01'),
(8773, 'MUHAMMAD ISHAQ & SONS', 'm.ishaq.sons110@gmail.com', '0308-5524980', '13101-0972823-1', '	Fazal Ur Rehman', 'H.# 105 KARIMABAD THE MALL ABBOTTABAD ', 'MUHAMMAD ISHAQ & SONS', '3125', 'PK-C-2', 'PK-C-2', '1804181', 'K1804181-7', NULL, 'no', 'CNIC-5ef46bda.jpeg', NULL, 'FBR-1ef7141c.jpeg', 'KIPRA-ec78adfa.jpeg', 'PEC2020-e9f6457d.jpeg', '', '', 'no', 0, 0, '2021-07-26 01:07:48', '2024-08-19 08:07:01'),
(8774, 'DILAWAR KHAN & BATTNI', 'na@gamil', '0346-9731381', '11201-7020755-7', 'Iman Sultan', 'VILLAGE GOLI KHEL, P.O NOWROZ BATTNI, DISTRICT LUKKI MARWART,', 'Lakki Marwat', '15394', 'PK-C-4', 'PK-C-4', '7281174', 'K7281174-3', NULL, 'no', 'CNIC-8914c6f9.jpeg', NULL, 'FBR-62239ade.jpeg', 'KIPRA-bae3d4e2.jpeg', 'PEC2020-14c6a1b9.jpeg', '', '', 'no', 0, 0, '2021-07-26 02:07:12', '2024-08-19 08:07:01'),
(8776, 'NADER ALI & CO', 'nadir.ali@gmail.com', '0344-9456273', '13101-5404922-1', '	FAZAL-E-RAZIQ', 'LASSAN MALACH, P.O.NATHIA GALI, ABBOTTABAD', 'ABBOTTABAD', '22112', 'PK-C-5', 'PK-C-4', '7274047', '	K7274047-4', NULL, 'no', 'CNIC-f6647ef6.jpeg', NULL, 'FBR-66574740.jpeg', 'KIPRA-ef6dca93.jpeg', 'PEC2020-23c2c587.jpeg', 'Form-H-b22a71e4.jpeg', '', 'no', 0, 0, '2021-07-26 03:07:55', '2024-08-19 08:07:01'),
(8777, 'M/S Zeros Builders', 'ak44444333@gmail.com', '0331-8009300', '17201-9342681-9', 'Arbab Khan', 'Arbab Khan Hujra, Near GBPS Hakimabad Nowshera', 'Nowshera', '23684', 'PK-C-5', 'PK-C-5', '1430464-3', '1430464-3', NULL, 'no', 'CNIC-717f9c11.jpeg', NULL, 'FBR-e844b50b.jpeg', 'KIPRA-e5ed61a5.jpeg', 'PEC2020-dfbe8ec6.jpeg', '', '', 'no', 0, 0, '2021-07-26 03:07:04', '2024-08-19 08:07:01'),
(8778, 'S.A. BUILDERS & SOLAR POWER', 'builders@gmail.com', '0300-5614822', '13302-3275266-7', 'Ibrar ahmad', 'S.A. BUILDERS & SOLAR POWER, FIRST FLOOR, ZAMAN PLAZA, MAIN HARIPUR', '	HARIPUR', '24544', 'PK-C-5', 'PK-C-5', '4322194', 'K4322194-7', NULL, 'no', 'CNIC-47995e22.jpeg', NULL, 'FBR-1abbc7e3.jpeg', 'KIPRA-7582ce9b.jpeg', 'PEC2020-f6cb9a58.jpeg', '', 'PE-6d795831.jpeg', 'no', 0, 0, '2021-07-26 03:07:31', '2024-08-19 08:07:01'),
(8780, 'Farid Ullah Khan & Sons	', 'na@gamil', '0312-5879512', '11101-9888831-3', 'Farid Ullah Khan', 'Gul Zaman Masjid, Nogarih Mamash Khel, Miran Shah road, Bannu ', 'Bannu', '24289', 'PK-C-5', 'PK-C-5', '5959689', '	K5959689-6', NULL, 'no', 'CNIC-6c46cd57.jpeg', NULL, 'FBR-964229b2.jpeg', 'KIPRA-80632a3a.jpeg', 'PEC2020-5f9f4022.jpeg', 'Form-H-d046b577.jpeg', 'PE-d6d00cdc.jpeg', 'no', 0, 0, '2021-07-26 05:07:32', '2024-08-19 08:07:01'),
(8783, 'A.Q . BUILDERS (PRIVATE) LIMITED', 'aqkhankpk@gmail.com', '0359-5559525', '16102-2109784-1', 'ABDUL QADAR', 'VILL.GARO MUHAMMAD AKBAR KOROONA GARU SHAH Mardan', 'Mardan', '362', 'PK-C-B', 'PK-C-B', '3346446', 'K7964169-6', NULL, 'no', 'CNIC-f6e16c86.jpeg', NULL, 'FBR-ee06847c.jpeg', 'KIPRA-afa2ee16.jpeg', 'PEC2020-3385c12d.jpeg', '', '', 'no', 0, 0, '2021-07-26 06:07:08', '2024-08-19 08:07:01'),
(8785, 'GULF CONSTRUCTION COMPANY', 'gulfconstruction.gc4c@gmail.com', '0332-6133039', '17101-3864483-5', 'AAMIR KHAN', 'MOH. MUHAMMAD ZAI RAJJAR', 'CHARSADDA', '13860', 'PK-C-4', 'PK-C-4', '6679933', 'k66799337', NULL, 'no', 'CNIC-0c60c336.jpeg', NULL, 'FBR-d03c7d10.jpeg', 'KIPRA-d6a03ddd.jpeg', 'PEC2020-3893849e.jpeg', '', '', 'no', 0, 0, '2021-07-26 00:07:46', '2024-08-19 08:07:01'),
(8786, 'M/S MURTAZA KHAN & BROTHRES', 'murtazakhandir712@gmail.com', '0346-9222326', '15701-3680213-1', 'MURTAZA KHAN', 'VILLAGE ABAKAND P.O GANORI DISTT DIR UPPER', 'DIR UPPER', '23251', 'PK-C-5', 'PK-C-5', '15701-3680213-1', 'K-5323040-8', NULL, 'no', 'CNIC-8946c766.jpeg', NULL, 'FBR-f77fb629.jpeg', 'KIPRA-bef5b19f.jpeg', 'PEC2020-5a5bca10.jpeg', '', 'PE-2e2d2d2e.jpeg', 'no', 0, 0, '2021-07-27 00:07:27', '2024-08-19 08:07:01'),
(8789, 'M/s Golden Gate Construction', 'Ifrikhar_afridi442@yahoo.com', '03054445151', '21201-5137651-1', 'Muhammad iftikhar', '1st floor jan palaza near minar masjid tehsil bara district khyber bara khyber agency', 'Khyber', '14949', 'PK-C-4', 'PK-C-4', '2120151376511', 'K8987783-5', NULL, 'no', 'CNIC-aba336d2.jpeg', NULL, 'FBR-acb18946.jpeg', 'KIPRA-18736ee1.jpeg', 'PEC2020-8340c7cd.jpeg', '', 'PE-09b6eb68.jpeg', 'no', 0, 0, '2021-07-27 04:07:34', '2024-08-19 08:07:01'),
(8790, 'Ali & Co', 'PESHAWAR1976@YAHOO.COM', '03339055556', '17301-8855290-1', 'Ahmad Ali', 'OFFICE#8,SABIR PLAZA NEAR BANK OF KHYBER BABO GHARI WARSAK', 'Peshawar', '1664', 'PK-C-1', 'PK-C-1', '4350884', 'K4350884-7', NULL, 'no', 'CNIC-0c64256b.jpeg', NULL, 'FBR-00df0439.jpeg', 'KIPRA-5895f751.jpeg', 'PEC2020-c00325dc.jpeg', 'Form-H-a33a9653.jpeg', 'PE-9e876979.jpeg', 'no', 0, 0, '2021-07-27 04:07:06', '2024-08-19 08:07:01'),
(8794, 'BLUE BAND CONSTRUCTION COMPANY', 'na@gmail.com', '03151918777', '17101-1645568-5', 'Khaista Gul', 'VILLAGE PRANG YASEENZAI,P/O PRANG TEHSIL , CHARSADDA', 'charsadda', '24541', 'PK-C-5', 'PK-C-5', '3326981', 'K3326981-5', NULL, 'no', 'CNIC-5819db39.jpeg', NULL, 'FBR-2e14951e.jpeg', 'KIPRA-e8bc24f8.jpeg', 'PEC2020-e0e8d51f.jpeg', '', '', 'no', 0, 0, '2021-07-26 20:07:57', '2024-08-19 08:07:01'),
(8795, 'S & Q CONSTRUCTION GROUP', 'na@gmail.com', ' 315 1918777', '1710185163393', 'Salah Uddin', 'MOHALLAH SHAMS UD DIN KORUNA, PESHAWAR ROAD, TEHSIL AND DISTT, Charsadda', 'charsadda', '15242', 'PK-C-5', 'PK-C-5', '7566907', 'K7566907-4', NULL, 'no', 'CNIC-7f484c5c.jpeg', NULL, 'FBR-c88fc844.jpeg', 'KIPRA-afe707d0.jpeg', 'PEC2020-c0ba151a.jpeg', 'Form-H-c40f3660.jpeg', '', 'no', 0, 0, '2021-07-26 20:07:13', '2024-08-19 08:07:01'),
(8798, 'MALAZY CONSTRUCTION', 'ashukat679@gmail.com', '0340-4876435', '15702-2664225-7', 'SHAUKAT ALI', 'VILLAGE SHAWA QALA TEHSIL ADENZAI DIE LOWER DISTT: TIMERGARA', 'DIR UPPER', '20192', 'PK-C-5', 'PK-C-5', '71599724', 'K71599724', NULL, 'no', 'CNIC-430484ca.jpeg', NULL, 'FBR-9df75737.jpeg', 'KIPRA-b6070c22.jpeg', 'PEC2020-fdf5ad91.jpeg', '', '', 'no', 0, 0, '2021-07-26 22:07:26', '2024-08-19 08:07:01'),
(8799, 'UMARZAI CONSTRUCTION & ENGINEERS', 'umarzai9966@gmail.com', '0312-3674848', '17101-6609767-1', 'SALAH UD DIN', '21-A ZAHEER PLAZARING ROADLATIFABAD PESHAWAR', 'CHARSADDA', '3073', 'PK-C-2', 'PK-C-2', '37709747', 'K37709747', NULL, 'no', 'CNIC-4a030ed8.jpeg', NULL, 'FBR-bde2dcd3.jpeg', 'KIPRA-afcab4ae.jpeg', 'PEC2020-5535a5e0.jpeg', 'Form-H-d8218f42.jpeg', '', 'no', 0, 0, '2021-07-26 22:07:24', '2024-08-19 08:07:01'),
(8800, 'AK Contractors', 'abidjan28@gmail.com', '03139573730', '17301-1056619-1', 'Abid ur Rehman', 'office # 7 Ali taj market, iqra chowk university road, peshawar.', 'Peshawar', '24540', 'PK-C-5', 'PK-C-5', '3968641-8', 'k3968641-8', NULL, 'no', 'CNIC-72e83c7d.jpeg', NULL, 'FBR-4e3596e8.jpeg', 'KIPRA-cea0ec7d.jpeg', 'PEC2020-9d454185.jpeg', '', '', 'no', 0, 0, '2021-07-27 00:07:28', '2024-08-19 08:07:01'),
(8802, 'Shah Zaman Khan', 'shahzamankhanmrd@gmail.com', '0312-9343053', '16101-1227586-9', 'Shah Zaman Khan', 'Faqrir Ban New Baghdada Teshil and District Mardan KPK', 'Mardan', '70844', 'PK-C-6', 'PK-C-6', '1414217-1', 'K141427-1', NULL, 'no', 'CNIC-41313d18.jpeg', NULL, 'FBR-bc2f00d0.jpeg', 'KIPRA-96577fd1.jpeg', 'PEC2020-9ce9736a.jpeg', '', 'PE-d5808cbf.jpeg', 'no', 0, 0, '2021-07-28 04:07:05', '2024-08-19 08:07:01'),
(8803, 'SHAH JAHAN BHATTANI', 'na@yahoo.com', '0345-1950803', '22101-6729291-3', '	5418724-', 'SHAH JAHAN BHATTANI', 'lakki marwat', '24285', 'PK-C-5', 'PK-C-5', '2210167292913', '	K5418724-4', NULL, 'no', 'CNIC-19fda30d.jpeg', NULL, 'FBR-826dff3e.jpeg', 'KIPRA-5b059300.jpeg', 'PEC2020-b3fabf36.jpeg', '', 'PE-cad064f7.jpeg', 'no', 0, 0, '2021-07-28 05:07:27', '2024-08-19 08:07:01'),
(8805, 'M/S BILAL BROTHERS CONSTRUCTIONS', 'abdulmateenk42@gmail.com', '0333-8885734', '21201-7619921-5', 'MUHAMMAD BILAL', 'BLOCK NO.04 JAMRUD SHOPPING PLAZA JAMRUD KHYBER AGENCY PESHAWAR', 'KHYBER ', '24159', 'PK-C-5', 'PK-C-5', '7376924-2', 'K7376924-2', NULL, 'no', 'CNIC-0acd2ca9.jpeg', NULL, 'FBR-087a45fe.jpeg', 'KIPRA-a7c8a720.jpeg', 'PEC2020-15411c00.jpeg', '', '', 'no', 0, 0, '2021-07-28 07:07:08', '2024-08-19 08:07:01'),
(8807, 'RAHMATULLAH MASHWANI & SONS', 'rahmatullahmashwani0@gmail.com', '0300-2244127', '15302-0888689-3', 'RAHMAT ULLAH', 'Village Maskini P.O Mayar Teh, Samar Bagh District Lower Dir', 'Lower Dir', '14836', 'PK-C-4', 'PK-C-4', '7477447-4', 'K7477447-4', NULL, 'no', 'CNIC-48a7775d.jpeg', NULL, 'FBR-1db7afce.jpeg', 'KIPRA-9c0688b5.jpeg', 'PEC2020-0c233799.jpeg', '', 'PE-efa2f1ad.jpeg', 'no', 0, 0, '2021-07-29 00:07:46', '2024-08-19 08:07:01'),
(8808, 'Gul Shad khan Government Contractor', 'gulshadntn123@gmail.com', '0333-9272644', '17301-8664486-5', 'Gul Shad Khan', 'Mohallah Nawab Khel Marozai Deh Bahadar Peshawar', 'Peshawar', '24536', 'PK-C-5', 'PK-C-5', '17301-8664486-5', 'A302828-5', NULL, 'no', 'CNIC-f7f45790.jpeg', NULL, 'FBR-07374e94.jpeg', 'KIPRA-bc532ed2.jpeg', 'PEC2020-b8ef2c59.jpeg', '', '', 'no', 0, 0, '2021-07-29 02:07:39', '2024-08-19 08:07:01'),
(8811, 'MUHAMMAD JAN BUILDERS', 'na@yahoo.com', '03459532794', '15302-6417614-7', 'MUHAMMAD JAN', 'MOH:QUARTERO TIMERGARA DIR LOWER', 'DIR LOWER', '14284', 'PK-C-4', 'PK-C-4', '7610367-3', 'K7610367-3', NULL, 'no', 'CNIC-e0a1d74d.jpeg', NULL, 'FBR-bbace059.jpeg', 'KIPRA-01e86352.jpeg', 'PEC2020-e7089526.jpeg', '', '', 'no', 0, 0, '2021-07-29 03:07:29', '2024-08-19 08:07:01'),
(8817, 'KHANI ZAMAN & SONS ', 'khanizaman1000@gmail.com', '0345-9579817', '13101-0855268-1', 'KHANI ZAMAN ', 'MOH.DALAZAI COLONY, MAIN D SARI SARI P.O PUBLIC SCHOOL MIRPUR ABBOTTABAD ', 'ABBOTTABAD ', '46308', 'PK-C-6', 'PK-C-6', '5154498', 'K5154498-0', NULL, 'no', 'CNIC-c5c79828.jpeg', NULL, 'FBR-82d26478.jpeg', 'KIPRA-30861e40.jpeg', 'PEC2020-c6d225e5.jpeg', 'Form-H-dcbef863.jpeg', 'PE-ddf53c6b.jpeg', 'no', 0, 0, '2021-07-29 03:07:51', '2024-08-19 08:07:01'),
(8819, 'M/S FARHAN BROTHERS CONSTRUCTION COMPANY ', 'qismat.kt.20@gmail.com', '0333-9484609', '14202-4648967-1', 'Qismat Ullah Khan', 'H.NO. 129, STREET NO.114, DHOK BREEN DISTRICT ATTOCK OIL COMPANY KOTA KALA, RAWALPINDI', 'Karak', '73517', 'PK-C-6', 'PK-C-6', '1420246489671', 'K5326881-6', NULL, 'no', 'CNIC-f793983d.jpeg', NULL, 'FBR-18dbe2ea.jpeg', 'KIPRA-52d8c4c1.jpeg', 'PEC2020-57bddcfc.jpeg', '', '', 'no', 0, 0, '2021-07-29 04:07:56', '2024-08-19 08:07:01'),
(8820, 'GHULAM DASTAGIR BUILDERS', 'na@gmail.com', '0000-4545645', '13504-7515203-1', 'Ghulam Dastagir', 'H.NO.112/M STREET NO.30-C SECTOR I-10/4 Islamabad', 'Islamabad', '13653', 'PK-C-4', 'PK-C-4', '1350475152031', 'K8947331-8', NULL, 'no', 'CNIC-9aeab3a8.jpeg', NULL, 'FBR-59922240.jpeg', 'KIPRA-21596c88.jpeg', 'PEC2020-a008bd2d.jpeg', '', '', 'no', 0, 0, '2021-07-29 05:07:13', '2024-08-19 08:07:01'),
(8821, 'KAWAI CONSTRUCTION CO', 'na@yahoo.com', '0000-0000001', '13403-7845326-9', '	MUHAMMAD JEE KHAN', 'C/O.ALI SHOPKEEPER P.O.PATTAN TEH.PATTAN DISTT. KOHISTAN', 'KOHISTAN', '23471', 'PK-C-5', 'PK-C-5', '1340378453269', '	K6815951-8', NULL, 'no', 'CNIC-9fc99902.jpeg', NULL, 'FBR-5e1a085d.jpeg', 'KIPRA-a5999435.jpeg', 'PEC2020-4a7a74c0.jpeg', 'Form-H-77e18477.jpeg', 'PE-4982c218.jpeg', 'no', 0, 0, '2021-07-29 06:07:28', '2024-08-19 08:07:01'),
(8822, 'Muhammad Wali Khan & Brother', 'ullahrahat042@gmail.com', '0333-1956701', '11101-1499871-7', 'Muhammad Wali Khan', 'HARMAIN PLAZA GHOUSIA MASJID OLD BANK ROAD ALI PUR, District, Islamabad', 'Islamabad', '14986', 'PK-C-4', 'PK-C-4', '3026973-3', '3026973-3', NULL, 'no', 'CNIC-a79dfdf1.jpeg', NULL, 'FBR-397076b1.jpeg', 'KIPRA-e756aee7.jpeg', 'PEC2020-d4ff1665.jpeg', '', '', 'no', 0, 0, '2021-07-29 06:07:22', '2024-08-19 08:07:01'),
(8825, 'ISRAR MUHAMMAD AND SONS', 'na@gmail.com', '0345-9270852', '15402-0125070-1', 'ISRAR MUHAMMAD', 'INZARGAI RANIZAI', 'MALAKAND AGENCY', '7272', 'PK-C-3', 'PK-C-3', '6648132', 'k39081451', NULL, 'no', 'CNIC-422d8f27.jpeg', NULL, 'FBR-6c476183.jpeg', 'KIPRA-0be92411.jpeg', 'PEC2020-e53beafc.jpeg', '', '', 'no', 0, 0, '2021-07-29 00:07:56', '2024-08-19 08:07:01'),
(8826, 'MUQMEEN KHAN & SONS (MKCC)', 'abc@pec.org.pk', '0345-2288968', '15402-1424241-9', 'MUQMEEN KHAN5', 'NEAR LOVY POST QULANGI CHOWK P,O, TATAKAN TEH. BATKHELA,', 'MALAKAND AGENCY', '7289', 'PK-C-3', 'PK-C-3', '5050873', 'k5050873', NULL, 'no', 'CNIC-729b9019.jpeg', NULL, 'FBR-5752a9d5.jpeg', 'KIPRA-714c34bb.jpeg', 'PEC2020-fcd88db9.jpeg', '', '', 'no', 0, 0, '2021-07-29 00:07:16', '2024-08-19 08:07:01'),
(8827, 'FAZAL CONSTRUCTION CO', 'na@gmail.com', '0324-9934799', '15306-2812273-9', 'MUHAMMAD SOHAIL', 'VILL & P.O HAYASERI TEH BALAMBAT', 'DIR', '22223', 'PK-C-5', 'PK-C-5', '75609898', 'k75609898', NULL, 'no', 'CNIC-2d0536dc.jpeg', NULL, 'FBR-e3fb9e50.jpeg', 'KIPRA-ba8a87dc.jpeg', 'PEC2020-0ce0cff4.jpeg', 'Form-H-b151a87b.jpeg', 'PE-33229345.jpeg', 'no', 0, 0, '2021-07-29 00:07:23', '2024-08-19 08:07:01');
INSERT INTO `contractor_registrations` (`id`, `contractor_name`, `email`, `mobile_number`, `cnic`, `district`, `address`, `pec_number`, `owner_name`, `category_applied`, `pec_category`, `fbr_ntn`, `kpra_reg_no`, `pre_enlistment`, `is_limited`, `cnic_front_attachment`, `cnic_back_attachment`, `fbr_attachment`, `kpra_attachment`, `pec_attachment`, `form_h_attachment`, `pre_enlistment_attachment`, `is_agreed`, `defer_status`, `approval_status`, `created_at`, `updated_at`) VALUES
(8828, 'KALA KHAN CONSTRUCTION CO', 'kkcc786@gmail.com', '0346-2436415', '13101-7663434-9', 'kala khan', 'VILL & P.O BAGH TEH & DISTT:', 'ABBOTTABAD', '15395', 'PK-C-4', 'PK-C-4', '18692788', 'k18692788', NULL, 'no', 'CNIC-8b0f6092.jpeg', NULL, 'FBR-b406373c.jpeg', 'KIPRA-d270f911.jpeg', 'PEC2020-f46735cb.jpeg', '', 'PE-dd9f1189.jpeg', 'no', 0, 0, '2021-07-29 00:07:02', '2024-08-19 08:07:01'),
(8829, 'TAIMAR KHAN GOVT. CONTRACTOR', 'AN@gmail.com', '0300-9390505', '21103-6419930-3', 'TAIMAR KHAN', 'SHAMLO QILA P.O. KHAR FILLING TEH. KHAR BAJAUR DISTT.', 'BAJAUR AGENCY', '23678', 'PK-C-5', 'PK-C-5', '21103-6419930-3', 'k43368085', NULL, 'no', 'CNIC-59aafd29.jpeg', NULL, 'FBR-7ff09a69.jpeg', 'KIPRA-f86abca2.jpeg', 'PEC2020-db047c34.jpeg', '', '', 'no', 0, 0, '2021-07-29 01:07:37', '2024-08-19 08:07:01'),
(8830, 'SHAFI ULLAH KHAN & SONS', 'na@gmail.com', '033-49104861', '11101-2454716-1', 'SHAFI ULLAH KHAN', 'KOTKA AKHWANDAN, DAKHLI FATIMA KHEL, KHURD POST OFFICE ISMAIL KHEL DISTT.', 'BANNU', '21391', 'PK-C-5', 'PK-C-5', '36467154', 'k36467154', NULL, 'no', 'CNIC-d217a3f5.jpeg', NULL, 'FBR-b0c68664.jpeg', 'KIPRA-c709e2ae.jpeg', 'PEC2020-1c42b8ed.jpeg', '', '', 'no', 0, 0, '2021-07-29 01:07:10', '2024-08-19 08:07:01'),
(8831, 'ali rehman & sons', 'nih45926@gmail.com', '0333-9162303', '17301-1557200-9', 'ali rehman', 'MOHALLAH MUGHALZAI, VILL & P.O TEHKAL BALA DISTT', 'Peshawar', '11656', 'PK-C-5', 'PK-C-5', '722313468', 'k722313468', NULL, 'no', 'CNIC-e7eac31e.jpeg', NULL, 'FBR-d9fb0947.jpeg', 'KIPRA-0308b3ab.jpeg', 'PEC2020-313d44b3.jpeg', '', '', 'no', 0, 0, '2021-07-29 01:07:03', '2024-08-19 08:07:01'),
(8832, 'M/S WAHID MASHAL KHAN', 'wahidmashal5@gmail.com', '0311-9064598', '11201-2511520-9', 'WAHID MASHAL KHAN', 'KOTKA PAINDA KHEL DAKHLI GANDI KHAN KHEL TEHSIL SARAI NAURANG LAKKI MARWAT', 'LAKKI MARWAT', '15361', 'PK-C-4', 'PK-C-4', '5174751-3', 'K5174751-3', NULL, 'no', 'CNIC-697a7761.jpeg', NULL, '', 'KIPRA-ce83318b.jpeg', 'PEC2020-b6354bd5.jpeg', '', '', 'no', 0, 0, '2021-07-29 20:07:27', '2024-08-19 08:07:01'),
(8834, 'SUPER SHAHEEN & CO', 'safi1982safi@gmail.com', '0333-9619647', '1430192734361', 'Safi Ullah', 'GUL ABAD P/O. HABIBABAD KTM ROAD NEW BUS STAND H# T-663,\r\n KOHAT', 'KOHAT', '13523', 'PK-C-4', 'PK-C-4', '1430192734361', 'K3664622-9', NULL, 'no', 'CNIC-7198a3b9.jpeg', NULL, 'FBR-4f8e4ef7.jpeg', 'KIPRA-11681f01.jpeg', 'PEC2020-603ac60c.jpeg', '', 'PE-d2cba689.jpeg', 'no', 0, 0, '2021-07-30 02:07:03', '2024-08-19 08:07:01'),
(8836, 'WAZIR BROTHERS', 'NA@GMAIL.COM', '0333-648794', '10922-9100271-1', 'ahmad nawaz', 'Peshawar', 'Peshawar', '1967', 'PK-C-3', 'PK-C-3', '21546240', '21546240', NULL, 'no', 'CNIC-67ea801c.jpeg', NULL, 'FBR-68fd12cc.jpeg', 'KIPRA-0ed45233.jpeg', 'PEC2020-ada4f247.jpeg', '', '', 'no', 0, 0, '2021-07-30 04:07:53', '2024-08-19 08:07:01'),
(8837, 'MUHAMMAD AJMAL CONTRACTOR', 'waziristan19@gmail.com', '0345-9876000', '21708-2850959-5', 'MUHAMMAD AJMAL', 'ahsan solar system offosite madni masjid tank adda\r\nCity	DERA ISMAIL KHAN', 'DERA ISMAIL KHAN', '22522', 'PK-C-5', 'PK-C-5', '	7871495-5', 'K7871495-5', NULL, 'no', 'CNIC-1e937e98.jpeg', NULL, 'FBR-ff94e89f.jpeg', 'KIPRA-62e37b32.jpeg', 'PEC2020-415f42f7.jpeg', '', '', 'no', 0, 0, '2021-07-30 04:07:10', '2024-08-19 08:07:01'),
(8838, 'MUHAMMAD AJMAL CONTRACTOR', 'wazirjamal9@gmail.com', '0333-8508527', '21708-2850959-5', '	MUHAMMAD AJMAL', 'ahsan solar system offosite madni masjid tank adda DERA ISMAIL KHAN', '	DERA ISMAIL KHAN', '22522', 'PK-C-5', 'PK-C-5', '	7871495-5', 'K7871495-5', NULL, 'no', 'CNIC-3d5f907f.jpeg', NULL, 'FBR-cc89b6e6.jpeg', 'KIPRA-37f817b6.jpeg', 'PEC2020-b9c24cd1.jpeg', '', '', 'no', 3, 0, '2021-07-30 05:07:39', '2024-08-26 04:37:28'),
(8839, 'Farhan Wahab & Company', 'farhanwahab2014@gmail.com', '0333-5475304', '17101-6167314-3', 'Abdul Wahab', 'Moh: Sheikh Malli Vill: Nisatta Distt: Charsadda', 'Charsadda', '15330', 'PK-C-4', 'PK-C-4', '7444991', 'K4303930-8', NULL, 'no', 'CNIC-06625cf1.jpeg', NULL, 'FBR-41cb556c.jpeg', 'KIPRA-115a4ac3.jpeg', 'PEC2020-81332e9f.jpeg', '', '', 'no', 0, 0, '2021-07-30 06:07:55', '2024-08-19 08:07:01'),
(8844, 'Pak Reliable Engineering Co (Smc-Private) Limited', 'Sahibzadasiyaf@gmail.com', '03139520156', '1730194674869', 'Sahibzada Siyaf Ahmad', 'Upper Dir', 'Dir', '7442', 'PK-C-3', 'PK-C-3', '8935732-1', 'K8935732-1', NULL, 'no', 'CNIC-5d86b6e4.jpeg', NULL, 'FBR-5d032ae1.jpeg', 'KIPRA-849db2c1.jpeg', 'PEC2020-e6e19372.jpeg', '', '', 'no', 0, 0, '2021-07-29 23:07:58', '2024-08-19 08:07:01'),
(8845, 'Rahimzay Construction Company', 'Rahimzay91@gmail.com', '03339366392', '1730135599953', 'Muzammil Rahim', 'Peshawar', 'Peshawar', '15320', 'PK-C-4', 'PK-C-4', '7372932-6', 'K7372932-6', NULL, 'no', 'CNIC-16cc6eab.jpeg', NULL, 'FBR-5c1966f4.jpeg', 'KIPRA-213ab9ec.jpeg', 'PEC2020-4521abd2.jpeg', '', '', 'no', 0, 0, '2021-07-29 23:07:27', '2024-08-19 08:07:01'),
(8846, 'Rahimzay Construction Company', 'Rahimzay91@gmail.com', '03339366392', '1730135599953', 'Muzammil Rahim', 'Peshawar', 'Peshawar', '15320', 'PK-C-4', 'PK-C-4', '7372932-6', 'K7372932-6', NULL, 'no', 'CNIC-304054ce.jpeg', NULL, 'FBR-31f2a9df.jpeg', 'KIPRA-0457b269.jpeg', 'PEC2020-d6938c8b.jpeg', '', '', 'no', 0, 0, '2021-07-29 23:07:13', '2024-08-19 08:07:01'),
(8852, 'Kk Engineering Services ', 'Kkengineeringservices01@gmail.com', '0308-8866166', '17301-7791402-9', 'Kashif khan', 'Shop# 14,15,16 , block#C, awami , market , karkhano peshawar', 'Peshawar', '19555', 'PK-C-5', 'PK-C-5', '1730177914029', 'K7953929-8', NULL, 'no', 'CNIC-817115ee.jpeg', NULL, 'FBR-a6ec7342.jpeg', 'KIPRA-e8040ed1.jpeg', 'PEC2020-0fda4ee5.jpeg', '', '', 'no', 0, 0, '2021-07-31 05:07:45', '2024-08-19 08:07:01'),
(8853, 'Kk engineering services ', 'iamkashif.510@gmail.com', '0315-8866166', '17301-7791402-9', 'kashif khan', 'Shop#14,15,16 , block#C , awami market , karkhano peshawar', 'Peshawar ', '19555', 'PK-C-5', 'PK-C-5', '7953929', 'K7953929-8', NULL, 'no', 'CNIC-2a728ec4.jpeg', NULL, 'FBR-ffe3f978.jpeg', 'KIPRA-c68c4f15.jpeg', 'PEC2020-13ca1bfe.jpeg', '', 'PE-75cd3e86.jpeg', 'no', 0, 0, '2021-07-31 06:07:04', '2024-08-19 08:07:01'),
(8855, 'Munawar Shah Construction Company & Engineers Services', 'munawarsh888@gmail.com', '03128066388', '15701-1488918-3', 'Munawar Shah', '1st floor fazal market Main Bazar Darora Teh  & Distt Dir Upeer', 'Dir upper', '19972', 'PK-C-5', 'PK-C-5', '5298632-8', 'K5298632-8', NULL, 'no', 'CNIC-67e54a55.jpeg', NULL, 'FBR-9804d34f.jpeg', 'KIPRA-75e46a59.jpeg', 'PEC2020-858efa60.jpeg', '', 'PE-6fabccec.jpeg', 'no', 0, 0, '2021-07-31 20:08:24', '2024-08-19 08:07:01'),
(8856, 'M/s Ghazni construction company & builders', 'Wasiullah1st@gmeil.com', '03009048617', '1730195604911', 'Ibrahim shah', 'Vill & p.o.surazai payan,moh.piran teh & distt. Peshawar', 'Peshawar', '19520', 'PK-C-5', 'PK-C-5', '6097904', '6097904', NULL, 'no', 'CNIC-29ef169b.jpeg', NULL, 'FBR-91c4d37a.jpeg', 'KIPRA-00ee154f.jpeg', 'PEC2020-2979fd58.jpeg', 'Form-H-6932e968.jpeg', '', 'no', 0, 0, '2021-07-31 20:08:17', '2024-08-19 08:07:01'),
(8857, 'M/s KuzaBanda Trand Engineering Services', 'ktes314@gmail.com', '03005580314', '1320230823821', 'Muhammad Kashif Ehsan', 'KuzaBanda House Behind Askari Petrol Pump College Dorah Mansehra', 'Mansehra', '14320', 'PK-C-2', 'PK-C-2', '6960518', 'K6960518-8', NULL, 'no', 'CNIC-bece3f9b.jpeg', NULL, 'FBR-28ee340c.jpeg', 'KIPRA-ebd85a12.jpeg', 'PEC2020-9b04715d.jpeg', 'Form-H-e4fa56af.jpeg', 'PE-00602fbb.jpeg', 'no', 0, 0, '2021-07-31 21:08:56', '2024-08-19 08:07:01'),
(8858, 'M/S Imran And Brothers Construction Company', 'Engrirfankhan456@gmail.com', '03499252526', '1510128751053', 'Imran Khan', 'Sultan Wass,Daggar,District Buner', 'Buner', '23056', 'PK-C-5', 'PK-C-5', '49735348', 'K49735348', NULL, 'no', 'CNIC-870b2ddb.jpeg', NULL, 'FBR-6b58091e.jpeg', 'KIPRA-dfdee902.jpeg', 'PEC2020-ee0edefb.jpeg', '', '', 'no', 0, 0, '2021-07-31 21:08:55', '2024-08-19 08:07:01'),
(8861, 'Sajid and Aman Government Contractor', 'Sajid.khan81973@yahoo.com', '03415375933', '1560165865479', ' ', 'Swat', 'Sajidullah', '24240', 'PK-C-5', 'PK-C-5', 'A255514-4', 'KA255514-4', NULL, 'no', 'CNIC-dc5c94d7.jpeg', NULL, 'FBR-82b605a4.jpeg', 'KIPRA-e7cbe39e.jpeg', 'PEC2020-6b2703c9.jpeg', '', '', 'no', 0, 0, '2021-08-01 23:08:56', '2024-08-19 08:07:01'),
(8862, 'Sajid and Aman Government Contractor', 'Sajid.khan81973@yahoo.com', '03415375933', '1560165865479', 'Sajidullah', 'Swat', 'Swat', '24240', 'PK-C-5', 'PK-C-5', 'A255514-4', 'KA255514-4', NULL, 'no', 'CNIC-794e5376.jpeg', NULL, 'FBR-2beda7b0.jpeg', 'KIPRA-7da6852c.jpeg', 'PEC2020-a6eef6f3.jpeg', '', '', 'no', 0, 0, '2021-08-02 00:08:00', '2024-08-19 08:07:01'),
(8864, 'Pak Reliable Engineering Co (Smc-Private) Limited', 'Sahibzadasiyaf@gmail.com', '03468001333', '1730194674869', 'Sahibzada Siyaf Ahmad', 'Dir', 'Dir', '7442', 'PK-C-3', 'PK-C-3', '8935732-1', 'K8935732-1', NULL, 'no', 'CNIC-d1028976.jpeg', NULL, 'FBR-45b5d398.jpeg', 'KIPRA-a1f0d775.jpeg', 'PEC2020-e18d9cfc.jpeg', '', '', 'no', 0, 0, '2021-08-02 01:08:50', '2024-08-19 08:07:01'),
(8865, 'MATHER KHEL CONSTRUCTION COMPANY', '03337463449khan@gmail.com', '0334-0537118', '11201-3581757-3', 'MUHAMMAD IBRAHIM KHAN', 'KOTKA ZAFAR KHAN BHITTANI FR LAKKI MARWAT', 'LAKKI MARWAT', '13432', 'PK-C-4', 'PK-C-4', '8177633-8', 'K8177633-8', NULL, 'no', 'CNIC-27a2c16a.jpeg', NULL, 'FBR-3b8a793a.jpeg', 'KIPRA-3fcf3d4b.jpeg', 'PEC2020-3df3d88d.jpeg', '', 'PE-571fe868.jpeg', 'no', 0, 0, '2021-08-01 21:08:13', '2024-08-19 08:07:01'),
(8868, 'Kabeer & Co', 'NA@GMAIL.COM', '0958-7485873', '13403-3592676-1', 'Haji Abdul Karim', 'Kohistsan', 'Kohistan', '7389', 'PK-C-3', 'PK-C-3', '13403-3592676-1', '73159154', NULL, 'no', 'CNIC-a5450bb0.jpeg', NULL, 'FBR-d71a5191.jpeg', 'KIPRA-dbfa5d15.jpeg', 'PEC2020-6fda3468.jpeg', '', '', 'no', 0, 0, '2021-08-03 01:08:59', '2024-08-19 08:07:01'),
(8869, 'Ali Construction Enterprises', 'cardalikhan834@gmail.com', '0315-5704020', '17201-2206350-5', 'Zard Ali Khan', 'Sarwar Plaza 3rd Floor Nowshera', 'Peshawar', '7072', 'PK-C-3', 'PK-C-3', '17201-2206350-5', 'K4309985-8', NULL, 'no', 'CNIC-ee50a502.jpeg', NULL, 'FBR-8e767ad2.jpeg', 'KIPRA-9d2593d1.jpeg', 'PEC2020-ea07d2df.jpeg', '', 'PE-c99b6d15.jpeg', 'no', 0, 0, '2021-08-03 02:08:41', '2024-08-19 08:07:01'),
(8870, 'M/S Shahadad Shah Govt. Contractor', 'shahadadshahgovtcontractor@gmail.com', '0310-5421008', '17301-1933580-1', 'Shahadad Shah', 'Mohallah Gari Saidan Deh-Bahadar Tehsil & District Peshawar', 'Peshawar', '24545', 'PK-C-5', 'PK-C-3', '17301-1933580-1', 'KA259971-6', NULL, 'no', 'CNIC-96a704ae.jpeg', NULL, 'FBR-fd161b92.jpeg', 'KIPRA-de204b01.jpeg', 'PEC2020-bf78a192.jpeg', '', '', 'no', 0, 0, '2021-08-03 03:08:36', '2024-08-19 08:07:01'),
(8873, 'Z.H.A CONSTRUCTION COMPANY ', 'amanburkipk@gmail.com', '03449353580', '21702-2310626-7', 'Aman Ullah Burki ', 'Salay Rogha Market Upper Kanigurram Teh. Ladha Distt South Waziristan ', 'South waziristan ', '15421', 'PK-C-4', 'PK-C-4', '5070869-8', 'K5070869-8', NULL, 'no', 'CNIC-544672c0.jpeg', NULL, 'FBR-72689051.jpeg', 'KIPRA-d0bcdebb.jpeg', 'PEC2020-8c2950b8.jpeg', '', '', 'no', 0, 0, '2021-08-02 21:08:51', '2024-08-19 08:07:01'),
(8874, 'MIR WALI KHAN & SONS', 'walikhan123@gmail.com', '0343-2389083', '16101-1175927-5', 'WALI KHAN ', 'PATORRAK ,PO KATLANG MARDAN ', 'Mardan', '24404', 'PK-C-5', 'PK-C-5', '16101-1175927-5', 'K79344573', NULL, 'no', 'CNIC-e301c6d4.jpeg', NULL, 'FBR-cd6bdb53.jpeg', 'KIPRA-c74cd546.jpeg', 'PEC2020-4ea71dbd.jpeg', '', '', 'no', 0, 0, '2021-08-03 01:08:22', '2024-08-19 08:07:01'),
(8875, 'AWAL DAD & BROTHERS', 'awaldadbrotheres@gmail.com', '0334-8683330', '14202-1913979-9', 'AWAL DAD KHAN', 'SHAIR DAD HOTEL, NEAR TEHSIL,', 'KARAK', '3225', 'PK-C-2', 'PK-C-2', '7140527', 'k7140527', NULL, 'no', 'CNIC-8d48e7dc.jpeg', NULL, 'FBR-e49c1842.jpeg', 'KIPRA-98fbc916.jpeg', 'PEC2020-b49b57c5.jpeg', 'Form-H-958746e0.jpeg', 'PE-831c2224.jpeg', 'no', 0, 0, '2021-08-03 01:08:38', '2024-08-19 08:07:01'),
(8876, 'ABDULLAH & BROTHERS KHALIL', 'fara87578@yahoo.com', '0345-5631890', '17301-2550949-7', 'ABDULLAH', 'VILLAGE TEHKAL BALA KANDI AKAZAI', 'Peshawar', '19641', 'PK-C-5', 'PK-C-5', '17301-2550949-7', 'k27344258', NULL, 'no', 'CNIC-308ceb74.jpeg', NULL, 'FBR-17f761a3.jpeg', 'KIPRA-409790bb.jpeg', 'PEC2020-fc023395.jpeg', '', 'PE-f11b4ce0.jpeg', 'no', 0, 0, '2021-08-03 01:08:26', '2024-08-19 08:07:01'),
(8877, 'SYED HAKEEM BUILDERS AND CO', 'abc@pec.org.pk', '0333-9686298', '21604-9796887-5', 'SYED HAKEEM', 'C/O.KHATTAK TRADERS AHMED PLAZA BANK COLONY DHAMIAL ROAD', 'Rawalpindi', '15181', 'PK-C-4', 'PK-C-4', '21604-9796887-5', 'k89104397', NULL, 'no', 'CNIC-1a2be61e.jpeg', NULL, 'FBR-3bd5f3f1.jpeg', 'KIPRA-218951bd.jpeg', 'PEC2020-46254a66.jpeg', '', '', 'no', 0, 0, '2021-08-03 01:08:06', '2024-08-19 08:07:01'),
(8878, 'khiyal jan and sonscontractors ', 'khyalmamad@gmail.com', '0333-9886501', '17301-9594053-7', 'khiyal jan ', 'masjid nosho baba . main  GT road peshawar ', 'Peshawar', '7469', 'PK-C-3', 'PK-C-3', '17301-9594053-7', 'k26468859', NULL, 'no', 'CNIC-58a755de.jpeg', NULL, 'FBR-20bf9ba1.jpeg', 'KIPRA-4a082b62.jpeg', 'PEC2020-b9dad549.jpeg', '', 'PE-ff667f5c.jpeg', 'no', 0, 0, '2021-08-03 02:08:40', '2024-08-19 08:07:01'),
(8879, 'MALIK AFTAB & BROTHERS14295', 'aftabahmad49@gmail.com', '0312-4945321', '17201-2292276-4', 'malik aftab khan', 'VILL. KANDI TAZADIN P.O. & TEH. PUBBI DISTT.', 'NOWSHERA', '14295', 'PK-C-4', 'PK-C-4', '17201-2292276-4', 'k31807623', NULL, 'no', 'CNIC-b36ad761.jpeg', NULL, 'FBR-1c7375d1.jpeg', 'KIPRA-805defca.jpeg', 'PEC2020-408eaf72.jpeg', '', 'PE-69ca8a1f.jpeg', 'no', 0, 0, '2021-08-03 02:08:28', '2024-08-19 08:07:01'),
(8883, '	AMAN ALI KHAN', 'na@yahoo.com', '0311-9189009', '1620248721533', '	AMAN ALI KHAN', 'Mohallah Karam Khel/ Seri, Jalar Village Maneri Payan, Tehsil & District, Swabi Swabi', 'swabi', '24409', 'PK-C-5', 'PK-C-5', '1620248721533', 'k5881897-1', NULL, 'no', 'CNIC-2fd9c286.jpeg', NULL, 'FBR-7f47ff86.jpeg', 'KIPRA-b6daf45e.jpeg', 'PEC2020-02158aa5.jpeg', '', '', 'no', 0, 0, '2021-08-04 06:08:13', '2024-08-19 08:07:01'),
(8884, 'IMMAM SHAH & CO', 'na@yahoo.com', '0346-8647348', '11201-5517040-9', '	IMAM SHAH', 'village & P.O. Abba Khel, Teh & Distt Lakki Marwat', 'LAKKI MARWAT', '24291', 'PK-C-5', 'PK-C-5', '	1120155170409', 'k3795559-4', NULL, 'no', 'CNIC-af423874.jpeg', NULL, 'FBR-e76325bf.jpeg', 'KIPRA-0ad2a240.jpeg', 'PEC2020-235c3786.jpeg', '', '', 'no', 0, 0, '2021-08-04 06:08:45', '2024-08-19 08:07:01'),
(8885, 'IMMAM SHAH & CO', 'na@yahoo.com', '0346-8647348', '11201-5517040-9', '	IMAM SHAH', 'village & P.O. Abba Khel, Teh & Distt Lakki Marwat', 'LAKKI MARWAT', '24291', 'PK-C-5', 'PK-C-5', '	1120155170409', 'k3795559-4', NULL, 'no', 'CNIC-2a56e0c3.jpeg', NULL, 'FBR-086367e9.jpeg', 'KIPRA-37a5ea68.jpeg', 'PEC2020-1ce8fc3f.jpeg', '', '', 'no', 0, 0, '2021-08-04 06:08:04', '2024-08-19 08:07:01'),
(8886, 'IMMAM SHAH & CO', 'na@yahoo.com', '0346-8647348', '11201-5517040-9', '	IMAM SHAH', 'village & P.O. Abba Khel, Teh & Distt Lakki Marwat', 'LAKKI MARWAT', '24291', 'PK-C-5', 'PK-C-5', '1120155170409', 'k3795559-4', NULL, 'no', 'CNIC-f272d32c.jpeg', NULL, 'FBR-1da21fa5.jpeg', 'KIPRA-a7560e1e.jpeg', 'PEC2020-9b76aaa5.jpeg', '', '', 'no', 0, 0, '2021-08-04 06:08:31', '2024-08-19 08:07:01'),
(8887, 'NAYAB KOKAR CONSTRUCTION CO', 'na@yahoo.com', '0336-9778899', '12103-1493042-1', '	HAYAT ULLAH KHAN', 'OFFICE NO.01, RAZZAQ PLAZA OPP. ALLIED BANK LANE NO.04\r\nCity	Rawalpindi', 'Rawalpindi', '6955', 'PK-C-3', 'PK-C-3', '1210314930421', 'K3379484-7', NULL, 'no', 'CNIC-6b5df0a9.jpeg', NULL, 'FBR-ffcc0798.jpeg', 'KIPRA-da15f0af.jpeg', 'PEC2020-872b6df5.jpeg', '', '', 'no', 0, 0, '2021-08-04 06:08:33', '2024-08-19 08:07:01'),
(8890, 'Ms Muhammad Saboor Khan', 'Muhammadsabooor77@gmail.com', '03239100080', '13101_7397439_1', 'Muhammad Saboor Khan', 'Sultan Hotel Chare road TEH and Dist Abbottabad', 'Abbottabad', '26860', 'PK-C-4', 'PK-C-5', '1310173974391', 'K3383121_1', NULL, 'no', 'CNIC-b70e8403.jpeg', NULL, 'FBR-42f86f4c.jpeg', 'KIPRA-18bace2d.jpeg', 'PEC2020-16a97923.jpeg', '', 'PE-049e2ef1.jpeg', 'no', 0, 0, '2021-08-03 21:08:46', '2024-08-19 08:07:01'),
(8891, 'M/S SABIR DAD', 'sabirdad@gmail.com', '0346-9640296', '42401-1622577-9', 'SABIR DAD', 'MIRA MADAKHEL po NEW DARBAND TEH & DISTT MANSEHRA\r\n', 'MANSEHRA', '15277', 'PK-C-5', 'PK-C-5', '3685042-0', 'K3685042-0', NULL, 'no', 'CNIC-35b5122d.jpeg', NULL, 'FBR-2f210a48.jpeg', 'KIPRA-86d96e32.jpeg', 'PEC2020-abdbb192.jpeg', 'Form-H-b408a274.jpeg', '', 'no', 0, 0, '2021-08-05 00:08:58', '2024-08-19 08:07:01'),
(8893, 'M/s BAKHTAJ KHAN & BROTHERS ', 'bakhtajkhan2416@gmail.com', '0312-0051114', '13302-4484239-7', 'Bakhtaj Khan', 'MOH. PALAS P.O. GABASNI, TEH. TOPI DISTT. SWABI', 'Swabi', '75218', 'PK-C-6', 'PK-C-6', '6964070-5', 'K6964070-5', NULL, 'no', 'CNIC-525e3eb9.jpeg', NULL, 'FBR-67853226.jpeg', 'KIPRA-3f598b58.jpeg', 'PEC2020-bc03ae0b.jpeg', '', '', 'no', 0, 0, '2021-08-05 03:08:29', '2024-08-19 08:07:01'),
(8894, 'Shah & Co:', 'sabirshah2017@gmail.com', '0307-5710379', '17101-3680765-9', 'Esar Ullah Shah', 'P.O Prang Mohallah Sheikh Sunnat Khel Charsadda', 'Charsadda', '18572', 'PK-C-5', 'PK-C-5', '5573255-5', 'K5573255-5', NULL, 'no', 'CNIC-d55d9e7c.jpeg', NULL, 'FBR-9204bcc4.jpeg', 'KIPRA-9cb8284c.jpeg', 'PEC2020-751c0a1e.jpeg', '', '', 'no', 0, 0, '2021-08-05 03:08:03', '2024-08-19 08:07:01'),
(8895, 'MUHAMMAD ISRAR HUSSAIN SHAH (DAAG)', 'na@yahoo.com', '1411-1111111', '1730139753535', 'MUHAMMAD ISRAR HUSSAIN SHAH', 'PAJAGGI ROAD, POST OFFICE, DAGG, Peshawar Peshawar', 'Peshawar', '24290', 'PK-C-5', 'PK-C-5', '1730139753535', 'k4389028-8', NULL, 'no', 'CNIC-ab6782fa.jpeg', NULL, 'FBR-a00a3f41.jpeg', 'KIPRA-bb033486.jpeg', 'PEC2020-95f64147.jpeg', '', '', 'no', 0, 0, '2021-08-05 05:08:19', '2024-08-19 08:07:01'),
(8896, 'MULLAHA KHEL BUILDERS & DEVELOPERS', 'akhtarorakzai4232@yahoo.com', '0333-9993991', '1410104176149', 'AKHTAR MUNIR ORAKZAI', 'HOUSE NO.257, STREET NO.44 F-11/3', 'Islamabad', '/24319', 'PK-C-5', 'PK-C-5', '1410104176149', 'K7499774-2', NULL, 'no', 'CNIC-c79a195a.jpeg', NULL, 'FBR-f2525ef4.jpeg', 'KIPRA-ca0cc391.jpeg', 'PEC2020-05aadcbf.jpeg', '', '', 'no', 0, 0, '2021-08-05 05:08:58', '2024-08-19 08:07:01'),
(8897, 'MARJAN ALI & CO', 'marjanali1975@gmail.com', '0332-8500007', '17301-8504770-9', 'MARJAN ALI', 'BILAWAL HOUSE MOH. NAWAZ ABAD ST#17, ZARYAB COLONY FAQIRABAD #2, peshawar', 'Peshawar', '24239', 'PK-C-5', 'PK-C-5', '32309969', 'K32309969', NULL, 'no', 'CNIC-e461f8e0.jpeg', NULL, 'FBR-a1eb345b.jpeg', 'KIPRA-c26cd38e.jpeg', 'PEC2020-c2cbb74c.jpeg', '', '', 'no', 0, 0, '2021-08-05 06:08:41', '2024-08-19 08:07:01'),
(8898, 'BEHR-E-KARAM & SONS', 'behrikaram3434@gmail.com', '0345-9371620', '15402-3873713-5', 'BAKHT KAMAL', 'VILL & P.O DHERE ALLADAND, MOH. SHALMANI TEH:BATKHELA', 'Malakand ', '3304', 'PK-C-2', 'PK-C-2', '15231186', 'K15231186', NULL, 'no', 'CNIC-365b8a7a.jpeg', NULL, 'FBR-a00e3c8e.jpeg', 'KIPRA-79d0de1d.jpeg', 'PEC2020-f14f78eb.jpeg', '', 'PE-ba5924cc.jpeg', 'no', 0, 0, '2021-08-05 06:08:58', '2024-08-19 08:07:01'),
(8901, 'RAHMAT ULLHA', 'rahmatullah@gmail.com', '0333-5923643', '14202-1351285-7', 'RAHMAT ULLAH ', 'NEAR TEH,BUILDING CO RASHID MEDICAL STORE KARAK ', 'KARAK', '14845', 'PK-C-4', 'PK-C-4', '22369853', 'K22369853', NULL, 'no', 'CNIC-8cbd10b9.jpeg', NULL, 'FBR-41ae0dfc.jpeg', 'KIPRA-c07a2d24.jpeg', 'PEC2020-a647dec2.jpeg', '', 'PE-3cbe5119.jpeg', 'no', 0, 0, '2021-08-05 00:08:09', '2024-08-19 08:07:01'),
(8902, 'WAQAS & BRPTHERS', 'waqasbrothers@gmail.com', '03175-752536', '13101-4018168-3', 'WAQAS LKHAN', 'JADOON MARKET 2ND FLOOR OFFICE NO 6 DEPU  ROAD HAVELLAN ', 'ABBOTTABAD', '24665', 'PK-C-5', 'PK-C-5', '6386769-0', '6386769-0', NULL, 'no', 'CNIC-1f3ebc07.jpeg', NULL, 'FBR-c9b8dd21.jpeg', 'KIPRA-66c62303.jpeg', 'PEC2020-69ba875d.jpeg', '', 'PE-3d79542a.jpeg', 'no', 0, 0, '2021-08-05 00:08:52', '2024-08-19 08:07:01'),
(8903, 'ITTEMAD BUILDER& DEVELOPERS PRIVAATE LIMITED', 'ittemadbuilder@gmail.com', '0300-8595519', '17301-9513136-7', 'ITTEMAD ', 'ALAM GODAR ROAD JAVED GODOWN HAJII KHYBER AGENCY ', 'KHYBER AGENCY', '14484', 'PK-C-4', 'PK-C-4', '7143753-3', 'K7143753-3', NULL, 'no', 'CNIC-531d1cb3.jpeg', NULL, 'FBR-17f442d5.jpeg', 'KIPRA-a1745503.jpeg', 'PEC2020-e81671c7.jpeg', '', '', 'no', 0, 0, '2021-08-05 01:08:46', '2024-08-19 08:07:01'),
(8904, 'SYSTEMS ENGINEERING', 'sayidawiasalsha@gmail.com', '0345-4455501', '16101-8142198-9', 'awais ali', 'MOH;KUZ KANDAY VILL VALA I PO SHAHBAZ GARHI TEH &DISTT. MARDAN ', 'Mardan', '14646', 'PK-C-4', 'PK-C-4', '4012168-2', 'K4012168-2', NULL, 'no', 'CNIC-f7ab08f2.jpeg', NULL, 'FBR-2a3832e2.jpeg', 'KIPRA-3d4679db.jpeg', 'PEC2020-9ecf7e83.jpeg', '', 'PE-8f883f1f.jpeg', 'no', 0, 0, '2021-08-05 01:08:53', '2024-08-19 08:07:01'),
(8907, 'Naveed khan construction company', 'naveedconstruction70@gmail.com', '03009394651', '1710102607223', 'Naveed khan', 'Ghatababad Shabqadar Teh& Distt Charsadda', 'Charsadda', '24654', 'PK-C-5', 'PK-C-5', '3752895-5', 'K3752895-5', NULL, 'no', 'CNIC-317e710c.jpeg', NULL, 'FBR-c3dcf391.jpeg', 'KIPRA-d687722e.jpeg', 'PEC2020-a85cc9b6.jpeg', '', '', 'no', 0, 0, '2021-08-06 04:08:00', '2024-08-19 08:07:01'),
(8908, 'Naveed khan construction company', 'naveedconstruction70@gmail.com', '03009394651', '1710102607223', 'Naveed khan', 'Ghatababad Shabqadar Teh & Distt charsadda', 'Charsadda', '24654', 'PK-C-5', 'PK-C-5', '3752895-5', 'K3752895-5', NULL, 'no', 'CNIC-83601641.jpeg', NULL, 'FBR-136a7e8d.jpeg', 'KIPRA-2b4cb457.jpeg', 'PEC2020-81cce2c0.jpeg', '', 'PE-040e5914.jpeg', 'no', 0, 0, '2021-08-06 04:08:15', '2024-08-19 08:07:01'),
(8909, 'HAJI ALI ZAMAN &BROTHERS ', 'hajializaman@gmail.com', '0333-5996374', '21303-2245545-5', 'HAJI ALI ZAMAN ', 'PARACHINAR UPPER KURRAM AGENCY KURRAM AGENCY ', 'UPPER KURRAM ', '24644', 'PK-C-5', 'PK-C-5', '21303-2245545-5', 'K76529002', NULL, 'no', 'CNIC-a7397ce8.jpeg', NULL, 'FBR-1b2fde8f.jpeg', 'KIPRA-ae448ab3.jpeg', 'PEC2020-5f5b7f21.jpeg', '', 'PE-7f822b2a.jpeg', 'no', 0, 0, '2021-08-06 05:08:00', '2024-08-19 08:07:01'),
(8910, 'MUHAMMAD SAMIULLAH ', 'muhammadsamiullah@gmail.com', '0347-3700769', '15202-8457705-7', 'muhammad samiullah', 'VILLAG3E WARIJUN MULKHOW TEHSIL MASTUJ DISTRICT UPPER CHIRAL ', 'UPPER CHITRAL ', '24661', 'PK-C-5', 'PK-C-5', '15202-8457705-7', '74941345', NULL, 'no', 'CNIC-5a2621ba.jpeg', NULL, 'FBR-a8401050.jpeg', 'KIPRA-593335bf.jpeg', 'PEC2020-d2964f81.jpeg', '', '', 'no', 0, 0, '2021-08-06 06:08:57', '2024-08-19 08:07:01'),
(8911, 'M/S GHULAM FARID & SONS ', 'Ahsanawan9090@gmail.com', '0335-6262628', '17301-1286116-9', 'Ghulam farid', 'House no 2015/12 shaheed bazar peshawar ', 'peshawar', '19475', 'PK-C-5', 'PK-C-5', '0999680-0', 'k0999680-0', NULL, 'no', 'CNIC-f8db2fdf.jpeg', NULL, 'FBR-489e19c2.jpeg', 'KIPRA-651c238a.jpeg', 'PEC2020-3a255742.jpeg', '', 'PE-4a876f76.jpeg', 'no', 0, 0, '2021-08-06 06:08:39', '2024-08-19 08:07:01'),
(8912, 'AXS PAKISTAN (PVT) LIMITED', 'axspakistanho@gmail.com', '0300-0807811', '17301-4816566-1', 'SYED ZAHID HUSSAIN SHAH', 'SARA-E-KHARBOOZA, P.O. TARNOL, G.T. ROAD, ISLAMABAD', 'PESHAWAR', '243', 'PK-C-B', 'PK-C-B', '1865935-7', 'K1865935-7', NULL, 'no', 'CNIC-dbaa4f03.jpeg', NULL, 'FBR-28fd2e96.jpeg', 'KIPRA-3855c34f.jpeg', 'PEC2020-87e74841.jpeg', '', 'PE-7452e8a6.jpeg', 'no', 0, 0, '2021-08-07 01:08:55', '2024-08-19 08:07:01'),
(8916, 'M/s Alam zeb', 'NA@YAHOO.COM', '03165052929', '1560218888083', 'Alam zeb', 'Kokarai moh: Banr: Teh: Babozai Distt: Swat. ', 'SWAT', '23067', 'PK-C-5', 'PK-C-5', '1560218888083', 'K5252382-0', NULL, 'no', 'CNIC-b7719063.jpeg', NULL, 'FBR-b54ec1af.jpeg', 'KIPRA-72665817.jpeg', 'PEC2020-9cf59698.jpeg', '', '', 'no', 0, 0, '2021-08-07 23:08:07', '2024-08-19 08:07:01'),
(8919, 'New nawab khan & brothers', 'Nawabkhan@gmail.com', '03068301065', '1570131211483', 'Nawab khan', 'Vill kumbar', 'DIR', '24648', 'PK-C-5', 'PK-C-5', '1570131211483', 'K82226788', NULL, 'no', 'CNIC-2b14138e.jpeg', NULL, 'FBR-8ee699fa.jpeg', 'KIPRA-841fdec1.jpeg', 'PEC2020-167bd119.jpeg', '', '', 'no', 0, 0, '2021-08-09 03:08:22', '2024-08-19 08:07:01'),
(8920, 'M/s NAVEED KAMAL & BROTHERS', 'naveedkamal29@gmail.com', '0300-9080181', '16202-2285561-1', 'Naveed Kamal', 'Gulo Dheri Swabi P.O Swabi, Tehsil & District Swabi', 'Swabi', '18926', 'PK-C-5', 'PK-C-5', '4007300-9', 'K4007300-9', NULL, 'no', 'CNIC-fa9556db.jpeg', NULL, 'FBR-e3320f47.jpeg', 'KIPRA-2c5f927b.jpeg', 'PEC2020-d2c6b43d.jpeg', '', '', 'no', 0, 0, '2021-08-09 03:08:11', '2024-08-19 08:07:01'),
(8921, 'Haji safdar khan', 'Hijisafdarkhan@gmail.com', '034399624136', '1730217706775', 'Haji safdar khan ', 'Dir ', 'Dir', '23065', 'PK-C-5', 'PK-C-5', '30218624', '3021862', NULL, 'no', 'CNIC-c2b46d49.jpeg', NULL, 'FBR-93efcee7.jpeg', 'KIPRA-835797d2.jpeg', 'PEC2020-75fb1989.jpeg', '', '', 'no', 0, 0, '2021-08-09 03:08:36', '2024-08-19 08:07:01'),
(8922, 'SHAKIR ULLAH DANISH & SONS KOH CONSTRUCTION COMPANY', 'shakirbarghuzi@gmail.com', '0340-1694094', '15201-0605980-9', 'SHAKIRULLAH', 'VILL BARGHUZI TEH & DISTT.', 'CHITRAL', '24243', 'PK-C-5', 'PK-C-5', '15201-0605980-9', '79642236', NULL, 'no', 'CNIC-66b4b2ca.jpeg', NULL, 'FBR-2590140a.jpeg', 'KIPRA-51ae75aa.jpeg', 'PEC2020-f75163b2.jpeg', '', '', 'no', 0, 0, '2021-08-09 03:08:49', '2024-08-19 08:07:01'),
(8923, 'C&w mega project swat ', 'asarkhan2021@gmail.com', '0342-0086237', '15602-4444064-9', 'Asarkhan', 'P.o aboha Barikot swat kpk', 'SwAt kpk', 'ipi Indus polytechnic gt road odigram swar', 'PK-C-2', 'PK-C-3', 'No fbr', 'No ', NULL, 'no', 'CNIC-f14156e5.jpeg', NULL, 'FBR-61edde63.jpeg', 'KIPRA-b6ce02f8.jpeg', 'PEC2020-69713567.jpeg', 'Form-H-85f2bf48.jpeg', 'PE-7490765c.jpeg', 'no', 0, 0, '2021-08-09 04:08:48', '2024-08-19 08:07:01'),
(8924, 'LAL SHARIF & CO', 'lalsharif14@gmail.com', '0346-3613674', '13504-5971873-5', 'LAL SHARIF', 'KALA DHAKA MAIRA MADA KHAIL P.O.NEW DARBAND', 'MANSEHRA', '15162', 'PK-C-5', 'PK-C-5', '4263491', 'k42683491', NULL, 'no', 'CNIC-058349ed.jpeg', NULL, 'FBR-2d875c1c.jpeg', 'KIPRA-2ca8298e.jpeg', 'PEC2020-58c0139a.jpeg', '', 'PE-fdd96218.jpeg', 'no', 0, 0, '2021-08-09 05:08:21', '2024-08-19 08:07:01'),
(8931, 'Nasir Muhammad/ Nasir and Brothers construction company ', 'Nasir.mspm1@gmail.com', '0314-9998855', '16202-8320424-9', ' Asif Muhammad ', 'Mohalla Moti Kheil , Maneri Payan po Tehsil and Disstrict Swabi', 'Swabi ', '24651', 'PK-C-5', 'PK-C-5', '4445131-4', 'K4445131-8', NULL, 'no', 'CNIC-1d8fb76a.jpeg', NULL, 'FBR-60162787.jpeg', 'KIPRA-85185cac.jpeg', 'PEC2020-fbd7912a.jpeg', '', '', 'no', 0, 0, '2021-08-08 21:08:33', '2024-08-19 08:07:01'),
(8932, 'Nasir Muhammad', 'Tahir.mspm1@gmail.com', '0314-9998855', '16202-8320424-9', 'NASIR MUAHAMMAD', 'Mohalla Moti Kheil , PO Tehsil and Disstrict swabi', 'Swabi', '24651', 'PK-C-5', 'PK-C-5', '4445131-4', 'K4445131-8', NULL, 'no', 'CNIC-fcc73a47.jpeg', NULL, 'FBR-f19129c6.jpeg', 'KIPRA-3a1dfd8e.jpeg', 'PEC2020-29830ec4.jpeg', '', 'PE-1e591ae5.jpeg', 'no', 0, 0, '2021-08-09 00:08:03', '2024-08-19 08:07:01'),
(9683, 'NM Builders', 'nmbuilders8@gmail.com', '0304-9651308', '21303-6608938-1', 'Engr Mudassir Hussain', 'Office No 21, RoseOne Plaza ,I/8 Markaz Islamabad', 'Kurram Agency', '15477', 'PK-C-4', 'PK-C-4', '5138003', 'k5138003-2', NULL, 'no', 'CNIC-e4e804f4.jpeg', NULL, 'FBR-c1fc7a88.jpeg', 'KIPRA-94990e87.jpeg', 'PEC2020-9301f492.jpeg', '', '', 'no', 0, 0, '2021-08-09 20:08:41', '2024-08-19 08:07:01'),
(10438, 'M/S Iftikhar Govt. Contractor', 'iftikhargovtcontractor@gmail.com', '0345-9386994', '17301-3560461-3', 'Iftikhar', 'Mohallah Mughalzai, Tehkal Bala Peshawar', 'Peshawar', '24650', 'PK-C-5', 'PK-C-5', '17301-3560461-3', 'K7878486-3', NULL, 'no', 'CNIC-03c1a922.jpeg', NULL, 'FBR-a4922c91.jpeg', 'KIPRA-56831eba.jpeg', 'PEC2020-f54170dd.jpeg', '', 'PE-8485922f.jpeg', 'no', 0, 0, '2021-08-12 02:08:26', '2024-08-19 08:07:01'),
(10440, 'MALIK ARIF & BROTHERS', 'malik.rahat123@gmail.com', '0345-9147105', '1730180218555', '	ARIF ULLAH', 'MOH. MUGHAL ZAI TEHKAL BALA P.O.KHAS TEH & DISTT', 'Peshawar', '32439', 'PK-C-6', 'PK-C-6', '1730180218555', '	K3141916-0', NULL, 'no', 'CNIC-8057ccdf.jpeg', NULL, 'FBR-da3b3656.jpeg', 'KIPRA-b9fc7f59.jpeg', 'PEC2020-4e85dcd6.jpeg', '', '', 'no', 0, 0, '2021-08-12 05:08:11', '2024-08-19 08:07:01'),
(10442, 'M/S THE 3C ENTERPRISE', 'the3centerprise@gmail.com', '0343-9056897', '13302-1290021-9', 'SYED MUSSARAT SHAH', 'HOUSE NO. 05/1 D, MES ROAD, MAKKA STREET, HABIBULLAH COLONY DISTRICT & TEHSIL ABBOTTABAD', 'ABBOTTABAD', '13219', 'PK-C-4', 'PK-C-4', '0336706-1', 'K0336706-1', NULL, 'no', 'CNIC-87ca71fe.jpeg', NULL, 'FBR-23b24825.jpeg', 'KIPRA-bd83a532.jpeg', 'PEC2020-e14757f5.jpeg', '', '', 'no', 0, 0, '2021-08-11 22:08:24', '2024-08-19 08:07:01'),
(10443, 'SABIT ALI & BROTHERS', 'sabitalibrothers@gmail.com', '0310-9074847', '2160386618501', 'SABIT ALI	', 'VILL. TARANGI P.O. KADA ORAKZAI', 'ORAKZAI AGENCY', '3493', 'PK-C-2', 'PK-C-2', '2160386618501', 'K4232688-5', NULL, 'no', 'CNIC-4969f6af.jpeg', NULL, 'FBR-9b772895.jpeg', 'KIPRA-3f051712.jpeg', 'PEC2020-0a3272de.jpeg', '', 'PE-68849042.jpeg', 'no', 0, 0, '2021-08-13 01:08:53', '2024-08-19 08:07:01'),
(10444, 'M/S Aslam  Shah & Co (Pvt) Ltd', 'aslamshahco@yahoo.com', '03339013992', '1720123200387', 'Aslam Shah', 'House No 16/2 Station Road Nowshera Cantt ', 'Nowshera', '3143', 'PK-C-2', 'PK-C-2', '3151719-6', 'K3151719-6', NULL, 'no', 'CNIC-8e080bed.jpeg', NULL, 'FBR-a82f15f8.jpeg', 'KIPRA-cec8dcda.jpeg', 'PEC2020-469991fd.jpeg', 'Form-H-f72f7bc3.jpeg', 'PE-5dae2f06.jpeg', 'no', 0, 0, '2021-08-13 02:08:19', '2024-08-19 08:07:01'),
(10449, 'NAWAZ KHAN & CO ', 'ahmadjadoon20145@gmail.com', '0333-5048628', '13101-8944323-1', 'MUHAMMAD NAWAZ KHAN ', 'Stadium  side Muree  Road  House No 1463/5 , Mohalla Jhogan New City Abbottabad ', 'ABBOTTABAD ', '17458', 'PK-C-5', 'PK-C-5', '21933146', 'K2193314-6', NULL, 'no', 'CNIC-1b38ca6a.jpeg', NULL, 'FBR-8ca2f825.jpeg', 'KIPRA-60fe627b.jpeg', 'PEC2020-c37dca3e.jpeg', '', '', 'no', 0, 0, '2021-08-14 01:08:01', '2024-08-19 08:07:01'),
(10450, 'Iqbalshahhalimzaipvtlmt', 'iqbalshahhalimzai@gmail.com', '03449111411', '2140229683759', 'Iqbal shah', 'wali baig p/o Navi kaly tehsil halimzai district mohmand', 'Mohmand', '3498', 'PK-C-2', 'PK-C-2', '7604081', 'k43746497', NULL, 'no', 'CNIC-a9221bf0.jpeg', NULL, 'FBR-b8f79b04.jpeg', 'KIPRA-7a407b9e.jpeg', 'PEC2020-d976635a.jpeg', '', 'PE-6fde8044.jpeg', 'no', 0, 0, '2021-08-15 22:08:22', '2024-08-19 08:07:01'),
(10455, 'M/s DMK Construction', 'coolentengineering7@gmail.com', '0332-0928404', '16202-5169237-7', 'Dayash Muhammad ', 'house # 74, Street # 3,  Sector F-10 Phase # 6 Hayatabad Peshawar', 'Peshawar', '76046', 'PK-C-6', 'PK-C-6', '6568842-3', 'K6568842-3', NULL, 'no', 'CNIC-2cb6cba2.jpeg', NULL, 'FBR-795ebd4c.jpeg', 'KIPRA-654c0362.jpeg', 'PEC2020-0b17a0db.jpeg', '', '', 'no', 0, 0, '2021-08-16 05:08:45', '2024-08-19 08:07:01'),
(10458, 'Shahid builders (pvt) ltd', 'waqasmahmood@shahibuilders.com.pk', '0304-4191786', '35202-3963535-7', 'shahid Mahmood', '23 Ajmal khan St .No 115 Lytton Road Mozang Lahore', 'lahore', '252', 'PK-C-A', 'PK-C-A', '3687132-0', 'k3687132-0', NULL, 'no', 'CNIC-64696408.jpeg', NULL, 'FBR-faf415d4.jpeg', 'KIPRA-101bfc88.jpeg', 'PEC2020-52f4b22a.jpeg', 'Form-H-b1a656f8.jpeg', '', 'no', 0, 0, '2021-08-17 01:08:24', '2024-08-19 08:07:01'),
(10463, 'HASHT NAGAR CONSTRUCTION CO', 'faiz_kn@yahoo.com', '0300-8583211', '17101-0306052-1', 'Shamsher Khan', 'H.# 69 ST.# 34 SECTOR G-14/4 ISLAMABAD', 'Islamabad', '334', 'PK-C-A', 'PK-C-A', '12048867', 'k12048867', NULL, 'no', 'CNIC-c39755c7.jpeg', NULL, 'FBR-373c8266.jpeg', 'KIPRA-6c0f573a.jpeg', 'PEC2020-607b25ff.jpeg', '', 'PE-464490a7.jpeg', 'no', 0, 0, '2021-08-17 05:08:46', '2024-08-19 08:07:01'),
(10466, 'Fahad and Co construction services', 'Fahad.ullah.bangash@gmail.com', '03015917171', '1410186261347', 'Fahad Ullah ', 'Bannu chowk Tehsil Thall District Hangu', 'Hangu', '15438', 'PK-C-4', 'PK-C-4', '5330935', 'K7451836-7', NULL, 'no', 'CNIC-cf451c7d.png', NULL, 'FBR-2e6f2909.jpeg', 'KIPRA-518b7e01.png', 'PEC2020-3a468a51.jpeg', '', '', 'no', 0, 0, '2021-08-16 22:08:15', '2024-08-19 08:07:01'),
(10467, 'Bakhtawar And Sons Engineers & Consultants', 'sajideen.afridi.9@gmail.com', '03355235335', '17301-5686548-9', 'Sajideen Khan', 'Mulazai Chowk Umer abad Sufaid Sung Road Peshawar', 'Peshawar', '15754', 'PK-C-5', 'PK-C-5', '7881577-7', '7881577', NULL, 'no', 'CNIC-95dedb69.jpeg', NULL, 'FBR-e0acfc0c.jpeg', 'KIPRA-a679d77e.jpeg', 'PEC2020-e9c7e3fd.jpeg', '', 'PE-f1411254.jpeg', 'no', 0, 0, '2021-08-17 00:08:50', '2024-08-19 08:07:01'),
(10472, 'M/s Subhan U Din', 'samiullahkhan222@gmail.com', '0345-1561353', '15201-8643067-9', 'Subhan Ud Din', 'Faizabad District Chitral.', 'Chitral', 'C5/20573', 'PK-C-5', 'PK-C-5', '15201-8643067-9', '	5094484-7', NULL, 'no', 'CNIC-7910b158.png', NULL, 'FBR-d8e328d2.jpeg', 'KIPRA-08f0f43b.jpeg', 'PEC2020-b8d497ae.jpeg', '', 'PE-9ca8bc03.jpeg', 'no', 0, 0, '2021-08-19 00:08:42', '2024-08-19 08:07:01'),
(10475, 'M/s Hamesh Gul And Sons', 'Coolentengineering7@gmail.com', '0300-9194976', '21201-8166301-5', 'HAMESH GUL', 'Qoom bar Qambar khel tapa sheikh mal khel kanday wali khel toot dhand P/o Bara  Khyber bara Khyber agency', 'Khyber ', '6863', 'PK-C-3', 'PK-C-3', '4094254-6', 'K4094254-6', NULL, 'no', 'CNIC-85a3aaaa.jpeg', NULL, 'FBR-733cb941.jpeg', 'KIPRA-3143a020.jpeg', 'PEC2020-5f091aa5.jpeg', '', '', 'no', 0, 0, '2021-08-20 00:08:49', '2024-08-19 08:07:01'),
(10476, 'M/S MOHIBULLAH KHAN AND CO', 'mohibullahkhanandco1@gmail.com', '0346-2809977', '1560229671013', 'javid ali', 'VILLAGE GASHKOR TEHSIL AND P/O KHWAZA KHELA SWAT KPK', 'swat', '15093', 'PK-C-5', 'PK-C-5', '7393179', 'K7393179-3', NULL, 'no', 'CNIC-c4ba2046.jpeg', NULL, 'FBR-c052dc20.jpeg', 'KIPRA-7447b943.jpeg', 'PEC2020-3ded6d59.jpeg', 'Form-H-83458e57.jpeg', 'PE-1b8b9189.jpeg', 'no', 0, 0, '2021-08-20 02:08:09', '2024-08-19 08:07:01'),
(10477, 'M.NAIK MOHAMMAD & SONS', 'naik@gmail.com', '0346-9413474', '15302-5227872-1', 'NAIK MOHAMMAD', 'VILLAGE KAMANGARA TALASH TIMERGARA', 'DIR', '15402', 'PK-C-4', 'PK-C-4', '3664301-7', '3664301-7', NULL, 'no', 'CNIC-816842c3.jpeg', NULL, 'FBR-ae53549b.jpeg', 'KIPRA-f4a22969.jpeg', 'PEC2020-b37f40fb.jpeg', '', 'PE-14dd46c4.jpeg', 'no', 0, 0, '2021-08-20 04:08:37', '2024-08-19 08:07:01'),
(10478, 'SHER MUHAMMAD', 'shermuhammad@gmail.com', '0346-9385070', '15302-0902358-1', 'SHER MUHAMMAD ', 'VILL SARAI PAYEEN TALASH P.O TEH ; TIMERGARA DISTTI DIR LOWER ', 'DIR', '15429', 'PK-C-4', 'PK-C-4', '15302-0902358-1', 'K5128048-1', NULL, 'no', 'CNIC-7ac60e7b.jpeg', NULL, 'FBR-6949ef80.jpeg', 'KIPRA-6d62b2cf.jpeg', 'PEC2020-ace000da.jpeg', '', 'PE-44deff7f.jpeg', 'no', 0, 0, '2021-08-20 04:08:48', '2024-08-19 08:07:01'),
(10479, 'ZAFAR&SONS', 'zafarkhan@gmail.com', '0300-6012896', '38403-4440609-1', 'ZAFAR KHAN', 'KOKI KHER MANYA KHEL AJMEER KALLAY P.O JAMRUD KHYBER AJENCY', 'KHYBER ', '70456', 'PK-C-6', 'PK-C-6', '5409864-0', 'K5409864-0', NULL, 'no', 'CNIC-65bf7893.jpeg', NULL, 'FBR-fe602e1e.jpeg', 'KIPRA-14fb9600.jpeg', 'PEC2020-b1e5ba8b.jpeg', '', '', 'no', 0, 0, '2021-08-20 04:08:34', '2024-08-19 08:07:01'),
(10480, 'SRJ Builders', 'sirajulhaq159@gmail.com', '0311-9797806', '17301-1474789-5', 'Fayaz Ul Haq', 'Plot No 108 Street No. 2 Green Town PO Potal Colony Said Hassan Pir Road Kohat Road Peshawar', 'Peshawar', 'Peshawar', 'PK-C-4', 'PK-C-4', '4379611-7', 'K4379611-7', NULL, 'no', 'CNIC-9e4b2add.jpeg', NULL, 'FBR-fe7cfaac.jpeg', 'KIPRA-ed11a785.jpeg', 'PEC2020-08020915.jpeg', '', '', 'no', 0, 0, '2021-08-20 05:08:32', '2024-08-19 08:07:01'),
(10481, 'NEW MUHAMMAD RIAZ BUILDERS', 'riazgovt495@gmail.com', '0346-5973781', '21027-1656991', 'MUHAMMAD RIAZ', 'NEW MUHAMMAD RIAZ BUILDERS BAJUR AGENCY', 'BARANG ', '23031', 'PK-C-5', 'PK-C-5', 'A0720898', 'KA0720898', NULL, 'no', 'CNIC-b916db11.jpeg', NULL, 'FBR-200b67fb.jpeg', 'KIPRA-597af298.jpeg', 'PEC2020-9385fdef.jpeg', '', '', 'no', 0, 0, '2021-08-20 05:08:35', '2024-08-19 08:07:01'),
(10482, 'Muhammad Arqam contractor smc Pvt LTD', 'atifphy08@gmail.com', '03034050596', '3520208085703', 'Muhammad Atif Asghar', 'Kot shadi da po morr khunda nankana sahib', 'Nankana sahib', 'C5/24861', 'PK-C-5', 'PK-C-5', '8094355-7', '8094355-7', NULL, 'no', 'CNIC-ee26aea5.jpeg', NULL, 'FBR-ada9c70a.jpeg', 'KIPRA-f7cacb10.jpeg', 'PEC2020-bbdeb3c2.jpeg', '', '', 'no', 0, 0, '2021-08-21 01:08:55', '2024-08-19 08:07:01'),
(10483, 'M/S Hasnat Construction Experts', 'engrhasnatkhan@gmail.com', '0335-1556255', '38302-9709670-9', 'Muhammad Hasnat', 'Al Waris City Bannu Road H# 2 OPP: Chapri Hotel P.O Sheikh Yousaf Adda Dera Ismail Khan', 'Dera Ismail Khan', '24418', 'PK-C-5', 'PK-C-5', '272160-0', '272160', NULL, 'no', 'CNIC-1c8a4b05.jpeg', NULL, 'FBR-3a21d67d.jpeg', 'KIPRA-e9d332b6.jpeg', 'PEC2020-1053ada5.jpeg', '', '', 'no', 0, 0, '2021-08-21 04:08:52', '2024-08-19 08:07:01'),
(10484, 'M/S Almas Said Builders', 'rehmanawan0078@gmail.com', '0333-8812256', '22301-1283517-9', 'Said Ahmad', 'Sangjani Bazar Baswal Road Pak Capital Granite and marbel Factory Islamabad', 'Islamabad', '15491', 'PK-C-4', 'PK-C-4', '7620477-6', '7620477-6', NULL, 'no', 'CNIC-09039c57.jpeg', NULL, 'FBR-7ba42e5b.jpeg', 'KIPRA-0ad78d26.jpeg', 'PEC2020-a2829ad7.jpeg', '', '', 'no', 0, 0, '2021-08-21 04:08:49', '2024-08-19 08:07:01'),
(10485, 'M/S Almas Said Builders', 'rehmanawan0078@gmail.com', '0333-8812256', '22301-1283517-9', 'Said Ahmad', 'Sangjani Bazar Baswal Road Pak Capital Granite and marbel Factory Islamabad', 'Islamabad', '15491', 'PK-C-4', 'PK-C-4', '7620477-6', '7620477-6', NULL, 'no', 'CNIC-7274d8ea.jpeg', NULL, 'FBR-2b329b0e.jpeg', 'KIPRA-d053bec2.jpeg', 'PEC2020-96343dd0.jpeg', '', '', 'no', 0, 0, '2021-08-21 04:08:20', '2024-08-19 08:07:01'),
(10486, 'M/S Mohammad Sadiq Sherani', 'sadiqsherani123@gmail.com', '0345-9888394', '22301-2135013-3', 'Muhammad Sadiq Khan', 'Teh: Darazinda FR Dera Ismail Khan Dera Ismail Khan', 'FR DIKhan', '7506', 'PK-C-3', 'PK-C-3', '7403055-6', '7403055-6', NULL, 'no', 'CNIC-c10bf987.jpeg', NULL, 'FBR-b2d0818a.jpeg', 'KIPRA-aa7c2453.jpeg', 'PEC2020-7ca21d55.jpeg', '', '', 'no', 0, 0, '2021-08-21 04:08:56', '2024-08-19 08:07:01'),
(10487, 'M/S Malik Muhammad Kashif Adil', 'kashifadil345@gmail.com', '03339973110', '12101-9784537-7', 'Malik Muhammad Kashif Adil', 'H#246/24, Shah Alam Abad Dera Ismail Khan', 'Dera Ismail Khan', '6979', 'PK-C-3', 'PK-C-3', '2450185-9', '2450185-9', NULL, 'no', 'CNIC-183493ff.jpeg', NULL, 'FBR-d37c359b.jpeg', 'KIPRA-2237d8b5.jpeg', 'PEC2020-6352a73b.jpeg', '', '', 'no', 0, 0, '2021-08-21 04:08:43', '2024-08-19 08:07:01'),
(10492, 'Fahad and Co. construction services', 'Fahad.ullah.bangash@gmail.com', '03323542807', '14101-0800248-9', 'Iqbal javid ', 'Bannu chowk Tehsil Thall, District Hangu', 'Hangu', '15438', 'PK-C-4', 'PK-C-4', '5330935', '7451836-7', NULL, 'no', 'CNIC-79b99a4e.jpeg', NULL, 'FBR-51deb567.jpeg', 'KIPRA-145df266.jpeg', 'PEC2020-9b34f79d.jpeg', 'Form-H-db1b5588.jpeg', 'PE-ec90cf9d.jpeg', 'no', 0, 0, '2021-08-23 01:08:15', '2024-08-19 08:07:01'),
(10493, 'RAHIM ULLAH & CO', 'rehimullah1203@gmail.com', '0346-9552143', '21102-4994078-3', 'RAHEEM ULLAH', 'BAR SAFARAY GHER SHAMOZAI P.O.TOTAKAN BARANG DISTT', '	BAJAUR AGENCY', '23030', 'PK-C-5', 'PK-C-5', '21102-49940783', 'K42975328', NULL, 'no', 'CNIC-96972fc3.jpeg', NULL, 'FBR-de3890bb.jpeg', 'KIPRA-12182232.jpeg', 'PEC2020-75c201f5.jpeg', '', 'PE-4e7db719.jpeg', 'no', 0, 0, '2021-08-23 02:08:14', '2024-08-19 08:07:01'),
(10494, 'AKH Government Contractor	', 'na@gmail.com', '0312-9871606', '21103-6278991-1', '	MUHAMMAD AYUB', 'Mir Ali, Qila, Khar, Bajaur, Khar.	', 'Peshawar', '7191', 'PK-C-3', 'PK-C-3', '2110362789911', 'K6962069-2', NULL, 'no', 'CNIC-f953092f.jpeg', NULL, 'FBR-6dd71cd7.jpeg', 'KIPRA-0cd9513f.jpeg', 'PEC2020-c6a667ae.jpeg', '', '', 'no', 0, 0, '2021-08-23 04:08:35', '2024-08-19 08:07:01'),
(10496, 'SAID BADSHAH BHITTANI', 'saidbhittani@gmail.com', '0345-9844323', '1220196274015', 'SAID BADSHAH', ' KIRRI UMAR UMAR ADDA	', 'Tank', '24663', 'PK-C-5', 'PK-C-5', '1220196274015', 'K3547109-3', NULL, 'no', 'CNIC-a5d64603.jpeg', NULL, 'FBR-c4d98933.jpeg', 'KIPRA-722975d3.jpeg', 'PEC2020-5d070986.jpeg', '', 'PE-8adc845b.jpeg', 'no', 0, 0, '2021-08-23 06:08:43', '2024-08-19 08:07:01'),
(10497, 'SALEH CONSTRUCTION CO', 'mushtaqsaleh444@gmail.com', '0345-9421444', '15701-6787656-3', 'Mushtaq Saleh', 'MUSHTAQ SALEH HOUSE DIR', 'DIR Upper', '447', 'PK-C-A', 'PK-C-A', '3350532', '3350532-2', NULL, 'no', 'CNIC-ce9f31ee.jpeg', NULL, 'FBR-b869b114.jpeg', 'KIPRA-f639947c.jpeg', 'PEC2020-597dcd19.jpeg', '', 'PE-18f789c8.jpeg', 'no', 0, 0, '2021-08-23 06:08:21', '2024-08-19 08:07:01'),
(10498, 'M/S KALIM KHAN SHIN KAMER', 'na@gmail.com', '0333-9403130', '21201-8996735-9', 'Kalim Khan', 'RING ROAD PUSHTAKHARA CHOWK AMIN SERVICE & GENERAL STORE Peshawar', 'Peshawar', '24653', 'PK-C-5', 'PK-C-5', '8287028-8', '8287028-8', NULL, 'no', 'CNIC-bd1fda62.jpeg', NULL, 'FBR-17ae624a.jpeg', 'KIPRA-610ed5f2.jpeg', 'PEC2020-6ae1a1d0.jpeg', '', '', 'no', 0, 0, '2021-08-23 06:08:16', '2024-08-19 08:07:01'),
(10499, 'M/S Nawab Zada Government Contractor', 'nawabmanerwal@gmail.com', '03325882985', '1620233472065', 'Nawab Zada', 'Maneri Bala, Gar Banda, P.O, Tehsil & District Swabi', 'Swabi', 'C5/24876', 'PK-C-5', 'PK-C-5', '1640581-1', 'K1640581-1', NULL, 'no', 'CNIC-ccfb9a7c.jpeg', NULL, 'FBR-1fcc704a.jpeg', 'KIPRA-da2b9647.jpeg', 'PEC2020-ae364b8c.jpeg', '', 'PE-3b2d4f00.jpeg', 'no', 0, 0, '2021-08-23 07:08:54', '2024-08-19 08:07:01'),
(10500, 'Ms shafiq jan & brother', 'shafiqjan350@gmail.com', '03151208258', '17101-4833155-3', 'Shafiq jan', 'Rahman plaza 2nd floor mardan raod charsadda', 'Charsadda', '24888', 'PK-C-5', 'PK-C-5', '3750608-7', '37506087', NULL, 'no', 'CNIC-dd7d3bc5.jpeg', NULL, '', 'KIPRA-876a613e.jpeg', 'PEC2020-d4c88107.jpeg', '', 'PE-ef542e72.jpeg', 'no', 0, 0, '2021-08-23 23:08:07', '2024-08-19 08:07:01'),
(10501, 'M/S SAID AFRIDI', 'saidmafridi@gmail.com', '0333-9155659', '17301-1474205-9', 'SAID MUHAMMAD .', 'Shop#2, Fazal Rahman Makhet Warsa RoaD Peshawar', 'Peshawar', '23750', 'PK-C-5', 'PK-C-5', '7556718-3', 'K7556718-3', NULL, 'no', 'CNIC-bc628dc6.jpeg', NULL, 'FBR-f4afb8ae.jpeg', 'KIPRA-e1fdced6.jpeg', 'PEC2020-0a07c21e.jpeg', '', '', 'no', 0, 0, '2021-08-24 01:08:40', '2024-08-19 08:07:01'),
(10502, 'MIR AZAM KHAN AND SONS', 'mirazamkhan.sons@gmail.com', '0333-9763137', '21702-2341058-9', 'MIR AZAM KHAN', 'SHOHAB MOBILE ZONE AND PHOTOSTATE SHOP DAMAN PLAZA DERA ISMAIL KHAN ROAD DISTRICT TANK', 'SOUTH WAZIRISTAN', '15502', 'PK-C-4', 'PK-C-4', '7399345-4', '7399345-4', NULL, 'no', 'CNIC-2503ea23.jpeg', NULL, 'FBR-27c63f61.jpeg', 'KIPRA-de5e0abe.jpeg', 'PEC2020-2458aea9.jpeg', '', '', 'no', 0, 0, '2021-08-24 01:08:58', '2024-08-19 08:07:01'),
(10504, 'Sardar Ghulam Mustafa ', 'sardarghulam_mustafa@yahoo.com', '0315-0848394', '13101-1267415-9', 'Sardar Ghulam Mustafa ', 'H#337, Haji Buland Khan, Near Railway Station Havelian, Abbottabad', 'Abbottabad ', '24657', 'PK-C-5', 'PK-C-5', '4001190-9', 'K4001190-9', NULL, 'no', 'CNIC-1ef2ae02.jpeg', NULL, 'FBR-09f13ddc.jpeg', 'KIPRA-6c90267c.jpeg', 'PEC2020-369d9c98.jpeg', '', 'PE-aed5c54c.jpeg', 'no', 0, 0, '2021-08-23 20:08:54', '2024-08-19 08:07:01'),
(10505, 'M/s Kashif Imran and sons general contracting', 'imrankashif953@gmail.com', '03439508889', '1420393863877', 'Kashif Imran', 'Warand ahmad abad Takht nasrati karak', 'Karak', '24408', 'PK-C-5', 'PK-C-5', '1420393863877', 'KA283718-2', NULL, 'no', 'CNIC-449a93bc.jpeg', NULL, 'FBR-15263d59.jpeg', 'KIPRA-ddbf9ce6.jpeg', 'PEC2020-351af399.jpeg', '', '', 'no', 0, 0, '2021-08-24 01:08:22', '2024-08-19 08:07:01'),
(10509, 'SK ENGINEERING', 'na@gmail.com', '0301-5525975', '15607-0347915-3', 'Shah Nawaz Khan	', 'FLAT NO 203 SABOOR ARCADE MPCHS E-1/3\r\n', 'Islamabad', '15492', 'PK-C-4', 'PK-C-4', '1560703479153', 'KA306571-4', NULL, 'no', 'CNIC-bc446185.jpeg', NULL, 'FBR-95aeb73a.jpeg', 'KIPRA-c6bf453b.jpeg', 'PEC2020-1ca372ac.jpeg', '', '', 'no', 0, 0, '2021-08-25 05:08:19', '2024-08-19 08:07:01'),
(10510, 'KASHIF IMRAN AND SONS GENERAL CONTRACTING', 'na@gmail.com', '0335-9295665', '14203-9386387-7', 'KASHIF IMRAN	', 'WARAND AHMAD ABAD TAKHT NASRATI\r\n', 'KARAK', '24408', 'PK-C-5', 'PK-C-5', '1420393863877', 'KA283718-2', NULL, 'no', 'CNIC-fc93a075.jpeg', NULL, 'FBR-7ba5b7fb.jpeg', 'KIPRA-e945d3ef.jpeg', 'PEC2020-d2a37f1a.jpeg', '', '', 'no', 0, 0, '2021-08-25 06:08:13', '2024-08-19 08:07:01'),
(10511, 'SHUJA UR REHMAN', 'shuj.rehman321@gmail.com', '0000-0001111', '15201-0604755-5', 'SHUJA UR REHMAN	', 'p.o. ayun darkhanandeh TEH. & DISTT.\r\n', 'CHITRAL', '14810', 'PK-C-4', 'PK-C-4', '1520106047555', 'K4029210-0', NULL, 'no', 'CNIC-c9b7b43b.jpeg', NULL, 'FBR-ce453fdd.jpeg', 'KIPRA-20d8bfe1.jpeg', 'PEC2020-44f315b0.jpeg', '', '', 'no', 0, 0, '2021-08-25 06:08:23', '2024-08-19 08:07:01'),
(10512, 'SKY LAND CONSTRUCTION COMPANY', 'skylandconstruction907@gmail.com', '0333-9073306', '15602-5258684-3', 'SHAHID KHAN', 'VILL. GULIBAGH DITT SWAT', 'SWAT', '24889', 'PK-C-5', 'PK-C-5', '5121608-5', '5121608-5', NULL, 'no', 'CNIC-9e6513b2.jpeg', NULL, 'FBR-85532a96.jpeg', 'KIPRA-b73b6661.jpeg', 'PEC2020-e71e6c49.jpeg', '', '', 'no', 0, 0, '2021-08-25 06:08:18', '2024-08-19 08:07:01'),
(10513, 'MUKARAM KHAN AND COMPANY', 'mkhanxmail@gmail.com', '0315-5860483', '17301-7955427-9', 'Mukaram Khan', 'INSAF TILES SHOP NO. 46-D JAN PALAZA JAMRUD ROAD KARKHANO MARKET PESHAWAR', 'Peshawar', '10564', 'PK-C-4', 'PK-C-4', '3931769-2', '3931769-2', NULL, 'no', 'CNIC-d2f9a332.jpeg', NULL, 'FBR-512d8b62.jpeg', 'KIPRA-85f732ae.jpeg', 'PEC2020-e2270ee3.jpeg', '', 'PE-aa8d3f24.jpeg', 'no', 0, 0, '2021-08-25 06:08:13', '2024-08-19 08:07:01'),
(10515, 'M/S Core Constructions ', 'Coreconstructions40@gmail.com', '03401661141 ', '13401-1512076-3', 'Mir Baz Khan', 'District Kohistan Tehsil Dassu P/O Komila Kohistan Guest House Basement ', 'Kohistan ', '24531', 'PK-C-5', 'PK-C-5', '1340115120763 ', '1340115120763 ', NULL, 'no', 'CNIC-5a6c46dd.jpeg', NULL, '', 'KIPRA-0d08ddb6.jpeg', 'PEC2020-c94dddf7.jpeg', '', '', 'no', 0, 0, '2021-08-25 07:08:25', '2024-08-19 08:07:01'),
(10518, 'NOWSHERWAN SWATI BUILDERS', 'na@gmail.com', '0333-8988066', '15502-2806573-7', 'NOWSHERWAN', 'KOZ BATKOT P.O SHAN TELL .BISHAM DISTT.SHANGLA ', 'SHANGLA', '7473', 'PK-C-3', 'PK-C-3', '507046-9', '507046-9', NULL, 'no', 'CNIC-06a5e5e8.jpeg', NULL, 'FBR-3ee5a31d.jpeg', 'KIPRA-736322eb.jpeg', 'PEC2020-44d5fb75.jpeg', '', 'PE-9911e0f7.jpeg', 'no', 0, 0, '2021-08-25 00:08:06', '2024-08-19 08:07:01'),
(10521, 'Hindukush Builders (Pvt) Ltd ', 'hindukushbuilders20@gmail.com', '03460141468', '15202-8478076-7', 'Raiz Ahmad', 'Mastuj Road Junali Koch, near GGDC Upper Chitral ', 'Chitral', '24916', 'PK-C-5', 'PK-C-5', '6708033', 'K6708033-0', NULL, 'no', 'CNIC-b8a4c20b.jpeg', NULL, 'FBR-319c9b09.jpeg', 'KIPRA-fbd0567b.jpeg', 'PEC2020-62d7d3eb.jpeg', 'Form-H-0b14944d.jpeg', 'PE-0c42dabc.jpeg', 'no', 0, 0, '2021-08-26 01:08:03', '2024-08-19 08:07:01'),
(10522, 'M/S  J K B ENGINEERS & CONSTRUCTORS ', 'jkbconstructors@gmail.com', '0333-9097799', '17201-3420933-5', 'AZRAR AHMAD KHAN', '86 ARMOUR HOUSING SOCIETY, MANKI ROAD NOWSHERA', 'NOWSHERA', '20746', 'PK-C-5', 'PK-C-5', '7188407', 'K7188407-8', NULL, 'no', 'CNIC-ff9f9ca3.jpeg', NULL, 'FBR-9bba303f.jpeg', 'KIPRA-7cfcae0e.jpeg', 'PEC2020-a4eeab80.jpeg', 'Form-H-ba5da75d.jpeg', 'PE-01a2b9bc.jpeg', 'no', 0, 0, '2021-08-26 03:08:21', '2024-08-19 08:07:01'),
(10525, 'SYED ASIM ALI BACHA', 'asimalibacha593@gmail.com', '0313-9428938', '16101-7638016-7', 'Syed Asim Ali Bacha', 'VILLAGE BAGH-E-IRAM, TEHSIL AND DISTRICT ', 'Mardan', '24664', 'PK-C-5', 'PK-C-5', '4018398-0', 'K4018398-0', NULL, 'no', 'CNIC-de16abaf.jpeg', NULL, '', 'KIPRA-afe42852.jpeg', 'PEC2020-26772500.jpeg', '', '', 'no', 0, 0, '2021-08-26 04:08:00', '2024-08-19 08:07:01'),
(10526, 'Aziz Khan & Sons ', 'azizkhansons@gmail.com', '0300-5620696', '13101-8774332-7', 'Malik Hanif ', 'House # 66, Street # 5, Iqbal Road Supply, Abbottabad ', 'Abbottabad ', '12832', 'PK-C-4', 'PK-C-4', '3553763-9', 'K3553763-9', NULL, 'no', 'CNIC-583ff934.jpeg', NULL, 'FBR-a0cd78fd.jpeg', 'KIPRA-4ac7bd5c.jpeg', 'PEC2020-5722417a.jpeg', '', '', 'no', 0, 0, '2021-08-26 07:08:59', '2024-08-19 08:07:01'),
(10529, 'M/S ECOTECH BUILDERS', 'rifaqatkhan317@gmail.com', '03469221348', '1730198548159', 'Rifaqat', 'F-28 4th floor spinzar IT tower university road peshawar', 'Peshawar', 'C5/24659', 'PK-C-5', 'PK-C-5', '6705773-8', 'K6705773-8', NULL, 'no', 'CNIC-b2e3e77a.jpeg', NULL, 'FBR-7d93e29b.jpeg', 'KIPRA-7fd8112d.jpeg', 'PEC2020-cbb35aa8.jpeg', '', 'PE-690ccf53.jpeg', 'no', 0, 0, '2021-08-27 05:08:07', '2024-08-19 08:07:01'),
(10532, 'SADDAT BUILDERS', 'sayedasadullah919@gmail.com', '0347-6052015', '15305-9683696-5', 'SYED ASAD ULLAH', 'LAL QALA P.O KUMBAR DISSTT\r\n; LOWER DIR', 'LOWER DIR', '24666', 'PK-C-5', 'PK-C-5', 'A3310751', 'KA3310751', NULL, 'no', 'CNIC-3b2c6f50.jpeg', NULL, 'FBR-9fe18e40.jpeg', 'KIPRA-d8ea4431.jpeg', 'PEC2020-ce41db5d.jpeg', '', '', 'no', 0, 0, '2021-08-29 05:08:20', '2024-08-19 08:07:01'),
(10534, 'smr construction company', 'karshid989@gmail.com', '0311-7799773', '17201-1634968-9', 'arshid ali', 'office no 4 thailand market main bazar rashakai', 'nowshera', '24848', 'PK-C-5', 'PK-C-5', '1720116349689', 'K3089281-3', NULL, 'no', 'CNIC-d330ab4a.jpeg', NULL, 'FBR-baff1ca5.jpeg', 'KIPRA-f3e4b9f7.jpeg', 'PEC2020-c039472e.jpeg', '', '', 'no', 0, 0, '2021-08-30 04:08:42', '2024-08-19 08:07:01');
INSERT INTO `contractor_registrations` (`id`, `contractor_name`, `email`, `mobile_number`, `cnic`, `district`, `address`, `pec_number`, `owner_name`, `category_applied`, `pec_category`, `fbr_ntn`, `kpra_reg_no`, `pre_enlistment`, `is_limited`, `cnic_front_attachment`, `cnic_back_attachment`, `fbr_attachment`, `kpra_attachment`, `pec_attachment`, `form_h_attachment`, `pre_enlistment_attachment`, `is_agreed`, `defer_status`, `approval_status`, `created_at`, `updated_at`) VALUES
(10535, 'MS JAN FAQIR BUILDERS', 'wajeehullah.83@gmail.com', '0333-8212891', '15702-1434666-1', 'JAN FAQIR ', 'mohallah ramin kass kalkot tehsil kalkot kohistan distt dir upper', 'DIR UPPER', '14908', 'PK-C-4', 'PK-C-4', '15702-1434666-1', 'K6714105-6', NULL, 'no', 'CNIC-3087f141.jpeg', NULL, 'FBR-4e3b9df7.png', 'KIPRA-806fd01d.png', 'PEC2020-c3f55b61.jpeg', '', 'PE-324e8632.jpeg', 'no', 0, 0, '2021-08-30 06:08:20', '2024-08-19 08:07:01'),
(10536, 'M/s kashif Latif constructors SMC Pvt limited', 'la755517@gmail.com', '03469394970', '1530209902717', 'Syed Latif Ahmad', 'Village &p/o Mian brangola dir lower', 'Dir lower', 'C3/5945', 'PK-C-3', 'PK-C-3', '1530209902717', 'K3603286-7', NULL, 'no', 'CNIC-de127160.jpeg', NULL, 'FBR-de6776ef.jpeg', 'KIPRA-803b9423.jpeg', 'PEC2020-7f0e0ba1.jpeg', '', 'PE-e73b8883.jpeg', 'no', 0, 0, '2021-08-30 06:08:05', '2024-08-19 08:07:01'),
(10538, 'M/s MODERNEDGE ENGINEERING & CONSTRUCTION', 'ms.modernedge@gmail.com', '0332-9193964', '21505-8565922-7', 'Intekhab Alam', 'P.O MIRALI HASSUKHEL, TEHSIL MIRALI, DISTRICT NORTH WAZIRISTAN', 'North Waziristan', '25121', 'PK-C-5', 'PK-C-5', '2150585659227', 'KA331707-3', NULL, 'no', 'CNIC-6339bebe.jpeg', NULL, 'FBR-411880e5.jpeg', 'KIPRA-c3e1cd5c.jpeg', 'PEC2020-696e22f8.jpeg', '', '', 'no', 0, 0, '2021-08-29 21:08:21', '2024-08-19 08:07:01'),
(10541, 'M/s Abbas Rehman', 'abbasrehman89@gmail.com', '0300-9026828', '13302-7981898-1', 'abbas rehman', 'House no 164 phase 1 Armour crop housing society manki road Nowshera', 'Nowshera', '15523', 'PK-C-4', 'PK-C-4', '3254939-3', 'K3254939-3', NULL, 'no', 'CNIC-7e2d27c4.jpeg', NULL, 'FBR-8a002f37.jpeg', 'KIPRA-52c63480.jpeg', 'PEC2020-32285fba.jpeg', '', 'PE-4998c292.jpeg', 'no', 0, 0, '2021-08-30 01:08:29', '2024-08-19 08:07:01'),
(10544, 'M/S UNITED BUILDERS & CONSTRUCTION COMPANY', 'ubcc07@gmail.com', '0310-9701347', '15402-5890512-3', 'Haseeb Ullah', 'PULL CHOWKI MOTERWAY INTERCHANG DISTT. Malakand', 'Malakand', '24576', 'PK-C-5', 'PK-C-5', 'A331027-7', 'A331027-7', NULL, 'no', 'CNIC-5e11a365.jpeg', NULL, 'FBR-c456345e.jpeg', 'KIPRA-653d9d25.jpeg', 'PEC2020-c7110fdc.jpeg', '', '', 'no', 0, 0, '2021-08-30 22:08:35', '2024-08-19 08:07:01'),
(10545, 'Concrete Construction ', 'Rahim3336@gmail.com', '03469568025', '13101-3043515-5', 'Rahim Dad ', 'New Muslim Hotel Near Ex-Sp office Kutchery Road Abbottabad ', 'Abbottabad ', '23657', 'PK-C-5', 'PK-C-6', '7140631-4', 'K7140631-4', NULL, 'no', 'CNIC-9200f4e7.jpeg', NULL, 'FBR-988b7c93.jpeg', 'KIPRA-e13e73de.jpeg', 'PEC2020-cb7250c8.jpeg', '', 'PE-a6f995a5.jpeg', 'no', 0, 0, '2021-08-31 01:08:00', '2024-08-19 08:07:01'),
(10546, 'REHMAN ENGINEER & CONSTRUCTORS', 'engrraztalib399@gmail.com', '0345-1920845', '15402-7378195-9', 'Raz Muhammad', 'TAHGAY KHWAR AGRA, TEH. BATKHILA DISTT. MALAKAND MALAKAND AGENCY', 'Malakand', '23182', 'PK-C-5', 'PK-C-5', '1540273781959', '1540273781959', NULL, 'no', 'CNIC-16740d01.jpeg', NULL, 'FBR-c88e8a05.png', 'KIPRA-3b7395f4.png', 'PEC2020-2a78a57a.png', '', '', 'no', 0, 0, '2021-08-31 03:08:41', '2024-08-19 08:07:01'),
(10550, 'M/S SAIF-UR-REHMAN KHAN & BROTHERS', 'srk9508420@gmail.com', '0345-9508420', '1120195644825', 'SAIF UR REHMAN KHAN', 'VILLAGE & P.O,TAJAZAI,WANDA WAZIR, LAKKI MARWAT', 'LAKKI MARWAT', '24852', 'PK-C-5', 'PK-C-5', '1120195644825', 'K4138823-2', NULL, 'no', 'CNIC-f481d286.jpeg', NULL, 'FBR-e6eabf9c.jpeg', 'KIPRA-06265c81.jpeg', 'PEC2020-931628a0.jpeg', '', '', 'no', 0, 0, '2021-08-31 05:08:44', '2024-08-19 08:07:01'),
(10551, 'Contractor', 'meer18629@gmail.com', '0345-9682712', '13302-0504799-7', 'Syed Safdar Rehman', 'Office at Moh: Choo, Village Gudwalian Distt: Haripur', 'Haripur', '24660', 'PK-C-5', 'PK-C-5', '1330205047997', 'K3282291-0', NULL, 'no', 'CNIC-6cf8641b.jpeg', NULL, 'FBR-fe007ebd.jpeg', 'KIPRA-8a8588a2.jpeg', 'PEC2020-501fc654.jpeg', '', '', 'no', 0, 0, '2021-08-31 07:08:32', '2024-08-19 08:07:01'),
(10552, 'M/s mati ullah shah', 'Matiullahshah38@gmail.com', '03339537090', '1410197219389', 'Mati ullah shah', 'Madrassa dar-al-olomia tall Distt hangu ', 'Hangu', '14843', 'PK-C-4', 'PK-C-4', '3045572-3', 'K3045572-3', NULL, 'no', 'CNIC-de9294c2.jpeg', NULL, 'FBR-8779d156.jpeg', 'KIPRA-0fe81491.jpeg', 'PEC2020-a176e030.jpeg', '', 'PE-62637fbf.jpeg', 'no', 0, 0, '2021-08-30 21:08:21', '2024-08-19 08:07:01'),
(10555, 'AKHTER HUSSAIN BALLAKOT BUILDERS', 'ah48737@gmail.com', '0334-1254789', '13501-8865614-7', 'AKHTAR HUSSAIN', 'HAMID & BILAL GENERAL STORE NEAR ARIBA CHILDREN ACADEMY', 'MANSEHRA', '14083', 'PK-C-4', 'PK-C-4', '4123981-4', '4123981-4', NULL, 'no', 'CNIC-6827fd81.jpeg', NULL, 'FBR-c0ad949f.jpeg', 'KIPRA-9bc7a312.jpeg', 'PEC2020-79a4123d.jpeg', '', 'PE-0cc38e6a.jpeg', 'no', 0, 0, '2021-08-31 01:08:53', '2024-08-19 08:07:01'),
(10556, 'SHAD MUHAMMAD & CO', 'zarar5114@gmail.com', '0344-5678321', '17301-15177145', 'SHAD MUHAMMAD', 'H#01, ST#01, SECTOR#E-3, PHASE#1, HAYATABAD', 'Peshawar', '24921', 'PK-C-5', 'PK-C-5', '17301-15177145', 'K51193596', NULL, 'no', 'CNIC-55f39958.jpeg', NULL, 'FBR-63787fb1.jpeg', 'KIPRA-0fbcb998.jpeg', 'PEC2020-75da7856.jpeg', '', 'PE-270c34ae.jpeg', 'no', 0, 0, '2021-08-31 01:08:35', '2024-08-19 08:07:01'),
(10557, 'Dost & co', 'Dostandc@yahoo.com', '0345-5020307', '17301-5615105-1', 'Arbab haji dost muhammad khan', 'Ghafoor electric house eid gha road faqir abad no 2 Peshwar ', 'Peshawar ', '3208', 'PK-C-2', 'PK-C-2', '1260079-2', 'K1260079-2', NULL, 'no', 'CNIC-130d6941.jpeg', NULL, 'FBR-2d59668f.jpeg', 'KIPRA-067e8efd.jpeg', 'PEC2020-1ed7f84c.jpeg', 'Form-H-a23fc8a6.jpeg', 'PE-deaa3797.jpeg', 'no', 0, 0, '2021-08-31 03:08:18', '2024-08-19 08:07:01'),
(10558, 'M/S YARO KHEL CONSTRUCTION', 'yarokhelconstruction@gmail.com', '345-6593736', '15501-6614209-3', 'Muazzam Ali', 'VILL. BARKANA P.O. SHAHPUR TEH. ALPURI DISTT. Shangla', 'Shangla', '24918', 'PK-C-5', 'PK-C-5', '8391913-7', 'K8391913-7', NULL, 'no', 'CNIC-730b96a0.jpeg', NULL, 'FBR-5b1d30c7.jpeg', 'KIPRA-10fb16c8.jpeg', 'PEC2020-a268a5c4.jpeg', '', 'PE-fbf42c18.jpeg', 'no', 0, 0, '2021-08-31 22:09:59', '2024-08-19 08:07:01'),
(10559, 'M/s Shamsher Ali Govt. Contractor', 'alishamsher74@gmail.com', '346-6346800', '15501-3195872-9', 'Shamsher Ali', 'Vill damorai tehsil alpurai distt Shangla', 'Shangla', '25133', 'PK-C-5', 'PK-C-5', '3247883-6', 'K3247883-6', NULL, 'no', 'CNIC-77a0adfc.jpeg', NULL, 'FBR-c3594178.jpeg', 'KIPRA-fb6d0ff1.jpeg', 'PEC2020-f2d92f8f.jpeg', '', 'PE-069a5f55.jpeg', 'no', 0, 0, '2021-08-31 22:09:42', '2024-08-19 08:07:01'),
(10560, 'M/S Amir Khel Construction Company ', 'shahabkhel111@gmail.com', '0334-1913722', '11201-8764672-5', 'Niamat Ullah Khan ', 'Amir Khel P/O Mela Shahab Khel, Tehsil and District Lakki Marwat ', 'Lakki Marwat ', 'C-4/15463', 'PK-C-4', 'PK-C-4', '1120187646725', 'KA292583-2', NULL, 'no', 'CNIC-23422366.jpeg', NULL, '', 'KIPRA-0d61dc71.jpeg', 'PEC2020-86fbcc68.jpeg', '', '', 'no', 0, 0, '2021-09-01 04:09:47', '2024-08-19 08:07:01'),
(10561, 'Takhtaband construction ', 'asad_pharmdd@yahoo.com', '0346-9469333', '15101-6828454-1', 'Syed Asad hussain shah', 'Takhtaband p/o swari tehsil gagra buner Khyber Pakhtunkhwa ', 'Buner', '13521', 'PK-C-4', 'PK-C-4', '7538996-2', '7538996', NULL, 'no', 'CNIC-91edeea9.jpeg', NULL, 'FBR-f0f89f51.jpeg', 'KIPRA-a74fe0dc.jpeg', 'PEC2020-9fa4bfbb.jpeg', '', 'PE-351930af.jpeg', 'no', 0, 0, '2021-09-01 04:09:12', '2024-08-19 08:07:01'),
(10562, 'M/s YOUNUS KHAN & CO', 'younas_khan19@gmail.com', '0333-2929686', '21403-1677462-3', 'Younas Khan', 'MAMO KOR ISSA KHEL P.O. & TEH: PANDAILY Distt: Mohmand', 'Mohmand', '16307', 'PK-C-5', 'PK-C-5', '4230109', 'K4230109-2', NULL, 'no', 'CNIC-bae9f8d2.jpeg', NULL, 'FBR-06a92ed4.jpeg', 'KIPRA-6a003417.jpeg', 'PEC2020-09f099e7.jpeg', '', '', 'no', 0, 0, '2021-09-01 06:09:56', '2024-08-19 08:07:01'),
(10572, 'M/s Haji Gul Saeed Khan & son', 'Kihtisham87@gmail.com', '40308288828', '1120103610595', 'AJMAL KHAN', '	VILL & P.O:BEHRAM KHEL, TEH & DISTT:', 'Lakki Marwat', '7528', 'PK-C-3', 'PK-C-3', '1120103610595', '7546340-2', NULL, 'no', 'CNIC-a63b8b2b.jpeg', NULL, 'FBR-2306b02d.jpeg', 'KIPRA-d4b3b5cd.jpeg', 'PEC2020-6d7c059e.jpeg', '', 'PE-5958cd2a.jpeg', 'no', 0, 0, '2021-09-01 06:09:18', '2024-08-19 08:07:01'),
(10573, 'M/s Tariq Mahmood Construction', 'tariqmahmoodconstruction@gmail.com', '0300938822', '3130366159533', 'Muhammad Arshad', 'Shop No. 26 Zayarat, Trade Center Islamabad', 'Islamabad', '76252', 'PK-C-6', 'PK-C-6', 'A272750', 'A272750-5', NULL, 'no', 'CNIC-716c1fd5.jpeg', NULL, 'FBR-6eef57de.jpeg', 'KIPRA-16e7ce9f.jpeg', 'PEC2020-5ddc391c.jpeg', '', '', 'no', 0, 0, '2021-09-02 07:09:29', '2024-08-19 08:07:01'),
(10574, 'MUHAMMAD IDRESS CONSTRUCTION CO', 'muhammadidresgovtcons@gmail.com', '0346-9304606', '15402-9362075-3', 'MUHAMMAD IDRESS', 'VILLAGE DHERI,ALLADAND BATKHELA, MALAKAND', 'MALAKAND', '25130', 'PK-C-5', 'PK-C-5', '82383827', 'K82383827', NULL, 'no', 'CNIC-604e9344.jpeg', NULL, 'FBR-714b31af.jpeg', 'KIPRA-521ee369.jpeg', 'PEC2020-9cb927a2.jpeg', '', '', 'no', 0, 0, '2021-09-02 02:09:23', '2024-08-19 08:07:01'),
(10575, 'TURI IRSHAD ALI & BROTHERS', 'arsahdalituri@gmail.com', '0300-9159169', '21302-9572431-9', 'IRSHAD ALI	', 'YASIR ALKURANIC ALIZAI KURRAM, KURRAM AGENCY', 'KURRAM AGENCY', '23068', 'PK-C-5', 'PK-C-5', '2130295724319', 'K6598175-5	', NULL, 'no', 'CNIC-9b594a20.jpeg', NULL, 'FBR-9aa41456.jpeg', 'KIPRA-16aa9ebd.jpeg', 'PEC2020-0c21010a.jpeg', '', '', 'no', 0, 0, '2021-09-02 02:09:06', '2024-08-19 08:07:01'),
(10577, 'M/S, Maaz Ullah Contractor', 'maazullah365@gmail.com', '0349-6052024', '15302-4590745-9', 'Maaz Ullah', 'Office No. 04 First Floor Sadiq Chamber Sitara Market Sector G-7 Markaz Islamabad Urban Islamabad', 'Dir Lower', '21194', 'PK-C-6', 'PK-C-6', '1530245907459', 'K6628472-8', NULL, 'no', 'CNIC-7f5437ad.jpeg', NULL, 'FBR-d377ca0d.jpeg', 'KIPRA-d0769a57.jpeg', 'PEC2020-7fcbb9f8.jpeg', '', '', 'no', 0, 0, '2021-09-02 02:09:33', '2024-08-19 08:07:01'),
(10578, 'M/s Baist Khan', 'na@gmail.com', '0331-9172139', '11201-7664256-9', 'Baist Khan', 'Village & PO tajazai Tehsil & Distt Laki Marwat', 'Lakki Marwat', '15273', 'PK-C-4', 'PK-C-4', '1350778', 'K1350778-8', NULL, 'no', 'CNIC-895cfde1.jpeg', NULL, 'FBR-bf608494.jpeg', 'KIPRA-26dc76c0.jpeg', 'PEC2020-c6007a31.jpeg', '', 'PE-0ce34de0.jpeg', 'no', 0, 0, '2021-09-02 04:09:33', '2024-08-19 08:07:01'),
(10580, 'NEW SURANI CONST CO', 'rrizwanullahsurani@gmail.com', '0333-9726573', '54401-2789910-7', 'WAJAHAT RASOOL', 'MADINA MARKET MOHALLA QADIR ABAD NEAR RAILWAY ROAD NATIONAL BANK, BANU', 'BANU', '7516', 'PK-C-3', 'PK-C-3', 'A3344444', 'KA3344444', NULL, 'no', 'CNIC-77380656.jpeg', NULL, 'FBR-458a064d.jpeg', 'KIPRA-61da789b.jpeg', 'PEC2020-9f456796.jpeg', 'Form-H-717c6f5c.jpeg', '', 'no', 0, 0, '2021-09-02 06:09:02', '2024-08-19 08:07:01'),
(10581, 'M/s Rahim Khan (Mardan)', 'na@gmail.com', '346-3005107', '16101-1193830-3', 'Rahim Khan ', 'Bagi khel Pipal Tehsil & District Mardan', 'Mardan', '24917', 'PK-C-5', 'PK-C-5', '3280559-4', 'K3280559-4', NULL, 'no', 'CNIC-7d7de740.jpeg', NULL, 'FBR-34401ba1.jpeg', 'KIPRA-c5f608c6.jpeg', 'PEC2020-20d7b2c3.jpeg', '', 'PE-59194800.jpeg', 'no', 0, 0, '2021-09-02 06:09:43', '2024-08-19 08:07:01'),
(10584, 'M/s Shafiq jan& brother', 'Shafiqjan350@gmail.com', '03151208258', '1710148331553', 'Shafiq jan', 'Rahman plaza 2nd floor mardan road charsadda', 'Charsadda', 'C-5 24888', 'PK-C-5', 'PK-C-5', '3750608-7', 'K3750608-7', NULL, 'no', 'CNIC-c3150210.jpeg', NULL, 'FBR-84419916.jpeg', 'KIPRA-5c95516c.jpeg', 'PEC2020-cd819f2b.jpeg', '', '', 'no', 0, 0, '2021-09-02 00:09:59', '2024-08-19 08:07:01'),
(10586, 'SAJJAD UL HAQ', 'ahmadikaz280@gmail.com', '0312-9165798', '17301-1045331-1', 'SAJJAD UL HAQ	', 'asif and shinwari market sarafa bazar\r\n', 'Peshawar', '24317', 'PK-C-5', 'PK-C-5', '17301-1045331-1', 'K3771259-4', NULL, 'no', 'CNIC-da3b9b60.jpeg', NULL, 'FBR-066d843b.jpeg', 'KIPRA-e9b1d668.jpeg', 'PEC2020-8718ed7c.jpeg', '', '', 'no', 0, 0, '2021-09-03 06:09:51', '2024-08-19 08:07:01'),
(10587, 'M/S jamshaid & sons construction', 'jamshedkhanswabi5500@gmail.com', '0301-5978248', '16202-0733008-9', 'Jamshaid', 'Moh Torkhel Teh & DIstt swabi', 'swabi', '24890', 'PK-C-5', 'PK-C-5', '7525096', '	K7525096-7', NULL, 'no', 'CNIC-2cf13179.jpeg', NULL, 'FBR-9b095058.jpeg', 'KIPRA-d3b3c350.jpeg', 'PEC2020-7e6221aa.jpeg', '', 'PE-26b6a604.jpeg', 'no', 0, 0, '2021-09-04 00:09:12', '2024-08-19 08:07:01'),
(10588, 'GRAVITY GUMPTION WORKS (SMC-PRIVATE) LIMITED', 'abbassi333@gmail.com', '0334-5885588', '13302-2002561-3', 'Sajid Ali', 'Off # 4 Chodhry Iftekhar Plaza Civil Courts G.T Road Haripur', 'Haripur', '24411', 'PK-C-5', 'PK-C-5', '4564387', '4564387-1', NULL, 'no', 'CNIC-c7696ca2.jpeg', NULL, 'FBR-804ec603.jpeg', 'KIPRA-a4d2575a.png', 'PEC2020-888919f9.jpeg', '', '', 'no', 0, 0, '2021-09-04 00:09:10', '2024-08-19 08:07:01'),
(10589, 'AJMAL KHAN MARWAT', 'na@gmail.com', '0345-2165789', '11201-0350320-1', 'AJMAL KHAN ', 'VILL & P.O TAJAZAI TEH & DISTT.\r\n', 'LAKKI MARWAT', '15524', 'PK-C-4', 'PK-C-4', '1120103503201', 'K3172995-9', NULL, 'no', 'CNIC-de2c9384.jpeg', NULL, 'FBR-8dc01fa9.jpeg', 'KIPRA-384f1e20.jpeg', 'PEC2020-4d48a8ff.jpeg', '', 'PE-b88da70e.jpeg', 'no', 0, 0, '2021-09-04 03:09:06', '2024-08-19 08:07:01'),
(10592, 'Naikzada Dawar & Company Government Contractor', 'Nekzada111@gmail.com', '03339293175', '21505-8328202-9', 'Naikzada', 'Waziristan', 'North Waziristan', '24920', 'PK-C-5', 'PK-C-5', '8194487-5', 'K8194487-5', NULL, 'no', 'CNIC-2d7649b0.jpeg', NULL, 'FBR-2d90a81c.jpeg', 'KIPRA-3632e6e7.jpeg', 'PEC2020-a676a926.jpeg', '', '', 'no', 0, 0, '2021-09-04 20:09:34', '2024-08-19 08:07:01'),
(10593, 'Mardan Civil Solution', 'Mcivilsoultionkp@gmail.com', '03149696859', '16101-6327111-3', 'Hazrat Bilal', 'Mardan', 'Mardan', '25430', 'PK-C-5', 'PK-C-5', '5028983-8', 'K5028983-8', NULL, 'no', 'CNIC-6f58cf62.jpeg', NULL, 'FBR-ccaab0ff.jpeg', 'KIPRA-6e7a90b4.jpeg', 'PEC2020-15205767.jpeg', '', '', 'no', 0, 0, '2021-09-04 20:09:47', '2024-08-19 08:07:01'),
(10594, 'Muzaffar Khan Associates', 'engr.abdullah22@gmail.com', '03005778139', '17201-1970221-5', 'Muzaffar khan', 'Nowshera', 'Nowshera', '25129', 'PK-C-5', 'PK-C-5', '1517952-4', 'K1517952-4', NULL, 'no', 'CNIC-b7b57706.jpeg', NULL, 'FBR-f8e2b62f.jpeg', 'KIPRA-02c31bf0.jpeg', 'PEC2020-b4aafd57.jpeg', '', '', 'no', 0, 0, '2021-09-04 21:09:28', '2024-08-19 08:07:01'),
(10596, 'Worker Engineering & Construction', 'uhanif208@gmail.com', '0332-9205932', '13202-3660855-1', 'Sher Khan', 'H # 126, St # 05, G-15/1, Islamabad.', 'Battagram', 'C37508', 'PK-C-3', 'PK-C-3', '7459297', 'K7459297-7', NULL, 'no', 'CNIC-fb177d60.jpeg', NULL, '', 'KIPRA-d85670aa.jpeg', 'PEC2020-23ed2bef.jpeg', 'Form-H-de9d2881.jpeg', 'PE-a2cb72ca.jpeg', 'no', 0, 0, '2021-09-04 21:09:15', '2024-08-19 08:07:01'),
(10598, '7517', 'maliktaimursalih353@gmail.com', '03323033555', '1570136611919', 'Malik Taimur Salih', 'SHERINGAL CONSTRUCTION COMPANY, TEHSIL SHERINGAL P/O SHERINGAL DISTRICT DIR UPPER ', 'Upper dir', '7517', 'PK-C-3', 'PK-C-3', '6604030-1', 'K6604030-1', NULL, 'no', 'CNIC-a29bd303.jpeg', NULL, 'FBR-84b0f8d1.jpeg', 'KIPRA-14696fa4.jpeg', 'PEC2020-c4e93dde.jpeg', '', '', 'no', 0, 0, '2021-09-05 02:09:56', '2024-08-19 08:07:01'),
(10599, 'RUFAN CONSTRUCTION & CO', 'rufanconstruction5584@gmail.com', '0316-6765584', '11101-5860799-7', 'MUHAMMAD ISLAM SHAH	', 'VILL. SAHIB KHAN TUGHAL KHEL P.O. SAID TUGHAL KHEL DISTT.\r\n', 'BANNU', '15464', 'PK-C-4', 'PK-C-4', '1110158607997', 'KA313431-6', NULL, 'no', 'CNIC-2aabaad7.jpeg', NULL, 'FBR-43659dd5.jpeg', 'KIPRA-e963fe6b.jpeg', 'PEC2020-70691f88.jpeg', '', '', 'no', 0, 0, '2021-09-06 00:09:53', '2024-08-19 08:07:01'),
(10600, 'ASFANDYAR PERVEZ&CO', 'Mi580891@gmail.com', '03459091139', '1710102436061', 'ASFANDYAR PERVEZ', 'MOH BEHLOL KHEL CHARSADDA', 'CHARSADDA', '24914', 'PK-C-5', 'PK-C-5', '37518247', 'K37518247', NULL, 'no', 'CNIC-11f01e1a.jpeg', NULL, 'FBR-f6c3c300.jpeg', 'KIPRA-cb5722cb.jpeg', 'PEC2020-a7995940.jpeg', '', '', 'no', 0, 0, '2021-09-06 01:09:44', '2024-08-19 08:07:01'),
(10601, 'M/S NEW BARAWAL CONSTRUCTION COMPANY', 'mumtazmuhammad4635@gmail.com', '0346-9899504', '15701-1178255-7', 'MUMTAZ MUHAMMAD', 'VILL. SHAHIKOT BARAWAL, DISTT DIR UPPER', 'DIR UPPER', '19978', 'PK-C-5', 'PK-C-5', '15701-1178255-7', 'K6104458-1', NULL, 'no', 'CNIC-63d5d320.jpeg', NULL, 'FBR-4478fd51.jpeg', 'KIPRA-688790c6.jpeg', 'PEC2020-299fb34c.jpeg', '', 'PE-c5cd2b54.jpeg', 'no', 0, 0, '2021-09-06 01:09:55', '2024-08-19 08:07:01'),
(10602, 'DILAWAR KHAN D.K.G', 'NA@GMAIL.COM', '0996-7487450', '21104-4632359-3', 'DILAWAR KHAN ', 'Abbotabad', 'ABBOTTABAD', '7504', 'PK-C-3', 'PK-C-3', '21104-4632359-3', '40831965', NULL, 'no', 'CNIC-ef0fe9e2.jpeg', NULL, 'FBR-cd6bc7d3.jpeg', 'KIPRA-dc72d372.jpeg', 'PEC2020-d5d1a099.jpeg', '', '', 'no', 0, 0, '2021-09-06 04:09:35', '2024-08-19 08:07:01'),
(10604, 'JAMAL ORAKZAI CONSTRUCTION ', 'Jamalorakzaiconstruction@gmail.com', '0333-9672146', '14101-6599702-7', 'JAMAL ZAREEN', 'VILLAGE SIFAT BANDA, TEH & DISTT. HANGU ', 'ORAKZAI', '13871', 'PK-C-4', 'PK-C-4', '4178131-7', 'K4178131-7', NULL, 'no', 'CNIC-d194c799.jpeg', NULL, 'FBR-82c5fb7c.jpeg', 'KIPRA-3084407b.jpeg', 'PEC2020-4e8b9d16.jpeg', '', 'PE-5acaf23f.jpeg', 'no', 0, 0, '2021-09-06 21:09:53', '2024-08-19 08:07:01'),
(10605, 'Hazrat Hussain & Company', 'irfan.kh102@gmail.com', '03335481857', '17201-2110570-5', 'Hazrat Hussain', 'Faizan Medicose 2nd floor main Bazar rashaki Nowshera', 'Nowshera', '25136', 'PK-C-5', 'PK-C-5', '1720121105705', 'K7457704-7', NULL, 'no', 'CNIC-3a792542.jpeg', NULL, 'FBR-1e892010.jpeg', 'KIPRA-1d8930cb.jpeg', 'PEC2020-c9cc7f02.jpeg', '', 'PE-775e6499.jpeg', 'no', 0, 0, '2021-09-06 22:09:35', '2024-08-19 08:07:01'),
(10606, 'M/s Fida Muhammad constructor (FMC)', 'fidaconstructioncompany@gamil.com', '0311-1821251', '17101-2949211-1', 'Fida Muhammad', 'Moh: quaidabad distt chardadda', 'Charsadda', '25444', 'PK-C-5', 'PK-C-5', '7531088-5', 'K7531088-5', NULL, 'no', 'CNIC-40f26527.jpeg', NULL, 'FBR-ceddd7d3.jpeg', 'KIPRA-6dcb1fa5.jpeg', 'PEC2020-d6d2ccc1.jpeg', '', 'PE-cd892c56.jpeg', 'no', 0, 0, '2021-09-06 23:09:36', '2024-08-19 08:07:01'),
(10607, 'M/s Sanat Khan', 'sanatkhan567@gmail.com', '0300-5778290', '17201-2146378-1', 'Sanat Khan', 'Mohallah Miskeen abad Pir sabaq Nowshera', 'Nowshera', '15631', 'PK-C-4', 'PK-C-4', '3901145-3', 'K3901145-3', NULL, 'no', 'CNIC-a6d75462.jpeg', NULL, 'FBR-47da2bd8.jpeg', 'KIPRA-9afdb94d.jpeg', 'PEC2020-2f1dfe82.jpeg', '', 'PE-553c7abe.jpeg', 'no', 0, 0, '2021-09-06 23:09:58', '2024-08-19 08:07:01'),
(10608, 'SYED JAMSHED ALI & SONS', 'jamshadali1956@yahoo.com', '0346-9307131', '1560224709933', 'SYED GOHAR ALI	', 'MOHALLAH SHAHI BAGH NEAR DIG OFFICE BABA GENERAL STORE SHAHIBAGH SAIDU SHARIF\r\n', 'SWAT', '6331', 'PK-C-5', 'PK-C-5', '1560224709933', 'K5147549-8', NULL, 'no', 'CNIC-63244486.jpeg', NULL, 'FBR-28ddf474.jpeg', 'KIPRA-a310d77f.jpeg', 'PEC2020-3d7fb166.jpeg', 'Form-H-80c46000.jpeg', '', 'no', 0, 0, '2021-09-07 00:09:54', '2024-08-19 08:07:01'),
(10609, 'BIN MAIRAJ ENGINEERING SERVICES', 'anhidtehseen@gmail.com', '0334-9167814', '1730153097009', 'TEHSEEN WAHID	', 'P.O. THANA THANA JADEED MALAKAND\r\n', 'BATKHELA', '7011', 'PK-C-3', 'PK-C-3', '1730153097009', 'K3890038-6', NULL, 'no', 'CNIC-5c419d82.jpeg', NULL, 'FBR-aa27c637.jpeg', 'KIPRA-5b9971e0.jpeg', 'PEC2020-ff1aae93.jpeg', '', '', 'no', 0, 0, '2021-09-07 00:09:57', '2024-08-19 08:07:01'),
(10611, 'M/s Abdul Wadud & Brothers', 'engrmurad1988@gmail.com', '0345-9479188', '13401-1505361-7', 'Abdul Wadood Khan', 'Dassu P/o Komela Tehsil Kandia District Kohistan.', 'Kohistan', 'C4/12835', 'PK-C-4', 'PK-C-4', '13401-1505361-7', 'k4043907-7', NULL, 'no', 'CNIC-fc8f130c.jpeg', NULL, 'FBR-19ddd8b9.jpeg', 'KIPRA-d90fbbe0.jpeg', 'PEC2020-d6cba099.jpeg', '', 'PE-dfbcb189.jpeg', 'no', 0, 0, '2021-09-07 03:09:07', '2024-08-19 08:07:01'),
(10612, 'M/s Malik Painda Khel Construction Co', 'sherahmad.dir@gmail.com', '0341-2242555', '15702-7766086-7', 'Malik Bakht Sher Khan', 'Vill Kashmiray PO Wari Distt Dir Upper', 'Dir Upper', '7518', 'PK-C-3', 'PK-C-3', '5209062-6', 'K5209062-6', NULL, 'no', 'CNIC-524dc24f.jpeg', NULL, 'FBR-ffe9823b.jpeg', 'KIPRA-cd42ea0f.jpeg', 'PEC2020-e21360e3.jpeg', '', 'PE-2eacdb1e.jpeg', 'no', 0, 0, '2021-09-07 04:09:59', '2024-08-19 08:07:01'),
(10613, 'HK Enterprises', 'Wddkhan5@Gmail.com', '03329375486', '1730171333343', 'Hood khan', 'Warsak road behari colony opposite new defence colony gate Shop No#2 Peshawar', 'Peshawar', '24662', 'PK-C-5', 'PK-C-5', '4342845-2', 'K4342845-2', NULL, 'no', 'CNIC-0d945b0a.jpeg', NULL, 'FBR-2d02a495.jpeg', 'KIPRA-20617468.jpeg', 'PEC2020-abef5aff.jpeg', '', 'PE-b3ec7527.jpeg', 'no', 0, 0, '2021-09-07 04:09:35', '2024-08-19 08:07:01'),
(10615, 'MS iftikhar wadood builders', 'engr.iftikhar566@gmail.com', '03404442804', '1560244352667', 'Iftikhar wadood', 'Mohallah zamarod kan near shinwari masjid mingora swat', 'Swat', 'Civil/50362', 'PK-C-5', 'PK-C-5', '1560244354667', '1560244354667', NULL, 'no', 'CNIC-260410f3.jpeg', NULL, 'FBR-627965e0.jpeg', 'KIPRA-79e303a2.jpeg', 'PEC2020-e0ed4972.jpeg', '', '', 'no', 0, 0, '2021-09-07 05:09:57', '2024-08-19 08:07:01'),
(10616, 'Rosh nain associates', 'waheed2021@gmail.com', '03129820421', '1310105668441', 'Abdul waheed', 'village and po malsa tehsil and district abbottabad', 'Abbottabad', '22157', 'PK-C-5', 'PK-C-5', '2813842-2', 'K2813842-2', NULL, 'no', 'CNIC-433dad7e.jpeg', NULL, 'FBR-6a58c803.jpeg', 'KIPRA-93676ba2.jpeg', 'PEC2020-1fd9bdb3.jpeg', '', 'PE-2637fbe8.jpeg', 'no', 0, 0, '2021-09-07 05:09:54', '2024-08-19 08:07:01'),
(10617, 'FAZAL AKBAR & CO. KOHISTAN', 'fna@gmail.com', '0346-9564466', '13403-0155418-9', 'FAZAL AKBAR	', 'VILL. GAMEER TEH. PATTAN DISTT.KOHISTAN', 'KOHISTAN', '24923', 'PK-C-5', 'PK-C-5', '1340301554189', 'K4093801-8', NULL, 'no', 'CNIC-d21aa1a5.jpeg', NULL, 'FBR-e0967672.jpeg', 'KIPRA-a41accff.jpeg', 'PEC2020-0138e5ee.jpeg', '', '', 'no', 0, 0, '2021-09-07 05:09:37', '2024-08-19 08:07:01'),
(10618, 'RAFI ULLAH & BROTHERS', 'KASHIFKTK625@GMAIL.COM', '0335-1570311', '14202-9172848-3', 'RAFI ULLAH', 'VILLAGE. MITHA WALA P.O TEH & DISSTT KARAK', 'KARAK', '7552', 'PK-C-3', 'PK-C-3', '33321540', 'K33321540', NULL, 'no', 'CNIC-7682d685.jpeg', NULL, 'FBR-152d16a5.jpeg', 'KIPRA-bde815c4.jpeg', 'PEC2020-3f7ba9ca.jpeg', '', '', 'no', 0, 0, '2021-09-07 05:09:36', '2024-08-19 08:07:01'),
(10619, 'Ali traders mingora ', 'rizwansawat@gmail.com', '03430921029 ', '15602.0457010.1', 'Rizwan ali', 'Ali traders malak brothers market nishat chowk mingora swat ', 'Swat', '24922', 'PK-C-5', 'PK-C-5', '4345762-2', 'K4345762-2', NULL, 'no', 'CNIC-3b57a8db.jpeg', NULL, 'FBR-f9734e26.jpeg', 'KIPRA-d2f75262.jpeg', 'PEC2020-9c21b7ff.jpeg', '', '', 'no', 0, 0, '2021-09-07 06:09:22', '2024-08-19 08:07:01'),
(10620, 'Ali traders mingora', 'rizwansawat@gmail.com', '03430921029 ', '15602.0457010.1', 'Rizwan ali', 'Ali traders malak brothers market nishat chowk mingora swat ', 'Swat', '24922', 'PK-C-5', 'PK-C-5', '4345762-2', 'K4345762-2', NULL, 'no', 'CNIC-992e7b79.jpeg', NULL, 'FBR-1cedd1f9.jpeg', 'KIPRA-bfa30927.jpeg', 'PEC2020-aac95523.jpeg', '', '', 'no', 0, 0, '2021-09-07 06:09:33', '2024-08-19 08:07:01'),
(10621, 'International developer construction company', 'Irfanmehsood786@gmail.com', '0345-8762789', '21704-5014301-3', 'Irfan ullah', 'Abdullah town bahra kaho islamanad', 'SWTD', '2542', 'PK-C-2', 'PK-C-2', '6464919', '6464919', NULL, 'no', 'CNIC-1bb82404.jpeg', NULL, 'FBR-d66713e1.jpeg', 'KIPRA-e3d6a97e.jpeg', 'PEC2020-5a404630.jpeg', '', 'PE-d53940ac.jpeg', 'no', 0, 0, '2021-09-07 06:09:07', '2024-08-19 08:07:01'),
(10622, 'Ali traders mingora ', 'rizwansawat@gmail.com', '0343-0921029', '15602-0457010-1', 'Rizwan ali ', 'ali traders malak brothers market nishat chowk mingora swa', 'swat                                    ', '24922', 'PK-C-5', 'PK-C-5', '43465762-2', 'k-4345762-2', NULL, 'no', 'CNIC-110dfd75.jpeg', NULL, 'FBR-9237788a.jpeg', 'KIPRA-a11512af.jpeg', 'PEC2020-82ef7d2d.jpeg', '', 'PE-b285f561.jpeg', 'no', 0, 0, '2021-09-07 06:09:25', '2024-08-19 08:07:01'),
(10623, 'Shahzad Government Contractor ', 'shahzadashrafabbottabad@gmail.com', '0311-0592095', '13101-9624141-9', 'Shahzad ', 'House No 265, Mohallah Kunj Qadeem, Tehsil & District Abbottabad ', 'Abbottabad', '75317', 'PK-C-6', 'PK-C-6', '8380151-8', 'K8380151-8', NULL, 'no', 'CNIC-739318d4.jpeg', NULL, 'FBR-b35d33c5.jpeg', 'KIPRA-4c2501d9.jpeg', 'PEC2020-ece93136.jpeg', '', '', 'no', 0, 0, '2021-09-07 06:09:47', '2024-08-19 08:07:01'),
(10624, 'M/s Jagg & Co', 'msjaggandko@gmail.com', '0345-9188576', '13403-7796560-1', 'Mohib Yazdan', 'Vill & PO Jagg Duber PO runlla Tehsil Pattan Kohistan', 'Kohistan', '15680', 'PK-C-4', 'PK-C-4', '7879764', 'K5070740', NULL, 'no', 'CNIC-b85860d2.jpeg', NULL, 'FBR-08c52118.jpeg', 'KIPRA-bb0880d8.jpeg', 'PEC2020-8b535766.jpeg', '', 'PE-a0b4be75.jpeg', 'no', 0, 0, '2021-09-07 07:09:44', '2024-08-19 08:07:01'),
(10625, 'M/s Alam Geer Khan Shamat Khail', 'alamgir_shamatkhel@gmail.com', '0343-2455966', '13401-1501798-5', 'Alamgir', 'NEAR CONTENTAL HOTEL P.O.DASSU DISTT: kohistan', 'Kohistan', '24655', 'PK-C-5', 'PK-C-5', '3954609-8', 'K3954609-8', NULL, 'no', 'CNIC-2fb8b4e3.jpeg', NULL, 'FBR-28b001c7.jpeg', 'KIPRA-565feca5.jpeg', 'PEC2020-dd8365fd.jpeg', '', 'PE-60aedcbb.jpeg', 'no', 0, 0, '2021-09-07 07:09:22', '2024-08-19 08:07:01'),
(10626, 'M/S IJAZ AHMAD KHAN', 'ijazahmadkhanij@gmail.com', '0300-9350790', '13202-0736855-5', 'IJAZ AHMAD KHAN', 'OFFICE NO. 4-C, 1ST FLOOR, MEHMOOD PLAZA FAZAL E HAQ ROAD BLUE AREA ISLAMABAD.', 'MANSEHRA', '15549', 'PK-C-4', 'PK-C-4', '2672695-5', 'K2672695-5', NULL, 'no', 'CNIC-670dcc56.jpeg', NULL, 'FBR-7f0cfe77.jpeg', 'KIPRA-519ed485.jpeg', 'PEC2020-98e9c178.jpeg', '', '', 'no', 0, 0, '2021-09-06 20:09:00', '2024-08-19 08:07:01'),
(10627, 'malik panda khel construction co', 'na@gamil', '09445678245', '1570277660867', 'malik bakht sher khan', 'dir', 'Dir Upper', '7518', 'PK-C-3', 'PK-C-3', '1570277660867', '52090626', NULL, 'no', 'CNIC-a9861e1a.jpeg', NULL, 'FBR-c90870b0.jpeg', 'KIPRA-6970c5f1.jpeg', 'PEC2020-2571e5a6.jpeg', '', '', 'no', 0, 0, '2021-09-06 22:09:38', '2024-08-19 08:07:01'),
(10628, 'Shoaib Ahmad Bettani', 'Shoaibamd007@gmail.com', '03330767675', '12201-3493773-3', 'Shoaib Ahmad', 'DI Khan', 'DI khan', '25097', 'PK-C-5', 'PK-C-5', '5039825-5', 'K5039825-5', NULL, 'no', 'CNIC-51413b51.jpeg', NULL, 'FBR-9a760089.jpeg', 'KIPRA-d60c1d71.jpeg', 'PEC2020-631f9eb7.jpeg', '', '', 'no', 0, 0, '2021-09-07 21:09:02', '2024-08-19 08:07:01'),
(10630, 'M/S NEW BARAWAL CONSTRUCTION COMPANY', 'shop.foryou@yahoo.com', '0300-5955504', '15701-1178255-7', 'MUMTAZ MUHAMMAD', 'VILL SHAHIKOT BARAWAL DISTT DIR UPPER', 'Dir Upper', '19978', 'PK-C-5', 'PK-C-5', '15701-1178255-7', 'K6104458-1', NULL, 'no', 'CNIC-a4617af7.jpeg', NULL, 'FBR-126bd071.jpeg', 'KIPRA-34ede098.jpeg', 'PEC2020-aa1b9371.jpeg', '', 'PE-434f5dd1.jpeg', 'no', 0, 0, '2021-09-08 04:09:24', '2024-08-19 08:07:01'),
(10631, 'Jehan Zeb bajaury', 'Jehanzeb4054@gmail.com', '03085994054', '2110310329019', 'Jehab zeb', 'Tehsil khar ziallah bajaur ', 'Bajaur', '25044', 'PK-C-5', 'PK-C-5', '73849972', '73849972', NULL, 'no', 'CNIC-5c4eab40.jpeg', NULL, 'FBR-4dd33df5.jpeg', 'KIPRA-c2aed6b6.jpeg', 'PEC2020-d64a2b3b.jpeg', 'Form-H-9c2c7448.jpeg', 'PE-6898e130.jpeg', 'no', 0, 0, '2021-09-08 05:09:01', '2024-08-19 08:07:01'),
(10632, 'Mohammad Iqbal Khan Mian Khel & Sons', 'mamooniqbal123@gmail.com', '0343 9900180', '12101-9856543-7', 'Muhammad Mamoon Iqbal', 'H#1 Miankhel House, Near Police Line Dera Ismail Khan', 'Dera Ismail Khan', '7498', 'PK-C-3', 'PK-C-3', '6570634', 'K-6570634-4', NULL, 'no', 'CNIC-0567f336.jpeg', NULL, 'FBR-b7f315cf.jpeg', 'KIPRA-b69e96ec.jpeg', 'PEC2020-a4c0d7b2.jpeg', 'Form-H-70cd7f7e.jpeg', 'PE-cb6f8f4c.jpeg', 'no', 0, 0, '2021-09-08 07:09:24', '2024-08-19 08:07:01'),
(10635, 'TELCON ENGINEERING (PVT)LTD', 'shahzad.shaukat@telcon.com.pk', '03134574118', '35202-4316957-1', 'Naveed Akhtar ', '412 TOPAZ BLOCK MASJID AL-GHAFAAR PARK VIEW VILLAS MULTAN ROAD LAHORE ', 'Lahore ', '1584', 'PK-C-1', 'PK-C-1', '2248253', 'K2248253-9', NULL, 'no', 'CNIC-39226197.jpeg', NULL, 'FBR-167b6b8b.jpeg', 'KIPRA-a080bcfd.jpeg', 'PEC2020-d9697344.jpeg', 'Form-H-87d24a00.jpeg', '', 'no', 0, 0, '2021-09-08 00:09:15', '2024-08-19 08:07:01'),
(10636, 'Amjad Ali Khan & Co', 'peshawar1982@yahoo.com', '0343-3199933', '17301-1392483-9', 'Amjad Ali', 'Village Yari Koronona P.O Mathra Warsak Road Peshawar', 'Amjid Ali ', '24119', 'PK-C-5', 'PK-C-5', '3398543-0', '3398543-0', NULL, 'no', 'CNIC-148402d2.jpeg', NULL, 'FBR-ab21f66a.jpeg', 'KIPRA-8bc52107.jpeg', 'PEC2020-cb2a0cb5.jpeg', '', '', 'no', 0, 0, '2021-09-09 00:09:46', '2024-08-19 08:07:01'),
(10637, 'Nazir  Renewable & Construction services', 'nazirmuhammad64@gmail.com', '0333-9988467', '21201-1456881-1', 'Nazir Muhammad', 'Bar Qamber khel pakka tara bara khyber agency', 'KHYBER AGENCY', '11', 'PK-C-5', 'PK-C-5', '6759149-5', '6759149-5', NULL, 'no', 'CNIC-3febfcaf.jpeg', NULL, 'FBR-96426d10.jpeg', 'KIPRA-5cd4402d.jpeg', 'PEC2020-5c709774.jpeg', 'Form-H-fd63908b.jpeg', '', 'no', 0, 0, '2021-09-09 00:09:09', '2024-08-19 08:07:01'),
(10638, 'ANWAR KHAN & SONS (AKS)', 'na@gmail.com', '0333-4144581', '21403-3761630-9', 'ANWAR KHAN	', 'P.O PANDYALI P.O YAKA GHUND MOHMAND\r\n', 'MOHMAND AGENCY', '7601', 'PK-C-3', 'PK-C-3', '2140337616309', 'K2624323-7	', NULL, 'no', 'CNIC-c377fea7.jpeg', NULL, 'FBR-574692f9.jpeg', 'KIPRA-792cfa92.jpeg', 'PEC2020-ca093511.jpeg', '', 'PE-d4a73111.jpeg', 'no', 0, 0, '2021-09-09 02:09:50', '2024-08-19 08:07:01'),
(10639, 'MALIK CONTRACTORS & BUILDERS', 'malik09587891@gmail.com', '0333-3333222', '1710211548895', 'MURAD ALI	', 'TANGI BARAZI MOH. DAULAT KHEL\r\nCHARSADDA\r\n', 'CHARSADDA', '24934', 'PK-C-5', 'PK-C-5', '1710211548895', 'K7398204-6	', NULL, 'no', 'CNIC-cbd5862a.jpeg', NULL, 'FBR-234be89f.jpeg', 'KIPRA-91ef8f74.jpeg', 'PEC2020-bbf915c4.jpeg', '', '', 'no', 0, 0, '2021-09-09 02:09:51', '2024-08-19 08:07:01'),
(10640, 'D.G BUILDERS CONSTRUCTION CO.', 'na@gmail.com', '0346-9456671', '15602-8773062-5', 'IFRANULLAH KHAN	', 'VILL. TEH. CHARBAGH MOH. KHWAR PALAW DISTT. SWAT\r\n', 'SWAT', '25138', 'PK-C-5', 'PK-C-5', '1560287730625', 'K7347015-0	', NULL, 'no', 'CNIC-dd87c2a8.jpeg', NULL, 'FBR-ba41e42b.jpeg', 'KIPRA-e79b4db6.jpeg', 'PEC2020-11202f65.jpeg', '', '', 'no', 0, 0, '2021-09-09 04:09:44', '2024-08-19 08:07:01'),
(10641, 'M/s Hakim Khan & Arif Ullah Construction Company Constructor', 'HAKIMKHAN1968@GMAIL.COM', '0341-9848179', '11201-0365636-1', 'Hakeem Khan', 'village bega tajazai po tajazai tehsil & distt lakki marwat', 'Lakki Marwat', '25664', 'PK-C-5', 'PK-C-5', 'A230996-2', 'KA230996-2', NULL, 'no', 'CNIC-da72d51e.jpeg', NULL, 'FBR-2036a8d2.jpeg', 'KIPRA-f37acc39.jpeg', 'PEC2020-97fdb243.jpeg', 'Form-H-576d57ff.jpeg', '', 'no', 0, 0, '2021-09-09 04:09:17', '2024-08-19 08:07:01'),
(10644, 'JDK MASHWANI CONSTRUCTION & ENGINEERING COMPANY ', 'jandastagir1@gmail.com', '03-479-45605', '15401-9852331-5', 'Jandastagir khan', 'Yarishah, prangai p/o sakhakot district mlakand tehsile dargai', 'Malakand', '76393', 'PK-C-6', 'PK-C-6', '15401-9852331-5 ', '15401-9852331-5 ', NULL, 'no', 'CNIC-12888c3c.jpeg', NULL, 'FBR-a1c47328.jpeg', 'KIPRA-a956c587.jpeg', 'PEC2020-11d1ecae.jpeg', '', '', 'no', 0, 0, '2021-09-08 23:09:43', '2024-08-19 08:07:01'),
(10645, 'SAID FAISAL', 'saidfaisal217@gmail.com', '03139898104', '1620180129059', 'Said Faisal ', 'HOUSE NO 22 ST NO 18 MOHALLAH ABDULLAH SHAH BIYABANI DAK Islamabad', 'Sawabi ', '24329', 'PK-C-5', 'PK-C-5', '2039728-3', 'K2039728-3', NULL, 'no', 'CNIC-2f0f2272.jpeg', NULL, 'FBR-8394cde4.jpeg', 'KIPRA-9579fc88.jpeg', 'PEC2020-f9e93baf.jpeg', '', '', 'no', 0, 0, '2021-09-09 03:09:36', '2024-08-19 08:07:01'),
(10646, 'M/s A.Q Builders & Developers', 'amirqadir31955@gmail.com', '03325877332', '1730190489737', 'Amir Qadir', 'House No. 81, Sector N-3, Street N-5, Phase 04 Hayatabad Peshawar. ', 'PESHAWAR', '7589', 'PK-C-3', 'PK-C-3', '7535827', '7535827-1', NULL, 'no', 'CNIC-06cec8a2.jpeg', NULL, 'FBR-e3c2b74d.jpeg', 'KIPRA-a819f0eb.jpeg', 'PEC2020-0feb8071.jpeg', '', '', 'no', 0, 0, '2021-09-09 06:09:51', '2024-08-19 08:07:01'),
(10647, 'M/s A.Q Builders & Developers', 'amirqadir31955@gmail.com', '000987776544', '1730190489737', 'Amir Qadir', 'House No. 81, Sector N-3, Street N-5, Phase 04 Hayatabad Peshawar. ', 'PESHAWAR', '7589', 'PK-C-3', 'PK-C-3', '7535827', '7535827-1', NULL, 'no', 'CNIC-09ffeb69.jpeg', NULL, 'FBR-d21c44c0.jpeg', 'KIPRA-23fc99b7.jpeg', 'PEC2020-5394aa81.jpeg', '', 'PE-3198b77d.jpeg', 'no', 0, 0, '2021-09-09 06:09:15', '2024-08-19 08:07:01'),
(10649, 'SHERINGAL CONSTRUCTION COMPANY', 'na@gmail.com', '0345-4126784', '15701-3661191-9', 'TAIMUR SALIH	', 'SHERINGAL CONSTRUCTION COMPANY TEHSIL SHERINGAL P/O\r\n', 'DIR', '7517', 'PK-C-3', 'PK-C-3', '1570136611919', 'K6604030-1', NULL, 'no', 'CNIC-7911fb5d.jpeg', NULL, 'FBR-c89952b9.jpeg', 'KIPRA-84f9ce06.jpeg', 'PEC2020-0d05055e.jpeg', '', 'PE-4a7ac3fe.jpeg', 'no', 0, 0, '2021-09-10 01:09:08', '2024-08-19 08:07:01'),
(10650, 'ROYAL BUILDERS & CONSTRUCTION', 'bilalkhan1038swat@gmail.com', '0333-9461042', '15607-0350040-9', 'Hazrat Bilal', 'Gul maroof khel plaza haji baba chwok mingora swat', 'swat                                    ', '25426', 'PK-C-5', 'PK-C-5', '7325312-5', 'K7325312-5', NULL, 'no', 'CNIC-d873c6b1.jpeg', NULL, 'FBR-6da319b2.jpeg', 'KIPRA-8b66cbfc.jpeg', 'PEC2020-79915c35.jpeg', 'Form-H-6a655388.jpeg', 'PE-85c3c462.jpeg', 'no', 0, 0, '2021-09-10 20:09:10', '2024-08-19 08:07:01'),
(10651, 'Hilal brothers engineering services', 'Amirkan93100@gmail.com', '0317-1486962', '17101-0331451-3', 'Ajmal khan', 'Hilal electric works tangi road charsadda', 'Charsadda', '67985', 'PK-C-6', 'PK-C-6', '4340773-7', 'K4340773-7', NULL, 'no', 'CNIC-56f914a6.jpeg', NULL, 'FBR-2e970168.jpeg', 'KIPRA-22110100.jpeg', 'PEC2020-dc692096.jpeg', '', '', 'no', 0, 0, '2021-09-12 00:09:21', '2024-08-19 08:07:01'),
(10654, 'AAK Contractors ', 'Dablewkhan@yahoo.co.uk', '0333-9966796', '12201-4257488-1', 'Adil Wahab Kundi ', 'House#807, Street#34, Sector#D/4, Phase#1, Hayatabad Peshawar. ', 'Peshawar ', '69254', 'PK-C-6', 'PK-C-6', '4388517', 'K4388517-9', NULL, 'no', 'CNIC-4c0d3747.jpeg', NULL, 'FBR-6a32f5b4.jpeg', 'KIPRA-2a87954c.jpeg', 'PEC2020-cbe93454.jpeg', 'Form-H-cd9658cd.jpeg', 'PE-75a852ca.jpeg', 'no', 0, 0, '2021-09-12 20:09:55', '2024-08-19 08:07:01'),
(10655, 'Akbar Hassan', 'akbarhassan254@gmail.com', '03459369254', '16101-1183757-3', 'Akbar hassan', 'Mardan', 'Mardan', '15620', 'PK-C-4', 'PK-C-4', '0007191-9', 'K0007191-9', NULL, 'no', 'CNIC-53099bbb.jpeg', NULL, 'FBR-59ad7e89.jpeg', 'KIPRA-e7c16d67.jpeg', 'PEC2020-9c3f4812.jpeg', '', '', 'no', 0, 0, '2021-09-12 20:09:38', '2024-08-19 08:07:01'),
(10656, 'RNENWABLE POWER UTILITIES', 'adelderwesh7272@gmail.com', '0308-2287272', '21708-5932500-9', 'ENGR ANDEL DERWESH', 'house no 179,street 03,secor phase6,hayatabad Peshawar', 'peshawar', '70347', 'PK-C-4', 'PK-C-5', '5296146', '5296146', NULL, 'no', 'CNIC-761d7ccd.jpeg', NULL, 'FBR-62e35591.jpeg', 'KIPRA-8706adb9.jpeg', 'PEC2020-a640d480.jpeg', 'Form-H-7f19fe86.jpeg', 'PE-d6672024.jpeg', 'no', 0, 0, '2021-09-13 01:09:47', '2024-08-19 08:07:01'),
(10658, 'Meer Traders ', 'naeem71015@yahoo.com', '0315-5869928', '13302-0370230-7', 'Naeemullah Khan ', 'Village Kaileg, Tehsil & District Haripur ', 'Haripur ', '24913', 'PK-C-5', 'PK-C-5', '6945818-5', 'K6945818-5', NULL, 'no', 'CNIC-d06de2b2.jpeg', NULL, 'FBR-b36d133b.jpeg', 'KIPRA-4de5c445.jpeg', 'PEC2020-954d742d.jpeg', '', 'PE-0c263d87.jpeg', 'no', 0, 0, '2021-09-13 06:09:11', '2024-08-19 08:07:01'),
(10660, 'M/s Amjad Ullah ', 'amjadullah916@gmail.com', '0300-9369058', '17301-9519846-3', 'Amjad Ullah ', 'Village Regi Mohallah Aftezai Tehsil and District Peshawar', 'Peshawar', '6893', 'PK-C-4', 'PK-C-4', '2988484-5', 'K2988484-5', NULL, 'no', 'CNIC-9125fe85.jpeg', NULL, 'FBR-fc1403d8.jpeg', 'KIPRA-5693b3c3.jpeg', 'PEC2020-499922a9.jpeg', '', '', 'no', 0, 0, '2021-09-13 07:09:24', '2024-08-19 08:07:01'),
(10662, 'MOIN UD DIN & CO', 'na@gmail.com', '0344-1265743', '17201-0333512-9', 'MOINUDDIN', 'VILL & P.O.TAJORI MOH: DAWAR KHEL DISTT:\r\n', 'LAKKI MARWAT', '15274', 'PK-C-4', 'PK-C-4', '2249308-5', 'K2249308-5', NULL, 'no', 'CNIC-f9543bcb.jpeg', NULL, 'FBR-70b3fedc.jpeg', 'KIPRA-87eaa391.jpeg', 'PEC2020-69996d5d.jpeg', '', 'PE-3a5fb348.jpeg', 'no', 0, 0, '2021-09-13 01:09:01', '2024-08-19 08:07:01'),
(10663, 'Malik Paindah Khail Construction', 'Paindahkheel@gmail.com', '03442221844', '15702-0606644-9', 'Sher Bahadar Khan', 'Dir', 'Dir', '25120', 'PK-C-5', 'PK-C-5', '1001142-7', 'K1001142-7', NULL, 'no', 'CNIC-39c933b5.jpeg', NULL, 'FBR-1c50c7f1.jpeg', 'KIPRA-e3a2484b.jpeg', 'PEC2020-1076a138.jpeg', '', '', 'no', 0, 0, '2021-09-14 00:09:30', '2024-08-19 08:07:01'),
(10665, 'Masood khan achar', 'masoodkhan1964@gmail.com', '03349269130', '17301-1647574-7', 'Masood khan', 'Teh bahadar moh, Achar p/o bahadar kalli peshawar', 'Peshawar', '13872', 'PK-C-4', 'PK-C-5', '1730116475747', 'K3239912-0', NULL, 'no', 'CNIC-19c7018a.jpeg', NULL, 'FBR-998342b7.jpeg', 'KIPRA-040ccb02.jpeg', 'PEC2020-b31f5195.jpeg', '', 'PE-e0e7a4cc.jpeg', 'no', 0, 0, '2021-09-14 02:09:13', '2024-08-19 08:07:01'),
(10666, 'M/S Shaukat Ali Khan And Sons', 'S.shoukatalikhanandbrothers@gmail.com', '03018576555', '2110625094075', 'Shaukat Ali Khan', 'AZAMY KHAR,P.O KHAR,TEHSIL Salarzai,District Bajaur', 'Bajaur', '24853', 'PK-C-5', 'PK-C-5', '51479008', 'K51479008', NULL, 'no', 'CNIC-53fe6ad7.jpeg', NULL, 'FBR-c39ccf04.jpeg', 'KIPRA-562c5a7f.jpeg', 'PEC2020-613ab41a.jpeg', '', '', 'no', 0, 0, '2021-09-14 02:09:36', '2024-08-19 08:07:01'),
(10667, 'Shamraz Abbasi ', 'shamraizabbasi706@gmail.com', '0312-9321713', '13302-0524910-7', 'Shamraz Abbasi ', 'Thanda Choha Sarai Saleh Distt. Haripur ', 'Haripur ', '44867', 'PK-C-6', 'PK-C-6', '1330205249107', 'K2717548-7', NULL, 'no', 'CNIC-9ad02f19.jpeg', NULL, 'FBR-68a30870.jpeg', 'KIPRA-968d2e84.jpeg', 'PEC2020-98b9ed64.jpeg', '', '', 'no', 0, 0, '2021-09-14 02:09:52', '2024-08-19 08:07:01'),
(10668, 'M/s Waheed Zaman Khan Govt: Contractor ', 'waheedzamankhan420@gmail.com', '0344-8917420', '16202-3888943-9', 'Waheed Zaman Khan', 'Ghulam abad Garmunara, Tehsil & Distt Swabi', 'Swabi', '22762', 'PK-C-5', 'PK-C-5', '1620238889439', 'K7263630-0', NULL, 'no', 'CNIC-9b97742c.jpeg', NULL, 'FBR-8f81a60a.jpeg', 'KIPRA-a80a853c.jpeg', 'PEC2020-80b7c681.jpeg', '', '', 'no', 0, 0, '2021-09-14 03:09:03', '2024-08-19 08:07:01'),
(10669, 'Mohammad Naeem Brothers & Co.', 'raheemkhan0343@gmail.com', '03439015861', '1620250420617', 'Mohammad Naeem Khan', 'Mohallah Khadri Khel, Village & P.O Panjpir, Tehsil & District Swabi, KPK', 'Swabi', 'C5/25418', 'PK-C-5', 'PK-C-5', '3751960-3', 'K3751960-3', NULL, 'no', 'CNIC-c6502bf5.jpeg', NULL, 'FBR-e5f5d57a.jpeg', 'KIPRA-d9e39b91.jpeg', 'PEC2020-af26445c.jpeg', '', 'PE-62eaf554.jpeg', 'no', 0, 0, '2021-09-14 04:09:09', '2024-08-19 08:07:01'),
(10670, 'THE BRIGHT BUILDERS & CO.', 'brightbuilderws@gmail.com', '0348-9089996', '15602-9132047-7', 'NAVEED KHAN ', 'SUNEHRI MOHALLAH, BANR NEW ROAD MINGORA, SWAT ', 'SWAT ', '76395', 'PK-C-6', 'PK-C-6', '4973319-5', 'K4973319-5', NULL, 'no', 'CNIC-4f57aa5a.jpeg', NULL, 'FBR-eed111c1.jpeg', 'KIPRA-0a884aab.jpeg', 'PEC2020-97f1a01b.jpeg', '', '', 'no', 0, 0, '2021-09-14 04:09:10', '2024-08-19 08:07:01'),
(10671, 'fayaz khan gandapur', 'fayazkhangandapur@gmail.com', '0313-9568000', '12102-6666276-7', 'muhammad fayaz', 'zaidi colony kabal river nowshera kalan', 'nowshera', '25122', 'PK-C-5', 'PK-C-5', '1210266662767', 'k7559651-2', NULL, 'no', 'CNIC-b961bcb0.jpeg', NULL, 'FBR-c3b72b92.jpeg', 'KIPRA-6e5e8fe5.jpeg', 'PEC2020-3b17c33f.jpeg', '', 'PE-b9cde1a0.jpeg', 'no', 0, 0, '2021-09-14 05:09:08', '2024-08-19 08:07:01'),
(10672, 'fayaz khan gandapur', 'greatgeminins85@gmail.com', '0313-9568000', '12102-6666276-7', 'muhammad fayaz', 'zaidi colony kabalriver nowshera kalan', 'nowshera', '25122', 'PK-C-5', 'PK-C-5', '1210266662767', 'k7559651-2', NULL, 'no', 'CNIC-9faa89a1.jpeg', NULL, 'FBR-b50a444e.jpeg', 'KIPRA-79bd09fb.jpeg', 'PEC2020-5ae49a9c.jpeg', '', 'PE-74019988.jpeg', 'no', 0, 0, '2021-09-14 06:09:59', '2024-08-19 08:07:01'),
(10679, 'Muslim Bagh & Co', 'rasheed.mh9944@gmail.com', '0344-5959944', '13503-1935941-7', 'Abdul Rasheed', 'C/O. AHMAD USMAN OFFICE#316 , 3RD FLOOR CAPITAL TRADE CENTRE F-10 MARKAZ ISLAMABAD', 'Kohistan', '15652/E', 'PK-C-4', 'PK-C-4', '4094309-7', 'K4094309-7', NULL, 'no', 'CNIC-718e6c01.jpeg', NULL, 'FBR-d7cbed26.jpeg', 'KIPRA-36952812.jpeg', 'PEC2020-ad27c631.jpeg', 'Form-H-43b7a8ae.jpeg', '', 'no', 0, 0, '2021-09-14 03:09:59', '2024-08-19 08:07:01'),
(10681, 'M/s khan engineer & brothers', 'fakhar_fakhar7@yahoo.com', '0300-5888902', '35200-1558110-9', 'Fakhar ul islam', 'Vellage seo p.o komila tehsil Dassu kohistan', 'Upar kohistan', '20128', 'PK-C-5', 'PK-C-5', '3520015581109', 'K8248177_1', NULL, 'no', 'CNIC-f3f3f6be.jpeg', NULL, 'FBR-e86a2e9b.jpeg', 'KIPRA-af8edb38.jpeg', 'PEC2020-a723fc50.jpeg', '', '', 'no', 0, 0, '2021-09-15 01:09:39', '2024-08-19 08:07:01'),
(10683, 'Malik Hafeez ur Rehman & Co ', 'malikhassamawan2@gmail.com', '0314-5005999', '13101-9644491-5', 'Malik Hafeez ur Rehman ', 'Banda Phugwarian, Abbottabad ', 'Abbottabad', '10908', 'PK-C-5', 'PK-C-5', '7576657', 'K7576657-7', NULL, 'no', 'CNIC-48707b90.jpeg', NULL, 'FBR-4fbbdd3f.jpeg', 'KIPRA-d683aa93.jpeg', 'PEC2020-5df2152e.jpeg', 'Form-H-486c2f69.jpeg', 'PE-c6ffebd8.jpeg', 'no', 0, 0, '2021-09-15 03:09:35', '2024-08-19 08:07:01'),
(10686, 'Al Aziz Construction Company Battagram', 'Gulabkhan1222@gmail.com', '03469621454', '13201-1813244-9', 'Gulab Khan', 'Battagram', 'Battagram', '25112', 'PK-C-5', 'PK-C-5', '7598144-2', 'K7598144-2', NULL, 'no', 'CNIC-f8b5f85a.jpeg', NULL, 'FBR-ff4e84c3.jpeg', 'KIPRA-20b95b70.jpeg', 'PEC2020-c6a83f23.jpeg', '', '', 'no', 0, 0, '2021-09-14 22:09:49', '2024-08-19 08:07:01'),
(10687, 'Sky Construction Company', 'umerzaifs@gmail.com', '0310-0003114', '17101-1138654-7', 'Suleman Khan', 'Mohallah Shamozai Utmanzai, District Charsadda', 'Charsadda', '9422', 'PK-C-4', 'PK-C-4', '4894164', 'K4894164-5', NULL, 'no', 'CNIC-48201a56.jpeg', NULL, 'FBR-27d88cdd.jpeg', 'KIPRA-3b18e5ad.jpeg', 'PEC2020-d2729d97.jpeg', '', '', 'no', 0, 0, '2021-09-15 01:09:35', '2024-08-19 08:07:01'),
(10688, 'Sky Construction Company', 'umerzaifs1@gmail.com', '0310-0003114', '17101-1138654-7', 'Suleman Khan', 'Mohallah Shamozai Utmanzai District Charsadda', 'Charsadda', '9422', 'PK-C-4', 'PK-C-4', '4894164', 'K4894164-5', NULL, 'no', 'CNIC-7b089156.jpeg', NULL, 'FBR-c301093f.jpeg', 'KIPRA-587a0857.jpeg', 'PEC2020-a07dad45.jpeg', '', '', 'no', 0, 0, '2021-09-15 01:09:52', '2024-08-19 08:07:01'),
(10689, 'M/S SAMI KHAN CONSTRUCTI COMPANY', 'samikhanzsk@gmail.com', '0315-5571157', '16101-3280385-5', 'Sami Ullah', 'MARDAN', 'Mardan', '15494', 'PK-C-4', 'PK-C-4', '16101-3280385-5', 'K82282768', NULL, 'no', 'CNIC-e589cfa4.jpeg', NULL, 'FBR-b7ea4f5a.jpeg', 'KIPRA-71fcf64c.jpeg', 'PEC2020-32df58bf.jpeg', '', 'PE-11dfa6e3.jpeg', 'no', 0, 0, '2021-09-15 22:09:30', '2024-08-19 08:07:01'),
(10690, 'ABDUL SAMAD JADOON GOVT.CONTRACTOR', 'abdulsamadjadoon555@gmail.com', '0322-9957260', '16202-5631792-1', 'ABDUL SAMAD', 'R/O KARKHANO ROAD,SHAGA,CHOWK AZAM KHAN MARKET TOPI SWABI', 'SWABI', '75240', 'PK-C-6', 'PK-C-6', '1620256317921', 'K83578342', NULL, 'no', 'CNIC-5fbdb3b1.jpeg', NULL, 'FBR-6e899990.jpeg', 'KIPRA-b149c9b9.jpeg', 'PEC2020-3dfd4fea.jpeg', '', 'PE-f76c37d5.jpeg', 'no', 0, 0, '2021-09-16 01:09:37', '2024-08-19 08:07:01'),
(10692, 'M/s ALTAF GOVERNMENT CONTRACTOR', 'altafhussain123@gmail.com', '0340-1948040', '15307-9662198-3', 'Altaf Hussain', 'CHAT PAT P.O. CHAKDARA TEH. ADANZAI DISTT. LOWER Dir', 'DIR', '25470', 'PK-C-5', 'PK-C-5', '1530796621983', 'K8357105-2', NULL, 'no', 'CNIC-55d59212.jpeg', NULL, 'FBR-74971d1a.jpeg', 'KIPRA-f13bb8c4.jpeg', 'PEC2020-7654ce8d.jpeg', '', '', 'no', 0, 0, '2021-09-16 02:09:06', '2024-08-19 08:07:01'),
(10694, 'M/s United Contracting Company (SMC Private) Limited', 'sajid.mohmand70@gmail.com', '0345-0257007', '16102-2510936-9', 'Sajid Ali', 'Ameer Gulab Killi badaraga Takh Bhai District Mardan', 'Mardan', '3287', 'PK-C-2', 'PK-C-2', '8382799', 'K8382799-1', NULL, 'no', 'CNIC-3d108504.jpeg', NULL, 'FBR-08a875f9.jpeg', 'KIPRA-31fe664c.jpeg', 'PEC2020-79de340e.jpeg', '', '', 'no', 0, 0, '2021-09-16 06:09:24', '2024-08-19 08:07:01'),
(10695, 'AIMS ENGINEERING SERVICES', 'aimzcon@gmail.com', '0345-8075001', '15602-1351454-9', 'IKRAM ULLAH KHAN', 'MOH, NASIR KHEL ODIGRAM TEHSIL BABUZAI SWAT', 'SWAT', '14498', 'PK-C-4', 'PK-C-4', '81942647', 'K81942647', NULL, 'no', 'CNIC-6e8e22be.jpeg', NULL, 'FBR-c8cfad82.jpeg', 'KIPRA-2b1792c1.jpeg', 'PEC2020-3931abd6.jpeg', '', '', 'no', 0, 0, '2021-09-15 21:09:41', '2024-08-19 08:07:01'),
(10696, 'JAVED KHAN', 'na@gmail.com', '0332-5674321', '11201-4170989-1', 'JAVED USMAN', 'R/O MOH: SAID KHEL VILL. TAJAZAI\r\n', 'LAKKI MARWAT', '25443', 'PK-C-5', 'PK-C-5', '1120141709891', '3397435-7', NULL, 'no', 'CNIC-084dcc88.jpeg', NULL, 'FBR-d69b6297.jpeg', 'KIPRA-866a00cc.jpeg', 'PEC2020-8b2243cb.jpeg', '', 'PE-bc3cde09.jpeg', 'no', 0, 0, '2021-09-16 01:09:10', '2024-08-19 08:07:01'),
(10697, 'AL-MUJIB CONSTRUCTION COMPANY', 'na@gmail.com', '0344-1234562', '21704-6170895-7', 'MUJIB UR REHMAN', 'KOTKAL P.O. & TEH. TRIBAL DISTT. SOUTH\r\n', 'WAZIRISTAN AGENCY', '25095', 'PK-C-5', 'PK-C-5', '2170461708957', 'K8941116-3', NULL, 'no', 'CNIC-36003b02.jpeg', NULL, 'FBR-6717c558.jpeg', 'KIPRA-cc197613.jpeg', 'PEC2020-3cc4dd56.jpeg', '', 'PE-0bdba168.jpeg', 'no', 0, 0, '2021-09-16 01:09:27', '2024-08-19 08:07:01'),
(10698, 'CHIEF OF SHERANI GOVT CONTRACTOR', 'na@gmail.com', '0347-3452167', '22301-2134944-7', 'SARDAR ABAD KHAN	', 'MAIN DARAZINDA TRIBAL SUB DIVISION DARAZINDA\r\n', 'DERA ISMAIL KHAN', '15122', 'PK-C-4', 'PK-C-4', '2230121349447', 'K8030581-7', NULL, 'no', 'CNIC-9d10294e.jpeg', NULL, 'FBR-b7b6a5c7.jpeg', 'KIPRA-195eccd2.jpeg', 'PEC2020-3595ed00.jpeg', '', '', 'no', 0, 0, '2021-09-16 01:09:32', '2024-08-19 08:07:01'),
(10700, 'M/S UMAR CONSTRUCTIONS', 'umerconstruction0@gmail.com', '0334-9047066', '15601-8866207-7', 'Shawkat hayat', 'VILL. & P.O. SAKHRA TEH. MATTA DISTT SWAT', 'Swat', '23847', 'PK-C-5', 'PK-C-5', '4898551-0', 'K4898551-0', NULL, 'no', 'CNIC-3142181a.jpeg', NULL, 'FBR-1552b701.jpeg', 'KIPRA-edb61566.jpeg', 'PEC2020-2b452939.jpeg', '', '', 'no', 0, 0, '2021-09-17 04:09:55', '2024-08-19 08:07:01'),
(10701, 'M/S SBZ CONSTRUCTION CO.', 'sbzconstructionco@gmail.com', '0347 5784404', '15602-8230238-1', 'BAHADAR KHAN', 'vill. shinkad p.o. charbagh distt. Swat ', 'Swat ', '7273', 'PK-C-3', 'PK-C-3', '5176952-8', 'K5176952-8', NULL, 'no', 'CNIC-816ce18e.jpeg', NULL, 'FBR-04b381fb.jpeg', 'KIPRA-479ece77.jpeg', 'PEC2020-0ed46cb5.jpeg', '', '', 'no', 0, 0, '2021-09-17 04:09:38', '2024-08-19 08:07:01'),
(10702, 'Anwaria Construction Company', 'nisarali6559kurram@gmail.com', '0300-0818197', '21303-3436932-3', 'Nisar Ali ', '7, Tehsil Upper Kurram District Kurram Agency, P/O Parachinar, Epiwar Shra Kaly Khyber, Parachinar', 'Kurram', '7565', 'PK-C-3', 'PK-C-3', '2130334369323', 'K6559356-3', NULL, 'no', 'CNIC-9a151e6c.jpeg', NULL, 'FBR-6cbf04fc.jpeg', 'KIPRA-32d4b9d9.jpeg', 'PEC2020-482df56f.jpeg', '', '', 'no', 0, 0, '2021-09-17 05:09:09', '2024-08-19 08:07:01'),
(10703, 'Khalil Constration pvt ltd ', 'khalilconstruction82@gmail.com', '0333-9128519', '1730155671299', 'Sharafat Ali Khalil ', 'Al-haji Plaza Shop #2 jamrud road Gulabad peshawar ', 'peshawar', '2099', 'PK-C-2', 'PK-C-2', '8985930-6', 'k8985930-6', NULL, 'no', 'CNIC-3bbeb8c8.jpeg', NULL, 'FBR-ed596255.jpeg', 'KIPRA-a3475b4e.jpeg', 'PEC2020-1814c6d6.jpeg', '', 'PE-1b1fee0c.jpeg', 'no', 0, 0, '2021-09-18 02:09:45', '2024-08-19 08:07:01'),
(10706, 'M/s Farhan ullah ', 'kaleemullah0969@gmail.com', '03128102222', '1120103142553', 'Farhan ullah', 'Village &p.o. taja zai \r\nDist. Allied marwat', 'Lakki marwat', '14999', 'PK-C-4', 'PK-C-4', '1431595-5', '1431595-5', NULL, 'no', 'CNIC-f1972339.jpeg', NULL, 'FBR-b21fe528.jpeg', 'KIPRA-cc19bc7e.jpeg', 'PEC2020-637123b6.jpeg', '', '', 'no', 0, 0, '2021-09-17 22:09:10', '2024-08-19 08:07:01'),
(10707, 'M/S SARKAR CONST. COMPANY', 'auk9606159@gmail.com', '03149606159', '1120170722785', 'ASIF ULLAH KHA', 'Koh. Shaba khkle \r\nDULAT TAJA ZAI \r\nP.O TAJAZAI\r\nTEH. & DIST. LAKKI MARWAT', 'Lakki marwat', '25387', 'PK-C-5', 'PK-C-5', '82576361', '82576361', NULL, 'no', 'CNIC-c9cc8289.jpeg', NULL, 'FBR-c46fa55c.jpeg', 'KIPRA-bcca0407.jpeg', 'PEC2020-4d3ed884.jpeg', 'Form-H-626172ed.jpeg', '', 'no', 0, 0, '2021-09-18 01:09:51', '2024-08-19 08:07:01'),
(10709, 'Ajmal Five Star Builders', 'ajmalkhan33773377@gmail.com', '03339348824', '16202-0848579-7', 'Ajmal Khan', 'CE-01, CE04-CE-09 CE-10,EE01,EE02, EE04,EE11', 'Swabi', '14229', 'PK-C-4', 'PK-C-4', '7151445-0', 'K7151445-0', NULL, 'no', 'CNIC-45d8421b.jpeg', NULL, '', 'KIPRA-165cc412.jpeg', 'PEC2020-9f71b6e2.jpeg', '', 'PE-93615f6c.jpeg', 'no', 0, 0, '2021-09-19 07:09:35', '2024-08-19 08:07:01'),
(10710, 'AZMAT ULLAH & BROTHERS', 'azmatullahbrother@gmail.com', '010100000000', '17201-0350383-1', 'AZMAT ULLAH', 'VILL KHOSH MUQAM P.O TARU JABBA TEH & DISTT\r\nCity	NOWSHERA', 'NOWSHERA', '15623', 'PK-C-4', 'PK-C-4', '1720103503831', 'K3812071-2', NULL, 'no', 'CNIC-97e55182.jpeg', NULL, 'FBR-68292cd3.jpeg', 'KIPRA-6a18baf7.jpeg', 'PEC2020-985d602a.jpeg', '', '', 'no', 0, 0, '2021-09-20 02:09:23', '2024-08-19 08:07:01');
INSERT INTO `contractor_registrations` (`id`, `contractor_name`, `email`, `mobile_number`, `cnic`, `district`, `address`, `pec_number`, `owner_name`, `category_applied`, `pec_category`, `fbr_ntn`, `kpra_reg_no`, `pre_enlistment`, `is_limited`, `cnic_front_attachment`, `cnic_back_attachment`, `fbr_attachment`, `kpra_attachment`, `pec_attachment`, `form_h_attachment`, `pre_enlistment_attachment`, `is_agreed`, `defer_status`, `approval_status`, `created_at`, `updated_at`) VALUES
(10711, 'M/s SJ BUILDERS (SMC-PRIVATE) LIMITED', 'm.ahmedkhan49@gmail.com', '0322-9898761', '13101-9640262-5', 'MUHAMMAD JAVED ', 'BASHIR MARKET SHOP #1, UPPER PORTION MAIN BAZAR TOPI SWABI', 'SWABI', 'C5-24850', 'PK-C-5', 'PK-C-5', '8163756-0', 'K8163756-0', NULL, 'no', 'CNIC-e07f5e98.jpeg', NULL, 'FBR-5d6f5861.jpeg', 'KIPRA-c360f9c7.jpeg', 'PEC2020-e385f25f.jpeg', '', '', 'no', 0, 0, '2021-09-20 02:09:53', '2024-08-19 08:07:01'),
(10712, 'Eshan Constuction & Co', 'adilkhan501@yahoo.com', '03139579501', '1720105937119', 'Muhmmad Adil Khan', 'Office No 2 1st Floor Gul Plaza Aziz Bhatti Road Nowshera Cantt', 'Nowshera', '23472', 'PK-C-5', 'PK-C-5', '3765260-5', 'K3765260-5', NULL, 'no', 'CNIC-34c086e3.jpeg', NULL, 'FBR-fda6c726.jpeg', 'KIPRA-f0417882.jpeg', 'PEC2020-f74368d1.jpeg', '', 'PE-5d92e330.jpeg', 'no', 0, 0, '2021-09-20 04:09:51', '2024-08-19 08:07:01'),
(10713, 'M/s Shahid Saleem Contractor', 'shahedsaleem26877@gmail.com', '0333-9426877', '15101-0365895-1', 'Shahid Saleem', 'Mohallah Sadaat Ghur Ghushto Teshil Daggar Distt Buner', 'Buner', '24919', 'PK-C-5', 'PK-C-5', '1510103658951', 'K7613108-8', NULL, 'no', 'CNIC-22e22c20.jpeg', NULL, 'FBR-a5bd4e87.jpeg', 'KIPRA-769c6629.jpeg', 'PEC2020-7fbb769d.jpeg', '', 'PE-d127ead4.jpeg', 'no', 0, 0, '2021-09-20 04:09:37', '2024-08-19 08:07:01'),
(10714, 'AJIDULLAH BUILDERS', 'na@gmail.com', '0342-5678143', '15101-5494669-3', 'AJID ULLAH	', 'VILL:SHANGRA PANDIR TEH: DAGGAR DISTT:\r\n', 'BUNER', '65663', 'PK-C-6', 'PK-C-6', '1510154946693', 'K5177045-2', NULL, 'no', 'CNIC-c258b250.jpeg', NULL, 'FBR-9c77a13a.jpeg', 'KIPRA-e572abfb.jpeg', 'PEC2020-0aad3900.jpeg', '', '', 'no', 0, 0, '2021-09-20 00:09:03', '2024-08-19 08:07:01'),
(10717, 'M/S SHAHI MURAD CONSTRUCTION COMPANY', 'shahimurad94@gmail.com', '0342-9285674', '15605-0349932-9', 'SHAHI MURAD', 'Mohallah Ali Bash khel Chamtalai Tehsil Khawazakhela District swat.', 'swat', 'C/5    24884', 'PK-C-5', 'PK-C-5', '1560503499329', '5995001-2', NULL, 'no', 'CNIC-6be0406d.jpeg', NULL, 'FBR-3b4f01bf.jpeg', 'KIPRA-0ba63286.jpeg', 'PEC2020-bea1cfdc.jpeg', '', '', 'no', 0, 0, '2021-09-21 02:09:01', '2024-08-19 08:07:01'),
(10718, 'FAST DEAL', 'Fastdeal314@gmail.com', '03337333014', '1320230823821', 'Muhammad Kashif Ehsan', 'KuzaBanda House Behind Askari Petrol Pump College Duraha Mansehra', 'Mansehra', '15764', 'PK-C-4', 'PK-C-4', '1320230823821', 'K42397804', NULL, 'no', 'CNIC-0265801f.jpeg', NULL, 'FBR-7e6eca04.jpeg', 'KIPRA-5f2f7f80.jpeg', 'PEC2020-814f602d.jpeg', '', '', 'no', 0, 0, '2021-09-21 03:09:51', '2024-08-19 08:07:01'),
(10719, 'AZK Construction Engineering Pvt Ltd', 'arshedzia@hotmail.com', '0333-9188592', '17201-9695238-9', 'Arshad Zia', 'H#26 Street No.2 G1 Phase II Hayatabad Peshawar', 'Nowshera', '5883', 'PK-C-3', 'PK-C-3', '8996708', 'K8996708-2', NULL, 'no', 'CNIC-b3540b86.jpeg', NULL, 'FBR-c578e152.jpeg', 'KIPRA-18a617dd.jpeg', 'PEC2020-4e22bb05.jpeg', '', '', 'no', 0, 0, '2021-09-21 04:09:32', '2024-08-19 08:07:01'),
(10721, 'KuzaBanda Trand Engineering Services', 'Ktes314@gmail.com', '03335058017', '1320230823821', 'Muhammad Kashif Ehsan', 'KuzaBanda House Behind Askari Petrol Pump College Dorah Mansehra', 'Mansehra', '14320', 'PK-C-2', 'PK-C-2', '6960518', 'K69605188', NULL, 'no', 'CNIC-fd656432.jpeg', NULL, 'FBR-452d36f2.jpeg', 'KIPRA-3c1d9882.jpeg', 'PEC2020-2d4a8802.jpeg', 'Form-H-d8b96d75.jpeg', 'PE-83799e38.jpeg', 'no', 0, 0, '2021-09-21 20:09:16', '2024-08-19 08:07:01'),
(10722, 'MOHAMMAD ALI BUILDERS AND CONSTRUCTION CO', 'na@gmail.com', '0345-8888885', '15101-1245010-7', 'M.ALI	', 'VILL. KAREE TANGI JAWAR TEH & DISTT.\r\n', 'BUNER', '24932', 'PK-C-5', 'PK-C-5', '1510112450107', 'K3235431-2', NULL, 'no', 'CNIC-b7a0bfb0.jpeg', NULL, 'FBR-acd4ec9c.jpeg', 'KIPRA-f19132f8.jpeg', 'PEC2020-80d70e97.jpeg', '', 'PE-a5b542bf.jpeg', 'no', 0, 0, '2021-09-21 23:09:04', '2024-08-19 08:07:01'),
(10723, 'Youth contraction Company', 'youthcontractioncompany01@gmail.com', '0345-5144221', '17301-3124401-9', 'Ishaq Ahmad', 'Village Faizabad Honi Tehsil And District Lower Chitral', 'chitral', '11', 'PK-C-3', 'PK-C-3', '1730131244019', 'KA0170313', NULL, 'no', 'CNIC-28177884.jpeg', NULL, 'FBR-98bec0b5.jpeg', 'KIPRA-ccd60649.jpeg', 'PEC2020-d924da1a.jpeg', '', '', 'no', 0, 0, '2021-09-22 02:09:30', '2024-08-19 08:07:01'),
(10724, 'Buni constriction Company', 'mdin-7742@gmail.com', '0303-7374208', '42501-3290123-1', 'Muhiuddin', 'Village Boni Lasht Tehsil And District Upper Chitral', 'chitral', '11', 'PK-C-6', 'PK-C-6', '4250132901231', 'K6293241-0', NULL, 'no', 'CNIC-6fb47370.jpeg', NULL, 'FBR-14957a11.jpeg', 'KIPRA-4dd712c9.jpeg', 'PEC2020-3f192acb.jpeg', '', 'PE-5aab3b21.jpeg', 'no', 0, 0, '2021-09-22 03:09:06', '2024-08-19 08:07:01'),
(10725, 'Climate Control', 'mahmood@climatecontrol.com.pk', '03214288855', '35202-3058446-7', 'Ahmad Naeem Chughtai', 'Lahore', 'Lahore', '3473', 'PK-C-2', 'PK-C-2', '2742943-1', 'K2742943-1', NULL, 'no', 'CNIC-ef9598d4.jpeg', NULL, 'FBR-664878e6.jpeg', 'KIPRA-8ba72eeb.jpeg', 'PEC2020-7b50c974.jpeg', '', '', 'no', 0, 0, '2021-09-22 04:09:44', '2024-08-19 08:07:01'),
(10726, 'M/s Jabran Construction Co', 'jabrandanish07@gmail.com', '0333-9675345', '14101-1558109-1', 'Gul Sahib Shah', 'Farooq abad thal road Hangu', 'Hangu', '23475', 'PK-C-5', 'PK-C-5', '1518325', 'K1518325-4', NULL, 'no', 'CNIC-0485b06e.jpeg', NULL, 'FBR-7fc8c614.jpeg', 'KIPRA-cfc7fb23.jpeg', 'PEC2020-3b06e0cb.jpeg', '', 'PE-9c8b5610.jpeg', 'no', 0, 0, '2021-09-22 05:09:47', '2024-08-19 08:07:01'),
(10727, 'M/s Amal Dad & Sons', 'ayub9711@gmail.com', '0334-8683430', '14202-1334642-5', 'Amal Dad', 'Tehsil colony Moh: Asad Khel Karak City, Karak', 'Karak', '14844', 'PK-C-4', 'PK-C-4', '3234064-8', 'K3234064-8', NULL, 'no', 'CNIC-04d3c184.jpeg', NULL, 'FBR-8c7ce648.jpeg', 'KIPRA-31186027.jpeg', 'PEC2020-0e8f05e2.jpeg', '', '', 'no', 0, 0, '2021-09-22 07:09:56', '2024-08-19 08:07:01'),
(10730, 'ROGHANI CONSTRUCTION COMPANY', 'na@gmail.com', '0344-9908271', '15701-2160103-9', 'SULTAN YOUSAF ROGHANI	', 'ROGHANI HOUSE, STREET#08, MAIN PAHARI PURA, NEAR RING ROAD,\r\n', 'Peshawar', '25708', 'PK-C-5', 'PK-C-5', '1570121601039', 'K4076510-5', NULL, 'no', 'CNIC-01e1cf31.jpeg', NULL, 'FBR-b8ba491d.jpeg', 'KIPRA-288ca04b.jpeg', 'PEC2020-238234cd.jpeg', '', '', 'no', 0, 0, '2021-09-23 01:09:33', '2024-08-19 08:07:01'),
(10731, 'SAIFI BROTHERS AND SONS', 'saifmsd@gmail.com', '0346-3058881', '21706-0375415-5', 'SAIFULLAH SAIFI	', 'OFFICE NO.M-26 IRSHAD ARCADE ABPARA MARKET\r\n', 'Islamabad', 'C5 /25669', 'PK-C-5', 'PK-C-5', '2170603754155', 'K6172240-4', NULL, 'no', 'CNIC-630e7153.jpeg', NULL, 'FBR-2df36616.jpeg', 'KIPRA-d31c8b30.jpeg', 'PEC2020-c06cc5db.jpeg', '', '', 'no', 0, 0, '2021-09-23 01:09:33', '2024-08-19 08:07:01'),
(10732, 'M.J CONSTRUCTION ASSOCIATES', 'na@gmail.com', '0324-3456811', '13401-1506693-9', 'JALAL KHAN	', 'MASHOOR OPTICAL AL REHMAN, D.S.P PLAZA,OPP.AYUB\r\n', 'ABBOTTABAD', 'C6 /54785', 'PK-C-6', 'PK-C-6', '1340115066939', 'K7319305-1', NULL, 'no', 'CNIC-07e9bc44.jpeg', NULL, 'FBR-c81ab002.jpeg', 'KIPRA-a009a55c.jpeg', 'PEC2020-53e9c38e.jpeg', '', '', 'no', 0, 0, '2021-09-23 01:09:01', '2024-08-19 08:07:01'),
(10736, 'Muhammad Amin Khan Marwat', 'mohammadamin030090@gmail.com', '03139984082', '1120103132559', 'Muhammad Amin khan', 'Vega taja zai p.0 taja zai \r\nDist. Lakki Marwat', 'Lakki marwat', '25659', 'PK-C-5', 'PK-C-5', '3539353', '3539353', NULL, 'no', 'CNIC-f4eb8c9e.jpeg', NULL, 'FBR-e6a1af86.jpeg', 'KIPRA-caf3aa30.jpeg', 'PEC2020-9cd6c373.jpeg', '', '', 'no', 0, 0, '2021-09-23 22:09:45', '2024-08-19 08:07:01'),
(10737, 'SHORAM CONSTRUCTION COMPANY', 'na@gmail.com', '0347-4317692', '15302-2800844-5', 'FARID GUL	', 'TANGOMANZ KHANGE PATAY P.O. RABAT TEH. TIMERGARA DISTT.\r\n', 'DIR', 'C5 /20299', 'PK-C-5', 'PK-C-5', '1530228008445', 'K8488558-1', NULL, 'no', 'CNIC-1610419b.jpeg', NULL, 'FBR-549c5b5d.jpeg', 'KIPRA-2ce6932b.jpeg', 'PEC2020-ac1f9476.jpeg', '', '', 'no', 0, 0, '2021-09-24 01:09:10', '2024-08-19 08:07:01'),
(10738, 'ASIM TRADERS & CONSTRUCTION', 'na@gmail.com', '0321-5900028', '17301-8543753-7', 'ASIM RAZA	', 'HOUSE # 2112 RATTI BAZAR\r\n', 'Peshawar', 'C5 /12454', 'PK-C-5', 'PK-C-5', '1730185437537', 'K1756699-1', NULL, 'no', 'CNIC-2d1ffcf0.jpeg', NULL, 'FBR-63e8a63a.jpeg', 'KIPRA-de6b56e1.jpeg', 'PEC2020-88f7c6b3.jpeg', '', '', 'no', 0, 0, '2021-09-24 01:09:38', '2024-08-19 08:07:01'),
(10739, 'HAJI NASIR & SONS COMPANY', 'na@gmail.com', '0321-5544101', '21107-6967941-5', 'NASIR KHAN	', 'BADO RANG P/O: GORI TEH: UTMAN KHEL DISTT:\r\n', 'BAJAUR AGENCY', 'C2 /3329', 'PK-C-2', 'PK-C-2', '2110769679415', 'K5416038-0', NULL, 'no', 'CNIC-55d00d72.jpeg', NULL, 'FBR-88488a5c.jpeg', 'KIPRA-3eb7a2e4.jpeg', 'PEC2020-b95a9851.jpeg', 'Form-H-70014437.jpeg', '', 'no', 0, 0, '2021-09-24 01:09:16', '2024-08-19 08:07:01'),
(10740, 'Muhammad Amin Khan Marwat', 'mohammadamin030090@gmail.com', '03009063208', '1120103132559', 'Muhammad Amin khan', 'Kashmir khel vega taja zai \r\nP.o taja zai \r\nTEH. Dist. Lakki marwat', 'Lakki marwat', '25659', 'PK-C-5', 'PK-C-5', '35393530', '35393530', NULL, 'no', 'CNIC-7cae9f1d.jpeg', NULL, 'FBR-6057d8ab.jpeg', 'KIPRA-1898685d.jpeg', 'PEC2020-52031c4f.jpeg', '', '', 'no', 0, 0, '2021-09-25 00:09:57', '2024-08-19 08:07:01'),
(10741, 'Contractor', 'engineerbilal546@gmail.com', '0346-1211018', '13302-4429725-3', 'M/S Ch.Muhammad Ashram Khan Govt Contractor', 'Office at Muhallah Soka Younis Khan Colony, Railway Road Haripur', 'Haripur', '25653', 'PK-C-5', 'PK-C-5', '13302-4429725-3', 'K3248855-6', NULL, 'no', 'CNIC-48989155.jpeg', NULL, 'FBR-da2b68ba.jpeg', 'KIPRA-1d08aabe.jpeg', 'PEC2020-a6f52fa6.jpeg', '', '', 'no', 0, 0, '2021-09-25 06:09:02', '2024-08-19 08:07:01'),
(10742, 'M/S Sayed Mustafa Hussain Builders', 'hmustafahussain2@gmail.com', '03088283837', '21302-1562338-5', 'M/S Sayed Mustafa Hussain Builders', 'Shop No 59 Fakhri Car Decoration  posh Arcade Plaza G 9 Markaz Islamabad', 'Kurram', '24789', 'PK-C-5', 'PK-C-5', '2130216623385', 'KA009975-3', NULL, 'no', 'CNIC-86bbd30e.jpeg', NULL, 'FBR-735d7fbf.jpeg', 'KIPRA-1288c9d3.png', 'PEC2020-9f6eb5dc.jpeg', 'Form-H-1e8b643b.png', 'PE-00a99b7a.jpeg', 'no', 0, 0, '2021-09-24 20:09:55', '2024-08-19 08:07:01'),
(10744, 'HORIZON  BUILDERS', 'yasirbbb99@gmail.com', '0313-0919774', '15101-9699653-3', 'UMAR RAHMAN', 'Office No. 17, Ground Floor Liberty Mall plaza, University road plaza, Peshawar', 'BUNER', '6497', 'PK-C-3', 'PK-C-3', '67126904', 'K67126904', NULL, 'no', 'CNIC-6d0fc117.jpeg', NULL, 'FBR-70cbb8d9.jpeg', 'KIPRA-1612010e.jpeg', 'PEC2020-3d3d5855.jpeg', '', '', 'no', 0, 0, '2021-09-27 02:09:04', '2024-08-19 08:07:01'),
(10746, 'SARDAR ALI KHAN MATTA', 'sardaralikhanmatta@gmail.com', '0346-3770576', '15601-1004762-3', 'Sardar Ali Khan', 'VILL. SIJBAN TEH MATTA, DISTRICT SWAT', 'Swat', '25442', 'PK-C-5', 'PK-C-5', '6006422-2', 'K6006422-2', NULL, 'no', 'CNIC-5e2c504e.jpeg', NULL, '', 'KIPRA-3f62ab76.jpeg', 'PEC2020-09542ab6.jpeg', '', '', 'no', 0, 0, '2021-09-27 02:09:18', '2024-08-19 08:07:01'),
(10747, 'MIR ADI ARCHITECTS & CONSTRUCTION (PRIVATE) LIMITED', 'MIRADI_CONSTRUCTION@OUTLOOK.COM', '0333-9381009', '17301-8774557-9', 'IMAD ULLAH KHAN	', 'HOUSE NO.3, STREET NO.2, MOHALLA SETHI TOWN, PAHARIPURA ROAD, HAJI CAMP\r\nPeshawar', 'Peshawar', '24878', 'PK-C-5', 'PK-C-5', 'A047249', 'A047249-8', NULL, 'no', 'CNIC-aefc6108.jpeg', NULL, 'FBR-06c7d8f4.jpeg', 'KIPRA-b236e4cf.jpeg', 'PEC2020-b028a1ae.jpeg', '', '', 'no', 0, 0, '2021-09-27 03:09:50', '2024-08-19 08:07:01'),
(10749, 'Bajeeda Builders', 'mraza2565@gmail.com', '0308-8907292', '13302-3789359-5', 'Raza Muhammad', 'Village Bajeeda Chapper Road Distt. Haripur.', 'Haripur', '67615', 'PK-C-6', 'PK-C-6', '3298096-5', 'K3298096-5', NULL, 'no', 'CNIC-792f18ff.jpeg', NULL, 'FBR-20e3dcbe.jpeg', 'KIPRA-ebea538b.jpeg', 'PEC2020-b6b5a514.jpeg', '', 'PE-1ba8bdbe.jpeg', 'no', 0, 0, '2021-09-26 22:09:19', '2024-08-19 08:07:01'),
(10750, 'NEW MOHMAND CONSTRUCTION & GENERAL ORDER SUPPLIER', 'pakdoha001@gmail.com', '0301-5757298', '21402-1769995-1', 'SAMIN KHAN	', 'PAGAL KORE P.O GHALLANAI KHAS, TEHSIL HALIMZAI\r\n', 'MOHMAND AGENCY', 'C5 /25657', 'PK-C-5', 'PK-C-5', '2140217699951', '4231117-9', NULL, 'no', 'CNIC-95141373.jpeg', NULL, 'FBR-44d93443.jpeg', 'KIPRA-10686d77.jpeg', 'PEC2020-7647c7dd.jpeg', '', '', 'no', 0, 0, '2021-09-27 00:09:18', '2024-08-19 08:07:01'),
(10752, 'MASTKHEL ENTERPRISES', 'faridgov249@gmail.com', '0300-5777257', '15303-1163251-1', 'Farid Ullah', 'STUDENT COMPOSING NEAR NBP BANK TIMERGARA DISTT: DIR LOWER', 'Dir Lower', 'C5/23252', 'PK-C-5', 'PK-C-5', '3321081', '3321304', NULL, 'no', 'CNIC-44a08738.jpeg', NULL, 'FBR-f83737fe.jpeg', 'KIPRA-cea21394.jpeg', 'PEC2020-68562a4f.jpeg', 'Form-H-45eeab02.jpeg', 'PE-633a3f40.jpeg', 'no', 0, 0, '2021-09-28 05:09:27', '2024-08-19 08:07:01'),
(10755, 'AL-ZIA & CO', 'khankhang805@gmail.com', '0334-6693575', '12201-9687117-7', 'MUHAMMAD ZIAULLHAQ	', '1, ASHIANA -II, DIYAL ROAD\r\n', 'DERA ISMAIL KHAN', 'C5 /23688', 'PK-C-5', 'PK-C-5', '1220196871177', 'K7220037-3', NULL, 'no', 'CNIC-6af8e189.jpeg', NULL, 'FBR-3815c98a.jpeg', 'KIPRA-64323474.jpeg', 'PEC2020-225a6933.jpeg', '', '', 'no', 0, 0, '2021-09-28 00:09:43', '2024-08-19 08:07:01'),
(10757, 'M/S  Azmat Khan Govt. Contractor', 'azmatkhankpk1@gmail.com', '0313-0108370', '17301-1018201-8', 'Azmat Khan', 'Moh: Hassanzai Deh Bahadar P.O Deh Bahadar District Peshawar', 'Peshawar', '24935', 'PK-C-5', 'PK-C-5', '7218010-1', '7218010-1', NULL, 'no', 'CNIC-04c6cce2.jpeg', NULL, 'FBR-af1b6933.jpeg', 'KIPRA-3f8c4c76.jpeg', 'PEC2020-77994fb3.jpeg', '', '', 'no', 0, 0, '2021-09-29 01:09:21', '2024-08-19 08:07:01'),
(10758, 'M/s MUHAMMAD NAWAZ JALBAI', 'muhammadnawaz2415@gmail.com', '0301-3016508', '16201-6041474-7', 'Muhammad Nawaz', 'VILLAGE & P.O JALBAI TEHSIL CHOTA LAHORE DISTRICT SWABI ', 'Swabi', 'C5-24532', 'PK-C-5', 'PK-C-5', '3642178-2', 'K3642178-2', NULL, 'no', 'CNIC-9d1086bc.jpeg', NULL, 'FBR-d22e018c.jpeg', 'KIPRA-d3d6aec0.jpeg', 'PEC2020-acae307a.jpeg', '', '', 'no', 0, 0, '2021-09-29 01:09:07', '2024-08-19 08:07:01'),
(10759, 'MS iftikhar wadood builders', 'engr.iftikhar566@gmail.com', '03349352894', '1560244352667', 'Iftikhar wadood', 'Mohallah zamarod kan near shinwari masjid mingora swat', 'Swat', 'Civil/50362', 'PK-C-5', 'PK-C-5', '1560244354667', '1560244354667', NULL, 'no', 'CNIC-1925e013.jpeg', NULL, 'FBR-f098faf3.jpeg', 'KIPRA-1dbd96f1.jpeg', 'PEC2020-9c10cb45.jpeg', '', '', 'no', 0, 0, '2021-09-29 05:09:17', '2024-08-19 08:07:01'),
(10760, 'M/s MEHAR JAN KHEL CONSTRUCTION CO.', 'javed.sruwapda@gmail.com', '0344-9446660', '13403-0159095-3', 'MASHOOQ UR REHMAN', 'P.O MANKHAR PATTAN DISTT. Kohistan', 'Kohistan', '23070', 'PK-C-5', 'PK-C-5', '7500732-6', 'K7500732-6', NULL, 'no', 'CNIC-93e95715.jpeg', NULL, 'FBR-b6cd3f05.jpeg', 'KIPRA-8917b285.jpeg', 'PEC2020-40e39188.jpeg', '', 'PE-e00a309f.jpeg', 'no', 0, 0, '2021-09-29 06:09:42', '2024-08-19 08:07:01'),
(10761, 'M/s JAMEEL MUHAMMAD', 'jamilsalar1524@gmail.com', '0345-9514981', '15501-2242282-5', 'Jameel Muhammad', 'VILL ZARA DHARI TEH ALPURI DISTT: Shangla', 'Shangla', '23401', 'PK-C-5', 'PK-C-5', '3194221-7', 'K3194221-7', NULL, 'no', 'CNIC-a993cec8.jpeg', NULL, 'FBR-3ede15da.jpeg', 'KIPRA-0b978035.jpeg', 'PEC2020-2824677d.jpeg', '', '', 'no', 0, 0, '2021-09-29 07:09:11', '2024-08-19 08:07:01'),
(10762, 'M/s Mohmand builders now goes to M/s Mohmand builders private limited ', 'Mohmand.builders@yahoo', '0330-9331137', '17301-0756382-1', 'Fazle Qadir ', 'Village post office zarif kor, District Peshawar ', 'Peshawar ', '3496', 'PK-C-2', 'PK-C-2', '1426681-4', 'K1426681-4', NULL, 'no', 'CNIC-1654b696.jpeg', NULL, 'FBR-1d2e09cc.jpeg', 'KIPRA-68ed62be.jpeg', 'PEC2020-7d16e09e.jpeg', 'Form-H-962cf5fb.jpeg', 'PE-ae149512.jpeg', 'no', 0, 0, '2021-09-28 22:09:10', '2024-08-19 08:07:01'),
(10763, 'Aryan Land Linkers & Contractors Pvt Ltd', 'info@aryanldc.com', '0333-5257075', '37405-0593348-7', 'Abid Hussain Khokhar', 'Office # 1, Opposite Gate # 3, NUST, University Main AD Double Road H-13 Islamabad.', 'Haripur', '268', 'PK-C-A', 'PK-C-A', '7199245-1', 'K7199245-1', NULL, 'no', 'CNIC-5db9a879.jpeg', NULL, 'FBR-d8310938.jpeg', 'KIPRA-81ec8bde.jpeg', 'PEC2020-fdb152ed.jpeg', '', '', 'no', 0, 0, '2021-09-28 23:09:36', '2024-08-19 08:07:01'),
(10764, 'M/S Haroon Ur Rashid', 'haroon.rashid_sapac@yahoo.com', '0316-0852816', '13302-7351603-7', 'Haroon Ur Rashid', 'House # 83, V.P.O. Gudwalian, Teh & Distt. Haripur.', 'Haripur', '67051', 'PK-C-6', 'PK-C-6', '7383155-5', 'K7383155-5', NULL, 'no', 'CNIC-d05bb1a7.jpeg', NULL, 'FBR-8c5f47b6.jpeg', 'KIPRA-e3aa7d2f.jpeg', 'PEC2020-24faebb9.jpeg', '', '', 'no', 0, 0, '2021-09-28 23:09:02', '2024-08-19 08:07:01'),
(10765, 'Zaheer-Ud-Din Babar ', 'abbottabadzaheeruddinbaba@gmail.com', '0311-9443900', '13101-0976951-7', 'Zaheer ud Din Babar ', 'House No 255, Moh. Khola Kehal, Abbottabad', 'Abbottabad', '19135', 'PK-C-5', 'PK-C-5', '2569431-6', 'K-2053208-3', NULL, 'no', 'CNIC-c259b2d0.jpeg', NULL, 'FBR-af57483e.jpeg', 'KIPRA-ad416fb4.jpeg', 'PEC2020-480af573.jpeg', '', '', 'no', 0, 0, '2021-09-30 02:09:46', '2024-08-19 08:07:01'),
(10766, 'Zaheer-Ud-Din Babar ', 'abbottabadzaheeruddinbabar@gmail.com', '0315-5319509', '13101-0976951-7', 'Zaheer ud Din Babar ', 'House No 225, Moh. Khola Kehal Abbottabad', 'Abbottabad', '19135', 'PK-C-5', 'PK-C-5', '1310109769517', 'K-2053208-3', NULL, 'no', 'CNIC-4468497c.jpeg', NULL, 'FBR-1aa5ae09.jpeg', 'KIPRA-f6212141.jpeg', 'PEC2020-0c792300.jpeg', '', '', 'no', 0, 0, '2021-09-30 02:09:10', '2024-08-19 08:07:01'),
(10768, 'Ms Azmeerandco', 'usman.aus09@gmail.com', '0317-6000511', '13101-6500647-5', 'awaisfarooq', 'murre road illama iqbal cloney joganstreetno3 basit general store abbottabad', 'abbottabad', '76444', 'PK-C-6', 'PK-C-6', '49437106', '49437106', NULL, 'no', 'CNIC-0e8a370c.jpeg', NULL, 'FBR-808fa81a.jpeg', 'KIPRA-f8e51801.jpeg', 'PEC2020-37913074.jpeg', '', '', 'no', 0, 0, '2021-09-30 00:09:03', '2024-08-19 08:07:01'),
(10770, 'M/S MIAN GUL & CO', 'Miangul&con@gmail.com', '0314-9097842', '21201-6128245-5', 'Mian Gul', 'BARA COMMERCIAL PLAZA INDUSTRIAL ESTATE SHOP COMPERITY & GENERAL STORE PESHAWAR', 'Peshawar', '24463', 'PK-C-5', 'PK-C-5', '72288922', 'K72288922', NULL, 'no', 'CNIC-790248c6.jpeg', NULL, 'FBR-3393a0f0.jpeg', 'KIPRA-dcf3a6a8.jpeg', 'PEC2020-58baafc2.jpeg', '', '', 'no', 0, 0, '2021-10-01 03:10:59', '2024-08-19 08:07:01'),
(10772, 'M/s FAZAL ELAHI KAKA KHEL CONSTRUCTION CO', 'fazalelahi2415@gmail.com', '0303-2229899', '16201-6976798-5', 'Fazal Elahi', 'MOHALLAH ZAREEN ABAD POST OFFICE SARD CHEENA, TEHSIL LAHOR, DISTRICT SWABI ', 'Swabi', 'C5-25439', 'PK-C-5', 'PK-C-5', '7374702-3', 'K7374702-3', NULL, 'no', 'CNIC-8e635d35.jpeg', NULL, 'FBR-c2d06ada.jpeg', 'KIPRA-f433a6df.jpeg', 'PEC2020-861d29e9.jpeg', '', '', 'no', 0, 0, '2021-10-03 23:10:26', '2024-08-19 08:07:01'),
(10774, 'Manahil engineering & Construction', 'Engr_fakher@yahoo.com', '03348687522', '1420357387187', 'Fakhr e Azam', 'Mohalla Behram Abad near Malak Sohbat khan Par, Tehsil & District Kohat', 'Karak', '7262', 'PK-C-3', 'PK-C-3', '5000365-1', 'K5000365-1', NULL, 'no', 'CNIC-80b8b1f8.jpeg', NULL, 'FBR-2afb6346.jpeg', 'KIPRA-110e56cd.jpeg', 'PEC2020-91942f5d.jpeg', '', 'PE-333b7fab.jpeg', 'no', 0, 0, '2021-10-04 06:10:46', '2024-08-19 08:07:01'),
(10775, 'Smart Green Builders', 'nasirjanjj@gmail.com', '0333-9969656', '12101-7451644-9', 'Muhammad Nasir Jan', 'Fort Road Nawaz Lane D.I.Khan', 'Dera Ismail Khan', '14877', 'PK-C-4', 'PK-C-4', '0811475-7', 'K0811475-7', NULL, 'no', 'CNIC-9696bd26.jpeg', NULL, 'FBR-3653d261.jpeg', 'KIPRA-865f6ff8.jpeg', 'PEC2020-7775b4c2.jpeg', '', '', 'no', 0, 0, '2021-10-04 07:10:49', '2024-08-19 08:07:01'),
(10776, 'UBAID BUILDERS & CONSTRUCTION ', 'ubaidbuilders@gmail.com', '0334-0507275', '21505-2469804-1', 'Ubaid Ullah Khan ', 'Nizam Ud Din Plaza, Mir Ali Bazaar Tehsil Road North Waziristan', 'North Waziristan Agency', '1598', 'PK-C-1', 'PK-C-1', '5173049-2', 'K-5173049-2', NULL, 'no', 'CNIC-6aad2531.jpeg', NULL, 'FBR-642f9b31.jpeg', 'KIPRA-863e26fa.jpeg', 'PEC2020-1c3de3e5.jpeg', '', '', 'no', 0, 0, '2021-10-04 07:10:25', '2024-08-19 08:07:01'),
(10777, 'Gravity Gumption Works (SMC-Private) Limited', 'Abbassi333@gmail.com', '0334-5885588', '13302-2002561-3', 'Sajid Ali.', 'Office # 4, Chodhry Iftekhar Plaza Civil Courts, G.T. Road Haripur.', 'Haripur', '24411', 'PK-C-5', 'PK-C-5', '4564387', 'K4564387-1', NULL, 'no', 'CNIC-9ebd8f65.jpeg', NULL, 'FBR-9d03a11c.jpeg', 'KIPRA-e6f8cc49.jpeg', 'PEC2020-d52183de.jpeg', '', '', 'no', 0, 0, '2021-10-03 21:10:18', '2024-08-19 08:07:01'),
(10779, 'JSK Technologies (Pvt) Ltd', 'jehangirfazil@gmail.com', '0343-1804085', '16202-2170575-1', 'Jahangir fazil', 'kalukhan', 'swabi', '76493 C6/E', 'PK-C-6', 'PK-C-6', '8019720', '0164683', NULL, 'no', 'CNIC-c6812671.jpeg', NULL, '', 'KIPRA-1251c633.jpeg', 'PEC2020-cba5e95a.jpeg', '', '', 'no', 0, 0, '2021-10-04 23:10:27', '2024-08-19 08:07:01'),
(10780, 'KAYI (IYI) CONSTRUCTION COMPANY', 'na@gmail.com', '1251-2325555', '1730175615213', 'MUHAMMAD TAHIR HASSAN SHAH	', 'VILL: & P/O DAGG PAJAGAI ROAD,\r\n', 'Peshawar', '76443', 'PK-C-6', 'PK-C-6', '1730175615213', 'K8297992-1	', NULL, 'no', 'CNIC-63e668f1.jpeg', NULL, 'FBR-9775729b.jpeg', 'KIPRA-58bc8a29.jpeg', 'PEC2020-d820b53c.jpeg', '', '', 'no', 0, 0, '2021-10-05 01:10:45', '2024-08-19 08:07:01'),
(10781, 'M/s Ijaz Shah', 'ijazshahcb@gmail.com', '0347-9561792', '13501-1348634-9', 'Ijaz Hussain Shah', 'Office No 4,2nd Floor Block -H Mascow Palza Jinnah Avenue Blue Area Islamabad', 'Abbottabad', '15675', 'PK-C-4', 'PK-C-4', '3675756-0', '3675756-0', NULL, 'no', 'CNIC-05ee7711.jpeg', NULL, 'FBR-9cd0e50a.jpeg', 'KIPRA-764d6d2d.jpeg', 'PEC2020-0827d734.jpeg', '', 'PE-580a4904.jpeg', 'no', 0, 0, '2021-10-05 02:10:28', '2024-08-19 08:07:01'),
(10782, 'Itehad Builders', 'gulzarhabib.pk@gmail.com', '0332-5552619', '13302-0500238-9', 'Gulzar Ahmad', 'Babu Chowk, Sector # 1, Khalabat Town Ship, Haripur.', 'Haripur', '24563', 'PK-C-6', 'PK-C-6', '2898355-6', 'K2898355-6', NULL, 'no', 'CNIC-855549fe.jpeg', NULL, 'FBR-e969d78a.jpeg', 'KIPRA-303a80ac.jpeg', 'PEC2020-4f001d43.jpeg', '', '', 'no', 0, 0, '2021-10-05 03:10:52', '2024-08-19 08:07:01'),
(10783, 'M/s Made khail construction company', 'Muhammadqasim15501@gmail.com', '0346-7055571', '15501-2258308-7', 'Muhammad qasim', 'Village ranial post office karora tehsil alpurai district shangla', 'Shangla', '23050', 'PK-C-5', 'PK-C-5', '1550122583087', 'K3652645-2', NULL, 'no', 'CNIC-b43d601c.jpeg', NULL, 'FBR-410cbac1.jpeg', 'KIPRA-385df287.jpeg', 'PEC2020-2d219a2e.jpeg', '', '', 'no', 0, 0, '2021-10-05 03:10:44', '2024-08-19 08:07:01'),
(10784, 'The 3C Enterprise', 'shahidjamalshah@gmail.com', '0343-9056897', '13302-1290021-9', 'Shaid Jamal Shah', 'House No. 05/1D, MES Road Makka Street Habibullah Colony District Abbottabad', 'Abbottabad ', 'C4/E-13219', 'PK-C-4', 'PK-C-4', '0336706-1', 'K-0336706-1', NULL, 'no', 'CNIC-833cded8.jpeg', NULL, 'FBR-7b646685.jpeg', 'KIPRA-a6465200.jpeg', 'PEC2020-b98530ec.jpeg', '', '', 'no', 0, 0, '2021-10-05 05:10:24', '2024-08-19 08:07:01'),
(10786, 'AL SYED & CO', 'ABC@PEC.ORG.PK', '0312-7894563', '13501-7667074-1', 'SYED WASIF ALI SHAH	', 'C/O.AFFRIDI GENERAL STORE DHOKE GUJRAN MISRIAL ROAD\r\n', 'Rawalpindi', 'C4 /14569', 'PK-C-4', 'PK-C-4', '1350176670741', 'K7191153-0', NULL, 'no', 'CNIC-a8eb68b9.jpeg', NULL, 'FBR-fa668a7f.jpeg', 'KIPRA-0536f7c3.jpeg', 'PEC2020-6b647be8.jpeg', '', '', 'no', 0, 0, '2021-10-05 00:10:57', '2024-08-19 08:07:01'),
(10787, 'SHAH REHMAN UTMANI CONSTRUCTION CO', 'shahrahman972@gmail.com', '0341-2656789', '21106-5178282-7', 'SHAH RAHMAN	', 'BEHRAM POR KOKA P.O.KHAR TEH.SALARZAI\r\n', 'BAJAUR AGENCY', 'C5 /22209', 'PK-C-5', 'PK-C-5', '2110651782827', 'K5393415-3', NULL, 'no', 'CNIC-0720610a.jpeg', NULL, 'FBR-c579fae0.jpeg', 'KIPRA-5c058c0a.jpeg', 'PEC2020-dd2d3de8.jpeg', '', 'PE-d7819618.jpeg', 'no', 0, 0, '2021-10-05 00:10:05', '2024-08-19 08:07:01'),
(10788, 'Dilawar Khan D.K.G', 'na@gmail.com', '0345-897587', '21104-4632359-3', 'Dilawar Khan', 'abbottabad', 'Bajaur', '7504', 'PK-C-3', 'PK-C-3', '21104-4632359-3', '40831965', NULL, 'no', 'CNIC-816c2656.jpeg', NULL, 'FBR-dc5bad22.jpeg', 'KIPRA-e5d75837.jpeg', 'PEC2020-d24034ee.jpeg', '', '', 'no', 0, 0, '2021-10-06 02:10:21', '2024-08-19 08:07:01'),
(10789, 'MUHAMMAD IQBAL AND CO. SHAH WAZIR GUL', 'na@gmail.com', '0354-8798733', '17301-9718959-9', 'MUHAMMAD IQBAL', 'Peshawar', 'Peshawar', '	C4 /15763', 'PK-C-4', 'PK-C-4', '17301-9718959-9', '3667296-3', NULL, 'no', 'CNIC-8b44a835.jpeg', NULL, 'FBR-a0dc05e8.jpeg', 'KIPRA-567a22d0.jpeg', 'PEC2020-070c12e9.jpeg', '', '', 'no', 0, 0, '2021-10-06 03:10:25', '2024-08-19 08:07:01'),
(10790, 'MUHAMMAD ZESHAN & CO', 'na@gmail.com', '0954-8741430', '17301-0710657-9', '	Muhammad Zeshan', 'Peshawar', 'pESHAWAR', 'C5 /24843', 'PK-C-5', 'PK-C-5', '17301-0710657-9', '17301-0710657-9', NULL, 'no', 'CNIC-a3916602.jpeg', NULL, 'FBR-ab3735f1.jpeg', 'KIPRA-9e4008a2.jpeg', 'PEC2020-cdb99f30.jpeg', '', '', 'no', 0, 0, '2021-10-06 03:10:24', '2024-08-19 08:07:01'),
(10791, 'M/s SARKAR CONSTRUCTION COMPANY', 'auk9606159@gmail.com', '0314-9606159', '11201-7072278-5', 'Asif Ullah Khan', 'MOHALLA SHABA KHKEL, DAULAT TAJAZAI, P/O TAJAZAI TEHSIL & DISTRICT LAKKI MARWAT LAKKI MARWAT', 'Lakki Marwat', '25387', 'PK-C-5', 'PK-C-5', '8257616', 'K8257616-8', NULL, 'no', 'CNIC-e3f0bf25.jpeg', NULL, 'FBR-7410e772.jpeg', 'KIPRA-a02ba371.jpeg', 'PEC2020-1c8f2eef.jpeg', 'Form-H-224a572d.jpeg', '', 'no', 0, 0, '2021-10-06 04:10:22', '2024-08-19 08:07:01'),
(10792, 'M/S Mashallah Construction Company ', 'shermuhammad9044675@gmail.com', '0345-9524105', '15602-3676834-3', 'Sher Muhammad', 'Qalagy Tehsil Kabal Swat', 'Swat', '23239', 'PK-C-5', 'PK-C-5', 'KA294138-0', 'KA294138-0', NULL, 'no', 'CNIC-19605266.jpeg', NULL, 'FBR-c2bcea77.jpeg', 'KIPRA-9ee0018c.jpeg', 'PEC2020-0c376cd1.jpeg', '', '', 'no', 0, 0, '2021-10-06 04:10:38', '2024-08-19 08:07:01'),
(10794, 'AAZAN IU ENGINEERING SERVICES', 'engr_mahsood@yahoo.com', '0343-8882888', '12101-4130013-1', 'UMAR MAHSOOD', 'H # 48,ST # 5,SECTOR # K-5 PHASE # 3,HAYATABAD,Peshawar, KPK, Pakistan.', 'South Waziristan AGency', '2925', 'PK-C-2', 'PK-C-2', '7312304-2', 'K7312304-2', NULL, 'no', 'CNIC-9412fdaf.jpeg', NULL, 'FBR-5d61ec72.jpeg', 'KIPRA-28cb8b69.jpeg', 'PEC2020-522052b6.jpeg', 'Form-H-d709d3e3.jpeg', 'PE-e390b4f5.jpeg', 'no', 0, 0, '2021-10-06 22:10:26', '2024-08-19 08:07:01'),
(10795, 'Al-Fatah contractors pvt ltd', 'Alfatah.acpl@gmail.com', '0307-2222555', '14203-0479430-1', 'Siraj ud din', 'Ambri killa siraj market office no 10 karak', 'Karak', '1861', 'PK-C-2', 'PK-C-2', '39078523', 'K39078523', NULL, 'no', 'CNIC-d848bc6e.jpeg', NULL, 'FBR-d0847696.jpeg', 'KIPRA-b4e36e52.jpeg', 'PEC2020-6721750d.jpeg', '', 'PE-86ca8c3d.jpeg', 'no', 0, 0, '2021-10-07 00:10:20', '2024-08-19 08:07:01'),
(10796, 'M/s SHERDAD KHEL GROUP', 'refaqzada2415@gmail.com', '0332-9426276', '16202-7350124-1', 'Refaq Zada', 'P.O, MOHALLAH PER TAB BANDA MANIRI PAYAN, SWABI', 'Swabi', 'C5-24284', 'PK-C-5', 'PK-C-5', '5172780-3', 'K5172780-3', NULL, 'no', 'CNIC-f271e5d1.jpeg', NULL, 'FBR-bca05bd8.jpeg', 'KIPRA-487e4941.jpeg', 'PEC2020-a40d4d53.jpeg', '', '', 'no', 0, 0, '2021-10-07 01:10:26', '2024-08-19 08:07:01'),
(10797, 'Zarshed Ali Khan Amazai', 'zarshidkhanpk7@gmail.com', '0345-9696085', '15101-9039630-1', 'Zarshed Ali Khna', 'Office #5, Basement Imran Plaza, Near Umania Restaurant, Muree Road, Bhara Kahu Islamabad', 'Buner', '7279', 'PK-C-3', 'PK-C-3', '7192909-1', 'K7192909-1', NULL, 'no', 'CNIC-0fafb2cd.jpeg', NULL, 'FBR-0816deba.jpeg', 'KIPRA-631fd4a5.jpeg', 'PEC2020-fb0f52c3.jpeg', '', 'PE-99b2182e.jpeg', 'no', 0, 0, '2021-10-07 01:10:07', '2024-08-19 08:07:01'),
(10798, 'M/s ZAM ZAM GOVT. CONTRUCTION COMPANY', 'afsaralikhan047@gmail.com', '0333-9696992', '90106-0102558-7', 'Afsar Ali Khan', 'MOH. CHAMLATI ELAI TEH DAGGAR DISTT. Buner', 'Buner', '7391', 'PK-C-3', 'PK-C-3', '7178039-8', 'K7178039-8', NULL, 'no', 'CNIC-33a02be8.jpeg', NULL, 'FBR-52715547.jpeg', 'KIPRA-3471edb0.jpeg', 'PEC2020-04ef8ede.jpeg', '', 'PE-9a499c77.jpeg', 'no', 0, 0, '2021-10-07 03:10:12', '2024-08-19 08:07:01'),
(10803, 'SARHAD DEVELOPERS( SMC-PRIVATE) Limited', 'a1952hussain@gmail.com', '0333-9362629', '17301-0823998-5', 'Akhtar Hussain', 'H#342 street 11 sector E-2 Phase Hayatabad Peshawar', 'Peshawar', '23187', 'PK-C-5', 'PK-C-5', '8055547-7', 'K8055547-7', NULL, 'no', 'CNIC-34672888.jpeg', NULL, '', 'KIPRA-f0ee8d1e.jpeg', 'PEC2020-dec2b232.jpeg', '', '', 'no', 0, 0, '2021-10-07 02:10:21', '2024-08-19 08:07:01'),
(10804, 'Akh government contractor ', 'Arsuhayat@mail.com', '03129000878', '21103_6278991_1', 'Muhammad ayub', 'Mir ali qila khar bajuar', 'Bajuar', '7491', 'PK-C-3', 'PK-C-3', '6962069', '2136289', NULL, 'no', 'CNIC-9989ad4b.jpeg', NULL, 'FBR-f0030ce8.jpeg', 'KIPRA-0a9a9415.jpeg', 'PEC2020-19171a4d.jpeg', '', '', 'no', 0, 0, '2021-10-07 21:10:17', '2024-08-19 08:07:01'),
(10807, 'JSK Technologies (Pvt) Ltd', 'hamza97185@gmail.com', '0343-1804085', '16202-2170575-1', 'Jahangir fazil', 'village kalu khan tehsil razzar district swabi', 'swabi', '76493 C6/E', 'PK-C-6', 'PK-C-6', '8019720', '0164683', NULL, 'no', 'CNIC-86eb97fe.jpeg', NULL, '', 'KIPRA-7aefdc8e.jpeg', 'PEC2020-65f9fe99.jpeg', '', '', 'no', 0, 0, '2021-10-10 04:10:43', '2024-08-19 08:07:01'),
(10808, 'JSK Technologies (Pvt) Ltd', 'jehangirfazil@gmail.com', '0311-2389666', '16202-2170575-1', 'Jahangir fazil', 'village kalukhan tehsil razar district swabi', 'swabi', '76493 C6/E', 'PK-C-6', 'PK-C-6', '8019720', '0164683', NULL, 'no', 'CNIC-255fefe2.jpeg', NULL, '', 'KIPRA-da7fc075.jpeg', 'PEC2020-6aeb64f9.jpeg', '', '', 'no', 0, 0, '2021-10-10 05:10:22', '2024-08-19 08:07:01'),
(10809, 'HAJI & SONS CONSTRUCTION CO', 'engrmriaz309@gmail.com', '0301-8083385', '21201-2191734-7', 'Muhammad Riaz', 'House#133, Street@14,Sector#F9,Phase#6 Hayatabad Peshawar', 'Khyber', '17918', 'PK-C-5', 'PK-C-5', '2120121917347', 'K7707921-6', NULL, 'no', 'CNIC-a9819578.jpeg', NULL, 'FBR-19f57b2a.jpeg', 'KIPRA-e84c370e.jpeg', 'PEC2020-fa3bacb1.jpeg', '', 'PE-907118a7.jpeg', 'no', 0, 0, '2021-10-10 07:10:34', '2024-08-19 08:07:01'),
(10810, 'M/s shoukat ali', 'khanofkayal@gmail.com', '03458828848', '1340340196093', 'Shoukat ali', 'Moh: muslim abadÙ« vill kheyal Teh Pattan Kohistan', 'Kohistan', '25124', 'PK-C-5', 'PK-C-5', '1340340196093', '1334096', NULL, 'no', 'CNIC-342952aa.jpeg', NULL, 'FBR-17ba0c71.jpeg', 'KIPRA-e7ceddff.jpeg', 'PEC2020-76e4df77.jpeg', '', '', 'no', 0, 0, '2021-10-11 01:10:36', '2024-08-19 08:07:01'),
(10811, 'M/S M.A KHAN & CO.', 'makhancompany928@gmail.com', '03477935001', '15602-5096537-1', 'Muhammad Abrar khan', 'Moh.kali khel bill ser THE.Char bagh distt swat', 'Swat', '14876', 'PK-C-4', 'PK-C-4', '4988556-5', '4988556-5', NULL, 'no', 'CNIC-0ebf9bfb.jpeg', NULL, 'FBR-8cee9fb9.jpeg', 'KIPRA-73f6fac3.jpeg', 'PEC2020-a1f095fd.jpeg', '', '', 'no', 0, 0, '2021-10-11 03:10:00', '2024-08-19 08:07:01'),
(10812, 'NAZIR RENEWABLE & CONSTRUCTION SERVICES', 'Nazirmuhammad64@gamil.com', '0333-9988467', '21201-1456881-1', 'NAZIR MUHAMMAD', 'KHBYBER CHOWK MALAK NOOR PLAZA MAIN BARA BAZAR KHYBER AGENCY  ', 'KHYBER AGENCY', '24416', 'PK-C-5', 'PK-C-5', '6759149_5', 'K6759149_5', NULL, 'no', 'CNIC-2ab68fa9.jpeg', NULL, 'FBR-d91d013b.jpeg', 'KIPRA-38e3da54.jpeg', 'PEC2020-f048fd87.jpeg', 'Form-H-4f2b26b3.jpeg', '', 'no', 0, 0, '2021-10-11 04:10:47', '2024-08-19 08:07:01'),
(10813, 'QUBA BUILDERS', 'fahadkhan.quba@gmail.com', '0346-2626267', '21202-2061995-3', 'Fahad Khan', 'GOUDAR KOKI KHEL,SIKANDAR KHEL, P/O JAMRUD, HAJIANO KALAY GOUGAR, TEHSIL JAMRUD KHYBER AGENCY', 'Khyber', '25049', 'PK-C-5', 'PK-C-5', '2534457-9', 'K2534457-9', NULL, 'no', 'CNIC-e3b8f517.jpeg', NULL, 'FBR-67281742.jpeg', 'KIPRA-4d937938.jpeg', 'PEC2020-18f71d04.jpeg', '', '', 'no', 0, 0, '2021-10-11 00:10:03', '2024-08-19 08:07:01'),
(10814, 'ZULFIQAR SAEED ', 'Na.@gmail.com', '03139566201', '17301-9287855-1', 'Zulfiqar saeed', 'Moh.marozai deh bahadar kohat road peashwer', 'Peshawer', '22118', 'PK-C-5', 'PK-C-5', '1730192878551', 'K7279195-4', NULL, 'no', 'CNIC-7850c56c.jpeg', NULL, 'FBR-83b5dc32.jpeg', 'KIPRA-6ce4a6cf.jpeg', 'PEC2020-eeee3b71.jpeg', '', 'PE-7d31cc0d.jpeg', 'no', 0, 0, '2021-10-12 02:10:19', '2024-08-19 08:07:01'),
(10815, 'Arshad Khan & co', 'Na.@gmail.com', '03139951775', '17301-1621897-3', 'Arshad Khan', 'Qazian shakh Muhammad I teh & distt peshawer', 'Peshawer', '21490', 'PK-C-5', 'PK-C-5', '1730116218973', 'K8995995-0', NULL, 'no', 'CNIC-839ab5cc.jpeg', NULL, 'FBR-1bdf2f8a.jpeg', 'KIPRA-babe9a92.jpeg', 'PEC2020-518f45a6.jpeg', '', 'PE-6f89c409.jpeg', 'no', 0, 0, '2021-10-12 02:10:21', '2024-08-19 08:07:01'),
(10817, 'Imran pervaiz', 'waheed2021@gmail.com', '03151517070', '1310115421131', 'Imran parvaiz', 'Village makool Bala tehsil dusty abbottabad', 'Abbottabad', '23477', 'PK-C-5', 'PK-C-5', '3092490-1', 'K3092490-1', NULL, 'no', 'CNIC-3ad18fe3.jpeg', NULL, 'FBR-ccfc8ea1.jpeg', 'KIPRA-66d4c177.jpeg', 'PEC2020-8bef09f6.jpeg', '', 'PE-8e93c94b.jpeg', 'no', 0, 0, '2021-10-12 07:10:30', '2024-08-19 08:07:01'),
(10818, 'SYED IBNE ALI SHAH', 'syedibneali123@gmail.com', '0333-9672749', '14101-0773976-7', 'SYED IBNE ALI SHAH	', 'VILL: HAJI KHEL BANDA P/O,\r\n', 'HANGU', 'C5 /25445', 'PK-C-5', 'PK-C-5', '1410107739767', 'K3349600-5', NULL, 'no', 'CNIC-32ff86c7.jpeg', NULL, 'FBR-d3136ce9.jpeg', 'KIPRA-5339c614.jpeg', 'PEC2020-fc8e10f4.jpeg', '', 'PE-6b80790e.jpeg', 'no', 0, 0, '2021-10-11 23:10:55', '2024-08-19 08:07:01'),
(10819, 'M/s KHAN BACHA DHOK', 'khanbachadhok@gmail.com', '0300-5858636', '42401-1612854-7', 'Khan Bacha', 'VILL. & P.O GAR MANARA YOUSAFI, TEHSIL & DISTRICT SWABI', 'Swabi', 'C5-25428', 'PK-C-5', 'PK-C-5', '8999327-2', 'K8999327-2', NULL, 'no', 'CNIC-56effd03.jpeg', NULL, 'FBR-b85196ff.jpeg', 'KIPRA-a108fdd9.jpeg', 'PEC2020-34dc7d8a.jpeg', '', '', 'no', 0, 0, '2021-10-13 01:10:36', '2024-08-19 08:07:01'),
(10821, 'M/S BILAL BROTHERS CONSTRUCTIONS', 'bilalbrothersconstruction@gmail.com', '0333-8885734', '21202-7619921-5', 'MUHAMMAD BILAL', 'Block No.04 Jamrud Shopping Plaza Jamrud khyber Agency Peshawar ', 'Peshawar', '24159', 'PK-C-5', 'PK-C-5', '7376924-2', 'K7376924-2', NULL, 'no', 'CNIC-853f4d4d.jpeg', NULL, 'FBR-ea385e67.jpeg', 'KIPRA-ad6613ce.jpeg', 'PEC2020-32cb695d.jpeg', '', '', 'no', 0, 0, '2021-10-13 05:10:48', '2024-08-19 08:07:01'),
(10822, 'GHULAM MUHAMMAD AND SONS SHAHNAVI', 'tajclt121@gmail.com', '0340-4040722', '15202-0815801-5', 'GHULM MUHAMMAD', 'VILL.MAROI, P.O TEHSIL AND DISTRICT CHITRAL', 'CHITRAL', '23040', 'PK-C-5', 'PK-C-5', '47496280', 'K47496280', NULL, 'no', 'CNIC-51f44d10.jpeg', NULL, 'FBR-e57fefc5.jpeg', 'KIPRA-5f900fca.jpeg', 'PEC2020-9dcd43c1.jpeg', '', '', 'no', 0, 0, '2021-10-12 21:10:31', '2024-08-19 08:07:01'),
(10824, 'BANSEER CONSTRUCTION CO', 'NA@GMAIL.COM', '0333-5033111', '13202-6550800-9', 'BADAR ALAM', 'mansehra', 'mansehra', '2862', 'PK-C-2', 'PK-C-2', '15404257', '15404257', NULL, 'no', 'CNIC-725358bb.jpeg', NULL, 'FBR-044db195.jpeg', 'KIPRA-80c3b552.jpeg', 'PEC2020-605eca78.jpeg', '', '', 'no', 0, 0, '2021-10-14 03:10:11', '2024-08-19 08:07:01'),
(10825, 'KUNHAR CONSTRUCTION CO', 'NA@GMAIL.COM', '0988-777870', '13501-0250928-7', '	KAMRAN MASOOD', 'Islamabad\r\n', 'Islamabad', '19387', 'PK-C-5', 'PK-C-5', '36537870', '36537870', NULL, 'no', 'CNIC-65e15344.jpeg', NULL, 'FBR-c1435cf5.jpeg', 'KIPRA-df6d9c00.jpeg', 'PEC2020-63aeab85.jpeg', '', '', 'no', 0, 0, '2021-10-14 04:10:53', '2024-08-19 08:07:01'),
(10826, 'M/S Haider Ali & Sons Construction Company', 'Haiderali&sonscontructioncompany@gmail.com', '0313-9944470', '17301-6214927-3', 'HAIDER ALI', 'Vill, Regi Moh: , Kandaray Peshawar ', 'Peshawar', '14327', 'PK-C-4', 'PK-C-4', '2890933-0', 'K2890933-0', NULL, 'no', 'CNIC-1753ae75.jpeg', NULL, 'FBR-2182d06c.jpeg', 'KIPRA-9d8036f3.jpeg', 'PEC2020-30c59fd9.jpeg', '', '', 'no', 0, 0, '2021-10-13 20:10:15', '2024-08-19 08:07:01'),
(10827, 'ITTEHAD CONSTRUCTION COMPANY', 'itifaqconstruction@gmail.com', '0342-1345678', '17301-5402215-3', 'HAFIZ ZIA AHMAD	', 'SUITE#1,1ST FLOOR, BILAL TOWER CITY CIRCULAR ROAD\r\n', 'Peshawar', 'C2 /389', 'PK-C-2', 'PK-C-2', '1730154022153', 'K3016393-5', NULL, 'no', 'CNIC-0403d853.jpeg', NULL, 'FBR-88cbde8a.jpeg', 'KIPRA-af788705.jpeg', 'PEC2020-5da84383.jpeg', 'Form-H-aa5b40e7.jpeg', '', 'no', 0, 0, '2021-10-13 23:10:08', '2024-08-19 08:07:01'),
(10828, 'KHAZANA CONSTRUCTION CO', 'na.@gmail.com', '0322-7867564', '15302-1696052-7', 'MUBARAK ZEB	', 'VILL. KHAZANA, TEH. MUNDA\r\n', 'DIR', 'C4 /15678', 'PK-C-4', 'PK-C-4', '1530216960527', 'K7495353-0', NULL, 'no', 'CNIC-f22b3955.jpeg', NULL, 'FBR-b367d22f.jpeg', 'KIPRA-356bc20d.jpeg', 'PEC2020-7d4494e8.jpeg', '', 'PE-032895f9.jpeg', 'no', 0, 0, '2021-10-13 23:10:18', '2024-08-19 08:07:01'),
(10831, 'Malik Nisar & Brothers Construction Company', 'maliknisarandbrothers@gmail.com', '0300-9713841', '17301-8025098-5', 'Malik Nisar', 'Al Haram Model Town A-41 Near Hayatabad Toll Plaza Ring Road Peshawar', 'Peshawar', '25032', 'PK-C-5', 'PK-C-5', '7705812-3', 'K7705812-3', NULL, 'no', 'CNIC-8f1d9d6f.jpeg', NULL, 'FBR-ee436af9.jpeg', 'KIPRA-5dc1d549.jpeg', 'PEC2020-959bad2d.jpeg', '', '', 'no', 0, 0, '2021-10-15 06:10:58', '2024-08-19 08:07:01'),
(10838, 'M/s Muhammad Gul Govt. Contractor', 'muhammadgul123@gmail.com', '0307-7184007', '21701-6589183-5', 'Muhammad Gul', 'P.O Wana Teh.Barmil, Distt. South Waziristan Waziristan Agency', 'South Waziristan', '24542', 'PK-C-5', 'PK-C-5', '7146387-0', '7146387-0', NULL, 'no', 'CNIC-d314db28.jpeg', NULL, 'FBR-e1f91c0d.jpeg', 'KIPRA-5ba3850e.jpeg', 'PEC2020-df729f3c.jpeg', '', '', 'no', 0, 0, '2021-10-17 05:10:24', '2024-08-19 08:07:01'),
(10839, 'Northwest Engineering Services Pvt Ltd', 'adnan.sahibzada@northwest.pk', '03341115523', '14101-2227730-7', 'Ashfaq Bangash', 'Peshawar', 'Peshawar', '7519', 'PK-C-3', 'PK-C-3', 'A030165-6', 'KA030165-6', NULL, 'no', 'CNIC-aac38f5f.jpeg', NULL, 'FBR-bba1cd95.jpeg', 'KIPRA-1f7e8353.jpeg', 'PEC2020-5126214b.jpeg', '', '', 'no', 0, 0, '2021-10-19 02:10:46', '2024-08-19 08:07:01'),
(10840, 'M/S SBS ASSOCIATES', 'sbs.associates333@gmail.com', '03339076541', '1710134664335', 'Syed amjid shah', 'House 370, st#B17,Sector #2,Esecutive Lodges Arbab Sabz ali khan town Warsak Road Peshawar', 'Peshawar', '23444', 'PK-C-5', 'PK-C-5', '81562814', 'K81562814', NULL, 'no', 'CNIC-8337669d.jpeg', NULL, 'FBR-86e502c9.jpeg', 'KIPRA-1a24098f.jpeg', 'PEC2020-cfcd60ee.jpeg', '', '', 'no', 0, 0, '2021-10-18 20:10:49', '2024-08-19 08:07:01'),
(10844, 'M/S TOKEER ABASS', 'toqeertoqeer932@gmail.com', '0345-9098585', '42301-3769351-5', 'TOKEER ABBAS', 'R/O NAWASHER, POST OFFICE PARHINNA, TEHSIL & DISTRICT MANSEHRA.', 'MANSEHFRA', '24652', 'PK-C-5', 'PK-C-5', '5166529-7', 'K5166529-7', NULL, 'no', 'CNIC-98e837b5.jpeg', NULL, 'FBR-c471d65d.jpeg', 'KIPRA-e93828c8.jpeg', 'PEC2020-3656681d.jpeg', '', '', 'no', 0, 0, '2021-10-20 06:10:12', '2024-08-19 08:07:01'),
(10845, 'MALIK MUNIR AHMED CONTRACTOR', 'Na.@gmail.com', '03126578957', '13503-0132461-7', 'munir ahmed', 'VILL. BASUND UC JALLU', 'Manshera', '23325', 'PK-C-5', 'PK-C-5', '7205269', 'K7205269-4', NULL, 'no', 'CNIC-add42b6e.jpeg', NULL, 'FBR-729bf16e.jpeg', 'KIPRA-2ef670e5.jpeg', 'PEC2020-7e9f164d.jpeg', '', 'PE-9911ee63.jpeg', 'no', 0, 0, '2021-10-21 00:10:25', '2024-08-19 08:07:01'),
(10847, 'Shadab & Brothers Buildercompany', 'shadabbrother72@gmail.com', '0341-2000061', '22601-1829305-9', 'Javed Iqbal', 'Pir Tangi, Jandola, District FR Tank', 'Tank', '15765', 'PK-C-4', 'PK-C-4', '4990039-3', 'K4990039-3', NULL, 'no', 'CNIC-1cb81a0a.jpeg', NULL, 'FBR-6acec1f0.jpeg', 'KIPRA-4b423600.jpeg', 'PEC2020-35f55cd1.jpeg', '', '', 'no', 0, 0, '2021-10-21 05:10:57', '2024-08-19 08:07:01'),
(10848, 'Al-Mushtaq Contractor & Supplier ', 'adnankhan3906813@gmail.com', '0333-8927373', '17301-3906813-7', 'Adnan Khan ', 'Fakhr-e-Alam Road Peshawar Cantt, Peshawar', 'Peshawar', '23178', 'PK-C-5', 'PK-C-5', '1730139068137', 'K8394865-7', NULL, 'no', 'CNIC-4066e8df.jpeg', NULL, 'FBR-46f8c2c0.jpeg', 'KIPRA-d6f8ac38.jpeg', 'PEC2020-3bef3887.jpeg', '', '', 'no', 0, 0, '2021-10-22 02:10:48', '2024-08-19 08:07:01'),
(10849, 'ABDUR RASHID & SONS', 'abdurrashidsons0345@gmail', '9234-5479706', '13503-0612558-9', 'ABDUL RASHID', 'HOUSE NO.219, STREET NO.73 OPPSITE BILAL MEHAR MASJID islamabad', 'islamabad', '22781', 'PK-C-5', 'PK-C-5', '7304458-4', 'K7304458-4', NULL, 'no', 'CNIC-56f255fa.jpeg', NULL, 'FBR-e3f973d5.jpeg', 'KIPRA-4c1b578f.jpeg', 'PEC2020-7258bc04.jpeg', 'Form-H-0b312280.jpeg', '', 'no', 0, 0, '2021-10-22 03:10:16', '2024-08-19 08:07:01'),
(10850, 'M/S IRFAN ULLAH CONSTRUCTION', 'engr_irfan160@yahoo.com', '0348-9656173', '14203-2285156-9', 'IRFAN ULLAH', 'VILLAGE,POST OFFICE & TEHSIL TAKHTI NASRATI,DISTT KARAK,KPK', 'KARAK', '13616', 'PK-C-4', 'PK-C-4', '6583196-2', 'K6583196-2', NULL, 'no', 'CNIC-288d158e.jpeg', NULL, 'FBR-69aa401c.jpeg', 'KIPRA-1b6ccab2.jpeg', 'PEC2020-cc767252.jpeg', '', 'PE-0ce54595.jpeg', 'no', 0, 0, '2021-10-22 04:10:58', '2024-08-19 08:07:01'),
(10856, 'M/s MOHAMMAD ZAHIR & BROTHERS', 'muhammadzahir450@gmail.com', '0345-9316718', '1720122186937', 'Muhammad Zahir', 'HOUSE NO.596, STREET NO.13-F GHOURI TOWN PHASE-4B Islamabad', 'islamabad', '15492', 'PK-C-4', 'PK-C-4', '2610270', 'K2610270-6', NULL, 'no', 'CNIC-d76700b4.jpeg', NULL, 'FBR-237e1769.jpeg', 'KIPRA-46e21ba9.jpeg', 'PEC2020-1a2da2c2.jpeg', '', 'PE-fbc1c75e.jpeg', 'no', 0, 0, '2021-10-26 03:10:05', '2024-08-19 08:07:01'),
(10857, 'M/S Muhammad Islam & Sons', 'sajjadyousafzai52@gmail.com', '0300-9019864', '17201-9382642-9', 'Sajjad Khan', 'Village Wattar P.O Akora Khattak District Nowshera ', 'Nowshera', '7313', 'PK-C-3', 'PK-C-3', '5026664', '50266664', NULL, 'no', 'CNIC-36338b7c.jpeg', NULL, 'FBR-633190fc.jpeg', 'KIPRA-8b6fd09d.jpeg', 'PEC2020-ec141c0a.jpeg', 'Form-H-145e075b.jpeg', 'PE-d54cc0de.jpeg', 'no', 0, 0, '2021-10-26 05:10:09', '2024-08-19 08:07:01'),
(10858, 'M/s MOHAMMAD ZAHIR & BROTHERS', 'muhammadzahir450@gmail.com', '333-9268380', '1720122186937', 'Mohammad Zahir', 'HOUSE NO.596, STREET NO.13-F GHOURI TOWN PHASE-4B Islamabad', 'islamabad', '15482', 'PK-C-4', 'PK-C-4', 'K2610270-6', 'K2610270-6', NULL, 'no', 'CNIC-4dc13de3.jpeg', NULL, 'FBR-29d68487.jpeg', 'KIPRA-33cc8480.jpeg', 'PEC2020-7c71f40a.jpeg', '', 'PE-e51712a8.jpeg', 'no', 0, 0, '2021-10-26 05:10:49', '2024-08-19 08:07:01'),
(10859, 'J S Enterprises ', 'jawadbk8600@gyahoo.com', '0335-9701082', '13302-0465684-3', 'Jawad Liaqat', 'House No. 405, Pakhral Chowk, Sector No. 2 KTS Haripur. ', 'Haripur', 'C-6/73725', 'PK-C-6', 'PK-C-6', '6573271-4', 'K-6573271-4', NULL, 'no', 'CNIC-afb1c87c.jpeg', NULL, '', 'KIPRA-9f998504.jpeg', 'PEC2020-28eb9372.jpeg', '', '', 'no', 0, 0, '2021-10-26 07:10:48', '2024-08-19 08:07:01'),
(10862, 'M/s ABDUL QADEER & SONS GOVT. CONTRACTOR', 'qadeer9988sohail@gmail.com', '0313-5632732', '13503-4016825-7', 'Sohail Qadeer', 'HOUSE NO.1874-C SECTOR I-14/3 islamabad', 'islamabad', '25637', 'PK-C-5', 'PK-C-5', 'A273218-5', 'A273218-5', NULL, 'no', 'CNIC-803626df.jpeg', NULL, 'FBR-821c4975.jpeg', 'KIPRA-2f469971.jpeg', 'PEC2020-34bfe582.jpeg', '', '', 'no', 0, 0, '2021-10-27 07:10:37', '2024-08-19 08:07:01'),
(10863, 'M/s JIK ASSOCIATES', 'jikassociates2020@gmail.com', '0303-5866660', '21106-8539108-5', 'Jawad Iqbal Khan', 'SHOP NO.06, NEW TEHSIL KHAN MARKET NEAR SABZI MANDI, MAIN MUNDA ROAD, KHAR Bajaur', 'Bajaur', '25012', 'PK-C-5', 'PK-C-5', 'A309722-5', 'A309722-5', NULL, 'no', 'CNIC-c00ee681.jpeg', NULL, 'FBR-6a0a42e6.jpeg', 'KIPRA-f99a9d1d.jpeg', 'PEC2020-e5cd5053.jpeg', '', '', 'no', 0, 0, '2021-10-27 07:10:05', '2024-08-19 08:07:01'),
(10864, 'M/s MUHAMMAD QAISAR KHAN & BROTHERS', 'mqkhanandbrothers@gmail.com', '313-8184971', '17101-4541568-3', 'Muhammad Qaisar Khan', 'VILL:SHAIKHANO KORONA P/O:UMARZAI TEH & DISTT charsadda', 'Charsadda', '25431', 'PK-C-5', 'PK-C-5', '17101-4541568-3', 'K5131589-5', NULL, 'no', 'CNIC-bca25378.jpeg', NULL, 'FBR-d554aebf.jpeg', 'KIPRA-15452c99.jpeg', 'PEC2020-65e862b5.jpeg', '', 'PE-8bccfee5.jpeg', 'no', 0, 0, '2021-10-27 07:10:36', '2024-08-19 08:07:01'),
(10865, 'M/s SYED MUNIR HUSSAIN SHAH', 'munir.shah.9560@gmail.com', '345-9620984', '1350112972247', 'Syed Munir Hussain Shah', 'AFRIDI GENERAL STORE DHOKE GUJRAN MISRIAL ROAD Rawalpindi', 'Rawalpindi', '21982', 'PK-C-5', 'PK-C-5', '3122679-9', 'K3122679-9', NULL, 'no', 'CNIC-d12f52b7.jpeg', NULL, 'FBR-c29abdb0.jpeg', 'KIPRA-cdb87ec7.jpeg', 'PEC2020-631b4c5c.jpeg', '', '', 'no', 0, 0, '2021-10-27 07:10:14', '2024-08-19 08:07:01'),
(10866, 'WARDAG BUILDERS', 'wardagbuilders@gmail.com', '0345-6523412', '15703-5238033-7', 'JAHNZEB	', 'PATRAK TEHL KALKOT KOHISTAN DISTT. UPPER\r\n', 'DIR', 'C6 /76180', 'PK-C-6', 'PK-C-6', '1570352380337', 'K6164664-6', NULL, 'no', 'CNIC-30ee9c4b.jpeg', NULL, 'FBR-793c4c87.jpeg', 'KIPRA-4e1b012c.jpeg', 'PEC2020-59af9b6e.jpeg', '', '', 'no', 0, 0, '2021-10-26 22:10:14', '2024-08-19 08:07:01'),
(10870, 'A-K Contractors', 'abidjan28@gmail.com', '03335132315', '17301-1056619-1', 'Abid ur Rehman', 'Office no 7, Ali Taj market iqra Chowk university road peshawar', 'Peshawar', '24540', 'PK-C-5', 'PK-C-5', '3968641-8', 'K3968641-8', NULL, 'no', 'CNIC-5db6572c.jpeg', NULL, 'FBR-43d90de4.jpeg', 'KIPRA-e3c77617.jpeg', 'PEC2020-620bc372.jpeg', '', '', 'no', 0, 0, '2021-10-28 00:10:59', '2024-08-19 08:07:01'),
(10871, 'GENERAL ELECTRONE', 'Taj607542@gmail.com', '03357990900', '21505-2983319-5', 'Dost mohammad', 'SHOP#2092, MOLVI , HUSSAN STREET SADDAR, RAWALPINDI CANTT', 'Rawalpindi', '7012', 'PK-C-4', 'PK-C-4', '5300065', 'K5300065-1', NULL, 'no', 'CNIC-9ea3618b.jpeg', NULL, 'FBR-3fbce160.jpeg', 'KIPRA-5907cb50.jpeg', 'PEC2020-8d31aa2e.jpeg', 'Form-H-5e251da6.jpeg', '', 'no', 0, 0, '2021-10-28 01:10:37', '2024-08-19 08:07:01'),
(10872, 'New Al Haseeb Construction Co', 'Mohammadhaseebk971@gmail.com', '0346-9418578', '15101-9562731-9', 'Muhammad Haseeb Khan ', 'Vill:Hissar, Tehsil Daggar, District Buner', 'Buner', '24915', 'PK-C-5', 'PK-C-5', '4933496-7', 'K4933496-7', NULL, 'no', 'CNIC-d0bb4c0a.jpeg', NULL, 'FBR-a40c80c6.jpeg', 'KIPRA-ff87fd62.jpeg', 'PEC2020-00d2643f.jpeg', '', '', 'no', 0, 0, '2021-10-28 02:10:46', '2024-08-19 08:07:01'),
(10873, 'HHA Construction ', 'hazrat.usman41178@gmail.com', '0333-7640937', '17201-3613816-3', 'Hidayat Ali ', 'Hakim Abad, Dheri Kati Khel, District Nowshehra', 'Nowshehra', '76376', 'PK-C-6', 'PK-C-6', '4270896-6', 'K4270896-6', NULL, 'no', 'CNIC-c74979b4.jpeg', NULL, 'FBR-2d6aa769.jpeg', 'KIPRA-fefea886.jpeg', 'PEC2020-25c5b0ab.jpeg', '', '', 'no', 0, 0, '2021-10-28 04:10:41', '2024-08-19 08:07:01'),
(10880, 'Metron  Techology International (Pvt) ltd', 'Kazmi@metronintl.com', '030284855822', '35202-3484032-5', 'Muhammad Adana ', '333-B IQbal Avenue Shoukat khanum khayaban E- jinnah Lahore', 'Lahore', '268', 'PK-C-B', 'PK-C-B', '8965654-7', 'k8965654-7', NULL, 'no', 'CNIC-30b6fb2f.jpeg', NULL, 'FBR-984a1d19.jpeg', 'KIPRA-600738d8.jpeg', 'PEC2020-b0ccc0f1.jpeg', 'Form-H-1e6e81ef.jpeg', '', 'no', 0, 0, '2021-10-28 21:10:55', '2024-08-19 08:07:01'),
(10881, 'M/S BAHADAR KHAN', 'kb45882@gmail.com', '0301-5641331', '22601-4236311-9', 'BAHADAR KHAN', 'ANJAM ABAD COLONY MULTAN ROAD DERA ISMAIL KHAN', 'FR TANK', 'C3/6488', 'PK-C-3', 'PK-C-3', '2260142363119', 'K42211390-8', NULL, 'no', 'CNIC-15d2d401.jpeg', NULL, 'FBR-efd75ee5.jpeg', 'KIPRA-995b5568.jpeg', 'PEC2020-c4374afd.jpeg', '', '', 'no', 0, 0, '2021-10-30 00:10:22', '2024-08-19 08:07:01'),
(10883, 'Unimix', 'Kashankaleem@unimix.com.pk', '03224442785', '3520229487881', 'Kaleem Ahad', 'Lahore', 'Lahore', '7534', 'PK-C-3', 'PK-C-3', '2181692-1', 'K2181692-1', NULL, 'no', 'CNIC-25911c70.jpeg', NULL, 'FBR-43a16fe0.jpeg', 'KIPRA-e32b88a1.jpeg', 'PEC2020-d9855f65.jpeg', '', '', 'no', 0, 0, '2021-10-30 02:10:00', '2024-08-19 08:07:01'),
(10885, 'New Al Haseeb Construction Co', 'Mohammadhaseebk971@gmail.com', '0333-9696578', '15101-9562731-9', 'Muhammad Haseeb Khan ', 'Village Hissar, Tehsil Daggar, District Buner', 'BUNER', '24915', 'PK-C-5', 'PK-C-5', '49334967-7', 'K4933496-7', NULL, 'no', 'CNIC-ef84443b.jpeg', NULL, 'FBR-08fcb9ef.jpeg', 'KIPRA-9354d4b6.jpeg', 'PEC2020-f5aab249.jpeg', '', '', 'no', 0, 0, '2021-11-01 04:11:26', '2024-08-19 08:07:01'),
(10887, 'M/S Shamsul Arifeen', 'fayazkhails@gmail.com', '0333-9378959', '17301-1483027-5', 'Shamsul Arifeen', 'Village Maghdarzai Mohallah Kandy Payan P.O University of Peshawar', 'Peshawar', '24314', 'PK-C-5', 'PK-C-5', '2632864-0', 'K2632864-0', NULL, 'no', 'CNIC-834de350.jpeg', NULL, 'FBR-8c33c40d.jpeg', 'KIPRA-9669e9a3.jpeg', 'PEC2020-d23bea94.jpeg', '', 'PE-6860c48d.jpeg', 'no', 0, 0, '2021-11-02 01:11:37', '2024-08-19 08:07:01'),
(10888, 'M/s ACS TRADERS', 'acstraderspk@gmail.com', '0345-9343217', '16102-1116363-5', 'Namoos Khan', 'NEAR SEHAT MEDICOS MA IN MALAKAND ROAD TAKHT BHAI DISTT: Mardan', 'Mardan', '14612', 'PK-C-4', 'PK-C-4', '8350091', 'K8350091-8', NULL, 'no', 'CNIC-b35ddb43.jpeg', NULL, 'FBR-5966f09d.jpeg', 'KIPRA-527164f5.jpeg', 'PEC2020-44e528e4.jpeg', 'Form-H-e1022575.jpeg', '', 'no', 0, 0, '2021-11-02 05:11:53', '2024-08-19 08:07:01'),
(10891, 'Gul Anwar & Co.', 'gulanwarandco@gmail.com', '0300-8583580', '17301-1647401-3', 'Gul Anwar', 'H#29, St#3, Haji Town, Pajjaggi Road, Bashirabad, Peshawar', 'Peshawar', 'C2-1766', 'PK-C-2', 'PK-C-2', '13481681', 'K13481681', NULL, 'no', 'CNIC-a2b8d742.jpeg', NULL, 'FBR-d75c2f30.png', 'KIPRA-68edea1e.png', 'PEC2020-895525cf.jpeg', '', '', 'no', 0, 0, '2021-11-01 21:11:17', '2024-08-19 08:07:01');
INSERT INTO `contractor_registrations` (`id`, `contractor_name`, `email`, `mobile_number`, `cnic`, `district`, `address`, `pec_number`, `owner_name`, `category_applied`, `pec_category`, `fbr_ntn`, `kpra_reg_no`, `pre_enlistment`, `is_limited`, `cnic_front_attachment`, `cnic_back_attachment`, `fbr_attachment`, `kpra_attachment`, `pec_attachment`, `form_h_attachment`, `pre_enlistment_attachment`, `is_agreed`, `defer_status`, `approval_status`, `created_at`, `updated_at`) VALUES
(10893, 'MUHAMMAD SIRAJ C.C', 'sk5735748@gmail.com', '0348-9884029', '13101-9279141-5', 'Muhammad Siraj', 'KALAPUL MURREE ROAD, MUHALLAH SEHRI ABBOTTABAD\r\n', 'Abbottabad', '20023', 'PK-C-5', 'PK-C-5', '6281467-7', 'K6281467-7', NULL, 'no', 'CNIC-4b1cc3e3.jpeg', NULL, 'FBR-a872ab33.jpeg', 'KIPRA-b92bc860.jpeg', 'PEC2020-27954e2f.jpeg', 'Form-H-1235f01d.jpeg', 'PE-de40068b.jpeg', 'no', 0, 0, '2021-11-03 02:11:16', '2024-08-19 08:07:01'),
(10894, 'JEHANZEB AFRIDI', 'Na.@gmail.com', '03142612789', '173012-293219-3', 'JEHANZEB AFRIDI', 'P/O OFFICE BARA , NALA, KAJOORI TEHSIL BARA DISTRIC KHYBER . KHYBER AGENCY', 'KHYBER', '7536', 'PK-C-3', 'PK-C-3', '1730122932193', 'K7504738-7', NULL, 'no', 'CNIC-f5aff388.jpeg', NULL, 'FBR-ac783872.jpeg', 'KIPRA-bf4f761d.jpeg', 'PEC2020-2ab426a7.jpeg', '', 'PE-96caf6d0.jpeg', 'no', 0, 0, '2021-11-04 01:11:28', '2024-08-19 08:07:01'),
(10896, 'SARAN ZEB AND BROTHERS ', 'Na.@gmail.com', '03167895427', '13403-3664618-7', 'SARAN ZEB', 'OFFICE NO.4-C IST FLOOR MAHMOOD PLAZA FAZAL-E-HAQ ROAD BLUE AREA ISLAMABAD', 'Islamabad', '25719', 'PK-C-5', 'PK-C-5', '1340336646187', 'K4982851-6', NULL, 'no', 'CNIC-90a31d78.jpeg', NULL, 'FBR-fad02f51.jpeg', 'KIPRA-b3267c2d.jpeg', 'PEC2020-563614fa.jpeg', '', '', 'no', 0, 0, '2021-11-04 05:11:32', '2024-08-19 08:07:01'),
(10899, 'Green Edge Engineering (Pvt.) Ltd', 'green.edge99@gmail.com', '0333-4446498', '17301-8646389-1', 'Saif Ullah', 'National Machinery Corporation\r\n1067/A, Saddar Road Peshawar Cantt', 'Peshawar', '14272', 'PK-C-4', 'PK-C-4', '0112652', 'K7623205-7', NULL, 'no', 'CNIC-d3f14a3f.jpeg', NULL, 'FBR-1cfd9b7d.jpeg', 'KIPRA-ebb135f7.jpeg', 'PEC2020-d886bad5.jpeg', 'Form-H-dc5fff1b.jpeg', 'PE-bc4655da.jpeg', 'no', 0, 0, '2021-11-08 02:11:42', '2024-08-19 08:07:01'),
(10900, 'M/S Jahaan Development Association LLP', 'jahaan.devpt@gmail.com', '0313-9708603', '17301-1233325-7', 'Abdul Wakeel', 'House No. 247, Street No.16, New Shami Road Peshawar', 'Peshawar', '3529', 'PK-C-2', 'PK-C-2', '1290980-7', 'K1290980-7', NULL, 'no', 'CNIC-27ae79af.jpeg', NULL, 'FBR-6e544a65.jpeg', 'KIPRA-42078177.jpeg', 'PEC2020-620e74df.jpeg', '', 'PE-42487a95.jpeg', 'no', 1, 0, '2021-11-08 06:11:36', '2024-08-28 09:07:21'),
(10902, 'M/S Integrated Techno Services (Pvt) Ltd', 'its.pvtltd786@gmail.com', '0345-9022776', '11201-1057183-9', 'Ibrahim Khan', 'H.No 161, Street 5, Sector F-2, Phase-6, Hayatabad, Peshawar', 'Peshawar', '6348', 'PK-C-3', 'PK-C-3', '7371455', 'k7371455', NULL, 'no', 'CNIC-eb318852.jpeg', NULL, 'FBR-12771541.jpeg', 'KIPRA-be27b0c8.jpeg', 'PEC2020-0e3e567b.jpeg', 'Form-H-a054a6af.jpeg', 'PE-bda44ea2.jpeg', 'no', 0, 0, '2021-11-07 21:11:10', '2024-08-19 08:07:01'),
(10903, 'Balouch Construction Company (BCC)', 'balouchconstructioncompany143@gmail.com', '0335-9404095', '17301-0105976-3', 'Saddam Ijaz', 'PO Pakha GHulam Ghari Balouch Abad Hujra Ijaz Khan Near Govt Primary School Peshawar', 'Peshawar', '26272', 'PK-C-5', 'PK-C-5', '8985520', 'K8985520-1', NULL, 'no', 'CNIC-0c6b9ddb.jpeg', NULL, 'FBR-1ac7fd4e.jpeg', 'KIPRA-bc24969e.jpeg', 'PEC2020-f9e4dc9f.jpeg', 'Form-H-1064ebd7.jpeg', '', 'no', 0, 1, '2021-11-09 04:11:29', '2024-08-26 03:55:22'),
(10904, 'MUHAMMAD KHALIQ', 'khaliq5288@gmail.com', '0333-8885288', '15501-9136891-3', 'MUHAMMAD KHALIQ', 'Village Kotkay Tehsil Alpuri District Shangla', 'SHANGLA', '25504', 'PK-C-5', 'PK-C-5', '1550191368913', 'K4110882-5', NULL, 'no', 'CNIC-f3e449b6.jpeg', NULL, 'FBR-4febc6cd.png', 'KIPRA-b13aa45f.png', 'PEC2020-36896655.jpeg', '', '', 'no', 0, 1, '2021-11-08 20:11:07', '2024-08-26 03:55:29'),
(10909, 'Wali Jan Bettani & Co. Govt. Contractor', 'Walijan2021@gmail.com', '03468992786', '2260164811393', 'Wali Jan', 'Tank', 'TANK', '7709', 'PK-C-3', 'PK-C-3', '7227780', 'K7227780-6', NULL, 'no', 'CNIC-a85573c3.jpeg', NULL, 'FBR-c16a85ca.jpeg', 'KIPRA-61ddf26d.jpeg', 'PEC2020-46217c73.jpeg', '', '', 'no', 0, 0, '2021-11-10 02:11:02', '2024-08-19 08:07:01'),
(10910, 'GANTAR &CO', 'NA@GMAIL.COM', '0900-025554', '13403-0156480-5', 'dOST mUHAMMAD ', 'KOHISTAN', 'Kohistan', '16076', 'PK-C-4', 'PK-C-4', '8140749-6', '8140749-6', NULL, 'no', 'CNIC-a9ba03a8.jpeg', NULL, 'FBR-04b38b77.jpeg', 'KIPRA-04dc4e93.jpeg', 'PEC2020-021c9e15.jpeg', '', '', 'no', 1, 0, '2021-11-10 03:11:42', '2024-08-26 02:57:28'),
(10911, 'JEE CONSTRUCTION COMPANY (PVT) LTD', 'zainjee86@gmail.com', '0321-9071574', '17301-7937999-5', 'Hamid Shayan Jee', 'Bha jee kor 187 E5 street 7 phase 7 Hayatabad Peshawar', 'Peshawar', '4676', 'PK-C-3', 'PK-C-3', '7398450', '7398450-0', NULL, 'no', 'CNIC-a009d17b.png', NULL, 'FBR-68dddee3.jpeg', 'KIPRA-d49f7b1a.png', 'PEC2020-63722775.jpeg', '', '', 'no', 0, 0, '2021-11-10 05:11:29', '2024-08-19 08:07:01'),
(10912, 'M/s SOHAIL KHAN BUILDERS (PRIVATE) LIMITED', 'javedkhanskb1@gmail.com', '0315-9982299', '16101-6794080-1', 'JAVED KHAN', 'OFFICE#1, GUJJAR GARI ROAD NEAR T.B HOSPITAL Mardan', 'Mardan', '7710', 'PK-C-3', 'PK-C-3', '8240526', 'K8240526-0', NULL, 'no', 'CNIC-291baae0.jpeg', NULL, 'FBR-efd2154f.jpeg', 'KIPRA-8d83072b.jpeg', 'PEC2020-77eae74b.jpeg', '', '', 'no', 1, 0, '2021-11-10 06:11:08', '2024-08-26 02:56:46'),
(10913, 'M/s Wadan Engineering Services', 'wespakpak@gmail.com', '0316-9947274', '15701-9415691-5', 'Muhammad Alam', 'Mohallah Malak Abad villege and P/O box Bibyawar\r\nDir Upper KPK', 'Dir', '6754', 'PK-C-4', 'PK-C-4', '2549938', 'K2549938-6', NULL, 'no', 'CNIC-047a0804.jpeg', NULL, '', 'KIPRA-30f3fbed.jpeg', 'PEC2020-ad6cc829.jpeg', '', 'PE-14df262b.jpeg', 'no', 0, 1, '2021-11-09 20:11:08', '2024-08-26 03:55:42'),
(10914, 'M.Z. AWAN & SONS', 'mzawanandsons@outlook.com', '0333-9166991', '17301-7762755-9', 'Malik Aamir Zaman', 'House#123, Street#5, Sector#E/2, Phase#1, Hayatabad, Peshawar ', 'Peshawar', '334', 'PK-C-B', 'PK-C-B', '7935674-5', 'K7935674-5', NULL, 'no', 'CNIC-49b1793b.jpeg', NULL, 'FBR-2d9b9fb3.jpeg', 'KIPRA-93e067c8.jpeg', 'PEC2020-aaf85cc4.jpeg', '', '', 'no', 1, 0, '2021-11-09 22:11:09', '2024-08-26 03:55:16'),
(10916, 'M/S ASMAT ULLAH KHAN MOHMAND', 'kami_zeb@yahoo.com', '344-0004770', '17101-0350007-9', 'ASMAT ULLAH KHAN	', 'Vill Pri qilla PO Shabqadar distt Charsadda', 'Charsadda', '7717', 'PK-C-3', 'PK-C-3', '17101-0350007-9	', 'K2628638-6', NULL, 'no', 'CNIC-b900fad5.jpeg', NULL, 'FBR-34ffc268.jpeg', 'KIPRA-d830eb43.jpeg', 'PEC2020-fb068fc4.jpeg', '', 'PE-3bfeaa09.jpeg', 'no', 0, 1, '2021-11-10 23:11:58', '2024-08-26 02:55:45'),
(10922, 'MIAN ENGINEERING CONSTRUCTION SERVIES', 'Mianrahim1983@gmail.com', '03342997757', '15701-5591938_1', 'MIAN RAHIM ULLAH ', 'P/O SERAI GANDIGAR MANO BANDA TEHSIL DIR DISTRICT UPPER DIR  UPPER DIR', 'UPPER DIR', '26150', 'PK-C-5', 'PK-C-5', '4934951-4', 'K4934951-4', NULL, 'no', 'CNIC-a9ee2dca.jpeg', NULL, 'FBR-669f8e9f.jpeg', 'KIPRA-62957872.jpeg', 'PEC2020-f55862b3.jpeg', '', '', 'no', 1, 0, '2021-11-11 04:11:43', '2024-08-26 02:54:19'),
(10923, 'MIAN ENGINEERING CONSTRUCTION SERVICES', 'mianrahim1983@gmail.com', '03342997757', '1570155919381', 'Mian Rahimullah', 'P/O SERAI GANDIGAR,MANO BANADA TEHSIL DIR,DISTRICT UPPER DIR', 'Upper Dir', '26150', 'PK-C-5', 'PK-C-5', '49349514', 'K49349514', NULL, 'no', 'CNIC-44d96ea1.jpeg', NULL, 'FBR-ec68b809.jpeg', 'KIPRA-95f9526e.jpeg', 'PEC2020-7be1788a.jpeg', '', '', 'no', 0, 1, '2021-11-11 05:11:19', '2024-08-26 02:54:04'),
(10924, 'MIAN ENGINEERING CONSTRUCTION SERVICES', 'mianrahim1983@gmail.com', '03342997757', '1570155919381', 'Mian Rahimullah', 'P/O SERAI GANDIGAR, MANO. BANDA, TEHSIL DIR,UPPER DIR', 'Upper Dir', '26150', 'PK-C-6', 'PK-C-5', '49349514', 'K49349514', NULL, 'no', 'CNIC-94387df8.jpeg', NULL, 'FBR-25c5ba1c.jpeg', 'KIPRA-a6eb7f57.jpeg', 'PEC2020-b6f504c0.jpeg', '', '', 'no', 1, 0, '2021-11-11 05:11:44', '2024-08-26 02:54:00'),
(10925, 'VICINITY DEVELOPERS PVT LTD', 'na.@gmail.com', '0347-9165967', '37405-5271181-7', 'NAJEEB ULLAH KHAN	', 'HOUSE NO CB-2263 STREET NO 4 MOHALLAH ALLAHABAD\r\n', 'Rawalpindi', 'C5 /25718', 'PK-C-5', 'PK-C-5', '3740552711817', 'KA305863-7', NULL, 'no', 'CNIC-d5e9e2f2.jpeg', NULL, 'FBR-1103f1bb.jpeg', 'KIPRA-909d062c.jpeg', 'PEC2020-f8654796.jpeg', '', '', 'no', 0, 1, '2021-11-11 01:11:31', '2024-08-26 02:55:51'),
(10926, 'M/s M/s Fazal Amin Shah', 'yshah2054@gmail.com', '0315-9526974', '17101-3141563-3', 'Fazal Amin Shah', 'MOH: GULBAHAR COLONY#2 MARDAN ROAD TEH& DISTT. Charsadda', 'Charsadda', '23474', 'PK-C-5', 'PK-C-5', '4023582', 'K4023582-3', NULL, 'no', 'CNIC-591f86ee.jpeg', NULL, 'FBR-ad7603f7.jpeg', 'KIPRA-52cd1a75.jpeg', 'PEC2020-54fe531c.jpeg', '', '', 'no', 1, 0, '2021-11-12 03:11:13', '2024-08-26 02:31:38'),
(10927, 'Arif star unique co (ASU) construction company', 'arifstaruniqueco@gmail.com', '03001611222', '1120196894527', 'Arif Salam', 'Office no 4, second floor building no 50-c Muslim comm street no 1 phase 6 dha Karachi', 'Lakki Marwat', '25357', 'PK-C-5', 'PK-C-5', '7222097-2', 'K7222097-2', NULL, 'no', 'CNIC-507c312e.jpeg', NULL, 'FBR-1ba44865.png', 'KIPRA-9876a0aa.jpeg', 'PEC2020-897bc6c8.jpeg', '', 'PE-b91ccd93.jpeg', 'no', 0, 0, '2021-11-12 04:11:54', '2024-08-19 08:07:01'),
(10928, 'Arif star unique co (ASU) construction company', 'arifstaruniqueco@gmail.com', '03134532532', '1120196804527', 'Arif Salam', 'Office no 4 second floor building no 50-c Muslim comm street no 1 phase 6 dha Karachi Pakistan', 'Lakki Marwat', '25357', 'PK-C-5', 'PK-C-5', '7222097-2', 'K7222097-2', NULL, 'no', 'CNIC-c40c1b26.jpeg', NULL, 'FBR-4e038caf.png', 'KIPRA-79360f8d.jpeg', 'PEC2020-fddc1519.jpeg', '', '', 'no', 1, 0, '2021-11-12 05:11:42', '2024-08-26 00:00:39'),
(10930, 'M/S Muhammad Saboor Khan', 'sardarjasim99@gmail.com', '03080005937', '13101-7397439-1', 'MUhammad saboor khan', 'Sultan Hotel CHare Road TEH and District Abbottabad', 'Abbottabad', '16096', 'PK-C-4', 'PK-C-4', '13101-7397439-1', 'K3383121-1', NULL, 'no', 'CNIC-c8f5219e.jpeg', NULL, 'FBR-b79dbb4d.jpeg', 'KIPRA-ec1f1d32.jpeg', 'PEC2020-c7305faf.jpeg', '', 'PE-8ab6f03e.jpeg', 'no', 1, 0, '2021-11-12 23:11:36', '2024-08-26 01:19:07'),
(10931, 'M/s M.Afzal', 'na@gmail.com', '0310-4799000', '16102-4666017-3', 'Mohtiar Zamir', 'Afzal Market jan khan kali Takht bhai distt Mardan', 'Mardan', '73930', 'PK-C-6', 'PK-C-6', '7573801-4', 'K7573801-4', NULL, 'no', 'CNIC-d43e35da.jpeg', NULL, 'FBR-b562d79c.jpeg', 'KIPRA-946b7b60.jpeg', 'PEC2020-b77cfc12.jpeg', '', '', 'no', 1, 0, '2021-11-15 00:11:28', '2024-08-26 00:00:35'),
(10932, 'Muhammad Yousaf & Sons', 'civil_engineer_pk@yahoo.com', '0345-9632530', '13302-5266145-3', 'Muhammad Yousaf ', 'Carry Raikan, Post Office Kala Bagh, Nathiagali Abbottabad', 'Abbottabad', '76686', 'PK-C-6', 'PK-C-6', '8345973-3', 'K8345973-3', NULL, 'no', 'CNIC-537b8b4b.jpeg', NULL, 'FBR-e6ac8c56.jpeg', 'KIPRA-f24df493.jpeg', 'PEC2020-272d615d.jpeg', '', '', 'no', 0, 1, '2021-11-15 01:11:16', '2024-08-26 02:33:55'),
(10933, 'Anisullah and Brothers', 'msanisbrothers@gmail.com', ' 92314969509', '15702-2519605-7', 'Anis Ullah and Brothers', 'Village Molvi Post Office Sahib Abad Tehsil Wari Dir Upper', 'Dir Upper', '7706', 'PK-C-3', 'PK-C-3', '15702-2519605-7', 'K4272078-8', NULL, 'no', 'CNIC-6990e205.jpeg', NULL, 'FBR-2546f68b.jpeg', 'KIPRA-d4b3e127.jpeg', 'PEC2020-b47d04bb.jpeg', 'Form-H-8f1342a0.jpeg', 'PE-fd3f1e86.jpeg', 'no', 1, 0, '2021-11-15 04:11:54', '2024-08-26 00:00:32'),
(10934, 'M/s Shah Nawaz Construction Company', 'sn004275@gmail.com', '0333-9633233', '14101-5648177-3', 'Shah Nawaz Khan', 'Alam Zeb medicos samana road Hangu', 'Hangu', '16110', 'PK-C-4', 'PK-C-4', '7222206-3', 'K7222206-3', NULL, 'no', 'CNIC-8b8ade27.jpeg', NULL, 'FBR-f65ca459.jpeg', 'KIPRA-3df1e213.jpeg', 'PEC2020-f20e917e.jpeg', '', 'PE-f0784574.jpeg', 'no', 1, 0, '2021-11-15 06:11:47', '2024-08-26 00:00:29'),
(10935, 'S.MUHAMMAD ZAHIR', 'NA@GMAIL.COM', '0397-84875', '13504-7523005-3', 'MUHAMMAD ZAHIR', 'Islamabad', 'Islamabad', '39558', 'PK-C-6', 'PK-C-6', '13504-7523005-3', '3984338-6', NULL, 'no', 'CNIC-9a62c400.jpeg', NULL, 'FBR-6ab4aa62.jpeg', 'KIPRA-701f3c54.jpeg', 'PEC2020-e30ada61.jpeg', '', '', 'no', 0, 1, '2021-11-16 00:11:42', '2024-08-26 01:18:34'),
(10936, 'M/S Razmak Construction Co', 'inamwazir78@gmail.com', '03159636053', '2150782149955', 'Sher ayaz Khan', 'Plot #76, Sector C, Phase 1 ,Bannu Town Bannu', 'Bannu', '3324', 'PK-C-2', 'PK-C-2', '40371492', 'K40371492', NULL, 'no', 'CNIC-6fb4d976.jpeg', NULL, 'FBR-bef4ee70.jpeg', 'KIPRA-34e4ae73.jpeg', 'PEC2020-d5a84849.jpeg', '', 'PE-13b70759.jpeg', 'no', 0, 1, '2021-11-16 00:11:21', '2024-08-26 00:00:16'),
(10937, 'TAHIR UL MULK & CO', 'NA@GMAIL.COM', '0365-874800', '13503-1859580-1', 'TAHIR UL MULK ', 'Islamabad', 'Islamabad', 'C5 /24845', 'PK-C-5', 'PK-C-5', '13503-1859580-1', '24880582', NULL, 'no', 'CNIC-149c1143.jpeg', NULL, 'FBR-fb1b304c.jpeg', 'KIPRA-b08a5f5c.jpeg', 'PEC2020-39beee71.jpeg', '', '', 'no', 2, 0, '2021-11-16 00:11:42', '2024-09-01 02:14:26'),
(10938, 'Star', 'abbaskhan357@gmail.com', '03130535333', '15701-2490811-7', 'Buner', 'Village Rehankot, Tehsil Dir, P/O Dir and District Dir', '54790', 'Abbas Khan', 'PK-C-B', 'PK-C-A', '1231629', '43123', '[\"Irrigation\",\"PHA\",\"FATA\"]', 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', 0, 1, '2024-08-18 14:27:26', '2024-08-18 14:37:13'),
(10939, 'Star', 'abbaskhan357@gmail.com', '394720934790', '15701-6619056-1', 'Abbottabad', 'Village Rehankot, Tehsil Dir, P/O Dir and District Dir', '2324252441', 'Abbas Khan Underworld', 'PK-C-A', 'PK-C-A', '1231629', '43123', '[\"Local Council Board\",\"Irrigation\",\"PHA\"]', 'no', 'registrations/cnic/cE8OfHySNN5zeAHydJumHcyp1771Z7iFG1CgFFdq.jpg', 'registrations/cnic/s2ZFxHDXstFBBAE4Ap4Nhk0wLpWo7eBVbszTIzPA.jpg', NULL, NULL, NULL, NULL, NULL, 'no', 0, 1, '2024-08-18 14:31:43', '2024-08-26 01:18:09'),
(10940, 'Star', 'zahid@gmail.com', '03130535333', '15701-2490811-7', 'Bajaur', 'Village Rehankot, Tehsil Dir, P/O Dir and District Dir', '7858758', 'Aslam Khan', 'PK-C-A', 'PK-C-A', '0324', '54-3', '[\"Irrigation\",\"PKHA\",\"PDA\"]', 'no', 'registrations/cnic/cILc1NEMsMZjWE1QluG9BiKKzt9NQ8KWEXaHfeUs.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 'no', 2, 0, '2024-08-19 01:17:45', '2024-08-28 09:07:27');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Secretary', '2024-08-28 07:16:24', '2024-08-28 07:16:24'),
(2, 'Chief Engineer', '2024-08-28 07:16:31', '2024-08-28 07:16:31'),
(3, 'Director IT', '2024-08-28 07:16:37', '2024-08-28 07:16:37'),
(4, 'Director P&M', '2024-08-28 07:16:46', '2024-08-28 07:16:46'),
(5, 'Additional Secretary', '2024-08-28 07:16:54', '2024-08-28 07:16:54');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Abbottabad', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(2, 'Bajaur', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(3, 'Bannu', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(4, 'Battagram', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(5, 'Buner', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(6, 'Charsadda', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(7, 'Dera Ismail Khan', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(8, 'Hangu', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(9, 'Haripur', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(10, 'Karak', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(11, 'Kohat', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(12, 'Kolai-Palas', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(13, 'Kohistan', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(14, 'Kurram', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(15, 'Lakki Marwat', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(16, 'Lower Chitral', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(17, 'Lower Dir', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(18, 'Lower Kohistan', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(19, 'Malakand', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(20, 'Mansehra', '2024-08-18 16:19:20', '2024-08-18 16:19:20'),
(21, 'Mardan', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(22, 'Mohmand', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(23, 'North Waziristan', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(24, 'Nowshera', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(25, 'Orakzai', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(26, 'Peshawar', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(27, 'Shangla', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(28, 'South Waziristan', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(29, 'Swabi', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(30, 'Swat', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(31, 'Tank', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(32, 'Torghar', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(33, 'Upper Chitral', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(34, 'Upper Dir', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(35, 'Upper Kohistan', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(36, 'Khyber', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(37, 'Kurram', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(38, 'Lakki Marwat', '2024-08-18 16:19:21', '2024-08-18 16:19:21'),
(39, 'Mardan', '2024-08-18 16:19:21', '2024-08-18 16:19:21');

-- --------------------------------------------------------

--
-- Table structure for table `district_user`
--

CREATE TABLE `district_user` (
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(5, '2024_08_17_184139_create_contractor_registrations_table', 2),
(6, '2024_08_18_160001_create_districts_table', 3),
(8, '2024_08_18_163837_create_collections_table', 4),
(9, '2024_08_26_101153_create_permission_tables', 5),
(10, '2024_08_26_101257_create_media_table', 5),
(11, '2024_08_28_085129_create_designations_table', 6),
(12, '2024_08_28_085147_create_offices_table', 6),
(13, '2024_08_28_085213_create_contractor_categories_table', 6),
(14, '2024_08_28_085232_create_provincial_entities_table', 6),
(15, '0001_01_01_000000_create_users_table', 7),
(16, '2024_08_29_063052_create_district_user_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 2),
(5, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Secretary', '2024-08-28 07:17:10', '2024-08-28 07:17:10'),
(2, 'Chief Engineer (Center)', '2024-08-28 07:17:31', '2024-08-28 07:17:31'),
(3, 'Chief Engineer (North)', '2024-08-28 07:17:40', '2024-08-28 07:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'View Registrations', 'web', '2024-08-28 07:14:22', '2024-08-28 07:14:22'),
(2, 'Defer Registration', 'web', '2024-08-28 07:14:35', '2024-08-28 07:14:35'),
(3, 'Approve Registrations', 'web', '2024-08-28 07:15:11', '2024-08-28 07:15:11'),
(4, 'Add Users', 'web', '2024-08-28 07:15:31', '2024-08-28 07:15:31'),
(5, 'View Users', 'web', '2024-08-28 07:15:35', '2024-08-28 07:15:35'),
(6, 'Edit Users', 'web', '2024-08-28 07:15:54', '2024-08-28 07:15:54'),
(7, 'Delete Users', 'web', '2024-08-28 07:15:59', '2024-08-28 07:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `provincial_entities`
--

CREATE TABLE `provincial_entities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provincial_entities`
--

INSERT INTO `provincial_entities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'C&W', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(2, 'PHE', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(3, 'Local Government', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(4, 'Local Council Board', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(5, 'Irrigation', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(6, 'PHA', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(7, 'PKHA', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(8, 'FATA', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(9, 'PDA', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(10, 'Electric Inspector', '2024-08-28 12:23:11', '2024-08-28 12:23:11'),
(11, 'Others', '2024-08-28 12:23:11', '2024-08-28 12:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `registrations_logs`
--

CREATE TABLE `registrations_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reg_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(45) DEFAULT NULL,
  `old_status` int(10) UNSIGNED DEFAULT NULL,
  `new_status` int(10) UNSIGNED NOT NULL,
  `action_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrations_logs`
--

INSERT INTO `registrations_logs` (`id`, `reg_id`, `action`, `old_status`, `new_status`, `action_at`) VALUES
(1, 7008, 'approval', 0, 1, '2024-08-18 05:16:52'),
(2, 7011, 'deferment', 0, 1, '2024-08-18 05:17:36'),
(3, 7011, 'approval', 0, 1, '2024-08-18 05:17:42'),
(4, 7012, 'deferment', 0, 1, '2024-08-18 05:22:22'),
(5, 7012, 'deferment', 1, 2, '2024-08-18 05:22:30'),
(6, 7012, 'approval', 0, 1, '2024-08-18 05:22:36'),
(7, 7014, 'deferment', 0, 1, '2024-08-18 05:23:17'),
(8, 7014, 'deferment', 1, 2, '2024-08-18 05:23:35'),
(9, 7014, 'deferment', 2, 3, '2024-08-18 05:23:40'),
(10, 7019, 'deferment', 0, 1, '2024-08-18 05:33:24'),
(11, 7019, 'deferment', 1, 2, '2024-08-18 05:33:37'),
(12, 7024, 'deferment', 0, 1, '2024-08-18 05:33:43'),
(13, 7016, 'approval', 0, 1, '2024-08-18 05:51:40'),
(14, 7027, 'deferment', 0, 1, '2024-08-18 05:51:51'),
(15, 7027, 'approval', 0, 1, '2024-08-18 05:52:00'),
(16, 7028, 'deferment', 0, 1, '2024-08-18 08:09:41'),
(17, 7031, 'deferment', 0, 1, '2024-08-18 08:10:10'),
(18, 7031, 'deferment', 1, 2, '2024-08-18 08:10:21'),
(19, 7030, 'deferment', 0, 1, '2024-08-18 13:45:38'),
(20, 10938, 'approval', 0, 1, '2024-08-18 14:37:13'),
(21, 7031, 'approval', 0, 1, '2024-08-19 01:08:48'),
(22, 7019, 'deferment', 2, 3, '2024-08-19 04:47:25'),
(23, 10940, 'deferment', 0, 1, '2024-08-19 06:40:17'),
(24, 10940, 'deferment', 1, 2, '2024-08-19 06:40:36'),
(25, 10940, 'deferment', 2, 3, '2024-08-19 06:40:41'),
(26, 7024, 'deferment', 1, 2, '2024-08-21 07:00:26'),
(27, 7024, 'approval', 0, 1, '2024-08-21 07:02:54'),
(28, 7028, 'approval', 0, 1, '2024-08-21 07:03:04'),
(29, 7030, 'deferment', 1, 2, '2024-08-21 07:06:20'),
(30, 10936, 'approval', 0, 1, '2024-08-26 00:00:16'),
(31, 10934, 'deferment', 0, 1, '2024-08-26 00:00:29'),
(32, 10933, 'deferment', 0, 1, '2024-08-26 00:00:32'),
(33, 10931, 'deferment', 0, 1, '2024-08-26 00:00:35'),
(34, 10928, 'deferment', 0, 1, '2024-08-26 00:00:39'),
(35, 10939, 'approval', 0, 1, '2024-08-26 01:18:09'),
(36, 10935, 'approval', 0, 1, '2024-08-26 01:18:34'),
(37, 10930, 'deferment', 0, 1, '2024-08-26 01:19:07'),
(38, 10926, 'deferment', 0, 1, '2024-08-26 02:31:38'),
(39, 10932, 'approval', 0, 1, '2024-08-26 02:33:55'),
(40, 10924, 'deferment', 0, 1, '2024-08-26 02:54:00'),
(41, 10923, 'approval', 0, 1, '2024-08-26 02:54:03'),
(42, 10922, 'deferment', 0, 1, '2024-08-26 02:54:19'),
(43, 10916, 'approval', 0, 1, '2024-08-26 02:55:45'),
(44, 10925, 'approval', 0, 1, '2024-08-26 02:55:51'),
(45, 10912, 'deferment', 0, 1, '2024-08-26 02:56:46'),
(46, 10910, 'deferment', 0, 1, '2024-08-26 02:57:28'),
(47, 10914, 'deferment', 0, 1, '2024-08-26 03:55:16'),
(48, 10903, 'approval', 0, 1, '2024-08-26 03:55:22'),
(49, 10904, 'approval', 0, 1, '2024-08-26 03:55:29'),
(50, 10913, 'approval', 0, 1, '2024-08-26 03:55:42'),
(51, 8838, 'deferment', 0, 1, '2024-08-26 04:37:11'),
(52, 8838, 'deferment', 1, 2, '2024-08-26 04:37:21'),
(53, 8838, 'deferment', 2, 3, '2024-08-26 04:37:28'),
(54, 7030, 'approval', 0, 1, '2024-08-26 04:37:47'),
(55, 10900, 'deferment', 0, 1, '2024-08-28 09:07:21'),
(56, 10940, 'deferment', 1, 2, '2024-08-28 09:07:27'),
(57, 10937, 'deferment', 0, 1, '2024-09-01 02:14:17'),
(58, 10937, 'deferment', 1, 2, '2024-09-01 02:14:26'),
(59, 7031, 'approval', 0, 1, '2024-09-01 14:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-08-28 06:49:14', '2024-08-28 06:49:14'),
(2, 'Secretary', 'web', '2024-08-28 06:49:33', '2024-08-28 06:49:33'),
(3, 'Chief Engineer', 'web', '2024-08-28 06:49:42', '2024-08-28 06:49:42'),
(4, 'Director IT', 'web', '2024-08-28 06:52:11', '2024-08-28 06:52:11'),
(5, 'Director P&M', 'web', '2024-08-28 06:52:18', '2024-08-28 06:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('p9K0d738MMgUtU2SYRWkGESqwu31Gw6fqGAr455f', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQjFVa3hCMGRUUUlCVGFLZFpPQWVwYWE5UkdOaFNEeWpDSXZvc2R6VyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vY253a3AuZ292LnBrL3VzZXJzLzU3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1725419723);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `mobile_number` varchar(45) DEFAULT NULL,
  `landline_number` varchar(45) DEFAULT NULL,
  `designation` varchar(45) DEFAULT NULL,
  `cnic` varchar(45) DEFAULT NULL,
  `office` varchar(45) DEFAULT NULL,
  `otp` varchar(45) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password_updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile_number`, `landline_number`, `designation`, `cnic`, `office`, `otp`, `is_active`, `email_verified_at`, `password_updated_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abbas Khan', 'abbaskhan357@gmail.com', '0313-0535333', '0944-880250', 'Assistant Director IT', '15701-2490811-7', 'IT', NULL, 1, '1993-11-27 15:26:56', '2024-08-26 11:44:27', '$2y$12$wmcpa8lo940rCXu3UWgoxeE3wvvbXPZNTTAVPVUABM6VuKbIWBmqi', 'gTR5f3KAlbBKddvpiOkFUVnh4QEv3cTwPjEGsdS3ujRsqmhgWl9drq1o8OLC', '2024-08-29 11:12:07', '2024-08-29 11:23:50'),
(2, 'Prof. Leanna Kreiger Jr.', 'stokes.cecile@example.net', '1-458-721-8267', '+13463680347', 'Bench Jeweler', '56472-8563441-8', 'Johnson, Stehr and Terry', NULL, 0, '1997-06-15 00:31:53', '1984-06-28 05:07:48', '$2y$12$b6mvsAXaGSupbHgeyA1wu.kyWs75oL8B5jd9MUNgI4mjQJSXgV6nm', 'yC5DdRMgWx', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(3, 'Miss Esta Pollich V', 'drake.kemmer@example.org', '+1 (910) 499-1885', '1-818-213-8988', 'Crane and Tower Operator', '29132-1821429-3', 'Schimmel, Davis and Trantow', NULL, 0, '1971-10-09 20:04:22', '1979-12-17 23:56:58', '$2y$12$wmM/aae.CGgenCDFGDvLsu8S2mtHb5M5LCg6D0SnOitCc79wrACPq', 'bNg6DGZC0z', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(4, 'Katrina Schuster Sr.', 'buford70@example.com', '1-857-723-4002', '(252) 519-4052', 'Electrical Engineering Technician', '59220-9255473-3', 'Goyette LLC', NULL, 1, '1992-11-15 18:47:24', '1990-04-28 16:44:25', '$2y$12$nFfCqg7WCMJWTAY/uz54muOXWEVlYiEooyT0zUo0TYZPSIhmu6THu', 'uVsp9nEY38', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(5, 'Miss Olga Legros', 'kurt.cassin@example.com', '+1-216-863-9957', '651-703-5037', 'Annealing Machine Operator', '81185-9574310-3', 'Ernser Group', NULL, 1, '2018-05-06 22:52:22', '1985-09-26 19:19:11', '$2y$12$8Tqyz5vWgQPhXSyyfpOiteG7l5OiZbLkMd1pC1c09RFekwF1ftCF6', 'GQj6lggWHW', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(6, 'Della Keeling', 'bruen.juston@example.com', '+1-319-472-1806', '947.992.8881', 'Production Planning', '53902-8118435-9', 'Gleichner, Schmeler and Tremblay', NULL, 0, '1986-01-10 10:25:04', '1971-08-22 20:53:40', '$2y$12$raeDjqlazmL7tC528LBwv.apgU5NN2egSNaXqf1xQ0OH4ppqtcoQ2', 'fqvkeN92y9', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(7, 'Orie Kemmer', 'dweber@example.net', '320.260.7903', '+1-984-531-1223', 'Economics Teacher', '74891-3557310-0', 'Beier, Russel and Hessel', NULL, 0, '2014-01-28 13:36:31', '2016-06-24 03:56:23', '$2y$12$UZjtO/sbpyM3ZNwGwoqMSOy7qo3KMoe1UTtQFTRnEFN3X8ivaJ2zO', 'jD06ptBgix', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(8, 'Mrs. Bailee Konopelski', 'chaya87@example.net', '(458) 499-7628', '1-689-342-5234', 'Inspector', '14970-5508988-7', 'Gerlach-Zulauf', NULL, 0, '1985-05-20 05:01:40', '1971-12-11 05:26:39', '$2y$12$Xyp0q2Lyh3RXCxaiD0O9pukkDOP7lW5KkdP5g.LD1mvoD5slg9tHC', 'NFaUQ3ULua', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(9, 'Hank Murphy', 'auer.breanne@example.com', '1-831-417-0521', '+15747224130', 'Electrical Drafter', '49906-6332591-2', 'Adams, Ankunding and Smith', NULL, 1, '1977-06-23 12:03:14', '1979-10-20 10:37:47', '$2y$12$3byj.WSDODJr7Ij.74mqAOG1A8Wv/EI2SOlgTjfSzSnAME9v5qLEG', '3QzZiSwAld', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(10, 'Madyson Boyle', 'barbara.wehner@example.org', '701-964-0156', '+1-541-899-5534', 'Nuclear Engineer', '94380-2412786-6', 'Roberts-West', NULL, 1, '2002-10-22 02:09:29', '1986-07-27 14:26:00', '$2y$12$ZY9qylLbP.pgc9VwHQ7v.uiGAokSdrcA1ZvOSNRCoDuTEI/sSQD6u', '2X2WEHQzmT', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(11, 'Anderson Hartmann', 'sam.homenick@example.org', '1-651-960-4158', '989.736.3120', 'Orthodontist', '73964-2330962-1', 'Kihn Inc', NULL, 0, '1988-04-22 21:10:05', '2020-05-05 05:22:07', '$2y$12$bVzIjzFXc8AAmJRnd1vTWuFrXDNuVNGgFxIN2oZ4YiAC8xpeDg/X6', 'RehDWvGcVZ', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(12, 'Kathryne Gerlach', 'nasir92@example.org', '920.336.5167', '+1 (870) 349-8959', 'Landscaper', '73777-2619031-6', 'Mante LLC', NULL, 1, '2004-12-02 19:37:09', '1990-10-19 23:34:37', '$2y$12$Mp654z830IJg/hM0CF9hMerRb4ikRpt2hNrTvFHRd6bdgVEijCRsC', '44l7gwvTKp', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(13, 'Lilly Greenholt', 'mdeckow@example.org', '1-469-531-5314', '208.667.4872', 'Technical Writer', '50744-5519910-3', 'Maggio Ltd', NULL, 1, '1987-09-21 07:29:18', '1999-09-16 11:21:17', '$2y$12$Ym0zP8P3BUNVztfsOJDIzeJpsG6PKB8oGYUU/WboePDFIdGMXginy', '93BvtTLOuk', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(14, 'Araceli Stark', 'bailey.brandi@example.net', '+1-712-337-8140', '930-867-6088', 'Short Order Cook', '75793-2607954-3', 'Kuhic-Lueilwitz', NULL, 1, '1979-04-14 03:32:32', '2002-04-10 00:36:52', '$2y$12$izA3uyhv01toVyTBMrDV5eCAMWLGhOvFv2qwiE0pXP53febHKyzEC', 'Zn91zmcUU0', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(15, 'Daniella Mayer', 'runolfsson.brennan@example.org', '+1 (623) 797-3328', '+1-619-322-9957', 'Door To Door Sales', '25130-4571523-6', 'Huels-Corwin', NULL, 0, '2017-07-07 01:07:17', '1987-05-29 02:38:20', '$2y$12$nzC0OvwlsuA.LmP5Xwdvr.zn3xGpffz99lLMP04/8x3sKz35.RF6e', 'vrMbQKRUU2', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(16, 'Dr. Jonatan Cassin', 'effie.jacobs@example.com', '270-675-5647', '813.837.6621', 'Social Science Research Assistant', '40289-7823376-9', 'Kris-Marks', NULL, 1, '1996-05-11 21:09:16', '1988-05-04 13:23:54', '$2y$12$yMiTrg8U89i31/8fBR2tMOzev1v/V9O38wiYYHdK4zx3mIgHn1BUK', 'YyekS0VZIz', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(17, 'Delilah Reilly MD', 'clotilde.stamm@example.net', '1-785-585-9835', '+16407716783', 'Gas Distribution Plant Operator', '53590-1191109-4', 'Bayer, Tromp and Fisher', NULL, 0, '1995-12-31 09:52:47', '2020-10-29 15:38:28', '$2y$12$s8g7U/nqnIIZBd3HYLgI8O1EiPxehKdv/4XgSzqC9.QvMi7KnOt8S', 'ndTbB15AhK', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(18, 'Obie Jones', 'fahey.terrill@example.com', '1-424-432-9979', '484-565-3510', 'Precision Instrument Repairer', '39527-9726353-4', 'Satterfield-McDermott', NULL, 1, '1980-08-31 14:06:20', '2020-08-17 00:21:00', '$2y$12$CMJhplxKhMrXIrQFheremuTEwaEFAAo91.bbwqM.7tx35IJg9pwDe', '7XlEGBcj8l', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(19, 'Miss Gabriella Towne', 'cassie63@example.com', '1-580-593-5274', '678.990.0705', 'Special Education Teacher', '44242-1029190-0', 'Pagac Inc', NULL, 1, '1982-01-25 03:37:23', '2017-05-16 00:23:18', '$2y$12$BXvLAlrONlgmgXELbTAlf.bn0sgovvdcsICCRHmqejSlGPsrHRTfC', '9izmyKqv4Y', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(20, 'Dr. Cheyenne Huel DVM', 'ylueilwitz@example.org', '916-610-1662', '424.941.0422', 'Secretary', '11171-7759035-6', 'Schmidt, Roob and Huel', NULL, 0, '2003-02-27 14:05:42', '1980-10-25 01:01:49', '$2y$12$hzi0dqJyKU4sOKNNIW32aOZYlGYFyQKEYfxn0PXDBEMvM/4vlgy9y', 'oO76qVYprn', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(21, 'Mrs. Maryse Wolff III', 'elmo.bechtelar@example.org', '934-887-1689', '940.242.7110', 'Computer Repairer', '71407-7684495-5', 'Lebsack and Sons', NULL, 1, '2007-04-05 06:52:23', '2024-01-28 19:00:40', '$2y$12$xgkU8iuz6PUIgDtIGoLsB.rgLRPNKej8EgfPS5rJ49CtaWzPe4f6G', 'ksJ6733UAT', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(22, 'Prof. Tyree Hill II', 'nader.lance@example.net', '682-952-5839', '+1-757-316-0904', 'Ship Engineer', '24700-5695283-5', 'O\'Connell Inc', NULL, 1, '1983-05-24 22:47:16', '1998-11-29 06:11:29', '$2y$12$DoK2BXwExfH8Hw9LtEIItewNk1GFFrW6GrPiCi5l88nXXfE26jy4S', '4UDKGly4Nt', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(23, 'Prof. Johnnie Pagac', 'odubuque@example.net', '475-364-7098', '1-667-944-1597', 'Boat Builder and Shipwright', '52850-6888049-7', 'Nader, Metz and Prosacco', NULL, 1, '1988-05-11 00:52:25', '1993-01-16 14:51:35', '$2y$12$c0FDrPFzjy6gunfaN38EiuWjLNYYHfA4kOr5C4cxTzJGlBUKeDF9q', 'W1dGEn2zIj', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(24, 'Carolyn Cummings Sr.', 'elena.hessel@example.net', '+12198094848', '385-938-4463', 'Hand Presser', '60904-5877090-5', 'Boyer Inc', NULL, 0, '1999-11-19 03:42:09', '2008-02-11 05:15:07', '$2y$12$q4zh8nygf8ZQVpH.7NnsCu6SYcfD7IZab9uGgWBgmuzL4J8jAA6AC', 'dlZNkDHYc2', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(25, 'Ms. Rylee Mraz DVM', 'blick.josiane@example.org', '+1-680-420-8854', '+1-575-342-0413', 'Office and Administrative Support Worker', '93152-2160646-3', 'Jones, Hoppe and Waelchi', NULL, 0, '1993-11-09 05:44:50', '2003-05-26 10:26:35', '$2y$12$4YnwGkjJFFuQtN6HwHfXFOu/m386F1SwdmsDgfPkQ4Huo7OdRLh/u', 'jR9Rh8sk5h', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(26, 'Emilie Franecki', 'fstracke@example.com', '458.293.6196', '+1-906-979-3054', 'Tree Trimmer', '42324-7774617-0', 'West, Gerhold and Kohler', NULL, 0, '1998-03-14 02:29:44', '2011-08-20 13:07:24', '$2y$12$k3aesquf0uOuc3TMLjXWyu6lmhveYdJ900NiAhh8Vbld.jd0TybkW', 'yEdRlXQS8L', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(27, 'Janick Bauch', 'qmorissette@example.org', '207.547.5594', '602.330.1750', 'Tractor Operator', '10311-4608001-9', 'Zemlak-Abbott', NULL, 0, '2005-04-12 13:46:21', '1977-06-24 23:00:36', '$2y$12$0DWt3lDYuCd3j1JIUjVx8.krc53bmCP9RJZxlM/rcV5Y1eLcqUHSW', 'n0PoAxWI0b', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(28, 'Moses Ernser', 'mnicolas@example.com', '1-651-512-3912', '+14455703802', 'Clerk', '32841-3474510-1', 'Pouros, Bailey and Johnston', NULL, 1, '2019-12-20 21:22:22', '1983-03-05 21:06:10', '$2y$12$tbHWWixzQUKFWGXl7XRnIuN.7uqwmSnoGuRyzJd/w864vpCojopB2', 'CWioBRicIp', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(29, 'Dr. Marlin Schmitt MD', 'eve.beatty@example.com', '+1 (830) 759-0080', '+1-424-756-6929', 'Aircraft Engine Specialist', '21430-1224195-5', 'Funk, Daniel and Kilback', NULL, 0, '1980-01-16 15:02:59', '1985-08-13 02:15:00', '$2y$12$7zkTHPHXrr2GHEx1RlaYTOLuEcwanCiQez3XKsphgI7NPRoIlrywy', '95FrwHFi7r', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(30, 'Jennifer Gleason', 'lvandervort@example.org', '+1 (415) 673-6067', '863.227.8492', 'Social Service Specialists', '08091-3155898-4', 'Schoen-Hauck', NULL, 1, '2010-10-16 05:22:32', '2020-01-10 02:46:03', '$2y$12$tfMHgd3shqyW4grpUQ9rW.gid19YZcSbOw3YcDPgHdhI90WqfMZFe', 'MbAbAGjJHK', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(31, 'Blaze Mills MD', 'ava.rau@example.org', '+1.769.233.1690', '708.491.9531', 'Sales Person', '88266-5250824-6', 'Herman Ltd', NULL, 0, '1998-04-21 15:04:18', '1992-11-27 07:42:30', '$2y$12$5wmXCOAvtN8UJfbZfDDFA.HRdPW1HzIKKFh22TZO8..NaR.Ubblyu', 'sPCLMMfv6G', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(32, 'Dr. Blake Reichert MD', 'ladarius.torphy@example.net', '(224) 782-1262', '+13645831693', 'Horticultural Worker', '16137-4939311-2', 'Pagac-Casper', NULL, 0, '2018-12-15 18:48:18', '1993-12-27 16:27:26', '$2y$12$oWRwqZ9N/pVvRNCDnn/X6.DkhQN9/ez/TgS7W6wnLYyzwDpgW6aa6', 'yQSGf6rY5Q', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(33, 'Leilani Langosh Jr.', 'bergnaum.skyla@example.org', '+1-909-627-7837', '325-488-7748', 'Recreational Vehicle Service Technician', '77516-5386405-2', 'Pollich, Wolff and Swaniawski', NULL, 1, '2020-10-14 19:06:32', '1974-06-20 02:10:04', '$2y$12$/glfvVn3rP3WT4LCuMDys.ovJxjaTDBfSgvBSu5mce/UzbRGuOh3O', 'q0FwOcdcgM', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(34, 'Mr. Curt Tillman IV', 'bridgette.reilly@example.com', '+1.574.290.5934', '+1.619.837.6538', 'Mining Engineer OR Geological Engineer', '22498-1473966-9', 'Walter, Gibson and Adams', NULL, 1, '1992-12-27 08:13:01', '1985-07-04 11:00:19', '$2y$12$.MuM9tAVfAv.ievnrCHtPec3Q0iH/Xxg/7MLfRrLxev.ry7LUPt4K', 'SOLLSs0Xb3', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(35, 'Vena Schamberger', 'qferry@example.org', '(530) 789-5897', '1-458-393-9553', 'Special Force', '85395-9334068-1', 'Eichmann PLC', NULL, 1, '2001-05-02 20:16:31', '1980-04-14 06:24:28', '$2y$12$aiDKHDOOakaIh/unsHxAhuD68F.8Y29rgMALkxbY6x50ypj3xWV1u', 'Uc8eMHOG0x', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(36, 'Hayley Homenick', 'iritchie@example.org', '1-863-392-8677', '+13393341352', 'Librarian', '04212-4165444-8', 'Weissnat Ltd', NULL, 0, '2001-10-22 00:36:02', '2021-09-06 09:26:24', '$2y$12$0W3rHH.hi1pDN5XiAOMXIOkZs3pCNw1jNX3TvHpFEVwtclnKTiNC2', 'l1AQqqBcGd', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(37, 'Mrs. Meda Rice', 'oconner.velva@example.com', '330-900-8537', '480-643-6964', 'Maintenance Equipment Operator', '36078-6981282-7', 'Treutel Inc', NULL, 1, '2014-01-20 10:12:57', '2023-12-11 09:42:06', '$2y$12$PD.fFklsZFHHD3f7fZ8vsOBUdizxnGTWkqlCaBDUj94lGDmd52IdC', 'DPeo9OygFY', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(38, 'Isabel Lynch', 'ward.albertha@example.org', '1-337-332-4812', '564-544-9977', 'Postal Service Mail Carrier', '61955-6951784-1', 'Lubowitz LLC', NULL, 0, '1978-10-15 02:03:09', '1978-05-24 20:54:49', '$2y$12$f4AASUTPUCmMmDviYmEyUujG3VDuINmC5EH.5fbX/tFrLOvqjeJG2', 'sUZaMrMkSX', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(39, 'Mr. Tavares Mitchell IV', 'murray05@example.com', '+1 (832) 957-5290', '986-904-8613', 'Inspector', '14257-8891485-9', 'Walter-Runte', NULL, 1, '2009-10-17 09:29:32', '1980-10-02 07:03:43', '$2y$12$rOXTv1waYMllnXR5WoZtEuEqo8dFdGVLDWxhGJLvinvcGxya/H3x.', 'NaBOr4qhnm', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(40, 'Ross Oberbrunner', 'casper.irma@example.net', '445-328-1831', '351.636.0114', 'Geographer', '43425-0758811-4', 'Balistreri, White and Thiel', NULL, 0, '1975-04-19 19:33:00', '2024-06-05 21:42:40', '$2y$12$q6lrVrmAzPtRHgybClrj9uk4amzeAhFuyaVTpRWcDXDEFBeGOpOYu', 'fZll6Xbrpw', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(41, 'Riley Kuhic', 'claudia.kessler@example.net', '+1-539-543-4757', '+1-351-901-8891', 'Animal Trainer', '57519-5012745-5', 'Gerlach, Crist and Murphy', NULL, 1, '1974-10-18 16:10:01', '2022-01-26 08:57:54', '$2y$12$5XixQqLxjZuyFmAys2LEcOlxaQoWweGLs4aLXSY8OkqOkY8nNIZlq', 'L4DMt0jd50', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(42, 'Lisa Graham DDS', 'jamarcus17@example.com', '(458) 234-8087', '(930) 353-1801', 'Electronic Equipment Assembler', '58548-0714507-1', 'Reichel-Robel', NULL, 0, '2012-12-01 05:19:02', '2007-07-08 00:48:35', '$2y$12$fFtLhcbOCUYrRGmagyst/uKPwgOjcQVBgclduuyHyk/t2S0WqmgoO', 'ayXClu5piw', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(43, 'Corbin Schimmel', 'okessler@example.org', '+1 (571) 516-8272', '+1.425.314.2892', 'Music Arranger and Orchestrator', '83695-1295784-1', 'Braun, Gusikowski and Beahan', NULL, 0, '2020-07-14 19:48:58', '1982-08-16 17:33:01', '$2y$12$VjRd1zPoxOUVS.t6jBcNb.QL.1MGBcSjPJM8kWT96dt43y2XEof1.', 'Yy39yd1QY3', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(44, 'Prof. Ignacio Barrows III', 'baumbach.genesis@example.net', '+1-440-767-1613', '+1-440-620-4038', 'Chemical Equipment Tender', '88630-5300144-2', 'Dicki Ltd', NULL, 1, '1985-07-01 16:40:43', '2014-06-05 01:38:58', '$2y$12$wjxfKY6ZSRaEPDn6a2Uk3Oj11Ut.Re75dZON/M/VJsqEM5/XTQnAO', 'OvSbbJ4YEg', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(45, 'Ms. Joelle Walter', 'bbahringer@example.com', '1-424-763-8386', '831-314-2159', 'Program Director', '91589-0012230-4', 'Moen Group', NULL, 0, '2015-09-23 23:01:46', '2012-11-25 12:05:30', '$2y$12$ZAqk82NBCs4c/hbJQ.oAFOw1yYwHV0QgBBzJSWPe/QvdMuBKzBIWi', 'nQHQIT2MdZ', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(46, 'Dr. Charlotte Treutel', 'garret59@example.com', '+1 (856) 940-6996', '1-858-789-2596', 'Radio Mechanic', '41862-2600901-1', 'Hintz-Ratke', NULL, 0, '2007-01-16 16:20:32', '1986-01-10 11:09:18', '$2y$12$1lodeY8Kiv/reGk2Wliiz.N7HXjP4pwX6IcRoF0a5ugb.UZ4I8eVG', 'dK6X0kyPzg', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(47, 'Virginie McDermott', 'mackenzie06@example.net', '+1.779.934.6457', '+15619616347', 'Distribution Manager', '24352-2773707-7', 'Fadel-McDermott', NULL, 0, '1992-02-14 14:45:17', '1972-05-20 01:14:21', '$2y$12$pzjBYgr7Kau/P84tKDkkcuDdndoW9lWXu/TsDI8oP6eC3BYNGsnTm', 'PrMt528G7F', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(48, 'Dean Flatley', 'nina78@example.net', '+1-989-706-6241', '458-277-3108', 'Automotive Mechanic', '17655-9089734-6', 'Medhurst, Douglas and Kihn', NULL, 0, '2013-06-08 12:54:19', '2021-05-08 18:35:56', '$2y$12$pqnWAqW5WNUxArUj2nv/feOS/HWp8tDiBgGTqaoV3/Jw/poc.Vd5W', 'uAkqZSQq5p', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(49, 'Dr. D\'angelo Hermann', 'qcassin@example.net', '234.961.0394', '+17724520459', 'Preschool Teacher', '47873-1163567-4', 'Kessler-Jacobson', NULL, 0, '2019-12-17 21:27:14', '1975-04-17 15:33:02', '$2y$12$9LfUQvkHChJZyqY21JPPiuehjPjclJaOhAnshSZJUIr6fIfIbF6dC', 'OksWvJw2q9', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(50, 'Mac Lindgren DDS', 'gregorio.kassulke@example.com', '+1 (574) 658-6187', '+1 (603) 974-8657', 'Computer Support Specialist', '09257-2204689-0', 'McKenzie Ltd', NULL, 1, '2022-07-28 08:01:03', '1983-08-30 14:24:57', '$2y$12$4Cm8VEXE18rgjHN7EafZbeyzeb2qTh2QJRIH6Cq3IlCme2BPp9jXq', 'tN65oweoPa', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(51, 'Andrew Reynolds', 'marge.davis@example.net', '430.758.7118', '+1-872-602-8315', 'Veterinary Technician', '35924-5350132-7', 'Zemlak-Langosh', NULL, 1, '2017-12-06 23:09:04', '2022-10-28 06:25:29', '$2y$12$FvpIgYlL.zEr3o2iNxo3v.95X2u9YrKkszu9HRNLCkOM4v2Zq797O', '2sfN5Gj9AV', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(52, 'Vern Stamm', 'laura.dickens@example.org', '(830) 894-7459', '816.659.9246', 'Personal Home Care Aide', '49860-7392583-0', 'Reynolds, Konopelski and Pollich', NULL, 0, '2024-08-11 19:56:17', '1998-09-14 18:15:55', '$2y$12$LhIyuXENzd/MBBFmENmru.GlJMJJlCMvlFsyToEMaXv1zK5SmsuAO', '5s364d335L', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(53, 'Henriette Krajcik', 'alford76@example.com', '(520) 246-6043', '+1-920-331-6344', 'Market Research Analyst', '49593-7956677-1', 'Feeney-Hoppe', NULL, 0, '2008-04-07 21:35:36', '1979-05-23 10:06:36', '$2y$12$Fg/MCb5GyVJnIjEcsiSXweLK2iVP4fSf7fyammM2rEVg2vM6YV0FS', 'zqL28ZpJkb', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(54, 'Braulio Cremin', 'tillman.sienna@example.com', '551.249.0503', '+1-863-408-7204', 'Healthcare Practitioner', '90153-7886221-8', 'O\'Reilly-Becker', NULL, 1, '2006-12-22 12:35:18', '1990-03-24 21:39:02', '$2y$12$GQLkNvbxvkbWNjbpi43vge1iu6v1tIRsnYXd.5N8pBFEt5A1K31UC', 'mlG5QOmazS', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(55, 'Norris Kertzmann Sr.', 'hackett.kailyn@example.org', '+1-484-468-8189', '740.257.0072', 'Coil Winders', '93240-2417085-4', 'Erdman-Jacobi', NULL, 0, '1991-07-01 12:13:07', '1990-11-17 03:22:30', '$2y$12$k12ptaiARpVfflrsxSQwd.rNvsGaodsejVqou9SYSaVvGNZ8y157e', 'j7q5uuU9hi', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(56, 'Frederic Schmidt', 'kendall47@example.net', '(878) 661-8768', '785-543-7512', 'Retail Salesperson', '74448-9441825-3', 'McClure-Fahey', NULL, 0, '1994-04-20 17:29:21', '1975-01-28 06:31:42', '$2y$12$2j11eGH0Q3Z89vhVEa8k2.n033t4PqPRcz/146/35MYpuwWs664TK', '8GjZQjqkVq', '2024-08-29 11:20:51', '2024-08-29 11:20:51'),
(57, 'Aslam Jan', 'aslam@gmail.com', '0313-4343535', '091-424927', 'Secretary', '15701-2242425-4', 'Secretary', NULL, 0, NULL, NULL, '$2y$12$0zELRMKSkQxVS9Db7pdTCeuYJu1YB0KKn9YnIIajbRTQNaA86Cq5C', NULL, '2024-09-03 05:07:20', '2024-09-03 05:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_hierarchy`
--

CREATE TABLE `user_hierarchy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `boss_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `contractor_categories`
--
ALTER TABLE `contractor_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contractor_registrations`
--
ALTER TABLE `contractor_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `district_user`
--
ALTER TABLE `district_user`
  ADD PRIMARY KEY (`district_id`,`user_id`),
  ADD KEY `district_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `provincial_entities`
--
ALTER TABLE `provincial_entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations_logs`
--
ALTER TABLE `registrations_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contractor_deferments_reg_id_foreign` (`reg_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_hierarchy`
--
ALTER TABLE `user_hierarchy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_hierarchy_user_id_foreign` (`user_id`),
  ADD KEY `user_hierarchy_boss_id_foreign` (`boss_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contractor_categories`
--
ALTER TABLE `contractor_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `contractor_registrations`
--
ALTER TABLE `contractor_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10941;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `provincial_entities`
--
ALTER TABLE `provincial_entities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `registrations_logs`
--
ALTER TABLE `registrations_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `user_hierarchy`
--
ALTER TABLE `user_hierarchy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `district_user`
--
ALTER TABLE `district_user`
  ADD CONSTRAINT `district_user_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `district_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations_logs`
--
ALTER TABLE `registrations_logs`
  ADD CONSTRAINT `contractor_deferments_reg_id_foreign` FOREIGN KEY (`reg_id`) REFERENCES `contractor_registrations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_hierarchy`
--
ALTER TABLE `user_hierarchy`
  ADD CONSTRAINT `user_hierarchy_boss_id_foreign` FOREIGN KEY (`boss_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_hierarchy_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
