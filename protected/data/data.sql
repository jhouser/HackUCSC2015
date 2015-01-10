INSERT INTO event_types (id, type)
VALUES 
(1, 'exercise'),
(2, 'food'),
(3, 'concert'),
(4, 'volunteer'),
(5, 'comedy');

-- Sample Events Table

INSERT INTO events (title, description, typeID, cost, startTime, endTime)
VALUES 
-- Monday
-- 10 - 11:30
('Yoga', 'Morning yoga in the park', 1, 0, 1421056800, 1421062200), 
-- 12 - 2pm
('2-for-1 Pizza', 'Lunch deal at Tidal Pizza', 2, 10, 1421064000, 1421071200),
-- 8 - 10:45pm
('Bluegrass Concert', 'The Fiddle Sticks playing at The Ole Watering Hole', 3, 15, 1421092800, 1421059500),
-- Tuesday
-- 8 - 12 am
('Beach Clean-up', 'Come help keep our beaches clean!', 4, 0, 1421136000, 1421150400),
-- 12:30 - 3:30pm
('Beginner Surf Lessons',  'Catch a wave', 1, 18, 1421152200, 1421163000),
-- 7:30 - 9:00 pm
('Craft Beer Tasting', 'Enjoy some local brews', 2, 0, 1421177400, 1421182800),
-- Wednesday
-- 6:00 - 7:00am
('Early Bird Bagle Deal', '20% off for early risers at Bobs Bagels', 2, 0, 1421215200, 1421218800), 
-- 11 - 1:45
('Read to Children', 'Come read books to preschoolers at the library', 4, 0, 1421233200, 1421243100),
-- 12 - 3pm
('Sale on Bananas', 'A-PEEL-ING Fruit store', 2, 0, 1421236800, 1421247600),
-- 2 - 7pm
('Art and Wine Festival', 'Booze and peruse on main street', 2, 0, 1421244000, 1421262000),
-- 6:30 - 9pm
('Comedy Night', 'Open Mike at Jakes Comedy Club', 5, 12, 1421260200, 1421269200);  

