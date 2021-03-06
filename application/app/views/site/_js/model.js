module.config(['$httpProvider', 'RestProvider',
    function ($httpProvider, RestProvider) {
        $httpProvider.interceptors.push(httpInterceptor);

        RestProvider.defaults.baseUrl = baseApiUrl;
        RestProvider.defaults.collectionEnvelope = 'rows';
    }
]);

httpInterceptor.$inject = ['$q', '$injector'];
function httpInterceptor($q, $injector) {
    return {
        request: request,
        responseError: responError
    };

    function request(config) {
        if (opts.token === undefined) {
            //opts.token = localStorage.getItem(TOKEN_KEY);
        }
        if (opts.token && config.url.indexOf(baseApiUrl) === 0) {
            switch (opts.authMethod) {
                case 'http-bearer':
                    config.headers.Authorization = 'Bearer ' + opts.token;
                    break;

                case 'query-param':
                default :
                    config.params = angular.extend(config.params || {}, {'access-token': opts.token});
                    break;
            }
        }
        return config;
    }
    function responError(response) {
        if (response.status == 401) {
            var deferred = $q.defer();
            var $modal = $injector.get('$modal');

            var loginModal = angular.extend({}, widget.routes['/user/login'], {
                animation: true,
                size: 'sm',
                backdrop: 'static',
            });
            $modal.open(loginModal).result.then(function (token) {
                opts.token = token;
                //localStorage.setItem(TOKEN_KEY, opts.token);
                window.location.reload();
            }, function () {
                window.history.back();
            });
            return deferred.promise;
        }
        return $q.reject(response);
    }
}