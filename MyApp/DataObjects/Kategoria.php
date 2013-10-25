<?php

namespace MyApp\DataObjects;

class Kategoria
{
    private $idkategoria, $kategoria, $paakategoria, $alakategoriat = Array();
    
    function getId()
    {
        return $this->idkategoria;
    }
    
    function getKategoria()
    {
        return $this->kategoria;
    }
    
    function getPaaKategoria()
    {
        return $this->paakategoria;
    }
    
    function getAlakategoriat()
    {
        return $this->alakategoriat;
    }
    
    function setId($id)
    {
        $this->idkategoria = $id;
    }
    
    function setKategoria($kategoria)
    {
        $this->kategoria = $kategoria;
    }
    
    function setPaakategoria($paakategoria)
    {
        $this->paakategoria = $paakategoria;
    }
    
    function addAlakategoria($kategoria)
    {
        $this->alakategoriat[] = $kategoria;
    }
}
?>