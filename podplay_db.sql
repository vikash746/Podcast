CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_image VARCHAR(100) DEFAULT 'default.jpg',
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    icon VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Podcasts table
CREATE TABLE IF NOT EXISTS podcasts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    host VARCHAR(100) NOT NULL,
    cover_image VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    is_featured BOOLEAN DEFAULT 0,
    rating DECIMAL(3,1) DEFAULT 0.0,
    listens INT DEFAULT 0,
    episode_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Episodes table
CREATE TABLE IF NOT EXISTS episodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    podcast_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    audio_file VARCHAR(100) NOT NULL,
    duration VARCHAR(10) NOT NULL,
    release_date DATE NOT NULL,
    listens INT DEFAULT 0,
    show_notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (podcast_id) REFERENCES podcasts(id) ON DELETE CASCADE
);

-- Likes table
CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    episode_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, episode_id)
);

-- Subscriptions table
CREATE TABLE IF NOT EXISTS subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    podcast_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (podcast_id) REFERENCES podcasts(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, podcast_id)
);

-- Sample data insertion
-- Categories
INSERT INTO categories (name, icon) VALUES 
('Technology', 'fas fa-laptop-code'),
('Business', 'fas fa-briefcase'),
('Science', 'fas fa-flask'),
('Health', 'fas fa-heartbeat'),
('Comedy', 'fas fa-laugh'),
('True Crime', 'fas fa-search'),
('News', 'fas fa-newspaper'),
('Sports', 'fas fa-football-ball');

-- Podcasts
INSERT INTO podcasts (title, description, host, cover_image, category, is_featured, rating, episode_count) VALUES
('Tech Today', 'A daily podcast covering the latest in technology news and trends.', 'Alex Johnson', 'tech-today.jpg', 'Technology', 1, 4.8, 156),
('Business Insights', 'Interviews with successful entrepreneurs and business leaders.', 'Sarah Miller', 'business-insights.jpg', 'Business', 0, 4.6, 89),
('Science Weekly', 'Exploring the wonders of science and new discoveries.', 'Dr. Michael Lee', 'science-weekly.jpg', 'Science', 0, 4.7, 112),
('Health Matters', 'Tips and advice for a healthier lifestyle.', 'Emma Davis', 'health-matters.jpg', 'Health', 0, 4.5, 74),
('Comedy Hour', 'An hour of laughter with top comedians.', 'Chris Wilson', 'comedy-hour.jpg', 'Comedy', 0, 4.9, 203),
('True Crime Stories', 'In-depth analysis of famous criminal cases.', 'Detective Jane Parker', 'true-crime.jpg', 'True Crime', 0, 4.8, 95),
('News Roundup', 'Daily summary of top news stories.', 'Robert Taylor', 'news-roundup.jpg', 'News', 0, 4.3, 312),
('Sports Talk', 'Discussion of the latest sports events and interviews with athletes.', 'Mike Johnson', 'sports-talk.jpg', 'Sports', 0, 4.4, 128);

-- Episodes (for Tech Today podcast)
INSERT INTO episodes (podcast_id, title, description, audio_file, duration, release_date, listens, show_notes) VALUES
(1, 'The Future of AI', 'Exploring how artificial intelligence is shaping our future.', 'tech_ai_episode.mp3', '45:20', '2023-06-15', 12500, 'In this episode, we discuss:\n- The latest advancements in AI\n- Ethical considerations\n- How AI will impact jobs\n- Interviews with AI experts'),
(1, 'Blockchain Revolution', 'Understanding blockchain technology beyond cryptocurrencies.', 'tech_blockchain.mp3', '38:15', '2023-06-08', 9800, 'Key points:\n- Blockchain basics explained\n- Real-world applications beyond finance\n- Future of decentralized systems\n- Expert opinions on blockchain adoption'),
(1, 'Privacy in the Digital Age', 'How to protect your personal information online.', 'tech_privacy.mp3', '42:30', '2023-06-01', 11200, 'This episode covers:\n- Common privacy threats\n- Tools to protect your data\n- Legislative developments\n- Interview with privacy advocate'),
(1, '5G Technology Explained', 'Everything you need to know about 5G networks.', 'tech_5g.mp3', '36:45', '2023-05-25', 10300, 'We explore:\n- How 5G works\n- Speed and latency improvements\n- Infrastructure challenges\n- Future applications of high-speed networks'),
(1, 'Cloud Computing Trends', 'Latest developments in cloud technology for businesses and individuals.', 'tech_cloud.mp3', '40:10', '2023-05-18', 8900, 'Topics include:\n- Major cloud providers comparison\n- Cost optimization strategies\n- Security considerations\n- Edge computing advancements');

-- Episodes for other podcasts (abbreviated for example)
INSERT INTO episodes (podcast_id, title, description, audio_file, duration, release_date, listens) VALUES
(2, 'Startup Funding Strategies', 'How to secure funding for your startup in todays economy.', 'business_funding.mp3', '52:40', '2023-06-14', 7600),
(3, 'Quantum Computing Breakthrough', 'Recent advancements in quantum computing research.', 'science_quantum.mp3', '48:15', '2023-06-13', 8200),
(4, 'Nutrition Myths Debunked', 'A scientific look at common nutrition misconceptions.', 'health_nutrition.mp3', '44:30', '2023-06-12', 6900),
(5, 'Stand-up Special', 'Highlights from recent comedy shows.', 'comedy_standup.mp3', '58:20', '2023-06-11', 15400),
(6, 'The Mysterious Case of John Doe', 'Investigating an unsolved mystery.', 'crime_johndoe.mp3', '65:10', '2023-06-10', 12800),
(7, 'Global News Roundup', 'This weeks top international news stories.', 'news_global.mp3', '35:45', '2023-06-16', 9100),
(8, 'Championship Analysis', 'Breaking down the championship games.', 'sports_championship.mp3', '49:30', '2023-06-15', 11300);

-- Add a test user (password: password123)
INSERT INTO users (username, email, password, created_at) VALUES
('testuser', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW());
