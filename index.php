<?php require_once __DIR__ . '/utilities/layout/header.ut.php'; ?>

<div class="container py-4">
    <!-- Section générique titre + paragraphe -->
    <?php displaySection($db, 'home'); ?>

    <?php require_once __DIR__ . '/utilities/card/doctors_card.ut.php'; ?>
</div>

<?php require_once __DIR__ . '/utilities/layout/footer.ut.php'; ?>
