<?php

include "db.php";
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$sql = "SELECT * FROM api1";
$result = mysqli_query($conn, $sql);
 $html='<h1>Thi s is pdf file</h1>';
if (mysqli_num_rows($result) > 0) {
    $rows=array();
    while ($r = mysqli_fetch_assoc($result)) {
       $html.="<li>".$r['name']."</li>";
       $html.="<li>".$r['email']."</li>";
    }
    
}
echo $html;
?>
<form method="post">
    <input type="text" name="email">
    <input type="submit" value="pdf mail" name="pdf">
</form>
<?php

if ($_POST['pdf']) {
    $email=$_POST['email'];
$file_name=rand().'.pdf';  
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();
$file=$dompdf->output();
file_put_contents($file_name,$file);
// Output the generated PDF to Browser
// $dompdf->stream();




// Recipient 
$to = $email; 
 
// Sender 
$from = 'innoda.nilanjan@gmail.com';
 
// Email subject 
$subject = 'PHP Email with Attachment';  
 
// Attachment file 
$file = $file_name; 
 
// Email body content 
$htmlContent = ' 
    <h3>PHP Email with Attachment</h3> 
    <p>This email is sent from the PHP script with attachment.</p> '; 
 
// Header for sender info  
$headers = "From: example@example.com";
// Boundary  
$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
 
// Headers for attachment  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 
// Multipart boundary  
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  
 
// Preparing attachment 
if(!empty($file) > 0){ 
    if(is_file($file)){ 
        $message .= "--{$mime_boundary}\n"; 
        $fp =    @fopen($file,"rb"); 
        $data =  @fread($fp,filesize($file)); 
 
        @fclose($fp); 
        $data = chunk_split(base64_encode($data)); 
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
        "Content-Description: ".basename($file)."\n" . 
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
    } 
} 
$message .= "--{$mime_boundary}--"; 
$returnpath = "-f" . $from; 
 
// Send email 
$mail = @mail($to, $subject, $message, $headers, $returnpath);  
 
// Email sending status 
echo $mail?"<h1>Email Sent Successfully!</h1>":"<h1>Email sending failed.</h1>"; 
}
