

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `engine` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `max_speed` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `cars` (`id`, `brand`, `model`, `year`, `engine`, `color`, `max_speed`, `price`) VALUES
(1, 'chevrolet', 'camaro', 2017, 3564, 'blue', 250, 60000),
(2, 'bmw', '7ser', 2009, 2993, 'black', 245, 18000),
(3, 'fiat', 'Grande Punto', 2009, 1242, 'white', 155, 7000),
(4, 'volvo', 's90', 2017, 2000, 'grey', 250, 37000),
(5, 'infiniti', 'q50', 2017, 3696, 'grey', 250, 30000),
(6, 'toyota', 'sequoia', 2017, 4608, 'grey', 205, 75000),
(7, 'skoda', 'fabia', 2017, 1600, 'green', 150, 5000),
(8, 'opel', 'vivara', 2016, 2500, 'white', 170, 13000),
(9, 'skoda', 'Octavia', 2016, 1900, 'gold', 220, 13000),
(10, 'subaru', 'impreza wrx', 2014, 2500, 'blue', 300, 15000),
(12, 'mitsubishi', 'lancer evolution', 2012, 3500, 'blue', 320, 17000)



ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
