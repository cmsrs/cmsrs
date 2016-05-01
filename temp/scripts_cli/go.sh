#!/bin/bash
cd menu
./delete_all.sh  #comment to test


echo -e "./menu/create.sh $id_m--"
id_m=$(./create.sh)

echo -e "----create_menu_id=$id_m----"

echo -e "./menu/update.sh $id_m"
./update.sh $id_m 

echo  -e ""
echo -e "./menu/get.sh $id_m"
./get.sh $id_m
echo -e "./menu/index.sh"
./index.sh
echo  -e ""



cd ../page

echo -e "./page/create.sh $id_m"
id_p=$(./create.sh $id_m)
#echo -e "--create_page_id=$id_m"

id_p2=$(./create.sh $id_m)
echo -e "--create2_page_id=$id_p"


echo -e "--update_p=$id_p--"
./update.sh $id_m $id_p 
echo  -e ""
echo -e  "./page/get.sh $id_p"
./get.sh $id_p
echo  -e ""
echo -e  "./page/index.sh"
./index.sh
echo  -e ""


cd ../main/
echo -e "--getconfig--"
./getconfig.sh



echo  -e ""
cd ../menu
echo -e "--delete_m=$id_m--"
#./delete.sh $id_m  ##uwaga to odkomentuj do testow
echo  -e ""


#echo -e  "--delete--all"
#./delete_all.sh 
echo  -e ""

