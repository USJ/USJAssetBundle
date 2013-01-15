define([
    "channel",
    "jquery",

    "text!template/asset_show.html",
    "text!template/asset_property_list.html",

    "collection/asset_property",
    "model/asset_property"],
    function(channel,$, tmplAssetShow, tmplAssetPropertyList, AssetPropertyCollection, AssetPropertyModel){
        var viewAssetShow = Backbone.View.extend({
            // using the asset that model defined, display and render the view
            template: _.template(tmplAssetShow),
            propertyTemplate: _.template(tmplAssetPropertyList),
            id: "asset-show",
            events: {
                "keypress #properties_new_key": "focusOnValue",
                "keypress #properties_new_value": "createProperty",
                "click .property-delete-btn": "deleteProperty"
            },
            focusOnValue: function(e) {
                if(e.keyCode != 9) return;
                if(!this.$("#properties_new_key").val()) return false;
            },
            createProperty: function(e) {
                if(e.keyCode != 13) return;
                if(!$("#properties_new_key").val() || !$("#properties_new_value").val() ) return;
                var newProperty = new AssetPropertyModel({
                    "property" :$("#properties_new_key").val(),
                    "value" :$("#properties_new_value").val()
                });
                this.assetPropertyCollection.add(newProperty);

                var that = this;
                this.renderProperty();

            },
            render: function() {
                //initialize the property collection
                this.assetPropertyCollection.reset(this.model.get('properties'));

                $(this.el).html(this.template(this.model.toJSON()));
                return this;
            },

            deleteProperty: function(e) {
                e.preventDefault();

                var property_id = $(e.target).parent().parent().data("property-id");
                var property_model = this.assetPropertyCollection.get(property_id);

                this.assetPropertyCollection.remove(property_model);

                this.renderProperty();
            },

            renderProperty: function() {
                // render the properties
                $(this.el).find("#asset_property")
                    .empty()
                    .append(this.propertyTemplate({"properties":this.assetPropertyCollection.toJSON()}));
            },

            blockView: function(ele){

            },

            initialize: function() {
                this.assetPropertyCollection = new AssetPropertyCollection;

                var that = this;

                // bind properties add event
                this.assetPropertyCollection.on("add", function(property) {
                    property.asset_id = that.model.get('id');
                    property.save();
                });

                this.assetPropertyCollection.on("remove", function(property) {
                    property.asset_id = that.model.get('id');
                    property.destroy();
                });
            }

        });

        return new viewAssetShow;
    }
);
