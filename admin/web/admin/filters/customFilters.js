angular.module("customFilters", [])
.filter('checkmark', function() {
	return function(input) {
		return ( '1' ===  input ) ? '\u2713' : '\u2718';
	};
});

