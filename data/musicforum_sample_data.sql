-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 14, 2024 at 08:32 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `musicforum`
--

--
-- Tabela Truncate przed wstawieniem `likes`
--

TRUNCATE TABLE `likes`;
--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `post_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(5, 2, 3),
(6, 1, 4),
(7, 3, 4),
(8, 2, 5),
(9, 3, 5),
(10, 4, 1),
(11, 4, 3),
(12, 2, 6),
(13, 1, 6),
(14, 1, 5);

--
-- Tabela Truncate przed wstawieniem `post`
--

TRUNCATE TABLE `post`;
--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `title`, `text`, `date`, `data`, `user_id`) VALUES
(1, 'Top 10 Rock Albums', 'Jakie są Wasze ulubione rockowe albumy wszechczasów? Oto moja lista: od klasyki lat 70-tych po nowoczesne arcydzieła. \r\n    Zaczynam od Led Zeppelin IV, bo utwory takie jak \"Stairway to Heaven\" są ponadczasowe. \r\n    Kolejny to \"The Wall\" od Pink Floyd – ten album jest doświadczeniem samym w sobie. Na trzecim miejscu \"Back in Black\" AC/DC, energia tego albumu jest nie do podrobienia. \r\n    Co Wy dodalibyście do tej listy?', '2024-11-14 12:00:00', '[\"/data/post1-1.jpg\", \"/data/post1-2.jpg\", \"/data/post1-5.jpg\", \"/data/post1-3.jpg\", \"/data/post1-4.jpg\"]', 3),
(2, 'Czy warto uczyć się gry na gitarze?', 'Rozważam naukę gry na gitarze, ale zastanawiam się, czy to dobry pomysł na późnym etapie życia. Jakie są wasze doświadczenia? \r\n    Ile czasu trzeba poświęcić na codzienną praktykę, żeby zacząć odczuwać postępy? Słyszałem, że w początkowym okresie najtrudniejsze jest przezwyciężenie bólu palców i nauczenie się podstawowych chwytów. \r\n    Czy macie jakieś sprawdzone metody, by ułatwić sobie start? A może znacie dobre materiały dla początkujących? Z góry dziękuję za wszelkie rady!', '2024-11-14 13:00:00', NULL, 1),
(3, 'Najlepsze koncerty, na których byłem', 'Podzielcie się swoimi wspomnieniami z koncertów! Pamiętam pierwszy raz, kiedy byłem na żywo na występie Metallica – brzmienie gitary, energia w tłumie, \r\n    to było niesamowite przeżycie. Potem miałem okazję zobaczyć The Rolling Stones na ich jubileuszowej trasie – Mick Jagger i ekipa pokazali, że wiek to tylko liczba! \r\n    A jaki koncert najbardziej utkwił Wam w pamięci? Czy jest jakiś występ, na który marzycie, aby pójść?', '2024-11-14 14:00:00', NULL, 2),
(4, 'Najlepsze albumy jazzowe', 'Zainteresowałam się jazzem, a szczególnie fascynują mnie klasyki takich artystów jak Miles Davis czy John Coltrane. \r\n    Czy możecie polecić mi swoje ulubione albumy jazzowe, które warto poznać? Na razie na szczycie mojej listy są \"Kind of Blue\" i \"A Love Supreme\". \r\n    Co Wy byście dodali do tej listy?', '2024-11-14 15:00:00', '[\"/data/post4-3.jpg\", \"/data/post4-1.jpg\", \"/data/post4-2.jpg\"]', 4),
(5, 'Wpływ muzyki na nastrój i emocje', 'Czy zauważyliście, jak muzyka wpływa na wasze samopoczucie? Ostatnio odkryłam, że słuchanie jazzu pomaga mi się odprężyć po ciężkim dniu. \r\n    Ciekawi mnie, jakie gatunki muzyczne pomagają Wam w różnych sytuacjach – na przykład, czego słuchacie, gdy potrzebujecie energii albo wyciszenia?', '2024-11-14 16:00:00', '[\"/data/post5-1.png\", \"/data/post5-2.jpg\"]', 4),
(6, 'Powrót winyli - moda czy prawdziwa pasja?', 'Wielu moich znajomych zaczęło kolekcjonować płyty winylowe. Zastanawiam się, co sprawia, że winyle znów są tak popularne? \r\n    Czy to tylko moda, czy może faktycznie jest coś wyjątkowego w ich brzmieniu? Osobiście nie mam jeszcze kolekcji, ale zaczynam się nad tym zastanawiać. \r\n    Jakie są Wasze doświadczenia z winylami?', '2024-11-14 17:00:00', '[\"/data/post6-1.jpeg\"]', 4);

--
-- Tabela Truncate przed wstawieniem `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `login`, `user_name`, `password`, `email`, `profile_picture`) VALUES
(1, 'meloman1', 'Jan Kowalski', '$2y$10$8AexPYWO1CCioAxnjYgMYOhGlAZuYdCYm7wJC4TtJMsy.zm1JoXhy', 'jan.kowalski@example.com', '/img/profiles/default.jpg'),
(2, 'dj_kasia', 'Katarzyna Nowak', '$2y$10$8AexPYWO1CCioAxnjYgMYOhGlAZuYdCYm7wJC4TtJMsy.zm1JoXhy', 'kasia.nowak@example.com', '/img/profiles/default.jpg'),
(3, 'rocker', 'Paweł Adamski', '$2y$10$8AexPYWO1CCioAxnjYgMYOhGlAZuYdCYm7wJC4TtJMsy.zm1JoXhy', 'pawel.adamski@example.com', '/img/profiles/default.jpg'),
(4, 'jazzlover', 'Marta Wróbel', '$2y$10$8AexPYWO1CCioAxnjYgMYOhGlAZuYdCYm7wJC4TtJMsy.zm1JoXhy', 'marta.wrobel@example.com', '/img/profiles/default.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
