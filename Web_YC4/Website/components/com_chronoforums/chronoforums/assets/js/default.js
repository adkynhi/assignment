function selectCode(a)
{
	// Get ID of code block
	var e = a.parentNode.parentNode.getElementsByTagName('CODE')[0];

	// Not IE and IE9+
	if (window.getSelection)
	{
		var s = window.getSelection();
		// Safari
		if (s.setBaseAndExtent)
		{
			s.setBaseAndExtent(e, 0, e, e.innerText.length - 1);
		}
		// Firefox and Opera
		else
		{
			// workaround for bug # 42885
			if (window.opera && e.innerHTML.substring(e.innerHTML.length - 4) == '<BR>')
			{
				e.innerHTML = e.innerHTML + '&nbsp;';
			}

			var r = document.createRange();
			r.selectNodeContents(e);
			s.removeAllRanges();
			s.addRange(r);
		}
	}
	// Some older browsers
	else if (document.getSelection)
	{
		var s = document.getSelection();
		var r = document.createRange();
		r.selectNodeContents(e);
		s.removeAllRanges();
		s.addRange(r);
	}
	// IE
	else if (document.selection)
	{
		var r = document.body.createTextRange();
		r.moveToElementText(e);
		r.select();
	}
}

/**
* Resize viewable area for attached image or topic review panel (possibly others to come)
* e = element
*/
function viewableArea(e){
	var $img = jQuery(e);
	if($img.hasClass('enlarged')){
		$img.css({'max-width' : '100%'});
		$img.parent().css({'overflow' : 'hidden'});
		$img.removeClass('enlarged');
	}else{
		$img.css({'max-width' : 'none'});
		$img.parent().css({'overflow' : 'auto'});
		$img.addClass('enlarged');
	}
}
/*
function viewableModal(e){
	var $img = gcore_jQuery(e);
	if($img.next().hasClass('chronoforums-img-modal')){
		var $modal = $img.next();
	}else{
		var $modal = gcore_jQuery('<div class="modal fade chronoforums-img-modal" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"></div>');
		$modal.append('<div class="modal-dialog" style="width:auto; text-align:center;"><div class="modal-content"><div class="modal-header" style="text-align:right;"></div><div class="modal-body"></div><div class="modal-footer"></div></div></div>');
		$modal.find('.modal-header').append('<button type="button" class="btn btn-danger" data-g-dismiss="modal"><i class="fa fa fa-times fa-lg"></i></button>');
		$modal.find('.modal-body').append($img.clone());
		$modal.find('.modal-footer').append('<button type="button" class="btn btn-danger" data-g-dismiss="modal"><i class="fa fa fa-times fa-lg"></i></button>');
		$img.after($modal);
	}
	$modal.modal('show');
}*/
function viewableModal(e){
	var $img = jQuery(e);
	if($img.next().hasClass('chronoforums-img-modal')){
		var $modal = $img.next();
	}else{
		var $modal = jQuery('<div class="chronoforums-img-modal" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="display:none;"></div>');
		$modal.append('<div class="modal-dialog" style="width:auto; text-align:center;"><div class="modal-content"><div class="modal-header" style="text-align:right;"></div><div class="modal-body"></div><div class="modal-footer"></div></div></div>');
		$modal.find('.modal-header').append('<button type="button" class="btn btn-danger" data-close="gmodal"><i class="fa fa fa-times fa-lg"></i></button>');
		var image_clone = $img.clone();
		image_clone.prop('onclick', '');
		image_clone.off('click');
		$modal.find('.modal-body').append(image_clone);
		$modal.find('.modal-footer').append('<button type="button" class="btn btn-danger" data-close="gmodal"><i class="fa fa fa-times fa-lg"></i></button>');
		$img.after($modal);
	}
	$modal.gmodal();
	$modal.gmodal('open');
}
/*
function topic_quick_review(e){
	var $link = gcore_jQuery(e);
	
	if($link.next().hasClass('chronoforums-quickpreview-modal')){
		var $modal = $link.next();
	}else{
		var $modal = gcore_jQuery('<div class="modal fade chronoforums-quickpreview-modal" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"></div>');
		$modal.append('<div class="modal-dialog" style="width:'+$link.closest('.chronoforums').width()+'px;"><div class="modal-content chronoforums posts index"><div class="modal-header" style="text-align:right;"></div><div class="modal-body"></div><div class="modal-footer"></div></div></div>');
		$modal.find('.modal-header').append('<button type="button" class="btn btn-danger" data-g-dismiss="modal"><i class="fa fa fa-times fa-lg"></i></button>');
		$modal.find('.modal-body').append($link.clone());
		
		gcore_jQuery.ajax({
			"type" : "GET",
			"url" : $link.prop("href"),
			"data" : {"p": 0},
			beforeSend: function(){
				//topic_preview_running = 1;
				//jQuery("#topic_preview_loading").css("display", "block");
			},
			"success" : function(res){
				if(res == "_END_"){
					//jQuery(".cfu-post").last().after("<div class=\"row posts-loader-no-posts\"><div class=\"col-md-12\"><div class=\"alert alert-info\">'.l_('CHRONOFORUMS_NO_MORE_POSTS').'</div></div></div>");
					//posts_end_reached = 1;
					//jQuery(".posts-loader-load-more").prop("disabled", true);
				}else{
					$modal.find('.modal-body').append(res);
				}
				//topic_preview_running = 0;
				//jQuery("#topic_preview_loading").css("display", "none");
			},
		});
		
		//$modal.find('.modal-body').append($link.clone());
		//$modal.find('.modal-footer').append('<button type="button" class="btn btn-danger" data-g-dismiss="modal"><i class="fa fa fa-times fa-lg"></i></button>');
		$link.after($modal);
	}
	$modal.modal('show');
}
*/
function expand_collapse_code(e){
	var $link = jQuery(e);
	if($link.hasClass('collapsed')){
		$link.removeClass('collapsed');
		$link.closest('.cfu-code').removeClass('cfu-collapsed');
		$link.closest('.cfu-code').find('.cfu-multiline').removeClass('cfu-collapsed');
		$link.text($link.data('collapse'));
	}else{
		$link.addClass('collapsed');
		$link.closest('.cfu-code').addClass('cfu-collapsed');
		$link.closest('.cfu-code').find('.cfu-multiline').addClass('cfu-collapsed');
		$link.text($link.data('expand'));
	}
}