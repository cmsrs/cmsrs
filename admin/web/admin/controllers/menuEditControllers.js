angular.module("adminCmsrs")
	.constant("menuEditUrl", 	"http://cmsrs2admin.loc/api/menus/save" )
	.constant("menuGet", "http://cmsrs2admin.loc/api/menus/get/" )
	.constant("mainGetconfig", "http://cmsrs2admin.loc/api/main/getconfig" )
    .controller("menuEditCtrl", function ($scope, $resource, $routeParams,  $http, $location 
	, menuEditUrl, menuGet, mainGetconfig, cms ){
		var menuId = $routeParams.id;
		$scope.btnName = ( '0' === menuId ) ? 'Add new menu'  :  'Edit menu';

		menusGetResource = $resource( menuGet + ":id", { id: "@id" });
		menusGetResource.get({ id: menuId }, function( menuOut  ){
			$scope.menu =  menuOut['out']; 
			$scope.datalang = 'ala_ma_kota';

			var positions = [];
			//console.log( 'menu_count',  menuOut['out'].menus_count  );
			for( var i=0; i < menuOut['out'].menus_count; i++ ){
				positions[i] = i+1;
			}
			$scope.positions =  positions;

			//console.log(  positions );
		});

        $http.get(  mainGetconfig )
            .success(function (data) {
                $scope.langs = data.langs;
            })
            .error(function (error) {
                //$scope.data.error = error;
				alert( error );
            });



        $scope.saveMenu= function (menuData) {

			var menu =  'data=' + JSON.stringify( menuData );

            $http.post( menuEditUrl,  menu )
                .success(function (data) {
					//console.log('ok='+data);
                })
                .error(function (error) {
                    //$scope.data.orderError = error;
					alert( 'err_create_menu' );
                }).finally(function () {
					//alert('aaaaaaaaaa'  );
                    $location.path("/menulist");
                });
        }

	});
