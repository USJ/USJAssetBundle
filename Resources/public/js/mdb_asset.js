(function (jQuery, Underscore) {
    'use strict';
    var $ = jQuery,
        _ = Underscore,
        docCreateEl = $('#doc-create'),
        docResultsEl = $('#doc-search-results'),
        docSearchForm = docCreateEl.find('form.form-search.doc-search'),
        searchResultTmpl = _.template($("#search-results-template").html());

    // type a head for document search query.
    var docSearchInput = $(".doc-search .search-query");
    docSearchInput.typeahead(
        {
            'ajax' : {
                'url': Routing.generate('mdb_document_document_index',{'_format': 'json'}),
                'method' : 'GET',
                'triggerLength': 2,
                'preDispatch': function(query){
                    return {q: query};
                }
            },
            'display' : 'title',
            'val' : 'id',
            'itemSelected': function(item, val, text) {
                $("#doc-search-results").load(Routing.generate('mdb_document_document_show', {
                    'id': val
                }), function(){
                    $('.doc-embed-view input[name="object_id"]').val($("#asset_id").val());
                    $('.doc-embed-view input[name="object_class"]').val($("#asset_class").val());
                });
            }
        }
    );

    

})(jQuery, this._);
