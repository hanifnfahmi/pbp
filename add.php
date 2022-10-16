<?php
session_start();
include_once "config.php";
$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
if ( !$connection ) {
    echo mysqli_error( $connection );
    throw new Exception( "Database cannot Connect" );
} else {
    $action = $_REQUEST['action'] ?? '';

    if ( 'addManager' == $action ) {
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $password = $_REQUEST['password'] ?? '';

        if ( $fname && $lname && $lname && $phone && $password ) {
            $hashPassword = password_hash( $password, PASSWORD_BCRYPT );
            $query = "INSERT INTO managers(fname,lname,email,phone,password) VALUES ('{$fname}','$lname','$email','$phone','$hashPassword')";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allManager" );
        }

    } elseif ( 'updateManager' == $action ) {
        $id = $_REQUEST['id'] ?? '';
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';

        if ( $fname && $lname && $lname && $phone ) {
            $query = "UPDATE managers SET fname='{$fname}', lname='{$lname}', email='$email', phone='$phone' WHERE id='{$id}'";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allManager" );
        }
    } elseif ( 'addObat' == $action ) {
        $nama = $_REQUEST['nama_obat'] ?? '';
        $harga = $_REQUEST['harga'] ?? '';
        $stok = $_REQUEST['stok_obat'] ?? '';
        $tgl_kdl = $_REQUEST['tanggal_kadaluarsa'] ?? '';

        if ( $nama && $harga && $stok && $tgl_kdl) {
            $query = "INSERT INTO obat(nama_obat,harga,stok_obat,tanggal_kadaluarsa) VALUES ('$nama','$harga','$stok','$tgl_kdl')";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allObat" );
        }
    } elseif ( 'updateObat' == $action ) {
        $id = $_REQUEST['id'] ?? '';
        $nama = $_REQUEST['nama_obat'] ?? '';
        $harga = $_REQUEST['harga'] ?? '';
        $stok = $_REQUEST['stok_obat'] ?? '';
        $tgl_kdl = $_REQUEST['tanggal_kadaluarsa'] ?? '';

        if ( $nama && $harga && $stok && $tgl_kdl ) {
            $query = "UPDATE obat SET nama_obat='{$nama}', harga='{$harga}', stok_obat='{$stok}', tanggal_kadaluarsa='$tgl_kdl' WHERE id_obat ='{$id}'";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allObat" );
        }
    } elseif ( 'addPharmacist' == $action ) {
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $password = $_REQUEST['password'] ?? '';

        if ( $fname && $lname && $lname && $phone && $password ) {
            $hashPassword = password_hash( $password, PASSWORD_BCRYPT );
            $query = "INSERT INTO pharmacists(fname,lname,email,phone,password) VALUES ('{$fname}','$lname','$email','$phone','$hashPassword')";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allPharmacist" );
        }
    } elseif ( 'updatePharmacist' == $action ) {
        $id = $_REQUEST['id'] ?? '';
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';

        if ( $fname && $lname && $lname && $phone ) {
            $query = "UPDATE pharmacists SET fname='{$fname}', lname='{$lname}', email='$email', phone='$phone' WHERE id='{$id}'";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allPharmacist" );
        }
    } elseif ( 'addSalesman' == $action ) {
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $password = $_REQUEST['password'] ?? '';

        if ( $fname && $lname && $lname && $phone && $password ) {
            $hashPassword = password_hash( $password, PASSWORD_BCRYPT );
            $query = "INSERT INTO salesmans(fname,lname,email,phone,password) VALUES ('{$fname}','$lname','$email','$phone','$hashPassword')";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allSalesman" );
        }
    } elseif ( 'updateSalesman' == $action ) {
        $id = $_REQUEST['id'] ?? '';
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';

        if ( $fname && $lname && $lname && $phone ) {
            $query = "UPDATE salesmans SET fname='{$fname}', lname='{$lname}', email='$email', phone='$phone' WHERE id='{$id}'";
            mysqli_query( $connection, $query );
            header( "location:index.php?id=allSalesman" );
        }
    } elseif ( 'updateProfile' == $action ) {

        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $oldPassword = $_REQUEST['oldPassword'] ?? '';
        $newPassword = $_REQUEST['newPassword'] ?? '';
        $sessionId = $_SESSION['id'] ?? '';
        $sessionRole = $_SESSION['role'] ?? '';
        $avatar = $_FILES['avatar']['name'] ?? "";

        if ( $fname && $lname && $email && $phone && $oldPassword && $newPassword ) {
            $query = "SELECT password,avatar FROM {$sessionRole}s WHERE id='$sessionId'";
            $result = mysqli_query( $connection, $query );

            if ( $data = mysqli_fetch_assoc( $result ) ) {
                $_password = $data['password'];
                $_avatar = $data['avatar'];
                $avatarName = '';
                if ( $_FILES['avatar']['name'] !== "" ) {
                    $allowType = array(
                        'image/png',
                        'image/jpg',
                        'image/jpeg'
                    );
                    if ( in_array( $_FILES['avatar']['type'], $allowType ) !== false ) {
                        $avatarName = $_FILES['avatar']['name'];
                        $avatarTmpName = $_FILES['avatar']['tmp_name'];
                        move_uploaded_file( $avatarTmpName, "assets/img/$avatar" );
                    } else {
                        header( "location:index.php?id=userProfileEdit&avatarError" );
                        return;
                    }
                } else {
                    $avatarName = $_avatar;
                }
                if ( password_verify( $oldPassword, $_password ) ) {
                    $hashPassword = password_hash( $newPassword, PASSWORD_BCRYPT );
                    $updateQuery = "UPDATE {$sessionRole}s SET fname='{$fname}', lname='{$lname}', email='{$email}', phone='{$phone}', password='{$hashPassword}', avatar='{$avatarName}' WHERE id='{$sessionId}'";
                    mysqli_query( $connection, $updateQuery );

                    header( "location:index.php?id=userProfile" );
                }

            }

        } else {
            echo mysqli_error( $connection );
        }

    }

}
