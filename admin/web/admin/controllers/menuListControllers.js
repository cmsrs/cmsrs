angular.module("adminCmsrs")
	.constant("menusUrl", "http://cmsrs2admin.loc/api/menus/index" )
	.constant("menuDelete", "http://cmsrs2admin.loc/api/menus/delete/" )
    .controller("menuListCtrl", function ($scope, $resource,  $http, $location
	, menusUrl, menuDelete, cms  ){

		this.navHide = false;

        $scope.menusData = {
        };

        $http.get(menusUrl)
            .success(function (data) {
                $scope.menusData = data['out'];
	        })
            .error(function (error) {
                $scope.data.error = error;
            });

		$scope.createMenu = function(){
            $location.path('/menuedit/0');
		}

		$scope.editMenu = function( menuId ){
            $location.path('/menuedit/' +  menuId );
		}

		$scope.deleteMenu = function( menuId  ){
			menusResource = $resource( menuDelete + ":id", { id: "@id" });
			menusResource.remove({ id: menuId }, function(){
				cms.setItems(  $scope.menusData  );
				$scope.menusData = cms.removeItem( menuId  );
			});
		}

	});
