<?php
/**
 * Created by PhpStorm.
 * User: regin
 * Date: 17.01.2018
 * Time: 12:24
 */

function DBConnection($server, $user, $pwd, $db)
{
    try
    {
        $connect = new PDO('mysql:host='.$server.';dbname='.$db.';charset=utf8',$user, $pwd);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(Exception $e)
    {
        echo $e->getMessage();
    }
    return $connect;
}

/**
 * @param $connection
 * @param $query
 * @return mixed
 */
function PrepareStatement($connection, $query)
{
    $stmt = $connection->prepare($query);
    return $stmt;
}

function BindParamStatement($stmt, $bindParamArray)
{
    for($i = 0; $i < sizeof($bindParamArray); $i++)
    {
        $stmt->bindParam($i+1, $bindParamArray[$i]);
    }
}

function ExecuteStatement($stmt)
{
    $stmt->execute();

}

function GetStatement($connection, $query, $bindParamArray =null)
{
    $stmt = null;
    if($bindParamArray == null)
    {
        $stmt = PrepareStatement($connection, $query);
        ExecuteStatement($stmt);
    } else {
        $stmt = PrepareStatement($connection, $query);
        BindParamStatement($stmt, $bindParamArray);
        ExecuteStatement($stmt);
    }
    return $stmt;
}

function GetLastInsertID($connection)
{
    return $connection->lastInsertId();
}

function ShowTable($stmt)
{
    echo '<table>';
    while($row = $stmt->fetch(PDO::FETCH_NUM))
    {
        //echo '<tr><td>'.$row[1].'</td></tr>';
        echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td></tr>';
        echo '<tr>';
        foreach($row as $r)
        {
            echo '<td'.$r.'</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}