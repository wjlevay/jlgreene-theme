/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*//*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/function updateViewportDimensions(){var e=window,t=document,n=t.documentElement,r=t.getElementsByTagName("body")[0],i=e.innerWidth||n.clientWidth||r.clientWidth,s=e.innerHeight||n.clientHeight||r.clientHeight;return{width:i,height:s}}var viewport=updateViewportDimensions(),waitForFinalEvent=function(){var e={};return function(t,n,r){r||(r="Don't call this twice without a uniqueId");e[r]&&clearTimeout(e[r]);e[r]=setTimeout(t,n)}}(),timeToWaitForLast=100;jQuery(document).ready(function(e){e(".wpba-flexslider").flexslider({animation:"slide",touch:"true",start:function(t){e(t).find("img.lazy").slice(0,5).each(function(){var t=e(this).attr("data-src");e(this).attr("src",t).removeAttr("data-src").removeClass("lazy")});e("ol.flex-control-nav").css({top:e("img.sliding-image").height()-20})},before:function(t){var n=e(t).find(".slides").children().eq(t.animatingTo+1).find("img"),r=n.attr("data-src");n.attr("src",r).removeAttr("data-src").removeClass("lazy")}})});