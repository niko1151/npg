<div class="container">
    <!-- Række af produktkort -->
    <div class="row">
        <?php foreach($categoryProducts as $product): ?>
            <!-- Produktkolonne med bootstrap grid-system -->
            <div class="col-md-4 mb-3">
                <!-- Produktkort med mørk kant og baggrundsfarve -->
                <div class="card border-dark" style="background-color: #333; width: 100%;">
                    <!-- Billedhåndtering: Henter billedet fra databasen, ellers bruger den standardbillede -->
                    <?php
                        $imagePath = isset($product->billede_url) && !empty($product->billede_url)
                            ? "../npg/images/" . $product->billede_url
                            : '../npg/images/NPGaming.png';
                    ?>
                    <!-- Indholdsboks med margin og polstring -->
                    <div style="margin: 5px; padding: 10px; box-sizing: border-box;">
                        <!-- Produktbillede med responsiv tilpasning -->
                        <img src="<?= $imagePath; ?>" class="card-img-top" alt="Product Image" style="width: 100%; height: 450px; object-fit: cover;">
                    </div>
                    <!-- Kortets indhold med lys tekstfarve -->
                    <div class="card-body text-light">
                        <!-- Overskrift for produktets navn -->
                        <h5 class="card-title"><?= $product->produkt_navn; ?></h5>
                        <!-- Pris- og kategoritekst -->
                        <p class="card-text"><strong>Pris:</strong> <?= number_format($product->pris, 2); ?> DKK</p>
                        <p class="card-text"><strong>Kategori:</strong> <?= $product->kategori_navn; ?></p>
                        <!-- Hvis der bliver trykket på vis detaljer så kalder den på /product_details/ -->
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