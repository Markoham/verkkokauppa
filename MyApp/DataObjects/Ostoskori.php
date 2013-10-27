<?php
namespace MyApp\DataObjects;

class Ostoskori
{
    private $tuotteet = Array();
    
    function addTuote($tuote)
    {
        if(array_key_exists($tuote->getTuoteId(), $this->tuotteet))
        {
            $temp = $this->tuotteet[$tuote->getTuoteId()];
            
            $temp->setMaara($temp->getMaara() + 1);
            
            $this->tuotteet[$tuote->getTuoteId()] = $temp;
        }
        else
            $this->tuotteet[$tuote->getTuoteId()] = $tuote;
    }
    
    function removeTuote($tuote)
    {
        $this->tuotteet = array_diff($this->_tuotteet, array($tuote));
    }
    
    function updateTuote($tuote)
    {
        $this->tuotteet[$tuote->getTuoteId()] = $tuote;
    }
    
    function getTuotteet()
    {
        return $this->tuotteet;
    }
}
?>