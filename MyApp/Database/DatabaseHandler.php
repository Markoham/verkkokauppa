<?php

namespace MyApp\Database;

class DatabaseHandler
{
    private $_pdo;
    private $_host, $_username, $_passwd, $_database, $_prefix;
    
    function setHost($host)
    {
        $this->_host = $host;
    }
    
    function setUsername($username)
    {
        $this->_username = $username;
    }
    
    function setPassword($passwd)
    {
        $this->_passwd = $passwd;
    }
    
    function setDatabase($database)
    {
        $this->_database = $database;
    }
    
    function setPrefix($prefix)
    {
        $this->_prefix = $prefix . "_";
    }
    
    function connect()
    {
        if ($this->_pdo)
            return false;
        
        try {
            $this->_pdo = new \PDO("mysql:host=".$this->_host.";dbname=".$this->_database, $this->_username, $this->_passwd);
        } catch (\PDOException $e) {
            die("VIRHE: " . $e->getMessage());
        }
        $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->_pdo->exec("SET NAMES utf8");
    }
    
    function getTuotteet($kategoria)
    {
        $tuotteet = Array();

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tuotteet AS t, " . $this->_prefix . "tuotteenkategoriat AS tk WHERE tk.tuoteid = t.idtuote AND tk.kategoriaid = ?;");
        $kysely->execute(array($kategoria));

        while ($rivi = $kysely->fetch())
        {
            $tuote = new \MyApp\DataObjects\Tuote();
            
            $tuote->setId($rivi['idtuote']);
            $tuote->setValmistajanTuotenumero($rivi['valmistajantuotenumero']);
            $tuote->setTuotteennimi($rivi['tuotteennimi']);
            $tuote->setHinta($rivi['hinta']);
            $tuote->setKuvaus($rivi['kuvaus']);
            $tuotteet[] = $tuote;
        }
        
        return $tuotteet;
    }
    
    function getCategorys()
    {
        $kategoriat = Array();

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "kategoriat WHERE paakategoria = 1;");
        $kysely->execute();

        while ($rivi = $kysely->fetch())
        {
            $kat = new \MyApp\DataObjects\Kategoria();
            
            $kat->setId($rivi['idkategoria']);
            $kat->setKategoria($rivi['kategoria']);
            $kat->setPaakategoria($rivi['paakategoria']);
            
            $kyselyAla = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "kategoriat AS k," . $this->_prefix . "alakategoriat AS ak WHERE ak.alakategoriaid = k.idkategoria AND ak.ylakategoriaid = ?;");
            $kyselyAla->execute(array($rivi['idkategoria']));

            while ($riviAla = $kyselyAla->fetch())
            {
                $alaKat = new \MyApp\DataObjects\Kategoria();
                $alaKat->setId($riviAla['idkategoria']);
                $alaKat->setKategoria($riviAla['kategoria']);
                $alaKat->setPaakategoria($riviAla['paakategoria']);
                
                $kat->addAlakategoria($alaKat);
            }
            
            $kategoriat[] = $kat;
        }
        
        return $kategoriat;
    }
    
    function close()
    {
        $this->_pdo = null;
    }
}
?>