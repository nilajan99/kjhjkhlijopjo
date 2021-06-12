<?php
include('connection.php');
include('function.php');
$sql="SELECT * FROM student ORDER BY id DESC ";
$res=mysqli_query($conn,$sql);
$html=' <table>

<thead>
  <tr>
    <th>No</th>
    <th>Order Id</th>
    <!-- <th>Product</th> -->
    <th>Customer</th>
    <th>Quantity</th>
    <th>Total Amount</th>
    <th>Order Date</th>
    <th>Status</th>
    <th>Shipping</th>
    <th>Delivery</th>
    <!-- <th>Shipping Date</th>
    <th>Delivery Date</th>
    <th>invoice_no</th> -->
  </tr>
</thead>
<tbody>';
$i=1;
while($fetch=mysqli_fetch_assoc($res)){
	$html.='<tr><td>'.$i++.'</td><td>'.$fetch['orderid'].'</td><td>'.ucwords(getCustomer($conn,$fetch['customerid'],"name")).'</td><td>'.$fetch['quantity'].'</td><td>'.$fetch['total'].'</td><td>'.$fetch['status_date']/*$date=date_create($fetch['status_date'])
    date_format($date,"d-m-Y")*/.'</td><td>'.
   getStatus($fetch['status'])
    .'</td><td>'.
    getOtherStatus($fetch['shipping_status'])
    .'</td><td>'.
    getDelStatus($fetch['delstatus'])
    .'</td></tr>';
}
$html.='</tbody></table>';
header('Content-Type:application/xls');
header('Content-Disposition:attachment;filename=report.xls');
echo $html;

function getStatus($status){
    if ($status=="I") { 
        return "pending";
    }else{
        if ($status=="C") {
            return "cancel";
        }else {
            return "Confirm";
        }
    }
}

function getOtherStatus($status){
if ($status=="I") {
    return "pending";
}else {
    return "Shipped";
    //$status['status_date'];date=date_create($fetch['status_date'])
    //date_format($date,"d-m-Y")
}
}
function getDelStatus($status){
    if ($status=="I") {
        return "pending";
    }else {
        return "Delivered";
        //$status['status_date'];date=date_create($fetch['status_date'])
        //date_format($date,"d-m-Y")
    } 
}
/*
<?php
include "../authentication.php";

ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 3000);

$user_id=getUser_id($_REQUEST["token"],"user_id");
if ($user_id) {

    include "../dbconnect.php";

    $id=$user_id;
    // print_r($data);
    // $rand=rand(10000,99999);
    echo $tmp_img=$_FILES['image']['name'];
    
    if (empty($_REQUEST['name']) || empty($_REQUEST['phone']) || empty($_REQUEST['email']) || empty($_REQUEST['dob']) || empty($_REQUEST['address']) || empty($_REQUEST['gender'])) {
        echo '{"message": "Name.Phone,Email,DOB,Address,Gender are required"}';
    }else {
            
        $name=mysqli_escape_string($conn,$_REQUEST["name"]);
        $phone=mysqli_escape_string($conn,$_REQUEST["phone"]);
        $email=strtolower(mysqli_escape_string($conn,$_REQUEST["email"]));
        $dob=mysqli_escape_string($conn,$_REQUEST["dob"]);
        $address=mysqli_escape_string($conn,$_REQUEST["address"]);
        $gender=mysqli_escape_string($conn,$_REQUEST["gender"]);

        if (isset($id) && $id!='') {
            if (isset($tmp_img) && $tmp_img!="") {
                $allowed_types = array('jpg', 'png', 'jpeg');
                $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                if(!in_array(strtolower($file_ext), $allowed_types)) {
                    echo '{"message": "File must be jpg,jpeg and png format","statusCode":"F"}';die();
                }
                $image=time()."-".basename($_FILES['image']['name']);
                // $target_path = "../FileUpload/uploads/";
                $target_path = "../../user_image/";

                $target_path = $target_path .$image;
                // $image = basename($_FILES['image']['name']);
                $img=findImg($id);

                if ($img) {
                    unlink("../../user_image/".$img);
                }
                move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
                // copy($_FILES['file']['tmp_name'],"../../user_image/".$image);

                $sql = "UPDATE `riaaya_user` SET `name`='$name',`email`='$email',`phone`='$phone',  `dob`='$dob',`address`='$address',`gender`='$gender',`file`='$image'   WHERE `id`='$id'";
                if(mysqli_query($conn, $sql)){
                    $sql="SELECT * FROM `riaaya_user` WHERE `id`=$id";
                    $res=mysqli_query($conn,$sql);
                    $fetch = mysqli_fetch_assoc($res);
                    
                    $result = ['message'=>"Update Succesfully", 'statusCode'=>'S', 'userdata'=>$fetch];
                    echo json_encode($result);
                }else {
                    echo '{"message": "not updated","status":"F"}';    
                }
            }else {
                $sql = "UPDATE `riaaya_user` SET `name`='$name',`email`='$email',`phone`='$phone',  `dob`='$dob',`address`='$address',`gender`='$gender' WHERE `id`='$id'";
                if(mysqli_query($conn, $sql)){

                    $sql="SELECT * FROM `riaaya_user` WHERE `id`=$id";
                    $res=mysqli_query($conn,$sql);
                    $fetch = mysqli_fetch_assoc($res);
                    $result = ['message'=>"Update Succesfully", 'statusCode'=>'S', 'userdata'=>$fetch];
                    echo json_encode($result);

                }else {
                    echo '{"message": "not updated","statusCode":"F"}';    
                }   
            }
        
        } else {
            echo '{"message": "id not found","statusCode":"F"}';
        }
    }
}
function findImg($id){
    include "../dbconnect.php";

    $sql = "SELECT * FROM `riaaya_user` WHERE `id`=$id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
        return $row['file'];
    } else{
        return false;
    }
}

*/
?>
