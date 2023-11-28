<!-- Kategori præsentationssektion -->

<div class="container">
    <!-- Række af kategorikort -->
    <div class="row">
        <?php foreach ($categories as $category): ?>
            <!-- Kategorikortkolonne med bootstrap grid-system -->
            <div class="col-md-4 mb-3">
                <!-- Kategorikort med mørk kant og baggrundsfarve -->
                <div class="card border-dark" style="background-color: #333; width: 100%;">
                    <!-- Kategorikortets indhold med lys tekstfarve -->
                    <div class="card-body text-light">
                        <!-- Overskrift for kategorinavnet -->
                        <h5 class="card-title"><?= $category->kategori_navn; ?></h5>
                        
                        <!-- Link til siden der viser alle produkter for den aktuelle kategori -->
                        <a href="category_products/<?= $category->kategori_id; ?>">
                            Se alle produkter
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
