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



