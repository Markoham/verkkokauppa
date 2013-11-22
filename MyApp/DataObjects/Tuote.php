<?php

namespace MyApp\DataObjects;

class Tuote
{
    private $idtuote, $valmtun, $tuotteennimi, $kuvaus, $hinta, $mimetype, $kuva;
    
    function setId($id)
    {
        $this->idtuote = $id;
    }
    
    function setValmistajanTuotenumero($valmtun)
    {
        $this->valmtun = $valmtun;
    }
    
    function setTuotteennimi($tuotteennimi)
    {
        $this->tuotteennimi = $tuotteennimi;
    }
    
    function setHinta($hinta)
    {
        $this->hinta = $hinta;
    }
    
    function setKuvaus($kuvaus)
    {
        $this->kuvaus = $kuvaus;
    }
    
    function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;
    }

    function setKuva($kuva)
    {
        $this->kuva = $kuva;
    }

    function getId()
    {
        return $this->idtuote;
    }
    
    function getValmistajanTuotenumero()
    {
        return $this->valmtun;
    }
    
    function getTuotteennimi()
    {
        return $this->tuotteennimi;
    }
    
    function getHinta()
    {
        return $this->hinta;
    }
    
    function getKuvaus()
    {
        return $this->kuvaus;
    }

    function getMimetype()
    {
        return $this->mimetype;
    }

    function getKuva()
    {
        return $this->kuva;
    }
}
?>
