ALTER TABLE `e_users` ADD `instagram_id` VARCHAR(255) NULL DEFAULT NULL AFTER `google_id`;
ALTER TABLE `e_users` ADD `pinterest_id` VARCHAR(255) NULL DEFAULT NULL AFTER `instagram_id`;
ALTER TABLE `e_users` ADD `linkedin_id` VARCHAR(255) NULL DEFAULT NULL AFTER `pinterest_id`;
ALTER TABLE `e_users` ADD `vk_id` VARCHAR(255) NULL DEFAULT NULL AFTER `linkedin_id`, ADD `identifyme_id` VARCHAR(255) NULL DEFAULT NULL AFTER `vk_id`;
ALTER TABLE `e_users` ADD `is_2fa` BOOLEAN NOT NULL DEFAULT FALSE AFTER `last_login_at`;
ALTER TABLE `e_users` ADD `google2fa_secret` VARCHAR(255) NULL DEFAULT NULL AFTER `is_2fa`;
ALTER TABLE `e_settings_payments` ADD `is_razorpay` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_paystack`;
ALTER TABLE `e_settings_payments` ADD `is_barion` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_razorpay`;
ALTER TABLE `e_settings_payments` ADD `is_cashu` BOOLEAN NOT NULL DEFAULT TRUE AFTER `is_barion`;
ALTER TABLE `e_cities` ENGINE = MYISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;
ALTER TABLE `e_countries` ENGINE = MYISAM;
ALTER TABLE `e_states` ENGINE = MYISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `e_search_alert` (
  `id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `e_search_alert`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `e_search_alert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `e_search_alert` ADD `token` VARCHAR(255) NOT NULL AFTER `email`;
ALTER TABLE `e_ads` ADD `is_oos` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_archived`;
CREATE TABLE `e_reviews` (
  `id` int(11) NOT NULL,
  `ad_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text,
  `rating` int(11) NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `e_reviews`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `e_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `e_comments` CHANGE `content` `content` VARBINARY(2000) NOT NULL;
ALTER TABLE `e_settings_membership` CHANGE `free_ad_life` `free_ad_life` VARCHAR(255) NOT NULL DEFAULT '30', CHANGE `pro_ad_life` `pro_ad_life` VARCHAR(255) NOT NULL DEFAULT '120';
ALTER TABLE `e_settings_general` ADD `default_host` VARCHAR(255) NOT NULL DEFAULT 'local' AFTER `language`;
ALTER TABLE `e_ads` ADD `images_host` VARCHAR(255) NOT NULL DEFAULT 'local' AFTER `photos_number`;
ALTER TABLE `e_settings_geo` ADD `default_state` INT NOT NULL DEFAULT '3956' AFTER `default_country`, ADD `default_city` INT NOT NULL DEFAULT '48019' AFTER `default_state`;
ALTER TABLE `e_settings_geo` ADD `states_enabled` BOOLEAN NOT NULL DEFAULT TRUE AFTER `default_currency`, ADD `cities_enabled` BOOLEAN NOT NULL DEFAULT TRUE AFTER `states_enabled`;
ALTER TABLE `e_reviews` ADD `store_id` INT NOT NULL AFTER `user_id`;
ALTER TABLE `e_users` ADD `phonecode` VARCHAR(255) NULL DEFAULT NULL AFTER `city`;
ALTER TABLE `e_cities` ADD `country_id` INT NULL DEFAULT NULL AFTER `state_id`;
ALTER TABLE `e_users` CHANGE `state` `state` INT NULL DEFAULT NULL, CHANGE `city` `city` INT NULL DEFAULT NULL;
ALTER TABLE `e_settings_general` ADD `is_maintenance` BOOLEAN NOT NULL DEFAULT FALSE AFTER `default_host`;
ALTER TABLE `e_activations` CHANGE `phone` `phone` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;


