<?php

class Opiskelija {

    public string $nimi;
    public string $ryhma;

}

// opiskelija 1, Antti
$antti = new Opiskelija();
$antti->nimi = "Antti";
$antti->ryhma = "Ohjelmistokehittäjä";

// opiskelija 2, Einar
$einar = new Opiskelija();
$einar->nimi = "Einar";
$einar->ryhma = "IT-tukihenkilö";

echo "Opiskelija 1: " . $antti->nimi . ", ryhmä: " . $antti->ryhma . "<br>";
echo "Opiskelija 2: " . $einar->nimi . ", ryhmä: " . $einar->ryhma . "<br>";

?>