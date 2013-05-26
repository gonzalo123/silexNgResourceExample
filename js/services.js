angular.module('MessageService', ['ngResource']).factory('Message', ['$resource', function ($resource) {
    return $resource('/api/message/resource/:id');
}]);