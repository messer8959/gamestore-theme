jQuery(document).ready(function($){
			var file_frame;
			$('.gamestore-upload-image-button').on('click', function(e){
				e.preventDefault();
				var button = $(this);
				var field = button.closest('.term-group, .form-field').find('.news-category-icon-id');
				if ( file_frame ) { file_frame.open(); return; }
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Choose Icon',
					button: { text: 'Choose Icon' },
					multiple: false
				});
				file_frame.on('select', function(){
					var attachment = file_frame.state().get('selection').first().toJSON();
					field.val(attachment.id).trigger('change');
					var thumb = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
					button.closest('p').siblings('.news-category-image-preview').html('<img src="'+thumb+'" style="max-width=100px;height:auto;" />');
				});
				file_frame.open();
                
			});
            
			$('.gamestore-remove-image-button').on('click', function(e){
				e.preventDefault();
				var button = $(this);
				var field = button.closest('.term-group, .form-field').find('.news-category-icon-id');
				field.val('').trigger('change');
				button.closest('p').siblings('.news-category-image-preview').html('');
			});
		});