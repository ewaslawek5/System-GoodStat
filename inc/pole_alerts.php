<?php
// Włączenie raportowania wszystkich rodzajów błędów
error_reporting(E_ALL);

// Włączenie wyświetlania błędów na ekranie (w przeglądarce)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

function Pole_Alerts_Ok(string $tresc_info): void {		
    // PHP 8.4: Używamy htmlspecialchars, aby zapobiec atakom XSS
    $safe_info = htmlspecialchars($tresc_info, ENT_QUOTES, 'UTF-8');
    
    echo '<div class="container">
            <div class="alert px-3 py-3 bg-gradient-success text-white fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong><i class="fas fa-check-circle"></i> OK!</strong> ' . $safe_info . '
            </div>
          </div>';
}

function Pole_Alerts_Uwaga(string $tresc_info): void {		
    $safe_info = htmlspecialchars($tresc_info, ENT_QUOTES, 'UTF-8');
    
    echo '<div style="display: block;">
            <div class="alert px-3 py-3 bg-gradient-danger text-white fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong><i class="fas fa-exclamation-triangle"></i> UWAGA!</strong> ' . $safe_info . '
            </div>
          </div>';
}

function Pole_Alerts_Info(string $tresc_info): void {		
    $safe_info = htmlspecialchars($tresc_info, ENT_QUOTES, 'UTF-8');
    
    echo '<div class="container">
            <div class="alert px-3 py-3 bg-gradient-info text-white fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong><i class="fas fa-info-circle"></i> INFO!</strong> ' . $safe_info . '
            </div>
          </div>';
}

// PHP 8.4: Upewniamy się, że zmienne istnieją (używając operatora ?? lub sprawdzając isset)
$uruchom = $uruchom_alert ?? 'nie';
$rodzaj  = $rodzaj_alert ?? '';
$tresc   = $tresc_info ?? '';

if ($uruchom === 'tak') {
    // Użycie match zamiast drabinki if/else
    match ($rodzaj) {
        'uwaga' => Pole_Alerts_Uwaga($tresc),
        'info'  => Pole_Alerts_Info($tresc),
        'ok'    => Pole_Alerts_Ok($tresc),
        default => null, // Opcjonalnie: obsługa nieznanego rodzaju alertu
    };
}

