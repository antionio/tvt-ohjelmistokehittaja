<?php

// PDO = PHP Data Objects
// Tietokantayhteyden muodostaminen
$pdo = new PDO(
    "mysql:host=db:3306;dbname=productdb;charset=utf8mb4",
    "root",
    "root"
);

// määrittää HTTP-vastauksen headeriin kaikille vastauksille
// yhteisen tyypin: application/json
header("Content-Type: application/json");

// haetaan HTTP-pyynnön tiedoista metodi (GET, PUT, POST jne.)
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // määrittelee SQL-lausekkeen kaikkien tuotteiden hakemiselle
        $sql = "SELECT * FROM products";
        // muodostaa lausekkeesta query-olion
        $stmt = $pdo->query($sql);
        // pyytää query-oliota tekemään haun tietokantaan
        // PDO::FETCH_ASSOC määrittelee paluuarvoksi taulukon (array)
        $products= $stmt->fetchAll(PDO::FETCH_ASSOC);
        // palauttaa taulukon JSON-muodossa
        echo json_encode($products);
        break;
    case 'POST':
        // hakee HTTP-pyynnön sisällön tekstinä (eli http body)
        $json = file_get_contents('php://input');
        // muuttaa pyynnön sisällön tekstistä JSON-taulukoksi,
        // jotta sitä on helppo käsitellä koodissa
        $data = json_decode($json, true);

        // muodostaa "prepared statement" tyyppisen sql-lausekkeen
        // käyttäjältä tulevan tiedon tietokantaan lisäämistä varten
        // https://www.w3schools.com/sqL/sql_prepared_statements.asp
        $stmt = $pdo->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
        // suorittaa "prepared statementin" antamalla sille
        // halutut arvot argumentteina suoraan JSON-datasta
        $stmt->execute([
            ':name' => $data['name'],
            ':price' => $data['price']
        ]);

        // palauttaa vastauksen
        echo json_encode([
            'success' => 'true'
        ]);
        
        break;
    default:
        // jos käyttäjä kutsuu jotain muuta kuin toteutettua
        // http-metodia, palauttaa http koodin 405 method not allowed
        // ja myös virheviestin JSONina
        http_response_code(405);
        echo json_encode("Error: Method not supported");
        break;
}

?>