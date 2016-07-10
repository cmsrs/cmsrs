angular.module("adminCmsrs")
	.constant("menusUrl", "http://cmsrs2admin.loc/api/menus/index" )
	.constant("pageEditUrl", 	"http://cmsrs2admin.loc/api/pages/save" )
	.constant("pageGet", "http://cmsrs2admin.loc/api/pages/get/" )
	.constant("mainGetconfig", "http://cmsrs2admin.loc/api/main/getconfig" )
    .controller("pageEditCtrl", function ($scope, $resource, $routeParams,  $http, $location 
	, pageEditUrl, pageGet, mainGetconfig, menusUrl, cms ){
		var pageId = $routeParams.id;
		$scope.btnName = ( '0' === pageId ) ? 'Add new page'  :  'Edit page';

		pagesGetResource = $resource( pageGet + ":id", { id: "@id" });
		pagesGetResource.get({ id: pageId }, function( pageOut  ){
			//console.log( pageOut );
			$scope.page =  pageOut; 
			//$scope.datalang = 'ala_ma_kota';

			//var positions = [];
			//for( var i=0; i < pageOut.pages_count; i++ ){
			//	positions[i] = i+1;
			//}
			//$scope.positions =  positions;
			//console.log(  positions );
		});

        $http.get(menusUrl)
            .success(function (dataMenu) {
				var dataMenu = dataMenu['out'];
				var menuToSelect = [];
				for( var i = 0; i < dataMenu.length; i++ ){
					if(  "1" === dataMenu[i].published  ){
						//console.log(   dataMenu[i]  );
						menuToSelect[i] = {};
						menuToSelect[i].id = dataMenu[i].id;
						menuToSelect[i].menu_short_title = dataMenu[i].menu_short_title;
					}
				}
                $scope.menuToSelect = menuToSelect;
            })
            .error(function (error) {
				alert( 'page_list_menu_problem' );
                $scope.data.error = error;
            });



        $http.get(  mainGetconfig )
            .success(function (data) {
				//console.log( data.langs );
                $scope.langs = data.langs;
            })
            .error(function (error) {
                //$scope.data.error = error;
				alert( error );
            });



        $scope.savePage= function (pageData) {
			//console.log( pageData  );

			var page =  'data=' + JSON.stringify( pageData );

            $http.post( pageEditUrl,  page )
                .success(function (data) {
					//console.log('ok='+data);
                })
                .error(function (error) {
                    //$scope.data.orderError = error;
					alert( 'err_create_page' );
                }).finally(function () {
                    $location.path("/pagelist");
                });
        }

	});
