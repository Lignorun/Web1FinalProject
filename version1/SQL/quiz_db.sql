
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS quiz_db;

-- Use the created database
USE quiz_db;


CREATE TABLE `answers` (
  `aid` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `ans_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `answers` (`aid`, `answer`, `ans_id`) VALUES
(1, 'Iron Man', 1),
(2, 'Sherlock Holmes', 1),
(3, 'Avatar', 1),
(4, 'Detective Doodle', 1),
(5, 'India', 2),
(6, 'United States', 2),
(7, 'Finland', 2),
(8, 'Germany', 2),
(9, 'Mercury', 3),
(10, 'Venus', 3),
(11, 'Earth', 3),
(12, 'Mars', 3),
(13, 'Alpha', 4),
(14, 'Beta', 4),
(15, 'Gamma', 4),
(16, 'Delta', 4);



CREATE TABLE `questions` (
  `qid` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `ans_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `questions` (`qid`, `question`, `ans_id`) VALUES
(1, 'What character has both Robert Downey Jr. and Benedict Cumberbatch played?', 2),
(2, 'What country drinks the most coffee per capita?', 7),
(3, 'Which planet in the Milky Way is the hottest?', 10),
(4, 'What is the 4th letter of the Greek alphabet?', 16);



CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Pawan', 'pawan@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b');


ALTER TABLE `answers`
  ADD PRIMARY KEY (`aid`);


ALTER TABLE `questions`
  ADD PRIMARY KEY (`qid`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `answers`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;


ALTER TABLE `questions`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

ss