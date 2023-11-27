<?php if (!empty($searchResults)) : ?>
    <ul>
        <?php foreach ($searchResults as $result) : ?>
            <li>
                <a href="<?= getenv('BASE_URL') ?>/product_details/<?= $result->produkt_id ?>">
                    <?= $result->produkt_navn ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php elseif (isset($searchResults) && empty($searchResults)) : ?>
    <p>Ingen resultater fundet.</p>
<?php endif; ?>