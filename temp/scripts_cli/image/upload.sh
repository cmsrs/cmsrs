#!/bin/bash

if [ ! $# == 1 ]; then
  echo $"Skladnia: $0 {page_id}"
  exit
fi



#curl  -H "Accept:application/json" -H "Content-Type:application/json"   -XPOST "http://cmsrs2admin.loc/api/images/upload" -d '{"data":{ "page_id":"'$1'"}}'

#curl   -X POST  -H "Accept:application/json" -H "Content-Type:multipart/form-data"  -F "data=@test.jpg" "http://cmsrs2admin.loc/api/images/upload" 


curl --form name=myfileparam --form file=@test.jpg \
  -Fdata='{"pages_id": "'$1'", "file": "file"}' \
  -Fsubmit=Build \
	http://cmsrs2admin.loc/api/images/upload

