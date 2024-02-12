</main>
<footer class="py-3 my-4 footer">
    <div class="waves">
        <div class="wave z-0 opacity-100" id="wave1"></div>
        <div class="wave z-1 opacity-50" id="wave2"></div>
        <div class="wave z-2 opacity-25" id="wave3"></div>
        <div class="wave z-3 opacity-75" id="wave4"></div>
    </div>

    <?php require_once dirname(dirname(__DIR__)) . '/utilities/nav/footer_nav.ut.php'; ?>

    <p class="text-center text-white">
        <!-- La fonction PHP Date est utilisé pour afficher l’année en cours en PHP. Y = Année -->
        Copyright <?= date('Y') ?> Tous droits réservés.
    </p>

</footer>
</body>

</html>