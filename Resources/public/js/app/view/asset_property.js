define(['jquery',
	'underscore',
	'backbone',
	'text!template/asset_property.html',
	'model/asset_property'],
	function($, _, Backbone, AssetPropertyTmpl, AssetPropertyModel) {
		var assetPropertyView  = Backbone.View.extend({
			model: AssetPropertyModel,
			tagName: "tr",
			template: _.template(AssetPropertyTmpl),
			events: {
				'click a.remove': 'removeClick'
			},
			initialize: function() {
				// this.model.bind('remove', this.remove, this);
				// this.model.bind('change', this.changed, this);
			},
			changed: function() {
				this.model.save({wait: true});
			},
			removeClick: function() {
				var that = this;
				// alert(this.model.url);
				this.model.destroy({
					success: function(model, response) {
						that.remove();
					}
				});
				return false;
			},
			render: function() {
				this.$el.html(this.template(this.model.toJSON()));
				return this;
			}
		});
		return assetPropertyView;
	}
);