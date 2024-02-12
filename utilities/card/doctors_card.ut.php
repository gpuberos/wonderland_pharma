<!-- Section Médecins titre + cards -->
<section>
        <div class="row row-cols-1 row-cols-xs-2 row-cols-lg-2 row-cols-xl-4 row-gap-4">

            <?php
            // La requête SQL est stockée dans la variable $doctorsQuery puis est passé en paramètre dans la fonction displayCards.
            $doctorsQuery = "SELECT doctors.*, doctor_pictures.pathImg 
                             FROM `doctors`
                             INNER JOIN doctor_pictures ON doctors.id = doctor_pictures.doctor_id;
                            ";
            $doctors = findAllDatas($db, $doctorsQuery);

            foreach ($doctors as $row) :
            ?>
                <div class="col">
                    <div class="card h-100 text-center rounded-0">
                        <img src="<?= DOCTORS_IMG_PATH . $row['pathImg'] ?>" class="card-img-top rounded-0" alt="<?= $row['doctor_name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['doctor_name'] ?></h5>
                            <p class="card-text"><?= $row['doctor_description'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
</section>