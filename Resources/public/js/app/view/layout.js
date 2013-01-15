define([
	"jquery",
	"backbone",
	"underscore",
	"text!template/layout.html",	
	"backbone.layoutmanager",
],
	function($, Backbone, _, tmplLayout) {
		
		var layout = Backbone.Layout({
			template: tmplLayout
		});
		return new layout;
	}
);