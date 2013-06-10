function StatsCtrl($scope, $http) {
  $scope.fetchRankings = function(){
    $http.get('/statistics').success(function(data){
      $scope.top5 = data.top5;
      $scope.me = data.me;

      $scope.userCount = data.userCount;
      $scope.shotCount = data.shotCount;
    });
  }

  $scope.fetchRankings();

  $(document).bind('refresh.stats', function(){
    $scope.fetchRankings();
  });
}