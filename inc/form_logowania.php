    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Witamy spowrotem!</h1>
                  </div>

<?php
// PHP 8.4: Sprawdzamy czy wynik logowania istnieje, aby uniknąć Warningu
if (($wynik_logowania ?? '') === 'zle') {
    // Pobieramy login bezpiecznie
    $login_input = $_POST['l'] ?? 'nieznany';
    
    echo ' 
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong><i class="fas fa-exclamation-triangle"></i> Błąd!</strong> Login lub Hasło jest niepoprawne!
        </div>';
        
    // Zapis do logów - Używamy Prepared Statements (BEZPIECZEŃSTWO!)
    // Nigdy nie wkładamy $_POST['l'] bezpośrednio do ciągu SQL
    $opis_logu = "<b>Nieudane logowanie</b> do Systemu, nr.IP: " . ($nr_ip ?? '0.0.0.0') . ", login: <b>" . htmlspecialchars($login_input) . "</b>";
    
    $stmt = $db->prepare("INSERT INTO hist_operacji (opis, data_utw) VALUES (:opis, :data)");
    $stmt->execute([
        'opis' => $opis_logu,
        'data' => time()
    ]);
}
?>

<form action="index.php" method="post">
    <fieldset class="border p-4 shadow-sm">
        <legend class="w-auto px-2"><i class="fas fa-lock"></i> Logowanie</legend>
        
        <div class="form-group">
            <label for="login">Login</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="login" name="l" 
                       value="<?php echo htmlspecialchars($_POST['l'] ?? ''); ?>" 
                       placeholder="Wpisz login" required>
            </div>
        </div>

        <div class="form-group mt-3">
            <label for="haslo">Hasło</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" class="form-control" id="haslo" name="h" 
                       placeholder="Wpisz hasło" required>
            </div>
        </div>
    </fieldset>

    <div class="mt-4">
        <button type="submit" name="wyslij_loguj" class="btn btn-primary btn-block py-2">
            <i class="fas fa-sign-in-alt"></i> Zaloguj się
        </button>
    </div>
</form>
					
                  <hr />
                  <div class="text-center">
                    <a class="small" href="nie_pamietam_hasla.php">Nie pamiętasz hasła?</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

