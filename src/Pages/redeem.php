<?php
if (!isset($_SESSION['adminlogin']) && !isset($_SESSION['userlogin'])) {
    header('location: ?page=login');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem - Yosiket</title>
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
            <h1 align="center">Redeem Code Point : <?= $plr['point'] ?></h1>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') : ?>
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter the code here" aria-describedby="button-addon2" name="code">
                        <button type="submit" name="redeem" class="btn btn-outline-info" id="button-addon2">Redeem</button>
                    </div>
                </form>
            <?php
            else :
                if (isset($_POST['redeem'])) {
                    $codeinput = htmlspecialchars($_POST['code'], ENT_QUOTES, 'UTF-8');

                    if ($codeinput != "") {
                        $find = db_q("SELECT * FROM redeemcode WHERE code = ? ", [$codeinput]);
                        $code = $find->fetch(PDO::FETCH_ASSOC);

                        if ($find->rowCount() > 0) {
                            if ($code['count_use'] < $code['max_use']) {
                                $rd_his = db_q("SELECT * FROM redeem_his WHERE code = ? AND uid = ?  ", [$codeinput, $plr['uid']]);
                                if ($rd_his->rowCount() < 1) {
                                    $upt = db_q("UPDATE users SET point = point + ? WHERE uid = ? ", [$code['point'], $plr['uid']]);
                                    $upt2 = db_q("UPDATE redeemcode SET count_use = count_use + 1  WHERE rid = ? ", [$code['rid']]);
                                    $insert = db_q("INSERT INTO redeem_his (code,uid) VALUES (?, ?)", [$code['code'], $plr['uid']]);
                                    if ($insert && $upt && $upt2) {
                                        alertmsg('sww', 'ยินดีด้วย รับรางวัลสำเร็จ!');
                                        header("location: /?page=redeem");
                                    } else {
                                        alertmsg('err', 'ERROR Redeem API เกิดข้อผิดพลาดโปรดติดต่อผู้พัฒนา!');
                                        header("location: /?page=redeem");
                                    }
                                } else {
                                    alertmsg('err', 'คุณกรอกโค้ดนี้ไปแล้ว!');
                                    header("location: /?page=redeem");
                                }
                            } else {
                                alertmsg('err', 'โค้ดนี้มีการใช้งานครบแล้ว โปรดรอติดตามโค้ดใหม่!');
                                header("location: /?page=redeem");
                            }
                        } else {
                            alertmsg('q', 'กรุณาลองใหม่อีกครั้ง โค้ดนี้ไม่มีในระบบ!');
                            header("location: /?page=redeem");
                        }
                    } else {
                        alertmsg('q', 'กรุณาใส่โค้ดด้วย!');
                        header("location: /?page=redeem");
                    }
                }
            endif
            ?>
            <div class="d-grid gap-2 col-2 mx-auto">
                <a href="/?page=home" class="btn btn-outline-warning">Home</a>
                <a href="/?page=logout" class="btn btn-outline-danger">Logout</a>
            </div>
        </main>
    </div>

</body>

</html>