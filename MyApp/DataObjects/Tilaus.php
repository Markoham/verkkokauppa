<?php

namespace MyApp\DataObjects;

class Tilaus
{
    private $id, $asiakasId, $tuotteet = array();

    function getId()
    {
        return $this->id;
    }

    function getAsiakasId()
    {
        return $this->asiakasId;
    }

    function getTuotteet()
    {
        return $this->tuotteet;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setAsiakasId($id)
    {
        $this->asiakasId = $id;
    }

    function setTuotteet($tuotteet)
    {
        $this->tuotteet = $tuotteet;
    }

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
}
?>
