#!/bin/bash


curl   -H "Authorization: Bearer u4qnlunMrSWqcyitTV06gH5C8ZlAaWar" -H "Accept:application/json"  -XDELETE    "http://cmsrs2admin.loc/api/menus/deleteall"


#curl -i   -H "Accept:application/json" -H "Content-Type:application/json"   -XDELETE "http://cmsrs2admin.loc/api/menus/delete" -d '{"data":"'$1'"}'
