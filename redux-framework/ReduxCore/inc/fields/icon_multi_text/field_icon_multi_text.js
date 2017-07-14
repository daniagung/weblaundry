/* global redux_change */

(function($){
    "use strict";
    $.redux.icon_multi_text = $.group || {};
    $(document).ready(function () {
        $.redux.icon_multi_text();
    });

    $.redux.icon_multi_text = function(){
		$('.redux-icon-multi-text-remove').live('click', function() {
			redux_change($(this));
			$(this).prev('input[type="text"]').val('');
			$(this).parent().slideUp('medium', function(){
				$(this).remove();
			});
		});
		
		$('.redux-icon-multi-text-add').click(function(){
			var number = parseInt($(this).attr('data-add_number'));
			var id = $(this).attr('data-id');
			var name = $(this).attr('data-name');
			var oldnum=$('#'+id+' li').length;

			for (var i = 0; i < number; i++) {
				var new_input = $('#'+id+' li:last-child').clone(true);

				new_input.find('.icon-selection-preview').remove();
				$('#'+id+' li:last-child').before(new_input);

				new_input.removeAttr('style');
				new_input.find('.regular-text,.icon-field').val('');
				new_input.find('.icon-field').attr('name' , name+'['+oldnum+'][icon]');
				new_input.find('.regular-text').each(function(){
					var labelName=$(this).data('field');
					$(this).attr('name', name+'['+(i+oldnum)+']['+labelName+']');
				});

			}
		});
    };
})(jQuery);