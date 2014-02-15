@extends('portal.layouts.default')

@section('title')
    @parent :: Jobs
@stop

@section('styles')
<style type="text/css">
    .ng-table {
        border: 1px solid #000;
    }
</style>
{{ HTML::style('css/ng-table.css') }}
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['page_heading'] }}</h1>

            <div ng-app="main">
                <div ng-controller="DemoCtrl">
                    <p><strong>Page:</strong> @{{tableParams.page()}}</p>
                    <p><strong>Count per page:</strong> @{{tableParams.count()}}</p>

                    <table ng-table="tableParams" class="table">
                        <tr ng-repeat="user in $data">
                            <td data-title="'Name'">@{{user.name}}</td>
                            <td data-title="'Age'">@{{user.age}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
@stop

@section('scripts')
   <!-- <script src="/js/app/jobs-table.js"></script>-->
{{ HTML::script('js/ng-table.min.js') }}

<script>
    var app = angular.module('main', ['ngTable']);

/*
    app.config(function($interpolateProvider) {
        $interpolateProvider.startSymbol('//');
        $interpolateProvider.endSymbol('//');
    });
*/

    app.controller('DemoCtrl', function($scope, ngTableParams) {
            var data = [{name: "Moroni", age: 50},
                {name: "Tiancum", age: 43},
                {name: "Jacob", age: 27},
                {name: "Nephi", age: 29},
                {name: "Enos", age: 34},
                {name: "Tiancum", age: 43},
                {name: "Jacob", age: 27},
                {name: "Nephi", age: 29},
                {name: "Enos", age: 34},
                {name: "Tiancum", age: 43},
                {name: "Jacob", age: 27},
                {name: "Nephi", age: 29},
                {name: "Enos", age: 34},
                {name: "Tiancum", age: 43},
                {name: "Jacob", age: 27},
                {name: "Nephi", age: 29},
                {name: "Enos", age: 34}];

            $scope.tableParams = new ngTableParams({
                page: 1,            // show first page
                count: 10           // count per page
            }, {
                total: data.length, // length of data
                getData: function($defer, params) {
                    $defer.resolve(data.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                }
            });
        });
</script>

@stop