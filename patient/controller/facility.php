<?php 
// session_start();
require('../../../database_config/thvot/config.inc.php');
require('../config/configuration.php');
require('../config/database.php'); 

$db = new Database();
$conn = $db->conn();

if(!isset($_GET['stage'])){ $db->close(); header('Location: ../404?stage=001'); die(); }
$stage = mysqli_real_escape_string($conn, $_GET['stage']);

if($stage == 'getinfo'){
    
    if(!(isset($_POST['hcode']))){
        $db->close();
        die();
    }

    $hcode = mysqli_real_escape_string($conn, $_POST['hcode']);

    $strSQL = "SELECT * FROM vot2_chospital LEFT JOIN vot2_projecthospital ON vot2_chospital.hoscode = vot2_projecthospital.phoscode 
                WHERE vot2_chospital.hoscode = '$hcode' ORDER BY ID  DESC LIMIT 1";
    $result = $db->fetch($strSQL, false);

    // echo $strSQL;
    if($result){
        echo json_encode($result);
    }else{
        // echo $strSQL;
    }

    $db->close();
    die();
}

if($stage == 'save_project_hosital'){
    if(
        (!(isset($_POST['txtHostpname']))) ||
        (!(isset($_POST['txtLat']))) ||
        (!(isset($_POST['txtLng']))) ||
        (!(isset($_POST['txtHcode']))) ||
        (!(isset($_POST['txtType'])))
    ){
        $db->close();
        $db->close(); header('Location: ../404?error=x101'); die();
        die();
    }

    $hname = mysqli_real_escape_string($conn, $_POST['txtHostpname']);
    $hlat = mysqli_real_escape_string($conn, $_POST['txtLat']);
    $hlng = mysqli_real_escape_string($conn, $_POST['txtLng']);
    $htype = mysqli_real_escape_string($conn, $_POST['txtType']);
    $hmain = mysqli_real_escape_string($conn, $_POST['txtMainhname']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);
    
    $strSQL = "SELECT hosname FROM vot2_chospital WHERE hoscode = '$hmain'";
    $res1 = $db->fetch($strSQL, false);

    $reshname = $res1['hosname'];

    $strSQL = "SELECT a.*, b.Name changwat_name, c.Name ampur_name, d.Name tumbon_name FROM vot2_chospital a INNER JOIN vot2_changwat b ON a.provcode = b.Changwat
               INNER JOIN vot2_ampur c ON a.provcode = c.Changwat AND a.distcode = c.Ampur
               INNER JOIN vot2_tumbon d ON a.provcode = d.Changwat AND a.distcode = d.Ampur AND a.subdistcode = d.Tumbon
               WHERE a.hoscode = '$hcode'
              ";
    $res = $db->fetch($strSQL, false);
    if($res){
        $strSQL = "INSERT INTO vot2_projecthospital (`phoscode`, `phosstatus`, `hserv`, `hlat`, `hlng`, `hamp`, `htum`, `hospname`, `hospcode`, `htype_code`)
                   VALUES (
                       '$hcode', 'Y', '".$res['hosname']."', '$hlat', '$hlng', '".$res['ampur_name']."', '".$res['tumbon_name']."', '$reshname', '$hmain', '$htype'
                   )
                  ";
        $res_insert = $db->insert($strSQL, false);
        if($res_insert ){
            $db->close();
            header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-facility-add');
            die();
        }else{
            $db->close();
            header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-facility-add?stage=fail');
            die();
        }
    }else{
        $strSQL = "UPDATE vot2_projecthospital SET  
               hserv = '$hname', hlat = '$hlat', hlng = '$hlng', hospname = '$reshname', htype_code = '$htype', hospcode = '$hmain'
               WHERE phoscode = '$hcode'
              ";
        $result = $db->execute($strSQL);
        if($result){
            $db->close();
            header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-facility-add');
            die();
        }else{
            $db->close();
            header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-facility-list?stage=fail');
            die();
        }
    }

}

if($stage == 'update_project_hosital'){
    if(
        (!(isset($_POST['txtHostpname']))) ||
        (!(isset($_POST['txtLat']))) ||
        (!(isset($_POST['txtLng']))) ||
        (!(isset($_POST['txtHcode']))) ||
        (!(isset($_POST['txtType'])))
    ){
        $db->close();
        $db->close(); header('Location: ../404?error=x101'); die();
        die();
    }

    $hname = mysqli_real_escape_string($conn, $_POST['txtHostpname']);
    $hlat = mysqli_real_escape_string($conn, $_POST['txtLat']);
    $hlng = mysqli_real_escape_string($conn, $_POST['txtLng']);
    $htype = mysqli_real_escape_string($conn, $_POST['txtType']);
    $hmain = mysqli_real_escape_string($conn, $_POST['txtMainhname']);
    $hcode = mysqli_real_escape_string($conn, $_POST['txtHcode']);

    $strSQL = "SELECT hosname FROM vot2_chospital WHERE hoscode = '$hmain'";
    $res1 = $db->fetch($strSQL, false);

    $reshname = $res1['hosname'];

    $strSQL = "UPDATE vot2_projecthospital SET  
               hserv = '$hname', hlat = '$hlat', hlng = '$hlng', hospname = '$reshname', htype_code = '$htype', hospcode = '$hmain'
               WHERE phoscode = '$hcode'
              ";
    $result = $db->execute($strSQL);
    // echo  $strSQL;
    // die();
    if($result){
        $db->close();
        header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-facility-list');
        die();
    }else{
        $db->close();
        header('Location: ../core/'.$_SESSION['thvot_role'].'/system/app-facility-list?stage=fail');
        die();
    }
}