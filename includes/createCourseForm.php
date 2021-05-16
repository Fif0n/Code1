<?php
    if(!isset($_SESSION['username'])){
        header("Location: /Code1/home");
    }
?>
<section>
    <div class="create-course-container">
        <h1>Stwórz kurs</h1>
        <form>
            <label for="course-name">Nazwa kursu:</label>
            <input type="text" id="course-name" name="course-name">
            <label for="course-description">Opis kursu:</label>
            <textarea id="course-description" cols="30" rows="10" name="course-description"></textarea>
            <label for="course-miniature">Miniaturka kursu:</label>
            <input type="file" id="course-miniature" name="course-miniature">
            <label for="course-video">Plik wideo:</label>
            <input type="file" id="course-video" name="course-video">
            <label for="tags">Tagi (wprowadzaj po przecinku):</label>
            <input type="text" id="tags" name="tags">
            <label for="prize">Cena (zł):</label>
            <input type="number" id="prize" name="prize">
            <button type="submit" id="create-course-submit" name="create-course-submit">Opublikuj kurs</button>
            <ul id="create-course-error-message">
                
            </ul>
            <ul id="create-course-success-message">
            
            </ul>
        </form>
    </div>
</section>