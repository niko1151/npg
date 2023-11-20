<ul class="list-group m-0">
    <?php foreach($Product as $Product): ?>
        <li class="list-group-item mt-2 border border-dark">
            <?= $Product->produkt_id . " - " . $Product->produkt_navn; ?>
        </li>
    <?php endforeach; ?>
</ul>