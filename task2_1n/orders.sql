
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_car` int(11) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `payment` enum('credit_card','cash') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `orders` (`id`, `id_car`, `f_name`, `l_name`, `payment`) VALUES
(19, 13, 'User1', 'user1', 'cash'),
(20, 6, 'User2', 'user2', 'credit_card');


ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
