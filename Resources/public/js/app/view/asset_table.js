define(["channel","bootstrapped_data","jquery", "text!template/asset_table.html", "collection/asset","model/asset" ],
	function(channel,data,$, tmplAssetTable, AssetCollection, AssetModel){
		var assetTableView = Backbone.View.extend({
			id: "asset-table",
			className: "row",
			tagName: "div",
			template: _.template(tmplAssetTable),
			events: {
				"click .search-button": "search",
				"keyup .search-query": "autocomplete",
				"click a": "show"
			},
			initialize: function() {
				// instantize collection
				this.collection = new AssetCollection;
				// load with bootstrap data
				this.collection.reset(data.bootstrappedAssets);

				//bind events
				this.collection.on("add", this.add, this);
				this.collection.on("reset", this.reset, this);

				// add new model view to collection
				var that = this;
				channel.on('new:asset', function(args){
					that.collection.add(args.model);
				});

			},
			render: function() {
				$(this.el).find("table").remove();
				// actaul adding things to dom
				$(this.el).html(this.template({"assets": this.collection.toJSON()}));
				return this;
			},

			search: function() {
				var q = $(".search-query").val();
				// pass to server
				this.collection.fetch({
					"data": { "q": q }
				});
			},

			autocomplete: function() {
				var q = $(".search-query").val();

			},
			show: function(e) {
				var id = e.target.id;
				channel.trigger("asset:show", {"model": this.collection.get(id)});
			},

			add: function() {
				// render the colleciton again
				this.render();
			},

			reset: function() {
				this.render();
			}

		});

		return new assetTableView;
	}
);
