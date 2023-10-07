"use strict";
jQuery(document).ready(function(){
	window.addEventListener('load', (event) =>{

		//Single Line Charts.js  
		function createChartConfig(items, data) {
			return {
				type: 'line',
				data: {
					labels: items.labels,
					datasets: [{
						steppedLine:false,
						data: data,
						borderColor: items.color,
						fill: false,
						cubicInterpolationMode: 'monotone',
					}]
				},
				options: {
					responsive: true,
					animation:{
						duration:2500,
						easing:'linear',
					},
					title: {
						display: false,
					},
					plugins:{
						legend: {display: false},
						tooltip: {
							displayColors:false,
							padding:{
								x:15,
								top:15,
								bottom:9,
							},
							borderColor:'#eee',
							borderWidth:1,
							titleColor: '#353648',
							bodyColor: '#353648',
							bodySpacing: 6,
							titleMarginBottom: 9,
							backgroundColor:'rgba(255, 255, 255)',
						},
					},
					scales: {
						y: {
							ticks: {display: false}
						},
						x: {
							display: false,
						}
					}
				}
			};
		}
		var charData = [{
		labels: ['Start', 'Last Month', 'This Month', 'Total Posted Jobs'],
		container:document.querySelector('.chart-area'),
		steppedLine: false,
		color: window.chartColors.blue,
		data:[0,1300,855,3000],
	},{
		labels: ['Start', 'Last Month', 'This Month', 'Total Posted Jobs'],
		container:document.querySelector('.chart-area-2'),
		steppedLine: false,
		color: window.chartColors.blue,
		data:[100,50,150,100]
	},
	{
		labels: ['Start', 'Last Month', 'This Month', 'Total Posted Jobs'],
		container:document.querySelector('.chart-area-3'),
		steppedLine: false,
		color: window.chartColors.blue,
		data:[100,150,50,150]
	}];
	charData.forEach(function(items) {
		var div = document.createElement('div');
		div.classList.add('chart-container');
		var canvas = document.createElement('canvas');
		div.appendChild(canvas);
		items.container.appendChild(div);
		var ctx = canvas.getContext('2d');
		var config = createChartConfig(items, items.data);
		new Chart(ctx, config);
	});
	
	})
})