#!/bin/bash

if [ ! $# == 1 ]; then
  echo $"Skladnia: $0 {image_id}"
  exit
fi



curl  -H "Accept:application/json" "http://cmsrs2admin.loc/api/pages/showimage/$1"
