
show content_library
SELECT * FROM `wp_h5p_contents_libraries` JOIN `wp_h5p_libraries` ON `wp_h5p_contents_libraries`.`library_id` = `wp_h5p_libraries`.`id` WHERE `content_id` = 6 ORDER BY `weight` ASC
SELECT library_id,name,major_version,minor_version,patch_version, weight, drop_css, dependency_type FROM `wp_h5p_contents_libraries` JOIN `wp_h5p_libraries` ON `wp_h5p_contents_libraries`.`library_id` = `wp_h5p_libraries`.`id` WHERE `content_id` = 6 ORDER BY `weight` ASC

