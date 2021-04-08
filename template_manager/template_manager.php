<?php

include "Template.php";

class Template_manager
{
    private $_templates;
    private $_file_list;
    private $_file_list_path;

    public function __construct($path_dir_to_add)
    {
        $this->load_file_list($path_dir_to_add);
        $this->load_templates();
    }

    //GET
    private function get_file_list() { return $this->_file_list; }
    private function get_file_list_path() { return $this->_file_list_path; }
    public function get_templates() { return $this->_templates; }
    public function get_template_secure($template_name, $permission = -1)
    {
        if(isset($this->_templates[$template_name]))
        {
            if($permission >= $this->_templates[$template_name]->get_grades_permission())
            {
                return $this->_templates[$template_name]->get_html();
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    //SET
    private function set_file_list($dir, $file_list)
    {
       $this->_file_list[$dir] = $file_list;
    }

    private function set_file_list_path($dir, $file_list)
    {
        foreach($file_list as $key => $file)
        {
            $file_list[$key] = $dir.'/'.$file;
        }
        
       $this->_file_list_path[$dir] = $file_list;
    }

    private function set_templates($name, $path)
    {
        $this->_templates[$name] = new Template($name, $path);
    }

    //REMOVE FOLDER ON LIST
    private function remove_folder_in_file_list($file_list)
    {
        foreach ($file_list as $key => $file)
        {
            if(!strpos($file, '.'))
            {
                unset($file_list[$key]);
            }
            if(is_dir($file))
            {
                unset($file_list[$key]);
            }
        }

        sort($file_list);
        return $file_list;
    }

    //LOAD FILE LIST
    private function load_file_list($path_dir_to_add)
    {
        foreach($path_dir_to_add as $dir)
        {
            $file_list = scandir($dir);

            $file_list = $this->remove_folder_in_file_list($file_list);
            
            $this->set_file_list($dir, $file_list);
            $this->set_file_list_path($dir, $file_list);
        }
    }

    //LOAD TEMPLATES
    private function load_templates()
    {
        $file_list = $this->get_file_list();
        $file_list_path = $this->get_file_list_path();

        foreach($file_list as $main_key => $dir)
        {
            foreach($dir as $key => $file_name)
            {
                $this->set_templates($file_name, $file_list_path[$main_key][$key]); 
            }
        }
    }
}

?>