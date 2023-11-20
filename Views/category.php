<ul class="list-group m-0">
    <?php foreach($Category as $Category): ?>
        <li class="list-group-item mt-2 border border-dark">
            <?= $Category->kategori_id . " - " . $Category->kategori_navn; ?>
        </li>
    <?php endforeach; ?>
</ul>