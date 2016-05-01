#!/bin/bash

if [ ! $# == 2 ]; then
  echo $"Skladnia: $0 {menu_id} {page_id}"
  exit
fi



#curl  -H "Accept:application/json" -H "Content-Type:application/json"   -XPOST "http://cmsrs2admin.loc/api/menus/save" -d '{"data":{ "id":"'$1'",  "published":"1","position":"1","is_link":"1","translates":{"menu_short_title":{"pl":"test_pl2_uu1","en":"test_en2_uu2"}}}}'


curl    -H "Accept:application/json" -H "Content-Type:application/json"   -XPOST "http://cmsrs2admin.loc/api/pages/save" -d '{"data":{ "id":"'$2'",  "published":"1","translates":{"page_short_title":{"pl":"p_short_pl2_ch","en":"p_short_en2_ch"}, "page_title":{"pl":"p_pl2_ch","en":"p_en2_ch"}, "page_intro_text":{"pl":"p_intro_t_pl2_ch","en":"p_intro_t_en2_ch"} }, "is_left_menu" : "0", "is_intro_text" : "0", "menus_id":"'$1'", "contents":{"pl":"content_pl2_ch","en":"content_en2_ch"} }}'
