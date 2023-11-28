<div class="container">
    <div class="row">
        <?php foreach($Product as $product): ?>
            <div class="col-md-4 mb-3">
                <div class="card border-dark" style="background-color: #333; width: 100%;">
                    <!-- Hent billedet fra databasen, eller brug standardbillede -->
                    <?php
                        $imagePath = isset($product->billede_url) && !empty($product->billede_url)
                            ? "../npg/images/" . $product->billede_url
                            : '../npg/images/NPGaming.png';
                    ?>
                    <div style="margin: 5px; padding: 10px; box-sizing: border-box;">
                        <img src="<?= $imagePath; ?>" class="card-img-top" alt="Product Image" style="width: 100%; height: 450px; object-fit: cover;">
                    </div>
                    <div class="card-body text-light">
                        <h5 class="card-title"><?= $product->produkt_navn; ?></h5>
                        <p class="card-text"><strong>Pris:</strong> <?= number_format($product->pris, 2); ?> DKK</p>
                        <p class="card-text"><strong></strong> <?= $product->kategori_navn; ?></p>
                        <!-- Ny knap til detaljeret visning -->
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
<!-- Modal for visning af beskrivelse -->
<div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descriptionModalLabel">Produkt Beskrivelse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="descriptionContent"></div>
        </div>
    </div>
</div>
<!-- JavaScript for håndtering af visning af beskrivelse og tilføjelse til kurven -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Vis beskrivelse knap
        document.querySelectorAll('.view-description').forEach(function (button) {
            button.addEventListener('click', function () {
                var description = this.getAttribute('data-description');
                document.getElementById('descriptionContent').innerText = description;
                $('#descriptionModal').modal('show');
            });
        });
    });

    jQuery('.add-to-cart').on('click', function() {
    var productId = this.getAttribute('data-product-id');

    jQuery.ajax({
        type: 'POST',
        url: '<?= getenv('BASE_URL')?>/addToCart/' + productId,
        success: function(response) {
    console.log('Response from server:', response);
    if (response === 'success') {
        alert('Product added to cart!');
    } else {
        console.error('Unexpected server response:', response);
    }
},
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        },
        complete: function() {
            console.log('AJAX request completed');
        }
    });
});
</script>