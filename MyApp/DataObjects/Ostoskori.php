<?php
namespace MyApp\DataObjects;

class Ostoskori
{
    private $_tuotteet = Array();
    
    function addTuote($id)
    {
        $this->_tuotteet[] = $id;
    }
    
    function removeTuote($id)
    {
        $this->_tuotteet = array_diff($this->_tuotteet, array($id));
    }
    
    function getTuotteet()
    {
        return $this->_tuotteet;
    }
    
    function clear()
    {
        $this->_tuotteet = Array();
    }
}
?>