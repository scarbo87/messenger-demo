CREATE TABLE IF NOT EXISTS `mqdev`.`enqueue` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `published_at` bigint(11) NOT NULL,
  `body` text DEFAULT NULL,
  `redelivered` tinyint(1) DEFAULT NULL,
  `headers` text DEFAULT NULL,
  `properties` text DEFAULT NULL,
  `priority` smallint(6) NOT NULL,
  `queue` varchar(11) NOT NULL DEFAULT '',
  `time_to_live` int(11) DEFAULT NULL,
  `delayed_until` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `published_at` (`published_at`),
  KEY `queue` (`queue`),
  KEY `priority` (`priority`),
  KEY `delayed_until` (`delayed_until`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;