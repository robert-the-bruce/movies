<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 23.11.2017
 * Time: 18:00
 */
include_once 'DatabaseConnection.php';

class DBUsage extends DatabaseConnection
{
    private $query;
    private $dbconnect;
    private $stmt;

    /**
     * Konstruktor: erzeugt eine Instanz der Klasse DatabaseConnection
     * DB connection constructor.
     */
    public function __construct($server, $user, $pwd, $db)
    {
        $this->dbconnect = new DatabaseConnection($server, $user, $pwd, $db);
    }

    /**
     *
     */
    private function StatementPrepare()
    {
        $this->stmt = $this->dbconnect->connect->prepare($this->query);
    }

    /**
     *
     */
    private function StatementExecute()
    {
        $this->stmt->execute();
    }

    /**
     * @param $bindParamArray
     */
    private function StatementBindParam($bindParamArray)
    {
        for($i = 0; $i < sizeof($bindParamArray); $i++)
        {
            $this->stmt->bindParam($i+1, $bindParamArray[$i]);
        }
    }

    /**
     * Verwendung für insert, update etc.
     * @param $query
     * @param null $bindParamArray
     * @return mixed
     */
    public function GetStatement($query, $bindParamArray = null)
    {
        $this->query = $query;
        $this->StatementPrepare();
        if($bindParamArray != null)
        {
            $this->StatementBindParam($bindParamArray);
        }

        $this->StatementExecute();
        return $this->stmt;
    }

    /**
     * Gibt die letzt durch auto_increment gesetzte ID zurück
     * @return string
     */
    public function GetLastInsertID()
    {
        $lastID = $this->dbconnect->connect->lastInsertId();
        return $lastID;
    }


    function ShowTable($stmt)
    {
        $meta = [];

        echo '<div><table><tr>';
        if ($stmt->columnCount() > 0){
            for($i = 0; $i < $stmt->columnCount(); $i++)
            {
                $meta[$i] = $stmt->getColumnMeta($i);
                echo '<th>' . $meta[$i]['name'] . '</th>';
            }
            echo '</tr>';
            while($row = $stmt->fetch(PDO::FETCH_NUM))
            {
                echo '<tr>';
                foreach ($row as $r)
                {
                    echo '<td>'. $r . '</td>';
                }
                echo '</tr>';
            }
            echo '</table></div>';
        }
    }

}