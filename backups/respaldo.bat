@echo off
rem Obtener la fecha en formato YYYY-MM-DD
set anio=%date:~6,4%
set mes=%date:~3,2%
set dia=%date:~0,2%

rem Obtener la hora en formato HH-MM (suponiendo formato 24 horas)
set hora=%time:~0,2%
set minuto=%time:~3,2%

rem Eliminar espacios de la hora si es menor a 10
if "%hora:~0,1%"==" " set hora=0%hora:~1,1%
if "%minuto:~0,1%"==" " set minuto=0%minuto:~1,1%

rem Crear el nombre del archivo con fecha y hora en formato YYYY-MM-DD_HH-MM
set nombre=FAST_%anio%-%mes%-%dia%_%hora%-%minuto%.sql

rem Ejecutar el volcado de la base de datos
mysqldump -u admin test_fast5 > D:\xampp\htdocs\FAST-PROJECT\backups\%nombre%

rem en caso de tener contraseña para el usuario
rem se coloca asi mysqldump -u admin -p'mypassword' test_fast5 > D:\xampp\htdocs\FAST-PROJECT\backups\backup.sql
