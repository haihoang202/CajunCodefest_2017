/**

@Author: Hoang Pham

*/

<html>
    <header>
        <style>
            #map {
                height: 80%;
                width: 100%;
            }
        </style>

        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="assets/img/favicon.ico">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />

        <title>CitiDex (Lafayette Wiki)</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>

        <!-- Latest compiled JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- Animation library for notifications   -->
        <link href="assets/css/animate.min.css" rel="stylesheet"/>
        <link href="css/extra.css" rel="stylesheet"/>

        <!--  Light Bootstrap Table core CSS    -->
        <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>

        <!--  CSS for Demo Purpose, don't include it in your project     -->
<!--        <link href="assets/css/demo.css" rel="stylesheet" />-->
<!---->
<!---->
        <!--     Fonts and icons     -->
<!--        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">-->
<!--        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>-->
        <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
        <script src="js/extra.js"></script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyYRpNRpaSSe6hIBpQrTraLDWI7q04SSo"></script>
        <script>
            // In the following example, markers appear when the user clicks on the map.
            // Each marker is labeled with a single alphabetical character.
            $(document).ready(function () {
                <?php
                    if(isset($_GET['what'])){
                        $what = $_GET['what'];
                        ?>
                var what = '<?php echo $what;?>';
                console.log(what);
                <?php
                    }
                    else
                        $what = '';
                ?>
                var gmarkers =[];
                var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                var labelIndex = 0;

                var lafayette = { lat: 30.22, lng: -92.02 };

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 14,
                    center: lafayette
                });

                <?php
                if(isset($_GET['type'])&&$_GET['type']=='traffic'){
                ?>
                var trafficLayer = new google.maps.TrafficLayer();
                trafficLayer.setMap(map);
                <?php } elseif (isset($_GET['type'])&&$_GET['type']=='transit'){ ?>
                var transitLayer = new google.maps.TransitLayer();
                transitLayer.setMap(map);
                <?php } elseif (isset($_GET['type'])&&$_GET['type']=='bicy'){ ?>
                var bicyLayer = new google.maps.BicyclingLayer();
                bicyLayer.setMap(map);
                <?php } ?>


                var infoWindow = new google.maps.InfoWindow({map: map});

                var polyregion = [];
                var thisdata;
                var meta;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                      var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                      };

                      infoWindow.setPosition(pos);
                      infoWindow.setContent('Your Current Location!');
                      map.setCenter(pos);
                    }, function() {
                      handleLocationError(true, infoWindow, map.getCenter());
                    });
                  } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                  }



                // This event listener calls addMarker() when the map is clicked.
                google.maps.event.addListener(map, 'click', function(event) {
                    addMarker(event.latLng, map,0);
                });

                // Add a marker at the center of the map.
                addMarker(lafayette, map,0);

                var thepoly;
                console.log("hello1");

                if(what.includes("Bus")){
                    var node = document.createElement("li");                 // Create a <li> node
                    var anchor = document.createElement("a");
                    anchor.setAttribute("href","home.php?what="+what+"&type=traffic");
                    var textnode = document.createTextNode("Traffic Map");         // Create a text node
                    anchor.appendChild(textnode);                              // Append the text to <li>
                    node.appendChild(anchor);
                    document.getElementById("maptype").appendChild(node);


                    node = document.createElement("li");                 // Create a <li> node
                    anchor = document.createElement("a");
                    anchor.setAttribute("href","home.php?what="+what+"&type=transit");
                    textnode = document.createTextNode("Transit Map");         // Create a text node
                    anchor.appendChild(textnode);                              // Append the text to <li>
                    node.appendChild(anchor);
                    document.getElementById("maptype").appendChild(node);

                    node = document.createElement("li");                 // Create a <li> node
                    anchor = document.createElement("a");
                    anchor.setAttribute("href","home.php?what="+what+"&type=bicy");
                    textnode = document.createTextNode("Bicycling Map ");         // Create a text node
                    anchor.appendChild(textnode);                              // Append the text to <li>
                    node.appendChild(anchor);
                    document.getElementById("maptype").appendChild(node);
                }

                $.getJSON('data/<?php echo $what; ?>.json', function (data) {

                    meta = data.meta;
                    thisdata = data.features;

                    var busnum = '';

                    for(var i = 0; i < thisdata.length; i++){

                        var coords = thisdata[i].geometry;

                        var latLng1 = new google.maps.LatLng(coords['y'].toFixed(30),coords['x'].toFixed(30));
                        if(thisdata[i].properties.RouteNumber){
                            <?php if(isset($_GET['route'])){
                                ?>
                                if(thisdata[i].properties.RouteNumber == <?php echo $_GET['route']; ?>){
                                    addMarker(latLng1,map,1);
                                }
                            <?php
                            }else{?>
                            addMarker(latLng1,map,1);
                            <?php }?>
                            if(busnum != thisdata[i].properties.RouteNumber){
                                busnum = thisdata[i].properties.RouteNumber;
//                                console.log(busnum);
                                var node = document.createElement("li");                 // Create a <li> node
                                var anchor = document.createElement("a");
                                anchor.setAttribute("href","home.php?what="+what+"&route="+busnum);
                                var textnode = document.createTextNode("Route "+busnum);         // Create a text node
                                anchor.appendChild(textnode);                              // Append the text to <li>
                                node.appendChild(anchor);
                                document.getElementById("busroute").appendChild(node);
                            }
                        }

                        else
                            addMarker(latLng1,map,0)
                    }
                });
//                console.log(meta);


//                google.maps.event.addListener(map, 'click', function(e) {
//                    var color;
//                    console.log(polyregion.length);
//                    for(var i = 0; i < polyregion.length; i++){
//                        console.log("Here");
//                        if(google.maps.geometry.poly.containsLocation(e.latLng, polyregion[i])){
//                            color = thisdata[i].properties.address;
//                            console.log(thisdata[i].properties.name);
//                            break;
//                        }
//                    }
//
//                });

                    // Adds a marker to the map.
                function addMarker(location, map_main, flag) {
                    // Add the marker at the clicked location, and add the next-available label
                    // from the array of alphabetical characters.
                    if(flag == 0){
                        var marker = new google.maps.Marker({
                            position: location,
                            label: labels[labelIndex++ % labels.length],
                            map: map_main
                        });
                    }
                    else if(flag == 1){
                        var img = 'images/bus.ico';
                        var icon = {
                            url: "images/bus.ico", // url
                            scaledSize: new google.maps.Size(20, 20), // scaled size
//                            origin: new google.maps.Point(0,0), // origin
//                            anchor: new google.maps.Point(0, 0) // anchor
                        };
                        var marker = new google.maps.Marker({
                            animation: google.maps.Animation.DROP,
                            position: location,
                            map: map_main,
                            icon: icon
                        });
                    }

                    gmarkers.push(marker);

                    marker.addListener('click', function () {
//                        console.log(marker.getPosition().lat()+"   " + marker.getPosition().lng());

                        var contentString = "Hello in " + marker.getPosition().lat().toFixed(30) + ", " + marker.getPosition().lng().toFixed(30);

                        var arr = [];
                        for(var i = 0; i < meta.length; i++){
                            arr.push(meta[i]);

                        }



                        for(var i = 0; i < thisdata.length; i++){
                            if(Math.abs(marker.getPosition().lat() - thisdata[i].geometry['y']) <= 0.00001 && Math.abs(marker.getPosition().lng() - thisdata[i].geometry['x']) <= 0.000001 ){
                                contentString = '';
                                for(var j = 0; j < meta.length; j++){
                                    if(typeof thisdata[i].properties[meta[j]] === 'string') {
                                        if (thisdata[i].properties[meta[j]].includes('jpg') | thisdata[i].properties[meta[j]].includes('jpeg') | thisdata[i].properties[meta[j]].includes('png'))
                                            contentString += '<img id="img_art" height="50px" width="50px" src=\"' + thisdata[i].properties[meta[j]] + '\">';
                                        else
                                            contentString += '<div>' + thisdata[i].properties[meta[j]] + '</div>';
                                    }
                                    else
                                        contentString += '<div>' + thisdata[i].properties[meta[j]] + '</div>';
                                }
//                                contentString = '<div>' + thisdata[i].properties.Venue + '</div><div>';
//                                contentString+= thisdata[i].properties.Street_Add + '</div><div>' +thisdata[i].properties.Type+'</div><div>' +thisdata[i].properties.Descriptio +'</div><img id="img_art" height="50px" width="50px" src=\"'+ thisdata[i].properties.Image+'\">';
                                break;
                            }

                        }
                        var $tooltip = $('#fullsize');
                        $('#img_art').on('mouseenter', function() {
                            var img = this,
                                $img = $(img),
                                offset = $img.offset();

                            $tooltip
                                .css({
                                    'top': offset.top,
                                    'left': offset.left
                                })
                                .append($img.clone())
                                .removeClass('hidden');
                        });

                        $tooltip.on('mouseleave', function() {
                            $tooltip.empty().addClass('hidden');
                        });

                        var infowindow = new google.maps.InfoWindow({
                            content: contentString
                        });
                        infowindow.open(map, marker);

                    });
                    marker.addListener('dblclick',function () {
                       for(i=0; i <gmarkers.length; i++){
                           gmarkers[i].setMap(null);
                       }
                        labelIndex =0;
                    });
                }


                function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                  infoWindow.setPosition(pos);
                  infoWindow.setContent(browserHasGeolocation ?
                            'Error: The Geolocation service failed.' :
                            'Error: Your browser doesn\'t support geolocation.');
                }


            });

        </script>



    </header>
    <body>


/**

@Author: Hoang Pham

*/
