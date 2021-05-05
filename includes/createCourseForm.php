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
            <input type="text" id="course-name">
            <label for="course-description">Opis kursu:</label>
            <textarea id="course-description" cols="30" rows="10"></textarea>
            <label for="course-miniature">Miniaturka kursu:</label>
            <input type="file" id="course-miniature">
            <label for="course-video">Plik wideo:</label>
            <input type="file" id="course-video">
            <label for="tags">Tagi:</label>
            <input type="text" id="tags">
            <label for="prize">Cena (zł):</label>
            <input type="number" id="prize">
            <button type="submit" id="create-course-submit">Opublikuj kurs</button>
        </form>
    </div>
</section>