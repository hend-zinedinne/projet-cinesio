<?php

function abbrevierPays($pays): string
{
    return strtoupper(substr($pays, 0, 3));
}

function convertirMinutes($duree): string
{
    $heures = ($duree - ($duree % 60)) / 60;
    $minutes = $duree % 60;

    if ($heures == 0) {
        return $minutes . "min";
    } else {
        return $heures . "h " . $minutes . "min";
    }
}