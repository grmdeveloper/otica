<!DOCTYPE html>
<html>
<head>
	<title>Charts test</title>
	<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js'></script>
</head>
<body>
	<h1>canvas chart test</h1>
	<canvas class='line-chart'></canvas>
</body>
	<script type="text/javascript">
		var ctx= document.getElementsByClassName("line-chart");

	var chartGraph = new Chart(ctx,{
		type:'line',
		data:{
			labels:['ontem','hoje'],
			datasets:[
				{
					label:"Vendas",
					data:[1,0],
					borderWidth:5,
					borderColor:'blue',
					backgroundColor:'transparent'
				}
			],
		}
	});
		/*var chartGraph = new Chart(ctx, {
			type: 'line',
			data: {
				
				labels: ['jan','fev','mar','abr','mai','jun','jul','ago','set','out','nov','dez'],
				
				datasets: [
				{	
					label: "Vendas em milhares",
					data: 	[5,10,20,32,23,25,15,10,28,32,13,25],
					borderWidth:5,
					borderColor:'blue',
					backgroundColor:'transparent',
				},
				{
					label:"Homens %",
					data:	[49.2,49.4,49,50.9,49,51,49.2,50.8,49.7,48.9,49,51,],
					borderWidth:4,
					borderColor:'red',
					backgroundColor:'transparent',
				},
				{
					label:"Mulheres %",
					data:	[50.1,50.6,50.9,49.1,51,49.2,50.8,49.7,49.7,51.1,51,51,],
					borderWidth:4,
					borderColor:'pink',
					backgroundColor:'transparent',
				}]

			},
			options: {
				title:{
					display:true,
					fontSize:20,
					text:'DADOS Ecommerce 2017'
				}
			}
		});*/
	</script>
</html>