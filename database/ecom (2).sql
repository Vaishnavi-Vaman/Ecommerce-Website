-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 09:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_master`
--

CREATE TABLE `category_master` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(45) NOT NULL,
  `category_type` varchar(10) NOT NULL,
  `category_status` varchar(10) NOT NULL,
  `category_date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_master`
--

INSERT INTO `category_master` (`category_id`, `category_name`, `category_type`, `category_status`, `category_date_create`) VALUES
(26, 'Clothes', 'Shopping', 'Active', '2024-02-03 10:38:05'),
(27, 'Shoes', 'Shopping', 'Active', '2024-02-03 10:38:18'),
(28, 'Electronics', 'Shopping', 'Active', '2024-02-03 10:39:21'),
(29, 'Medicine', 'Shopping', 'Active', '2024-02-03 10:40:04'),
(30, 'Cosmetics', 'Shopping', 'Active', '2024-02-03 10:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `login_master`
--

CREATE TABLE `login_master` (
  `login_id` int(11) NOT NULL,
  `user_email_id` varchar(75) DEFAULT NULL,
  `login_password` varchar(25) DEFAULT NULL,
  `user_type` varchar(10) DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_master`
--

INSERT INTO `login_master` (`login_id`, `user_email_id`, `login_password`, `user_type`, `date_create`) VALUES
(1, 'user@gmail.com', '123456', 'User', '2023-02-12 23:40:40'),
(3, 'admin@gmail.com', 'admin123', 'Admin', '2023-02-12 23:48:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_master`
--

CREATE TABLE `order_master` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(25) DEFAULT NULL,
  `order_status` varchar(15) DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_master`
--

INSERT INTO `order_master` (`order_id`, `user_id`, `transaction_id`, `order_status`, `order_date`) VALUES
(1, 1, '170711117465C07306D822B', 'Order Shipped', '2024-02-05 05:32:55'),
(2, 1, '170754802265C71D76D908D', 'Order Delivered', '2024-02-10 06:53:42'),
(3, 1, '170858353165D6EA6B2AAC7', 'Order Placed', '2024-02-22 06:32:11'),
(4, 1, '170858388965D6EBD1C1164', 'Order Placed', '2024-02-22 06:38:09'),
(5, 1, '171047733365F3D015EB4AF', 'Order Placed', '2024-03-15 04:35:33'),
(6, 1, '171074605365F7E9C56FEFB', 'Order Placed', '2024-03-18 07:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `order_temp`
--

CREATE TABLE `order_temp` (
  `temp_id` int(11) NOT NULL,
  `transaction_id` varchar(25) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_temp`
--

INSERT INTO `order_temp` (`temp_id`, `transaction_id`, `product_id`, `product_quantity`, `product_size`) VALUES
(1, '170711117465C07306D822B', 7, 1, ''),
(2, '170754802265C71D76D908D', 4, 2, 'S'),
(3, '170858353165D6EA6B2AAC7', 4, 1, 'S'),
(4, '170858388965D6EBD1C1164', 5, 1, 'S'),
(5, '171047733365F3D015EB4AF', 4, 1, 'M'),
(6, '171074605365F7E9C56FEFB', 7, 1, ''),
(7, '171074605365F7E9C56FEFB', 6, 1, '9'),
(8, '171074605365F7E9C56FEFB', 4, 1, 'L');

-- --------------------------------------------------------

--
-- Table structure for table `payment_master`
--

CREATE TABLE `payment_master` (
  `payment_id` int(11) NOT NULL,
  `card_holder_name` varchar(50) DEFAULT NULL,
  `card_number` bigint(20) DEFAULT NULL,
  `card_expiry_date` tinyint(4) DEFAULT NULL,
  `card_expiry_month` varchar(10) DEFAULT NULL,
  `card_expiry_year` smallint(6) DEFAULT NULL,
  `transaction_id` varchar(25) DEFAULT NULL,
  `card_cvv` smallint(6) DEFAULT NULL,
  `date_of_payment` timestamp NULL DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `total_amount` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_master`
--

INSERT INTO `payment_master` (`payment_id`, `card_holder_name`, `card_number`, `card_expiry_date`, `card_expiry_month`, `card_expiry_year`, `transaction_id`, `card_cvv`, `date_of_payment`, `payment_status`, `total_amount`) VALUES
(1, 'ythft', 1234567891234567, 12, 'July', 2028, '170711117465C07306D822B', 123, '2024-02-05 05:32:55', 'Success', ''),
(2, 'ggcg', 1232555855894567, 10, 'August', 2028, '170754802265C71D76D908D', 121, '2024-02-10 06:53:42', 'Success', ''),
(3, 'asdfas', 1234567894561237, 1, 'February', 2023, '170858353165D6EA6B2AAC7', 123, '2024-02-22 06:32:11', 'Success', ''),
(4, 'qwfegv', 7894561230789456, 7, 'September', 2023, '170858388965D6EBD1C1164', 123, '2024-02-22 06:38:09', 'Success', ''),
(5, 'roy', 1521545535784569, 13, 'September', 2028, '171047733365F3D015EB4AF', 454, '2024-03-15 04:35:33', 'Success', ''),
(6, 'roy', 1234567894561231, 14, 'October', 2028, '171074605365F7E9C56FEFB', 123, '2024-03-18 07:14:13', 'Success', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_master`
--

CREATE TABLE `product_master` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_image` varchar(50) DEFAULT NULL,
  `product_image_2` varchar(50) DEFAULT NULL,
  `product_image_3` varchar(50) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `product_price` double DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_status` varchar(15) DEFAULT NULL,
  `type` varchar(500) NOT NULL,
  `gender` varchar(500) NOT NULL,
  `product_date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_master`
--

INSERT INTO `product_master` (`product_id`, `category_id`, `product_image`, `product_image_2`, `product_image_3`, `product_name`, `product_price`, `product_description`, `product_status`, `type`, `gender`, `product_date_create`) VALUES
(4, 26, '11706937987.jpg', '21706937987.jpg', '31706937987.jpg', 'Regular Fit Mens Shirt', 349, 'GO WEIRD WITH VEIRDO.100% Premium 180 GSM Cotton Bio Wash, Bright Color & Texture To Give You Perfect Comfort, Most Suppliers Sell Promotional Tshirts From 135-140 GSM. Veirdo Provides Best Quality. Half Sleeve, Single Jersey, Premimum Round Neck, Regular Fit, Ultra Soft Enzyme Treated Fabrics.', 'Active', 'Shirt', 'Male', '2024-02-03 05:26:27'),
(5, 26, '11706938123.jpg', '21706938123.jpg', '31706938123.jpg', 'Only Check Trouser', 499, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Active', 'Trouser', 'Female', '2024-02-03 05:28:43'),
(6, 27, '11706938269.jpg', '21706938269.jpg', '31706938269.jpg', 'Casual shoes', 449, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Active', '', '', '2024-02-03 05:31:09'),
(7, 28, '11706938331.jpg', '21706938331.jpg', '31706938331.jpg', 'Analog watch', 569, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Active', '', '', '2024-02-03 05:32:11'),
(8, 26, '11707109731.jpg', '21707109731.jpg', '31707109731.jpg', 'Shirt in Stretch Cotton', 799, 'Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.', 'Active', 'Shirt', 'Female', '2024-02-05 05:08:51'),
(9, 26, '11707109803.jpg', '21707109803.jpg', '31707109803.jpg', 'Esprit Ruffle Shirt', 299, 'Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.', 'Active', 'Tshirt', 'Female', '2024-02-05 05:10:03'),
(10, 28, '11707110070.jpg', '21707110070.jpg', '31707110070.jpg', 'Analog wrist watch', 769, 'Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.', 'Active', '', '', '2024-02-05 05:14:30'),
(11, 26, '11707110168.jpg', '21707110168.jpg', '31707110168.jpg', 'Herschel supply shirt for women', 449, 'Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.', 'Active', 'Shirt', 'Female', '2024-02-05 05:16:08'),
(12, 26, '11707714573.jpg', '21707714573.jpg', '31707714573.jpg', 'Armani white tshirt for women', 299, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Active', 'Tshirt', 'Female', '2024-02-12 05:09:33'),
(13, 26, '11708085311.jpg', '21708085311.jpg', '31708085311.jpg', 'Formal shirt for men', 299, 'lorem epsem', 'Active', 'Shirt', 'Male', '2024-02-16 12:08:31'),
(14, 26, '11708085367.webp', '21708085367.webp', '31708085367.webp', 'Good looking shirt for men', 449, 'lorem epsom', 'Active', 'Shirt', 'Male', '2024-02-16 12:09:27'),
(15, 26, '11708085461.webp', '21708085461.webp', '31708085461.webp', 'New shirt for men', 299, 'lorem epsum', 'Active', 'Shirt', 'Male', '2024-02-16 12:11:01'),
(16, 26, '11708085513.webp', '21708085513.webp', '31708085513.webp', 'new cheks shirt for men', 449, 'lorem epsum', 'Active', 'Shirt', 'Male', '2024-02-16 12:11:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_email_id` varchar(75) DEFAULT NULL,
  `user_phone_number` varchar(10) DEFAULT NULL,
  `address_line_1` varchar(250) DEFAULT NULL,
  `address_line_2` varchar(250) DEFAULT NULL,
  `pin_code` varchar(10) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `user_date_create` timestamp NULL DEFAULT NULL,
  `user_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`user_id`, `user_name`, `user_email_id`, `user_phone_number`, `address_line_1`, `address_line_2`, `pin_code`, `city`, `user_date_create`, `user_status`) VALUES
(1, 'Abhilash', 'user@gmail.com', '8904653322', 'Kankanady', 'Mangalore', '574166', 'Mangalore', '2023-02-12 23:40:40', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_master`
--
ALTER TABLE `category_master`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `login_master`
--
ALTER TABLE `login_master`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `order_master`
--
ALTER TABLE `order_master`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_temp`
--
ALTER TABLE `order_temp`
  ADD PRIMARY KEY (`temp_id`);

--
-- Indexes for table `payment_master`
--
ALTER TABLE `payment_master`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `product_master`
--
ALTER TABLE `product_master`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_master`
--
ALTER TABLE `category_master`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `login_master`
--
ALTER TABLE `login_master`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_master`
--
ALTER TABLE `order_master`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_temp`
--
ALTER TABLE `order_temp`
  MODIFY `temp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment_master`
--
ALTER TABLE `payment_master`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_master`
--
ALTER TABLE `product_master`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
