<?php
include_once 'function.php';
$pdo = connect();
if (isset($_GET['pag'])) {
    $pag = $_GET['pag'];
} else {
    $pag = 1;
}
$no_page = 3;
$offset = ($pag-1) * $no_page;

$total_rows = $pdo->query("SELECT COUNT(*) as count FROM posts")->fetchColumn();
$total_pages = ceil($total_rows / $no_page);

$ps=$pdo->query('select p.id, p.postTitle, p.postText, p.imagePath, p.datePost, c.categoryName from posts p, categories c WHERE p.categoryId=c.id LIMIT '.$offset.', '.$no_page);
$ps->setFetchMode(PDO::FETCH_OBJ);
?>

<h1 class="my-4">Page Heading
    <small>Secondary Text</small>
</h1>

<?php while ($row=$ps->fetch()):?>
    <!-- Blog Post -->
    <div class="card mb-4">
        <img class="card-img-top" src="images/<?=$row->imagePath?>" alt="<?=$row->imagePath?>Card image cap">
        <div class="card-body">
            <h2 class="card-title"><?=$row->postTitle?></h2>
            <p class="card-text"><?=$row->postText?></p>
            <a href="index.php?post=<?=$row->id?>" class="btn btn-primary">Read More &rarr;</a>
        </div>
        <div class="card-footer text-muted">
            Posted on <?=$row->datePost?> by
            <a href="#">Start <?=$row->categoryName?></a>
        </div>
    </div>

<?php endwhile;?>

<!-- Pagination -->
<ul class="pagination justify-content-center mb-4">
    <li class="page-item <?php if($pag <= 1){ echo 'disabled'; } ?>">
<!--        <a class="page-link" href="#">&larr; Older</a>-->
        <a class="page-link" href="<?php if($pag <= 1){ echo '#'; } else { echo "index.php?page=1&pag=".($pag - 1); } ?>">&larr; Older</a>
    </li>
    <li class="page-item <?php if($pag >= $total_pages){ echo 'disabled'; } ?>">
<!--        <a class="page-link" href="#">Newer &rarr;</a>-->
        <a class="page-link" href="<?php if($pag >= $total_pages){ echo '#'; } else { echo "index.php?page=1&pag=".($pag + 1); } ?>">Newer &rarr;</a>
    </li>
</ul>
