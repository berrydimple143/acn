$(function() {
	var bgimghandler, canvashandler, selectedshape, grtype, activeobj, webglBackend, canvas2dBackend, f;	
	var temp_images = [];	
	var mtype = $('#mtype').val() + "";
	var filters = ['grayscale', 'invert', 'remove-color', 'sepia', 'brownie',
                      'brightness', 'contrast', 'saturation', 'noise', 'vintage',
                      'pixelate', 'blur', 'sharpen', 'emboss', 'technicolor',
                      'polaroid', 'blend-color', 'gamma', 'kodachrome',
                      'blackwhite', 'blend-image', 'hue', 'resize'];			
	var stroke = $( "#stroke" ).spinner({
      min: 0,
      max: 20,
      step: 0.1,
      start: 1,
	  spin: function(event, ui) {		
		updateText(ui.value, '', 'swidth', '');
	  }
    });
	var circleStroke = $( "#circleStroke" ).spinner({
      min: 0,
      max: 20,
      step: 0.1,
      start: 1,
	  spin: function(event, ui) {		
		updateCircle(ui.value, '', 'swidth', '');
	  }
    });
	var triangleStroke = $( "#triangleStroke" ).spinner({
      min: 0,
      max: 20,
      step: 0.1,
      start: 1,
	  spin: function(event, ui) {		
		updateTriangle(ui.value, '', 'swidth', '');
	  }
    });
	var boxStroke = $( "#boxStroke" ).spinner({
      min: 0,
      max: 20,
      step: 0.1,
      start: 1,
	  spin: function(event, ui) {		
		updateBox(ui.value, '', 'swidth', '');
	  }
    });
	var fsize = $("#fontsize").spinner({
	  min: 3,
	  max: 150,
	  step: 1,
	  start: 3,
	  spin: function(event, ui) {		
		updateText(ui.value, '', 'fsize', '');
	  }
    });	
	var textOpacity = $("#textOpacity").spinner({
	  min: 0,
	  max: 1,
	  step: 0.1,
	  start: 1,
	  spin: function(event, ui) {		
		updateText(ui.value, '', 'opacity', '');
	  }
    });	
	var circleOpacity = $("#circleOpacity").spinner({
	  min: 0,
	  max: 1,
	  step: 0.1,
	  start: 1,
	  spin: function(event, ui) {		
		updateCircle(ui.value, '', 'opacity', '');
	  }
    });	
	var boxOpacity = $("#boxOpacity").spinner({
	  min: 0,
	  max: 1,
	  step: 0.1,
	  start: 1,
	  spin: function(event, ui) {		
		updateBox(ui.value, '', 'opacity', '');
	  }
    });	
	var triangleOpacity = $("#triangleOpacity").spinner({
	  min: 0,
	  max: 1,
	  step: 0.1,
	  start: 1,
	  spin: function(event, ui) {		
		updateTriangle(ui.value, '', 'opacity', '');
	  }
    });
	var bgOpacity = $("#bgOpacity").spinner({
	  min: 0,
	  max: 1,
	  step: 0.1,
	  start: 1,
	  spin: function(event, ui) {		
		updateBG(ui.value, '', 'opacity', '');
	  }
    });	
	var shadowBlur = $("#shadowBlur").spinner({
	  min: 0,
	  max: 100,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateText(ui.value, '', 'sblur', '');
	  }
    });	
	var shadowOffsetX = $("#shadowOffsetX").spinner({
	  min: -180,
	  max: 180,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateText(ui.value, '', 'offsetX', '');
	  }
    });
	var shadowOffsetY = $("#shadowOffsetY").spinner({
	  min: -180,
	  max: 180,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateText(ui.value, '', 'offsetY', '');
	  }
    });	
	
	var circleShadowBlur = $("#circleShadowBlur").spinner({
	  min: 0,
	  max: 100,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateCircle(ui.value, '', 'sblur', '');
	  }
    });	
	var circleShadowOffsetX = $("#circleShadowOffsetX").spinner({
	  min: -180,
	  max: 180,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateCircle(ui.value, '', 'offsetX', '');
	  }
    });
	var circleShadowOffsetY = $("#circleShadowOffsetY").spinner({
	  min: -180,
	  max: 180,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateCircle(ui.value, '', 'offsetY', '');
	  }
    });		
	var boxShadowBlur = $("#boxShadowBlur").spinner({
	  min: 0,
	  max: 100,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateBox(ui.value, '', 'sblur', '');
	  }
    });	
	var boxShadowOffsetX = $("#boxShadowOffsetX").spinner({
	  min: -180,
	  max: 180,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateBox(ui.value, '', 'offsetX', '');
	  }
    });
	var boxShadowOffsetY = $("#boxShadowOffsetY").spinner({
	  min: -180,
	  max: 180,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateBox(ui.value, '', 'offsetY', '');
	  }
    });	
	
	var triangleShadowBlur = $("#triangleShadowBlur").spinner({
	  min: 0,
	  max: 100,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateTriangle(ui.value, '', 'sblur', '');
	  }
    });	
	var triangleShadowOffsetX = $("#triangleShadowOffsetX").spinner({
	  min: -180,
	  max: 180,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateTriangle(ui.value, '', 'offsetX', '');
	  }
    });
	var triangleShadowOffsetY = $("#triangleShadowOffsetY").spinner({
	  min: -180,
	  max: 180,
	  step: 1,
	  start: 0,
	  spin: function(event, ui) {		
		updateTriangle(ui.value, '', 'offsetY', '');
	  }
    });	
	$("#brightness").slider({
		value: 0.1,
		range: "min",
		min: -1,
		max: 1,
		step: 0.003921,
		animate: true,
		orientation: "vertical",
		change: function(event, ui) {			
			applyFilter(5, new f.Brightness({
			  brightness: parseFloat(ui.value)
			}));
		}
	});	
	$("#contrast").slider({
		value: 0,
		min: -1,
		max: 1,
		step: 0.003921,
		range: "min",
		animate: true,
		orientation: "vertical",
		change: function(event, ui) {			
			applyFilter(6, new f.Contrast({
			  contrast: parseFloat(ui.value)
			}));
		}
	});	
	$("#hue").slider({
		value: 0,
		min: -2,
		max: 2,
		step: 0.002,
		range: "min",
		animate: true,
		orientation: "vertical",
		change: function(event, ui) {			
			applyFilter(21, new f.HueRotation({
			  rotation: ui.value,
			}));
		}
	});
	$("#saturation").slider({
		value: 0,
		min: -1,
		max: 1,
		step: 0.003921,
		range: "min",
		animate: true,
		orientation: "vertical",
		change: function(event, ui) {				
			applyFilter(7, new f.Saturation({
			  saturation: parseFloat(ui.value)
			}));
		}
	});	
	$("#noise").slider({
		value: 100,
		min: 0,
		max: 1000,		
		range: "min",
		animate: true,
		orientation: "vertical",
		change: function(event, ui) {					
			applyFilter(8, new f.Noise({
			  noise: parseInt(ui.value, 10)
			}));
		}
	});	
	$("#pixelate").slider({
		value: 4,
		min: 0,
		max: 20,
		step: 0.003921,
		range: "min",
		animate: true,
		orientation: "vertical",
		change: function(event, ui) {				
			applyFilter(10, new f.Pixelate({
			  blocksize: parseInt(ui.value, 10)
			}));
		}
	});	
	$('#grayscale, #blackwhite, #sepia, #invert, #brownie, #vintage, #kodachrome, #technicolor, #polaroid, #sharpen, #emboss').click(function() {	
		var id = $(this).attr('id');
		var chk = $(this).prop("checked");
		if(chk) {
			if(id =="blackwhite") {
				applyFilter(19, new f.BlackWhite());
			} else if(id =="sepia") {
				applyFilter(3, new f.Sepia());
			} else if(id =="invert") {
				applyFilter(1, new f.Invert());
			} else if(id =="brownie") {
				applyFilter(4, new f.Brownie());
			} else if(id =="vintage") {
				applyFilter(9, new f.Vintage());
			} else if(id =="kodachrome") {
				applyFilter(18, new f.Kodachrome());
			} else if(id =="technicolor") {
				applyFilter(14, new f.Technicolor());
			} else if(id =="polaroid") {
				applyFilter(15, new f.Polaroid());
			} else if(id =="sharpen") {
				applyFilter(12, new f.Convolute({
				  matrix: [0, -1,  0,
							-1,  5, -1,
							 0, -1,  0]
				}));
			} else if(id =="emboss") {
				applyFilter(13, new f.Convolute({
				  matrix: [1,   1,  1,
							1, 0.7, -1,
						   -1,  -1, -1]
				}));
			} else if(id =="grayscale") {
				applyFilter(0, new f.Grayscale());
			}
		} else {
			if(id =="blackwhite") {
				deleteFilter(19);
			} else if(id =="sepia") {
				deleteFilter(3);
			} else if(id =="invert") {
				deleteFilter(1);
			} else if(id =="brownie") {
				deleteFilter(4);
			} else if(id =="vintage") {
				deleteFilter(9);
			} else if(id =="kodachrome") {
				deleteFilter(18);
			} else if(id =="technicolor") {
				deleteFilter(14);
			} else if(id =="polaroid") {
				deleteFilter(15);
			} else if(id =="sharpen") {
				deleteFilter(12);
			} else if(id =="emboss") {
				deleteFilter(13);
			} else if(id =="grayscale") {
				deleteFilter(0);
			}
		}		 
	});
	$('#fontfamily').fontselect().change(function() {	
		var font = $(this).val().replace(/\+/g, ' ');
		updateText(font, '', 'font', '');
	});
	toggleToolbarColor('default');
	toggleToolbarControls('default','');	
	toggleToolbarBColor('default');
	toggleCircleToolbarColor('default');
	toggleBoxToolbarColor('default');
	toggleCirleToolbarBColor('default');
	toggleBoxToolbarBColor('default');
	toggleBGToolbarColor('default');
	toggleTriangleToolbarBColor('default');
	toggleTriangleToolbarColor('default');
	initCanvas(mtype);	
	$('#CFColor1, #BGColor1, #BGColor2, #BGColor3, #BFColor1, #BFColor2, #BFColor3, #TFColor1, #TFColor2, #TFColor3, #TBColor1, #TBColor2, #TBColor3, #BBColor1, #BBColor2, #BBColor3, #CFColor2, #CFColor3, #color, #color1, #color2, #color3, #color4, #color5, #shadowColor, #CBColor1, #CBColor2, #CBColor3, #circleShadowColor, #boxShadowColor, #triangleShadowColor').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			var elid = $(el).attr('id');
			var val1 = hex;
			var val2 = "";
			var type = 'fill';
			if(elid == "color1" || elid == "color2") {
				if(elid == "color1") {
					var val1 = hex;
					var val2 = $("#color2").val() + "";
				} else {
					var val2 = hex;
					var val1 = $("#color1").val() + "";
				}	
			} else if(elid == "CFColor2" || elid == "CFColor3") {
				if(elid == "CFColor2") {
					var val1 = hex;
					var val2 = $("#CFColor3").val() + "";
				} else {
					var val2 = hex;
					var val1 = $("#CFColor2").val() + "";
				}
			} else if(elid == "BFColor2" || elid == "BFColor3") {
				if(elid == "BFColor2") {
					var val1 = hex;
					var val2 = $("#BFColor3").val() + "";
				} else {
					var val2 = hex;
					var val1 = $("#BFColor2").val() + "";
				}
			} else if(elid == "TFColor2" || elid == "TFColor3") {
				if(elid == "TFColor2") {
					var val1 = hex;
					var val2 = $("#TFColor3").val() + "";
				} else {
					var val2 = hex;
					var val1 = $("#TFColor2").val() + "";
				}
			} else if(elid == "BGColor2" || elid == "BGColor3") {
				if(elid == "BGColor2") {
					var val1 = hex;
					var val2 = $("#BGColor3").val() + "";
				} else {
					var val2 = hex;
					var val1 = $("#BGColor2").val() + "";
				}
			} else if(elid == "color3" || elid == "CBColor1" || elid == "BBColor1" || elid == "TBColor1") {				
				type = 'stroke';
			} else if(elid == "CBColor2" || elid == "CBColor3") {
				if(elid == "CBColor2") {
					var val1 = hex;
					var val2 = $("#CBColor3").val() + "";
				} else {
					var val2 = hex;
					var val1 = $("#CBColor2").val() + "";
				}
				type = 'stroke';
			} else if(elid == "BBColor2" || elid == "BBColor3") {
				if(elid == "BBColor2") {
					var val1 = hex;
					var val2 = $("#BBColor3").val() + "";
				} else {
					var val2 = hex;
					var val1 = $("#BBColor2").val() + "";
				}
				type = 'stroke';
			} else if(elid == "TBColor2" || elid == "TBColor3") {
				if(elid == "TBColor2") {
					var val1 = hex;
					var val2 = $("#TBColor3").val() + "";
				} else {
					var val2 = hex;
					var val1 = $("#TBColor2").val() + "";
				}
				type = 'stroke';
			} else if(elid == "color4" || elid == "color5") {
				if(elid == "color4") {
					var val1 = hex;
					var val2 = $("#color5").val() + "";
				} else {
					var val2 = hex;
					var val1 = $("#color4").val() + "";
				}
				type = 'stroke';
			} else if(elid == "shadowColor" || elid == "circleShadowColor" || elid == "boxShadowColor" || elid == "triangleShadowColor") {
				type = 'scolor';
			}
			if(elid == "color" || elid == "color1" || elid == "color2" || elid == "color3" || elid == "color4" || elid == "color5" || elid == "shadowColor") {
				updateText(val1, val2, type, elid);
			} else if(elid == "CBColor1" || elid == "CFColor1" || elid == "CFColor2" || elid == "CFColor3" || elid == "CBColor2" || elid == "CBColor3" || elid == "circleShadowColor") {
				updateCircle(val1, val2, type, elid);
			} else if(elid == "BBColor1" || elid == "BFColor1" || elid == "BFColor2" || elid == "BFColor3" || elid == "BBColor2" || elid == "BBColor3" || elid == "boxShadowColor") {
				updateBox(val1, val2, type, elid);
			} else if(elid == "TBColor1" || elid == "TFColor1" || elid == "TFColor2" || elid == "TFColor3" || elid == "TBColor2" || elid == "TBColor3" || elid == "triangleShadowColor") {
				updateTriangle(val1, val2, type, elid);
			} else if(elid == "BGColor1" || elid == "BGColor2" || elid == "BGColor3") {
				updateBG(val1, val2, type, elid);
			}			
			$(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	}).bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
	function updateBG(val, val2, mode, id) {
		if(mode == 'opacity') {
			bgimghandler.set(mode, val);				
		} else if(mode == 'fill' && id == "BGColor1") {
			val = '#' + val;
			bgimghandler.set('fill', val);
		} else if(mode == 'fill' && (id == "BGColor2" || id == "BGColor3")) {
			val = '#' + val;
			val2 = '#' + val2;
			bgimghandler.setGradient('fill', {
			  type: 'linear',
			  x1: 0,
			  y1: bgimghandler.height / 2,
			  x2: bgimghandler.width,
			  y2: bgimghandler.height / 2,
			  colorStops: {
				0: val,				
				1: val2
			  }
			});	
		}		
		canvashandler.renderAll();		
	}
	function updateTriangle(val, val2, mode, id) {
		if(mode == 'swidth') {
			activeobj.set('strokeWidth', val);
		} else if(mode == 'opacity') {
			activeobj.set(mode, val);
		} else if(mode == 'scolor') {
			val = '#' + val;
			var bl = triangleShadowBlur.spinner('value');
			var fx = triangleShadowOffsetX.spinner('value');
			var fy = triangleShadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: val,
				blur: bl,
				offsetX: fx,
				offsetY: fy
			});
		} else if(mode == 'sblur') {			
			var col = '#' + $('#triangleShadowColor').val() + "";			
			var fx = triangleShadowOffsetX.spinner('value');
			var fy = triangleShadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: col,
				blur: val,
				offsetX: fx,
				offsetY: fy
			});
		} else if(mode == 'offsetX') {			
			var col = '#' + $('#triangleShadowColor').val() + "";
			var bl = triangleShadowBlur.spinner('value');			
			var fy = triangleShadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: col,
				blur: bl,
				offsetX: val,
				offsetY: fy
			});
		} else if(mode == 'offsetY') {			
			var col = '#' + $('#triangleShadowColor').val() + "";
			var bl = triangleShadowBlur.spinner('value');
			var fx = triangleShadowOffsetX.spinner('value');			
			activeobj.setShadow({
				color: col,
				blur: bl,
				offsetX: fx,
				offsetY: val
			});		
		} else if(mode == 'fill' && id == "TFColor1") {
			val = '#' + val;
			activeobj.set('fill', val);
		} else if(mode == 'fill' && (id == "TFColor2" || id == "TFColor3")) {
			val = '#' + val;
			val2 = '#' + val2;
			activeobj.setGradient('fill', {
			  type: 'linear',
			  x1: 0,
			  y1: activeobj.height / 2,
			  x2: activeobj.width,
			  y2: activeobj.height / 2,
			  colorStops: {
				0: val,				
				1: val2
			  }
			});
		} else if(mode == 'stroke' && id == "TBColor1") {
			val = '#' + val;
			activeobj.set('stroke', val);		
		} else if(mode == 'stroke' && (id == "TBColor2" || id == "TBColor3")) {
			val = '#' + val;
			val2 = '#' + val2;
			activeobj.setGradient('stroke', {
			  type: 'linear',
			  x1: 0,
			  y1: activeobj.height / 2,
			  x2: activeobj.width,
			  y2: activeobj.height / 2,
			  colorStops: {
				0: val,				
				1: val2
			  }
			});
		}		
		canvashandler.renderAll();		
	}
	function updateBox(val, val2, mode, id) {
		if(mode == 'swidth') {
			activeobj.set('strokeWidth', val);
		} else if(mode == 'opacity') {
			activeobj.set(mode, val);
		} else if(mode == 'scolor') {
			val = '#' + val;
			var bl = boxShadowBlur.spinner('value');
			var fx = boxShadowOffsetX.spinner('value');
			var fy = boxShadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: val,
				blur: bl,
				offsetX: fx,
				offsetY: fy
			});
		} else if(mode == 'sblur') {			
			var col = '#' + $('#boxShadowColor').val() + "";			
			var fx = boxShadowOffsetX.spinner('value');
			var fy = boxShadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: col,
				blur: val,
				offsetX: fx,
				offsetY: fy
			});
		} else if(mode == 'offsetX') {			
			var col = '#' + $('#boxShadowColor').val() + "";
			var bl = boxShadowBlur.spinner('value');			
			var fy = boxShadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: col,
				blur: bl,
				offsetX: val,
				offsetY: fy
			});
		} else if(mode == 'offsetY') {			
			var col = '#' + $('#boxShadowColor').val() + "";
			var bl = boxShadowBlur.spinner('value');
			var fx = boxShadowOffsetX.spinner('value');			
			activeobj.setShadow({
				color: col,
				blur: bl,
				offsetX: fx,
				offsetY: val
			});		
		} else if(mode == 'fill' && id == "BFColor1") {
			val = '#' + val;
			activeobj.set('fill', val);
		} else if(mode == 'fill' && (id == "BFColor2" || id == "BFColor3")) {
			val = '#' + val;
			val2 = '#' + val2;
			activeobj.setGradient('fill', {
			  type: 'linear',
			  x1: 0,
			  y1: activeobj.height / 2,
			  x2: activeobj.width,
			  y2: activeobj.height / 2,
			  colorStops: {
				0: val,				
				1: val2
			  }
			});
		} else if(mode == 'stroke' && id == "BBColor1") {
			val = '#' + val;
			activeobj.set('stroke', val);		
		} else if(mode == 'stroke' && (id == "BBColor2" || id == "BBColor3")) {
			val = '#' + val;
			val2 = '#' + val2;
			activeobj.setGradient('stroke', {
			  type: 'linear',
			  x1: 0,
			  y1: activeobj.height / 2,
			  x2: activeobj.width,
			  y2: activeobj.height / 2,
			  colorStops: {
				0: val,				
				1: val2
			  }
			});
		}		
		canvashandler.renderAll();		
	}
	function updateCircle(val, val2, mode, id) {
		if(mode == 'swidth') {
			activeobj.set('strokeWidth', val);
		} else if(mode == 'opacity') {
			activeobj.set(mode, val);	
		} else if(mode == 'scolor') {
			val = '#' + val;
			var bl = circleShadowBlur.spinner('value');
			var fx = circleShadowOffsetX.spinner('value');
			var fy = circleShadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: val,
				blur: bl,
				offsetX: fx,
				offsetY: fy
			});
		} else if(mode == 'sblur') {			
			var col = '#' + $('#circleShadowColor').val() + "";			
			var fx = circleShadowOffsetX.spinner('value');
			var fy = circleShadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: col,
				blur: val,
				offsetX: fx,
				offsetY: fy
			});
		} else if(mode == 'offsetX') {			
			var col = '#' + $('#circleShadowColor').val() + "";
			var bl = circleShadowBlur.spinner('value');			
			var fy = circleShadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: col,
				blur: bl,
				offsetX: val,
				offsetY: fy
			});
		} else if(mode == 'offsetY') {			
			var col = '#' + $('#circleShadowColor').val() + "";
			var bl = circleShadowBlur.spinner('value');
			var fx = circleShadowOffsetX.spinner('value');			
			activeobj.setShadow({
				color: col,
				blur: bl,
				offsetX: fx,
				offsetY: val
			});		
		} else if(mode == 'fill' && id == "CFColor1") {
			val = '#' + val;
			activeobj.set('fill', val);
		} else if(mode == 'fill' && (id == "CFColor2" || id == "CFColor3")) {
			val = '#' + val;
			val2 = '#' + val2;
			activeobj.setGradient('fill', {
			  type: 'linear',
			  x1: 0,
			  y1: activeobj.height / 2,
			  x2: activeobj.width,
			  y2: activeobj.height / 2,
			  colorStops: {
				0: val,				
				1: val2
			  }
			});
		} else if(mode == 'stroke' && id == "CBColor1") {
			val = '#' + val;
			activeobj.set('stroke', val);		
		} else if(mode == 'stroke' && (id == "CBColor2" || id == "CBColor3")) {
			val = '#' + val;
			val2 = '#' + val2;
			activeobj.setGradient('stroke', {
			  type: 'linear',
			  x1: 0,
			  y1: activeobj.height / 2,
			  x2: activeobj.width,
			  y2: activeobj.height / 2,
			  colorStops: {
				0: val,				
				1: val2
			  }
			});
		}		
		canvashandler.renderAll();		
	}
	$("#text").keyup(function() {
		updateText($(this).val(), '', 'text', '');
	});
	function updateText(val, val2, mode, id) {
		if(mode == 'text') {
			activeobj.set('text', val);
		} else if(mode == 'swidth') {
			activeobj.set('strokeWidth', val);
		} else if(mode == 'opacity') {
			activeobj.set(mode, val);
		} else if(mode == 'font') {
			activeobj.set('fontFamily', val);
		} else if(mode == 'scolor') {
			val = '#' + val;
			var bl = shadowBlur.spinner('value');
			var fx = shadowOffsetX.spinner('value');
			var fy = shadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: val,
				blur: bl,
				offsetX: fx,
				offsetY: fy
			});
		} else if(mode == 'sblur') {			
			var col = '#' + $('#shadowColor').val() + "";			
			var fx = shadowOffsetX.spinner('value');
			var fy = shadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: col,
				blur: val,
				offsetX: fx,
				offsetY: fy
			});
		} else if(mode == 'offsetX') {			
			var col = '#' + $('#shadowColor').val() + "";
			var bl = shadowBlur.spinner('value');			
			var fy = shadowOffsetY.spinner('value');
			activeobj.setShadow({
				color: col,
				blur: bl,
				offsetX: val,
				offsetY: fy
			});
		} else if(mode == 'offsetY') {			
			var col = '#' + $('#shadowColor').val() + "";
			var bl = shadowBlur.spinner('value');
			var fx = shadowOffsetX.spinner('value');			
			activeobj.setShadow({
				color: col,
				blur: bl,
				offsetX: fx,
				offsetY: val
			});
		} else if(mode == 'fsize') {
			activeobj.set('fontSize', val);
		} else if(mode == 'fill' && id == "color") {
			val = '#' + val;
			activeobj.set('fill', val);
		} else if(mode == 'fill' && (id == "color1" || id == "color2")) {
			val = '#' + val;
			val2 = '#' + val2;
			activeobj.setGradient('fill', {
			  type: 'linear',
			  x1: 0,
			  y1: activeobj.height / 2,
			  x2: activeobj.width,
			  y2: activeobj.height / 2,
			  colorStops: {
				0: val,				
				1: val2
			  }
			});
		} else if(mode == 'stroke' && id == "color3") {
			val = '#' + val;
			activeobj.set('stroke', val);
		} else if(mode == 'stroke' && (id == "color4" || id == "color5")) {
			val = '#' + val;
			val2 = '#' + val2;
			activeobj.setGradient('stroke', {
			  type: 'linear',
			  x1: 0,
			  y1: activeobj.height / 2,
			  x2: activeobj.width,
			  y2: activeobj.height / 2,
			  colorStops: {
				0: val,				
				1: val2
			  }
			});
		}		
		canvashandler.renderAll();		
	}
	function initCanvas(type) {
		try {
			webglBackend = new fabric.WebglFilterBackend();
		} catch (e) {
			console.log(e);
		}
		canvas2dBackend = new fabric.Canvas2dFilterBackend();
		fabric.filterBackend = fabric.initFilterBackend();	
		fabric.Object.prototype.transparentCorners = false;
		fabric.filterBackend = canvas2dBackend;	
		f = fabric.Image.filters;
		canvashandler = new fabric.Canvas('bannerImage');		
		if(type == "image") {
			var filename = $('#filename').val() + "";			
			fabric.Image.fromURL(filename, function(oImg) {			  
			  updateCanvas(oImg, "background");
			});
		} else {			
			bgimghandler = new fabric.Rect({
				width: 600, height: 314,
				left: 0, top: 0,
				fill: '#ffffff'				
			});
			updateCanvas(bgimghandler, "background");
		}
	}
	function updateCanvas(ob, type) {		
		canvashandler.add(ob);	
		if(type == "background") {
			ob.selectable = false;
			ob.sendToBack();
			deselectObject();
		} else if(type == "common") {
			ob.bringToFront();
		}		
	}
	function onObjectSelection(e) {
		var obj = e.target;		
		canvashandler.setActiveObject(obj);
		activeobj = canvashandler.getActiveObject();								
 	}	
	canvashandler.on('mouse:down', function(options) {  
	  var obj = options.target;
	  if(obj) {
		if(obj.width == 600 && obj.height == 314) {
			obj.selectable = false;
			canvashandler.discardActiveObject();
		} else {			
			$("#mainControls").hide();
			if(obj.type == "text") {								
				toggleToolbarControls('text','edit');
				$("#text").val(obj.text);
			} else if(obj.type == "circle") {
				toggleToolbarControls('circle','edit');
			} else if(obj.type == "rect") {
				toggleToolbarControls('box','edit');
			} else if(obj.type == "triangle") {
				toggleToolbarControls('triangle','edit');
			} else if(obj.type == "image") {
				toggleToolbarControls('image','edit');
			}
			canvashandler.setActiveObject(obj);
			activeobj = obj;	
			activeobj.bringToFront();
		}				
	  }
	});	
	$('#saveText, #saveCircle, #saveBox, #saveTriangle, #saveBG, #saveImage').click(function() {		
		backToMenu('');
	});	
	$('#backButton, #backButton2, #backButton3, #backButton4, #backButton5, #backButton6').click(function() {
		backToMenu('back');
	});
	$('#btext').click(function() {		
		$("#mainControls").hide();
		toggleToolbarControls('text','add');    
	});
	$('#bcircle').click(function() {
		$("#mainControls").hide();
		toggleToolbarControls('circle','add');    
	});
	$('#bbox').click(function() {
		$("#mainControls").hide();
		toggleToolbarControls('box','add');    
	});
	$('#btriangle').click(function() {
		$("#mainControls").hide();
		toggleToolbarControls('triangle','add');    
	});
	$('#editBG').click(function() {
		$("#mainControls").hide();
		toggleToolbarControls('bg','');    
	});
	$('#bImage').click(function() {
		$("#mainControls").hide();
		toggleToolbarControls('image','add');    
	});
	function toggleToolbarControls(c, op) {
		$("#toolbar").hide();
		$("#textControls").hide();
		$("#circleControls").hide();	
		$("#boxControls").hide();
		$("#triangleControls").hide();
		$("#bgControls").hide();
		$("#imageControls").hide();		
		if(c == 'text') {			
			$("#toolbar").show();
			$("#textControls").show();
			$("#backButton").show();
			if(op == 'add') {
				drawText();
			} else {
				$("#backButton").hide();
			}
		} else if(c == 'circle') {
			$("#toolbar").show();
			$("#circleControls").show();
			$("#backButton2").show();
			if(op == 'add') {
				drawCircle();
			} else {
				$("#backButton2").hide();
			}
		} else if(c == 'box') {
			$("#toolbar").show();
			$("#boxControls").show();
			$("#backButton3").show();
			if(op == 'add') {
				drawBox();
			} else {
				$("#backButton3").hide();
			}
		} else if(c == 'triangle') {
			$("#toolbar").show();
			$("#triangleControls").show();
			$("#backButton4").show();
			if(op == 'add') {
				drawTriangle();
			} else {
				$("#backButton4").hide();
			}
		} else if(c == 'bg') {
			$("#toolbar").show();
			$("#bgControls").show();
		} else if(c == 'image') {
			$("#toolbar").show();
			$("#imageControls").show();			
			toggleImageButton(op);			 
		}
	}
	function backToMenu(page) {
		if(page == 'back') {
			setDefaultValuesBack();
		} else {
			setDefaultValues();
		}		
		$("#mainControls").show();
		toggleToolbarControls('default','');
	}
	function applyFilter(index, filter) {
		var activeobj = canvashandler.getActiveObject();
		activeobj.filters[index] = filter;		
		activeobj.applyFilters();		
		canvashandler.renderAll();
	}	
	function deleteFilter(index) {
		var activeobj = canvashandler.getActiveObject();		
		delete activeobj.filters[index];
		activeobj.applyFilters();		
		canvashandler.renderAll();
	}
	function toggleImageButton(mode) {
		$("#imageEffects").hide();		
		$("#imageUploadButton").show();
		if(mode == "edit") {
			$("#imageEffects").show();			
			$("#imageUploadButton").hide();
		}
	}
	$('#beginImageUpload').click(function() {
		$('#file').click();    
	});	
	$('#createBanner').click(function() {
		var createUrl = $('#createUrl').val() + "";
		var csrf = $('#csrf').val() + "";
		var textmessage = "";
		do {
		    textmessage = prompt("Please enter banner title: ", "");		    
		} while (textmessage == "" || textmessage === null);
		var canvasimg = canvashandler.toDataURL('png');	
		var tmpImages = ""; 
		if(temp_images.length > 0) {
			tmpImages = temp_images.join(',');
		}
		blockMessage("Saving, please wait ...");		
		$.post(createUrl, { imgBase64: canvasimg, title: textmessage, tmpImages: tmpImages, _token: csrf }, function(data) {			
			unblockMessage(1000);
			var bannersRoute = $('#bannersRoute').val() + "";
			window.location = bannersRoute;
		},"json");
	});		
	$('#file').change(function () {
        if ($(this).val() != '') {
            uploadNow(this);
        }
    });	
	function uploadNow(img) {
		var imgurl = $("#url").val() + "";
		var csrf = $("#csrf").val() + "";		
        var form_data = new FormData();
        form_data.append('file', img.files[0]);
        form_data.append('_token', csrf);     
		blockMessage('Please wait...');
        $.ajax({
            url: imgurl,
            data: form_data,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function (data) {
				unblockMessage(2000);
                if (data.fail) {                    
                    alert(data.errors['file']);
                } else {					
					temp_images.push(data);
					toggleImageButton('edit');
					fabric.Image.fromURL(data, function(oImg) {			  
					  updateCanvas(oImg, "common");
					  canvashandler.setActiveObject(oImg);
					  activeobj = oImg;
					});                                        
                }                
            },
            error: function (xhr, status, error) {
				unblockMessage(2000);
                alert(xhr.responseText);                
            }
        });
    }
	$("#colorType").change(function() {
        var type = $(this).val() + "";			
        toggleToolbarColor(type);
    });
	$("#circleColorType").change(function() {
        var type = $(this).val() + "";			
        toggleCircleToolbarColor(type);
    });
	$("#boxColorType").change(function() {
        var type = $(this).val() + "";			
        toggleBoxToolbarColor(type);
    });
	$("#bgColorType").change(function() {
        var type = $(this).val() + "";			
        toggleBGToolbarColor(type);
    });
	$("#triangleColorType").change(function() {
        var type = $(this).val() + "";			
        toggleTriangleToolbarColor(type);
    });
	$("#bcolorType").change(function() {
        var type = $(this).val() + "";			
        toggleToolbarBColor(type);
    });	
	$("#circleBColorType").change(function() {
        var type = $(this).val() + "";			
        toggleCirleToolbarBColor(type);
    });
	$("#boxBColorType").change(function() {
        var type = $(this).val() + "";			
        toggleBoxToolbarBColor(type);
    });
	$("#triangleBColorType").change(function() {
        var type = $(this).val() + "";			
        toggleTriangleToolbarBColor(type);
    });				
	function drawText() {				
		var mytxt = new fabric.Text("Change Me!", { left: 100, top: 100, fontSize: 40, fontFamily: 'Comic Sans' });
		updateCanvas(mytxt, "common");
		canvashandler.setActiveObject(mytxt);
		activeobj = mytxt;		
	}
	function drawCircle() {
		var mycircle = new fabric.Circle({ radius: 25, fill: '#CD0000', left: 100, top: 100 });		
		updateCanvas(mycircle, "common");
		canvashandler.setActiveObject(mycircle);
		activeobj = mycircle;
	}
	function drawBox() {
		var mybox = new fabric.Rect({ width: 50, height: 50, left: 100, top: 100, fill: '#CD0000' });		
		updateCanvas(mybox, "common");
		canvashandler.setActiveObject(mybox);
		activeobj = mybox;
	}
	function drawTriangle() {
		var triangle = new fabric.Triangle({ width: 30, height: 40, fill: '#CD0000', left: 100, top: 100 });				
		updateCanvas(triangle, "common");
		canvashandler.setActiveObject(triangle);
		activeobj = triangle;
	}
	function deselectObject(){
		canvashandler.discardActiveObject();
		canvashandler.renderAll(); 
	}
	function setDefaultValues() {
		stroke.spinner("value", 0);
		$("#text").val("Change Me!");
		deselectObject();
	}
	function setDefaultValuesBack() {
		canvashandler.remove(activeobj);
		stroke.spinner("value", 0);
		$("#text").val("");
		deselectObject();
	}	
	function toggleToolbarColor(c) {
		$("#simpleColor").hide();
		$("#gradientColor").hide();		
		if(c == 'linear') {
			$("#simpleColor").show();
		} else if(c == 'gradient') {
			$("#gradientColor").show();
		}
	}
	function toggleCircleToolbarColor(c) {
		$("#circleSimpleColor").hide();
		$("#circleGradientColor").hide();		
		if(c == 'linear') {
			$("#circleSimpleColor").show();
		} else if(c == 'gradient') {
			$("#circleGradientColor").show();
		}
	}
	function toggleBoxToolbarColor(c) {
		$("#boxSimpleColor").hide();
		$("#boxGradientColor").hide();		
		if(c == 'linear') {
			$("#boxSimpleColor").show();
		} else if(c == 'gradient') {
			$("#boxGradientColor").show();
		}
	}
	function toggleBGToolbarColor(c) {
		$("#bgSimpleColor").hide();
		$("#bgGradientColor").hide();		
		if(c == 'linear') {
			$("#bgSimpleColor").show();
		} else if(c == 'gradient') {
			$("#bgGradientColor").show();
		}
	}
	function toggleTriangleToolbarColor(c) {
		$("#triangleSimpleColor").hide();
		$("#triangleGradientColor").hide();		
		if(c == 'linear') {
			$("#triangleSimpleColor").show();
		} else if(c == 'gradient') {
			$("#triangleGradientColor").show();
		}
	}
	function toggleToolbarBColor(c) {
		$("#simpleBorder").hide();
		$("#gradientBorder").hide();		
		if(c == 'linear') {
			$("#simpleBorder").show();
		} else if(c == 'gradient') {
			$("#gradientBorder").show();
		}
	}
	function toggleCirleToolbarBColor(c) {
		$("#circleSimpleBorder").hide();
		$("#circleGradientBorder").hide();		
		if(c == 'linear') {
			$("#circleSimpleBorder").show();
		} else if(c == 'gradient') {
			$("#circleGradientBorder").show();
		}
	}
	function toggleBoxToolbarBColor(c) {
		$("#boxSimpleBorder").hide();
		$("#boxGradientBorder").hide();		
		if(c == 'linear') {
			$("#boxSimpleBorder").show();
		} else if(c == 'gradient') {
			$("#boxGradientBorder").show();
		}
	}
	function toggleTriangleToolbarBColor(c) {
		$("#triangleSimpleBorder").hide();
		$("#triangleGradientBorder").hide();		
		if(c == 'linear') {
			$("#triangleSimpleBorder").show();
		} else if(c == 'gradient') {
			$("#triangleGradientBorder").show();
		}
	}
	function blockMessage(m) {
		$.blockUI({ 
			message: m,
			css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#000', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				color: '#fff' 
			}
		});        
	}
	function unblockMessage(s) {
		setTimeout($.unblockUI, s);
	}
});