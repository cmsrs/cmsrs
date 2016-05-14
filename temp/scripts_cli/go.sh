#!/bin/bash

#cd menu
./menu/delete_all.sh  #comment to 


imgDir="../../common/images/"
echo -e "ls -la $imgDir"
ls -la $imgDir 


echo -e "./menu/create.sh"
id_m=$(./menu/create.sh)


echo -e "./menu/update.sh $id_m"
./menu/update.sh $id_m 

echo -e "./menu/get.sh $id_m"
./menu/get.sh $id_m

echo -e "./menu/index.sh"
./menu/index.sh


echo -e "./page/create.sh $id_m"
id_p=$(./page/create.sh $id_m)
#echo -e "--create_page_id=$id_m"


echo -e "./page/create.sh $id_m"
id_p2=$(./page/create.sh $id_m)



echo -e "./page/update.sh $id_m $id_p"
./page/update.sh $id_m $id_p 
echo  -e ""
echo -e  "./page/get.sh $id_p"
./page/get.sh $id_p
echo  -e ""
echo -e  "./page/index.sh"
./page/index.sh
echo  -e ""





echo -e "./page/create.sh $id_m"
id_p3=$(./page/create.sh $id_m)


echo -e "./image/upload.sh $id_p3"
id_i=$(./image/upload.sh $id_p3)






echo -e "ls -la $imgDir"
ls -la $imgDir 


echo -e "ls -la $imgDir/$id_p3"
ls -la $imgDir/$id_p3 


echo -e "./page/delete.sh $id_p3"
./page/delete.sh $id_p3


echo -e "tu juz nie powinno byc obrazka $id_p3  ls -la $imgDir"
echo -e "ls -la $imgDir"
ls -la $imgDir 

#exit

echo -e "./image/upload.sh $id_p"
id_i=$(./image/upload.sh $id_p)

echo -e "11 ls -la $imgDir/$id_p/"
ls -la $imgDir/$id_p/


echo -e "tu nie bedzie obrazka:"
echo -e "11   ./image/delete.sh $id_i"
./image/delete.sh $id_i
echo -e "11 ls -la $imgDir/$id_p/"
ls -la $imgDir/$id_p/


echo -e "./image/upload.sh $id_p"
id_i=$(./image/upload.sh $id_p)
echo -e "./image/upload.sh $id_p2"
id_i=$(./image/upload.sh $id_p2)


echo -e "./image/upload.sh $id_p2"
id_i99=$(./image/upload.sh $id_p2)

echo -e "--getconfig--"
./main/getconfig.sh


echo  -e ""
#cd ../menu
echo -e "./menu/delete.sh $id_m"
#./menu/delete.sh $id_m  ##uwaga to odkomentuj do testow
echo  -e ""





#echo -e  "--delete--all"
#./delete_all.sh 
echo  -e "new menu"




echo -e "./menu/create.sh"
id_m2=$(./menu/create.sh)

echo -e "./page/create.sh $id_m2"
id_p4=$(./page/create.sh $id_m2)

echo -e "./image/upload.sh $id_p4"
id_i7=$(./image/upload.sh $id_p4)

echo -e "./image/upload.sh $id_p4"
id_i8=$(./image/upload.sh $id_p4)


#echo -e "./image/showimage.sh $id_i8"
#./image/showimage.sh $id_i8

echo -e "ls -laR $imgDir"
ls -laR $imgDir 



