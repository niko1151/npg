<!-- Container til at indeholde produkter -->
<div class="container">
    <!-- Row til at organisere produkter i rækker -->
    <div class="row">
        <!-- PHP-løkke for at gennemløbe hvert produkt i $Product-arrayet -->
        <?php foreach($Product as $product): ?>
            <!-- Kolonne med bredde 4 til at vise et produkt -->
            <div class="col-md-4 mb-3">
                <!-- Card til at vise produktets detaljer -->
                <div class="card border-dark" style="background-color: #333; width: 100%;">
                    <!-- Bestem billedstien baseret på om der er angivet et billede i databasen -->
                    <?php
                        $imagePath = isset($product->billede_url) && !empty($product->billede_url)
                            ? "../npg/images/" . $product->billede_url
                            : '../npg/images/NPGaming.png';
                    ?>
                    <!-- Container til at vise produktbillede -->
                    <div style="margin: 5px; padding: 10px; box-sizing: border-box;">
                        <!-- Vis produktbillede med dynamisk sti -->
                        <img src="<?= $imagePath; ?>" class="card-img-top" alt="Product Image" style="width: 100%; height: 450px; object-fit: cover;">
                    </div>
                    <!-- Card body med tekstinformation om produktet -->
                    <div class="card-body text-light">
                        <h5 class="card-title"><?= $product->produkt_navn; ?></h5>
                        <p class="card-text"><strong>Pris:</strong> <?= number_format($product->pris, 2); ?> DKK</p>
                        <p class="card-text"><strong>Kategori:</strong> <?= $product->kategori_navn; ?></p>
                        <a href="product_details/<?= $product->produkt_id; ?>" class="btn btn-info btn-sm">
                            Vis Detaljer
                        </a>
                        <button class="btn btn-primary btn-sm add-to-cart" data-product-id="<?= $product->produkt_id; ?>">
                            Tilføj til kurv
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal til at vise produktbeskrivelse -->
<div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Modal overskrift -->
                <h5 class="modal-title" id="descriptionModalLabel">Produkt Beskrivelse</h5>
                <!-- Luk-knap for modal -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal indhold til produktbeskrivelse -->
            <div class="modal-body" id="descriptionContent"></div>
        </div>
    </div>
</div>

<!-- JavaScript-sektion for håndtering af visning af beskrivelse og tilføjelse til kurven -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Vent med at køre scriptet, indtil DOM'en er fuldt indlæst
    document.addEventListener('DOMContentLoaded', function () {
        // Vis beskrivelse knap
        document.querySelectorAll('.view-description').forEach(function (button) {
            // Lyt efter klik på beskrivelse knappen
            button.addEventListener('click', function () {
                // Hent beskrivelse fra knappens attribut og vis i modal
                var description = this.getAttribute('data-description');
                document.getElementById('descriptionContent').innerText = description;
                // Vis modal
                $('#descriptionModal').modal('show');
            });
        });

        // Tilføj til kurven knap
        jQuery('.add-to-cart').on('click', function() {
            var productId = this.getAttribute('data-product-id');

            // AJAX-anmodning for at tilføje produktet til kurven
            jQuery.ajax({
                type: 'POST',
                url: '<?= getenv('BASE_URL')?>/addToCart/' + productId,
                success: function(response) {
                    // Log succes eller fejl i konsolen og vis besked til brugeren
                    console.log('Response from server:', response);
                    if (response === 'success') {
                        alert('Product added to cart!');
                    } else {
                        console.error('Unexpected server response:', response);
                    }
                },
                error: function(xhr, status, error) {
                    // Log fejlbesked i konsolen
                    console.error(xhr.responseText);
                },
                complete: function() {
                    // Log når AJAX-anmodningen er fuldført
                    console.log('AJAX request completed');
                }
            });
        });
    });
</script>
