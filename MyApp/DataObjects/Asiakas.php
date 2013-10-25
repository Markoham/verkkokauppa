<?php

namespace MyApp\DataObjects;

class Asiakas
{
    private $idasiakas, $etunimi, $sukunimi, $salasana;
    
    function getId()
    {
        return $this->idasiakas;
    }
    
    function getEtunimi()
    {
        return $this->etunimi;
    }
    
    function getSukunimi()
    {
        return $this->sukunimi;
    }
    
    function getSalasana()
    {
        return $this->salasana;
    }
    
    function setId($id)
    {
        $this->idasiakas = $id;
    }
    
    function setEtunimi($etunimi)
    {
        $this->etunimi = $etunimi;
    }
    
    function setSukunimi($sukunimi)
    {
        $this->sukunimi = $sukunimi;
    }
    
    function setSalasana($salasana)
    {
        $this->salasana = $salasana;
    }
}
?>