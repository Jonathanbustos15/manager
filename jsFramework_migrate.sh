#!/bin/bash
#Script del framework para poder correr migraciones sql

#para correr un sql por consola seria:
#mysql -u USUARIO -p NOMBRE_DE_LA_DB < NOMBRE_DEL_SCRIPT.sql

#Pedir: usuario_mysql, nombre de la bd y nombre del script

NOM_USER_MYSQL=""
NOM_BD=""
NOM_SCRIPT=""

echo ""
echo "Este script es un asistente para correr migraciones hechas de tipo nombredelscript.sql"
echo ""
echo "Migraciones disponibles:"

ls -l | grep '.sql'

echo ""

echo "Nombre de usuario mysql:"
read NOM_USER_MYSQL

echo "Nombre de la Base de Datos (BD):"
read NOM_BD

echo "Nombre del script (sin .sql):"
read NOM_SCRIPT


function migrar {
	mysql -u $NOM_USER_MYSQL -p $NOM_BD < $NOM_SCRIPT".sql"
}

migrar

