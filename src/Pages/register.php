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
    <title>SignUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        input.mail:invalid {
            background-color: lightpink;
        }
    </style>
</head>

<body onload="">
    <?php
    if (isset($_SESSION['alerts'])) :
        echo $_SESSION['alerts'];
        unset($_SESSION['alerts']);
    endif
    ?>

    <div class="container py-5">
        <h3 class="text-center mt-4">สมัครสมาชิก</h3>
        <hr>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') : ?>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Brover">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control mail" name="email" placeholder="name@hotmail.com" multiple>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="* * * * * *">
                    </div>
                    <div class="col">
                        <label for="confirm password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="c_password" placeholder="* * * * * *">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="g-recaptcha" data-sitekey="<?= $sitekeygg ?>"></div>
                </div>
                <button type="submit" name="register" class="btn btn-primary">Sign Up</button>
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
                if (isset($_POST['register'])) {
                    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
                    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
                    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
                    $c_password = htmlspecialchars($_POST['c_password'], ENT_QUOTES, 'UTF-8');


                    if (empty($username)) {
                        alertmsg('err', 'กรุณาใส่ชื่อผู้ใช้ของท่าน');
                        header("location: ?page=register");
                    } else if (empty($email)) {;
                        alertmsg('err', 'กรุณาใส่อีเมล์');
                        header("location: ?page=register");
                    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        alertmsg('err', 'รูปแบบเมลไม่ถูกต้อง');
                        header("location: ?page=register");
                    } else if (empty($password)) {
                        alertmsg('err', 'กรุณากรอกรหัสผ่าน');
                        header("location: ?page=register");
                    } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
                        alertmsg('err', 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร');
                        header("location: ?page=register");
                    } else if (empty($c_password)) {
                        alertmsg('err', 'กรุณายืนยันรหัสผ่าน');
                        header("location: ?page=register");
                    } else if ($password != $c_password) {
                        alertmsg('err', 'รหัสผ่านไม่ตรงกัน');
                        header("location: ?page=register");
                    } else {
                        try {
                            $check_email = db_q("SELECT email FROM users WHERE email = ? LIMIT 1", [$email]);
                            $row = $check_email->fetch(PDO::FETCH_ASSOC);

                            if ($row['email'] == $email) {
                                alertmsg('err', 'มีอีเมลนี้อยู่ในระบบแล้ว');
                                header("location: ?page=register");
                            } else if (!isset($_SESSION['error'])) {
                                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                                $stmt = $conn->prepare("INSERT INTO users(username, email, password)  VALUES(:username, :email, :password)");
                                $stmt->bindParam(":username", $username);
                                $stmt->bindParam(":email", $email);
                                $stmt->bindParam(":password", $passwordHash);
                                $stmt->execute();

                                $ln = db_q("SELECT * FROM users WHERE email = ? AND password = ?", [$email, $passwordHash]);
                                $lrow = $ln->fetch(PDO::FETCH_ASSOC);
                                $_SESSION['userlogin'] = $lrow['uid'];
                                alertmsg('sww', 'สมัครสมาชิกเรียบร้อยแล้ว!');
                                header("location: ?page=home");
                            } else {
                                alertmsg('q', 'มีบางอย่างผิดพลาด!');
                                header("location: ?page=register");
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }
            }
        endif
        ?>
        <hr>
        <p>เป็นสมาชิกแล้วใช่ไหม คลิ๊กที่นี่เพื่อ <a href="?page=login">เข้าสู่ระบบ</a></p>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>