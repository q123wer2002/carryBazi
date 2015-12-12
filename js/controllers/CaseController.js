caseModel.controller('CaseController',['$scope',
function($scope) {
	$scope.title = 'All cases';
	$scope.cases = [
		{
			name: 'case 1',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 2',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 3',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 4',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 5',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 6',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 7',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 8',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 9',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 10',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 11',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 12',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 13',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 14',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 15',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 16',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 17',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 18',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 19',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 20',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		}
	];
	
	$scope.currentList=[
		{
			name: 'case 1',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 2',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 3',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 4',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 5',
			owner: 'owner1',
			price: 10000,
			description: 'It is the description about this case'
		},
		{
			name: 'case 6',
			owner: 'owner2',
			price: 10000,
			description: 'It is the description about this case'
		}
	]; 
  
	$scope.pageCurrent = 1;
    $scope.pagePageSize = 6;
	
    $scope.pageMax = function () { 
        return Math.ceil($scope.cases.length / $scope.pagePageSize);};
	
    $scope.changePage = function(aPageIndex) {
        if(aPageIndex == 'next') {
			if($scope.pageCurrent >= $scope.pageMax()) $scope.pageCurrent = $scope.pageMax();
			else $scope.pageCurrent+=1;
		}    
        else if(aPageIndex == 'prev') {
			if($scope.pageCurrent <= 1) $scope.pageCurrent = 1;
			else $scope.pageCurrent-=1;
		}
        else if(aPageIndex == 'last')
            $scope.pageCurrent = $scope.pageMax();
        else if(aPageIndex == 'first')
            $scope.pageCurrent = 1;
		
		$scope.currentList = [];

		var ii = Math.min($scope.pageCurrent * $scope.pagePageSize, $scope.cases.length);         
		for (var i = ($scope.pageCurrent - 1) * $scope.pagePageSize; i < ii; i+=1) {
			$scope.currentList.push($scope.cases[i]);
		}
	}
}]);