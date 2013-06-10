function TrajectoryCtrl($scope, $http) {

  $scope.init = function(){
    $scope.targetDistance = Math.round((Math.random() * 11000) + 500);
    $scope.targetSize = Math.round((Math.random() * 25) + 5);

    $scope.projectileWeight = (Math.random() > 0.5 ? 90 : 100);
    $scope.launchVelocities = [450, 460, 470, 480, 490, 500, 510, 520, 530];

    $scope.launchVelocity = 530;
    $scope.launchAngle = 0;

    $scope.intersects = false;
    $scope.miss_by = 0;
    $scope.range = 0;
    $scope.working = false;
    $scope.show_output = false;
  };

  $scope.onValueChange = function() {
    $scope.working = true;
    $scope.show_output = true;

    var postPayload = {
        launchVelocity: $scope.launchVelocity,
        launchAngle: $scope.launchAngle,
        targetDistance: $scope.targetDistance,
        targetSize: $scope.targetSize
      },
      postData = $.param(postPayload);

    $http({
      method: 'POST',
      url: '/calculators/intersects-target',
      data: postData,
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    }).success(function(data){
      $scope.intersects = data.results.intersects;
      $scope.intersects_in = data.results.intersects_in;
      $scope.miss_by = Math.round(data.results.height - $scope.targetSize);
      $scope.miss_by_range = Math.round($scope.targetDistance - data.results.range);

      $scope.working = false;
      $(document).trigger('refresh.stats');
    });
  };

  $scope.init();
}