<div class="container">
    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-4 mb-3">
                <div class="card border-dark" style="background-color: #333; width: 100%;">
                    <div class="card-body text-light">
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