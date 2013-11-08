=== About ===

name: visit_counter <br>
website: http://www.ushahidi.com <br>
description: Adding count visits to reports <br>
version: 0.2 <br>
requires: 2.1 <br>
tested up to: 2.7 <br>
author: Oksana Lysak <br>
author website: http://www.ushahidi.com <br>

== Description ==
Show count visits

== Installation ==

1. Unpack archive with plugin
2. Rename the folder to /visit_counter/
3. Copy the entire /visit_counter/ directory into your /plugins/ directory.
4. Open /plugins/visit_counter/config/visit_counter.php and set the appropriate settings
5. Activate the plugin.
                       

== Example ==
   
CREATE TABLE IF NOT EXISTS `marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8

CREATE TABLE IF NOT EXISTS `marks_to_units` (
  `id_marks` int(11) NOT NULL,
  `id_units` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8


== Changelog ==

0.1
* Created the plugin
0.2
* Fixed bug with adding a report from admin page.

CREATE TABLE IF NOT EXISTS `visits_count` (
  `id_element` int(11) NOT NULL,
  `visits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
