<!-- Section Médecins titre + cards -->
<section>
        <div class="row row-cols-1 row-cols-xs-2 row-cols-lg-2 row-cols-xl-4 row-gap-4">

            <?php
            // La requête SQL est stockée dans la variable $doctorsQuery puis est passé en paramètre dans la fonction displayCards.
            $doctorsQuery = "SELECT doctors.* FROM doctors";
            $doctors = findAllDatas($db, $doctorsQuery);

            foreach ($doctors as $doctor) :
            ?>
                <div class="col">
                    <div class="card h-100 text-center rounded-0">
                        <img src="<?= DOCTORS_IMG_PATH . $doctor['doctor_pathimg'] ?>" class="card-img-top rounded-0" alt="<?= $doctor['doctor_name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $doctor['doctor_name'] ?></h5>
                            <p class="card-text"><?= $doctor['doctor_description'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
</section>