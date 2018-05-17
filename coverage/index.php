<?php

/*
    Author : Abhinav Kulinbhai Pathak
    Description : REST api for CRUD operations.
*/
include "../models/CoverageRepository.php";
$config = include("../db/config.php");
try{
$db = new PDO( $conn );
}
catch(PDOException $ex){
    throw new MyDatabaseException( $ex->getMessage( ) , $ex->getCode( ) );
}

//Creates a new instance of CoverageRepository class using given DB Context
$Coverage = new CoverageRepository($db);

switch($_SERVER["REQUEST_METHOD"]) {
    //Receives GET requests and returns all the records from the database
    case "GET":
        $error = "";
        $result = $Coverage->getAll(array(
            "id" => intval(isset($_GET["id"]) ? $_GET["id"] : '' ),
            "name" => (isset($_GET["name"]) ? $_GET["name"] : ''),
            "cost" => intval(isset($_GET["cost"]) ? $_GET["cost"] : '' )
        ));
        break;

    //Receives POST requests and Adds given data to the database
    case "POST":
        if(validate("POST") == true)
        {
            $error = "";
            $result = $Coverage->insert(array(
                "name" => $_POST["name"],
                "cost" => intval($_POST["cost"])
                ));
            $error .= $Coverage->sendmail("Inserted",json_encode($result));

        }
        break;

    //Receives PUT(update) requests and updates changes to the database
    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);     
        if(validate("PUT") == true)
        {
            $error = "";
            $result = $Coverage->update(array(
                "id" => intval($_PUT["id"]),
                "name" => $_PUT["name"],
                "cost" => intval($_PUT["cost"])
                ));
            $error .= $Coverage->sendmail("Updated",json_encode($result));
        }
        break;

    //Receives DELETE requests and removes the record containing given ID from the database
    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        if(validate("DELETE") == true)
        {
            $error = "";
            $result = $Coverage->remove(intval($_DELETE["id"]));
            $Coverage->sendmail("Deleted",json_encode($result));
            $result="";
        }
        break;
}

//Validates data before sending it to the database
//Sends any errors back to the user
function validate($caller)
    {
        global $error;
        $error = "";
    
       
        switch($caller)
        {
            
            case "POST" :
                         if(strcmp($_POST['name'],"AUTO") != 0 && strcmp($_POST['name'],"PROPERTY") !=0 && strcmp($_POST['name'] ,"LEGAL EXPENSE") !=0 )
                            $error .= "Enter valid name<br>";
                        else if(!preg_match('/^[0-9]*$/', $_POST["cost"]))
                            $error .= "Enter valid cost<br>";
                        break;

            case "PUT" :
                        parse_str(file_get_contents("php://input"), $_PUT);
                        if(!preg_match('/^[0-9]*$/', $_PUT["id"]))
                            $error .= "Invalid ID\n";
                        else if(strcmp($_PUT['name'],"AUTO") != 0 && strcmp($_PUT['name'],"PROPERTY") !=0 && strcmp($_PUT['name'] ,"LEGAL EXPENSE") !=0 )
                            $error .= "Enter valid coverage name<br>";
                        else if(!preg_match('/^[0-9]*$/', $_PUT["cost"]))
                            $error .= "Enter valid cost<br>";
                        break;

            case "DELETE" :
                        parse_str(file_get_contents("php://input"), $_DELETE);
                        if(!preg_match('/^[0-9]*$/',$_DELETE["id"]))
                            $error .= "Enter valid ID<br>";            
                        break;
        }
        if($error != "")
             return false;
        else
            return true;
    }

    //If there are no erros 
    if ($error == "")
    {
        header('Content-Type: application/json');
        print json_encode($result);
    }
else
    {
        header('HTTP/1.1 500 Invalid Data Entered');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($error));
    }
?>
