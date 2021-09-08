



-- create the Pages Table
CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- populate the pages table
INSERT INTO `pages` (`id`, `title`, `content`) VALUES
(1, 'Home page Title', 'Welcome to our homepage'),
(2, 'About us page', 'About us content of the page'),
(3, 'You have already submitted the form', 'Please be patient as we process your message'),
(4, 'Thank you for your message', 'We will get back to you'),
(5, 'Contact us page', 'Please write us a message');

-- index primary key
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

-- auto-increment
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

-- create the routes table
CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `action` text COLLATE utf8_unicode_ci NOT NULL,
  'entity_id' varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  'pretty_url' varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- index primary key
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

-- auto-increment
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

-- populate the routes table
INSERT INTO `routes` (`id`, `module`, `action`, 'entity_id', 'pretty_url') VALUES
(NULL, 'page', '', '1', 'home'),
(NULL, 'page', '', '2', 'about_me'),
(NULL, 'page', '', '3', 'submit'),
(NULL, 'page', '', '4', 'thanks'),
(NULL, 'contact', '', '5', 'contact_me');
