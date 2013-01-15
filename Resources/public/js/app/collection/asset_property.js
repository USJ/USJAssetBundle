define(['underscore', 'backbone','model/asset_property'],
	function(_, Backbone, assetPropertyModel) {
		var assetPropertyCollection = Backbone.Collection.extend({
			model: assetPropertyModel,
			url: function() {
				return Routing.generate("mdb_asset_rest_get_asset_properties");
			},
			initialize: function() {
				
			}
		});

		return assetPropertyCollection;
	}
);