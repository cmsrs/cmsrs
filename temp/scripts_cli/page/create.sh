#!/bin/bash

if [ ! $# == 1 ]; then
  echo $"Skladnia: $0 {menu_id}"
  exit
fi


curl  --silent    -H "Accept:application/json" -H "Content-Type:application/json"   -XPOST "http://cmsrs2admin.loc/api/pages/save" -d '{"data":{ "id":"0",  "published":"1","translates":{"page_short_title":{"pl":"p_short_pl2","en":"p_short_en2"}, "page_title":{"pl":"p_pl2","en":"p_en2"}, "page_intro_text":{"pl":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...","en":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua..."} }, "is_left_menu" : "1", "is_intro_text" : "1", "menus_id":"'$1'", "contents":{"pl":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.","en":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."} }}'


#curl  -H "Accept:application/json" -H "Content-Type:application/json"   -XPOST "http://cmsrs2admin.loc/api/pages/save" -d '{"data":{ "id":"0",  "published":"1","translates":{"page_short_title":{"pl":"test_pl2_uu1","en":"test_en2_uu2"},    }}}'
