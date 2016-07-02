/*require.config({
    baseUrl: '../new_project',
    urlArgs: 'v=1.0'
});

require([
        'share/app',
    ], function() {
	//do nothing
		angular.module(document, ['CarryBaziPhoto']);
	}
);*/

require.config({
    baseUrl: '../new_project',    
    paths: {
        'angular': 'share/js_lib/angular.js',
        'angular-route': 'share/js_lib/angular-route.js',
    },
    shim: { 'angular-route': ['angular'] },
    deps: ['app']
});
