import * as Init from '../init.js';
// import * as HttpRequest from '../classes/HttpRequest.Class.js';
// import * as WebAPIs from '../classes/WebAPIs.Class.js';
const hostname = Init.URL_API_MASTER_WS;
const DNWEB = Init.DNWEB;
const page = $('#xhrpage').attr('content');

WebAPIs_wsActiveHomeData();

function HttpRequestPost(request_data) {
	var response = "Initiated  -- " + request_data.request;
	$.ajax({
	  url: hostname,
	  type: "POST",
	  cache: false,
	  data: request_data,
	  success: function (dataResponse) {
		response = JSON.parse(dataResponse);
	  }
	});
	return response;
}

function formArticleCommentSubmit(article_token) {
	$('.iccn-article-comment-form').on('submit', function(){
	
		let name    = $('#name').val();
		let email   = $('#email').val();
		let website = $('#website').val();
		let comment = $('#comment').val();

		var form_data = {
			'request': 'iDh0HCtHN9csbx1qQbnykgsEHvUZwFFECfjdN3BVuXaq5HpN+RIqhpPGkeQTWPUd',
			'webToken': 'FZrp/HEwJwWCrAH303ypUQ',
			'article-token': article_token, 
			'article-name': name, 
			'article-email': email, 
			'article-website': website, 
			'article-comment': comment
		};

		$('.iccn-submission-feedback').html('');
		$('.iccn-submission-feedback').show();
		$.ajax({
		url: hostname,
		type: "POST",
		cache: false,
		data: form_data,
		success: function (dataResponse) {
			let response = JSON.parse(dataResponse);
			// $(".submitBtn").button('reset');
            $(".iccn-article-comment-form")[0].reset();
            $('.iccn-article-comment-form select').trigger("change");
			if(response.status == 1){
				let total_updated_count_comments = parseInt($('.iccn-html-description-article-comments').html()) + 1;
				$('.iccn-html-description-article-comments').html( total_updated_count_comments );
				$('.iccn-submission-feedback').html(`
					<span class="label label-success label-success-style" >
						Thank you ${name} for contacting ICCN. Your comment has been well received.
					</span>
				`);
				$('.iccn-submission-feedback').delay(6000).fadeOut(400);
			}
			else{
				$('.iccn-submission-feedback').html('');
			}
		}
		});
		return false;
	});
	return false;
}

function formContactUsSubmit() {
	$('.iccn-contact-us-form').on('submit', function(){
	
		let name      = $('#name').val();
		let email     = $('#email').val();
		let telephone = $('#telephone').val();
		let matiere   = $('#matiere').val();
		let comment   = $('#comment').val();

		var form_data = {
			'request': 'iDh0HCtHN9csbx1qQbnykg2Q/vplQM7dILl/EfwC6DuM++oOSMC2jc6zMWykY9w2',
			'webToken': 'FZrp/HEwJwWCrAH303ypUQ',
			'contact-name': name, 
			'contact-email': email, 
			'contact-telephone': telephone, 
			'contact-matiere': matiere, 
			'contact-comment': comment
		};

		$('.iccn-submission-feedback').html('');
		$('.iccn-submission-feedback').show();
		$.ajax({
		url: hostname,
		type: "POST",
		cache: false,
		data: form_data,
		success: function (dataResponse) {
			let response = JSON.parse(dataResponse);
            $(".iccn-contact-us-form")[0].reset();
            $('.iccn-contact-us-form select').trigger("change");
			if(response.status == 1){
				$('.iccn-submission-feedback').html(`
					<span class="label label-success label-success-style" >
						Thank you ${name} for contacting ICCN. Your request has been well received.
					</span>
				`);
				$('.iccn-submission-feedback').delay(6000).fadeOut(400);
			}
			else{
				$('.iccn-submission-feedback').html('');
			}
		}
		});
		return false;
	});
	return false;
}

function WebAPIs_wsActiveHomeData(){
	let request_data = {
		'request': 'oK3h5UtbqhIwfDjyki8SSxP+9lE+juq1AD/II5/tTvY',
		'webToken': 'FZrp/HEwJwWCrAH303ypUQ'
	};
	var response = "";
	$.ajax({
	  url: hostname,
	  type: "POST",
	  cache: false,
	  data: request_data,
	  success: function (dataResponse) {
		var response = JSON.parse(dataResponse);
		
		let response_data = response;
		if(response_data){
			if(response_data.status == 1){
				let data = response_data.data;

				let data_about = data.about;
				let data_service = data.service;
				let data_testimonial = data.testimonial;
				let data_gallery = data.gallery;
				let data_event_2 = data.event_2;
				let data_events = data.events;

				let data_article_2 = data.article_2;
				let data_articles = data.articles;

				let data_team = data.team;
				let data_partners = data.partner;
				let data_shops = data.shop;

				switch(page){
					case 'xhr_team':
						// Html About Description
						htmlWSICCNActiveAboutDescriptionMissionVisionObjective(data_about);

						// Html Team Members
						htmlWSICCNActiveTeamMembers(data_team);

						// html Partners
						htmlWSICCNActivePartners(data_partners);

						// Html Articles Last - Footer
						htmlWSICCNActiveArticlesLastFooter(data_article_2);
						
					break;

					case 'xhr_gallery':
						// Html Gallery Photos
						htmlWSICCNActiveGalleryPhotos(data_gallery);

						// Html Articles Last - Footer
						htmlWSICCNActiveArticlesLastFooter(data_article_2);

					break;

					case 'xhr_contact':
						// Html Contact 
						htmlWSICCNActiveContactEmailTelephoneAddress(data_about);

						// Handle Event Listener - Contact us Form
						formContactUsSubmit();
						
					break;

					case 'xhr_actualites':
						// Html Articles
						htmlWSICCNActiveArticles(data_articles);

						// Html Articles Last - Footer
						htmlWSICCNActiveArticlesLastFooter(data_article_2);

					break;

					case 'xhr_articles':
						let countpage = $('#xhrpage').attr('page');
						let tag = $('#xhrpage').attr('tag');
						// Html Articles
						htmlWSICCNActiveArticlesAll(data_articles, countpage, tag);

						// Html Articles Last - Footer
						htmlWSICCNActiveArticlesLastFooter(data_article_2);
						
						// Html Actualite
						htmlWSICCNActiveArticlesLast4Aside(data_articles);

					break;

					case 'xhr_actualite':
						let token_id = $('#xhrpage').attr('token');
						// Html Actualite Description
						htmlWSICCNActiveArticleDescription(data_articles, token_id);

						// Html Articles Last - Footer
						htmlWSICCNActiveArticlesLastFooter(data_article_2);

						// Html Actualite
						htmlWSICCNActiveArticlesLast4Aside(data_articles);

						// Handle Event Listener - Form Article Comment
						formArticleCommentSubmit(token_id);

					break;

					case 'xhr_events':
						// Html Articles
						htmlWSICCNActiveEvents(data_events);

						// Html Articles Last - Footer
						htmlWSICCNActiveArticlesLastFooter(data_article_2);

					break;

					case 'xhr_event':
						let tokenid = $('#xhrpage').attr('token');
						// Html Event Description
						htmlWSICCNActiveEventDescription(data_events, tokenid);

						// Html Articles Last - Footer
						htmlWSICCNActiveArticlesLastFooter(data_article_2);

					break;

					case 'xhr_shops':
						// Html Shops
						htmlWSICCNActiveShops(data_shops);

						// Html Articles Last - Footer
						htmlWSICCNActiveArticlesLastFooter(data_article_2);

					break;

					default:
						// Html Articles
						htmlWSICCNActiveGallery(data_gallery);

						// Html Testimonial
						htmlWSICCNActiveTestimonial(data_testimonial);

						// Html Events 2 Last
						htmlWSICCNActiveEventsLast2(data_event_2);

						// Html Home Articles
						htmlWSICCNActiveHomeArticles(data_articles, 3);

						// Html Articles Last - Footer
						htmlWSICCNActiveArticlesLastFooter(data_article_2);
					break;
				}

			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	  }
	});
	return response;
	
	
}

function fixedEncodeURIComponent (str) {
	return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
  }

// Html Testimonials
function htmlWSICCNActiveTestimonial(data_testimonial){
	let output = ``;
	if(data_testimonial){
		for(const index in data_testimonial){
			let data = data_testimonial[index];
			output += `
				<div class="tm-box-col-wrapper   col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<article class="themetechmount-box themetechmount-box-testimonial themetechmount-testimonialbox-styleone">
						<div class="themetechmount-post-item">
							<div class="themetechmount-box-content">
								<div class="themetechmount-box-author">	
									<div class="themetechmount-box-desc">
										<blockquote class="themetechmount-testimonial-text">
										${data.description}
										</blockquote>
									
										<div class="themetechmount-ratting-star">  <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i>  <i class="fa fa-star" aria-hidden="true"></i> 
										</div>	
									</div>
									<div class="tm-box-footer tm-wrap">
										<div class="themetechmount-box-img tm-wrap-cell">
												
											<span class="themetechmount-item-thumbnail">
												<span class="themetechmount-item-thumbnail-inner">
													<noscript>
													<img width="150" height="150" src="${data.image}" class="attachment-thumbnail size-thumbnail wp-post-image" alt="" data-id="6140" />
													</noscript>
													
													<img width="150" height="150" src='${data.image}' 
													data-src="${data.image}" class="lazyload attachment-thumbnail size-thumbnail wp-post-image" alt="" data-id="6140" />
												</span>
											</span>					
										</div>
										<div class="themetechmount-box-title tm-wrap-cell">
											<span class="themetechmount-box-footer">${data.profession}</span>
											<h3 class="themetechmount-author-name">${data.name}</h3>					
										</div>
									</div>
								</div>			
							</div>
						</div>
					</article>
				</div>

			`;
		}
	}
	$('.iccn-html-testimonials').html(output);
}

// Html Events Last 2
function htmlWSICCNActiveEventsLast2(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			output += `
				<div class="tm-box-col-wrapper   col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<article class="themetechmount-box themetechmount-box-events themetechmount-events-box-style1">
						<div class="themetechmount-post-item">
						<div class="col-md-5 themetechmount-box-img-left">
								<div class="themetechmount-post-item-inner">
									<div class="tm-featured-wrapper tm-tribe_events-featured-wrapper">
									<a href="${DNWEB}event/${data.token_id}/${ data.token_name }">
										<noscript>
											<img width="400" height="360" src="${data.image}" class="attachment-themetechmount-img-event-left size-themetechmount-img-event-left wp-post-image" alt="" data-id="6129" />
										</noscript>
										<img width="400" height="360" src='${data.image}' 
										data-src="${data.image}" class="lazyload attachment-themetechmount-img-event-left size-themetechmount-img-event-left wp-post-image" alt="" data-id="6129" /></a>
									</div>			
									<div class="themetechmount-meta-date "><span class="themetechmount-event-meta-item themetechmount-event-date"> <span class="themetechmount-event-meta-dtstart"> 22<span class="entry-month">Oct</span> </span><span class="themetechmount-event-meta-dtend">8:00 am </span> </span></div>			</div>
							</div>
							<div class="themetechmount-box-content col-md-7">
								<div class="themetechmount-box-bottom-content">
									<div class="themetechmount-box-meta themetechmount-events-meta"><div class="tribe-events-vanue"> <i class="fa fa-map-marker" aria-hidden="true"></i> 
										${data.address}
									</div>
									<div class="themetechmount-meta-details themetechmount-event-meta-details"><span class="themetechmount-event-meta-item themetechmount-event-date"> <i class="fa fa-clock-o"></i> 
										<span class="themetechmount-event-meta-dtstart"> 22 Oct 2021 </span>
										<span class="sep">-</span> <span class="themetechmount-event-meta-dtend">8:00 am </span> </span>
									</div>
								</div>
								<div class="themetechmount-box-title"><div class="themetechmount-box-title"><h4><a href="${DNWEB}event/${data.token_id}/${ data.token_name }">${data.name}</a></h4></div></div>
								<div class="themetechmount-box-desc">${data.description_short} <div class="themetechmount-post-readmore"><a href="${DNWEB}event/${data.token_id}/${ data.token_name }">See Event</a></div></div>
								</div>
							</div>
						</div>
					</article>
				</div>

			`;
		}
	}
	$('.iccn-html-last-events').html(output);
}



// Html Articles 
function htmlWSICCNActiveHomeArticles(data_array, limit){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			if(index >= limit)
				break;
			let data = data_array[index];
			output += `
				<div class="tm-box-col-wrapper  animal-Iccn col-lg-4 col-sm-6 col-md-4 col-xs-12">
					<article class="themetechmount-box themetechmount-box-blog themetechmount-blogbox-stylethree themetechmount-blogbox-format- ">
						<div class="post-item">
							<div class="themetechmount-box-content">
								<div class="tm-featured-outer-wrapper tm-post-featured-outer-wrapper">
									<div class="tm-featured-wrapper tm-post-featured-wrapper tm-post-format-">
										<a href="${DNWEB}article/${data.token_id}/${ data.token_name }">
											<noscript>
												<img width="650" height="510" src="${data.image}" class="attachment-themetechmount-img-blog-top size-themetechmount-img-blog-top wp-post-image" alt="" data-id="6131" />
											</noscript>
											<img width="650" height="510" 
												src='${data.image}' 
												data-src="${data.image}" 
												class="lazyload attachment-themetechmount-img-blog-top size-themetechmount-img-blog-top wp-post-image" alt="" data-id="6131" />
										</a>
									</div>			
									<a class="tmmpost-link" href="${DNWEB}article/${data.token_id}/${ data.token_name }" rel="bookmark"><i class="tm-wilddale-icon-plus-1"></i></a>
								</div>	
								<div class="themetechmount-box-desc">
									<div class="tm-blog-post-cat">
										<span class="tm-meta-line cat-links"><span class="screen-reader-text tm-hide">Categories </span><a href="#" rel="category tag">ICCN</a></span>
									</div>
									<div class="entry-header">
										<div class="tm-entry-meta-wrapper"><div class="entry-meta tm-entry-meta tm-entry-meta-blogbox"><span class="tm-meta-line byline">
										<i class="fa fa-user tm-hide"></i>
										<noscript><img alt='' src='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_32,h_32/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-32x32.jpg' srcset='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-64x64.jpg 2x' class='avatar avatar-32 photo' height='32' width='32' />
										</noscript><img alt='' src='https://sp-ao.shortpixel.ai/client/q_lqip,ret_wait,w_32,h_32/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-32x32.jpg' data-src='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_32,h_32/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-32x32.jpg' 
										data-srcset='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-64x64.jpg 2x' class='lazyload avatar avatar-32 photo' height='32' width='32' />
										
										<span class="author vcard"><span class="screen-reader-text cmt-hide">Author </span>
										<a class="url fn n" href="#">ICCN</a></span></span>
										<span class="tm-meta-line posted-on"><i class="tm-wilddale-icon-calendar-outlilne"></i> 
										<span class="screen-reader-text tm-hide">Posted on </span><a href="#" rel="bookmark">
										<span class="entry-date published">${data.publish_date}</span>
										<span class="updated tm-hide">${data.publish_time}</span></a></span>
										<span class="tm-meta-line comments-link"><i class="tm-wilddale-icon-comment-1"></i> 
										<a href="#" class="count_comments" >${data.count_comments} Comments</a></span></div></div>					
										
										<div class="themetechmount-box-title"><h4><a href="${DNWEB}article/${data.token_id}/${ data.token_name }">${data.name}</a></h4></div>					
										<div class="themetechmount-box-desc-text">${data.description_short}</div>		
										<div class="themetechmount-blogbox-desc-footer themetechmount-blogbox-footer-readmore">
										<div class="themetechmount-blogbox-footer-left themetechmount-wrap-cell"><a href="${DNWEB}article/${data.token_id}/${ data.token_name }">Lire la suite +</a></div>					
										</div>			
									</div> 
								</div>
							</div>
						</div>
					</article>
				</div>

			`;
		}
	}
	$('.iccn-html-home-articles').html(output);
}

// Html Articles 
function htmlWSICCNActiveArticles(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			output += `
				<div class="tm-box-col-wrapper  animal-Iccn col-lg-4 col-sm-6 col-md-4 col-xs-12">
					<article class="themetechmount-box themetechmount-box-blog themetechmount-blogbox-stylethree themetechmount-blogbox-format- ">
						<div class="post-item">
							<div class="themetechmount-box-content">
								<div class="tm-featured-outer-wrapper tm-post-featured-outer-wrapper">
									<div class="tm-featured-wrapper tm-post-featured-wrapper tm-post-format-">
										<a href="${DNWEB}article/${data.token_id}/${ data.token_name }">
											<noscript>
												<img width="650" height="510" src="${data.image}" class="attachment-themetechmount-img-blog-top size-themetechmount-img-blog-top wp-post-image" alt="" data-id="6131" />
											</noscript>
											<img width="650" height="510" 
												src='${data.image}' 
												data-src="${data.image}" 
												class="lazyload attachment-themetechmount-img-blog-top size-themetechmount-img-blog-top wp-post-image" alt="" data-id="6131" />
										</a>
									</div>			
									<a class="tmmpost-link" href="${DNWEB}article/${data.token_id}/${ data.token_name }" rel="bookmark"><i class="tm-wilddale-icon-plus-1"></i></a>
								</div>	
								<div class="themetechmount-box-desc">
									<div class="tm-blog-post-cat">
										<span class="tm-meta-line cat-links"><span class="screen-reader-text tm-hide">Categories </span><a href="#" rel="category tag">ICCN</a></span>
									</div>
									<div class="entry-header">
										<div class="tm-entry-meta-wrapper"><div class="entry-meta tm-entry-meta tm-entry-meta-blogbox"><span class="tm-meta-line byline">
										<i class="fa fa-user tm-hide"></i>
										<noscript><img alt='' src='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_32,h_32/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-32x32.jpg' srcset='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-64x64.jpg 2x' class='avatar avatar-32 photo' height='32' width='32' />
										</noscript><img alt='' src='https://sp-ao.shortpixel.ai/client/q_lqip,ret_wait,w_32,h_32/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-32x32.jpg' data-src='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_32,h_32/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-32x32.jpg' 
										data-srcset='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-64x64.jpg 2x' class='lazyload avatar avatar-32 photo' height='32' width='32' />
										
										<span class="author vcard"><span class="screen-reader-text cmt-hide">Author </span>
										<a class="url fn n" href="#">John Doe</a></span></span>
										<span class="tm-meta-line posted-on"><i class="tm-wilddale-icon-calendar-outlilne"></i> 
										<span class="screen-reader-text tm-hide">Posted on </span><a href="#" rel="bookmark">
										<span class="entry-date published">${data.publish_date}</span>
										<span class="updated tm-hide">${data.publish_time}</span></a></span>
										<span class="tm-meta-line comments-link"><i class="tm-wilddale-icon-comment-1"></i> 
										<a href="##respond">${data.count_comments} Comments</a></span></div></div>					
										
										<div class="themetechmount-box-title"><h4><a href="${DNWEB}article/${data.token_id}/${ data.token_name }">${data.name}</a></h4></div>					
										<div class="themetechmount-box-desc-text">${data.description_short}</div>		
										<div class="themetechmount-blogbox-desc-footer themetechmount-blogbox-footer-readmore">
										<div class="themetechmount-blogbox-footer-left themetechmount-wrap-cell"><a href="${DNWEB}article/${data.token_id}/${ data.token_name }">Lire la suite +</a></div>					
										</div>			
									</div>
								</div>
							</div>
						</div>
					</article>
				</div>

			`;
		}
	}
	$('.iccn-html-articles').html(output);
}

function countPageLimitMin(countPage){
	let limit_min = 0, rowsnumber = 5;
	return limit_min ;

}

// Html Articles 
function htmlWSICCNActiveArticlesAll(data_array, countpage, tag){

	let array_size = data_array.length;

	let limit_min = 0, limit_max, rowsnumber = 5;
	if( countpage == 1 ){
		limit_min = 0;
		limit_max = rowsnumber; // 5
	}
	else if( countpage > 1 ){
		limit_min = ( parseInt(rowsnumber) * ( parseInt(countpage) - 1 ) ); // 5
		limit_max = ( parseInt(rowsnumber) + parseInt(limit_min) ); // 10
	}
	else{
		limit_min = 0;
		limit_max = rowsnumber;
	}

	let output = ``;
	if(data_array){
		for(const index in data_array){
			if( index >= limit_min && index < limit_max ){
				let data = data_array[index];
				output += `
					<article class="themetechmount-box post themetechmount-box-blog-classic themetechmount-blogbox-format- post-5238 type-post status-publish format-standard has-post-thumbnail hentry category-animal-zoo tag-animal tag-bird">
				
						<div class="tm-featured-outer-wrapper tm-post-featured-outer-wrapper">
					
							<div class="tm-featured-wrapper tm-post-featured-wrapper tm-post-format-">
								<a href="${DNWEB}article/${data.token_id}/${ data.token_name }">
									<noscript>
										<img width="790" height="480" src="${data.image}" class="attachment-themetechmount-img-blog size-themetechmount-img-blog wp-post-image" alt="" data-id="6131" />
									</noscript>
									<img width="790" height="480" src='${data.image}' 
									data-src="${data.image}" class="lazyload attachment-themetechmount-img-blog size-themetechmount-img-blog wp-post-image" alt="" data-id="6131" />
								</a>
							</div>	
							<div class="tm-blogbox-cat">
								<span class="tm-meta-line cat-links">
									<span class="screen-reader-text tm-hide">
										Categories 
									</span>
									<a href="#" rel="category tag">
										ICCN
									</a>
								</span>		
							</div>
						</div>
				
						<div class="tm-blog-classic-box-content ">
							<header class="entry-header">
									
								<div class="tm-classic-footer-meta">
									<div class="tm-entry-meta-wrapper">
										<div class="entry-meta tm-entry-meta tm-entry-meta-blogclassic">
											<span class="tm-meta-line byline">
												<i class="fa fa-user tm-hide"></i>
												<span class="author vcard">
													<span class="screen-reader-text cmt-hide">Author </span>
													<a class="url fn n" href="">ICCN</a>
												</span>
											</span>
											<span class="tm-meta-line posted-on">
												<i class="tm-wilddale-icon-calendar-outlilne"></i> 
												<span class="screen-reader-text tm-hide">Posted on </span>
												<a href="${DNWEB}article/${data.token_id}/${ data.token_name }" rel="bookmark">
												<span class="entry-date published">${data.publish_date}</span>
												<span class="updated tm-hide">${data.publish_date}</span></a></span>
												<span class="tm-meta-line comments-link"><i class="tm-wilddale-icon-comment-1"></i> 
												<a href="${DNWEB}article/${data.token_id}/${ data.token_name }#respond">${data.count_comments} Comments</a>
											</span>
										</div>
									</div>		
								</div>
								
								<h2 class="entry-title"><a href="${DNWEB}article/${data.token_id}/${ data.token_name }" rel="bookmark">${data.name}</a></h2>							
							</header>
							<div class="entry-content">
								<div class="themetechmount-box-desc-text">
									${ data.description_short }
								</div>		
								<div class="themetechmount-blogbox-desc-footer">
									<div class="themetechmount-blogbox-footer-readmore">
										<div class="themetechmount-blogbox-footer-left themetechmount-wrap-cell">
											<a href="${DNWEB}article/${data.token_id}/${ data.token_name }">
											Lire la suite +
											</a>
										</div>				
									</div>
													
									
										<div class="clearfix"></div>	
									</div>
												
								</div>	
								<div class="clear clr"></div>		
										
							</div><!-- .entry-content -->
						</div>
					</article>

				`;
			}
		}

		let active_page_number = '';
		if( countpage == 1 )
			active_page_number = 'current';

		output += `
			<div class="clearfix"></div>
			<div class="themetechmount-pagination">
				<a class="page-numbers page-numbers ${active_page_number} " href="${DNWEB}articles/1">1</a>
		`;

		let count_i , count_page = 1;
		for( count_i = rowsnumber; count_i < array_size; count_i = count_i + rowsnumber){
			count_page++;
			active_page_number = '';
			if( countpage == count_page )
				active_page_number = 'current';

			output += `
				<a class="page-numbers page-numbers ${active_page_number} " href="${DNWEB}articles/${count_page}">${count_page}</a>
			`;
		}

		output += `
			</div>	
		`;
	}
	$('.iccn-html-content-articles').html(output);
}

// Html Articles 
function htmlWSICCNActiveEvents(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			output += `
				<div class="tm-box-col-wrapper  animal-Iccn col-lg-4 col-sm-6 col-md-4 col-xs-12">
					<article class="themetechmount-box themetechmount-box-blog themetechmount-blogbox-stylethree themetechmount-blogbox-format- ">
						<div class="post-item">
							<div class="themetechmount-box-content">
								<div class="tm-featured-outer-wrapper tm-post-featured-outer-wrapper">
									<div class="tm-featured-wrapper tm-post-featured-wrapper tm-post-format-">
										<a href="${DNWEB}event/${data.token_id}/${ data.token_name }">
											<noscript>
												<img width="650" height="510" src="${data.image}" class="attachment-themetechmount-img-blog-top size-themetechmount-img-blog-top wp-post-image" alt="" data-id="6131" />
											</noscript>
											<img width="650" height="510" 
												src='${data.image}' 
												data-src="${data.image}" 
												class="lazyload attachment-themetechmount-img-blog-top size-themetechmount-img-blog-top wp-post-image" alt="" data-id="6131" />
										</a>
									</div>			
									<a class="tmmpost-link" href="${DNWEB}event/${data.token_id}/${ data.token_name }" rel="bookmark"><i class="tm-wilddale-icon-plus-1"></i></a>
								</div>	
								<div class="themetechmount-box-desc">
									<div class="tm-blog-post-cat">
										<span class="tm-meta-line cat-links"><span class="screen-reader-text tm-hide">Categories </span><a href="#" rel="category tag">ICCN</a></span>
									</div>
									<div class="entry-header">
										<div class="tm-entry-meta-wrapper"><div class="entry-meta tm-entry-meta tm-entry-meta-blogbox"><span class="tm-meta-line byline">
										<i class="fa fa-user tm-hide"></i>
										<noscript><img alt='' src='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_32,h_32/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-32x32.jpg' srcset='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-64x64.jpg 2x' class='avatar avatar-32 photo' height='32' width='32' />
										</noscript><img alt='' src='https://sp-ao.shortpixel.ai/client/q_lqip,ret_wait,w_32,h_32/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-32x32.jpg' data-src='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img,w_32,h_32/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-32x32.jpg' 
										data-srcset='https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img/https://www.themetechmount.com/wordpress/wilddale/wp-content/uploads/2021/09/Team-1-64x64.jpg 2x' class='lazyload avatar avatar-32 photo' height='32' width='32' />
										
										<span class="author vcard"><span class="screen-reader-text cmt-hide">Author </span>
										<a class="url fn n" href="#">ICCN</a></span></span>
										<span class="tm-meta-line comments-link"><i class="tm-wilddale-icon-comment-1"></i> 
										<a href="##respond">${data.address}</a></span></div></div>		
										<span class="tm-meta-line posted-on"><i class="tm-wilddale-icon-calendar-outlilne"></i> 
										<span class="screen-reader-text tm-hide">Posted on </span><a href="#" rel="bookmark">
										<span class="entry-date published">${data.publish_date}</span>
										<span class="updated tm-hide">${data.publish_time}</span></a></span>
										<span class="entry-date published">${data.publish_time}</span>
													
										
										<div class="themetechmount-box-title"><h4><a href="${DNWEB}event/${data.token_id}/${ data.token_name }">${data.name}</a></h4></div>					
										<div class="themetechmount-box-desc-text">${data.description_short}</div>		
										<div class="themetechmount-blogbox-desc-footer themetechmount-blogbox-footer-readmore">
										<div class="themetechmount-blogbox-footer-left themetechmount-wrap-cell"><a href="${DNWEB}event/${data.token_id}/${ data.token_name }">See Event +</a></div>					
										</div>			
									</div>
								</div>
							</div>
						</div>
					</article>
				</div>

			`;
		}
	}
	$('.iccn-html-articles').html(output);
}


// Html Articles 
function htmlWSICCNActiveShops(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			output += `
				<div class="card  col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="imgBx">
						<img src="${data.image}">
					</div>
					<div class="contextBx">
						<h3>${data.name}</h3>
						<h2 class="price">${data.currency} ${data.price}</h2>
						<a href="${Init.SHOP_CHAT_WHATSAPP}" class="buy">Acheter</a>
					</div>
				</div>

			`;
		}
	}
	$('.iccn-html-shop-items').html(output);
}

// Html Active Gallery - Home Page
function htmlWSICCNActiveGallery(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			output += `
				<div class="tm-box-col-wrapper  mamalds col-lg-20percent col-sm-4 col-md-4 col-xs-12">
					<article class="themetechmount-box themetechmount-box-portfolio themetechmount-portfoliobox-style1  tm-post-format-image">
						<div class="themetechmount-post-item">	
							<div class="themetechmount-post-item-inner">
								<span class="themetechmount-item-thumbnail">
									<span class="themetechmount-item-thumbnail-inner">
										<noscript>
											<img width="740" height="800" 
											src="${data.image}" class="attachment-themetechmount-img-portfolio size-themetechmount-img-portfolio wp-post-image" alt="" data-id="9328" />
										</noscript>
										<img width="740" height="800" src='${data.image}' 
										data-src="${data.image}" class="lazyload attachment-themetechmount-img-portfolio size-themetechmount-img-portfolio wp-post-image" alt="" data-id="9328" />
									</span>
								</span>		
							</div>	
							<div class="themetechmount-box-content themetechmount-overlay">			
								<div class="themetechmount-box-content-inner">	
									<div class="item-content-box tm-hide">
										<div class="themetechmount-box-title"><h4>Tiger</h4></div>				
									</div>	
									<div class="themetechmount-icon-box themetechmount-media-link"><a class="tm_prettyphoto" title="Tiger" href="${data.image}"><i class="tm-wilddale-icon-resize-full-alt"></i></a></div>
								</div>	
							</div>		
						</div>
					</article>
				</div>

			`;
		}
	}
	$('.iccn-html-home-gallery').html(output);

	var	tpj = jQuery;

		var	revapi2;

		if(window.RS_MODULES === undefined) window.RS_MODULES = {};
		if(RS_MODULES.modules === undefined) RS_MODULES.modules = {};
		RS_MODULES.modules["revslider21"] = {once: RS_MODULES.modules["revslider21"]!==undefined ? RS_MODULES.modules["revslider21"].once : undefined, init:function() {
			window.revapi2 = window.revapi2===undefined || window.revapi2===null || window.revapi2.length===0  ? document.getElementById("rev_slider_2_1") : window.revapi2;
			if(window.revapi2 === null || window.revapi2 === undefined || window.revapi2.length==0) { window.revapi2initTry = window.revapi2initTry ===undefined ? 0 : window.revapi2initTry+1; if (window.revapi2initTry<20) requestAnimationFrame(function() {RS_MODULES.modules["revslider21"].init()}); return;}
			window.revapi2 = jQuery(window.revapi2);
			if(window.revapi2.revolution==undefined){ revslider_showDoubleJqueryError("rev_slider_2_1"); return;}
			revapi2.revolutionInit({
					revapi:"revapi2",
					DPR:"dpr",
					sliderLayout:"fullwidth",
					visibilityLevels:"1240,1240,778,480",
					gridwidth:"1300,1300,778,480",
					gridheight:"800,800,450,350",
					lazyType:"smart",
					perspective:600,
					perspectiveType:"global",
					editorheight:"800,768,450,350",
					responsiveLevels:"1240,1240,778,480",
					progressBar:{disableProgressBar:true},
					navigation: {
						wheelCallDelay:1000,
						onHoverStop:false,
						arrows: {
							enable:true,
							style:"hephaistos",
							hide_onmobile:true,
							hide_under:"1380px",
							left: {
								h_align:"right",
								h_offset:50,
								v_offset:-70
							},
							right: {
								h_offset:50
							}
						}
					},
					viewPort: {
						global:true,
						globalDist:"-200px",
						enable:false
					},
					fallbacks: {
						allowHTML5AutoPlayOnAndroid:true
					},
			});
			
		}} // End of RevInitScript

		if (window.RS_MODULES.checkMinimal!==undefined) { window.RS_MODULES.checkMinimal();};
}

// Html Events Last 2
function htmlWSICCNActiveGalleryPhotos(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			output += `
				<div class="tm-box-col-wrapper  mamalds col-lg-4 col-sm-6 col-md-4 col-xs-12">
					<article class="themetechmount-box themetechmount-box-portfolio themetechmount-portfoliobox-style1  tm-post-format-image">
						<div class="themetechmount-post-item">	
							<div class="themetechmount-post-item-inner">
								
							<span class="themetechmount-item-thumbnail">
								<span class="themetechmount-item-thumbnail-inner">
									<noscript>
										<img width="740" height="800" 
										src="${data.image}" class="attachment-themetechmount-img-portfolio size-themetechmount-img-portfolio wp-post-image" alt="" data-id="9328" />
									</noscript>
									<img width="740" height="800" 
									src='${data.image}' 
									data-src="${data.image}" class="lazyload attachment-themetechmount-img-portfolio size-themetechmount-img-portfolio wp-post-image" alt="" data-id="9328" />
								</span>
							</span>		</div>	
							<div class="themetechmount-box-content themetechmount-overlay">			
								<div class="themetechmount-box-content-inner">	
									<div class="item-content-box tm-hide">
										<div class="themetechmount-box-title"><h4>Tiger</h4></div>				
									</div>	
									<div class="themetechmount-icon-box themetechmount-media-link"><a class="tm_prettyphoto" title="Tiger" 
									href="${data.image}"><i class="tm-wilddale-icon-resize-full-alt"></i></a></div>
								</div>	
							</div>		
						</div>
					</article>
				</div>

			`;
		}
	}
	$('.iccn-html-gallery-photos').html(output);
}

// Html Artcles Last 2 - Footer
function htmlWSICCNActiveArticlesLastFooter(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			output += `
				<li class="tm-recent-post-list-li">
					<a href="${DNWEB}article/${data.token_id}/${ data.token_name }">
						<noscript>
							<img width="150" height="150" 
							src="${data.image}" class="attachment-thumbnail size-thumbnail wp-post-image" alt="" 
							srcset="${data.image} 150w, ${data.image} 100w" sizes="(max-width: 150px) 100vw, 150px" data-id="6131" />
						</noscript>
						<img width="150" height="150" 
						src='${data.image}' 
						data-src="${data.image}" class="lazyload attachment-thumbnail size-thumbnail wp-post-image" alt="" 
						data-srcset="${data.image} 150w, ${data.image} 100w" data-sizes="(max-width: 150px) 100vw, 150px" data-id="6131" />
					</a>
					<div class="post-detail">
						<a href="${DNWEB}article/${data.token_id}/${ data.token_name }">${data.name}</a>
						<span class="post-date"><i class="fa-solid fa-calendar-days"></i>${data.publish_date}</span>
					</div>
				</li>

			`;
		}
	}
	$('.iccn-html-home-footer-articles-last').html(output);
}


// Html Artcles Last 2 - Footer
function htmlWSICCNActiveArticlesLast4Aside(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			if(index  > 3)
				break;
			let data = data_array[index];
			output += `
				<li class="tm-recent-post-list-li">
					<a href="${DNWEB}article/${data.token_id}/${ data.token_name }">
						<noscript>
							<img width="150" height="150" 
							src="${data.image}" class="attachment-thumbnail size-thumbnail wp-post-image" alt="" 
							srcset="${data.image} 150w, ${data.image} 100w" sizes="(max-width: 150px) 100vw, 150px" data-id="6131" />
						</noscript>
						<img width="150" height="150" 
						src='${data.image}' 
						data-src="${data.image}" class="lazyload attachment-thumbnail size-thumbnail wp-post-image" alt="" 
						data-srcset="${data.image} 150w, ${data.image} 100w" data-sizes="(max-width: 150px) 100vw, 150px" data-id="6131" />
					</a>
					<div class="post-detail">
						<a href="${DNWEB}article/${data.token_id}/${ data.token_name }">${data.name}</a>
						<span class="post-date"><i class="fa-solid fa-calendar-days"></i>${data.publish_date}</span>
					</div>
				</li>

			`;
		}
	}
	$('.iccn-html-home-aside-articles-last-4').html(output);
}

// Html About - Description - Mission - Vision - Objective
function htmlWSICCNActiveAboutDescriptionMissionVisionObjective(data_array){
	let output = ``;
	if(data_array){
		$('.iccn-html-about-description').html(data_array.description);
		$('.iccn-html-about-mission').html(data_array.mission);
		$('.iccn-html-about-vision').html(data_array.vision);
		$('.iccn-html-about-general_objective').html(data_array.general_objective);
	}
	// $('.iccn-html-about-description').html(output);
}

// Html About - Description - Mission - Vision - Objective
function htmlWSICCNActiveContactEmailTelephoneAddress(data_array){
	let output = ``;
	if(data_array){
		$('.iccn-html-contact-org-email').html(data_array.email);
		$('.iccn-html-contact-org-telephone').html(data_array.telephone);
		$('.iccn-html-contact-org-address').html(data_array.address);
	}
}

// Html Team Members
function htmlWSICCNActiveTeamMembers(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			output += `
				<div class="tm-box-col-wrapper   col-lg-3 col-sm-6 col-md-3 col-xs-12">
					<article class="themetechmount-box themetechmount-box-team themetechmount-teambox-style1">
						<div class="themetechmount-post-item">
							<div class="themetechmount-content-inner">
								<div class="themetechmount-team-image-box">
									
							<span class="themetechmount-item-thumbnail">
								<span class="themetechmount-item-thumbnail-inner">
									<noscript>
									<img width="360" height="340" 
									src="${data.image}" class="attachment-themetechmount-img-team-member size-themetechmount-img-team-member wp-post-image" alt="" data-id="9632" />
									</noscript>
									<img width="360" height="340" src='${data.image}' 
									data-src="${data.image}" class="lazyload attachment-themetechmount-img-team-member size-themetechmount-img-team-member wp-post-image" alt="" data-id="9632" />
								</span>
							</span>				
							</div>
							</div>
							<div class="themetechmount-box-content">
								<div class="themetechmount-overlay">
								<div class="themetechmount-innercontent-box">			
									<div class="themetechmount-team-position">
										<div class="themetechmount-box-title"><h4><a href="#">${data.name}</a></h4></div>	
										${data.name}</div>			
								<div class="tm-member-social">
									<div class="themetechmount-team-icon"><i class="tm-wilddale-icon-plus"></i></div>
									<div class="themetechmount-box-social-links">
									<div class="tm-team-social-links-wrapper">
										<ul class="tm-team-social-links">
											<li><a href="${data.link_facebook}" target="_blank"><i class="tm-wilddale-icon-facebook"></i><span class="tm-hide">Facebook</span></a></li>
											<li><a href="${data.link_tweeter}" target="_blank"><i class="tm-wilddale-icon-twitter"></i><span class="tm-hide">Twitter</span></a></li>
											<li><a href="${data.link_instagram}" target="_blank"><i class="tm-wilddale-icon-instagram"></i><span class="tm-hide">Instagram</span></a></li>
											<li><a href="${data.link_linkedin}" target="_blank"><i class="tm-wilddale-icon-linkedin"></i><span class="tm-hide">LinkedIn</span></a></li>
										</ul> 
										<!-- .tm-team-social-links --> </div> <!-- .tm-team-social-links-wrapper --> 
									</div>
								</div>
								</div>	
								</div>			
							</div>		
						</div>
					</article>
				</div>

			`;
		}
	}
	$('.iccn-html-team-members').html(output);
}

// Html Team Members
function htmlWSICCNActivePartners(data_array){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			output += `
				<div class="tm-box-col-wrapper   col-lg-20percent col-sm-4 col-md-4 col-xs-12">
					<span class="themetechmount-box themetechmount-box-client themetechmount-box-view-simple-logo themetechmount-client-box-view-simple-logo">
						<span class="themetechmount-item-thumbnail">
							<span class="themetechmount-item-thumbnail-inner">
								<noscript>
									<img width="150" height="125" 
										src="${data.image}" class="attachment-full size-full wp-post-image" alt="" data-id="10274" />
								</noscript>
								<img width="150" height="125" 
								src='${data.image}' 
								data-src="${data.image}" class="lazyload attachment-full size-full wp-post-image" alt="" data-id="10274" />
							</span>
						</span>
					</span>
				</div>

			`;
		}
	}
	$('.iccn-html-partners').html(output);
}


// Html Actuality - Description
function htmlWSICCNActiveArticleDescription(data_array, xhr_token){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			if(data.token_id == xhr_token){
				$('.iccn-html-description-article-title').html(data.name);
				$('.iccn-html-description-article-title-h4').html(data.name);
				$('.iccn-html-description-article-publish-date').html(data.publish_date);
				$('.iccn-html-description-article-description').html(data.description);
				$('.iccn-html-description-article-comments').html(data.count_comments);

				$('.iccn-html-description-article-image-media').html(`
				
					<noscript>
						<img width="1200" height="800" 
						src="${data.image}" class="attachment-full size-full wp-post-image" alt="" 
						srcset="${data.image} 1200w, 
						${data.image} 300w, 
						${data.image} 1024w, 
						${data.image} 768w" sizes="(max-width: 1200px) 100vw, 1200px" data-id="6133" />
					</noscript>
					<img width="1200" height="800" 
						src='${data.image}' 
						data-src="${data.image}" 
						class="lazyload attachment-full size-full wp-post-image" alt="" 
						data-srcset="${data.image} 1200w, ${data.image} 300w, ${data.image} 1024w, ${data.image} 768w" data-sizes="(max-width: 1200px) 100vw, 1200px" data-id="6133" 
					/>
				
				`);
				return true;
			}
		}
		
	}
}

// Html Event - Description
function htmlWSICCNActiveEventDescription(data_array, xhr_token){
	let output = ``;
	if(data_array){
		for(const index in data_array){
			let data = data_array[index];
			if(data.token_id == xhr_token){
				$('.iccn-html-description-article-title').html(data.name);
				$('.iccn-html-description-article-title-h4').html(data.name);
				$('.iccn-html-description-article-publish-date').html(data.publish_date);
				$('.iccn-html-description-article-description').html(data.description);
				$('.iccn-html-description-article-schedule').html(data.schedule);

				$('.iccn-html-description-article-image-media').html(`
				
					<noscript>
						<img width="1200" height="800" 
						src="${data.image}" class="attachment-full size-full wp-post-image" alt="" 
						srcset="${data.image} 1200w, 
						${data.image} 300w, 
						${data.image} 1024w, 
						${data.image} 768w" sizes="(max-width: 1200px) 100vw, 1200px" data-id="6133" />
					</noscript>
					<img width="1200" height="800" 
						src='${data.image}' 
						data-src="${data.image}" 
						class="lazyload attachment-full size-full wp-post-image" alt="" 
						data-srcset="${data.image} 1200w, ${data.image} 300w, ${data.image} 1024w, ${data.image} 768w" data-sizes="(max-width: 1200px) 100vw, 1200px" data-id="6133" 
					/>
				
				`);
				return true;
			}
		}
		
	}
	else{
		window.location.href = DNWEB;
	}
	// alert("HEEEL");
	window.location.href = DNWEB;
	// window.location.replace("/abc");
}