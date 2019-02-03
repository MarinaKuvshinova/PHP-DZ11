<?php
include_once 'function.php';
$pdo = connect();
$idP = $_GET['post'];
$ps=$pdo->query('select p.id, p.postTitle, p.postText, p.imagePath, p.datePost, c.categoryName from posts p, categories c WHERE p.categoryId=c.id AND p.id='.$idP);
$ps->setFetchMode(PDO::FETCH_OBJ);
$row = $ps->fetch();

if(isset($_POST['addComment']))
{
    $commentText=trim(htmlspecialchars($_POST['commentText']));
    $commentAuthor=trim(htmlspecialchars($_POST['commentAuthor']));

    if (empty($commentAuthor)||empty($commentText))
    {
        echo "FUCK ASS!!!!";
        return false;
    }


    $data = [
        commentText => $commentText,
        commentAuthor => $commentAuthor,
        postId => $idP
    ];
    $sql = "INSERT INTO comments (commentText, commentAuthor, postId) VALUES (?,?,?)";
    $pdo->prepare($sql)->execute(array_values($data));
}


$pc=$pdo->query('select * from comments WHERE postId='.$idP);
$pc->setFetchMode(PDO::FETCH_OBJ);




?>
<!-- Title -->
<h1 class="mt-4"> <?=$row->id?></h1>

<!-- Author -->
<p class="lead">
    by
    <a href="#">Start <?=$row->categoryName?></a>
</p>

<hr>

<!-- Date/Time -->
<p>Posted on <?=$row->datePost?></p>

<hr>

<!-- Preview Image -->
<img class="img-fluid rounded" src="images/<?=$row->imagePath?>" alt="">

<hr>

<!-- Post Content -->
<p><?=$row->postText?><p>
<hr>

<!-- Comments Form -->
<div class="card my-4">
    <h5 class="card-header">Leave a Comment:</h5>
    <div class="card-body">
        <form action="index.php?post=<?=$row->id?>" method="post"'>
            <div class="form-group">
                <label for="commentAuthor">Name</label>
                <input type="text" class="form-control" id="commentAuthor" name="commentAuthor" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label for="commentText">Text</label>
                <textarea type="text" class="form-control" id="commentText" name="commentText" placeholder="Text" required></textarea>
            </div>
            <button type="submit" name="addComment" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>


<?php while ($r=$pc->fetch()):?>
    <!-- Single Comment -->
    <div class="media mb-4">
        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
        <div class="media-body">
            <h5 class="mt-0"><?=$r->commentAuthor?></h5>
            <?=$r->commentText?>
        </div>
    </div>
<?php endwhile;?>

