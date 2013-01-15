define(["jquery","backbone", "underscore", "text!template/asset_table_row.html"], 
	function($, Backbone, _, tmplAssetTableRow){
		var assetTableRowView = Backbone.View.extend({
			template: _.template(tmplAssetTableRow),
			render: function() {
				this.el = this.template(this.model.toJSON());
			}
		});

		return assetTableRowView;
	}
);