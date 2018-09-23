<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConnectionClass
 *
 * @author User
 */
class ConnectionClass {

    private $host, $username, $password, $database;
    private $link;

    function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    function ConnectDB() {
        $this->link = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$this->link) {
            die("A problem occured");
        }
    }

    function AddFavorite($fullName, $language, $latestTag) {
        if ($latestTag == 'undefined') {
            $latestTag = '-';
        }
        $query = "INSERT INTO `favorites` (`FullName`, `Language`, `LatestTag`) VALUES ('$fullName', '$language', '$latestTag');";
        mysqli_query($this->link, $query);
    }

    function DeleteFavorite($fullname) {
        $query = "DELETE FROM `favorites` WHERE `favorites`.`FullName` = '$fullname'";
        mysqli_query($this->link, $query);
    }

    function DisplayFavorites() {

        $query = "SELECT * FROM `favorites`";
        $result = mysqli_query($this->link, $query);
        echo "<table id='favRepos'>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Language</th>";
        echo "<th>Latest Tag</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_array($result, 1)) {
            $fullName = $row['FullName'];
            $language = $row['Language'];
            $latestTage = $row['LatestTag'];
            echo "<tr>";
            echo "<td id='fName'>$fullName</td>";
            echo "<td>$language</td>";
            echo "<td>$latestTage</td>";
            echo "<td><a href='#' id='remove'>Remove</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function Display() {

        $query = "SELECT * FROM `favorites`";
        $result = mysqli_query($this->link, $query);

        while ($row = mysqli_fetch_array($result, 1)) {
            $rows[] = $row;
        }
        if (empty($rows)) {
            
        } else {
            return $rows;
        }
    }

}

$conObj = new ConnectionClass('localhost', 'root', '', 'githubfavorites');
$conObj->ConnectDB();
