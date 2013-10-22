<?php

namespace MyApp\DataObjects;

class Tuote
{
    private $_id, $_valmtun, $_tuotteennimi, $_kuvaus, $_hinta;
    
    function setId($id)
    {
        $this->_id = $id;
    }
    
    function setValmistajanTuotenumero($valmtun)
    {
        $this->_valmtun = $valmtun;
    }
    
    function setTuotteennimi($tuotteennimi)
    {
        $this->_tuotteennimi = $tuotteennimi;
    }
    
    function setHinta($hinta)
    {
        $this->_hinta = $hinta;
    }
    
    function setKuvaus($kuvaus)
    {
        $this->_kuvaus = $kuvaus;
    }
    
    function getId()
    {
        return $this->_id;
    }
    
    function getValmistajanTuotenumero()
    {
        return $this->_valmtun;
    }
    
    function getTuotteennimi()
    {
        return $this->_tuotteennimi;
    }
    
    function getHinta()
    {
        return $this->_hinta;
    }
    
    function getKuvaus()
    {
        return $this->_kuvaus;
    }
}
?>