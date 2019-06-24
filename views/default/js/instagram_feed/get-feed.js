/**
 * Display Instagram Feed
 *
 * @package instagram_feed
 */

define(function(require) {
	
	var $ = require('jquery');
	var elgg = require('elgg');
	require('jquery-modal');	

	var token = accesstoken,
	num_photos = 15;

	$.when(
		// profile	
		$.ajax({
			url: 'https://api.instagram.com/v1/users/self',
			dataType: 'jsonp',
			type: 'GET',
			data: {access_token: token},
			success: function(data){
				
				avatar = data.data.profile_picture;
				username = data.data.username;
				posts = data.data.counts.media;
				followers = data.data.counts.followed_by;
				following = data.data.counts.follows;
				fullname = data.data.full_name;
				website = data.data.website;
				
				var profileHTML =
				
				'<div class="elgg-image"><img src="' + avatar + '"></div>' + 
				'<div class="elgg-body"><h3>' + username + '</h3>' + 
					'<div class="elgg-listing-imprint">' +
						'<span>' + posts + elgg.echo('instagram_feed:media') + '</span>' +
						'<span>' + followers + elgg.echo('instagram_feed:followed_by') + '</span>' + 
						'<span>'	+ following +  elgg.echo('instagram_feed:follows') + '</span>' +
					'</div>' + 
					'<div class="ptm"><strong>' + fullname + '</strong></div>' + 
					'<div><a target="_blank" href="' + website + '">' + website + '</a></div>' +
				'</div>' +  
				'<div>' +
					'<a target="_blank" class="elgg-anchor elgg-button elgg-button-instagram" href="https://www.instagram.com/' + username + '">' + 
					'<span class="elgg-icon elgg-icon-instagram elgg-anchor-icon fab fa-instagram"></span>' +
					'<span class="elgg-anchor-label">' + elgg.echo('instagram_feed:more') + '</span></a>' +
				'</div>'
				
				$("#instagram-user-info").append(profileHTML);			
							
				result = data;
			}
		})		
		
	).then(function() {
		// feed
		$.ajax({		
			url: 'https://api.instagram.com/v1/users/self/media/recent/',
			dataType: 'jsonp',
			type: 'GET',
			data: {access_token: token, count: num_photos},
			success: function(data){	
					  
				for(i = 0; i < data.data.length; i ++){
	
					avatar = result.data.profile_picture;
					username = result.data.username;				
					img = data.data[i].images.standard_resolution.url;
					likes = data.data[i].likes.count; 
					comments = data.data[i].comments.count;
					caption = data.data[i].caption.text;
					
					var feedHTML = 
	
					'<li><a href="#modal' + i + '" rel="modal:open">' + '<img title="' + caption + '" src="' + img + '"></a>' +
	
					'<div class="modal" id="modal' + i + '">' +
						'<div class="modal-dialog">' +
							'<div class="modal-content">' +
								'<div class="modal-body">' +
									'<img title="' + caption + '" src="' + img + '">' +
								'</div>' +
								'<div class="modal-footer">' +
									'<div class="modal-caption">' +
										'<div class="modal-caption-user">' +
											'<div class="elgg-avatar-small mrm"><img src="' + avatar + '"></div>' +
											'<div class="link"><a target="_blank" href="https://www.instagram.com/' + username + '">@' + username + '</a></div>' +
										'</div>' +
										'<div>' + caption + '</div>' +
										'<div class="modal-counts">' + likes + '<span>' + comments + '</span></div>' +
									'</div>' +
									'<div class="modal-button">' +
										'<a href="#" rel="modal:close" class="elgg-button elgg-button-action">' + elgg.echo('close') + '</a>' +
									'</div>' +
								'</div>' +
							'</div>' +
						'</div>' +
					'</div></li>'
					
					$("#instagram-feed-canvas").append(feedHTML);				
				} 
			}
		})
	});
	
	$(document).on('click.modal', 'a[rel="modal:open"]', function(event) {
		event.preventDefault();
		$(this).modal({
			fadeDuration: 200
		});
	});
});