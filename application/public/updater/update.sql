DROP TABLE IF EXISTS `e_oauth_access_tokens`;
CREATE TABLE IF NOT EXISTS `e_oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `e_oauth_auth_codes`;
CREATE TABLE IF NOT EXISTS `e_oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `e_oauth_clients`;
CREATE TABLE IF NOT EXISTS `e_oauth_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `e_oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'EVEREST Personal Access Client', 'sZk4Zun1r0tkZUTixBT0RE7R9mtFr2QIXwwRQnSu', 'http://localhost', 1, 0, 0, '2018-04-02 14:49:26', '2018-04-02 14:49:26'),
(2, NULL, 'EVEREST Password Grant Client', 'Fdrh18WPcXdSe3bmje4rKH4LICnOJKr24ci43b1x', 'http://localhost', 0, 1, 0, '2018-04-02 14:49:26', '2018-04-02 14:49:26');
COMMIT;

DROP TABLE IF EXISTS `e_oauth_personal_access_clients`;
CREATE TABLE IF NOT EXISTS `e_oauth_personal_access_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `e_oauth_refresh_tokens`;
CREATE TABLE IF NOT EXISTS `e_oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `access_token_id` (`access_token_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
