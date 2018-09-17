<?php $this->load->view("admin/includes/lte/head"); ?>
<link rel="stylesheet" type="text/css" href="https://www.highcharts.com/media/com_demo/css/highslide.css" />
<title>Dashboard - <?php echo $settings['title']; ?></title>
<?php $this->load->view("admin/includes/lte/header"); ?>
<?php $this->load->view("admin/includes/lte/sidebar"); ?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Dashboard
			<small>All statistics and summary about the website</small>
		</h1>
		<ol class="breadcrumb">
			<li class="active"><a href="<?php echo base_url(ADMIN_CONTROLLER."/dashboard"); ?>">Dashboard</a></li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-md-6 m-b-10">
				<div class="box box-primary m-b-10">
					<div class="box-header with-border">
						<h3 class="box-title">Website Stats</h3>
					</div>
				</div>
			
				<div class="row">
					<div class="col-sm-6">
						
						<div class="info-box">
							<span class="info-box-icon bg-aqua"><i class="fa fa-eye"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Views Today</span>
								<span class="info-box-number"><?php echo $stats['pageViewsToday']['pageViews']?></span>
							</div>
							
						</div>
					  
					</div>
					
					<div class="col-sm-6">
						
						<div class="info-box">
							<span class="info-box-icon bg-aqua"><i class="fa fa-eye"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Unique Views Today</span>
								<span class="info-box-number"><?php echo $stats['pageViewsToday']['uniqueViews']?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						
						<div class="info-box">
							<span class="info-box-icon bg-aqua"><i class="fa fa-sign-in"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Today Signups</span>
								<span class="info-box-number"><?php echo $stats['totalUsersToday']?></span>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="info-box">
							<span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
							
							<div class="info-box-content">
								<span class="info-box-text">All Users </span>
								<span class="info-box-number"><?php echo $stats['allUsers']?></span>
							</div>
							
						</div>
					  
					</div>
					
					
				</div>
			</div>
			
			
			
			<div class="col-md-6 m-b-10">
				<div class="box box-primary m-b-10">
					<div class="box-header with-border">
						<h3 class="box-title">Website Resources</h3>
					</div>
				</div>
			
				<div class="row">
					<div class="col-sm-6">
						
						<div class="info-box">
							<span class="info-box-icon bg-yellow"><i class="fa fa-btc"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Total Coins</span>
								<span class="info-box-number"><?php echo $stats['totalCoins']?></span>
							</div>
							
						</div>
					  
					</div>
					
					<div class="col-sm-6">
						
						<div class="info-box">
							<span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Total Currencies</span>
								<span class="info-box-number"><?php echo $stats['totalCurrencies']?></span>
							</div>
							
						</div>
					  
					</div>
					
					
				</div>
				<div class="row">
					<div class="col-sm-6">
						
						<div class="info-box">
							<span class="info-box-icon bg-yellow"><i class="fa fa-language"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Total Languages</span>
								<span class="info-box-number"><?php echo $stats['totalLanguages']?></span>
							</div>
							 
						</div>
					  
					</div>
					
					<div class="col-sm-6">
						
						<div class="info-box">
							<span class="info-box-icon bg-yellow"><i class="fa fa-file-text-o"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Custom Pages</span>
								<span class="info-box-number"><?php echo $stats['totalPages']?></span>
							</div>
							
						</div>
					  
					</div>
					
					
				</div>
			</div>
		
		</div>
	
	<div class="row">
	
		<div class="col-md-6">
			<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		</div>
		
		<div class="col-md-6">
			<div id="getChartAdminStats" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		</div>
		
	</div>
	
	</section>
</div>
<?php $this->load->view("admin/includes/lte/footer-tag"); ?>
<?php $this->load->view("admin/includes/lte/footer-script-files"); ?>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- Additional files for the Highslide popup effect -->
<script src="https://www.highcharts.com/media/com_demo/js/highslide-full.min.js"></script>
<script src="https://www.highcharts.com/media/com_demo/js/highslide.config.js" charset="utf-8"></script>

<script type="text/javascript">

$.ajax({
    url: '<?php echo base_url()."getChartAdmin"?>',
    success: function (csv) {
        Highcharts.chart('container', {

            data: {
                csv: csv.replace(/\n\n/g, '\n')
            },

            title: {
                text: 'Users registration statistics'
            },

            subtitle: {
                text: ''
            },

            xAxis: {
                tickInterval: 7 * 24 * 3600 * 1000, // one week
                tickWidth: 0,
                gridLineWidth: 1,
                labels: {
                    align: 'left',
                    x: 3,
                    y: -3
                }
            },

            yAxis: [{ // left y axis
                title: {
                    text: null
                },
                labels: {
                    align: 'left',
                    x: 3,
                    y: 16,
                    format: '{value:.,0f}'
                },
                showFirstLabel: false
            }, { // right y axis
                linkedTo: 0,
                gridLineWidth: 0,
                opposite: true,
                title: {
                    text: null
                },
                labels: {
                    align: 'right',
                    x: -3,
                    y: 16,
                    format: '{value:.,0f}'
                },
                showFirstLabel: false
            }],

            legend: {
                align: 'left',
                verticalAlign: 'top',
                borderWidth: 0
            },

            tooltip: {
                shared: true,
                crosshairs: true
            },

            plotOptions: {
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function (e) {
                                hs.htmlExpand(null, {
                                    pageOrigin: {
                                        x: e.pageX || e.clientX,
                                        y: e.pageY || e.clientY
                                    },
                                    headingText: this.series.name,
                                    maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) + ':<br/> ' +
                                        this.y + ' visits',
                                    width: 200
                                });
                            }
                        }
                    },
                    marker: {
                        lineWidth: 1
                    }
                }
            },

            series: [{
                name: 'All visits',
                lineWidth: 4,
                marker: {
                    radius: 4
                }
            }]
        });
    }
});
$.ajax({
    url: '<?php echo base_url()."getChartAdminStats"?>',
    success: function (csv) {
        Highcharts.chart('getChartAdminStats', {

            data: {
                csv: csv.replace(/\n\n/g, '\n')
            },

            title: {
                text: 'Website statistics'
            },

            subtitle: {
                text: ''
            },

            xAxis: {
                tickInterval: 7 * 24 * 3600 * 1000, // one week
                tickWidth: 0,
                gridLineWidth: 1,
                labels: {
                    align: 'left',
                    x: 3,
                    y: -3
                }
            },

            yAxis: [{ // left y axis
                title: {
                    text: null
                },
                labels: {
                    align: 'left',
                    x: 3,
                    y: 16,
                    format: '{value:.,0f}'
                },
                showFirstLabel: false
            }, { // right y axis
                linkedTo: 0,
                gridLineWidth: 0,
                opposite: true,
                title: {
                    text: null
                },
                labels: {
                    align: 'right',
                    x: -3,
                    y: 16,
                    format: '{value:.,0f}'
                },
                showFirstLabel: false
            }],

            legend: {
                align: 'left',
                verticalAlign: 'top',
                borderWidth: 0
            },

            tooltip: {
                shared: true,
                crosshairs: true
            },

            plotOptions: {
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function (e) {
                                hs.htmlExpand(null, {
                                    pageOrigin: {
                                        x: e.pageX || e.clientX,
                                        y: e.pageY || e.clientY
                                    },
                                    headingText: this.series.name,
                                    maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) + ':<br/> ' +
                                        this.y + ' visits',
                                    width: 200
                                });
                            }
                        }
                    },
                    marker: {
                        lineWidth: 1
                    }
                }
            },

            series: [{
                name: 'All visits',
                lineWidth: 4,
                marker: {
                    radius: 4
                }
            }]
        });
    }
});
	</script>
<?php $this->load->view("admin/includes/lte/footer-end"); ?>