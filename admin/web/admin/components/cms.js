angular.module("cms", [])
.factory("cms", function () {
	var cmsData = [];

	return {
        removeItem: function (id) {
            for (var i = 0; i < cmsData.length; i++) {
                if (cmsData[i].id == id) {
                    cmsData.splice(i, 1);
                    break;
                }
            }
			return cmsData;
        },

		setItems: function( items  ){
			cmsData =  angular.copy( items  );
		},

        getItems: function () {
            return cmsData;
        }

	}

})
.directive('uploadFile', function (httpPostFactory) {
    return {
        restrict: 'A',
        scope: true,
        link: function (scope, element, attr) {

            element.bind('change', function () {
                var formData = new FormData();
                formData.append('file', element[0].files[0]  );
				var pageId = element[0].id.replace(/[^\d]/g,'');
                formData.append('pages_id', pageId );

                httpPostFactory('http://cmsrs2admin.loc/api/images/upload', formData, function (callback) {
                   // recieve image name to use in a ng-src 
                    console.log(callback);
                });
            });

        }
    };
})
.factory('httpPostFactory', function ($http) {
    return function (file, data, callback) {

        $http({
            url: file,
            method: "POST",
            data:  data,
            headers: {'Content-Type': undefined}
        }).success(function (response) {
            callback(response);
        });
    };
})
;

/*
.directive("langItems", function() {
    return {
        restrict: "AE",
        templateUrl: "components/views/langItems.html",
		replace: true,
		scope: {
			datalang: '=datalang',
		},
	    link: function($scope, elem, attr, ctrl) {
			console.debug($scope);
		    //var textField = $('input', elem).attr('ng-model', 'myDirectiveVar');
			// $compile(textField)($scope.$parent);
		}
        //controller: function ($scope) {
		//	$scope.langs = ['en', 'pl'];
        //}
    };
})
;
*/



