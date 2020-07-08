-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 08, 2020 at 02:21 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company_sta`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Robotic Cells'),
(2, 'Special Machines'),
(3, 'Electrical Services');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(1000) NOT NULL,
  `body` longtext NOT NULL,
  `date` date NOT NULL,
  `author` varchar(50) NOT NULL,
  `token` varchar(40) NOT NULL,
  `status` int(11) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `summary`, `body`, `date`, `author`, `token`, `status`, `users_id`) VALUES
(1, 'Officia architecto voluptate.', 'Ex quo quo sapiente atque rem sed.', 'Officiis qui numquam odit ipsam omnis. Odio eos voluptates doloribus optio magnam aut. Et id dolorem atque quaerat omnis. Necessitatibus saepe ipsa beatae nulla et rerum voluptatem. Et dignissimos illum animi impedit natus. Ut nihil aut non debitis repellat laudantium. Voluptatem odio rerum reprehenderit possimus. Cum voluptatem eos ipsam qui placeat rerum voluptatum.', '1980-01-26', 'Sherman Wehner', '0b60b75f-5d96-324a-8644-0ab57760b50d', 2, 1),
(2, 'Sunt dignissimos.', 'Adipisci molestias quia fugiat consectetur exercitationem molestiae eum.', 'Ratione dolorum eius blanditiis qui. Itaque accusantium omnis fugiat laboriosam molestiae et. Totam doloribus in sunt reprehenderit officia. Exercitationem omnis sint velit repudiandae vel et. Unde et ut corrupti dolor architecto dolorem veritatis. Nisi doloribus ipsum nihil numquam temporibus accusantium ab. Nobis nisi fuga nostrum asperiores esse.', '2019-05-06', 'Prof. Vernice Leffler', 'ba1d6dbb-7dc8-35e0-a9b8-5e0877faf9e3', 2, 1),
(3, 'Quidem est quia suscipit.', 'Nisi qui unde fuga dolor aliquam et iste harum.', 'Architecto est repellendus et exercitationem. Veniam consequatur nobis temporibus distinctio molestiae. Ipsum beatae rerum ipsa maiores natus perspiciatis soluta. Nihil accusamus dolorem nam dolor nulla nihil. Aut fugit qui sed enim. Quam eveniet autem sapiente. Provident et cumque reiciendis laudantium dolorem.', '1996-04-04', 'Micaela Kuvalis', '5cf48a50-7236-3bae-9b55-913823605e4a', 2, 1),
(4, 'Et magnam esse.', 'Hic enim reprehenderit sed quia itaque.', 'Velit sit similique quae placeat et vitae vel et. Voluptatum dicta ut consectetur aut nihil. Quas aut sit aut et totam ducimus. Ut explicabo voluptatem fuga eligendi voluptatem qui qui explicabo.', '2002-12-17', 'Hermann Dare Jr.', '8452118d-4beb-33ed-8fa1-60b5b4ceeb16', 2, 1),
(5, 'Doloremque omnis aliquam sequi.', 'Officiis quas qui minus magnam.', 'Eveniet aut doloremque in omnis. Nemo praesentium eos et sed accusantium neque voluptate. Est dolores corporis id repellat porro distinctio eaque provident. Et harum alias qui ratione ut officiis. Corrupti non rerum voluptas necessitatibus dolorem aut inventore. Dicta odio dicta nihil labore nemo vitae. Cumque optio velit exercitationem ut. Ratione mollitia laborum officiis ipsam voluptatibus ad.', '1981-04-13', 'Drew Hegmann DVM', '9ec39088-c0d8-3e5d-8bd7-59c6641dd59e', 2, 1),
(6, 'Aut est labore laudantium.', 'Aliquid odit est ducimus enim.', 'Omnis in modi doloremque impedit sed voluptas natus. Voluptatibus esse quo vel eveniet illo molestias suscipit. Enim sunt sequi dolores et quas sequi. Et et labore natus deleniti numquam natus vel. Sapiente eum quidem vitae hic iusto sunt. Qui corrupti laudantium maxime aliquid et asperiores. Rerum illum vero vel qui est.', '1971-03-27', 'Karlie Auer', 'df19eb4e-c3b4-3c00-bf74-59140e4ab8ba', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `summary` varchar(1000) DEFAULT NULL,
  `body` longtext NOT NULL,
  `date` date NOT NULL,
  `token` varchar(40) NOT NULL,
  `status` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `summary`, `body`, `date`, `token`, `status`, `categories_id`, `users_id`) VALUES
(1, 'Omnis enim facilis reiciendis.', 'Consequatur soluta porro adipisci.', 'Eos culpa debitis qui dolores. Quae voluptas aut at facere omnis et sunt. Debitis ipsa in magnam earum. Vitae iure perspiciatis delectus sed vel. Voluptatem unde nam doloribus. Repudiandae beatae modi et ea illo et. Ipsum qui est ea aliquam sed aut incidunt qui.', '2005-04-26', '5c4534a3-7208-3b2b-a91f-650471e36b7d', 0, 2, 1),
(2, 'Enim maiores sed nobis.', 'Alias sit impedit aut ut ratione earum.', 'Explicabo unde saepe qui autem eos. Sunt eum laboriosam a fugiat. Tenetur aut sunt omnis laudantium. Dolor possimus quaerat totam nam facilis tempore. Sit possimus ipsam perferendis. Doloremque ipsa magni veniam cumque. Aspernatur voluptas placeat voluptas aut eum minus.', '1973-04-14', '0b4db60b-a3e1-3e81-8b62-d7954eb946e6', 2, 3, 1),
(3, 'Corporis pariatur et dolorum.', 'Nam beatae itaque ratione et minus ullam et.', 'Facilis velit beatae qui inventore omnis. Velit est qui iste a consequatur qui. Esse molestiae accusantium dolorem magni inventore rerum totam natus. Aliquam quas eos laboriosam iure expedita. Aperiam sequi voluptas dolore recusandae. Esse at asperiores optio hic voluptatibus voluptates. Et qui blanditiis qui voluptatibus nisi reprehenderit incidunt.', '1985-10-27', 'c0dbec7a-22eb-3797-b2e4-74038930c276', 0, 3, 1),
(4, 'Sapiente commodi veritatis rerum.', 'Minima nulla maiores illo dignissimos eum iusto et.', 'Nesciunt dignissimos labore consequuntur maxime reprehenderit. Ipsum officiis rem commodi quia dolores rerum cupiditate enim. Fugit id autem placeat itaque sunt. Aut pariatur placeat voluptas et id sunt. Et est odio quisquam iste. Repellendus eum aut molestias omnis fugit reiciendis eos. Eligendi atque magni vel fugit voluptatem. Excepturi eos itaque voluptatum dolores aut qui.', '2016-09-14', '94a98085-44d9-31a7-adcf-6b86be2fce15', 0, 3, 1),
(5, 'Neque maxime explicabo harum.', 'Voluptates voluptas occaecati enim nesciunt unde voluptas.', 'Aliquid et enim aut explicabo impedit aspernatur quia error. Et consequatur dolor ipsa autem molestias facilis. Et autem aliquam sed ipsum autem. Vel id suscipit modi vitae qui aliquam. Quibusdam vel asperiores quae accusamus. Exercitationem accusantium necessitatibus maiores eum libero.', '1995-09-02', 'b04f0f28-45ea-3fb4-8ab8-b744614fc7b6', 0, 2, 1),
(6, 'Ullam sit enim quo.', 'Rerum sit qui et non.', 'Qui ratione sapiente aliquid ducimus perferendis. Quia quo expedita ipsam. A similique saepe culpa omnis ipsam commodi. Alias molestias eum error eum. Ut beatae ad reiciendis est. Aperiam ut eligendi sit est sit reprehenderit. Qui voluptatem non omnis suscipit iste natus et. Aliquam ab perspiciatis numquam esse quam modi. Quas cumque alias adipisci modi est. Ea laboriosam aut maiores autem.', '1990-05-02', '87098438-a4c7-380f-a7c0-a7a1eb338b67', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `token` varchar(128) NOT NULL,
  `level` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `token`, `level`, `registration_date`) VALUES
(1, 'Amorim+Admin', 'andreamorimsimoes@gmail.com', '$2y$10$IaRdD3/u247hVQxGrfchau2Z4tJsmATI1nRQtIOgCpK0IrW7OSxz2', 1, '6b383f5c-8d67-3ceb-89f8-c833e4f57f3b', 2, '2020-07-08 11:35:46'),
(2, 'Dr. Rahsaan Turcotte IV', 'stefanie84@okeefe.com', '&f86d,`RT9OlZ+Au*ca5', 0, '80c47f6b-26fb-386c-813d-4514ad59d592', 1, '1972-05-11 15:17:31'),
(3, 'Mr. Miles Erdman', 'orpha.kunze@gmail.com', '8~SuovIh@6c(;e0:', 1, 'a35a75f9-b9cc-3193-9be4-0b428f79ff21', 1, '2019-09-19 20:26:20'),
(4, 'Alvena McGlynn', 'velma70@hotmail.com', '{Ccz]e<)V^', 1, 'bdddfbb0-1ad3-3cd9-9db0-a90e03d659d6', 1, '1981-09-21 20:51:49'),
(5, 'Kyleigh Reichert', 'becker.lillian@goyette.com', 'IkWkED0bTOLX', 0, '209cd5b5-517b-3b0d-9ed4-8f655a4631e9', 1, '2006-01-03 16:25:17'),
(6, 'Quincy Becker Sr.', 'hermann84@gmail.com', '|d1tJ6Q#be', 1, '937d8e96-1257-3c92-9340-4c6969f64919', 1, '1978-11-16 01:55:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_news_users1_idx` (`users_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_categories1_idx` (`categories_id`),
  ADD KEY `fk_products_users1_idx` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_products_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
