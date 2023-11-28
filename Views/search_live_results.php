<?php
// Tjekker om søgeresultaterne ikke er tomme
if (!empty($searchResults)) :
    // Starter en ordnet liste til visning af søgeresultaterne
    ?>
    <ul>
        <?php
        // Gennemløber hvert søgeresultat og viser det som et listeelement med et link til produktets detaljeside
        foreach ($searchResults as $result) :
        ?>
            <li>
                <a href="<?= getenv('BASE_URL') ?>/product_details/<?= $result->produkt_id ?>">
                    <?= $result->produkt_navn ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php
// Hvis der ikke er søgeresultater, men der er foretaget en søgning
elseif (isset($searchResults) && empty($searchResults)) :
    // Viser en besked om, at ingen resultater blev fundet
    ?>
    <p>Ingen resultater fundet.</p>
<?php endif; ?>