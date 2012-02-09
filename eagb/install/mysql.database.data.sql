INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES
(':smiley:', '/eagb/themes/standard/img/smileys/smiley.png', NOW(), NOW()),
(':confuse:', '/eagb/themes/standard/img/smileys/smiley-confuse.png', NOW(), NOW()),
(':cool:', '/eagb/themes/standard/img/smileys/smiley-cool.png', NOW(), NOW()),
(':cry:', '/eagb/themes/standard/img/smileys/smiley-cry.png', NOW(), NOW()),
(':evil:', '/eagb/themes/standard/img/smileys/smiley-evil.png', NOW(), NOW()),
(':fat:', '/eagb/themes/standard/img/smileys/smiley-fat.png', NOW(), NOW()),
(':grin:', '/eagb/themes/standard/img/smileys/smiley-grin.png', NOW(), NOW()),
(':lol:', '/eagb/themes/standard/img/smileys/smiley-lol.png', NOW(), NOW()),
(':mad:', '/eagb/themes/standard/img/smileys/smiley-mad.png', NOW(), NOW()),
(':neutral:', '/eagb/themes/standard/img/smileys/smiley-neutral.png', NOW(), NOW()),
(':razz:', '/eagb/themes/standard/img/smileys/smiley-razz.png', NOW(), NOW()),
(':red:', '/eagb/themes/standard/img/smileys/smiley-red.png', NOW(), NOW()),
(':roll:', '/eagb/themes/standard/img/smileys/smiley-roll.png', NOW(), NOW()),
(':sad:', '/eagb/themes/standard/img/smileys/smiley-sad.png', NOW(), NOW()),
(':slim:', '/eagb/themes/standard/img/smileys/smiley-slim.png', NOW(), NOW()),
(':surprise:', '/eagb/themes/standard/img/smileys/smiley-surprise.png', NOW(), NOW()),
(':twist:', '/eagb/themes/standard/img/smileys/smiley-twist.png', NOW(), NOW()),
(':wink:', '/eagb/themes/standard/img/smileys/smiley-wink.png', NOW(), NOW()),
(':yell:', '/eagb/themes/standard/img/smileys/smiley-yell.png', NOW(), NOW());

INSERT INTO `eagb_users` (`id`, `name`, `email`, `password`, `salt`, `created`, `modified`) VALUES
(1, 'admin', 'admin@example.com', 'a79347597e661492a01ff77e13bf929de4d59d09', '202cb962ac59075b964b07152d234b70', NOW(), NOW());

INSERT INTO `eagb_settings` (`name`, `setting`) VALUES
('required_name', 1),
('required_email', 1),
('required_homepage', 0),
('required_body', 1),
('required_captcha', 1);