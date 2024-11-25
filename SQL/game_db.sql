SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create the 'answers' table to store answers for each question
CREATE TABLE `answers` (
  `aid` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `qid` int(11) NOT NULL,
  PRIMARY KEY (`aid`),
  FOREIGN KEY (`qid`) REFERENCES `questions`(`qid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample answers for questions
INSERT INTO `answers` (`qid`, `answer`, `aid`) VALUES 
(1, 'A', 1),
(1, 'B', 0),
(1, 'C', 0),
(1, 'D', 0),
(2, '1', 1),
(2, '2', 0),
(2, '3', 0),
(2, '4', 0);

-- Create the 'questions' table to store quiz questions
CREATE TABLE `questions` (
    `qid` INT AUTO_INCREMENT PRIMARY KEY,
    `question` TEXT NOT NULL
);

-- Create the 'users' table to store user details
CREATE TABLE `users` (
    `user_id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create unique index for the email column
CREATE UNIQUE INDEX `idx_email` ON `users`(`email`);

-- Create the 'game_results' table to store game results for users
CREATE TABLE `game_results` (
    `result_id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `result` VARCHAR(255) NOT NULL, -- 'game over' or 'completed'
    `lives_used` INT NOT NULL,
    `level` INT NOT NULL,
    `completed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
);

-- Example INSERT statements for questions
INSERT INTO `questions` (`question`) VALUES 
("Order these letters in ascending order: A, C, B, D"),
("Order these numbers in ascending order: 5, 1, 4, 3, 2");

COMMIT;

-- You can add more questions and answers as needed.
