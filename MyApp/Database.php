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
    
    // -----------------------------------------------------------------------
    // ------------------ TUOTTEET -------------------------------------------
    // -----------------------------------------------------------------------
    
    function getTuote($tuote = null)
    {
        if(!$tuote)
            $tuote = $this->cleanInput($_GET, 'product');
        
        return $this->_db->getTuote($tuote);
    }
    
    function getTuotteet()
    {
        if(isset($_GET['cat']))
            return $this->_db->getTuotteet($this->cleanInput($_GET, 'cat'));
        else
            return $this->_db->getKaikkiTuotteet();
    }
    
    function updateProduct($product)
    {
        $this->_db->updateProduct($product);
    }
    
    function addProduct($product)
    {
        return $this->_db->addProduct($product);
    }
    
    function removeTuote($id)
    {
        $this->_db->removeTuote($id);
    }

    function updateProductImage($id, $data, $mime)
    {
        $this->_db->updateProductImage($id, $data, $mime);
    }

    function getRecentlyAdded($limit)
    {
        return $this->_db->getRecentlyAdded($limit);
    }

    // -----------------------------------------------------------------------
    // ------------------ VARASTO --------------------------------------------
    // -----------------------------------------------------------------------
    
    function getVarastoSaldo($id)
    {
        return $this->_db->getVarastosaldo($id);
    }
    
    // -----------------------------------------------------------------------
    // ------------------ KATEGORIAT -----------------------------------------
    // -----------------------------------------------------------------------
    
    function getKategoriat()
    {
        return $this->_db->getCategorys();
    }
    
    function getTuotteenkategoriat($id)
    {
        return $this->_db->getTuotteenkategoriat($id);
    }
    
    function addTuotteelleKategoria($productId, $categoryId)
    {
        $this->_db->addTuotteelleKategoria($productId, $categoryId);
    }
    
    function addCategory($category, $maincategory)
    {
        if($maincategory == 0)
        {
            $this->_db->addMainCategory($category);
        }
        else
        {
            $this->_db->addCategory($category, $maincategory);
        }

    }
    
    function updateCategory($id, $category)
    {
        $this->_db->updateCategory($id, $category);
    }

    function removeCategory($id)
    {
        $this->_db->removeCategory($id);
    }
    
    function removeTuotteenKategoria($productId, $categoryId)
    {
        $this->_db->removeTuotteenKategoria($productId, $categoryId);
    }

    function removeTuotteenKategoriat($id)
    {
        $this->_db->removeTuotteenKategoriat($id);
    }

    function getCategoryNameById($id)
    {
        return $this->_db->getCategoryNameById($id);
    }

    // -----------------------------------------------------------------------
    // ------------------ ASIAKKAAT ------------------------------------------
    // -----------------------------------------------------------------------
    
    // Lisää asiakkaan
    function addAsiakkas($etunimi, $sukunimi, $email, $salasana)
    {
        if($this->_db->getAsiakasByEmail($email))
            return -1;
        
        $id = $this->_db->addAsiakas($etunimi, $sukunimi, $email, $this->createPasswordHash($salasana));
        $this->checkLogin($email, $salasana);
        return $id;
    }
    
    // -----------------------------------------------------------------------
    // ------------------ TYÖNTEKIJÄT ----------------------------------------
    // -----------------------------------------------------------------------
    
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
    
    
    // -----------------------------------------------------------------------
    // ------------------ ASIAKKAAT JA TYÖNTEKIJÄT ---------------------------
    // -----------------------------------------------------------------------
    
    // Lähettää hukatun salasanan
    function sendLostPassword($email)
    {
         $asiakas = $this->_db->getAsiakasByEmail($email);
    }
    
    // -----------------------------------------------------------------------
}
?>
