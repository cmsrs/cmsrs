angular.module("adminCmsrs")
	.constant("pagesUrl", "http://cmsrs2admin.loc/api/pages/index" )
	.constant("pageDelete", "http://cmsrs2admin.loc/api/pages/delete/" )
    .controller("pageListCtrl", function ($scope, $resource,  $http, $location
	, pagesUrl, pageDelete, cms  ){

        $scope.pagesData = {
        };

        $http.get(pagesUrl)
            .success(function (data) {
				//console.log( data );
                $scope.pagesData = data;
	        })
            .error(function (error) {
                $scope.data.error = error;
            });

		$scope.createPage = function(){
            $location.path('/pageedit/0');
		}

		$scope.editPage = function( pageId ){
            $location.path('/pageedit/' +  pageId );
		}

		$scope.deletePage = function( pageId  ){
			//alert('del'+ pageId   );
			pagesResource = $resource( pageDelete + ":id", { id: "@id" });
			pagesResource.remove({ id: pageId }, function(){
				cms.setItems(  $scope.pagesData  );
				$scope.pagesData = cms.removeItem( pageId  );
			});
		}

	});
