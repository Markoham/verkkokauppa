<?php

namespace MyApp\DataObjects;

class Kategoria
{
    private $_id, $_kategoria, $_paakategoria, $_alakategoriat = Array();
    
    function getId()
    {
        return $this->_id;
    }
    
    function getKategoria()
    {
        return $this->_kategoria;
    }
    
    function getPaaKategoria()
    {
        return $this->_paakategoria;
    }
    
    function getAlakategoriat()
    {
        return $this->_alakategoriat;
    }
    
    function setId($id)
    {
        $this->_id = $id;
    }
    
    function setKategoria($kategoria)
    {
        $this->_kategoria = $kategoria;
    }
    
    function setPaakategoria($paakategoria)
    {
        $this->_paakategoria = $paakategoria;
    }
    
    function addAlakategoria($kategoria)
    {
        $this->_alakategoriat[] = $kategoria;
    }
}
?>