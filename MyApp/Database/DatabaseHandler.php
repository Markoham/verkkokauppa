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
    
    // -----------------------------------------------------------------------
    // ------------------ TUOTTEET -------------------------------------------
    // -----------------------------------------------------------------------
    
        // Hakee halutun tuotteen
    function getTuote($id)
    {
        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tuotteet WHERE idtuote = ?;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Tuote");
        $kysely->execute(array($id));

        return $kysely->fetchAll()[0];
    }
    
    // Hakee kaikki tuotteet
    function getKaikkiTuotteet()
    {
        $tuotteet = Array();

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tuotteet;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Tuote");
        $kysely->execute();

        while ($tuote = $kysely->fetch())
        {
            $tuotteet[] = $tuote;
        }
        
        return $tuotteet;
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
    
    function addProduct($product)
    {
        $kysely = $this->_pdo->prepare("INSERT INTO " . $this->_prefix . "tuotteet (tuotteennimi, hinta, kuvaus) VALUES (?, ?, ?);");
        $kysely->execute(array($product->getTuotteennimi(), $product->getHinta(), $product->getKuvaus()));

        return $this->_pdo->lastInsertId();
    }

    function updateProduct($product)
    {
        $kysely = $this->_pdo->prepare("UPDATE " . $this->_prefix . "tuotteet SET tuotteennimi = ?, hinta = ?, kuvaus = ? WHERE idtuote = ?");
        $kysely->execute(array($product->getTuotteennimi(), $product->getHinta(), $product->getKuvaus(), $product->getId()));
    }

    function removeTuote($id)
    {
        $kysely = $this->_pdo->prepare("DELETE FROM " . $this->_prefix . "tuotteet WHERE idtuote = ?;");
        $kysely->execute(array($id));
    }

    function updateProductImage($id, $data, $mime)
    {
        $kysely = $this->_pdo->prepare("UPDATE " . $this->_prefix . "tuotteet SET kuva = ?, mimetype = ? WHERE idtuote = ?");
        $kysely->execute(array($data, $mime, $id));
    }

    function getRecentlyAdded($limit)
    {
        $tuotteet = Array();

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tuotteet ORDER BY idtuote DESC LIMIT 5;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Tuote");
        $kysely->execute();

        while ($tuote = $kysely->fetch())
        {
            $tuotteet[] = $tuote;
        }

        return $tuotteet;
    }

    function searchProducts($search)
    {
        $search = "%" . $search . "%";
        $tuotteet = Array();

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tuotteet WHERE tuotteenNimi LIKE ? OR kuvaus LIKE ? ORDER BY idtuote DESC;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Tuote");
        $kysely->execute(array($search, $search));

        while ($tuote = $kysely->fetch())
        {
            $tuotteet[] = $tuote;
        }

        return $tuotteet;
    }

    // -----------------------------------------------------------------------
    // ------------------ END TUOTTEET ---------------------------------------
    // -----------------------------------------------------------------------
    // ------------------ KATEGORIAT -----------------------------------------
    // -----------------------------------------------------------------------

    function getTuotteenkategoriat($id)
    {
        $kysely = $this->_pdo->prepare("SELECT k.* FROM " . $this->_prefix . "tuotteenkategoriat AS tk, " . $this->_prefix . "kategoriat AS k WHERE tk.tuoteid = ? AND tk.kategoriaid = k.idkategoria;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Kategoria");
        $kysely->execute(array($id));

        return $kysely->fetchAll();
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

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "kategoriat WHERE paakategoria = 1 ORDER BY kategoria ASC;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Kategoria");
        $kysely->execute();

        while ($kat = $kysely->fetch())
        {
            $kyselyAla = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "kategoriat AS k," . $this->_prefix . "alakategoriat AS ak WHERE ak.alakategoriaid = k.idkategoria AND ak.ylakategoriaid = ? ORDER BY kategoria ASC;");
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
    
    function addTuotteelleKategoria($productId, $categoryId)
    {
        $kysely = $this->_pdo->prepare("INSERT INTO " . $this->_prefix . "tuotteenkategoriat (tuoteid, kategoriaid) VALUES (?, ?);");
        $kysely->execute(array($productId, $categoryId));

        return $this->_pdo->lastInsertId();
    }

    // Lisää pääkategorian
    function addMainCategory($category)
    {
        $kysely = $this->_pdo->prepare("INSERT INTO " . $this->_prefix . "kategoriat (kategoria, paakategoria) VALUES (?, 1);");
        $kysely->execute(array($category));

        return $this->_pdo->lastInsertId();
    }

    // Lisää kategorian
    function addCategory($category, $maincategory)
    {
        $kysely = $this->_pdo->prepare("INSERT INTO " . $this->_prefix . "kategoriat (kategoria) VALUES (?);");
        $kysely->execute(array($category));

        $id = $this->_pdo->lastInsertId();

        $kysely2 = $this->_pdo->prepare("INSERT INTO " . $this->_prefix . "alakategoriat (ylakategoriaid, alakategoriaid) VALUES (?, ?);");
        $kysely2->execute(array($maincategory, $id));

        return $id;
    }

    function updateCategory($id, $category)
    {
        $kysely = $this->_pdo->prepare("UPDATE " . $this->_prefix . "kategoriat SET kategoria = ? WHERE idkategoria = ?;");
        $kysely->execute(array($category, $id));
    }

    function removeCategory($id)
    {
        $kysely = $this->_pdo->prepare("DELETE FROM " . $this->_prefix . "kategoriat WHERE idkategoria = ?;");
        $kysely->execute(array($id));
    }

    function removeTuotteenKategoria($productId, $categoryId)
    {
        $kysely = $this->_pdo->prepare("DELETE FROM " . $this->_prefix . "tuotteenkategoriat WHERE tuoteid = ? AND kategoriaid = ?;");
        $kysely->execute(array($productId, $categoryId));
    }

    function removeTuotteenKategoriat($id)
    {
        $kysely = $this->_pdo->prepare("DELETE FROM " . $this->_prefix . "tuotteenkategoriat WHERE tuoteid = ?;");
        $kysely->execute(array($id));
    }

    function getCategoryNameById($id)
    {
        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "kategoriat WHERE idkategoria = ?;");
        $kysely->execute(array($id));

        return $kysely->fetchAll()[0]['kategoria'];
    }

    // -----------------------------------------------------------------------
    // ------------------ END KATEGORIAT -------------------------------------
    // -----------------------------------------------------------------------
    // ------------------ ASIAKKAAT ------------------------------------------
    // -----------------------------------------------------------------------

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
    
    // -----------------------------------------------------------------------
    // ------------------ END ASIAKKAAT --------------------------------------
    // -----------------------------------------------------------------------
    // ------------------ TYÖNTEKIJÄT ----------------------------------------
    // -----------------------------------------------------------------------

    // Hakee käyttäjän sähköpostiosoitteen avulla
    function getTyontekijaByEmail($email)
    {
        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tyontekijat WHERE email = ?;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Tyontekija");
        $kysely->execute(array($email));

        $asiakas = @$kysely->fetchAll()[0];
        
        return $asiakas;
    }
    
    // Hakee työntekijän
    function getTyontekija($id)
    {
        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tyontekijat WHERE idtyontekija = ?;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Tyontekija");
        $kysely->execute(array($id));

        return $kysely->fetchAll()[0];
    }
    
    // Hakee työntekijät
    function getTyontekijat()
    {
        $tyontekijat = Array();

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tyontekijat;");
        $kysely->setFetchMode(\PDO::FETCH_CLASS, "\MyApp\DataObjects\Tyontekija");
        $kysely->execute();

        while ($tyontekija = $kysely->fetch())
        {
            $tyontekijat[] = $tyontekija;
        }
        
        return $tyontekijat;
    }
    
    // -----------------------------------------------------------------------
    // ------------------ END TYÖNTEKIJÄT ------------------------------------
    // -----------------------------------------------------------------------
    // ------------------ ASIAKKAAT JA TYÖNTEKIJÄT ---------------------------
    // -----------------------------------------------------------------------
    
    // -----------------------------------------------------------------------
    // ------------------ END ASIAKKAAT JA TYÖNTEKIJÄT -----------------------
    // -----------------------------------------------------------------------
    // ------------------ TILAUS ---------------------------------------------
    // -----------------------------------------------------------------------
    
    function tilausKesken($asiakasId)
    {
        $tyontekijat = Array();

        $kysely = $this->_pdo->prepare("SELECT COUNT(idtilaus) AS yht FROM " . $this->_prefix . "tilaukset WHERE asiakasid = ? AND tilauksentila = 0;");
        $kysely->execute(array($asiakasId));

        return $kysely->fetchColumn();
    }

    function getTilausKesken($asiakasId)
    {
        $tyontekijat = Array();

        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tilaukset WHERE asiakasid = ? AND tilauksentila = 0;");
        $kysely->execute(array($asiakasId));

        $row = $kysely->fetch(\PDO::FETCH_OBJ);

        $tilaus = new \MyApp\DataObjects\Tilaus();
        $tilaus->setId($row->idtilaus);
        $tilaus->setAsiakasId($row->asiakasid);
        return $tilaus;
    }

    function createTilaus($asiakasId)
    {
        $kysely = $this->_pdo->prepare("INSERT INTO " . $this->_prefix . "tilaukset (asiakasid) VALUES (?);");
        $kysely->execute(array($asiakasId));

        return $this->_pdo->lastInsertId();
    }

    function addTuoteTilaukseen($tilausId, $tuoteId)
    {
        $kysely = $this->_pdo->prepare("INSERT INTO " . $this->_prefix . "tilauksentuotteet (tilausid, tuoteid) VALUES (?, ?);");
        $kysely->execute(array($tilausId, $tuoteId));

        return $this->_pdo->lastInsertId();
    }

    function getTilauksenTuotteet($tilaus)
    {
        $kysely = $this->_pdo->prepare("SELECT * FROM " . $this->_prefix . "tilauksentuotteet WHERE tilausid = ?;");
        $kysely->execute(array($tilaus->getId()));

        $tuotteet = array();
        while ($tuote = $kysely->fetch(\PDO::FETCH_OBJ))
        {
            $tt = new \MyApp\DataObjects\TilauksenTuote();
            $tt->setTuoteId($tuote->tuoteid);
            $tt->setMaara(1);
            $tilaus->addTuote($tt);
        }

        return $tilaus;
    }

    function updateTilausStatus($tilaus, $status)
    {
        $kysely = $this->_pdo->prepare("UPDATE " . $this->_prefix . "tilaukset SET tilauksentila = ? WHERE idTilaus = ?;");
        $kysely->execute(array($status,$tilaus->getId()));
    }

    // -----------------------------------------------------------------------
    // ------------------ END TILAUS -----------------------------------------
    // -----------------------------------------------------------------------

    // Sulkee yhteyden
    function close()
    {
        $this->_pdo = null;
    }
}
?>
