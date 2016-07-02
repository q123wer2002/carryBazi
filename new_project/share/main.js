require.config({
    baseUrl: '../new_project',
    urlArgs: 'v=1.0'
});

require([
        'share/services/routeResolver',
        'share/app'
    ], function() {
	//do nothing
		angular.module(document, ['CarryBaziPhoto']);
	}
);
