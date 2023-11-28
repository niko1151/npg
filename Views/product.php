<div class="container">
    <div class="row">
        <!-- Iteration gennem hver produkt i $Product arrayet -->
        <?php foreach($Product as $product): ?>
            <!-- Kolonne med bredde md-4 og margin-bottom 3 -->
            <div class="col-md-4 mb-3">
                <!-- Kort med border-dark og baggrundsfarve #333, bredde 100% -->
                <div class="card border-dark" style="background-color: #333; width: 100%;">
                    <!-- Bestem billedstien baseret på om produktet har en billed-URL eller brug standardbilledet -->
                    <?php
                        $imagePath = isset($product->billede_url) && !empty($product->billede_url)
                            ? "../npg/images/" . $product->billede_url
                            : '../npg/images/NPGaming.png';
                    ?>
                    <!-- Billedsektion med margin og polstring -->
                    <div style="margin: 5px; padding: 10px; box-sizing: border-box;">
                        <!-- Billede tag med dynamisk kilde, bredde 100%, højde 450px, objekt-fit dækker området -->
                        <img src="<?= $imagePath; ?>" class="card-img-top" alt="Produktbillede" style="width: 100%; height: 450px; object-fit: cover;">
                    </div>
                    <!-- Kortets krop med tekstfarve hvid -->
                    <div class="card-body text-light">
                        <!-- Overskrift med produktets navn -->
                        <h5 class="card-title"><?= $product->produkt_navn; ?></h5>
                        <!-- Tekst med prisen i formatet 0,00 DKK -->
                        <p class="card-text"><strong>Pris:</strong> <?= number_format($product->pris, 2); ?> DKK</p>
                        <!-- Tekst med kategorinavn -->
                        <p class="card-text"><strong>Kategori:</strong> <?= $product->kategori_navn; ?></p>
                        <!-- Knap til detaljeret visning af produkt -->
                        <a href="product_details/<?= $product->produkt_id; ?>" class="btn btn-info btn-sm">
                            Vis Detaljer
                        </a>
                        <!-- Knap til at tilføje produktet til kurven -->
                        <button class="btn btn-primary btn-sm add-to-cart" data-product-id="<?= $product->produkt_id; ?>">
                            Tilføj til kurv
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal for visning af produktbeskrivelse -->
<div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modalhoved med titel og lukkeknap -->
            <div class="modal-header">
                <h5 class="modal-title" id="descriptionModalLabel">Produkt Beskrivelse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modalindhold uden initial beskrivelse -->
            <div class="modal-body" id="descriptionContent"></div>
        </div>
    </div>
</div>

<!-- JavaScript til håndtering af visning af beskrivelse og tilføjelse til kurv -->
<script>
    // Vent på at DOM'en er indlæst
    document.addEventListener('DOMContentLoaded', function () {
        // Lyt efter klik på knapper med klassen 'view-description'
        document.querySelectorAll('.view-description').forEach(function (button) {
            button.addEventListener('click', function () {
                // Hent beskrivelse fra knappens data-attribut og vis i modal
                var description = this.getAttribute('data-description');
                document.getElementById('descriptionContent').innerText = description;
                $('#descriptionModal').modal('show');
            });
        });

        // Lytter efter klik på knapper med klassen 'add-to-cart'
        document.querySelectorAll('.add-to-cart').forEach(function (button) {
            button.addEventListener('click', function () {
                // Henter produktets ID fra knappens data-attribut
                var productId = this.getAttribute('data-product-id');
                alert('Produktet med ID ' + productId + ' blev tilføjet til kurven!');
            });
        });
    });
</script>