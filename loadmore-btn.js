(function($){
	$('#loadmoreBtn a').ready(function(){
			$('#loadmoreBtn a').click(function(e){
			e.preventDefault();

			let button = $(this),
					buttonText = button.text();
					current_page = button.attr('data-current'),
					max_page = button.attr('data-max'),
					data = {
						'action': 'loadmore_btn',
						'current_page': current_page,
						'max_page': max_page,
					};

			$.ajax({
				url : params.ajaxurl,
				data : data,
				type : 'POST',
				beforeSend : function ( xhr ) {
					button.children('.deafult-text').css('display', 'none');
					button.children('.loading-text').css('display', 'block');
				},
				success : function( data ){
					if( data ) { 
						current_page++;

						button.parent().before(data);
						button.children('.loading-text').css('display', 'none');
						button.children('.deafult-text').css('display', 'block');
						button.attr('data-current', current_page);
						

						if ( current_page == max_page ) button.parents('.articles__more').remove();
						
					}else{
						button.parents('.articles__more').remove();
					}
				}
			});

		});
	});
	

})(jQuery);