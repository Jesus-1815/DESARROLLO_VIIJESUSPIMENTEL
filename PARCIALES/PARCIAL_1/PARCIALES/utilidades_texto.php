<?php
// Función que cuenta el número de palabras en un texto
function contar_palabras($texto) {
    return str_word_count($texto);
}

// Función que cuenta el número de vocales en un texto
function contar_vocales($texto) {
    $texto = strtolower($texto); // Convertimos el texto a minúsculas
    $vocales = ['a', 'e', 'i', 'o', 'u'];
    $contador = 0;
    
    // Contamos las vocales
    for ($i = 0; $i < strlen($texto); $i++) {
        if (in_array($texto[$i], $vocales)) {
            $contador++;
        }
    }
    
    return $contador;
}

// Función que invierte el orden de las palabras en un texto
function invertir_palabras($texto) {
    $palabras = explode(' ', $texto); // Dividimos el texto en palabras
    $palabras_invertidas = array_reverse($palabras); // Invertimos el orden de las palabras
    return implode(' ', $palabras_invertidas); // Unimos las palabras invertidas
}
?>
