<?php

class Template
{
    public $_name;
    public $_path;
    public $_grades_permission;
    public $_html;

    public function __construct($name, $path)
    {
        $this->set_name($name);
        $this->set_path($path);
        $this->set_grades_permission();
        $this->set_html();
    }

    //GET
    public function get_name() { return $this->_name; }
    public function get_path() { return $this->_path; }
    public function get_grades_permission()
    {
        if(isset($this->_grades_permission))
        {
            return $this->_grades_permission;
        }
        else
        {
            //Default permission (free access)
            return -1;
        }
    }
    public function get_html() { return $this->_html; }

    //SET
    private function set_name($name)
    {
        $this->_name = $name;
    }

    private function set_path($path)
    {
        $this->_path = $path;
    }

    private function set_grades_permission()
    {
        $permissions['_perm_user'] = 0;
        $permissions['_perm_admin'] = 1;

        foreach($permissions as $key => $permission)
        {
            if(stristr($this->get_name(), $key))
            {
                $this->_grades_permission = $permission;
            }
        }
    }

    private function set_html()
    {
        $this->_html = file_get_contents($this->get_path());
    }
}

?>
