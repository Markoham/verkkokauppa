<?php

namespace MyApp\DataObjects;

class Tyontekija
{
    private $idtyontekija, $etunimi, $sukunimi, $email, $salasana, $privateHash;
    
    function getId()
    {
        return $this->idtyontekija;
    }
    
    function getEtunimi()
    {
        return $this->etunimi;
    }
    
    function getSukunimi()
    {
        return $this->sukunimi;
    }
    
    function getEmail()
    {
        return $this->email;
    }
    
    function getSalasana()
    {
        return $this->salasana;
    }
    
    function getPrivateHash()
    {
        return $privateHash;
    }
    
    function setId($id)
    {
        $this->idtyontekija = $id;
    }
    
    function setEtunimi($etunimi)
    {
        $this->etunimi = $etunimi;
    }
    
    function setSukunimi($sukunimi)
    {
        $this->sukunimi = $sukunimi;
    }
    
    function setEmail($email)
    {
        $this->email = $email;
    }
    
    function setSalasana($salasana)
    {
        $this->salasana = $salasana;
    }
    
    function setPrivateHash($privateHash)
    {
        $this->privateHash = $privateHash;
    }
}
?>