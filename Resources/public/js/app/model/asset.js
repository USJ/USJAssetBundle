define(['underscore', 'backbone'],
	function(_, Backbone) {
		var assetModel = Backbone.Model.extend({
			urlRoot: function() {
				if(this.isNew()) {
					return Routing.generate("mdb_asset_rest_post_asset");
				}else{
					return Routing.generate("mdb_asset_rest_get_asset");
				}
			},
			defaults:{
				"properties":[
					{"property":"Property","value":"Value of property"}
				],
				"name":"Name of the asset",
				"description":"Here we goes the asset description"
			}
		});
		return assetModel;
	}
);