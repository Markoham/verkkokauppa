<?php
namespace MyApp\DataObjects;

class TilauksenTuote
{
    private $tuoteId, $maara;

    function setTuoteId($id)
    {
        $this->tuoteId = $id;
    }

    function getTuoteId()
    {
        return $this->tuoteId;
    }

    function setMaara($maara)
    {
        $this->maara = $maara;
    }

    function getMaara()
    {
        return $this->maara;
    }
}
?>
