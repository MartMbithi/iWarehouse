-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2021 at 03:45 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse_mis`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(200) NOT NULL,
  `categories_name` varchar(200) NOT NULL,
  `categories_desc` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `categories_desc`) VALUES
(1, 'Electronics', ' Electronics comprises the physics, engineering, technology and applications that deal with the emission, flow and control of electrons in vacuum and matter.[1] It uses active devices to control electron flow by amplification and rectification, which distinguishes it from classical electrical engineering which uses passive effects such as resistance, capacitance and inductance to control current flow.'),
(3, 'Motor Vehicles', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Cursus vitae congue mauris rhoncus aenean. Consectetur lorem donec massa sapien faucibus et molestie. Sed nisi lacus sed viverra. Facilisis leo vel fringilla est ullamcorper eget nulla facilisi. Mattis ullamcorper velit sed ullamcorper morbi tincidunt ornare massa eget. Nulla facilisi nullam vehicula ipsum a arcu cursus vitae. Et netus et malesuada fames ac turpis egestas sed tempus. Massa id neque aliquam vestibulum morbi. Consectetur adipiscing elit pellentesque habitant morbi tristique senectus et netus. Viverra nibh cras pulvinar mattis nunc sed blandit libero. Cursus metus aliquam eleifend mi in. Aliquet eget sit amet tellus.');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_address` longtext NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_login_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`, `customer_email`, `customer_login_id`) VALUES
(3, 'James Doe Updated', '90126 Localhost', 'jamesdoe@mail.com', '5cf83116b1ebf2c304ac89b5d63ba235b4fae35362'),
(4, 'Jane Doe', '127 Localhost', 'janedoe@mail.com', '249a08f890c885d9ce8a79859b9e42a15d0bc1680c');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` varchar(200) NOT NULL,
  `login_username` varchar(200) NOT NULL,
  `login_password` varchar(200) NOT NULL,
  `login_rank` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `login_username`, `login_password`, `login_rank`) VALUES
('249a08f890c885d9ce8a79859b9e42a15d0bc1680c', 'jane_doe', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Customer'),
('2f1e74e5bf7e1652b630c40e245985f2310dd2b1c5', 'doe_james', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Administrator'),
('4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd6ab8', 'System Admin', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Administrator'),
('5cf83116b1ebf2c304ac89b5d63ba235b4fae35362', 'James_Doe', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Customer'),
('76b06fc77f64e2f2b05bf0d7e0440bf3a0510a1031', 'jas_doe', 'a69681bcf334ae130217fea4505fd3c994f5683f', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `order_table`
--

CREATE TABLE `order_table` (
  `order_id` int(200) NOT NULL,
  `order_customer_id` int(200) NOT NULL,
  `order_date` varchar(200) NOT NULL,
  `order_product_id` int(200) NOT NULL,
  `order_quantity` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_table`
--

INSERT INTO `order_table` (`order_id`, `order_customer_id`, `order_date`, `order_product_id`, `order_quantity`) VALUES
(2, 3, '2021-07-27', 1, '3'),
(3, 3, '27-Jul-2021', 3, '1'),
(5, 3, '27-Jul-2021', 1, '5');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(200) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_category_id` int(200) NOT NULL,
  `product_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `product_category_id`, `product_image`) VALUES
(1, 'Hitachi J100 Circuit Board', 'Analog circuits are sometimes called linear circuits although many non-linear effects are used in analog circuits such as mixers, modulators, etc. Good examples of analog circuits include vacuum tube and transistor amplifiers, operational amplifiers and oscillators. ', 1, '1627383576hitachi.jpg'),
(3, 'Arduino FTDI Chip', 'You\'ll find an FTDI chip on Arduino boards that have a USB connector. It\'s used to handle the USB communications on one side, and TTL serial communications on the other. The serial pins from the chip are mapped to the UART on the AVR chip, and in turn they appear on the pin headers for easy connections', 1, '1627384094Arduino_ftdi_chip-2.jpg'),
(4, 'Raspiberry PI', 'The Raspberry Pi is a low cost, credit-card sized computer that plugs into a computer monitor or TV, and uses a standard keyboard and mouse. It is a capable little device that enables people of all ages to explore computing, and to learn how to program in languages like Scratch and Python.', 1, '1627384283raspiberry.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(200) NOT NULL,
  `stock_product_id` int(200) NOT NULL,
  `stock_quantity` varchar(200) NOT NULL,
  `stock_store_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `stock_product_id`, `stock_quantity`, `stock_store_id`) VALUES
(2, 1, '895', 2),
(3, 4, '900', 1),
(4, 3, '899', 3);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `store_id` int(200) NOT NULL,
  `store_name` varchar(200) NOT NULL,
  `store_des` longtext NOT NULL,
  `store_location` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `store_name`, `store_des`, `store_location`) VALUES
(1, 'Raspiberry PI ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Arcu felis bibendum ut tristique. Aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed. Placerat in egestas erat imperdiet sed euismod nisi porta. Diam quis enim lobortis scelerisque fermentum. Bibendum arcu vitae elementum curabitur. At varius vel pharetra vel. A iaculis at erat pellentesque adipiscing commodo. Risus feugiat in ante metus dictum at. Mus mauris vitae ultricies leo integer. ', 'Nairobi - CBD'),
(2, 'Hitachi Stores', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Arcu felis bibendum ut tristique. Aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed. Placerat in egestas erat imperdiet sed euismod nisi porta. Diam quis enim lobortis scelerisque fermentum. Bibendum arcu vitae elementum curabitur. At varius vel pharetra vel. A iaculis at erat pellentesque adipiscing commodo. Risus feugiat in ante metus dictum at. Mus mauris vitae ultricies leo integer. Donec enim diam vulputate ut pharetra sit. Porttitor rhoncus dolor purus non enim praesent elementum. Odio aenean sed adipiscing diam donec adipiscing. Interdum consectetur libero id faucibus nisl tincidunt eget nullam.', 'Nairobi - Westlands'),
(3, 'Arduino Official Store', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Arcu felis bibendum ut tristique. Aliquam malesuada bibendum arcu vitae elementum curabitur vitae nunc sed. Placerat in egestas erat imperdiet sed euismod nisi porta. Diam quis enim lobortis scelerisque fermentum. Bibendum arcu vitae elementum curabitur. At varius vel pharetra vel. A iaculis at erat pellentesque adipiscing commodo. Risus feugiat in ante metus dictum at. Mus mauris vitae ultricies leo integer. Donec enim diam vulputate ut pharetra sit. Porttitor rhoncus dolor purus non enim praesent elementum. Odio aenean sed adipiscing diam donec adipiscing. Interdum consectetur libero id faucibus nisl tincidunt eget nullam.', 'Nairobi CBD');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(200) NOT NULL,
  `user_full_name` varchar(200) NOT NULL,
  `user_mobile` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_login_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_full_name`, `user_mobile`, `user_email`, `user_login_id`) VALUES
(1, 'System Administrator', '+2547123456', 'sysadmin@mail.com', '4ef1dbe95fe4b1128ede9b16ff2dcacfc6fd6ab8'),
(3, 'Jasmine Doe', '90012673', 'jas@mail.com', '76b06fc77f64e2f2b05bf0d7e0440bf3a0510a1031'),
(4, 'Doe James', '0737229776', 'jamesdoe@mail.com', '2f1e74e5bf7e1652b630c40e245985f2310dd2b1c5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `ClientLogin` (`customer_login_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`);

--
-- Indexes for table `order_table`
--
ALTER TABLE `order_table`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `OrderCustomer` (`order_customer_id`),
  ADD KEY `order_product_id` (`order_product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `ProductCategory` (`product_category_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `ProductID` (`stock_product_id`),
  ADD KEY `StoreID` (`stock_store_id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `UserLogin` (`user_login_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_table`
--
ALTER TABLE `order_table`
  MODIFY `order_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_table`
--
ALTER TABLE `order_table`
  ADD CONSTRAINT `OrderCustomer` FOREIGN KEY (`order_customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `ProductCategory` FOREIGN KEY (`product_category_id`) REFERENCES `categories` (`categories_id`) ON DELETE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `ProductID` FOREIGN KEY (`stock_product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `StoreID` FOREIGN KEY (`stock_store_id`) REFERENCES `store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
