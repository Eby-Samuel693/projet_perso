<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Pages/_partials/head.php';
?>

<div class="containerMenu container">
    <ul id="clickListe">
        <li class="listMenu">
            <a title="Page article" href="article.php"><i class="fas fa-external-link-alt"></i> Article</a>
        </li>
        <li class="listMenu">
            <a title="Page Video" href="video.php"><i class="fas fa-play"></i> Vidéo</a>
        </li>
        <li class="listMenu">
            <a title="Page Galerie" href="galerie.php"><i class="fas fa-folder"></i> Galerie</a>
        </li>

    </ul>
</div>

<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Pages/_partials/footer.php';
?>
