define(['underscore', 'backbone'],
	function(_, Backbone) {
		var assetPropertyModel = Backbone.Model.extend({
			url: function() {
				if(this.isNew()){
					return Routing.generate("mdb_asset_rest_post_asset_properties", {"id": this.asset_id } );
				}else{
					return Routing.generate("mdb_asset_rest_delete_asset_properties", {"id": this.asset_id, "pid": this.id } );
				}
			},
			initialize: function() {
				// this.url = Routing.generate("mdb_asset_rest_get_asset_properties", {"id": $("#asset_id").val() });
			},
			defaults: {
				"property": "New key...",
				"value": "New value..."
			}
		});
		return assetPropertyModel;
	}
);