-- Karibu blog database

CREATE DATABASE IF NOT EXISTS karibu_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE karibu_blog;

CREATE TABLE IF NOT EXISTS posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL,
  excerpt VARCHAR(300) NOT NULL,
  body TEXT NOT NULL,
  image VARCHAR(120) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO posts (title, slug, excerpt, body, image, created_at) VALUES
('Escape to the Maasai Mara', 'maasai-mara',
 'Golden plains, endless skies, and the great migration up close.',
 'The Maasai Mara is one of the most breathtaking places in Kenya, and no photo really does it justice. The plains stretch out in every direction, dotted with acacia trees and grazing herds.\n\nWe set out before sunrise, wrapped in blankets against the cool morning air. Within an hour we had spotted zebra, giraffe, and a pride of lions resting near a riverbed.\n\nIf you are planning a first safari, the Mara is the perfect place to start. Book early, bring a good camera, and let the wild do the rest.',
 'post1.jpg', '2026-06-18 08:30:00'),
('A Weekend in Diani Beach', 'diani-beach',
 'White sand, warm water, and slow afternoons on the south coast.',
 'Diani Beach feels like a different world. The sand is soft and white, the water is a warm shade of turquoise, and the palm trees lean lazily toward the sea.\n\nWe spent our days swimming, reading in the shade, and taking a dhow ride out to the reef. Fresh seafood and coconut water were never far away.\n\nFor anyone who needs to slow down and breathe, Diani is the answer. Two nights are good, but three are better.',
 'post2.jpg', '2026-06-25 12:00:00'),
('Nairobi Best Coffee Spots', 'nairobi-coffee',
 'A short guide to the cafes fuelling the city one cup at a time.',
 'Nairobi has quietly become a great coffee city. From tucked away roasteries to bright modern cafes, there is a cup for every mood.\n\nStart your morning with a flat white and a view, then move somewhere quiet to work through the afternoon. Many spots roast their own beans and are happy to talk you through them.\n\nWherever you land, order local. Kenyan coffee is among the best in the world, and it tastes even better close to home.',
 'post3.jpg', '2026-07-02 10:15:00'),
('Hiking Mount Kenya', 'mount-kenya',
 'Thin air, frozen tarns, and a sunrise you will never forget.',
 'Mount Kenya is not for the faint hearted, but the reward is unreal. The trail climbs through forest, moorland, and finally bare rock and ice.\n\nWe hiked for three days, pacing ourselves against the thinning air. Point Lenana at dawn was silent, cold, and absolutely worth every step.\n\nBring warm layers, go slow, and respect the mountain. It gives back far more than it takes.',
 'post4.jpg', '2026-06-05 07:00:00'),
('Street Food in Mombasa', 'mombasa-food',
 'Coastal flavours, sizzling grills, and the smell of the sea.',
 'Mombasa eats well, and most of the best food is found on the street. Smoky mishkaki, warm mahamri, and fresh coconut are everywhere.\n\nWe wandered Old Town in the evening, following the crowds and the aromas. Every corner offered something new to try.\n\nCome hungry, carry small change, and let the locals point you to their favourites.',
 'post5.jpg', '2026-06-10 18:30:00'),
('Sunsets on Lake Naivasha', 'lake-naivasha',
 'Calm water, birdsong, and skies that turn to fire.',
 'Lake Naivasha is where the city slows down. Boats drift past hippos while fish eagles call overhead.\n\nWe took a sunset cruise and watched the sky shift from gold to deep orange. Later, dinner by the water felt like the perfect end to the day.\n\nStay a night if you can. The mornings here are just as beautiful as the evenings.',
 'post6.jpg', '2026-06-14 17:45:00');
