<?php
class ContactoModel extends Query{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getEmpresa() {
        return $this->select("SELECT * FROM empresa");
    }
}
?>