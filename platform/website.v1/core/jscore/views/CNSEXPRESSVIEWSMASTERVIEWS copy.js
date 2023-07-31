import * as Init from '../init.js';
import { WSCNSWEBEXPRESS } from '../classes/WSCNSWEBEXPRESS.js';
import { WSCNSCART } from '../classes/WSCNSCART.js';
import * as CloudPDFInit from '../classes/CloudPDF.js';
import { Hash } from '../classes/Hash.js';

export class CNSEXPRESSVIEWSMASTERVIEWS {
	constructor(name) {
		this.HASH = new Hash();
		this.WSCNSWEB = new WSCNSWEBEXPRESS("123445", "00000000");
		this.WSCNSWEB_HEADERS = this.WSCNSWEB.headers;
		this.WSCNSWEB_BODY = this.WSCNSWEB.body;
		this.WSCNSRESDATA = this.WSCNSWEB.enginedata();

		// this.CNS_RESDATA_CLASSIFICATION = this.WSCNSWEB.get(this.WSCNSRESDATA.data.classification.class);
		// this.CNS_RESDATA_SUBCLASSIFICATION = this.WSCNSWEB.get(this.WSCNSRESDATA.data.classification.subclass);
		this.CNS_RESDATA_CURRENCY = this.WSCNSWEB.get(this.WSCNSRESDATA.data.currency);
		this.CNS_RESDATA_LANGUAGE = this.WSCNSWEB.get(this.WSCNSRESDATA.data.language);

		// this.CNS_RESDATA_PRODUCT = this.WSCNSWEB.get(this.WSCNSRESDATA.data.product);
		// this.CNS_RESDATA_PRODUCTS = this.WSCNSWEB.get(this.WSCNSRESDATA.data.products);


		// this.CNS_RESDATA_ACCOUNT = this.WSCNSWEB.get(this.WSCNSRESDATA.data.account);

		// this.CNS_RESDATA_CARTS = this.WSCNSWEB.get(this.WSCNSRESDATA.data.cart);
		// this.CNS_RESDATA_CHECKOUT = this.WSCNSWEB.get(this.WSCNSRESDATA.data.checkout);
		// this.CNS_RESDATA_INFO = this.WSCNSWEB.get(this.WSCNSRESDATA.data.info);

		this.DNWEB = this.WSCNSWEB.dnweb();
		// $('.cnstoptotalcountcart').html(this.CNS_RESDATA_CARTS.count.cart);
		// $('.cnstoptotalcountwishlist').html(this.CNS_RESDATA_CARTS.count.wishlist);
	}

	cns_view_section_subclassification(el_key) {
		let output = ``;
		if (this.CNS_RESDATA_SUBCLASSIFICATION) {
			for (const index in this.CNS_RESDATA_SUBCLASSIFICATION) {
				let data = this.CNS_RESDATA_SUBCLASSIFICATION[index];
				let image = Init.DNCLOUDIMAGE + data.sub_class_image;
				let link = this.DNWEB + '/shop/scl/' + data.ctisubclass + '/' + this.WSCNSWEB.urlname(data.sub_class_name);

				output = output + `
				<div class="category-grid col-xs-12 col-sm-2 columns-6 text-color-dark valign-center style-classic content-under product-category product" data-hover="zoom-in">
                    <a href="${link}"><img class="lazyload lazyload-lqip" src="${image}" data-src="${image}" 
						alt="Business" width="600" height="600" srcset="${image}"
                        sizes="(max-width: 248px) 100vw, 248px" /></a>
                    <div class="categories-mask text-center text-uppercase">
                        <a href="${Init.DN}/shop/scl/${data.cticlass}">
                            <h4>${data.sub_class_name}</h4>
                        </a>
                        <a href="${Init.DN}/shop/scl/${data.cticlass}">
                            <mark class="count">${data.total_product}
                                products</mark></a>
                    </div>
                </div>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_home_section_popular_products(el_key) {
		let output = ``;
		if (this.CNS_RESDATA_PRODUCTS) {
			for (const index in this.CNS_RESDATA_PRODUCTS) {
				let data = this.CNS_RESDATA_PRODUCTS[index];
				let image = Init.DNCLOUDIMAGE + data.product_image;
				let link = this.DNWEB + '/book/' + data.ctiproduct + '/' + this.WSCNSWEB.urlname(data.product_name);;

				output = output + `
					<div class="swiper-slide slide-item product-slide -slide" style="width:16.666666666667%">
						<div class="et_cart-off hide-hover-on-mobile product-hover-swap product-view-default view-color-white product type-product post-389 status-publish instock product_cat-business product_cat-childrens-book product_cat-comics product_cat-cookbook product_cat-health product_cat-history product_tag-collections product_tag-men product_tag-week has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
							<div class="content-product ">
								<div class="sale-wrapper ">
									<span class="onsale type-square left">Sale</span>
								</div>
								<div class="product-image-wrapper hover-effect-swap">
									<div class="et-wishlist-holder type-icon-text position-under ">
										<div class="yith-wcwl-add-to-wishlist add-to-wishlist-389  wishlist-fragment on-first-load"
											data-fragment-ref="389" data-fragment-options="{&quot;base_url&quot;:&quot;&quot;,&quot;in_default_wishlist&quot;:false,&quot;is_single&quot;:false,&quot;show_exists&quot;:false,&quot;product_id&quot;:389,&quot;parent_product_id&quot;:389,&quot;product_type&quot;:&quot;simple&quot;,&quot;show_view&quot;:false,&quot;browse_wishlist_text&quot;:&quot;Browse wishlist&quot;,&quot;already_in_wishslist_text&quot;:&quot;The product is already in your wishlist!&quot;,&quot;product_added_text&quot;:&quot;Product added!&quot;,&quot;heading_icon&quot;:&quot;fa-heart-o&quot;,&quot;available_multi_wishlist&quot;:false,&quot;disable_wishlist&quot;:false,&quot;show_count&quot;:false,&quot;ajax_loading&quot;:false,&quot;loop_position&quot;:&quot;after_add_to_cart&quot;,&quot;item&quot;:&quot;add_to_wishlist&quot;}">

											<div class="yith-wcwl-add-button">
												<a href="#?add_to_wishlist=389&amp;_wpnonce=fb75cc7681"
													class="add_to_wishlist single_add_to_wishlist"
													data-product-id="389" data-product-type="simple"
													data-original-product-id="389"
													data-title="Add to wishlist" rel="nofollow">
													<i class="yith-wcwl-icon fa fa-heart-o"></i>
													<span>Add to
														wishlist</span>
												</a>
											</div>

										</div>
									</div>
									<p class="stock in-stock step-1">89
										in stock</p>
									<a class="product-content-image" href="${link}"
										data-images="">
										<img width="263" height="354"
											src="${image}"
											class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail lazyload lazyload-lqip et-lazyload-fadeIn"
											alt="" sizes="(max-width: 263px) 100vw, 263px"
											data-src="${image}"
											data-srcset="${image}	" />
									</a>
									<footer class="footer-product hidden">
										<span class="show-quickly" data-prodid="389">Quick
											shop</span>
									</footer>
								</div>
								<div class="text-center product-details">
									<div class="products-page-cats">
										<a href="product-category/childrens-book/index.html">${data.sub_class_name}</a>
									</div>
									<h2 class="product-title">
										<a href="${link}">${data.product_name}</a>
									</h2>
									<div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
										<span style="width:100%">Rated
											<strong class="rating">5.00</strong>
											out of 5</span>
									</div>
									<span class="price"><del aria-hidden="true">
											<span class="woocommerce-Price-amount amount">
													<bdi>
														<span class="woocommerce-Price-currencySymbol sm-price-currency">${data.currency}</span> ${data.product_price_before}
													</bdi>
											</span>
										</del>
										<ins>
											<span class="woocommerce-Price-amount amount"><bdi>
											<span class="woocommerce-Price-currencySymbol sm-price-currency">${data.currency}</span> ${data.product_price}</bdi></span>
										</ins>
									</span>
								</div>
							</div>
						</div>
					</div>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_footer_section_social_media_company_name_address(el_key_company_logo, el_key_company_address, el_key_social_media) {
		let output_social_media = ``;
		let output_company_logo = ``;
		let output_company_address = ``;
		if (this.CNS_RESDATA_INFO) {
			let data = this.CNS_RESDATA_INFO;
			let image = Init.DNCLOUDIMAGE + data.company_logo;

			output_company_address = output_company_address + `${data.address}`;
			output_company_logo = output_company_logo + `
			<img width="202" height="44" src="${image}" class="attachment-full size-full lazyload lazyload-lqip et-lazyload-fadeIn" alt="" sizes="(max-width: 202px) 100vw, 202px"
			data-src="${image}"
		/>`;

			output_social_media = output_social_media + `
													<ul>
                                                        <li class="menu-item  menu-item-2663">
                                                            <div class="subitem-title-holder    elementor-repeater-item-75e4c2c">
                                                                <a class="menu-title et-column-title  " href="${data.facebook}" target="_self" title="Facebook">
                                                                    <p>Facebook
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="menu-item  menu-item-8620">
                                                            <div class="subitem-title-holder    elementor-repeater-item-4ea1c9d">
                                                                <a class="menu-title et-column-title  " href="${data.instagram}" target="_self" title="Instagram">
                                                                    <p>Instagram
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="menu-item  menu-item-4773">
                                                            <div class="subitem-title-holder    elementor-repeater-item-469040d">
                                                                <a class="menu-title et-column-title  " href="${data.whatsapp}" target="_self" title="WhatsApp">
                                                                    <p>WhatsApp
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="menu-item  menu-item-9617">
                                                            <div class="subitem-title-holder    elementor-repeater-item-0bab317">
                                                                <a class="menu-title et-column-title  " href="${data.twitter}" target="_self" title="Twitter">
                                                                    <p>Twitter
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="menu-item  menu-item-6861">
                                                            <div class="subitem-title-holder    elementor-repeater-item-58ecf9e">
                                                                <a class="menu-title et-column-title  " href="${data.youtube}" target="_self" title="Youtube ">
                                                                    <p>Youtube
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li class="menu-item  menu-item-1741">
                                                            <div class="subitem-title-holder    elementor-repeater-item-6fdd9fa">
                                                                <a class="menu-title et-column-title  " href="${image}" target="_self" title="Tiktok">
                                                                    <p>Tiktok
                                                                    </p>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    </ul>
		`;
		}
		else {
		}
		$(el_key_company_logo).html(output_company_logo);
		$(el_key_company_address).html(output_company_address);
		$(el_key_social_media).html(output_social_media);
		return false;
	}

	cns_view_section_shop_featured_this_week(el_key) {
		let output = `
		<div class="swiper-wrapper ">`;
		if (this.CNS_RESDATA_PRODUCTS) {
			for (const index in this.CNS_RESDATA_PRODUCTS) {
				let data = this.CNS_RESDATA_PRODUCTS[index];

				output = output + `
															<div class="swiper-slide">
                                                                <div  class="etheme-product-grid-item type-list etheme-product-hover- etheme-product-hover-mode- etheme-product-image-hover- product type-product post-389 status-publish first instock product_cat-business product_cat-childrens-book product_cat-comics product_cat-cookbook product_cat-health product_cat-history product_tag-collections product_tag-men product_tag-week has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
                                                                    <div class="etheme-product-grid-image"><a
                                                                            href="https://xstore.8theme.com/elementor/demos/book-store/product/the-quiver-of-love/"><img
                                                                                width="263" height="354"
                                                                                src="https://v9m6d2m2.rocketcdn.me/elementor/demos/book-store/wp-content/uploads/sites/78/2022/05/Image_1-min-1x1.jpg"
                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail lazyload lazyload-lqip et-lazyload-fadeIn"
                                                                                alt=""
                                                                                sizes="(max-width: 263px) 100vw, 263px"
                                                                                data-src="https://v9m6d2m2.rocketcdn.me/elementor/demos/book-store/wp-content/uploads/sites/78/2022/05/Image_1-min-600x808.jpg"
                                                                                data-srcset="https://v9m6d2m2.rocketcdn.me/elementor/demos/book-store/wp-content/uploads/sites/78/2022/05/Image_1-min-600x808.jpg 600w, https://v9m6d2m2.rocketcdn.me/elementor/demos/book-store/wp-content/uploads/sites/78/2022/05/Image_1-min-223x300.jpg 223w, https://v9m6d2m2.rocketcdn.me/elementor/demos/book-store/wp-content/uploads/sites/78/2022/05/Image_1-min-761x1024.jpg 761w, https://v9m6d2m2.rocketcdn.me/elementor/demos/book-store/wp-content/uploads/sites/78/2022/05/Image_1-min-768x1034.jpg 768w, https://v9m6d2m2.rocketcdn.me/elementor/demos/book-store/wp-content/uploads/sites/78/2022/05/Image_1-min-1x1.jpg 1w, https://v9m6d2m2.rocketcdn.me/elementor/demos/book-store/wp-content/uploads/sites/78/2022/05/Image_1-min-7x10.jpg 7w, https://v9m6d2m2.rocketcdn.me/elementor/demos/book-store/wp-content/uploads/sites/78/2022/05/Image_1-min.jpg 780w" /></a>
                                                                    </div>
                                                                    <div class="etheme-product-grid-content">
                                                                        <div class="etheme-product-grid-categories"><a
                                                                                href="https://xstore.8theme.com/elementor/demos/book-store/product-category/business/"
                                                                                rel="tag">Business</a></div>
                                                                        <h2
                                                                            class="woocommerce-loop-product__title etheme-product-grid-title">
                                                                            <a
                                                                                href="https://xstore.8theme.com/elementor/demos/book-store/product/the-quiver-of-love/">The
                                                                                Quiver of Love</a></h2>
                                                                        <div class="star-rating-wrapper">
                                                                            <div class="star-rating" role="img"
                                                                                aria-label="Rated 5.00 out of 5"><span
                                                                                    style="width:100%">Rated <strong
                                                                                        class="rating">5.00</strong> out
                                                                                    of 5</span></div>
                                                                        </div>
                                                                        <span class="price"><del
                                                                                aria-hidden="true"><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>19.99</bdi></span></del>
                                                                            <ins><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>18.25</bdi></span></ins></span>
                                                                        <div class="product-stock step-1">
                                                                            <span class="stock-in">Available: <span
                                                                                    class="stock-count">89</span></span>
                                                                            <span class="stock-out">Sold: <span
                                                                                    class="stock-count">1</span></span>
                                                                            <span class="stock-line"><span
                                                                                    class="stock-line-inner"
                                                                                    style="width: 1.1111111111111%"></span></span>
                                                                        </div>
                                                                        <div
                                                                            class="woocommerce-product-details__short-description">
                                                                            <p>Dictum non in eu massa urna mattis.
                                                                                Venenatis tristique tristique quam ipsum
                                                                                quis iaculis sed pellentesque varius.
                                                                                Dictum faucibus libero.</p> 
                                                                        </div>
                                                                        <a href="?add-to-cart=389" data-quantity="1"
                                                                            class="button product_type_simple add_to_cart_button ajax_add_to_cart etheme-product-grid-button"
                                                                            data-product_id="389"
                                                                            data-product_sku="12345"
                                                                            aria-label="Add &ldquo;The Quiver of Love&rdquo; to your cart"
                                                                            rel="nofollow"
                                                                            data-product_name="The Quiver of Love"><span
                                                                                class="button-text">Add to
                                                                                cart</span></a>
                                                                    </div>
                                                                </div>
                                                            </div>
				`;
			}
		}
		else {
		}

		output = output + `
		</div>`;
		$(el_key).html(output);
		return false;
	}

	cns_view_section_shop_products(el_key) {
		let output = `
		<div class="swiper-wrapper--  ">`;
		if (this.CNS_RESDATA_PRODUCTS) {
			for (const index in this.CNS_RESDATA_PRODUCTS) {
				let data = this.CNS_RESDATA_PRODUCTS[index];
				let image = Init.DNCLOUDIMAGE + data.product_image;
				let link = this.DNWEB + '/product/' + data.ctiproduct + '/' + this.WSCNSWEB.urlname(data.product_name);

				output = output + `
				<div class="first grid-sizer col-md-3 col-sm-6 col-xs-6 product-hover-swap product-view-default view-color-white et_cart-off hide-hover-on-mobile product type-product status-publish instock product_cat-business product_cat-childrens-book product_cat-comics product_cat-cookbook product_cat-health product_cat-history product_tag-men product_tag-week has-post-thumbnail shipping-taxable purchasable product-type-simple">
				<div class="content-product ">
					<div class="product-image-wrapper hover-effect-swap">
						<div class="et-wishlist-holder type-icon-text position-under ">
							<div class="yith-wcwl-add-to-wishlist add-to-wishlist-494  wishlist-fragment on-first-load"
								data-fragment-ref="494"
								data-fragment-options="{&quot;base_url&quot;:&quot;&quot;,&quot;in_default_wishlist&quot;:false,&quot;is_single&quot;:false,&quot;show_exists&quot;:false,&quot;product_id&quot;:494,&quot;parent_product_id&quot;:494,&quot;product_type&quot;:&quot;simple&quot;,&quot;show_view&quot;:false,&quot;browse_wishlist_text&quot;:&quot;Browse wishlist&quot;,&quot;already_in_wishslist_text&quot;:&quot;The product is already in your wishlist!&quot;,&quot;product_added_text&quot;:&quot;Product added!&quot;,&quot;heading_icon&quot;:&quot;fa-heart-o&quot;,&quot;available_multi_wishlist&quot;:false,&quot;disable_wishlist&quot;:false,&quot;show_count&quot;:false,&quot;ajax_loading&quot;:false,&quot;loop_position&quot;:&quot;after_add_to_cart&quot;,&quot;item&quot;:&quot;add_to_wishlist&quot;}">

								<div class="yith-wcwl-add-button">
									<a href="?add_to_wishlist=494&#038;_wpnonce=67a434b652"
										class="add_to_wishlist single_add_to_wishlist"
										data-product-id="494" data-product-type="simple"
										data-original-product-id="494"
										data-title="Add to wishlist" rel="nofollow">
										<i class="yith-wcwl-icon fa fa-heart-o"></i>
										<span>Add to wishlist</span>
									</a>
								</div>

							</div>
						</div>
						<p class="stock in-stock step-1">230 in stock</p> <a
							class="product-content-image"
							href="${link}"
							data-images="">
							<img width="263" height="354"
								src="${image}"
								class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail lazyload lazyload-lqip et-lazyload-fadeIn"
								alt="" sizes="(max-width: 263px) 100vw, 263px"
								data-src="${image}"
								data-srcset="${image}" />
						</a>
						<footer class="footer-product hidden">
							<span class="show-quickly" data-prodid="494">Quick shop 000000</span>
						</footer>
					</div>
					<div class="text-center product-details">
						<div class="products-page-cats"><a
								href="https://xstore.8theme.com/elementor/demos/book-store/product-category/childrens-book/">${data.sub_class_name}</a></div>
						<h2 class="product-title">
							<a href="${link}">${data.product_name}</a>
						</h2>
						<div class="star-rating" role="img"
							aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated
								<strong class="rating">5.00</strong> out of 5</span></div>
						<span class="price"><span
								class="woocommerce-Price-amount amount"><bdi><span
										class="woocommerce-Price-currencySymbol"><span class="woocommerce-Price-currencySymbol sm-price-currency">${data.currency}</span> </span>${data.product_price}</bdi></span></span>
					</div>
				</div>
			</div>
				`;
			}
		}
		else {
		}

		output = output + `
		</div>`;
		$(el_key).html(output);
		return false;
	}

	cns_view_section_shop_list_subcategory(el_key) {
		let output = ``;
		if (this.CNS_RESDATA_SUBCLASSIFICATION) {
			for (const index in this.CNS_RESDATA_SUBCLASSIFICATION) {
				let data = this.CNS_RESDATA_SUBCLASSIFICATION[index];
				let link = this.DNWEB + '/shop/scl/' + data.ctisubclass + '/' + this.WSCNSWEB.urlname(data.sub_class_name);

				output = output + `
				<li class="cat-item cat-item-20">
					<a  href="${link}">${data.sub_class_name} (${data.total_product})</a>
                </li>
				`;
			}
		}
		else {
		}
		$(el_key).html(output);
		return false;
	}

	cns_view_section_shop_product_info(el_key_array) {
		let output = ``;
		if (this.CNS_RESDATA_PRODUCT) {
			let data = this.CNS_RESDATA_PRODUCT;
			let image = Init.DNCLOUDIMAGE + data.product_image;
			let link = this.DNWEB + '/shop/scl/' + data.ctisubclass + '/' + this.WSCNSWEB.urlname(data.sub_class_name);
			let linktocategory = this.DNWEB + '/shop/scl/' + data.ctisubclass + '/' + this.WSCNSWEB.urlname(data.sub_class_name);
			let linktotag = this.DNWEB + '/shop/';

			output = output + `
											<a
                                                class="woocommerce-main-image pswp-main-image zoom"
                                                href="${image}"
                                                data-index="0">
                                                <img width="368" height="495"
                                                    src="${image}"
                                                    class="attachment-woocommerce_single size-woocommerce_single lazyload lazyload-lqip et-lazyload-fadeIn wp-post-image"
                                                    alt="" title="Image_#2-min" data-caption=""
                                                    data-src="${image}"
                                                    data-large_image="${image}"
                                                    data-large_image_width="780" data-large_image_height="1050"
                                                    sizes="(max-width: 368px) 100vw, 368px"
                                                    data-srcset="${image}" />
                                            </a>
				`;

			$(el_key_array.product_image).html(output);
			$(el_key_array.product_name).html(data.product_name);

			$(el_key_array.product_shortdesc).html(data.shortdescription);
			$(el_key_array.product_desc).html(data.description);

			$(el_key_array.product_number_customer_review).html(0);
			$(el_key_array.product_number_views).html(0);
			$(el_key_array.product_quantity_available).html(`${data.quantity} in stock`);

			$("#CNSAddToCartForm").attr("cta", data.ctaproduct);

			$(el_key_array.product_meta_category).html(`
			Category: 
			<a href="${linktocategory}">${data.sub_class_name}</a>
		`);
			$(el_key_array.product_meta_tags).html(`
			Tags: 
			<a  href="${linktotag}"  rel="tag">Book</a>
		`);

			$(el_key_array.product_price).html(`
		<bdi>
			<span class="woocommerce-Price-currencySymbol sm-price-currency">${data.currency}</span> ${data.product_price}
		</bdi>`);
		}
		else {
		}
		return false;
	}

	cns_view_section_shop_list_product_may_also_like(el_key) {
		let output = `<ul class="product_list_widget">`;
		if (this.CNS_RESDATA_PRODUCTS) {
			for (const index in this.CNS_RESDATA_PRODUCTS) {
				let data = this.CNS_RESDATA_PRODUCTS[index];
				let image = Init.DNCLOUDIMAGE + data.product_image;
				let link = this.DNWEB + '/book/' + data.ctiproduct + '/' + this.WSCNSWEB.urlname(data.product_name);

				output = output + `
								
                                    <li>
                                        <a href="${link}"
                                            title="Ukrainian" class="product-list-image">
                                            <img width="263" height="354"
                                                src="${image}"
                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail lazyload lazyload-lqip et-lazyload-fadeIn"
                                                alt="" sizes="(max-width: 263px) 100vw, 263px"
                                                data-src="${image}"
                                                data-srcset="${image}" />
                                        </a>
                                        <div class="product-item-right">
                                            <p class="product-title"><a
                                                    href="${link}"
                                                    title="${data.product_name}">${data.product_name}</a></p>
                                            <div class="price">
                                                <span class="woocommerce-Price-amount amount">
													<bdi>
														<span class="woocommerce-Price-currencySymbol sm-price-currency">${data.currency}</span> ${data.product_price}
													</bdi>
												</span>
                                            </div>
                                            <div class="price">
                                                <span class="woocommerce-Price-amount amount">
													<bdi>
														 ${data.sub_class_name}
													</bdi>
												</span>
                                            </div>
                                        </div>
                                    </li>
				`;
			}
		}
		else {
		}
		output = output + `</ul>`;
		$(el_key).html(output);
		return false;
	}
























	cns_view_section_shop_checkout_cart_order(el_key) {
		let subtotal = "";
		let total = "";
		let output = `
		<table class="shop_table woocommerce-checkout-review-order-table">
			<thead>
				<tr>
					<th class="product-name">Product</th>
					<th class="product-total">Subtotal</th>
				</tr>
			</thead>
			<tbody>`;
		if (this.CNS_RESDATA_CHECKOUT) {
			if (this.CNS_RESDATA_CHECKOUT.cart) {
				for (const index in this.CNS_RESDATA_CHECKOUT.cart) {
					let data = this.CNS_RESDATA_CHECKOUT.cart[index];

					output = output + `
								
						<tr class="cart_item">
							<td class="product-name">
								${data.product_name} 
								<strong class="product-quantity">&times;&nbsp;${data.quantity}</strong> 
							</td>
							<td class="product-total">
								<span class="woocommerce-Price-amount amount"><bdi>${data.currency_name} ${data.total_price}</bdi></span>
							</td>
						</tr>
					
				`;
				}
			}
			if (this.CNS_RESDATA_CHECKOUT.order) {
				let order = this.CNS_RESDATA_CHECKOUT.order;
				subtotal = order.currency_name + " " + order.total_price;
				total = order.currency_name + " " + order.total_price;
			}

		}
		else {
		}

		output = output + `
		</tbody>
					<tfoot>

						<tr class="cart-subtotal">
							<th>Subtotal</th>
							<td><span class="woocommerce-Price-amount amount"><bdi>${subtotal}</bdi></span>
							</td>
						</tr>


						<tr class="order-total">
							<th>Total</th>
							<td><strong><span class="woocommerce-Price-amount amount"><bdi>${total}</bdi></span></strong>
							</td>
						</tr>


					</tfoot>
				</table>`;


		$(el_key).html(output);
		return false;
	}














	cns_view_section_shop_cart_data(el_key_array) {
		let WSCNSCARTMS = new WSCNSCART("CNS");
		let output = `
		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
			<thead>
				<tr>
					<th class="product-details" colspan="2">Product</th>
					<th class="product-price">Price</th>
					<th class="product-sku">SKU</th>
					<th class="product-quantity">Quantity</th>
					<th class="product-subtotal" colspan="2">Subtotal</th>
				</tr>
			</thead>
			<tbody>`;
		if (this.CNS_RESDATA_CARTS) {
			if (this.CNS_RESDATA_CARTS.list) {
				for (const index in this.CNS_RESDATA_CARTS.list) {
					let data = this.CNS_RESDATA_CARTS.list[index];
					let link = this.DNWEB + '/product/' + data.ctiproduct + '/' + data.product_name;

					output = output + `
				<tr class="woocommerce-cart-form__cart-item cart_item st-item-meta">
					<td class="product-name" data-title="Product">
						<div class="product-thumbnail">
							<a href="#">
								<img width="270" height="270" 
									src="http://cloud.cnsplateforme.com/bccclass03.png" 
									class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail lazyload lazyload-simple et-lazyload-fadeIn" alt="" decoding="async" 
									data-src="http://cloud.cnsplateforme.com/bccclass03.png" 
									/>
							</a> 
						</div>
					</td>
					<td class="product-details">
						<div class="cart-item-details">
							<a href="${link}" class="product-title">${data.product_name}</a> 
							<a href="#" type="button" class="remove-item text-underline cns_remove_cart"  cta="${data.ctacart}" title="Remove this item">Remove</a> 
							<span class="mobile-price">
								${data.quantity} x <span class="woocommerce-Price-amount amount">
								<bdi>
									<span class="woocommerce-Price-currencySymbol sm-price-currency">${data.currency_name}</span> ${data.unit_price}
								</bdi>
							</span> 
							</span>
						</div>
					</td>
					<td class="product-price" data-title="Price">
						<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol sm-price-currency">${data.currency_name}</span> ${data.unit_price}</bdi></span> 
					</td>
					<td class="product-sku" data-title="SKU">
						C0-${data.cticart} 
					</td>
					<td class="product-quantity" data-title="Quantity">
						<div class="quantity">
						<span class="minus cns_cart_quantity_minus" cti="${data.cticart}"><i class="et-icon et-minus"></i></span> <label class="screen-reader-text" for="quantity_63b1325dc40c9">Air Fryer with DualZone quantity</label>
						<input type="number" id="quantity_63b1325dc40c9" class="input-text qty text cns_cart_quantity cns_cart_quantity_${data.cticart}" cti="${data.cticart}" cta="${data.ctacart}" name="cart[1579779b98ce9edb98dd85606f2c119d][qty]" value="${data.quantity}" title="Qty" size="4" min="0" max="50" step="1" placeholder="" inputmode="numeric" autocomplete="off" />
						<span class="plus cns_cart_quantity_plus" cti="${data.cticart}"><i class="et-icon et-plus" ></i></span></div>
					</td>
					<td class="product-subtotal" data-title="Subtotal">
						<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol sm-price-currency">${data.currency_name}</span> ${data.total_price}</bdi></span> 
					</td>
				</tr>
				
				`;
				}
			}
			if (this.CNS_RESDATA_CARTS.total) {
				let totalcart = this.CNS_RESDATA_CARTS.total;
				$(el_key_array.cart_subtotal).html(`${totalcart.currency_name} ${totalcart.subtotal_amount}`);
				$(el_key_array.cart_total).html(`${totalcart.currency_name} ${totalcart.total_amount}`);
			}

		}
		else {
		}

		output = output + `
			</tbody>
		</table>`;
		$(el_key_array.cart_list).html(output);

		$('.cns_cart_quantity').on('change', function () {
			let cta = $(this).attr('cta');
			let quantity = $(this).val();

			if (quantity < 1) {

			}

			WSCNSCARTMS.cnsUpdateCart(cta, quantity);
		});

		$('.cns_cart_quantity_minus').on('click', function (e) {
			let cti = $(this).attr('cti');
			let cta = $('.cns_cart_quantity_' + cti).attr('cta');
			let quantity = $('.cns_cart_quantity_' + cti).val();
			quantity--;

			WSCNSCARTMS.cnsUpdateCart(cta, quantity);
		});

		$('.cns_cart_quantity_plus').on('click', function (e) {
			let cti = $(this).attr('cti');
			let cta = $('.cns_cart_quantity_' + cti).attr('cta');
			let quantity = $('.cns_cart_quantity_' + cti).val();
			quantity++;

			WSCNSCARTMS.cnsUpdateCart(cta, quantity);
		});

		$('.cns_remove_cart').on('click', function (e) {
			let cta = $(this).attr('cta');
			WSCNSCARTMS.cnsRemoveCart(cta);
		});


		return false;
	}






	cns_view_section_shop_list_bought_products(el_key) {
		let output = `<div class="row col-lg-12">`;
		if (this.CNS_RESDATA_ACCOUNT) {
			if (this.CNS_RESDATA_ACCOUNT.products) {
				for (const index in this.CNS_RESDATA_ACCOUNT.products) {
					let data = this.CNS_RESDATA_ACCOUNT.products[index];
					let image = Init.DNCLOUDIMAGE + data.product_image;
					let link = this.DNWEB + '/account/book/read/' + data.cti + '/' + this.WSCNSWEB.urlname(data.product_name);

					output = output + `
								
					<div  class="col-lg-3 col-md-3 col-sm-4 col-xs-6 product-hover-swap product-view-default view-color-white et_cart-off hide-hover-on-mobile product type-product post-569 status-publish last instock product_cat-business product_cat-childrens-book product_cat-comics product_cat-cookbook product_cat-health product_cat-history product_tag-collections product_tag-men product_tag-week has-post-thumbnail sale shipping-taxable purchasable product-type-simple">
						<div class="content-product">
							<div class="product-image-wrapper hover-effect-swap">
								<a class="product-content-image"
									href="${link}" data-images="">
									<img width="263" height="354"
										src="${image}"
										class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail lazyload lazyload-lqip et-lazyload-fadeIn"
										alt="" sizes="(max-width: 263px) 100vw, 263px"
										data-src="${image}"
										data-srcset="${image}" />
								</a>
							</div>
							<div class="text-center product-details">
								<div class="products-page-cats"><a
										href="${link}">${data.sub_class_name}</a></div>
								<h2 class="product-title">
									<a href="${link}"> ${data.product_name} </a>
								</h2>
								<div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
									<span style="width: 100%;">Rated <strong class="rating">5.00</strong> out of 5</span>
								</div>
								<span class="price">
									<span class="woocommerce-Price-amount amount">
										<bdi><span class="woocommerce-Price-currencySymbol">&#36;</span>17.60</bdi>
									</span>
								</span>
							</div>
						</div>
					</div>
				`;
				}
			}
		}
		else {
		}
		output = output + `</div>`;
		$(el_key).html(output);
		return false;
	}





}