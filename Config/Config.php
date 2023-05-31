<?php 
	
	const BASE_URL = "http://localhost/prueba_ofertas_suplos";

	//Zona horaria
	date_default_timezone_set("America/Bogota");

	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "db_ofertasClientes";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_PORT = "3306";
	const DB_CHARSET = "utf8";

	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbolo de moneda
	const SMONEY = "COP";

	//Datos envio de correo
	const NOMBRE_REMITENTE = "SUPLOS";
	const EMAIL_REMITENTE = "no-reply@abelosh.com";
	const NOMBRE_EMPRESA = "SUPLOS";
	const WEB_EMPRESA = "www.suplos.com";
	
	//Variables de encryptar y desencryptar
	const METHOD = "AES-256-CBC";
	const SECRET_KEY = "sanditor@2016";
	const SECRET_IV = "101712";	


	


 ?>