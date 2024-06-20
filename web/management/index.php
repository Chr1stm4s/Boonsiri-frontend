<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "dashboard";

        require_once "./head.php";

        $DataDashboardRequest = [
            "startDate" => date("Y-m-d"), 
            "endDate" => date("Y-m-d", strtotime(date("Y-m-d") . "+1 days"))
        ];

        $DataDashboardAPI = connect_api("{$API_URL}dashboard/get-dashboard", $DataDashboardRequest);

        if ($DataDashboardAPI['responseCode'] == "000") {
            $DataDashboard = $DataDashboardAPI['getDashBoard'];

            $totalOrder = $DataDashboard['totalOrder'];
            $totalWaitingPayment = $DataDashboard['totalWaitingPayment'];
            $totalClaim = $DataDashboard['totalClaim'];
            $totalEarn = number_format($DataDashboard['totalEarn']);
        } else {
            $totalOrder = 0;
            $totalWaitingPayment = 0;
            $totalClaim = 0;
            $totalEarn = 0;
        }

        $DataSaleChartRequest = [
            "year" => date("Y"), 
        ];

        $DataSaleChartAPI = connect_api("{$API_URL}dashboard/get-yearly-sales-chart", $DataSaleChartRequest);

        if ($DataSaleChartAPI['responseCode'] == "000") {
            $DataSaleChart = $DataSaleChartAPI['salesChartViewModels'];
        } else {
            for ($month = 1; $month <= 12; $month++) {
                $DataSaleChart[$month] = [
                    "month" => $month,
                    "monthName" => thai_month($month),
                    "totalOrders" => "0",
                    "totalIncome" => "0"
                ];
            }
        }

        $DataPieChartRequest = [
            "topSales" => 5,
            "startDate" => date("Y-m-01"), 
            "endDate" => date("Y-m-01", strtotime("+1 month", strtotime(date("Y-m-01"))))
        ];

        $DataPieChartAPI = connect_api("{$API_URL}dashboard/get-circle-sales-graph", $DataPieChartRequest);

        if ($DataPieChartAPI['responseCode'] == "000") {
            $DataPieChart = $DataPieChartAPI['circleSalesGraphModel'];
        } else {
            $DataPieChart['toTalAmounts'] = [
                "itemCode" => "-", 
                "amount" => "0"
            ];

            $DataPieChart['toTalAmountsCategories'] = [
                "title" => "-", 
                "products" => [
                    "title" => "-", 
                    "amount" => "0"
                ]
            ];
        }
    ?>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load(
            'current', {
                'packages': [
                    'corechart', 
                    'bar'
                ]
            }
        );

        google.charts.setOnLoadCallback(ProductSalesChart);
        google.charts.setOnLoadCallback(CategorySalesChart);
        google.charts.setOnLoadCallback(SalesChart);
        
        function ProductSalesChart() {
            var data = new google.visualization.DataTable();

            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows(
                [

                    <?php
                        foreach ($DataPieChart['toTalAmounts'] as $DataPieChartCategory) {
                    ?>

                    [
                        '<?=$DataPieChartCategory['itemCode'];?>', 
                        <?=$DataPieChartCategory['amount'];?>
                    ], 

                    <?php
                        }
                    ?>
                ]
            );

            var options = {
                'title': 'อัตราส่วนยอดขายราย SKU ประจำเดือน (<?=thai_month(date("n"));?>)', 
                'width': "100%", 
                'height': "100%" 
            };

            var chart = new google.visualization.PieChart(document.getElementById('ProductSalesChart'));
            chart.draw(data, options);
        }

        function CategorySalesChart() {
            var data = new google.visualization.DataTable();

            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows(
                [
                    <?php
                        foreach ($DataPieChart['toTalAmountsCategories'] as $DataPieChartCategory) {
                    ?>

                    [
                        '<?=$DataPieChartCategory['title'];?>', 
                        <?=count($DataPieChartCategory['products']);?>
                    ], 

                    <?php
                        }
                    ?>
                ]
            );

            var options = {
                'title': 'อัตราส่วนยอดขายตามหมวดหมู่ประจำเดือน (<?=thai_month(date("n"));?>)', 
                'width': "100%", 
                'height': "100%" 
            };

            var chart = new google.visualization.PieChart(document.getElementById('CategorySalesChart'));
            chart.draw(data, options);
        }

        function SalesChart() {
            var chartDiv = document.getElementById('SalesChart');

            var data = google.visualization.arrayToDataTable(
                [
                    [
                        'เดือน', 
                        'คำสั่งซื้อ', 
                        'ยอดขาย'
                    ], 

                    <?php
                        foreach ($DataSaleChart as $Chart) {
                    ?>

                    [
                        '<?=$Chart['monthName'];?>', 
                        <?=$Chart['totalOrders'];?>, 
                        <?=$Chart['totalIncome'];?>
                    ], 

                    <?php
                        }
                    ?>

                ]
            );

            var materialOptions = {
                chart: {
                    title: 'ยอดขายรายเดือน ประจำปี (<?=date("Y");?>)',
                    subtitle: 'แบ่งตามยอดขายสินค้า และยอดจองบริการทั้งหมด'
                },
                series: {
                    0: {
                        axis: 'สินค้า'
                    },
                    1: {
                        axis: 'บริการ'
                    }
                },
                axes: {
                    y: {
                        distance: {
                            label: 'parsecs'
                        },
                        brightness: {
                            side: 'right',
                            label: 'apparent magnitude'
                        }
                    }
                },
                'width': "100%",
                'height': "100%"
            };

            var materialChart = new google.charts.Bar(chartDiv);
            materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
        };
    </script>

    <style>
        .google-chart {
            width: 100%;
            height: 50dvh;
        }
    </style>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="mb-0">Dashboard</h1>
                </div>
                <div class="col-auto my-auto">
                    <h5 class="mb-0 badge text-bg-dark fs-3"><?=date("d M Y");?></h5>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="row my-5">
                <div class="col-6 col-md-3 my-3">
                    <div class="card text-bg-primary">
                        <div class="card-body text-center">
                            <p class="card-title">จำนวนคำสั่งซื้อ</p>
                            <h1><?=$totalOrder;?> รายการ</h1>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 my-3">
                    <div class="card text-bg-warning">
                        <div class="card-body text-center">
                            <p class="card-title">จำนวนคำสั่งซื้อที่รอจ่ายเงิน</p>
                            <h1><?=$totalWaitingPayment;?> รายการ</h1>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 my-3">
                    <div class="card text-bg-info">
                        <div class="card-body text-center">
                            <p class="card-title">จำนวนรายการเคลม</p>
                            <h1><?=$totalClaim;?> รายการ</h1>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 my-3">
                    <div class="card text-bg-danger">
                        <div class="card-body text-center">
                            <p class="card-title">ยอดขาย</p>
                            <h1><?=$totalEarn;?> บาท</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12 col-md-6 my-3">
                    <div id="ProductSalesChart" class="google-chart"></div>
                </div>
                <div class="col-12 col-md-6 my-3">
                    <div id="CategorySalesChart" class="google-chart"></div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="SalesChart" class="google-chart"></div>
                </div>
            </div>
        </div>
    </section>
    
    <?php require_once "./js.php"; ?>

</body>

</html>