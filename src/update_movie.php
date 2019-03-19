<?php
/**
 * Created by PhpStorm.
 * User: regin
 * Date: 02.01.2018
 * Time: 15:16
 */

if (isset($_POST['save'])) {

    $moviename1 = $_POST['titel_1'];
    $moviename2 = $_POST['titel_2'];
    $movieyear = $_POST['jahr'];
    $genre = $_POST['genre'];
    $mov_id = $_POST['mov_id'];

    $bindArray = [
            0 => $moviename1,
            1 => $moviename2,
            2 => $movieyear,
            3 => $genre,
            4 => $mov_id
         ];

    $query = 'update movie set  move_title_1 = ?,
                                move_title_2 = ?,
                                mov_year = ?,
                                gen_id = ?
              where mov_id = ?';

    $query_show = ' select 
                    gen_name as "Genre",
                    move_title_1 as "Filmtitel",
                    move_title_2 as "Verleihtitel",
                    mov_year as "Jahr"
                    from movie
                    left join genre using(gen_id)
                    where mov_id = ?;
              ';

    try {

        $stmt = $con->getStatement($query, $bindArray);

        $bindArray_show = [
            0 => $mov_id
        ];

        $stmt1 = $con->getStatement($query_show, $bindArray_show);

?>
        <div class="row">
            <div class="four columns">
                <h4>Ihre Änderungen wurden gespeichert</h4>
            </div>
            <div class="seven columns">
            <div class="movielist">
  <?php
        $con->ShowTable($stmt1);
        ?>
            </div>
            </div>
        </div>

        <?php
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else if (isset($_POST['select'])) {

    $movie = explode(",", $_POST["movie"]);
    $mov_id = $movie[0];
    $moviename1 = $movie[1];
    $moviename2 = $movie[2];
    $movieyear = $movie[3];
    $genre = $movie[4];

    $query_genre = 'select gen_id, gen_name from genre';

    try {

        $stmt_genre = $con->GetStatement($query_genre);


        ?>
        <form method="POST">
            <div class="row">
                <div class="four columns">
                    <h4>Bitte die gewünschten Einträge ändern.</h4>
                </div>
                <div class="seven columns">
                    <div class="updatemovie">
                        <div class="form-group">
                            <input type="hidden" name="mov_id" class="mytext" value="<?php echo $mov_id?>"><br>
                            <label class="control-label col-md-3" for="titel_1">Filmtitel:</label>
                            <input type="text" name="titel_1" id="titel_1" class="mytext" value="<?php echo $moviename1?>"><br>
                            <label class="control-label col-md-3" for="titel_2">Verleihtitel:</label>
                            <input type="text" name="titel_2" id="titel_2" class="mytext" value="<?php echo $moviename2?>"><br>
                            <label class="control-label col-md-3" for="jahr">Erscheinungsjahr:</label>
                            <input type="number" name="jahr" id="jahr" value="<?php echo $movieyear?>" min="1900" max="9999"><br>
                            <label class="control-label col-md-3" for="genre">Genre:</label>
                            <?php

                            while ($row = $stmt_genre->fetch(PDO::FETCH_NUM)) {
                                if ($row[0] == $genre) {
                                    echo '<input type="radio" name="genre" value="' . $row[0] . '" checked="checked"> ' . $row[1] . '<br>';
                                }
                                echo '<input type="radio" name="genre" value="' . $row[0] . '"> ' . $row[1] . '<br>';
                            }
                            ?>
                            <input class="control-label col-md-3" type="submit" name="save" value="Änderungen speichern" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php

    } catch (Exception $e) {
        echo $e->getMessage();
    }

} else {
    $query = 'select 
              mov_id,
              move_title_1,
              move_title_2,
              mov_year,
              gen_id
              from movie
              left join genre using(gen_id);';

    try {

        $movies = $con->GetStatement($query);

        //$con->ShowTable($stmt);

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    ?>

    <form method="POST">
        <div class="row">
            <div class="four columns">
                <h4>Wählen Sie den Film, den Sie ändern möchten</h4>
            </div>
            <div class="seven columns">
                <div class="movieselect">
                    <select name="movie">
                        <?php

                        while ($row = $movies->fetch(PDO::FETCH_NUM)) {
                            echo '<option value="' . $row[0] .','.$row[1] .','. $row[2]. ','. $row[3].','. $row[4].'">' . $row[1] . ' ' . $row[2] .'  ' . $row[3] . '</option>';
                        }
                        ?>
                    </select>
                    <input class="control-label col-md-3" type="submit" name="select" value="auswählen"/>
                </div>
            </div>
        </div>
    </form>

    <?php

}
