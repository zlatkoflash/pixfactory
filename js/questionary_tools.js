function TheLeftFormsHolder()
{
	this.resize = function()
	{
		var availWidth = 0;
		/**/
		if(TheRightFormHolder.TRFH.isVisible == true)
		{
			availWidth = ThePage.MIN_WIDTH - TheRightFormHolder.MIN_WIDTH;
		}
		else
		{
			availWidth = ThePage.MIN_WIDTH;
		}
		
		if(availWidth < TheLeftFormsHolder.MIN_WIDTH)
		{
			$(".left_forms_holder").css("padding-left","0px");
			$(".left_forms_holder").css("width",TheLeftFormsHolder.MIN_WIDTH+"px");
		}
		else
		{
			var paddingLeft = (availWidth - TheLeftFormsHolder.MIN_WIDTH) / 2;
			var width = TheLeftFormsHolder.MIN_WIDTH+paddingLeft;
			$(".left_forms_holder").css("padding-left",paddingLeft+"px");
			$(".left_forms_holder").css("width",width+"px");
		}
	}
}
TheLeftFormsHolder.TLFH = new TheLeftFormsHolder();
TheLeftFormsHolder.MIN_WIDTH = 855;

function TheRightFormHolder()
{
	this.isVisible = true;
	this.show_hide = function()
	{
		if(TheRightFormHolder.TRFH.isVisible == true)
		{
			$(".right_form_holder").stop(true,true).animate({width:50},300);
			TheRightFormHolder.TRFH.isVisible = false;
		}
		else
		{
			$(".right_form_holder").stop(true,true).animate({width:TheRightFormHolder.MIN_WIDTH},300);
			TheRightFormHolder.TRFH.isVisible = true;
		}
	}
}
TheRightFormHolder.TRFH = new TheRightFormHolder();
TheRightFormHolder.MIN_WIDTH = 293;

function ThePage()
{
	this.resize_and_position_me = function()
	{
		ThePage.RECT = new Rectangle(0,0,0,0);
		if($(window).height() < ThePage.MIN_HEIGHT)
		{
			$("#page").css("margin-top","0px");
			$(".right_form_holder").css("top","0px");
		}
		else
		{
			var top = ($(window).height() - ThePage.MIN_HEIGHT) / 2;
			$("#page").css("margin-top",top+"px");
			$(".right_form_holder").css("top",top+"px");
		}
		$("#page").css("height", ThePage.MIN_HEIGHT+"px");
	}
}
ThePage.TP = new ThePage();

ThePage.MIN_HEIGHT = 768;
ThePage.RECT = null;

function Rectangle(x,y,w,h)
{
	this.x = x;
	this.y = y;
	this.w = w;
	this.h = h;
}

$(window).load(function(e) 
{
	ThePage.TP.resize_and_position_me();
});
$(window).resize(function(e) 
{
	ThePage.TP.resize_and_position_me();
});
$(document).ready(function(e) 
{
	ThePage.TP.resize_and_position_me();
});

$(document).ready(function(e) 
{
	$(".menu_item").each(function(index, element) 
	{
		$(this).click(function(e) 
		{
			window.location = $(this).attr("href");
		});
	});
});
