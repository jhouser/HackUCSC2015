INSERT INTO event_types (id, type)
VALUES 
(1, 'exercise'),
(2, 'food'),
(3, 'concert'),
(4, 'volunteer'),
(5, 'comedy'),
(6, 'sports');

-- Sample Events Table

INSERT INTO events (title, description, typeID, cost, startTime, endTime)
VALUES 
-- Monday
-- 10 - 11:30
('Yoga', 'Morning yoga in the park', 1, 0, 1421085600, 1421091000), 
-- 12 - 2pm
('2-for-1 Pizza', 'Lunch deal at Tidal Pizza', 2, 10, 1421092800, 1421100000),
-- 8 - 10:45pm
('Bluegrass Concert', 'The Fiddle Sticks playing at The Ole Watering Hole', 3, 15, 1421121600, 1421088300),
-- 7:45 - 10
('Baseball Game', 'Giants vs Rockies at AT&T Park', 6, 35, 1421120700, 1421131500),
-- Tuesday
-- 8 - 12 am
('Beach Clean-up', 'Come help keep our beaches clean!', 4, 0, 1421164800, 1421179200),
-- 12:30 - 3:30pm
('Beginner Surf Lessons',  'Catch a wave', 1, 18, 1421181000, 1421191800),
-- 7:30 - 9:00 pm
('Craft Beer Tasting', 'Enjoy some local brews', 2, 0, 1421206200, 1421211600),
-- Wednesday
-- 6:00 - 7:00am
('Early Bird Bagle Deal', '20% off for early risers at Bobs Bagels', 2, 0, 1421244000, 1421247600), 
-- 11 - 1:45
('Read to Children', 'Come read books to preschoolers at the library', 4, 0, 1421262000, 1421271900),
-- 12 - 3pm
('Sale on Bananas', 'A-PEEL-ING Fruit store', 2, 0, 1421265600, 1421276400),
-- 2 - 7pm
('Art and Wine Festival', 'Booze and peruse on main street', 2, 0, 1421272800, 1421290800),
-- 6:30 - 9pm
('Comedy Night', 'Open Mike at Jakes Comedy Club', 5, 12, 1421289000, 1421298000);  

