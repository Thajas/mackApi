
Requirements : 
	1.) mod_rewrite must be enable.
	2.) Platform must be Mobile.
	
	
Configurations :
	1.) Set username and password of database in file config/app.php
	2.) Import database : database/dummy.sql
	
	

API's HTTP Method
---------------------------------------------
GET	 : http://localhost/mackApi/classname?action=actionname&param1=abc&param2=xyz
POST 	 : http://localhost/mackApi/





Eample : 


1.) Login API :
**********************************************
In this API 3 parameter is required. 

1.) action : in
2.) username : testone or test@gmail.com
3.) password : testone

GET  : http://localhost/mackApi/login?action=in&username=test@gmail.com&password=testone
POST : http://localhost/mackApi/login

Note : In username you can enter either username or email.


2.)	customerSearch API :
**********************************************
In this API 2 parameter is required. 

1.) action : cus
2.) keyword : royal enfield

GET  : http://localhost/mackApi/customer?action=cus&keyword=royal enfield
POST : http://localhost/mackApi/customer

Note : In keyword you have to enter customer name.



Testing :
**********************************************
1.) If you are using GET Method (Default) then you have to use GET Url's.

2.) If you are using POST Method (Change method from GET to POST in app.php) then you have to use POST url's. 

3.) These API's work if platform is Mobile. 
	if you want to run on Desktop Eg. In CustomerApi.inc file, you have to change device type.
	
	if ($this->detect->getDevice () === 2) // Mobile
	if ($this->detect->getDevice () === 1) // Desktop 