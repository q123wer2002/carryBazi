project.controller('ProjectController',['$scope',
function($scope) {
	$scope.title = 'Surpeise Projects';
	$scope.projects = [
		{
			name: 'Project 1',
			publish_date: new Date('2015', '11', '08'),
			img: 'images/project1.jpg' ,
			description: '冬天來臨，除了登上玉山才能體驗降雪的樂趣，還可以用什麼方式捕捉美麗的雪花？很簡單，製作一個天氣瓶，透過天氣溫度的變化，瓶內的結晶時而飄雪，時而長成羽毛，越冷越美麗，讓你不需在冬天出遠門，就可以隨時欣賞在瓶中小世界飄雪的美好。',
			likes: 0
		},
		{
			name: 'Project 2',
			publish_date: new Date('2015', '11', '09'),
			img: 'images/project2.jpg' ,
			description: '根據維基百科記載，餃子源起於中國東漢末年，是一種以麵粉為皮的充餡食物，由南北朝至唐朝時期「偃月形餛飩」和南宋時的「燥肉雙下角子」發展而來，至今各朝代對於這道食品都有豐富的記錄。',
			likes: 0
		},
		{
			name: 'Project 3',
			publish_date: new Date('2015', '11', '09'),
			img: 'images/project3.jpg' ,
			description: 'PEGA Intern 每個月都被賦予「製作生日卡」這項使命! 在現今社群網路發達的時代，對於生日，大家總是以訊息方式傳達祝福，手做卡片好像是很久以前的事了。',
			likes: 0
		},
		{
			name: 'Project 4',
			publish_date: new Date('2015', '11', '09'),
			img: 'images/project4.jpg' ,
			description: '樂高牆的製作是PEGA intern的例行作業，一年替換一次，依照每年的生肖作為主題，而今年迎來了馬年。',
			likes: 0
		},
		{
			name: 'Project 5',
			publish_date: new Date('2015', '11', '09'),
			img: 'images/project5.jpg' ,
			description: '一直以來，PEGA Blah Blah 的編輯群們都希望將生活中美好的事物，透過不同的眼睛和視角，介紹給對設計生活有興趣的朋友們。看過這麼多不同種類與型式的創意與作品後，或許你也發現，每個躲在每個閃閃發光作品背後的創作者，往往具備了比作品本身還要精彩的故事與能量。',
			likes: 0
		}
	];
	$scope.plusOne = function(index) {
		if ($scope.projects[index].likes == 0) {
			$scope.projects[index].likes = 1;
		} else {
			$scope.projects[index].likes = 0;
		}
		
	};
	$scope.share = function(index) {
		
	};
}]);