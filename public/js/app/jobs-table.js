/* var app = angular.module('jobs-table',['ngTable']);*/
var app = angular.module('jobs-table',['ngResource']);

app.service('Job', '$resource', function($resource) {
    return $resource('jobs/:id', {id: '@id'});
});

app.controller('jobs.controller', ['$scope', 'Job', function($scope, Job) {
    $scope.jobs = Job.query();
    }]);

app.directive('pagination', [function() {
    return {
        scope: {results: '&pagination'},
        link: function(scope) {
            var paginate = function(results) {
                if (!scope.currentPage) scope.currentPage = 0;

                scope.total = results.total;
                scope.totalPages = results.last;
                scope.pages = [];

                for (var i = 1; i <= scope.totalPages; i++) {
                    scope.pages.push(i);
                }

                scope.nextPage = function() {
                    if (scope.currentPage < scope.totalPages) {
                        scope.currentPage++;
                    }
                };

                scope.prevPage = function() {
                    if (scope.currentPage > 1) {
                        scope.currentPage--;
                    }
                };

                scope.firstPage = function() {
                    scope.currentPage = 1;
                };

                scope.lastPage = function() {
                    scope.currentPage = scope.totalPages;
                };

                scope.setPage = function(page) {
                    scope.currentPage = page;
                };
            };

            var pageChange = function(newPage, lastPage) {
                if (newPage != lastPage) {
                    scope.$emit('page.changed', newPage);
                }
            };

            scope.$watch('results', paginate);
            scope.$watch('currentPage', pageChange);
        }
    }
}]);
