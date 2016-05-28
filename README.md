#cmsRS

##Description
===========

CmsRS is a cms base on: 
* Yii2 advanced template 
* AngularJS v1 (administration panel)
* CSS · Bootstrap (frontend and backend)

This is cutdown version of my cms.
It is include:
* add pages and menu
* add content to the page
* upload and delete image
* set up langs
* log in to administration panel

Db scheme:

<img src="https://github.com/cmsrs/cmsrs/blob/master/temp/schema_cmsrs.png" alt="Db scheme" />


The full version available on the website:

http://www.cmsrs.pl/en/cms/cmsrs/about-cmsrs


##Installation
============

1. Install:

		git clone https://github.com/yiisoft/yii2-app-advanced.git
		cd yii2-app-advanced
		composer global require "fxp/composer-asset-plugin:~1.1.1"
		composer create-project --prefer-dist yiisoft/yii2-app-advanced cmsrs
		
		cd cmsrs
		git clone https://github.com/cmsrs/cmsrs.git
		rm -rf common frontend admin; mv cmsrs/* .; rm -rf  cmsrs


2. Set db:

	Change: `common/config/main-local.php` accordingly.
	
	Create table to database from `temp/cmsrs4.sql` in my case:
	
		mysql --default-character-set=utf8 -u cmsrs -ppass123456 cmsrs < ./temp/cmsrs4.sql 
	
	
	
3. Set vhosts:
	
	Frontend:

	 url: `cmsrs2.loc` 
	 `/path/to/yii2-app-advanced/cmsrs/frontend/web/`
	
	Backend:

	 url:  `cmsrs2admin.loc` (it is a important name)
	 `/path/to/yii2-app-advanced/cmsrs/admin/web/`


		<VirtualHost *:80>
			ServerName cmsrs2.loc
			DocumentRoot "/path/to/yii2-app-advanced/cmsrs/frontend/web/"
			
			<Directory "/path/to/yii2-app-advanced/cmsrs/frontend/web/">
               # use mod_rewrite for pretty URL support
               RewriteEngine on
               # If a directory or a file exists, use the request directly
               RewriteCond %{REQUEST_FILENAME} !-f
               RewriteCond %{REQUEST_FILENAME} !-d
               # Otherwise forward the request to index.php
               RewriteRule . index.php

               # use index.php as index file
               DirectoryIndex index.php

               # ...other settings...
			</Directory>
       </VirtualHost>


		<VirtualHost *:80>
			ServerName cmsrs2admin.loc  
			DocumentRoot "/path/to/yii2-app-advanced/cmsrs/admin/web/"
			
			<Directory "/path/to/yii2-app-advanced/cmsrs/admin/web/">
               # use mod_rewrite for pretty URL support
               RewriteEngine on
               # If a directory or a file exists, use the request directly
               RewriteCond %{REQUEST_FILENAME} !-f
               RewriteCond %{REQUEST_FILENAME} !-d
               # Otherwise forward the request to index.php
               RewriteRule . index.php

               # use index.php as index file
               DirectoryIndex index.php

               # ...other settings...
           </Directory>
       </VirtualHost>

4. Edit hosts:

		127.0.0.1 cmsrs2.loc
		127.0.0.1 cmsrs2admin.loc

5. Run server side tests:

		cd temp/scripts_cli
		./go.sh

6. Config cms:

	for example set up: login and password to administration panel

	`common/config/params.php`


7. Backend:

	`http://cmsrs2admin.loc/admin/#`

	Create menu and pages

	example:

	<img src="https://github.com/cmsrs/cmsrs/blob/master/temp/admin_list_page2.png" alt="list pages" />

	<img src="https://github.com/cmsrs/cmsrs/blob/master/temp/admin_page_edit.png" alt="edit page" />

	https://github.com/cmsrs/cmsrs/blob/master/temp/cmsrs_admin.png



8. Frontend:

	`http://cmsrs2.loc/`

	example:

	<img src="https://github.com/cmsrs/cmsrs/blob/master/temp/front_start_page.png" alt="home page" />

	<img src="https://github.com/cmsrs/cmsrs/blob/master/temp/front_page_example.png" alt="page example" />

