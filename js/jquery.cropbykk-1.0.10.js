var cropbykk = function(options){
	var cImagePos = { x: 0, y: 0 }
		,cCropLayoutPos = { x: 0, y: 0 }
		,cDefaultPos = { x: 0, y: 0 }
		,cImageSize = { w: 0, h: 0 }
		,cCropSize = { w: 0, h: 0 };
	var cDefaultImageSize = { w: 0, h: 0 }, cZoom = 1.0;
	var cIsMouseDown = false, pChangedZoom = false;
	var cFullSize = true;
	
	var defaults = {
		image_url: "images/black_eyed_peas.png",
		crop_layout: "#crop-layout",
		crop_image: "#crop-image",
		crop_tools: "#crop-tools",
		dest: "temp.php",
		optional_url: "",
		forcefull : false
	};
	
	var opt = options || {};
	
	var commandsURL = '';

	for (var o in defaults) opt[o] = (o in opt) ? opt[o] : defaults[o];
	
	function changeZoom()
    {
	    if(!pChangedZoom)
	    {
	        var zoom = $(opt.crop_tools+" #zoom-slider").slider("value"),
	        	diff=0;
	        cZoom = zoom/10;
	        if(cZoom > 10)
				cZoom = 10;
			if(cFullSize)
			{
		        if(cCropSize.w > (cDefaultImageSize.w*cZoom) || cCropSize.h > (cDefaultImageSize.h*cZoom))
		        {
		        	if((cDefaultImageSize.h*cZoom)/(cDefaultImageSize.w*cZoom) >= (cCropSize.h / cCropSize.w))
		            	cZoom = (cCropSize.w / cDefaultImageSize.w);
		            else /*if(cCropSize.h > (cDefaultImageSize.h*cZoom))*/
		            	cZoom = (cCropSize.h / cDefaultImageSize.h);
	            	if(Math.floor(cZoom*10)<=0)
						$(opt.crop_tools+" #zoom-slider").slider("value",1);
	            	else
	            		$(opt.crop_tools+" #zoom-slider").slider("value",Math.floor(cZoom*10));
            		pChangedZoom = true;
		        }
			}
			else
			{
		        if(cCropSize.w > (cDefaultImageSize.w*cZoom) && cCropSize.h > (cDefaultImageSize.h*cZoom))
		        {
		            if((cCropSize.w / cDefaultImageSize.w) >= (cCropSize.h / cDefaultImageSize.h))
		            	cZoom = (cCropSize.h / cDefaultImageSize.h);
		            else
		            	cZoom = (cCropSize.w / cDefaultImageSize.w);
		            if(Math.floor(cZoom*10)<=0)
						$(opt.crop_tools+" #zoom-slider").slider("value",1);
	            	else
	            		$(opt.crop_tools+" #zoom-slider").slider("value",Math.floor(cZoom*10));
		            pChangedZoom = true;
		        }
			}
	        
			$(opt.crop_tools+" #czoom-text").text(cZoom.toFixed(1)+'X');
			
			cImageSize.w = cDefaultImageSize.w*cZoom;
			cImageSize.h = cDefaultImageSize.h*cZoom;
			
			if(cCropSize.w > cImageSize.w + cImagePos.x)
			{
				diff = (cCropSize.w) - (cImageSize.w + cImagePos.x);
				$(opt.crop_image).css({'left':cImagePos.x+diff+'px'});
				cImagePos.x=cImagePos.x+diff;
			}
			
			if(cCropSize.h > cImageSize.h + cImagePos.y)
			{
				diff = (cCropSize.h) - (cImageSize.h + cImagePos.y);
				$(opt.crop_image).css({'top':cImagePos.y+diff+'px'});
				cImagePos.y=cImagePos.y+diff;
			}
			
			$(opt.crop_image).css({'width':cImageSize.w+'px','height':cImageSize.h+'px'});
	    }
	    pChangedZoom = false;
    }
	
	if(!opt.forcefull)
		$(opt.crop_tools).empty().append("<div style='padding: 2px;overflow: hidden;width: 580px;margin: 0 auto;'><span style='padding: 3px 3px 3px 5px;float: left;margin: 4px 0 0 10px;cursor: pointer;' class='ui-state-default ui-corner-all' >Full Size <input type='checkbox' checked='checked' style='height: 11px;' id='c-full-size' ></span><span style='padding: 1px;float: left;margin: 4px 0 0 10px;cursor: pointer;' class='ui-state-default ui-corner-all' id='czoom-out'><span class='ui-icon ui-icon-minus' style='float: left; margin: 2px;'></span></span><div style='float: left;width: 300px;padding: 10px;'><div id='zoom-slider'></div></div><span style='padding: 1px;float: left;margin: 4px 5px 0 2px;cursor: pointer;' class='ui-state-default ui-corner-all' id='czoom-in'><span class='ui-icon ui-icon-plus' style='float: left; margin: 2px;'></span></span><span  style='padding: 3px 5px;float: left;margin: 4px 5px 0 0px;cursor: pointer;' class='ui-state-default ui-corner-all' id='czoom-text'>1.0X</span><a href='' style='float: left;' target='_blank'  id='crop-link' ><span  style='padding: 3px 5px;float: left;margin: 4px 5px 0 0px;cursor: pointer;' class='ui-state-default ui-corner-all'>Crop it</span></a></div>");
	else
		$(opt.crop_tools).empty().append("<div style='padding: 2px;overflow: hidden;width: 500px;margin: 0 auto;'><span style='padding: 1px;float: left;margin: 4px 0 0 10px;cursor: pointer;' class='ui-state-default ui-corner-all' id='czoom-out'><span class='ui-icon ui-icon-minus' style='float: left; margin: 2px;'></span></span><div style='float: left;width: 300px;padding: 10px;'><div id='zoom-slider'></div></div><span style='padding: 1px;float: left;margin: 4px 5px 0 2px;cursor: pointer;' class='ui-state-default ui-corner-all' id='czoom-in'><span class='ui-icon ui-icon-plus' style='float: left; margin: 2px;'></span></span><span  style='padding: 3px 5px;float: left;margin: 4px 5px 0 0px;cursor: pointer;' class='ui-state-default ui-corner-all' id='czoom-text'>1.0X</span><a href='' style='float: left;' target='_blank'  id='crop-link' ><span  style='padding: 3px 5px;float: left;margin: 4px 5px 0 0px;cursor: pointer;' class='ui-state-default ui-corner-all'>Crop it</span></a></div>");
	
	setTimeout(function(){
		$(".ui-state-default").hover(
				function() {
				$( this ).addClass( "ui-state-hover" );
			},
			function() {
				$( this ).removeClass( "ui-state-hover" );
			}
		);
		
		$(opt.crop_tools+" #zoom-slider").slider({
	      orientation: "horizontal",
	      range: "min",
	      min: 1,
	      max: 100,
	      value: 10,
	      slide: changeZoom,
	    });

	    $(opt.crop_tools+" #c-full-size").change(function(){
	    	if(!opt.forcefull)
    		{
			    if($(opt.crop_tools+" #c-full-size").attr("checked") == 'checked')
				    cFullSize = true;
			    else
				    cFullSize = false;
    		}
	    });

		$(opt.crop_tools+" #zoom-slider").slider("value",10);
		
		cCropLayoutPos.x = $(opt.crop_layout).offset().left;
		cCropLayoutPos.y = $(opt.crop_layout).offset().top;
		cCropSize.w = $(opt.crop_layout).width();
		cCropSize.h = $(opt.crop_layout).height();
		
		$("<img/>").attr("src", opt.image_url).load(function() {
			var w,h;
			w = this.width;
			h = this.height;
			cDefaultImageSize.w = w;
			cDefaultImageSize.h = h;
			cImageSize.w = cDefaultImageSize.w;
			cImageSize.h = cDefaultImageSize.h;
			$(opt.crop_image).css({'width':w+'px','height':h+'px','background-image': 'url('+opt.image_url+')'});
		}); 
		
		$(opt.crop_tools+" #crop-link").mousedown(function(){
			var crop_x, crop_y, crop_h, crop_w, crop_zoom,crop_image,image_w,image_h;
			crop_x = cImagePos.x;
			crop_y = cImagePos.y;
			crop_w = cCropSize.w;
			crop_h = cCropSize.h;
			image_w = cImageSize.w;
			image_h = cImageSize.h;
			
			crop_zoom = cZoom;
			crop_image = encodeURIComponent(opt.image_url);
			commandsURL = opt.dest+"?image_url="+crop_image+"&crop_x="+(-crop_x)+"&crop_y="+(-crop_y)+"&crop_w="+crop_w+"&crop_h="+crop_h+"&crop_zoom="+crop_zoom+"&image_w="+image_w+"&image_h="+image_h+opt.optional_url;
			$(opt.crop_tools+" #crop-link").attr("href",commandsURL);
		});
		
		$(opt.crop_tools+" #crop-link").click(function(){
			$.get(commandsURL,function(){
				alert("ImageCropByKK: Image cropped!");
				$("#crop-overlay").animate({'opacity':'0'},300,function(){
					$(this).css({'display':'none'});
					$(this).children(".container").remove();
					delete crop;
				});
			});
		});
		
		$(opt.crop_tools+" #czoom-in").click(function() {
			cZoom = cZoom + 0.1;
			if(cZoom > 10)
				cZoom = 10;
			$(opt.crop_tools+" #czoom-text").text(cZoom.toFixed(1)+'X');
			$(opt.crop_tools+" #zoom-slider").slider("value",Math.floor(cZoom*10));
			pChangedZoom = true;
			cImageSize.w = cDefaultImageSize.w*cZoom;
			cImageSize.h = cDefaultImageSize.h*cZoom;
			$(opt.crop_image).css({'width':cImageSize.w+'px','height':cImageSize.h+'px'});
		});
		
		$(opt.crop_tools+" #czoom-out").click(function() {
			var diff = 0;

			if(cCropSize.w <= (cDefaultImageSize.w*cZoom) && cCropSize.h <= (cDefaultImageSize.h*cZoom))
	        {
				if(cZoom <= 0.1)
					cZoom = cZoom - 0.01;
				else
					cZoom = cZoom - 0.1;
	        
				if(cFullSize)
				{
					if(cCropSize.w > (cDefaultImageSize.w*cZoom) || cCropSize.h > (cDefaultImageSize.h*cZoom))
					{
						if((cDefaultImageSize.h*cZoom)/(cDefaultImageSize.w*cZoom) >= (cCropSize.h / cCropSize.w))
			            	cZoom = (cCropSize.w / cDefaultImageSize.w);
			            else 
			            	cZoom = (cCropSize.h / cDefaultImageSize.h);
					}
				}
				else
				{
			        if(cCropSize.w > (cDefaultImageSize.w*cZoom) && cCropSize.h > (cDefaultImageSize.h*cZoom))
			        {
			            if((cCropSize.w / cDefaultImageSize.w) >= (cCropSize.h / cDefaultImageSize.h))
			            	cZoom = (cCropSize.h / cDefaultImageSize.h);
			            else
			            	cZoom = (cCropSize.w / cDefaultImageSize.w);
			        }
				}
				$(opt.crop_tools+" #czoom-text").text(cZoom.toFixed(1)+'X');
				if(Math.floor(cZoom*10)<=0)
					$(opt.crop_tools+" #zoom-slider").slider("value",1);
		    	else
		    		$(opt.crop_tools+" #zoom-slider").slider("value",Math.floor(cZoom*10));
				pChangedZoom = true;
				
				cImageSize.w = cDefaultImageSize.w*cZoom;
				cImageSize.h = cDefaultImageSize.h*cZoom;
				
				if(cCropSize.w > cImageSize.w + cImagePos.x)
				{
					diff = (cCropSize.w) - (cImageSize.w + cImagePos.x);
					$(opt.crop_image).css({'left':cImagePos.x+diff+'px'});
					cImagePos.x=cImagePos.x+diff;
				}
				if(cCropSize.h > cImageSize.h + cImagePos.y)
				{
					diff = (cCropSize.h) - (cImageSize.h + cImagePos.y);
					$(opt.crop_image).css({'top':cImagePos.y+diff+'px'});
					cImagePos.y=cImagePos.y+diff;
				}
		
				$(opt.crop_image).css({'width':cImageSize.w+'px','height':cImageSize.h+'px'});
	        }
		});
	    
		$(opt.crop_tools+" #czoom-text").click(function() {
			$(opt.crop_tools+" #zoom-slider").slider("value",10);
			changeZoom();
		});
		
		$(opt.crop_image).mousedown(function(e) {
			cDefaultPos.x = e.pageX - cCropLayoutPos.x - cImagePos.x;
			cDefaultPos.y = e.pageY - cCropLayoutPos.y - cImagePos.y;
			cImageSize.w = $(opt.crop_image).width();
			cImageSize.h = $(opt.crop_image).height();
			cIsMouseDown = true;
		});
		
		$(document).mouseup(function() {
			cIsMouseDown = false;
		});
		
		$(document).mousemove(function(e) {
			if(cIsMouseDown)
			{
				cImagePos.x = e.pageX - cCropLayoutPos.x - cDefaultPos.x;
				cImagePos.y = e.pageY - cCropLayoutPos.y - cDefaultPos.y;

				if(cFullSize)
				{
					if(cImagePos.x > 0) cImagePos.x = 0;
					if(cImagePos.y > 0) cImagePos.y = 0;
					if(cImagePos.x < (cCropSize.w - cImageSize.w)) cImagePos.x = (cCropSize.w - cImageSize.w);
					if(cImagePos.y < (cCropSize.h - cImageSize.h)) cImagePos.y = (cCropSize.h - cImageSize.h);
				}
				else
				{
					if(cCropSize.w > cImageSize.w || cCropSize.h > cImageSize.h)
					{
						if((cCropSize.w / cDefaultImageSize.w) >= (cCropSize.h / cDefaultImageSize.h))
						{
							if(cImagePos.y > 0) cImagePos.y = 0;
							if(cImagePos.x > (cCropSize.w - cImageSize.w)) cImagePos.x = (cCropSize.w - cImageSize.w);
						}
						else
						{
							if(cImagePos.x > 0) cImagePos.x = 0;
							if(cImagePos.y > (cCropSize.h - cImageSize.h)) cImagePos.y = (cCropSize.h - cImageSize.h);
							//alert();
						}
						
						if((cCropSize.w / cDefaultImageSize.w) >= (cCropSize.h / cDefaultImageSize.h))
						{
							if(cImagePos.y < (cCropSize.h - cImageSize.h)) cImagePos.y = (cCropSize.h - cImageSize.h);
							if(cImagePos.x < 0) cImagePos.x = 0;
						}
						else
						{
							if(cImagePos.x < (cCropSize.w - cImageSize.w)) cImagePos.x = (cCropSize.w - cImageSize.w);
							if(cImagePos.y < 0) cImagePos.y = 0;
						}
					}
					else
					{
						if(cImagePos.x > 0) cImagePos.x = 0;
						if(cImagePos.y > 0) cImagePos.y = 0;
						if(cImagePos.x < (cCropSize.w - cImageSize.w)) cImagePos.x = (cCropSize.w - cImageSize.w);
						if(cImagePos.y < (cCropSize.h - cImageSize.h)) cImagePos.y = (cCropSize.h - cImageSize.h);
					}
				}
				
				$(opt.crop_image).css({'left':cImagePos.x+'px','top':cImagePos.y+'px'});
			}
	    });
		
	},100);
	/*
	<div style='padding: 2px;overflow: hidden;width: 580px;margin: 0 auto;'>
		<span style='padding: 3px 3px 3px 5px;float: left;margin: 4px 0 0 10px;cursor: pointer;' class='ui-state-default ui-corner-all' >
			Full Size <input type='checkbox' checked='checked' style='height: 11px;' id='c-full-size' >
		</span>
		<span style='padding: 1px;float: left;margin: 4px 0 0 10px;cursor: pointer;' class='ui-state-default ui-corner-all' id='czoom-out'>
			<span class='ui-icon ui-icon-minus' style='float: left; margin: 2px;'></span>
		</span>
		<div style='float: left;width: 300px;padding: 10px;'>
			<div id='zoom-slider'></div>
		</div>
		<span style='padding: 1px;float: left;margin: 4px 5px 0 0;cursor: pointer;' class='ui-state-default ui-corner-all' id='czoom-in'>
			<span class='ui-icon ui-icon-plus' style='float: left; margin: 2px;'></span>
		</span>
		<span  style='padding: 3px 5px;float: left;margin: 4px 5px 0 0px;cursor: pointer;' class='ui-state-default ui-corner-all' id='czoom-text'>
		1.0X
		</span>
		<a href='' class='download' style='float: left;' target='_blank'  id='crop-link' >
			<span  style='padding: 3px 5px;float: left;margin: 4px 5px 0 0px;cursor: pointer;' class='ui-state-default ui-corner-all'>
				Crop it
			</span>
		</a>
	</div>*/
}