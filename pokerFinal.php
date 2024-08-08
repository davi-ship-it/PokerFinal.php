<?php

// 1. Función para repartir cartas
function repartirCartas() {
    $palos = ['Corazones', 'Diamantes', 'Tréboles', 'Picas'];
    $valores = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    
    $mazo = [];
    foreach ($palos as $palo) {
        foreach ($valores as $valor) {
            $mazo[] = "$valor de $palo";
        }
    }

    shuffle($mazo); // Barajar el mazo
    return array_slice($mazo, 0, 5); // Devolver 5 cartas
}

// 2. Función para mostrar cartas
function mostrarCartas($cartas) {
    foreach ($cartas as $carta) {
        echo $carta . PHP_EOL;
    }
}

// 3. Función para evaluar la mano
function evaluarMano($cartas) {
    $valores = [];
    $palos = [];

    // Contar los valores y los palos de las cartas
    foreach ($cartas as $carta) {
        $partes = explode(' de ', $carta);
        $valores[] = $partes[0];
        $palos[] = $partes[1];
    }

    $valoresContados = array_count_values($valores);
    $palosContados = array_count_values($palos);

    // Combinaciones posibles
    if (count($palosContados) === 1 && esEscalera($valores)) {
        echo "¡Escalera de color!" . PHP_EOL;
    } elseif (count($valoresContados) === 2) {
        if (max($valoresContados) === 4) {
            echo "¡Póker!" . PHP_EOL;
        } else {
            echo "¡Full House!" . PHP_EOL;
        }
    } elseif (count($palosContados) === 1) {
        echo "¡Color!" . PHP_EOL;
    } elseif (esEscalera($valores)) {
        echo "¡Escalera!" . PHP_EOL;
    } elseif (max($valoresContados) === 3) {
        echo "¡Trío!" . PHP_EOL;
    } elseif (max($valoresContados) === 2 && count($valoresContados) === 3) {
        echo "¡Dos pares!" . PHP_EOL;
    } elseif (max($valoresContados) === 2) {
        echo "¡Un par!" . PHP_EOL;
    } else {
        echo "Carta alta: " . maxCarta($valores) . PHP_EOL;
    }
}

function esEscalera($valores) {
    $orden = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    $indices = [];

    foreach ($valores as $valor) {
        $indices[] = array_search($valor, $orden);
    }

    sort($indices);
    for ($i = 0; $i < count($indices) - 1; $i++) {
        if ($indices[$i + 1] !== $indices[$i] + 1) {
            return false;
        }
    }

    return true;
}

function maxCarta($valores) {
    $orden = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    $maxIndex = -1;

    foreach ($valores as $valor) {
        $index = array_search($valor, $orden);
        if ($index > $maxIndex) {
            $maxIndex = $index;
        }
    }

    return $orden[$maxIndex];
}

// Programa principal
$cartas = repartirCartas();
echo "Cartas repartidas:" . PHP_EOL;
mostrarCartas($cartas);
echo PHP_EOL;

echo "Evaluación de la mano:" . PHP_EOL;
evaluarMano($cartas);

?>
