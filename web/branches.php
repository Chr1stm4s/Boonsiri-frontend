<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "branches";
        
        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <div id="map" class="branches-map"></div>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active" aria-current="page">สาขาบุญศิริทั่วประเทศ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 branches-list">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h3 class="fs-1 mb-0">สาขาบุญศิริทั่วประเทศ</h3>
                </div>
            </div>
            <div class="row g-4">

                <?php
                    $BranchesResponse = connect_api("https://ecmapi.boonsiri.co.th/api/v1/branch/master/list-branch");

                    if ($BranchesResponse['responseCode'] == 000) {
                        foreach ($BranchesResponse['branches'] as $BranchData) {
                ?>

                <div class="col-12 col-md-6 col-lg-4 my-3 h-100 branches-list" id="Branch<?=$BranchData['id'];?>">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            <h4 class="card-title text-center"><img src="<?=rootURL();?>images/logo.png" alt="บุญศิริโฟรเซ่นโปรดักส์ นครราชสีมา" height="70"><br>บุญศิริโฟรเซ่นโปรดักส์<br><?=$BranchData['title'];?></h4>
                            <p class="card-text" style="height: 50px;"><?=$BranchData['address'];?> <?=$BranchData['districtName'];?> <?=$BranchData['amphurName'];?> <?=$BranchData['provinceName'];?> <?=$BranchData['postcode'];?></p>
                            <p class="mb-1 fs-5"><a href="tel:<?=$BranchData['phone'];?>" class="text-decoration-none text-primary"><i class="fa-solid fa-square-phone"></i> <?=$BranchData['phone'];?></a></p>
                            <p class="mb-1 fs-5"><a href="https://line.me/ti/p/%40<?=$BranchData['line'];?>" class="text-decoration-none text-success"><i class="fa-brands fa-line"></i> @<?=$BranchData['line'];?></a></p>
                            <p class="mb-1 fs-5"><a href="https://www.google.com/maps/dir/?api=1&destination=<?=$BranchData['latitude'];?>,<?=$BranchData['longitude'];?>" class="text-decoration-none text-theme-4"><i class="fa-solid fa-map-location-dot"></i> นำทาง</a></p>
                        </div>
                    </div>
                    
                </div>

                <?php
                        }
                    } else {
                ?>

                <div class="col">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            <h5 class="card-title"><img src="<?=rootURL();?>images/logo.png" alt="บุญศิริโฟรเซ่นโปรดักส์ นครราชสีมา" height="30">ไม่พบข้อมูล</h5>
                        </div>
                    </div>
                </div>      

                <?php
                    }
                ?>

            </div>
        </div>
    </section>

    <?php require_once "./lead-form.php"; ?>
    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3j7pBekNzuztp6pjQBOiuh4fjTwyzTe0&callback=initMap" async defer></script>
    <script>
        // Initialize and add the map
        let map;
        let lastOpenedInfoWindow;
        
        async function initMap() {
            // Create a map object
            const { Map } = await google.maps.importLibrary("maps");

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: { lat: 15.8700, lng: 100.9925 }, // Center the map on Thailand
            });

            $.ajax({
                url: 'https://ecmapi.boonsiri.co.th/api/v1/branch/master/list-branch',
                type: 'POST',
                contentType: "application/json", 
                success: function(response) {
                    
                    const branchesArray = response.branches;
                    const markerIcon = {
                        url: '<?=rootURL();?>images/marker-icon.png', 
                        scaledSize: new google.maps.Size(70, 70), // Set the size of the image
                    }
                    
                    branchesArray.forEach(branch => {
                        // Create a marker for each branch
                        const marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(branch.latitude),
                                lng: parseFloat(branch.longitude),
                            },
                            map: map,
                            title: branch.title,
                            icon: markerIcon
                        });

                        // Create an info window for each marker
                        const infowindow = new google.maps.InfoWindow({
                            content: '<div id="content" class="p-1">'+
                                '<h4 id="firstHeading" class="firstHeading">'+branch.title+'</h4>'+
                                '<div id="bodyContent">'+
                                '<p><b>เบอร์ติดต่อ:</b> '+branch.phone+'</p>'+
                                '<p><b>LINE ID:</b> '+branch.line+'</p>'+
                                '<p><b>ที่อยู่:</b> '+branch.address+'</p>'+
                                '<button type="button" class="btn btn-theme-3" onclick="window.open(\'https://www.google.com/maps/dir/?api=1&destination='+branch.latitude+','+branch.longitude+'\', \'_blank\')"><i class="fa-solid fa-map-location-dot"></i>&nbsp;นำทาง</button>'+
                                '</div>'+
                                '</div>',
                        });

                        // Add a click listener to the marker to open the info window
                        marker.addListener('click', function() {
                            infowindow.open(map, marker);

                            if (lastOpenedInfoWindow) {
                                lastOpenedInfoWindow.close();
                            }
                            
                            infowindow.open(map, marker);
                            lastOpenedInfoWindow = infowindow;
                        });
                    });
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>

</body>

</html>