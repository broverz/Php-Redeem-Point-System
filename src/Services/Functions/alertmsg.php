<?php
    function alertmsg($type, $title, $msg = '')
    {
        if ($type == 'sww') {
            $_SESSION['alerts'] = "<script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '$title',
                text: '$msg',
                showConfirmButton: false,
                timer: 1500,
                showClass: {
                    popup: 'animate__animated animate__bounceInRight '
                },
                hideClass: {
                    popup: 'animate__animated animate__bounceOutRight'
                }
            });
            </script>";
        } elseif ($type == 'err') {
            $_SESSION['alerts'] = "<script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: '$title',
                text: '$msg',
                showConfirmButton: false,
                timer: 1500,
                showClass: {
                    popup: 'animate__animated animate__bounceInRight '
                },
                hideClass: {
                    popup: 'animate__animated animate__bounceOutRight'
                }
            });
            </script>";
        } elseif ($type == 'if') {
            $_SESSION['alerts'] = "<script>
            Swal.fire({
                position: 'top-end',
                icon: 'info',
                title: '$title',
                text: '$msg',
                showConfirmButton: false,
                timer: 1500,
                showClass: {
                    popup: 'animate__animated animate__bounceInRight '
                },
                hideClass: {
                    popup: 'animate__animated animate__bounceOutRight'
                }
            });
            </script>";
        } elseif ($type == 'q') {
            $_SESSION['alerts'] = "<script>
            Swal.fire({
                position: 'top-end',
                icon: 'question',
                title: '$title',
                text: '$msg',
                showConfirmButton: false,
                timer: 1500,
                showClass: {
                    popup: 'animate__animated animate__bounceInRight '
                },
                hideClass: {
                    popup: 'animate__animated animate__bounceOutRight'
                }
            });
            </script>";
        }
    }
?>