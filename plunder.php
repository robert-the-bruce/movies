<form method="post">
    <div class="form-group">
        <label class="control-label col-md-3" for="titel">Titel des Stücks:</label><input type="text" name="titel"
                                                                                          id="titel" required><br>
        <label class="control-label col-md-3" for="autor">Autor</label>
        <select name="autor">
            <?php

            while ($row = $stmt_rolle->fetch(PDO::FETCH_NUM)) {
                echo '<option value="' . $row[0] . '">' . $row[2] . '</option>';
            }
            ?>
        </select>
        <label class="control-label col-md-3" for="genre">Genre:</label>
        <select name="genre">
            <?php

            while ($row = $stmt_genre->fetch(PDO::FETCH_NUM)) {
                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
            ?>
        </select>

        <label class="control-label col-md-3" for="datum">Erstaufführung:</label><input type="date" min="1900-01-01"
                                                                                        name="datum" id="datum"
                                                                                        required><br>

        <input class="control-label col-md-3" type="submit" name="speichern" value="speichern"/>
    </div>
</form>