<!DOCTYPE html>
<html lang="nl">
<head>
    <!-- Meta tags voor character encoding en responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Pagina titel -->
    <title>Bedrijf Accepteren/Afwijzen</title>
    
    <!-- Link naar externe CSS stylesheet -->
    <link rel="stylesheet" href="CSS/accepteer.css">
</head>
<body>
    <!-- Container div - Witte box voor alle content -->
    <div class="container">
        <?php
        // Laad bedrijven uit JSON bestand
        $file = 'bedrijven.json';
        $companies = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        // Haal parameters op uit URL (GET request)
        $company_id = isset($_GET['company_id']) ? $_GET['company_id'] : null; // ID van het bedrijf
        $actie = isset($_GET['actie']) ? $_GET['actie'] : null; // Actie: "accepteren" of "afwijzen"
        $confirm = isset($_GET['confirm']) ? $_GET['confirm'] : false; // Bevestiging van gebruiker

        // Zoek het bedrijf in de array
        $company_found = null;
        foreach ($companies as $company) {
            if ($company['company_id'] == $company_id) {
                $company_found = $company; // Bedrijf gevonden
                break;
            }
        }

        // ===== SCENARIO 1: Bevestiging ontvangen - Verwerk de actie =====
        if ($confirm && $company_id && $actie) {
            // Loop door bedrijven om het juiste bedrijf te vinden
            foreach ($companies as $i => $company) {
                if ($company['company_id'] == $company_id) {
                    // Accepteren: Zet bedrijf op actief
                    if ($actie == 'accepteren') {
                        $companies[$i]['company_active'] = true; // Bedrijf activeren
                        $success_message = "Bedrijf succesvol geaccepteerd!";
                        $icon_class = "success"; // Groene icoon
                        $icon_symbol = "✓"; // Vinkje symbool
                    } 
                    // Afwijzen: Verwijder bedrijf uit array
                    elseif ($actie == 'afwijzen') {
                        array_splice($companies, $i, 1); // Bedrijf verwijderen
                        $success_message = "Bedrijf succesvol afgewezen en verwijderd!";
                        $icon_class = "error"; // Rode icoon
                        $icon_symbol = "✗"; // Kruis symbool
                    }
                    break;
                }
            }

            // Sla aangepaste bedrijvenlijst op in JSON bestand
            file_put_contents($file, json_encode($companies, JSON_PRETTY_PRINT));
            
            // Toon succesbericht met icoon
            echo '<div class="icon ' . $icon_class . '">' . $icon_symbol . '</div>';
            echo '<h1>' . $success_message . '</h1>';
            echo '<p>De wijziging is doorgevoerd in het systeem.</p>';
            
            // Button group met terug knop
            echo '<div class="btn-group">';
            echo '<a href="admin.php" class="btn btn-success">Terug naar Admin</a>';
            echo '</div>';
            
            // Auto-redirect naar admin.php na 3 seconden
            echo '<script>setTimeout(function(){ window.location.href = "admin.php"; }, 3000);</script>';
        } 
        
        // ===== SCENARIO 2: Toon bevestigingspagina =====
        elseif ($company_id && $actie && $company_found) {
            // Bepaal teksten en classes op basis van actie
            $actie_text = ($actie == 'accepteren') ? 'accepteren' : 'afwijzen'; // Actie tekst
            $btn_class = ($actie == 'accepteren') ? 'btn-success' : 'btn-danger'; // Groene of rode knop
            $icon_class = ($actie == 'accepteren') ? 'success' : 'error'; // Groene of rode icoon
            $icon_symbol = ($actie == 'accepteren') ? '?' : '!'; // Vraagteken of uitroepteken
            
            // Toon icoon en bevestigingstekst
            echo '<div class="icon ' . $icon_class . '">' . $icon_symbol . '</div>';
            echo '<h1>Bevestiging vereist</h1>';
            echo '<p>Weet u zeker dat u dit bedrijf wilt <strong>' . $actie_text . '</strong>?</p>';
            
            // Toon bedrijfsinformatie in een box
            echo '<div class="company-info">';
            echo '<strong>Bedrijfsnaam:</strong> ' . htmlspecialchars($company_found['company_name'] ?? 'Onbekend');
            echo '<br><strong>Bedrijf ID:</strong> ' . htmlspecialchars($company_id);
            echo '</div>';
            
            // Button group met bevestig en annuleer knoppen
            echo '<div class="btn-group">';
            // Bevestig knop - voegt &confirm=1 toe aan URL
            echo '<a href="accepteer.php?company_id=' . urlencode($company_id) . '&actie=' . urlencode($actie) . '&confirm=1" class="btn ' . $btn_class . '">Ja, ' . $actie_text . '</a>';
            // Annuleer knop - terug naar admin
            echo '<a href="admin.php" class="btn btn-secondary">Annuleren</a>';
            echo '</div>';
        } 
        
        // ===== SCENARIO 3: Foutmelding - Ongeldige parameters =====
        else {
            // Toon foutmelding met rode icoon
            echo '<div class="icon error">!</div>';
            echo '<h1>Fout</h1>';
            echo '<p>Ongeldige parameters. Bedrijf niet gevonden.</p>';
            
            // Button group met terug knop
            echo '<div class="btn-group">';
            echo '<a href="admin.php" class="btn btn-secondary">Terug naar Admin</a>';
            echo '</div>';
        }
        ?>
    </div> <!-- Einde container -->
</body>
</html>
