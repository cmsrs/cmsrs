#!/bin/bash

if [ ! $# == 1 ]; then
  echo $"Skladnia: $0 {menu_id}"
  exit
fi


curl  --silent    -H "Accept:application/json" -H "Content-Type:application/json"   -XPOST "http://cmsrs2admin.loc/api/pages/save" -d '{"data":{ "id":"0",  "published":"1","translates":{"page_short_title":{"pl":"p_short_pl2","en":"p_short_en2"}, "page_title":{"pl":"p_pl2","en":"p_en2"}, "page_intro_text":{"pl":"p_intro_t_pl2","en":"p_intro_t_en2"} }, "is_left_menu" : "1", "is_intro_text" : "1", "menus_id":"'$1'", "contents":{"pl":"content_pl2","en":"content_en2"} }}'


#curl  -H "Accept:application/json" -H "Content-Type:application/json"   -XPOST "http://cmsrs2admin.loc/api/pages/save" -d '{"data":{ "id":"0",  "published":"1","translates":{"page_short_title":{"pl":"test_pl2_uu1","en":"test_en2_uu2"},    }}}'
