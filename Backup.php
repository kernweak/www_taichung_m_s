<?php
//MFST_Backup


$DBfilename='MFST_DB_Backup_'.date('Y-m-d').'.zip';
$ImgFilename='MFST_IMG_Backup_'.date('Y-m-d').'.zip';
$OutTemp_Path = "D:\MFST_Backup\TEMP";
$Out_Path = "D:\MFST_Backup\ZIP\\";
$Img_Path = "D:\wamp\www_taichung_m_s_88\uploads\*.*";
//system( "rmdir ".$OutTemp_Path);
//system( "mkdir ".$OutTemp_Path);
//echo $filename."<br>";

//$CC = "D:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump military_family_support_taichung --password=123456 --user=root --single-transaction > ";
//帳號密碼改成寫入my.ini
// [mysqldump]
// user=your_backup_user_name
// password=your_backup_password

// 修改完配置文件后, 只需要执行mysqldump 脚本就可以了。备份脚本中不需要涉及用户名密码相关信息。
$CC = "D:\wamp\bin\mysql\mysql5.6.17\bin\mysqldump military_family_support_taichung --single-transaction > ";

system($CC.$OutTemp_Path."\MFST_DB_Backup.sql");
//sleep(10);//最後上線前改成30秒
system("D:\wamp\www_taichung_m_s_88\\7-zip\\7z-x64.exe a -tzip ".$Out_Path.$DBfilename." -pJRdgYeXjYsR259D7226G ".$OutTemp_Path."\MFST_DB_Backup.sql");
system("D:\wamp\www_taichung_m_s_88\\7-zip\\7z-x64.exe a -tzip ".$Out_Path.$ImgFilename." -pJRdgYeXjYsR259D7226G ".$Img_Path);


$date = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
$date->modify('-8 day');
//echo $date->format('Y-m-d');

$DBfileDel='MFST_DB_Backup_'.$date->format('Y-m-d').'.zip';
$ImgFileDel='MFST_IMG_Backup_'.$date->format('Y-m-d').'.zip';

system("del ".$Out_Path.$DBfileDel);
system("del ".$Out_Path.$ImgFileDel);

//sleep(10);//最後上線前改成180秒









//D:\wamp\www_taichung_m_s_88>D:\wamp\www_taichung_m_s_88\7-zip\7z-x64 a -tzip D:\MFST_Backup\TEMP\MFST_Backup.zip D:\MFST_Backup\TEMP\MFST_Backup.sql


//return;

//echo $CC."<br>";


//$result = exec($CC,$output);
//system("mkdir D:\\wamp\\bin\\mysql\\mysql5.6.17\\bin\\CC");
//system( $CC.$output_path.$filename);







?>