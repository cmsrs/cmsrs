#!/bin/bash

if [ ! $# == 1 ]; then
  echo $"Skladnia: $0 {image_id}"
  exit
fi

#echo $1

curl  -H "Accept:application/json"  -XDELETE    "http://cmsrs2admin.loc/api/images/delete/$1"


#curl -i   -H "Accept:application/json" -H "Content-Type:application/json"   -XDELETE "http://cmsrs2admin.loc/api/menus/delete" -d '{"data":"'$1'"}'
