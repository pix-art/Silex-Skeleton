/**
 * This function allowes you to do easy google event tracking
 * by adding data-ga-value and data-ga-action as attributes
 * to any object you want to track on a click a event.
 *
 * !!IMPORTANT: Some variables are needed so they are declared in settings.yml and created in base.html.twig
 **/
 
(function ($) {
    $.fn.track = function(options) {
    	var settings = $.extend({
    			id: null,
    			name: null,
                language: null,
    			value: 'data-ga-value',
    			action: 'data-ga-action',
                debug: false,
                gaAction: null,
                gaValue: null
        	}, options);

    	$('*[' + settings.value + '][' + settings.action + ']').bind('click', function(){
            var error = null;

    		settings.gaValue = $(this).attr(settings.value),
    		settings.gaAction = $(this).attr(settings.action);

            for (var setting in settings) {
                if(settings[setting] === null) {
                    error = 'no ' + setting + ' set';
                }
            }

            if(error === null) {
                if(settings.debug && console){
                    console.log(settings);
                }
                    
                _gaq.push([
                    '_trackEvent', 
                    settings.name, 
                    settings.gaAction, 
                    settings.id + '_' + settings.language + '_' + settings.gaValue
                ]);
            } else {
                if(settings.debug && console){
                    console.warn(error);
                }
            }
		});

		return this;
    };
}(jQuery));

$('body').track({
  debug : _ga_debug,
  id : _ga_project_id,
  name : _ga_project_name,
  language : _ga_language
});