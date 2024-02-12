<ul class="nav justify-content-center pb-3 mb-3 text-white">
    <?php
    $footerLinks = generateNavLinks($db, 'footernav');
    foreach ($footerLinks as $key => $value) : ?>
        <li class="nav-item">
            <a href="<?= $value['link_url'] ?>" class="nav-link px-2 text-white <?= $value['link_active'] ?>"><?= $value['link_title'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>