<div class="container">
    <div class="row">
        <?php foreach($categoryProducts as $product): ?>
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
                        <p class="card-text"><strong>Kategori:</strong> <?= $product->kategori_navn; ?></p>
                        <!-- Ny knap til detaljeret visning -->
                        <a href="<?= getenv('BASE_URL')?>/product_details/<?= $product->produkt_id; ?>" class="btn btn-info btn-sm">
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
<!-- Modals eller andet indhold kan tilføjes efter behov -->