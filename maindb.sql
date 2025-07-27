-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 09:46 PM
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
-- Database: `ecomerse_website`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_user` (IN `uid` INT)   BEGIN
    DELETE FROM orders WHERE user_id = uid;
    DELETE FROM reviews WHERE user_id = uid;
   
    DELETE FROM addresses WHERE user_id = uid;
    
    

    DELETE FROM users WHERE id = uid;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address_line1` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) DEFAULT 'Pakistan',
  `type` enum('billing','shipping') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `full_name`, `phone`, `address_line1`, `city`, `country`, `type`, `created_at`, `updated_at`) VALUES
(22, 9, 'Haris', '+923160116389', '4k chowrangi surani town', 'Karachi', 'Pakistan', 'billing', '2025-07-04 04:14:18', '2025-07-04 04:14:18'),
(30, 61, 'Fozia', '+923160116389', 'north karachi 11 b', 'Karachi', 'Pakistan', 'billing', '2025-07-15 09:41:15', '2025-07-15 09:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Apple'),
(2, 'DELL'),
(3, 'Samsung'),
(4, 'Sony'),
(5, 'LG'),
(6, 'HP'),
(7, 'Lenovo'),
(8, 'canon'),
(9, 'Nikon'),
(10, 'Kodak'),
(11, 'E.I.F'),
(12, 'ANUA'),
(13, 'Khaadi'),
(14, 'Limelight'),
(15, 'Ideas'),
(16, 'Bata'),
(17, 'Borjan'),
(18, 'Rolex'),
(19, ' Cartier'),
(20, 'Dawlance');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Electronics'),
(2, 'Health & Beauty'),
(3, 'Home & Lifestyle'),
(4, 'TV & Home Appliances'),
(5, 'Fashions'),
(6, 'Books & Stationary');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` enum('Cash','Card','UPI','Wallet') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `total`, `status`, `created_at`, `payment_method`) VALUES
(54, 9, 22, 41816.00, 'delivered', '2025-07-04 18:56:33', 'Cash'),
(55, 9, 22, 578.00, 'delivered', '2025-07-05 10:48:26', 'Cash'),
(58, 9, 22, 62500.00, 'delivered', '2025-07-06 18:46:53', 'Cash'),
(59, 9, 22, 40000.00, 'delivered', '2025-07-06 18:58:55', 'Cash'),
(60, 9, 22, 578.00, 'delivered', '2025-07-06 19:28:33', 'Cash'),
(71, 9, 22, 23000.00, 'shipped', '2025-07-09 15:20:10', 'Cash'),
(77, 9, 22, 1898.00, 'delivered', '2025-07-11 16:46:03', 'Cash'),
(100, 61, 30, 38526.00, 'delivered', '2025-07-15 09:41:25', 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(82, 54, 46, 2, 578.00),
(83, 54, 45, 1, 660.00),
(84, 54, 76, 1, 40000.00),
(85, 55, 46, 1, 578.00),
(91, 58, 88, 1, 25000.00),
(92, 59, 76, 1, 40000.00),
(93, 60, 46, 1, 578.00),
(108, 71, 16, 1, 23000.00),
(117, 77, 45, 2, 660.00),
(118, 77, 46, 1, 578.00),
(142, 100, 44, 1, 570.00),
(143, 100, 32, 1, 34800.00),
(144, 100, 26, 1, 156.00),
(145, 100, 71, 1, 3000.00);

-- --------------------------------------------------------

--
-- Table structure for table `otp_verification`
--

CREATE TABLE `otp_verification` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `brand_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `subcategory_id`, `created_at`, `brand_id`, `category_id`, `quantity`) VALUES
(13, 'Apple iPhone X, 64GB Unlocked - Red', 'Best i phone ever', 12000.00, 73, '2025-06-27 02:44:56', 1, 1, 5),
(15, 'Apple iPhone XR, US Version, 64GB, Red ', 'With the iPhone XR you get a roomy 6.1-inch display, fast enough performance from Apple\'s A12 Bionic processor and good camera quality in a colorful design and affordable package. Apple has included the all-new Liquid Retina LCD as the display on the iPhone XR. Apple released the iPhone XR with a smattering of color options. Both the glass back and the metal frame are brightly colored, with the glass using an in-depth seven-layer color process to achieve the rich finish and the Apple-exclusive aluminum alloy anodized to match. Instead of 3D Touch, the iPhone XR replicates the experience through \"Haptic Touch\". Advanced Face ID lets you securely unlock your iPhone and log in to apps with just a glance.', 13000.00, 73, '2025-06-27 03:27:00', 1, 1, 5),
(16, 'Samsung Galaxy A16 5G A Series Cell Phone', 'Measured diagonally, the screen size is 6.7\" in the full rectangle and 6.5\" accounting for the rounded corners. Actual viewable area is less due to the rounded corners and the camera cutout. ²IP54 rating for water and dust resistance. Water resistance based on laboratory test conditions for exposure to splashes of fresh water. Not advised for beach or pool use. Dust resistance based on laboratory test conditions, with limited protection against dust ingress.', 23000.00, 73, '2025-06-27 04:01:39', 3, 1, 5),
(17, 'SAMSUNG Galaxy S25 Ultra Cell Phone', 'Galaxy S25 Ultra handles the small details so you can focus on staying in the moment. Get several tasks fulfilled with one simple ask, and get insightful tips throughout your day to stay one step ahead. Simplify life with AI¹⁰ that evolves with you to work better for you.', 34000.00, 73, '2025-06-27 04:04:26', 3, 1, 5),
(18, 'MMY I25 Ultra Unlocked Cell Phone', 'Galaxy S25 Ultra handles the small details so you can focus on staying in the moment. Get several tasks fulfilled with one simple ask, and get insightful tips throughout your day to stay one step ahead. Simplify life with AI¹⁰ that evolves with you to work better for you.', 12000.00, 73, '2025-06-27 04:06:17', 3, 1, 5),
(19, 'Sony Xperia 10 VI 5G XQ-ES72 128GB 8GB', 'Sony Xperia 10 VI 5G XQ-ES72 128GB 8GB RAM Factory Unlocked (GSM Only | No CDMA – not Compatible with Verizon/Sprint) Smartphone Global Version Mobile', 45000.00, 73, '2025-06-27 04:11:14', 4, 1, 5),
(20, 'Sony Xperia 1 IV XQ-CT72 5G Dual 256GB', 'Sony Xperia 1 IV XQ-CT72 5G Dual 256GB 128GB 8GB RAM Factory Unlocked (GSM Only | No CDMA – not Compatible with Verizon/Sprint) Smartphone Global Version Mobile', 12300.00, 73, '2025-06-27 04:14:25', 4, 1, 5),
(22, 'Apple AirPods Pro 2 Wireless Earbuds', ' AirPods Pro 2 unlock the world’s first all-in-one hearing health experience: a scientifically validated Hearing Test,* clinical-grade and active Hearing Protection', 1200.00, 76, '2025-06-27 04:23:29', 1, 1, 5),
(23, 'Apple AirPods Max Wireless', 'ULTIMATE OVER-EAR LISTENING EXPERIENCE — Apple-designed dynamic driver provides high-fidelity audio. Computational audio combines custom acoustic design with the Apple H1 chip and software for breakthrough listening experiences.', 3400.00, 76, '2025-06-27 05:10:47', 1, 1, 5),
(24, 'Samsung Galaxy Buds 3 Pro', 'Meet the new shape of sound — Galaxy Buds3 Pro — now completely redesigned with improved hardware to bring you deeper into the audio than ever before. With Galaxy AI¹, your Buds create the best listening experience by optimizing sound based on your surroundings and how you wear them — while providing a snug fit for all-day comfort, no matter what you do. Buds3 Pro get how much you love your audio.', 189.00, 76, '2025-06-27 05:51:45', 3, 1, 5),
(25, 'SAMSUNG AKG Earbuds ', 'Samsung AKG Earbuds Original USB Type C In-Ear Earbud Headphones with Remote & Mic for Galaxy A53 5G, S22, S21, S21 FE, S20 Ultra, Note 10, Note 10+, S10 Plus - Braided - Includes Velvet Pouch - Black', 145.00, 76, '2025-06-27 05:56:25', 3, 1, 5),
(26, 'Lenovo Go Wired Speakerphone', 'this is a lenevo smart spekaer', 156.00, 76, '2025-06-27 06:02:42', 7, 1, 4),
(27, 'Canon EOS Rebel T7 DSLR Camera with 18-55mm Lens', 'Perfect for beginners, this camera bundle offers the essential tools needed to take your SLR skills to new heights, all in one convenient package. No matter where your next adventure takes you, count on the EOS Rebel t7\'s impressive 24.1 Megapixel CMOS sensor and wide ISO range of 100-6400 (H: 12800) to capture high-quality images, even in low-light situations.', 1288.00, 77, '2025-06-27 16:00:23', 8, NULL, 5),
(28, 'Nikon D7500 20.9MP DSLR Camera with AF-S DX NIKKOR', 'Class leading image quality, ISO range, image processing and metering equivalent to the award-winning D500 Large 3.2” 922K dot, tilting LCD screen with touch functionality 51-point AF system with 15 cross-type sensors and group-area AF paired with up to 8 fps continuous shooting capability 4K Ultra HD and 1080p Full HD video with stereo sound, power aperture control, auto ISO, 4K UHD Time-Lapse and more.', 1288.00, 77, '2025-06-27 16:10:08', 9, NULL, 5),
(30, 'Nikon Z fc with Wide-Angle Zoom Lens ', 'The Z fc mirrorless camera features a classic, tactile design fused with modern Z series technology. Equipped with a flip out vlogger screen, this DX-format 4K UHD compact camera delivers big image quality for photos and videos.', 12500.00, 77, '2025-06-27 16:23:49', 9, NULL, 0),
(31, 'KODAK PIXPRO Friendly Zoom FZ45-BK 16MP ', 'Introducing the FZ45, Friendly Zoom model from the KODAK PIXPRO collection of digital cameras. Compact, intuitive and oh so easy to use, the FZ45 is the perfect camera to take anywhere you go. One-touch video, red-eye removal, face detection and convenient AA batteries are just the start. KODAK PIXPRO Digital Cameras - Tell your story.\r\n\r\n', 1460.00, 77, '2025-06-27 16:26:46', 10, NULL, 5),
(32, 'LG K51 Unlocked Smartphone ', 'A phone packed with premium features that will keep you connected and fit your budget.\r\nIntroducing the impressive LG K51 that enables you to capture and experience life’s special moments.\r\n\r\n', 34800.00, 73, '2025-06-27 16:29:16', 5, NULL, 4),
(33, 'Nikon Z fc with Wide-Angle Zoom Lens ', 'The Z fc mirrorless camera features a classic, tactile design fused with modern Z series technology. Equipped with a flip out vlogger screen, this DX-format 4K UHD compact camera delivers big image quality for photos and videos.', 12500.00, 77, '2025-06-27 20:40:32', 9, NULL, 5),
(34, 'Nikon Z fc with Wide-Angle Zoom Lens ', 'The Z fc mirrorless camera features a classic, tactile design fused with modern Z series technology. Equipped with a flip out vlogger screen, this DX-format 4K UHD compact camera delivers big image quality for photos and videos.', 12500.00, 77, '2025-06-27 20:40:43', 9, NULL, 5),
(38, 'E.T.F SKIN Holy Hydration! Hydrated Ever After Skincare Mini Kit, Cleanser, ', 'A COMPLETE HYDRATION REGIMEN: This skincare kit has all of your favorite Holy Hydration necessities-', 25000.00, 89, '2025-06-28 01:09:29', 11, 2, 5),
(40, 'E.I.F. SKIN Bright Icon Vitamin C + E + Ferulic Serum', 'BRIGHTENING SERUM: A radiance-boosting serum formulated with a triple threat of 15% vitamin C, 1% vitamin E and 0.5% ferulic acid.', 650.00, 89, '2025-06-28 01:21:33', 11, 2, 5),
(41, 'E.I.F. SKIN  Clarify Facial Oil, Face Oil For Treating , Helps Calm Redness', 'CLARIFYING FACIAL OIL: Helps to help clarify clogged pores and treat and prevent new blackheads and breakouts without drying out your skin for a bright-looking, even-toned complexion.', 850.00, 89, '2025-06-28 01:29:34', 11, 2, 10),
(42, 'E.I.F. SKIN Holy Hydration!  Set Hydration Kit, Travel Friendly Hydrating  Set', 'FOR ALL SKIN TYPES: This skincare set is perfectly compatible with all skin types.', 560.00, 89, '2025-06-28 01:34:06', 11, 2, 5),
(44, 'ANUA Heartleaf Quercetinol Pore Deep Cleansing Foam, Facial Cleanser,', 'Creates a delicate light foam infused with Heartleaf Extract, making it gentle yet effective, especially suitable for deeply cleansing oily and combination skin.', 570.00, 89, '2025-06-28 01:52:46', 12, 2, 8),
(47, 'Comfy Shirts', 'Simply & regular shirt', 1500.00, 51, '2025-06-29 01:12:55', 15, 5, 5),
(48, 'White Hoodie', 'White Warm comfy hoodie', 2000.00, 51, '2025-06-29 01:13:49', 15, 5, 5),
(49, 'Green Hoodie', 'Green Soft Hoodie', 2000.00, 51, '2025-06-29 01:14:33', 15, 5, 5),
(50, 'Dark Green Jacket', 'Dark green comfy jacket', 3000.00, 51, '2025-06-29 01:15:31', 15, 5, 5),
(51, 'White T-shirt', 'Starchy white t-shirt', 2000.00, 51, '2025-06-29 01:16:42', 15, 5, 5),
(53, 'Winter Long Coat ', 'Winter long coat for men ', 3000.00, 51, '2025-06-29 01:34:54', 14, 5, 5),
(54, 'Black Sneaker ', 'Black & white Sneakers', 2000.00, 54, '2025-06-29 01:36:39', 16, 5, 5),
(55, 'Black Long Boots', 'Girls longs black boots ', 2500.00, 54, '2025-06-29 01:52:06', 17, 5, 5),
(58, 'White Heels', 'white heels by borjan', 2000.00, 54, '2025-06-29 04:18:50', 17, 5, 5),
(59, 'Flat cut shoe ', 'flat cut shoe', 1500.00, 54, '2025-06-29 04:19:48', 17, 5, 5),
(60, 'Off-White & Red Sneaker ', 'Comfy Off-White & red Sneaker ', 3000.00, 54, '2025-06-29 04:20:52', 16, 5, 5),
(61, 'Shinny Black Shoes ', 'Shinny black shoes ', 3000.00, 54, '2025-06-29 04:21:46', 16, 5, 5),
(62, 'Grey & Black Shoe', 'Grey & black Shoes', 3000.00, 54, '2025-06-29 04:34:02', 16, 5, 5),
(63, 'Cream Hell cut shoes', 'Cream Hell cut shoes by borjan', 2500.00, 54, '2025-06-29 04:36:08', 17, 5, 5),
(64, 'Blue Shirt', 'Blue full sleeve Shirt', 2000.00, 51, '2025-06-29 04:37:24', 14, 5, 5),
(65, 'Comfy White T-shirt', 'Comfy White T-Shirt', 1500.00, 51, '2025-06-29 04:38:37', 14, 5, 4),
(66, 'Plain round T-shirts ', 'Plain Round t-shirts', 1500.00, 51, '2025-06-29 04:42:07', 15, 5, 5),
(67, 'Black & White Skirt', 'Black & white Skirt', 3000.00, 52, '2025-06-29 04:43:05', 15, 5, 5),
(68, 'Brown Skirt', 'comfy Brown Skirt', 1500.00, 52, '2025-06-29 04:44:06', 15, 5, 5),
(69, 'Floral Black & White Skirt', 'Floral Black & White Skirt', 3000.00, 52, '2025-06-29 04:44:53', 15, 5, 5),
(70, 'Cream Comfy Dress', 'Cream Comfy Dress', 2000.00, 52, '2025-06-29 04:45:37', 15, 5, 5),
(71, 'Red & White Top & Skirt', 'Red & White Top & Skirt', 3000.00, 52, '2025-06-29 04:46:33', 15, 5, 3),
(72, 'Dark Brown Skirt', 'Dark Brown Skirt', 3000.00, 52, '2025-06-29 04:47:32', 15, 5, 5),
(73, '25inch LCD', 'Samsung LCD', 25000.00, 41, '2025-06-29 04:48:21', 3, 4, 5),
(74, '32inch LCD', 'Apple 32inch LCD', 32000.00, 41, '2025-06-29 04:49:06', 1, 4, 5),
(75, '40inch LCD', 'LG 40inch LCD', 40000.00, 41, '2025-06-29 04:50:08', 5, 4, 5),
(76, '40inch LCD', 'LG 40inch LCD', 40000.00, 41, '2025-06-29 04:52:38', 5, 4, 5),
(77, 'Girly Watches ', 'Regular Wear Watch', 1500.00, 56, '2025-06-29 04:53:44', 18, 5, 4),
(78, 'Office Watches Girls', '', 2000.00, 56, '2025-06-29 04:54:35', 19, 5, 10),
(79, 'Black Set Watch', 'Black Set Watch', 2000.00, 56, '2025-06-29 04:55:15', 19, 5, 5),
(80, 'Cream Office Watch', 'Cream Office Watch', 2000.00, 56, '2025-06-29 04:56:05', 19, 5, 5),
(81, 'Jet Black Watch', 'Jet Black Watch', 3000.00, 56, '2025-06-29 04:57:08', 18, 5, 5),
(82, 'Brown Leather Watch', 'Brown Leather Watch', 3000.00, 56, '2025-06-29 04:58:12', 18, 5, 5),
(83, 'Black Leather Watch', 'Black Leather Watch', 3000.00, 56, '2025-06-29 04:59:11', 18, 5, 5),
(84, 'Smart Watch', 'iSmart Watch', 5000.00, 56, '2025-06-29 04:59:50', 1, 5, 5),
(85, 'Smart Watch', 'iSmart Watch', 5000.00, 56, '2025-06-29 05:02:21', 1, 5, 5),
(86, 'Hand Mixer', 'Dawlance Hand Mixer', 30000.00, 46, '2025-06-29 05:03:08', 20, 4, 5),
(87, 'Air Fryer', 'Dawlance Air Fryer', 50000.00, 46, '2025-06-29 05:04:07', 20, 4, 5),
(88, 'Electric Mixer Machine ', 'Electric Mixer Machine ', 25000.00, 46, '2025-06-29 05:04:59', 20, 4, 5),
(89, 'Automatic Washing Machine ', 'Automatic Washing Machine ', 50000.00, 43, '2025-06-29 05:05:45', 20, 4, 0),
(90, 'DoubleTub Washing Machine', 'DoubleTub Washing Machine', 50000.00, 43, '2025-06-29 05:06:35', 20, 4, 5),
(91, 'Black Automatic  Washing Machine', 'Black Automatic  Washing Machine', 40000.00, 43, '2025-06-29 05:07:25', 20, 4, 5),
(92, 'Grey Automatic Washing Machine', 'Grey Automatic Washing Machine', 50000.00, 43, '2025-06-29 05:08:30', 20, 4, 5),
(93, 'LEYAOYAO Cube Bookshelf 3', 'The simple upright and open design of the book shelves can help you to save much more space in your room', 5000.00, 32, '2025-07-14 03:49:30', 10, 3, 0),
(94, 'Hunger Nightstand with Charging station', 'This table is more comfotable and use for charging', 6000.00, 32, '2025-07-14 03:51:30', 10, 3, 7),
(106, 'Samsung MX-ST40B Sound Tower Portable Party Speakers', ' The key to a great party is a great sound system. The ST40B sound tower is an all-in-one solution p', 4000.00, 76, '2025-07-15 14:32:37', 3, 1, 100);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`) VALUES
(13, 13, '1752499433-24.jpg'),
(15, 15, '1750976820-3_.jpg'),
(16, 16, '1750978899-4.jpg'),
(17, 17, '1750979066-5.jpg'),
(18, 18, '1750979177-6.jpg'),
(19, 19, '1750979474-7.jpg'),
(20, 20, '1750979665-8.jpg'),
(22, 22, '1750980209-9.jpg'),
(23, 23, '1750983047-10.jpg'),
(24, 24, '1750985505-11.jpg'),
(25, 25, '1750985785-12.jpg'),
(26, 26, '1752502430-25.jpg'),
(27, 27, '1751022023-14.jpg'),
(28, 28, '1751022608-15.jpg'),
(30, 30, '1751023429-16.jpg'),
(31, 31, '1751023606-17.jpg'),
(32, 32, '1751023756-18.jpg'),
(33, 33, '1751038832-16.jpg'),
(34, 34, '1751038843-16.jpg'),
(36, 38, '1751054969-EIF SKIN CARE.jpg'),
(38, 40, '1751055693-EIF SKIN CAREC.jpg'),
(39, 41, '1751056174-EIF SKIN CAR E.jpg'),
(40, 42, '1751056446-61xHTzEr8SL._SX425_.jpg'),
(42, 44, '1751057566-51Kpw2r-pIL._SX425_.jpg'),
(45, 47, '1751141575-3shirts.jpg'),
(46, 48, '1751141629-hoodie.jpg'),
(47, 49, '1751141673-hoodie2.jpg'),
(48, 50, '1751141731-m7.jpg'),
(49, 51, '1751141802-m9.jpg'),
(51, 53, '1751142894-s10.jpg'),
(52, 54, '1751142999-s4.jpg'),
(53, 55, '1751143926-s6.jpg'),
(56, 58, '1751152730-s3.jpg'),
(57, 59, '1751152788-s2.jpg'),
(58, 60, '1751152852-s1.jpg'),
(59, 61, '1751152906-s8.jpg'),
(60, 62, '1751153642-s5.jpg'),
(61, 63, '1751153768-s7.jpg'),
(62, 64, '1751153844-shirt1.jpg'),
(63, 65, '1751153917-shirt2.jpg'),
(64, 66, '1751154127-shirt4.jpg'),
(65, 67, '1751154185-top1.jpg'),
(66, 68, '1751154246-top2.jpg'),
(67, 69, '1751154293-top3.jpg'),
(68, 70, '1751154337-top4.jpg'),
(69, 71, '1751154393-top5.jpg'),
(70, 72, '1751154452-top6.jpg'),
(71, 73, '1751154501-tv1.jpg'),
(72, 74, '1751154546-tv2.jpg'),
(73, 75, '1751154608-tv-3.jpg'),
(74, 76, '1751154758-tv-3.jpg'),
(75, 77, '1751154824-w1.jpg'),
(76, 78, '1751154875-w2.jpg'),
(77, 79, '1751154915-w4.jpg'),
(78, 80, '1751154965-w5.jpg'),
(79, 81, '1751155028-w7.jpg'),
(80, 82, '1751155091-w8.jpg'),
(81, 83, '1751155151-w9.jpg'),
(82, 84, '1751155190-w11.jpg'),
(83, 85, '1751155341-w11.jpg'),
(84, 86, '1751155388-b1.jpg'),
(85, 87, '1751155447-b2.jpg'),
(86, 88, '1751155499-b3.jpg'),
(87, 89, '1751155545-m1.jpg'),
(88, 90, '1751155595-m2.jpg'),
(89, 91, '1751155645-m3.jpg'),
(90, 92, '1751155710-m4.jpg'),
(91, 93, '1752446970-22_.jpg'),
(92, 94, '1752447090-23.jpg'),
(104, 106, '1752571957-81TSvpYhl0L._AC_SX425_.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `review_text`, `created_at`, `updated_at`) VALUES
(188, 9, 44, 3, 'this is a girl product', '2025-07-09 14:59:15', '2025-07-09 14:59:15'),
(194, 61, 44, 3, 'This product is best of best', '2025-07-15 09:48:07', '2025-07-15 09:48:07'),
(195, 61, 42, 3, 'this is a best beauty kit', '2025-07-15 09:50:13', '2025-07-15 09:50:13'),
(197, 9, 83, 3, 'This is abest Washed', '2025-07-18 19:44:37', '2025-07-18 19:44:37');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`) VALUES
(31, 'Home Decor', 3),
(32, 'Furniture', 3),
(33, 'Kitchen & Dining', 3),
(34, 'Bedding & Bath', 3),
(35, 'Lighting', 3),
(36, 'Storage & Organizers', 3),
(37, 'Clocks & Wall Art', 3),
(38, 'Rugs & Carpets', 3),
(39, 'Gardening Tools & Supplies', 3),
(40, 'Candles & Fragrances', 3),
(41, 'Televisions', 4),
(42, 'Refrigerators', 4),
(43, 'Washing Machines', 4),
(44, 'Air Conditioners', 4),
(45, 'Microwave Ovens', 4),
(46, 'Kitchen Appliances', 4),
(47, 'Vacuum Cleaners', 4),
(48, 'Water Purifiers', 4),
(49, 'Fans & Air Coolers', 4),
(50, 'Geysers & Heaters', 4),
(51, 'Men\'s Clothing', 5),
(52, 'Women\'s Clothing', 5),
(53, 'Kids & Baby Clothing', 5),
(54, 'Footwear', 5),
(55, 'Bags & Luggage', 5),
(56, 'Watches', 5),
(57, 'Sunglasses & Eyewear', 5),
(58, 'Jewelry & Accessories', 5),
(59, 'Innerwear & Sleepwear', 5),
(60, 'Ethnic & Traditional Wear', 5),
(61, 'Academic Books', 6),
(62, 'Novels & Literature', 6),
(63, 'Children\'s Books', 6),
(64, 'Exam Preparation Books', 6),
(65, 'Office Supplies', 6),
(66, 'Notebooks & Diaries', 6),
(67, 'Art Supplies', 6),
(68, 'Pens & Writing Instruments', 6),
(69, 'Files & Folders', 6),
(70, 'Calculators', 6),
(71, 'School Supplies', 6),
(72, 'Greeting Cards & Gift Wrap', 6),
(73, 'Mobile Phone', 1),
(76, 'Audio Devices', 1),
(77, 'Cameras', 1),
(89, 'Skincare', 2),
(90, 'Hair Care', 2),
(91, 'Personal Care', 2),
(92, 'Makeup', 2),
(93, 'Fragrances', 2),
(94, 'Beauty Tools', 2),
(95, 'Health Devices', 2),
(96, 'Vitamins & Supplements', 2),
(97, 'Men\'s Grooming', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_profile` varchar(255) NOT NULL DEFAULT '',
  `gender` enum('male','female') DEFAULT 'male',
  `email_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `status`, `created_at`, `updated_at`, `user_profile`, `gender`, `email_token`, `token_expiry`) VALUES
(9, 'Haris', 'Haris333@gmail.com', '$2y$10$o1.w/PB0G7N3IcBxNzUa1.DBelcUaS/HYdVws84MQvVhyjs1mPtvS', '03128727336', 'user', 'active', '2025-07-04 09:07:46', '2025-07-15 13:32:12', '1752098352-Young man face avater vector illustration design _ Premium Vector.jpg', 'male', NULL, NULL),
(37, 'Abdullah', 'abdullahsidzz333@gmail.com', '$2y$10$CRNrx0U.G7XHX21GIPp29.HVQ.wSj6lmI0k4FOYZZ8Kh5LUPEBA16', '03160117489', 'admin', 'active', '2025-07-06 04:40:34', '2025-07-15 13:32:32', '', 'male', NULL, NULL),
(61, 'Fozia Naz', 'fozianaz140@gmail.com', '$2y$10$6bBMJlDgHocssY0MSl2.7upQOeq4T5C4k7ZjWuxoLwQ7jtrcBqOGu', '03128727334', 'user', 'active', '2025-07-11 03:15:18', '2025-07-11 03:40:31', '1752187231-girl.jpg', 'male', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_ibfk_1` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
