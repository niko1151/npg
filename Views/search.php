<!-- search.php -->
<form method="GET" id="live-search-form">
    <label for="search">Søg efter produkter:</label>
    <input type="text" name="search" id="search" placeholder="Indtast søgeterm">
</form>

<!-- Container til live søge resultater -->
<div id="live-search-results"></div>

<!-- Include jQuery hvis det ikke allerede er inkluderet -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript for live søgning -->
<script>
    $(document).ready(function () {
        $('#search').on('input', function () {
            var searchTerm = $(this).val();

            if (searchTerm.length >= 2) {
                // Lav en AJAX-anmodning for at hente live søgeresultater
                $.ajax({
                    url: '<?= getenv('BASE_URL') ?>/product/live_search',
                    method: 'GET',
                    data: { search: searchTerm },
                    success: function (data) {
                        // Opdater live søgeresultater
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