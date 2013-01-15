define(["channel","jquery","backbone", "underscore", "text!template/asset_toolbar.html","model/asset", "collection/asset"], 
	function(channel,$, Backbone, _,tmplAssetToolbar, AssetModel, AssetCollection){
		var toolbarView = Backbone.View.extend({
			id: "asset-toolbar",
			className: "row",
			tagName: "div",
			template: _.template(tmplAssetToolbar),
			events: {
				"click #add-asset-btn": "addForm",
				"click #add-asset-form-save-btn": "newAsset"
			},
			addForm: function() {
				$("#add-asset-form").show();
			},
			newAsset: function(e) {
				e.preventDefault();
				var name = $("#add-asset-form .search-query").val();
				var asset = new AssetModel({"name": name });
				asset.save({"name" : name},
					{
						success: function(model,res) {
							console.log(model);
							console.log(res);
							// trigger table render on success
							channel.trigger('new:asset', {
								"model" : model
							});
						},
						error: function(model, res){
							console.log(model);
							console.log(res);
						}
					}
				);
				// animate and trigger
				$("#add-asset-form").hide();
			},
			render: function(){
				$(this.el).html(this.template());
				return this;
			}

		});
		return new toolbarView;
	}
);