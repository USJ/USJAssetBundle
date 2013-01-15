/**
 * This is a Global event channel
 */
define(['backbone'], function (Backbone) {
    var channel = _.extend({}, Backbone.Events); 
    return channel;
});