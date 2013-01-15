define([
  'channel',
  'jquery',

  'model/asset',

  'view/asset_table_toolbar',
  'view/asset_create',
  'view/asset_table',
  'view/asset_show'
], function(channel, $, AssetModel, viewAssetToolbar, viewAssetNew, viewAssetTable, viewAssetShow){
  var AppRouter = Backbone.Router.extend({
    routes: {
      // Define some URL routes
      'create': 'create',
      'show/:id': 'show',
      '': 'index'
      // Default
      // '*actions': 'defaultAction'
    },
    create: function() {
      // render new asset view
      viewAssetNew.render();
    },
    show: function(id) {
      // render asset_show
      // since inline edit was allowed, no edit page is requiredf

     // fetch model from server
     var asset = new AssetModel({id:id});
     asset.fetch({
      success: function(model, response) {
        viewAssetShow.model = model;
        viewAssetShow.render();
        $("#container").empty().append(viewAssetShow.el);

        // $("#container").html(viewAssetShow.render().el);
      }
     });

    },

    index: function() {
      $("#container").empty();
      // render toolbar;
      $("#container").append(viewAssetToolbar.render().el);
      // render table
      $("#container").append(viewAssetTable.render().el);

      // construct the html

    },

    defaultAction: function(actions){
      // render asset_index
      this.navigate("index", {trigger: true});
    }

  });

  var initialize = function(){
    var app_router = new AppRouter;
    _.extend(window,Backbone.Events);
    Backbone.history.start();
  };
  return {
    initialize: initialize
  };
});
