<?php
$fullname = $_POST['fullname']; //هذا الكود الخاص بتعريف مدخل الاسم بالكامل
$email = $_POST['email']; //هذا الكود الخاص بتعريف مدخل البريد الالكتروني
$phone = $_POST['phone']; //هذا الكود الخاص بتعريف مدخل البلد
$subject = $_POST['subject']; //هذا الكود الخاص بتعريف مدخل العنوان
$message = $_POST['message'];//هذا الكود الخاص بتعريف مدخل الرسائل
$send = "arbe55com@gmail.com";//
$msg .="-----بيانات المرسل-----\n";
$msg .="الاسم : : ".$fullname."\n";
$msg .="البريد الالكتروني : : ".$email."\n";
$msg .="رقم الجوال : : ".$phone."\n";
$msg .="عنوان الرسالة : : ".$subject."\n";
$msg .="الرسالة : :".$message."\n"; 
$header = 'www.sooqwatheq.co' . "\r\n";  
mail($send,$subject,$msg,$header);
echo "<center><h3 style='color:red;'>تم ارسال الرسالة بنجاح</h3></center><br><a href='https://sooqwatheq.co/'>الرجوع للصفحة الرئيسية</a>" ;  
?>
