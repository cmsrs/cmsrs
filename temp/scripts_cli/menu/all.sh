#!/bin/bash

./delete_all.sh
id=`./create.sh`
#echo $id
echo "--edit--$id--"
./update.sh $id 
echo "--get--"
./get.sh $id 
echo "--index--"
./index.sh
echo "--delete--$id--"
./delete.sh $id 
