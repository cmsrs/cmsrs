angular.module("adminCmsrs")
	.constant("authUrl", "http://cmsrs2admin.loc/api/users/login" )
    .controller("authCtrl", function ($scope, $resource,  $http, $location, $window
	, authUrl  ){


	$scope.$watch('navHide', function(newValue, oldValue) {
		$scope.navHide = ($location.path() == '/login' ) ?  true : false ;
	});

    $scope.authenticate = function (user, pass) {

		var data_in =  'data=' + JSON.stringify( { username: user, password: pass } );
        $http.post(authUrl, 
			data_in
			//, { withCredentials: true}
		).success(function (data) {
			//console.log( data.access_token );
			$scope.navHide = false;
			$window.sessionStorage.access_token = data.access_token;
			//return Boolean($window.sessionStorage.access_token);
			$location.path( 'menulist' );
        }).error(function (error) {
            $scope.authenticationError = error;
        });
    }

	});
