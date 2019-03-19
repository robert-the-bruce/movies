<?php
/**
 * Created by PhpStorm.
 * User: regin
 * Date: 02.01.2018
 * Time: 15:08
 */

?>

<div class="row">
    <div class="four columns">
        <h4>Aktuelle Filmliste</h4>
    </div>
    <div class="seven columns">
        <div class="movielist">
            <?php
            try {
                $query = 'select 
              gen_name as "Genre",
              CONCAT_WS(" ", move_title_1, move_title_2) as "Filmtitel",
              mov_year as "Jahr",
              CONCAT_WS(" ", per_fname, per_secname, per_lname) as "Regie"
              from movie
              left join genre using(gen_id)
              left join movie_director using(mov_id)
              left join person using(per_id)
              group by Filmtitel
              order by Filmtitel;';

                $stmt = $con->GetStatement($query);

                $con->ShowTable($stmt);

            } catch (exception $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>
</div>
