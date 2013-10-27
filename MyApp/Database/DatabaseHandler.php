<?php

namespace MyApp\Database;

class DatabaseHandler
{
    private $_pdo;
    private $_host, $_username, $_passwd, $_database, $_prefix;
    
    // Asettaa tietokannan osoitteen
    function setHost($host)
    {
        $this->_host = $host;
    }
    
    // Asettaa käyttäjätunnuksen
    function setUsername($username)
    {
        $this->_username = $username;
    }
    
    // Asettaa salasanan
    function setPassword($passwd)
    {
        $this->_passwd = $passwd;
    }
    
    // Asettaa tietokannan nimi
    function setDatabase($database)
    {
        $this->_database = $database;
    }
    
    // Asettaa tunnisteen tietokantoja varten
    function setPrefix($prefix)
    {
        $this->_prefix = $prefix . "_";
    }
    
    // Yhdistää tietokantaan
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
    
    // Hakee varastosaldon tuotteelle
    function getVarastosaldo($id)
    {
        $kysely = $this->_pdo->prepare("SELECT SUM(maara) AS total FROM " . $this->_prefix . "varasto WHERE tuoteid = ?;");
        $kysely->execute(array($id));

        $rivi = $kysely->fetchAll()[0];
        
        if($rivi['total'])
            return $rivi['total'];
        else
            return 0;
    }
    
    // Hakee halutun tuotteen
    function getTuote($id)
    {
        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tuotteet WHERE idtuote = ?;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Tuote");
        $kysely->execute(array($id));

        return $kysely->fetchAll()[0];
    }
    
    // Hakee kategorian tuotteet
    function getTuotteet($kategoria)
    {
        $tuotteet = Array();

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tuotteet AS t, " . $this->_prefix . "tuotteenkategoriat AS tk WHERE tk.tuoteid = t.idtuote AND tk.kategoriaid = ?;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Tuote");
        $kysely->execute(array($kategoria));

        while ($tuote = $kysely->fetch())
        {
            $tuotteet[] = $tuote;
        }
        
        return $tuotteet;
    }
    
    // Hakee kategorian
    function getCategory($id)
    {
        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "kategoriat WHERE paakategoria = 1;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Kategoria");
        $kysely->execute(array($id));

        return $kysely->fetchAll()[0];
    }
    
    // Hakee kategoriat
    function getCategorys()
    {
        $kategoriat = Array();

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "kategoriat WHERE paakategoria = 1;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Kategoria");
        $kysely->execute();

        while ($kat = $kysely->fetch())
        {
            $kyselyAla = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "kategoriat AS k," . $this->_prefix . "alakategoriat AS ak WHERE ak.alakategoriaid = k.idkategoria AND ak.ylakategoriaid = ?;");
            $kyselyAla->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Kategoria");
            $kyselyAla->execute(array($kat->getId()));

            while ($alaKat = $kyselyAla->fetch())
            {
                $kat->addAlakategoria($alaKat);
            }
            
            $kategoriat[] = $kat;
        }
        
        return $kategoriat;
    }
    
    // Hakee asiakkaan
    function getAsiakas($id)
    {
        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "asiakkaat WHERE idasiakas = ?;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Asiakas");
        $kysely->execute(array($id));

        return $kysely->fetchAll()[0];
    }
    
    // Hakee käyttäjän sähköpostiosoitteen avulla
    function getAsiakasByEmail($email)
    {
        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "asiakkaat WHERE email = ?;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Asiakas");
        $kysely->execute(array($email));

        $asiakas = @$kysely->fetchAll()[0];
        
        return $asiakas;
    }
    
    // Lisää asiakkaan tietokantaan
    function addAsiakas($etunimi, $sukunimi, $email, $salasana)
    {
        $privateHash = uniqid($etunimi . $sukunimi);
        $kysely = $this->_pdo->prepare("INSERT INTO " . $this->_prefix . "asiakkaat (etunimi, sukunimi, email, salasana) VALUES (?, ?, ?, ?);");
        $kysely->execute(array($etunimi, $sukunimi, $email, $salasana));
        
        return $this->_pdo->lastInsertId();
    }
    
    // Sulkee yhteyden
    function close()
    {
        $this->_pdo = null;
    }
}
?>