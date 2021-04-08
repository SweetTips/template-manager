<?php

include "template_manager/template_manager.php";

$template_manager = new Template_manager(array('templates_exemple', 'templates_exemple/pages'));

//Get template whith Admin permission
echo $template_manager->get_template_secure('page2_perm_admin.html', 1);

//Get template not protected
echo $template_manager->get_template_secure('template1.html');

//Load all templates object
var_dump($template_manager->get_templates());

?>