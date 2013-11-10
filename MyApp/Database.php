<?php
namespace MyApp;

class Database
{
    protected $_db;
    
    function __construct($path = "")
    {
        if (!is_file($path . "../settings.php")) die("Settings file is missing...");
        require($path . "../settings.php");
        
        $this->_db = new Database\DatabaseHandler();
        $this->_db->setHost($host);
        $this->_db->setUsername($username);
        $this->_db->setPassword($password);
        $this->_db->setDatabase($database);
        $this->_db->setPrefix($database_prefix);
        $this->_db->connect();
    }
        
    // Putsaa syötteet
    function cleanInput($array, $key, $type = "string")
    {
        return $array[$key];
    }
    
    function getTuote($tuote = null)
    {
        if(!$tuote)
            $tuote = $this->cleanInput($_GET, 'product');
        
        return $this->_db->getTuote($tuote);
    }
    
    function getVarastoSaldo($id)
    {
        return $this->_db->getVarastosaldo($id);
    }
    
    function getTuotteet()
    {
        if(isset($_GET['cat']))
            return $this->_db->getTuotteet($this->cleanInput($_GET, 'cat'));
        else
            return $this->_db->getKaikkiTuotteet();
    }
    
    function getKategoriat()
    {
        return $this->_db->getCategorys();
    }
    
    // Lisää asiakkaan
    function addAsiakkas($etunimi, $sukunimi, $email, $salasana)
    {
        if($this->_db->getAsiakasByEmail($email))
            return -1;
        
        $id = $this->_db->addAsiakas($etunimi, $sukunimi, $email, $this->createPasswordHash($salasana));
        $this->checkLogin($email, $salasana);
        return $id;
    }
    
    // Lisää työntekijän
    function addTyontekija($etunimi, $sukunimi, $email, $salasana)
    {
        if($this->_db->getTyontekijaByEmail($email))
            return -1;
        
        $id = $this->_db->addTyontekija($etunimi, $sukunimi, $email, $this->createPasswordHash($salasana));
        return $id;
    }
    
    
    function getTyontekijat()
    {
        return $this->_db->getTyontekijat();
    }
        
    // Lähettää hukatun salasanan
    function sendLostPassword($email)
    {
         $asiakas = $this->_db->getAsiakasByEmail($email);
    }
}
?>