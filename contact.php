<?php require_once __DIR__ . '/utilities/layout/header.ut.php'; ?>

<div class="container py-4 text-white">

    <!-- Section générique titre + paragraphe -->
    <div class="text-center">
        <?php displaySection($db, 'contact'); ?>
    </div>
    
    <?php require_once __DIR__ . '/utilities/form/contact_form.ut.php'; ?>

</div>

<?php require_once __DIR__ . '/utilities/layout/footer.ut.php'; ?>