-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Cze 2021, 21:28
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `shop`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `course`
--

CREATE TABLE `course` (
  `courseID` int(11) NOT NULL,
  `name` text NOT NULL,
  `prize` double NOT NULL,
  `description` text NOT NULL,
  `photoSource` text NOT NULL,
  `videoSource` text NOT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`tags`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `course`
--

INSERT INTO `course` (`courseID`, `name`, `prize`, `description`, `photoSource`, `videoSource`, `tags`) VALUES
(18, 'Kurs podstaw css', 29.99, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sollicitudin odio non nisl accumsan consectetur. Maecenas egestas scelerisque dapibus. Nulla eget porta dolor, vel pretium dui. Quisque consequat lacus maximus nunc varius, eu mollis massa convallis. Integer at diam vel mi imperdiet mollis varius ut neque. Cras interdum est massa, ut ornare nulla elementum id. Suspendisse quis mattis velit. Sed bibendum laoreet venenatis. Nullam vel libero eu mi malesuada consectetur. Etiam erat nunc, luctus ac vestibulum quis, laoreet laoreet neque. Vestibulum lacinia est eget urna aliquet, ut ullamcorper est commodo.\n\nNulla eget sodales metus, vel lacinia turpis. Donec vel ante et velit aliquam bibendum. Donec molestie nec sapien eget tempus. Nunc ac augue eu ligula sagittis posuere in quis nunc. Donec ullamcorper, metus sed cursus semper, lorem lorem condimentum nunc, quis congue lacus libero ut magna. Curabitur aliquam dapibus euismod. Nulla non risus non ipsum maximus sollicitudin at a dui. Maecenas eget lectus ac felis convallis placerat. In consectetur ligula at erat sollicitudin, congue placerat elit tincidunt. Donec id consectetur dui.\n\nInteger eu urna ipsum. Maecenas non nisl ut urna auctor hendrerit eu vitae purus. In dictum diam vitae sapien gravida, vitae tempus nibh tincidunt. Duis vitae tincidunt enim, et gravida purus. Phasellus risus erat, suscipit at orci vitae, hendrerit bibendum leo. In vitae leo eu ex mollis accumsan nec vel odio. Quisque fringilla sem magna, id iaculis tellus vulputate id.\n\nNulla non tellus quis ligula porttitor euismod. Pellentesque pulvinar vitae elit eu fermentum. Duis elementum ultrices efficitur. Pellentesque scelerisque facilisis mattis. Fusce nec pellentesque sapien. Sed sed hendrerit nisl. Cras felis ante, eleifend ut lectus eget, viverra tempor dolor. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed vitae fermentum tellus. Donec sollicitudin elementum congue. Cras rutrum nunc sapien. Sed aliquet porta neque et faucibus. Aliquam consectetur mauris elit, in rhoncus velit porta non. Suspendisse sodales diam turpis, sed bibendum risus euismod vel.\n\nMaecenas faucibus eros arcu, in aliquam dui varius ut. Sed molestie volutpat urna, et pretium lorem ultrices eu. Duis mollis bibendum nisi, vehicula fringilla odio. Sed at arcu justo. Integer libero arcu, molestie sed laoreet id, tristique at felis. In hac habitasse platea dictumst. Sed finibus lobortis elit, sed sollicitudin neque porta eget. Nam volutpat tempor tellus id vulputate. Nunc vestibulum vitae metus in mattis. Aliquam suscipit egestas purus id sollicitudin. Morbi finibus augue at nisi semper, at volutpat nunc imperdiet.', '60bcdb34915656.15482706.png', '60bcdb34915656.15482706.mp4', '[\"html\",\"css\"]'),
(19, 'Zaawansowany html', 19.99, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sollicitudin odio non nisl accumsan consectetur. Maecenas egestas scelerisque dapibus. Nulla eget porta dolor, vel pretium dui. Quisque consequat lacus maximus nunc varius, eu mollis massa convallis. Integer at diam vel mi imperdiet mollis varius ut neque. Cras interdum est massa, ut ornare nulla elementum id. Suspendisse quis mattis velit. Sed bibendum laoreet venenatis. Nullam vel libero eu mi malesuada consectetur. Etiam erat nunc, luctus ac vestibulum quis, laoreet laoreet neque. Vestibulum lacinia est eget urna aliquet, ut ullamcorper est commodo.\n\nNulla eget sodales metus, vel lacinia turpis. Donec vel ante et velit aliquam bibendum. Donec molestie nec sapien eget tempus. Nunc ac augue eu ligula sagittis posuere in quis nunc. Donec ullamcorper, metus sed cursus semper, lorem lorem condimentum nunc, quis congue lacus libero ut magna. Curabitur aliquam dapibus euismod. Nulla non risus non ipsum maximus sollicitudin at a dui. Maecenas eget lectus ac felis convallis placerat. In consectetur ligula at erat sollicitudin, congue placerat elit tincidunt. Donec id consectetur dui.', '60bcdb869eed03.26374622.png', '60bcdb869eed03.26374622.mp4', '[\"html\"]'),
(20, 'Podstawy php', 30.99, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sollicitudin odio non nisl accumsan consectetur. Maecenas egestas scelerisque dapibus. Nulla eget porta dolor, vel pretium dui. Quisque consequat lacus maximus nunc varius, eu mollis massa convallis. Integer at diam vel mi imperdiet mollis varius ut neque. Cras interdum est massa, ut ornare nulla elementum id. Suspendisse quis mattis velit. Sed bibendum laoreet venenatis. Nullam vel libero eu mi malesuada consectetur. Etiam erat nunc, luctus ac vestibulum quis, laoreet laoreet neque. Vestibulum lacinia est eget urna aliquet, ut ullamcorper est commodo.', '60bcdbecd0bbc3.72806085.png', '60bcdbecd0bbc3.72806085.mp4', '[\"html\",\"php\"]'),
(21, 'Podstawy JS', 22.99, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sollicitudin odio non nisl accumsan consectetur. Maecenas egestas scelerisque dapibus. Nulla eget porta dolor, vel pretium dui. Quisque consequat lacus maximus nunc varius, eu mollis massa convallis. Integer at diam vel mi imperdiet mollis varius ut neque. Cras interdum est massa, ut ornare nulla elementum id. Suspendisse quis mattis velit. Sed bibendum laoreet venenatis. Nullam vel libero eu mi malesuada consectetur. Etiam erat nunc, luctus ac vestibulum quis, laoreet laoreet neque. Vestibulum lacinia est eget urna aliquet, ut ullamcorper est commodo.', '60bcdc1e8e4a53.41474636.png', '60bcdc1e8e4a53.41474636.mp4', '[\"html\",\"js\",\"css\"]');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinion`
--

CREATE TABLE `opinion` (
  `opinionID` int(11) NOT NULL,
  `rating` double NOT NULL,
  `opinionContent` text NOT NULL,
  `opinionDateTime` datetime NOT NULL,
  `relationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `opinion`
--

INSERT INTO `opinion` (`opinionID`, `rating`, `opinionContent`, `opinionDateTime`, `relationID`) VALUES
(30, 5, 'Super kurs. Wiele się nauczyłem', '2021-06-06 16:34:58', 26),
(31, 4, 'Super kurs, tylko przydało by się trochę więcej przykładów', '2021-06-06 16:36:44', 27),
(32, 5, 'polecam', '2021-06-06 16:41:34', 27),
(33, 5, 'Polecam', '2021-06-06 17:08:24', 28),
(34, 5, 'Super kurs', '2021-06-06 17:13:42', 30);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `relation`
--

CREATE TABLE `relation` (
  `relationID` int(11) NOT NULL,
  `bought` tinyint(4) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `currentTime` float NOT NULL,
  `relationDate` date NOT NULL,
  `courseID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `relation`
--

INSERT INTO `relation` (`relationID`, `bought`, `published`, `currentTime`, `relationDate`, `courseID`, `userID`) VALUES
(22, 0, 1, 0.518677, '2021-06-06', 18, 24),
(23, 0, 1, 0, '2021-06-06', 19, 24),
(24, 0, 1, 0, '2021-06-06', 20, 2),
(25, 0, 1, 0, '2021-06-06', 21, 2),
(26, 1, 0, 2.59156, '2021-06-06', 18, 2),
(27, 1, 0, 0, '2021-06-06', 18, 27),
(28, 1, 0, 0, '2021-06-06', 21, 24),
(30, 1, 0, 0, '2021-06-06', 21, 27);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`userID`, `username`, `password`, `email`) VALUES
(2, 'Karol', '$2y$10$EHOo0/WTMirfGNUwIAAh3eMQP3z34M.KQaR.mOlmlv4W/sN4dxFzO', 'karol@zakole.pl'),
(24, 'Fifon', '$2y$10$8gXLVBfvfbcpdSsG.2IQbuY/wkaBMrytqUVpePXJqpb17s4Rt9nr6', 'fifon@wp.pl'),
(27, 'orzeł', '$2y$10$4ikkrre6mwdWElcwU5z/k.1sseKXQFwmXe60z4O9f7a2fJN5uEbgK', 'orzel@eee.pl');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseID`);

--
-- Indeksy dla tabeli `opinion`
--
ALTER TABLE `opinion`
  ADD PRIMARY KEY (`opinionID`),
  ADD KEY `relationID` (`relationID`);

--
-- Indeksy dla tabeli `relation`
--
ALTER TABLE `relation`
  ADD PRIMARY KEY (`relationID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `courseID` (`courseID`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `course`
--
ALTER TABLE `course`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `opinion`
--
ALTER TABLE `opinion`
  MODIFY `opinionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT dla tabeli `relation`
--
ALTER TABLE `relation`
  MODIFY `relationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `opinion`
--
ALTER TABLE `opinion`
  ADD CONSTRAINT `opinion_ibfk_1` FOREIGN KEY (`relationID`) REFERENCES `relation` (`relationID`);

--
-- Ograniczenia dla tabeli `relation`
--
ALTER TABLE `relation`
  ADD CONSTRAINT `courseID` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`),
  ADD CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
