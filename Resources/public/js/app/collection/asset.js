define([
		"channel",
		"jquery",
		"backbone", 
		"underscore",
		"model/asset"], 
function(channel,$,Backbone,_,assetModel){
	var assetCollection = Backbone.Collection.extend({
		model: assetModel,
		url: function(){
			return Routing.generate('mdb_asset_rest_get_assets');
		},
		parse: function(resp, xhr){
				return resp;
		},
		initialize: function() {
			
		}

	});
	return assetCollection;
});