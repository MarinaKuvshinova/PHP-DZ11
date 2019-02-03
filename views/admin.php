<?php
$pdo = connect();

if(isset($_POST['addPost']))
{
    $postTitle=trim(htmlspecialchars($_POST['postTitle']));
    $postText=trim(htmlspecialchars($_POST['postText']));
    $imagePath=trim(htmlspecialchars($_POST['imagePath']));
    $categoryId=$_POST['postCategory'];

    if (empty($postTitle)||empty($postText))
    {
        echo "FUCK ASS!!!!";
        return false;
    }

    foreach ($_FILES['file']['name'] as $k=>$v){
        if($_FILES['file']['error'][$k]!=0){
            continue;
        }
        if(move_uploaded_file($_FILES['file']['tmp_name'][$k],'images/'.$v)){
            $imagePath = $v;
        }
    }

    $data = [
        postTitle => $postTitle,
        postText => $postText,
        imagePath => $imagePath,
        categoryId =>(int)$categoryId
    ];
    $sql = "INSERT INTO posts (postTitle, postText, imagePath, categoryId) VALUES (?,?,?,?)";
    $pdo->prepare($sql)->execute(array_values($data));
}
?>
<h1 class="my-4">Page Admit</h1>
<form action="index.php?page=2" method="post" enctype='multipart/form-data'>
    <div class="form-group">
        <label for="postTitle">Title</label>
        <input type="text" class="form-control" id="postTitle" name="postTitle" placeholder="Title" required>
    </div>
    <div class="form-group">
        <label for="postText">Text</label>
        <textarea type="text" class="form-control" id="postText" name="postText" placeholder="Text" required></textarea>
    </div>
    <div class="form-group">
        <label for="imagePath">Picture</label>
        <input type="file" class="form-control" id="imagePath" name="file[]"  placeholder="Picture">
    </div>
    <div class="form-group">
        <label for="postCategory">Category</label>
        <select name="postCategory" class="form-control" id="postCategory">
            <?php
            $pc=$pdo->query('select * from categories');
            $pc->setFetchMode(PDO::FETCH_OBJ);
            while ($row=$pc->fetch()) {
                if (property_exists($row, 'categoryName'))
                    echo '<option value='.$row->id.'>'.$row->categoryName .'</option>';
            }
            ?>
        </select>
    </div>
    <button type="submit" name="addPost" class="btn btn-primary">Add</button>
</form>

