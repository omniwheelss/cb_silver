	<style>.count {color:#ffffff;}</style>
	<div class="">
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats" style="background-color: green;">
                  <div class="icon" style="color: #ffffff"><i class="fa fa-car"></i></div>
                  <div class="count">4</div>
                  <h3>Active Vehicles</h3>
                  <p>Total devices associated with us.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats" style="background-color: red;">
                  <div class="icon" style="color: #ffffff"><i class="fa fa-road"></i></div>
                  <div class="count">2</div>
                  <h3>Stopped Vehicles</h3>
                  <p>Total devices associated with us.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats" style="background-color: orange;">
                  <div class="icon" style="color: #ffffff"><i class="fa fa-tachometer"></i></div>
                  <div class="count">1</div>
                  <h3>Idle Vehicles</h3>
                  <p>Total devices associated with us.</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats" style="background-color: grey;">
                  <div class="icon" style="color: #ffffff"><i class="fa fa-truck"></i></div>
                  <div class="count">1</div>
                  <h3>Problem Vehicles</h3>
                  <p>Total devices associated with us.</p>
                </div>
              </div>
            </div>

			
		<!-- ---------------Row 2 start ----------------------------- -->			

		

			<table id="dashboard_table" class="table table-striped table-bordered">
			  <thead>
				<tr>
				  <th>Name</th>
				  <th>Position</th>
				  <th>Office</th>
				  <th>Age</th>
				  <th>Start date</th>
				  <th>Salary</th>
				</tr>
			  </thead>


			  <tbody>
				<tr>
				  <td>Tiger Nixon</td>
				  <td>System Architect</td>
				  <td>Edinburgh</td>
				  <td>61</td>
				  <td>2011/04/25</td>
				  <td>$320,800</td>
				</tr>
				<tr>
				  <td>Garrett Winters</td>
				  <td>Accountant</td>
				  <td>Tokyo</td>
				  <td>63</td>
				  <td>2011/07/25</td>
				  <td>$170,750</td>
				</tr>
				<tr>
				  <td>Ashton Cox</td>
				  <td>Junior Technical Author</td>
				  <td>San Francisco</td>
				  <td>66</td>
				  <td>2009/01/12</td>
				  <td>$86,000</td>
				</tr>
				<tr>
				  <td>Cedric Kelly</td>
				  <td>Senior Javascript Developer</td>
				  <td>Edinburgh</td>
				  <td>22</td>
				  <td>2012/03/29</td>
				  <td>$433,060</td>
				</tr>
				<tr>
				  <td>Airi Satou</td>
				  <td>Accountant</td>
				  <td>Tokyo</td>
				  <td>33</td>
				  <td>2008/11/28</td>
				  <td>$162,700</td>
				</tr>
				<tr>
				  <td>Brielle Williamson</td>
				  <td>Integration Specialist</td>
				  <td>New York</td>
				  <td>61</td>
				  <td>2012/12/02</td>
				  <td>$372,000</td>
				</tr>
				<tr>
				  <td>Herrod Chandler</td>
				  <td>Sales Assistant</td>
				  <td>San Francisco</td>
				  <td>59</td>
				  <td>2012/08/06</td>
				  <td>$137,500</td>
				</tr>
				<tr>
				  <td>Rhona Davidson</td>
				  <td>Integration Specialist</td>
				  <td>Tokyo</td>
				  <td>55</td>
				  <td>2010/10/14</td>
				  <td>$327,900</td>
				</tr>
				<tr>
				  <td>Colleen Hurst</td>
				  <td>Javascript Developer</td>
				  <td>San Francisco</td>
				  <td>39</td>
				  <td>2009/09/15</td>
				  <td>$205,500</td>
				</tr>
				<tr>
				  <td>Sonya Frost</td>
				  <td>Software Engineer</td>
				  <td>Edinburgh</td>
				  <td>23</td>
				  <td>2008/12/13</td>
				  <td>$103,600</td>
				</tr>
				<tr>
				  <td>Jena Gaines</td>
				  <td>Office Manager</td>
				  <td>London</td>
				  <td>30</td>
				  <td>2008/12/19</td>
				  <td>$90,560</td>
				</tr>
				<tr>
				  <td>Quinn Flynn</td>
				  <td>Support Lead</td>
				  <td>Edinburgh</td>
				  <td>22</td>
				  <td>2013/03/03</td>
				  <td>$342,000</td>
				</tr>

			  </tbody>
			</table>
			
			
		<!-- ---------------Row 2 end ----------------------------- -->					
		
		<!-- ---------------Row 3 start ----------------------------- -->			

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
			
				<script type="text/javascript">
					
					function initialize() {
						var message;
					  var mapOptions = {
						zoom: 10,
						center: new google.maps.LatLng(13.1895533, 78.7309217)
					  };

					  var map = new google.maps.Map(document.getElementById('map'),
						  mapOptions);
							  // Add 5 markers to the map at random locations
						var position = new google.maps.LatLng(
							11.9990850,
							79.1053867);
						var marker = new google.maps.Marker({
						  position: position,
						  map: map
						});
						marker.setIcon('./img/map_icons/bus3.png');
						marker.setTitle((0 + 1).toString());
						attachSecretMessage(marker, 0);
						  // Add 5 markers to the map at random locations
						var position = new google.maps.LatLng(
							12.0851933,
							78.7309217);
						var marker = new google.maps.Marker({
						  position: position,
						  map: map
						});
						marker.setIcon('./img/map_icons/bus3.png');
						marker.setTitle((1 + 1).toString());
						attachSecretMessage(marker, 1);
						  // Add 5 markers to the map at random locations
						var position = new google.maps.LatLng(
							12.0783467,
							79.2148283);
						var marker = new google.maps.Marker({
						  position: position,
						  map: map
						});
						marker.setIcon('./img/map_icons/bus3.png');
						marker.setTitle((2 + 1).toString());
						attachSecretMessage(marker, 2);
						  // Add 5 markers to the map at random locations
						var position = new google.maps.LatLng(
							13.1894033,
							80.2307900);
						var marker = new google.maps.Marker({
						  position: position,
						  map: map
						});
						marker.setIcon('./img/map_icons/bus3.png');
						marker.setTitle((3 + 1).toString());
						attachSecretMessage(marker, 3);
						  // Add 5 markers to the map at random locations
						var position = new google.maps.LatLng(
							13.1279467,
							80.2990600);
						var marker = new google.maps.Marker({
						  position: position,
						  map: map
						});
						marker.setIcon('./img/map_icons/bus3.png');
						marker.setTitle((4 + 1).toString());
						attachSecretMessage(marker, 4);
						  // Add 5 markers to the map at random locations
						var position = new google.maps.LatLng(
							13.1895533,
							80.2310167);
						var marker = new google.maps.Marker({
						  position: position,
						  map: map
						});
						marker.setIcon('./img/map_icons/bus3.png');
						marker.setTitle((5 + 1).toString());
						attachSecretMessage(marker, 5);
						  // Add 5 markers to the map at random locations
						var position = new google.maps.LatLng(
							13.1894717,
							80.2308583);
						var marker = new google.maps.Marker({
						  position: position,
						  map: map
						});
						marker.setIcon('./img/map_icons/bus3.png');
						marker.setTitle((6 + 1).toString());
						attachSecretMessage(marker, 6);
											
					}

					// The five markers show a secret message when clicked
					// but that message is not within the marker's instance data
					function attachSecretMessage(marker, num) {
					  var message = ['<div><table cellpadding="5" cellspacing="5" border="0"><tr><td align="left" valign="top" colspan="2" style="color:red;"><b>Current Location Info</b></td></tr><tr><td align="left" valign="top" width="90px"><b>Vehicle</b></td><td>Route 10</td></tr><tr><td align="left" valign="top" width="90px"><b>Date & Time</b></td><td align="left" valign="top">21-Feb-2018 11:23pm</td></tr><tr><td align="left" valign="top"><b>Location</b></td><td align="left" valign="top">Tiruvannamalai-Tirukkovilur Road  Manalurpettai  Tamil Nadu 605754  India</td></tr></table></div>','<div><table cellpadding="5" cellspacing="5" border="0"><tr><td align="left" valign="top" colspan="2" style="color:red;"><b>Current Location Info</b></td></tr><tr><td align="left" valign="top" width="90px"><b>Vehicle</b></td><td>Route 2</td></tr><tr><td align="left" valign="top" width="90px"><b>Date & Time</b></td><td align="left" valign="top">21-Feb-2018 11:25pm</td></tr><tr><td align="left" valign="top"><b>Location</b></td><td align="left" valign="top">Murugan Temple St  Mothakkal  Tamil Nadu 606708  India</td></tr></table></div>','<div><table cellpadding="5" cellspacing="5" border="0"><tr><td align="left" valign="top" colspan="2" style="color:red;"><b>Current Location Info</b></td></tr><tr><td align="left" valign="top" width="90px"><b>Vehicle</b></td><td>Route 17</td></tr><tr><td align="left" valign="top" width="90px"><b>Date & Time</b></td><td align="left" valign="top">21-Feb-2018 11:23pm</td></tr><tr><td align="left" valign="top"><b>Location</b></td><td align="left" valign="top">Naraiyur Agaram Rd  Agaram  Tamil Nadu 606754  India</td></tr></table></div>','<div><table cellpadding="5" cellspacing="5" border="0"><tr><td align="left" valign="top" colspan="2" style="color:red;"><b>Current Location Info</b></td></tr><tr><td align="left" valign="top" width="90px"><b>Vehicle</b></td><td>TN 12 Q 0769</td></tr><tr><td align="left" valign="top" width="90px"><b>Date & Time</b></td><td align="left" valign="top">21-Feb-2018 11:25pm</td></tr><tr><td align="left" valign="top"><b>Location</b></td><td align="left" valign="top">Sendrambakkam Kosappur Road  Priya Nagar  Vilangadupakkam  Kosappur  Chennai  Tamil Nadu 600052  India</td></tr></table></div>','<div><table cellpadding="5" cellspacing="5" border="0"><tr><td align="left" valign="top" colspan="2" style="color:red;"><b>Current Location Info</b></td></tr><tr><td align="left" valign="top" width="90px"><b>Vehicle</b></td><td>Boat-Demo</td></tr><tr><td align="left" valign="top" width="90px"><b>Date & Time</b></td><td align="left" valign="top">19-Jan-2018 10:21am</td></tr><tr><td align="left" valign="top"><b>Location</b></td><td align="left" valign="top">Unnamed Road  Tamil Nadu 600013  India</td></tr></table></div>','<div><table cellpadding="5" cellspacing="5" border="0"><tr><td align="left" valign="top" colspan="2" style="color:red;"><b>Current Location Info</b></td></tr><tr><td align="left" valign="top" width="90px"><b>Vehicle</b></td><td>TN 13 D 7872</td></tr><tr><td align="left" valign="top" width="90px"><b>Date & Time</b></td><td align="left" valign="top">21-Feb-2018 11:22pm</td></tr><tr><td align="left" valign="top"><b>Location</b></td><td align="left" valign="top">Sendrambakkam Kosappur Road  Priya Nagar  Vilangadupakkam  Kosappur  Chennai  Tamil Nadu 600052  India</td></tr></table></div>','<div><table cellpadding="5" cellspacing="5" border="0"><tr><td align="left" valign="top" colspan="2" style="color:red;"><b>Current Location Info</b></td></tr><tr><td align="left" valign="top" width="90px"><b>Vehicle</b></td><td>TN 18 R 4333</td></tr><tr><td align="left" valign="top" width="90px"><b>Date & Time</b></td><td align="left" valign="top">21-Feb-2018 11:24pm</td></tr><tr><td align="left" valign="top"><b>Location</b></td><td align="left" valign="top">Sendrambakkam Kosappur Road  Priya Nagar  Vilangadupakkam  Kosappur  Chennai  Tamil Nadu 600052  India</td></tr></table></div>'];
					  var infowindow = new google.maps.InfoWindow({
						content: message[num]
					  });

					  google.maps.event.addListener(marker, 'click', function() {
						infowindow.open(marker.get('map'), marker);
					  });
					}

					google.maps.event.addDomListener(window, 'load', initialize);

				</script>			

				<div id="map" style="height: 300px;"></div>

			
              
            </div>
		  </div>	
          
    
		<!-- ---------------Row 3 end ----------------------------- -->			

                  </div>
                </div>
              </div>
				
		</div>
		<form id="demo-form" data-parsley-validate></form>
     </div>
