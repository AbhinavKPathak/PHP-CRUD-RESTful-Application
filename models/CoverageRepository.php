<?php

/*
    Author : Abhinav Kulinbhai Pathak
    Descriptions : Provide functions to communicate with the database
*/

include "Coverage.php";

class CoverageRepository {

    protected $db;
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    //Creates a new Coverage object for given data
    private function read($row) {
        $result = new Coverage();
        $result->id = $row["ID"];
        $result->name = $row["Coverage_Name"];
        $result->cost = $row["Cost"];
        return $result;
    }

    //Gets coverage record by ID
    public function getById($id) {
        $sql = "SELECT * FROM Coverage WHERE ID = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    //Gets all records from database Coverage table
    public function getAll($filter) {
        if($filter["id"] != '')
            $id = "%" . $filter["id"] . "%";
        else
            $id = "%";

        if($filter["name"] != '')
            $name = "%" . $filter["name"] . "%";
        else
            $name = "%";
        
        if($filter["cost"] != '')
            $cost = "%" . $filter["cost"] . "%";
        else
            $cost = "%";

        $sql = "SELECT * FROM Coverage WHERE Coverage_Name LIKE :name AND Cost LIKE :cost AND ID LIKE :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id);
        $q->bindParam(":name", $name);
        $q->bindParam(":cost", $cost);
        $q->execute();
        $rows = $q->fetchAll();

        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    //Inserts new record to Coverage table in the database
    public function insert($data) {
        $sql = "INSERT INTO Coverage (Coverage_Name, Cost) VALUES (:name, :cost)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":name", $data["name"]);
        $q->bindParam(":cost", $data["cost"], PDO::PARAM_INT);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    //Updates given record in the the database
    public function update($data) {
        $sql = "UPDATE Coverage SET Coverage_Name = :name, Cost = :cost WHERE ID = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $q->bindParam(":name", $data["name"]);
        $q->bindParam(":cost", $data["cost"], PDO::PARAM_INT);
        $q->execute();
        return $this->getById($data["id"]);
    }

    //Removes a record from the database using ID
    public function remove($id) {
        $result=$this->getById($id);
        $sql = "DELETE FROM Coverage WHERE ID = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        return $result;
    }
    
    //Notifies about any CRUD operations through mail.
    //Uses local mail server e.g. SMTP4dev 
    public function sendmail($identifier,$result) {
        $sendto = "coverages@fredcohen.com";
        $from = "system@fredcohen.com";
        $subject = "Record Changed";
        $employeeNo = mt_rand(1000,100000);
        $res=json_decode($result, true);
        $id = $res["id"];
        $name = $res["name"];
        $cost = $res["cost"];
        date_default_timezone_set("America/New_York");

        $headers = "From: " . $from . "\r\n";
        $headers .= "CC: sysadmin@fredcohen.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $message = '<html><body>';
        $message .= '<img src="https://media.merchantcircle.com/29977176/MSN%20icon%20info%20bubble_full.png" height=200 width=200/><br>';
        $message .= "<h3 style='color:red'>Record $identifier</h3>";
        $message .= '<table style="text-align:left" padding="20">';
        $message .= "<tr><td>Coverage ID</td><td>$id</td></tr>
                    <tr><td>Coverage Name</td><td>$name</td></tr>
                    <tr><td>Coverage Cost</td><td>$cost</td></tr>
                    <tr><td>Employee</td><td>#$employeeNo</td></tr>
                    <tr><td>Timestamp</td><td>".date('m/d/Y h:i:s a', time())."</td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";

       
        if(!mail($sendto, $subject, $message, $headers))
        {
            return "Record Updated,Cannot connect to mail server";
        }
        else
        {
            return "";
        }
       
    }

}

?>