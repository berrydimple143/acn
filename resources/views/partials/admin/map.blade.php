<script type="text/javascript">
(function ($) {
	var newLat = $("#latitude").val();		    			   			    
	var newLng = $("#longitude").val();		    			    
	var newZoom = $("#zoom").val(); 
	var map, pyrmont, marker, geocoder, mapLocation="";
	var infowindow = new google.maps.InfoWindow();	
	newLat = parseFloat(newLat);
	newLng = parseFloat(newLng);
	newZoom = parseInt(newZoom);
	drawMap(newLat, newLng, newZoom);
	function drawMap(latitude, longitude, zoom) {		
		geocoder = new google.maps.Geocoder();     
		pyrmont = new google.maps.LatLng(latitude, longitude);
		map = new google.maps.Map(document.getElementById("ad-map"), {
			center: pyrmont,
			zoom: zoom,
			mapTypeId: google.maps.MapTypeId.HYBRID,
			maxZoom: 30		
		}); 

		geocoder.geocode({'latLng': pyrmont}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[1]) {		        
					marker = new google.maps.Marker({
						position: pyrmont,
						map: map,
						draggable: true,
						icon: "{{ asset('images/redshadarrow.png') }}"
					});

					changeCoordinates(results[1].formatted_address);
					infowindow.setContent(results[1].formatted_address);
					infowindow.open(map, marker);

					google.maps.event.addListener(marker, 'dragend', function() {					
						changeCoordinates(results[1].formatted_address);
						infowindow.setContent(results[1].formatted_address);
						infowindow.open(map, this);
						setTimeout(function(){
							drawMap(newLat, newLng, newZoom);	
						}, 3000);													
					});

					google.maps.event.addListener(marker, 'drag', function() {					
						changeCoordinates(results[1].formatted_address);															
					});	

				} else {
					console.log('No location results found - Try refreshing the page');
					changeCoordinates(mapLocation);
					drawMap(newLat, newLng, newZoom);
				}
			} else {
				console.log('Geocoder failed due to: ' + status);
			}
		});		
		panoramaView();
	}
	function searchPlace(latitude, longitude, zoom, address) {		
		geocoder = new google.maps.Geocoder();
		pyrmont = new google.maps.LatLng(latitude, longitude);
		map = new google.maps.Map(document.getElementById("ad-map"), {
			center: pyrmont,
			zoom: zoom,
			mapTypeId: google.maps.MapTypeId.HYBRID,
			maxZoom: 30		
		});	
		geocoder.geocode({ 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				marker = new google.maps.Marker({
					map: map,
					draggable: true,
					icon: "{{ asset('images/redshadarrow.png') }}",
					position: results[0].geometry.location
				});

				changeCoordinates(results[0].formatted_address);

				google.maps.event.addListener(marker, 'dragend', function() {					
					changeCoordinates(results[0].formatted_address);
					infowindow.setContent(results[0].formatted_address);
					infowindow.open(map, this);
					setTimeout(function(){
						drawMap(newLat, newLng, newZoom);	
					}, 3000);													
				});		

				google.maps.event.addListener(marker, 'drag', function() {					
					changeCoordinates(results[0].formatted_address);															
				});	

			} else {
				console.log('Geocode was not successful for the following reason: ' + status);
			}
		});
		panoramaView();
	}
	function panoramaView(){		
		var panoramaOptions = {
			position: pyrmont,
			pov: {
				heading: 34,
				pitch: 10
			}
		};
		var panorama = new google.maps.StreetViewPanorama(document.getElementById("pip-pano"), panoramaOptions);
		map.setStreetView(panorama);
	}
	function changeCoordinates(loc) {		
		newLat = marker.getPosition().lat();
		newLng = marker.getPosition().lng();
		newZoom = map.getZoom();			
		$("#latitude").val(newLat);
		$("#longitude").val(newLng);
		$("#zoom").val(newZoom);		
		$("#location_map").val(loc);				
	}
	$("#search").click(function() {		
		var word = $("#search-input").val() + "";		
		if(word == "") { 
			alert("Please provide a location to search!");
			$("#search-input").focus();
		} else { 
			searchPlace(newLat, newLng, newZoom, word); 
		}
	});
	$("#searchCoord").click(function() {
		var latitude = $("#latitude").val() + "";
		var longitude = $("#longitude").val() + "";
		var zoom = $("#zoom").val() + "";
		if(latitude == "") {
			alert("Please provide a latitude!");
			$("#latitude").focus();
		} else if(longitude == "") {
			alert("Please provide a longitude!");
			$("#longitude").focus();
		} else if(zoom == "") {
			alert("Please provide a zoom level!");
			$("#zoom").focus();
		} else {
			var zm = parseInt(zoom); 
			drawMap(latitude, longitude, zm);	 
		}
	});
})(jQuery);
</script>