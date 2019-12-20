<?php
/*
 *  @plugin_name:        Hello plug-in
 *  @plugin_author:      Jørn Guldberg
 *  @plugin_Version:     0.0.2
 *  @plugin_main-core:   5.0.0
 */
/**
 *  Intall.php is the files which control the start settings for the plug-in
 *  The main function is install() 
 *  This should be the only nessesary function to call since it will take
 *  Takes care of the rest. 
 *  This file also holds the setup for the database, and is responseble for 
 *  the tabels and data are setup in the database
 */


/**
 *  
 *
 */
function install() {

}

/**
 *  
 *  It could be that this function should just tell
 *  php and mysql to load in the .sql files stored in this 
 *  directory, such that a clean database dump can be placed in the 
 *  folder and, then be loaded in to the dabase.
 */
function insert_data_to_database() {
  // attached_id is the ID of some text or post that the image is attached to. 
  // If this is 0, then the image is not attached to anything. 


/*CREATE TABLE `ReplaceDBimages` (
  `id` int(11) NOT NULL,
  `img_text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `dir` varchar(128) NOT NULL,
  `uploaded` datetime NOT NULL,
  `is_profile_img` int(11) NOT NULL,
  `show_order` int(11) NOT NULL,
  `flash` varchar(8) NOT NULL,
  `fnumber` varchar(16) NOT NULL,
  `exposuretime` varchar(16) NOT NULL,
  `isospeedratings` varchar(16) NOT NULL,
  `focallength` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ReplaceDBimages`
--
ALTER TABLE `ReplaceDBimages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ReplaceDBimages`
--
ALTER TABLE `ReplaceDBimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;*/
}


?>
