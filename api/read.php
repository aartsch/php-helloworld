<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    include_once '../domain/report.php';
    $database = new Database();
    $db = $database->getConnection();
    $items = new Employee($db);
    $stmt = $items->getReports();
    $itemCount = $stmt->rowCount();

    echo json_encode($itemCount);
    if($itemCount > 0){
        
        $reportArr = array();
        $reportArr["body"] = array();
        $reportArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "description" => $description,
            );
            array_push($reportArr["body"], $e);
        }
        echo json_encode($reportArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No report found.")
        );
    }
?>