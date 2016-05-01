#!/bin/bash

if [ ! $# == 1 ]; then
  echo $"Skladnia: $0 {menu_id}"
  exit
fi



curl  -H "Accept:application/json" -H "Content-Type:application/json"   -XPOST "http://cmsrs2admin.loc/api/menus/save" -d '{"data":{ "id":"'$1'",  "published":"1","position":"1","is_link":"1","translates":{"menu_short_title":{"pl":"test_pl2_menu2 ch","en":"test_en2_menu2 ch"}}}}'
