#!/bin/bash

if [ ! $# == 1 ]; then
  echo $"Skladnia: $0 {menu_id}"
  exit
fi



curl  -H "Accept:application/json" "http://cmsrs2admin.loc/api/menus/get/$1"
#curl -i -H "Accept:application/json" "http://cmsrs2admin.loc/api/menus/get/0"
