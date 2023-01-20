<?php
if (isset($_SESSION['userlogin']) || ($_SESSION['adminlogin'])) {
    header('location: ?page=home');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    <style>
        input.mail:invalid {
            background-color: lightpink;
        }
    </style>
</head>

<body onload="">
    <?php
    if (isset($_SESSION['alerts'])) :
        echo ($_SESSION['alerts']);
        unset($_SESSION['alerts']);
    endif
    ?>

    <div class="container py-5">
        <h3 class="text-center mt-4">เข้าสู่ระบบ</h3>
        <hr>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') : ?>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-5">
                        <input type="email" class="form-control mail" name="email" placeholder="name@hotmail.com" multiple>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-5">
                        <input type="password" class="form-control" name="password" placeholder="* * * * * *">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="<?= $sitekeygg ?>"></div>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Sign In</button>
            </form>
        <?php
        else :
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha = $_POST['g-recaptcha-response'];
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretkeygg . '&response=' . $captcha);
                $responseData = json_decode($verifyResponse);

                if (!$captcha) {
                    alertmsg('err', 'คุณยังไม่ได้ reCaptcha!!');
                    header("location: /?page=login");
                }

                if (isset($_POST['login']) && $responseData->success) {
                    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
                    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

                    if (empty($email)) { // กรุณากรอกอีเมล
                        alertmsg('err', 'กรุณากรอกอีเมล์!');
                        header("location: ?page=login");
                    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // รูปแบบอีเมล์ไม่ถูกต้อง
                        alertmsg('err', 'รูปแบบอีเมล์ไม่ถูกต้อง!');
                        header("location: ?page=login");
                    } else if (empty($password)) { // กรุณากรอกรหัสผ่าน
                        alertmsg('err', 'กรุณากรอกรหัสผ่าน!');
                        header("location: ?page=login");
                    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) { // รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร
                        alertmsg('err', 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร!');
                        header("location: ?page=login");
                    } else {
                        try {
                            $check_data = db_q("SELECT * FROM users WHERE email = ?", [$email]);
                            $row = $check_data->fetch(PDO::FETCH_ASSOC);

                            if ($check_data->rowCount() > 0) {
                                if ($email == $row['email']) {
                                    if (password_verify($password, $row['password'])) {
                                        $role = $row['role'];
                                        switch ($role) {
                                            case "admin":
                                                $_SESSION['adminlogin'] = $row['uid'];
                                                alertmsg('sww', 'ยินดีต้อนรับคุณ ' . $row['username'] . '!', 'เข้าสู่ระบบในฐานะ ' . $row['role']);
                                                header("location: ?page=home");
                                                break;
                                            case "user":
                                                $_SESSION['userlogin'] = $row['uid'];
                                                alertmsg('sww', 'ยินดีต้อนรับคุณ ' . $row['username'] . '!', 'เข้าสู่ระบบในฐานะ ' . $row['role']);
                                                header("location: ?page=home");
                                                break;
                                            default:
                                                $_SESSION['userlogin'] = $row['uid'];
                                                alertmsg('sww', 'ยินดีต้อนรับคุณ ' . $row['username'] . '!', 'เข้าสู่ระบบในฐานะ ' . $row['role'] = 'user');
                                                header("location: ?page=home");
                                        }
                                    } else { // รหัสผ่านผิด
                                        alertmsg('err', 'รหัสผ่านผิดพลาด!', 'โปรดลองใหม่อีกครั้ง!');
                                        header("location: ?page=login");
                                    }
                                } else { // อีเมล์ผิด
                                    alertmsg('err', 'อีเมล์ของท่านผิดกรุณาลองใหม่!', 'หรือคุณยังไม่ได้สมัครสมาชิก');
                                    header("location: ?page=login");
                                }
                            } else { // ไม่มีข้อมูลในระบบ
                                alertmsg('q', 'ไม่มีข้อมูลในระบบ!', 'โปรดลองใหม่อีกครั้ง');
                                header("location: ?page=login");
                            }
                        } catch (PDOException $e) {
                            return false;
                        }
                    }
                }
            }
        endif
        ?>
        <hr>
        <p>ยังไม่เป็นสมาชิกใช่ไหม คลิ๊กที่นี่เพื่อ <a href="?page=register">สมัครสมาชิก</a></p>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>