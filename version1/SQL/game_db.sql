-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS game_db;

-- Use the created database
USE game_db;

-- Create the 'users' table to store user details
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the 'questions' table to store quiz questions
CREATE TABLE IF NOT EXISTS questions (
    qid INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL
);

-- Create the 'answers' table to store answers for each question
CREATE TABLE IF NOT EXISTS answers (
    ans_id INT AUTO_INCREMENT PRIMARY KEY,
    qid INT NOT NULL,
    answer TEXT NOT NULL,
    is_correct BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (qid) REFERENCES questions(qid) ON DELETE CASCADE
);

-- Create the 'game_results' table to store game results for users
CREATE TABLE IF NOT EXISTS game_results (
    result_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    result VARCHAR(255) NOT NULL, -- 'game over' or 'completed'
    lives_used INT NOT NULL,
    level INT NOT NULL,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Example INSERT statements for questions and answers
INSERT INTO questions (question) VALUES 
("Order these letters in ascending order: A, C, B, D"),
("Order these numbers in ascending order: 5, 1, 4, 3, 2");

INSERT INTO answers (qid, answer, is_correct) VALUES 
(1, 'A', TRUE),
(1, 'B', FALSE),
(1, 'C', FALSE),
(1, 'D', FALSE),
(2, '1', TRUE),
(2, '2', FALSE),
(2, '3', FALSE),
(2, '4', FALSE);

-- You can add more questions and answers as needed.
