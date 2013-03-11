INSERT INTO `user` (`id`, `username`, `password`, `role`, `mail`, `name`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'juanma.aguero@gmail.com', 'admin');

INSERT INTO item_menu (id, `name`, id_menu, id_father, id_page, linkurl, `order`) VALUES
(1, 'Home', 1, 0, 1, '', 1),
(2, 'Sample', 1, 0, 2, '', 2),
(3, 'blog', 1, 0, 3, '', 4);

INSERT INTO menu (id, `name`) VALUES
(1, 'main-menu');


INSERT INTO page (id, permalink, `name`, description, htmlcontent, `status`, `type`) VALUES
(1, 'home', 'home', 'Home description', '<p>Sample page content</p>\r\n', 1, 100),
(2, 'sample-page', 'sample page', 'Sample Page', '<p>Another Sample page content</p>\r\n', 1, 100),
(3, 'blog', 'blog', 'Blog description', '', 1, 100);

INSERT INTO post (id, permalink, title, body, intro, `type`, image_slot, image_slot_top, image_slot_left, image_slot_size, `date`, `status`) VALUES
(1, 'sample-post', 'Sample post', '<p>Sample post content</p>\r\n', '<p>Sample post intro text.</p>\r\n', 'd', '', '0', '0', '100', '2013-03-11 18:55:02', 0);
