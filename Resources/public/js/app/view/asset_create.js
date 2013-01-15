define(["jquery","backbone", "underscore", "text!template/asset_create.html"],
	function($, Backbone, _,tmplAssetCreate){
		var assetNewView = Backbone.View.extend({
			el: $("#container"),
			render: function() {
				this.$el.html(_.template(tmplAssetCreate));
			}
		});

		return new assetNewView;
	}
);