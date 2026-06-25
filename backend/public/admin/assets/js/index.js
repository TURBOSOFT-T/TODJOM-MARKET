$(function () {
	"use strict";
   // Récupérer les valeurs des attributs data-* à partir de l'élément
   var profilNet = JSON.parse(
	document.querySelector("#chart1").getAttribute("data-profilNet")
);


	// chart 1
	var options = {
		series: [{
			name: 'Profit',
			data: profilNet,
		}],
		chart: {
			foreColor: '#9ba7b2',
			height: 330,
			type: 'bar',
			zoom: {
				enabled: false
			},
			toolbar: {
				show: false
			},
		},
		stroke: {
			width: 0,
			curve: 'smooth'
		},
		plotOptions: {
			bar: {
				horizontal: !1,
				columnWidth: "30%",
				endingShape: "rounded"
			}
		},
		grid: {
			borderColor: 'rgba(255, 255, 255, 0.15)',
			strokeDashArray: 4,
			yaxis: {
				lines: {
					show: true
				}
			}
		},
		fill: {
			type: 'gradient',
			gradient: {
			  shade: 'light',
			  type: 'vertical',
			  shadeIntensity: 0.5,
			  gradientToColors: ['#01e195'],
			  inverseColors: true,
			  opacityFrom: 1,
			  opacityTo: 1,
			}
		  },
		colors: ['#0d6efd'],
		dataLabels: {
			enabled: false,
			enabledOnSeries: [1]
		},
		xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
        },
	};
	var chart = new ApexCharts(document.querySelector("#chart1"), options);
	chart.render();
	



// chart 2
var chartElement2 = document.getElementById("chart2");
var total_confirmer = JSON.parse(chartElement2.getAttribute("data-confirmer"));
var total_non_confirmer = JSON.parse(chartElement2.getAttribute("data-non_confirmer"));
var total_attente = JSON.parse(chartElement2.getAttribute("data-attente"));

var options = {
	series: [total_confirmer, total_attente, total_non_confirmer],
	chart: {
		height: 255,
		type: 'donut',
	},
	legend: {
		position: 'bottom',
		show: false,
	},
	plotOptions: {
		pie: {
			// customScale: 0.8,
			donut: {
				size: '80%'
			}
		}
	},
	colors: [ "#198754", "#0d6efd", "#dc3545"],
	dataLabels: {
		enabled: false
	},
	labels: ['Commandes confirmées', 'Commandes en cours', 'Commandes annulées'],
	responsive: [{
		breakpoint: 480,
		options: {
			chart: {
				height: 200
			},
			legend: {
				position: 'bottom'
			}
		}
	}]
};
var chart = new ApexCharts(document.querySelector("#chart2"), options);
chart.render();



  // chart 3

      // Récupérer les valeurs des attributs data-* à partir de l'élément
	  var ventesPerMonth = JSON.parse(
        document.querySelector("#chart3").getAttribute("data-ventesPerMonth")
    );
    var commandesPerMonth = JSON.parse(
        document.querySelector("#chart3").getAttribute("data-commandesPerMonth")
    );
    var visitsPerMonth = JSON.parse(
        document.querySelector("#chart3").getAttribute("data-visitsPerMonth")
    );


	var options = {
		series: [
            {
                name: "Ventes",
                data: ventesPerMonth,
            },
            {
                name: "Commandes",
                data: commandesPerMonth,
            },
            {
                name: "Vistes",
                data: visitsPerMonth,
            },
        ],
		chart: {
			foreColor: '#9ba7b2',
			height: 250,
			type: 'line',
			zoom: {
				enabled: false
			},
			toolbar: {
				show: false
			},
		},
		stroke: {
			width: 4,
			curve: 'smooth'
		},
		plotOptions: {
			bar: {
				horizontal: !1,
				columnWidth: "30%",
				endingShape: "rounded"
			}
		},
		grid: {
			borderColor: 'rgba(255, 255, 255, 0.15)',
			strokeDashArray: 4,
			yaxis: {
				lines: {
					show: true
				}
			}
		},
		fill: {
			type: 'gradient',
			gradient: {
			  shade: 'light',
			  type: 'vertical',
			  shadeIntensity: 0.5,
			  gradientToColors: ["#377dff", "#00c9db", "#7d00b5"],
			  inverseColors: true,
			  opacityFrom: 1,
			  opacityTo: 1,
			}
		  },
		colors: ['#0d6efd'],
		dataLabels: {
			enabled: false,
			enabledOnSeries: [1]
		},
		xaxis: {
			categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
		},
	};
	var chart = new ApexCharts(document.querySelector("#chart3"), options);
	chart.render();
	





  // chart 4

  var inscriptionMonth = JSON.parse(
	document.querySelector("#chart4").getAttribute("data-values")
);

  var options = {
	series: [{
		name: "Users",
		data: inscriptionMonth,
	}],
	chart: {
		foreColor: '#9ba7b2',
		height: 250,
		type: 'area',
		zoom: {
			enabled: false
		},
		toolbar: {
			show: false
		},
	},
	stroke: {
		width: 3,
		curve: 'smooth'
	},
	plotOptions: {
		bar: {
			horizontal: !1,
			columnWidth: "30%",
			endingShape: "rounded"
		}
	},
	grid: {
		borderColor: 'rgba(255, 255, 255, 0.15)',
		strokeDashArray: 4,
		yaxis: {
			lines: {
				show: true
			}
		}
	},
	fill: {
		type: 'gradient',
		gradient: {
		  shade: 'light',
		  type: 'vertical',
		  shadeIntensity: 0.5,
		  gradientToColors: ['#01e195'],
		  inverseColors: false,
		  opacityFrom: 0.8,
		  opacityTo: 0.2,
		}
	  },
	colors: ['#0d6efd'],
	dataLabels: {
		enabled: false,
		enabledOnSeries: [1]
	},
	xaxis: {
		categories: [
			"Jan",
			"Feb",
			"Mar",
			"Apr",
			"May",
			"Jun",
			"Jul",
			"Aug",
			"Sep",
			"Oct",
			"Nov",
			"Dec",
		],
	},
};
var chart = new ApexCharts(document.querySelector("#chart4"), options);
chart.render();








    	
});