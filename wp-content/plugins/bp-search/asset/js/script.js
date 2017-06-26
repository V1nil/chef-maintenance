(function () {
    var tomas_bp_member_seach_app = angular.module("tomas_bp_member_seach_app", ['ngAnimate']);
    tomas_bp_member_seach_app.controller('tomas_bp_member_search_controller', function ($scope, $http) {
        $http.get('/tomasapi/bpmembersearch').success(function (data,status,headers,config)
        {
            $scope.members = data;
        });
    });
})();