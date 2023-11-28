<!-- Formular til søgning med GET-metoden og id'et "live-search-form" -->
<form method="GET" id="live-search-form">
    <label for="search">Søg efter produkter:</label>
    <!-- Inputfelt til søgetermer med id'et "search" -->
    <input type="text" name="search" id="search" placeholder="Indtast søgeterm">
</form>

<!-- Container til live søge resultater med id'et "live-search-results" -->
<div id="live-search-results"></div>

<!-- Inkluder jQuery, hvis det ikke allerede er inkluderet -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript til live søgning -->
<script>
    // Vent på, at dokumentet er klar
    $(document).ready(function () {
        // Lyt efter inputbegivenheder i søgefeltet med id'et "search"
        $('#search').on('input', function () {
            // Hent søgetermet fra inputfeltet
            var searchTerm = $(this).val();

            // Kontroller, om søgetermen er længere end eller lig med 2 tegn
            if (searchTerm.length >= 2) {
                // Lav en AJAX-anmodning for at hente live søgeresultater
                $.ajax({
                    url: '<?= getenv('BASE_URL') ?>/product/live_search', // URL til kontrolleren for live søgning
                    method: 'GET',
                    data: { search: searchTerm }, // Send søgetermen som data
                    success: function (data) {
                        // Opdater live søgeresultater i containeren med id'et "live-search-results"
                        $('#live-search-results').html(data);
                    },
                    error: function (error) {
                        console.error('Fejl ved søgning:', error);
                    }
                });
            } else {
                // Ryd live søgeresultater, hvis søgeforespørgslen er for kort
                $('#live-search-results').html('');
            }
        });
    });
</script>