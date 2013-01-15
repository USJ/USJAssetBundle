(function(){
    curl(['jquery','backbone','underscore','mdb_asset/view/asset_property_list']).then(
        function($, Backbone, _, assetProperyListView) {
            // assetProperyListView.render();
        },
        function (ex) {
            var msg = 'OH SNAP: ' + ex.message;
            alert(msg);
        }
    );
})();