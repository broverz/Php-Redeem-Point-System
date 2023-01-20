<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Yosiket</title>
</head>

<body>
    <?php
    if (isset($_SESSION['alerts'])) :
        echo ($_SESSION['alerts']);
        unset($_SESSION['alerts']);
    endif;
    ?>

    <div class="container py-5">
        <main>
            <?php if ($_SESSION['userlogin']) : ?>
                <h1 class="text-center"><?= $plr['username'] ?></h1>
                <div class="d-grid gap-2 col-2 mx-auto">
                    <a href="/?page=redeem" class="btn btn-outline-info">Redeem</a>
                    <a href="/?page=logout" class="btn btn-outline-danger">Logout</a>
                </div>
            <?php else : ?>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <a href="/?page=login" class="btn btn-outline-success">Signin</a>
                    <a href="/?page=register" class="btn btn-outline-danger">Signup</a>
                </div>
            <?php endif ?>
        </main>
    </div>

</body>

</html>