define(['jquery',
	'underscore',
	'backbone',
	'text!template/asset_property_list.html',
	'collection/asset_property',
	'view/asset_property',
	'model/asset_property'],
	function($, _, Backbone, assetPropertyListTmpl, AssetPropertyCollection, AssetPropertyView, AssetPropertyModel) {
		var assetPropertyListView = Backbone.View.extend({
			manager:true,
			template: _.template(assetPropertyListTmpl),
			initialize: function() {
				this.collection = new AssetPropertyCollection;
				this.collection.url = Routing.generate('mdb_asset_rest_get_asset_properties', {"id" : this.asset_id });
			},

			events: {
				"keypress #properties_new_key": "focusOnValue",
				"keypress #properties_new_value": "createProperty"
			},

			focusOnValue: function(e) {
				if(e.keyCode != 9) return;
				if(!this.$("#properties_new_key").val()) return false;
			},

			createProperty: function(e) {
				if(e.keyCode != 13) return;
				if(!this.$("#properties_new_key").val() || !this.$("#properties_new_value").val() ) return;
				var newProperty = new AssetPropertyModel(
					{
						key: this.$("#properties_new_key").val(),
						value: this.$("#properties_new_value").val()
					}
				);
				this.collection.add(newProperty);
				newProperty.save();

				this.render();
			},

			render: function() {
				var that = this;
				this.collection.fetch({
					success: function(resp) {
						that.collection = resp;
						$(this.el).html(that.template({"properties":that.collection.toJSON()}));
					}
				});
				return this;
			}
		});
		return new assetPropertyListView;
	}
);