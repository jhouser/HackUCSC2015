-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2015 at 06:08 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

--
-- Database: `hackucsc`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `user_type_preferences`;
DROP TABLE IF EXISTS `user_busy_times`;
DROP TABLE IF EXISTS `user_friend`;
DROP TABLE IF EXISTS `user_event`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `event_types`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `events` (
`id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `typeId` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `googleCalendarId` VARCHAR(255) DEFAULT NULL,
  `startTime` bigint(20) DEFAULT NULL,
  `endTime` bigint(20) DEFAULT NULL,
  `isUserEvent` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE IF NOT EXISTS `event_types` (
`id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `maxBudget` int(11) DEFAULT NULL,
  `refreshToken` varchar(255) DEFAULT NULL,
  `picture` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_event`
--

CREATE TABLE IF NOT EXISTS `user_event` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_busy_times`
--

CREATE TABLE IF NOT EXISTS `user_busy_times` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `startTime` int(11) NOT NULL,
  `endTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_friend`
--

CREATE TABLE IF NOT EXISTS `user_friend` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `friendId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_type_preferences`
--

CREATE TABLE IF NOT EXISTS `user_type_preferences` (
`id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `typeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
 ADD PRIMARY KEY (`id`), ADD KEY `event_type_id_fk` (`typeId`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_busy_times`
--
ALTER TABLE `user_busy_times`
 ADD PRIMARY KEY (`id`), ADD KEY `busy_user_id_fk` (`userId`);

--
-- Indexes for table `user_friend`
--
ALTER TABLE `user_friend`
 ADD PRIMARY KEY (`id`), ADD KEY `friend_user_id_fk` (`userId`), ADD KEY `friend_friend_id_fk` (`friendId`);

--
-- Indexes for table `user_type_preferences`
--
ALTER TABLE `user_type_preferences`
 ADD PRIMARY KEY (`id`), ADD KEY `type_user_id_fk` (`userId`), ADD KEY `type_type_id_fk` (`typeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_busy_times`
--
ALTER TABLE `user_busy_times`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_friend`
--
ALTER TABLE `user_friend`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_type_preferences`
--
ALTER TABLE `user_type_preferences`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Indexes for table `user_event`
--
ALTER TABLE `user_event`
 ADD PRIMARY KEY (`id`), ADD KEY `userId` (`userId`,`eventId`), ADD KEY `eventId` (`eventId`);

ALTER TABLE `user_event`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`typeId`) REFERENCES `event_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_busy_times`
--
ALTER TABLE `user_busy_times`
ADD CONSTRAINT `user_busy_times_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_friend`
--
ALTER TABLE `user_friend`
ADD CONSTRAINT `friend_fk` FOREIGN KEY (`friendId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `user_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_type_preferences`
--
ALTER TABLE `user_type_preferences`
ADD CONSTRAINT `user_type_preferences_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `user_type_preferences_ibfk_2` FOREIGN KEY (`typeId`) REFERENCES `event_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_event`
--
ALTER TABLE `user_event`
ADD CONSTRAINT `user_event_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `user_event_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;