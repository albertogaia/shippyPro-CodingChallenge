<?php
// CREAZIONE TABELLE

// Creo la classe per gli aeroporti
class Airport{
    public $id;
    public $name;
    public $code;
    public $lat;
    public $lng;

    // Dichiaro il metodo per poter creare nuovi possibili oggetti
    public function __construct($id, $name, $code, $lat, $lng){
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->lat = $lat;
        $this->lng = $lng;
    }
}

// Creo la classe per i voli
class Flight{
    public $code_departure;
    public $code_arrival;
    public $price;

    // Dichiaro il metodo per poter creare nuovi possibili oggetti
    public function __construct($code_departure, $code_arrival, $price)
    {
        $this->code_departure = $code_departure;
        $this->code_arrival = $code_arrival;
        $this->price = $price;
    }
}

// Creo gli oggetti degli aeroporti
$turinAirport = new Airport(
    1,
    'Aeroporto Internazionale di Torino-Caselle',
    'TRN',
    45.2025,
    7.649444,
);

$romeAirport = new Airport(
    2,
    'Aeroporto Internazionale di Roma Fiumicino "Leonardo da Vinci',
    'FCO',
    41.800278,
    12.238889
);

// Pusho gli aeroporti in un array per poi poterli ciclare e popolare
$airportsArr = [];
array_push($airportsArr, $turinAirport, $romeAirport);

// Creo degli oggetti dei voli con dati random e li pusho in un array contenente i voli
$flightsArr = [];
$n_flights = 5;
for($i = 0; $i < $n_flights; $i++){
    // Creo l'oggetto dei voli
    $flight = new Flight(
        'TRN' . rand(100, 999), // code_departure
        'FCO' . rand(100, 999), // code_arrival
        rand(100, 400) // price
    );
    array_push($flightsArr, $flight);
}

// Creo un array per i prezzi da poi confrontare
$pricesFlights =[];
// Popolo l'array dei prezzi con tutti i prezzi di tutti i voli
foreach($flightsArr as $flightPrice){
    array_push($pricesFlights, $flightPrice->price);
}

// Metto in ordine crescente l'array dei voli per i prezzi
function comparator($obj1, $obj2){
    return $obj1->price > $obj2->price;
}
usort($flightsArr, 'comparator');

// Salvo il prezzo più basso
$lowPrice = min($pricesFlights);
// var_dump($lowPrice);

// Salvo l'oggetto che contiene il prezzo più basso
$ecoFlight = array_filter($flightsArr , function($flight) use($lowPrice){
    return ($flight->price == $lowPrice);
});

// var_dump($ecoFlight);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Flights Scanner</title>
</head>
<body>
    <header class="header">
        <div class="container nav d-flex space-between">
            <div class="nav-brand">
                <a href="">ShippyPro Flight</a>
            </div>
            <div class="nav-user">
                <a href="">Alberto Gaia</a>
            </div>
        </div>
    </header>
    <main>

        <section id="flight-research" class="container d-flex flex-column mt-30">
            <h2>Results for: </h2>
            <h3><?php echo "{$turinAirport->name} ({$turinAirport->code}) -> {$romeAirport->name} ({$romeAirport->code})" ?></h3>
        </section>

        <section id="best-flight" class="container mt-30">
            <div class='row'>
                <h2>Best Result: </h2>
            </div>
            <div class='row d-flex space-between pt-10'>
                <div class='col-4'><h4>Departure Code</h4></div>
                <div class='col-4'><h4>Arrival Code</h4></div>
                <div class='col-4'><h4>Price</h4></div>
            </div>
            <?php foreach($ecoFlight as $flight){ 
            echo "
            <div class='row d-flex space-between pt-10'>
                <div class='col-4'>{$flight->code_departure}</div>
                <div class='col-4'>{$flight->code_arrival}</div>
                <div class='col-4'>€ {$flight->price}</div>
            </div>
            ";} ?>
        </section>

        <section id="all-flights" class="container mt-30">
            <div class='row'>
                <h2>All Result: </h2>
            </div>
            <div class='row d-flex space-between pt-10'>
                <div class='col-4'><h4>Departure Code</h4></div>
                <div class='col-4'><h4>Arrival Code</h4></div>
                <div class='col-4'><h4>Price</h4></div>
            </div>
            <?php foreach($flightsArr as $flight){ 
            echo "
            <div class='row d-flex space-between pt-10'>
                <div class='col-4'>{$flight->code_departure}</div>
                <div class='col-4'>{$flight->code_arrival}</div>
                <div class='col-4'>€ {$flight->price}</div>
            </div>
            ";} ?>

            <button class="btn mt-30" onClick="window.location.reload(true)">New Flights</button>
        </section>

    </main>
</body>
</html>