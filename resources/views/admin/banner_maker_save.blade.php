@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">    
    <h3 class="box-title text-green text-center"><i class="fa fa-flag"></i> Banner Creator</h3>   
  </div>
  <div class="panel-body">
	<form class="form-horizontal row-fluid" id="banner-form" enctype="multipart/form-data">
		<input type="hidden" name="filename" id="filename" value="{{ $filename }}">
		<input type="hidden" name="url" id="url" value="{{ $url }}">
		<input type="hidden" name="createUrl" id="createUrl" value="{{ $createUrl }}">
		<input type="hidden" name="bannersRoute" id="bannersRoute" value="{{ $bannersRoute }}">
		<input type="hidden" name="csrf" id="csrf" value="{{ $csrf }}">
		<input type="hidden" name="mtype" id="mtype" value="{{ $mtype }}">		
		<div class="row">			    	
			<div class="col-sm-2" id="mainControls">
				<a class="btn btn-primary btn-app-banner btn-app-popup" id="btext" data-toggle="popover" title="Tip" data-content="Add a text"><i class="fa fa-text-width"></i></a>
				<a class="btn btn-primary btn-app-banner btn-app-popup" id="bcircle" data-toggle="popover" title="Tip" data-content="Add a circle"><i class="fa fa-circle-o"></i></a>
				<a class="btn btn-primary btn-app-banner btn-app-popup" id="bbox" data-toggle="popover" title="Tip" data-content="Add a square or a rectangle"><i class="fa fa-square"></i></a>
				<a class="btn btn-primary btn-app-banner btn-app-popup" id="btriangle" data-toggle="popover" title="Tip" data-content="Add a triangle"><i class="fa fa-exclamation-triangle"></i></a>
				<a class="btn btn-primary btn-app-banner btn-app-popup" id="bImage" data-toggle="popover" title="Tip" data-content="Add an image"><i class="fa fa-image"></i></a>
				<a class="btn btn-primary btn-app-banner btn-app-popup" id="editBG" data-toggle="popover" title="Tip" data-content="Edit background"><i class="fa fa-gears"></i></a>
			</div>
			<div class="col-sm-10">										
				<canvas width="600" height="314" name="bannerImage" id="bannerImage"></canvas>
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">			
			<div class="col-sm-12" id="toolbar">				
					<div id="textControls">
						<div id="control1">
							Text: <input type="text" id="text" value="Change Me!">
							Fill Color Type: 
							<select id="colorType">
								<option value="">Select</option>
								<option value="linear">Normal</option>
								<option value="gradient">Gradient</option>
							</select>
							<span id="simpleColor">
								Color: <input type="text" maxlength="6" size="6" id="color" value="00ff00" />
							</span>
							<span id="gradientColor">
								Start Color: <input type="text" maxlength="6" size="6" id="color1" value="00ff00" />
								End Color: <input type="text" maxlength="6" size="6" id="color2" value="00ff00" />
							</span>
						</div>
						<div><hr style="color: #555; margin: 2px 0px;" /></div>
						<div id="control2">
							Border: <input id="stroke" style="height: 25px;" size="2" value="0">
							Border Color Type: 
							<select id="bcolorType">
								<option value="">Select</option>
								<option value="linear">Normal</option>
								<option value="gradient">Gradient</option>
							</select>
							<span id="simpleBorder">
								Color: <input type="text" maxlength="6" size="6" id="color3" value="00ff00" />
							</span>
							<span id="gradientBorder">
								Start Color: <input type="text" maxlength="6" size="6" id="color4" value="00ff00" />
								End Color: <input type="text" maxlength="6" size="6" id="color5" value="00ff00" />
							</span>							
						</div>
						<div><hr style="color: #555; margin: 2px 0px;" /></div>
						<div id="control3">								
							Shadow Color: <input type="text" maxlength="6" size="6" id="shadowColor" value="000000" />
							Shadow Blur: <input id="shadowBlur" style="height: 25px;" size="2" value="12">
							Offset X: <input id="shadowOffsetX" style="height: 25px;" size="2" value="12">
							Offset Y: <input id="shadowOffsetY" style="height: 25px;" size="2" value="12">							
						</div>
						<div><hr style="color: #555; margin: 2px 0px;" /></div>
						<div id="control4">
							Font: <input id="fontfamily" type="text" style="height: 25px;">
							Font Size: <input id="fontsize" style="height: 25px;" size="2" value="12">
							Opacity: <input id="textOpacity" style="height: 25px;" size="2" value="1">
							<button type="button" id="saveText" class="btn btn-success" title="Save"><i class="fa fa-save"></i> Save</button>
							<button type="button" id="backButton" class="btn btn-warning" title="Back"><i class="fa fa-undo"></i> Back</button>
						</div>
					</div>
					<div id="circleControls">						
						<div id="control1">
							Border: <input id="circleStroke" style="height: 25px;" size="2" value="0">
							Border Color Type: 
							<select id="circleBColorType">
								<option value="">Select</option>
								<option value="linear">Normal</option>
								<option value="gradient">Gradient</option>
							</select>
							<span id="circleSimpleBorder">
								Color: <input type="text" maxlength="6" size="6" id="CBColor1" value="00ff00" />
							</span>
							<span id="circleGradientBorder">
								Start Color: <input type="text" maxlength="6" size="6" id="CBColor2" value="00ff00" />
								End Color: <input type="text" maxlength="6" size="6" id="CBColor3" value="00ff00" />
							</span>							
						</div>
						<div><hr style="color: #555; margin: 2px 0px;" /></div>
						<div id="control2">								
							Shadow Color: <input type="text" maxlength="6" size="6" id="circleShadowColor" value="000000" />
							Shadow Blur: <input id="circleShadowBlur" style="height: 25px;" size="2" value="12">
							Offset X: <input id="circleShadowOffsetX" style="height: 25px;" size="2" value="12">
							Offset Y: <input id="circleShadowOffsetY" style="height: 25px;" size="2" value="12">							
						</div>
						<div><hr style="color: #555; margin: 2px 0px;" /></div>
						<div id="control3">							
							Fill Color Type: 
							<select id="circleColorType">
								<option value="">Select</option>
								<option value="linear">Normal</option>
								<option value="gradient">Gradient</option>
							</select>
							<span id="circleSimpleColor">
								Color: <input type="text" maxlength="6" size="6" id="CFColor1" value="00ff00" />
							</span>
							<span id="circleGradientColor">
								Start Color: <input type="text" maxlength="6" size="6" id="CFColor2" value="00ff00" />
								End Color: <input type="text" maxlength="6" size="6" id="CFColor3" value="00ff00" />
							</span>
							Opacity: <input id="circleOpacity" style="height: 25px;" size="2" value="1">
							<button type="button" id="saveCircle" class="btn btn-success" title="Save"><i class="fa fa-save"></i> Save</button>
							<button type="button" id="backButton2" class="btn btn-warning" title="Back"><i class="fa fa-undo"></i> Back</button>
						</div>
					</div>
					<div id="boxControls">
						<div id="control1">
							Border: <input id="boxStroke" style="height: 25px;" size="2" value="0">
							Border Color Type: 
							<select id="boxBColorType">
								<option value="">Select</option>
								<option value="linear">Normal</option>
								<option value="gradient">Gradient</option>
							</select>
							<span id="boxSimpleBorder">
								Color: <input type="text" maxlength="6" size="6" id="BBColor1" value="00ff00" />
							</span>
							<span id="boxGradientBorder">
								Start Color: <input type="text" maxlength="6" size="6" id="BBColor2" value="00ff00" />
								End Color: <input type="text" maxlength="6" size="6" id="BBColor3" value="00ff00" />
							</span>							
						</div>
						<div><hr style="color: #555; margin: 2px 0px;" /></div>
						<div id="control2">								
							Shadow Color: <input type="text" maxlength="6" size="6" id="boxShadowColor" value="000000" />
							Shadow Blur: <input id="boxShadowBlur" style="height: 25px;" size="2" value="12">
							Offset X: <input id="boxShadowOffsetX" style="height: 25px;" size="2" value="12">
							Offset Y: <input id="boxShadowOffsetY" style="height: 25px;" size="2" value="12">							
						</div>
						<div><hr style="color: #555; margin: 2px 0px;" /></div>
						<div id="control3">							
							Fill Color Type: 
							<select id="boxColorType">
								<option value="">Select</option>
								<option value="linear">Normal</option>
								<option value="gradient">Gradient</option>
							</select>
							<span id="boxSimpleColor">
								Color: <input type="text" maxlength="6" size="6" id="BFColor1" value="00ff00" />
							</span>
							<span id="boxGradientColor">
								Start Color: <input type="text" maxlength="6" size="6" id="BFColor2" value="00ff00" />
								End Color: <input type="text" maxlength="6" size="6" id="BFColor3" value="00ff00" />
							</span>
							Opacity: <input id="boxOpacity" style="height: 25px;" size="2" value="1">
							<button type="button" id="saveBox" class="btn btn-success" title="Save"><i class="fa fa-save"></i> Save</button>
							<button type="button" id="backButton3" class="btn btn-warning" title="Back"><i class="fa fa-undo"></i> Back</button>
						</div>
					</div>	
					<div id="triangleControls">
						<div id="control1">
							Border: <input id="triangleStroke" style="height: 25px;" size="2" value="0">
							Border Color Type: 
							<select id="triangleBColorType">
								<option value="">Select</option>
								<option value="linear">Normal</option>
								<option value="gradient">Gradient</option>
							</select>
							<span id="triangleSimpleBorder">
								Color: <input type="text" maxlength="6" size="6" id="TBColor1" value="00ff00" />
							</span>
							<span id="triangleGradientBorder">
								Start Color: <input type="text" maxlength="6" size="6" id="TBColor2" value="00ff00" />
								End Color: <input type="text" maxlength="6" size="6" id="TBColor3" value="00ff00" />
							</span>							
						</div>
						<div><hr style="color: #555; margin: 2px 0px;" /></div>
						<div id="control2">								
							Shadow Color: <input type="text" maxlength="6" size="6" id="triangleShadowColor" value="000000" />
							Shadow Blur: <input id="triangleShadowBlur" style="height: 25px;" size="2" value="12">
							Offset X: <input id="triangleShadowOffsetX" style="height: 25px;" size="2" value="12">
							Offset Y: <input id="triangleShadowOffsetY" style="height: 25px;" size="2" value="12">							
						</div>
						<div><hr style="color: #555; margin: 2px 0px;" /></div>
						<div id="control3">							
							Fill Color Type: 
							<select id="triangleColorType">
								<option value="">Select</option>
								<option value="linear">Normal</option>
								<option value="gradient">Gradient</option>
							</select>
							<span id="triangleSimpleColor">
								Color: <input type="text" maxlength="6" size="6" id="TFColor1" value="00ff00" />
							</span>
							<span id="triangleGradientColor">
								Start Color: <input type="text" maxlength="6" size="6" id="TFColor2" value="00ff00" />
								End Color: <input type="text" maxlength="6" size="6" id="TFColor3" value="00ff00" />
							</span>
							Opacity: <input id="triangleOpacity" style="height: 25px;" size="2" value="1">
							<button type="button" id="saveTriangle" class="btn btn-success" title="Save"><i class="fa fa-save"></i> Save</button>
							<button type="button" id="backButton4" class="btn btn-warning" title="Back"><i class="fa fa-undo"></i> Back</button>
						</div>
					</div>
					<div id="bgControls">						
						<div id="control1">							
							Color Type: 
							<select id="bgColorType">
								<option value="">Select</option>
								<option value="linear">Normal</option>
								<option value="gradient">Gradient</option>
							</select>
							<span id="bgSimpleColor">
								Color: <input type="text" maxlength="6" size="6" id="BGColor1" value="00ff00" />
							</span>
							<span id="bgGradientColor">
								Start Color: <input type="text" maxlength="6" size="6" id="BGColor2" value="00ff00" />
								End Color: <input type="text" maxlength="6" size="6" id="BGColor3" value="00ff00" />
							</span>
							Opacity: <input id="bgOpacity" style="height: 25px;" size="2" value="1">
							<button type="button" id="saveBG" class="btn btn-success" title="Save"><i class="fa fa-save"></i> Save</button>
							<button type="button" id="backButton5" class="btn btn-warning" title="Back"><i class="fa fa-undo"></i> Back</button>
						</div>
					</div>
					<div id="imageControls">						
						<div id="imageUploadButton">			
							<input type="file" id="file" style="display: none"/>														
							<a id="beginImageUpload" class="btn btn-warning" style="text-decoration: none;"><i class="fa fa-upload"></i> Upload Image</a>	
							<button type="button" id="backButton6" class="btn btn-warning" title="Back"><i class="fa fa-undo"></i> Back</button>
						</div>
						<div id="imageEffects">
							<p class="ui-state-default ui-corner-all" style="padding:4px;margin-top:4em;">
							  <span class="ui-icon ui-icon-signal" style="float:left; margin:-2px 5px 0 0;"></span>
							  Image Effects &nbsp;<button type="button" id="saveImage" class="btn btn-success btn-xs" title="Save"><i class="fa fa-save"></i> Save Changes</button>
							  <span class="pull-right">
								<span class="badge bg-red">Brightness</span>								
								<span class="badge bg-yellow">Contrast</span>								
								<span class="badge bg-blue">Hue</span>								
								<span class="badge bg-maroon">Saturation</span>
								<span class="badge bg-black">Noise</span>
								<span class="badge bg-green">Pixelate</span>								
							  </span>
							</p>							 
							<div id="eq">
							  <span id="brightness"></span>							  
							  <span id="contrast"></span>							  
							  <span id="hue"></span>
							  <span id="saturation"></span>
							  <span id="noise"></span>
							  <span id="pixelate"></span>										  							  
							  <span>
									<form>
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="blackwhite"> Black/White
											</label>
										</div>
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="sepia"> Sepia
											</label>
										</div>
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="invert"> Invert
											</label>
										</div>
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="brownie"> Brownie
											</label>
										</div>										
									</form>
								</span>
								<span>
									<form>										
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="vintage"> Vintage
											</label>
										</div>
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="kodachrome"> Kodachrome
											</label>
										</div>
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="technicolor"> Technicolor
											</label>
										</div>
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="polaroid"> Polaroid
											</label>
										</div>
									</form>
								</span>
								<span>
									<form>		
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="sharpen"> Sharpen
											</label>
										</div>
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="emboss"> Emboss
											</label>
										</div>	
										<div class="checkbox">
											<label>
											  <input type="checkbox" id="grayscale"> Grayscale
											</label>
										</div>
									</form>
								</span>
							</div>
						</div>
					</div>
			</div>			
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">			    	
			<div class="col-sm-12">
				<button type="button" id="createBanner" class="btn btn-success"><i class="fa fa-save"></i> Create</button>
				<a href="{{ route('banners') }}" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Cancel</a>
			</div>
		</div>	
	</form>
  </div> 
</div>
<style>
	#eq > span { height:120px; float:left; margin:15px; }
	#brightness .ui-slider-range { background: #dd4b39; }
	#brightness .ui-slider-handle { border-color: #dd4b39; }	
	#contrast .ui-slider-range { background: #f39c12; }
	#contrast .ui-slider-handle { border-color: #f39c12; }		
	#hue .ui-slider-range { background: #0073b7; }
	#hue .ui-slider-handle { border-color: #0073b7; }
	#noise .ui-slider-range { background: #111111; }
	#noise .ui-slider-handle { border-color: #111111; }	
	#pixelate .ui-slider-range { background: #00a65a; }
	#pixelate .ui-slider-handle { border-color: #00a65a; }
	#removecolor .ui-slider-range { background: #f012be; }
	#removecolor .ui-slider-handle { border-color: #f012be; }
	#saturation .ui-slider-range { background: #d81b60; }
	#saturation .ui-slider-handle { border-color: #d81b60; }	
	#control1, #control2, #control3, #control4, #imageEffects, #imageUploadButton { margin: 3px; }		
	#toolbar {
	  background-image: linear-gradient(#2C3539, #0C090A);
	  border: 1px solid #aaaaaa;	 
	  padding: 2px;
	}
	#textControls, #circleControls, #boxControls, #triangleControls, #bgControls, #imageControls { color: #ffffff; }
	#toolbar input, #toolbar select { color: #000000; height: 30px; }		
</style>
@endsection