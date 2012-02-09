INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':smiley:', '/eagb/themes/standard/img/smileys/smiley.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':confuse:', '/eagb/themes/standard/img/smileys/smiley-confuse.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':cool:', '/eagb/themes/standard/img/smileys/smiley-cool.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':cry:', '/eagb/themes/standard/img/smileys/smiley-cry.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':evil:', '/eagb/themes/standard/img/smileys/smiley-evil.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':fat:', '/eagb/themes/standard/img/smileys/smiley-fat.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':grin:', '/eagb/themes/standard/img/smileys/smiley-grin.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':lol:', '/eagb/themes/standard/img/smileys/smiley-lol.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':mad:', '/eagb/themes/standard/img/smileys/smiley-mad.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':neutral:', '/eagb/themes/standard/img/smileys/smiley-neutral.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':razz:', '/eagb/themes/standard/img/smileys/smiley-razz.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':red:', '/eagb/themes/standard/img/smileys/smiley-red.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':roll:', '/eagb/themes/standard/img/smileys/smiley-roll.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':sad:', '/eagb/themes/standard/img/smileys/smiley-sad.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':slim:', '/eagb/themes/standard/img/smileys/smiley-slim.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':surprise:', '/eagb/themes/standard/img/smileys/smiley-surprise.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':twist:', '/eagb/themes/standard/img/smileys/smiley-twist.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':wink:', '/eagb/themes/standard/img/smileys/smiley-wink.png', date('now'), date('now'));
INSERT INTO `eagb_smileys` (`smiley`, `url`, `modified`, `created`) VALUES (':yell:', '/eagb/themes/standard/img/smileys/smiley-yell.png', date('now'), date('now'));

INSERT INTO `eagb_users` (`id`, `name`, `email`, `password`, `salt`, `created`, `modified`) VALUES (1, 'admin', 'admin@example.com', 'a79347597e661492a01ff77e13bf929de4d59d09', '202cb962ac59075b964b07152d234b70', date('now'), date('now'));

INSERT INTO `eagb_settings` (`name`, `setting`) VALUES ('required_name', 1);
INSERT INTO `eagb_settings` (`name`, `setting`) VALUES ('required_email', 1);
INSERT INTO `eagb_settings` (`name`, `setting`) VALUES ('required_homepage', 0);
INSERT INTO `eagb_settings` (`name`, `setting`) VALUES ('required_body', 1);
INSERT INTO `eagb_settings` (`name`, `setting`) VALUES ('required_captcha', 1);