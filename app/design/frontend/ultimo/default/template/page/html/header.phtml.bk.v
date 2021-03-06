<?php
/**
 * @var Mage_Page_Block_Html_Header $this
 */
?>
<?php
	$theme = $this->helper('ultimo');
	$helperThis = $this->helper('ultimo/template_page_html_header');

	//Get HTML of header blocks
	//**************************************************************

	//User menu
	//Important: this block has to be rendered at the very beginning of this file
	$userMenuHtml = $this->getChildHtml('user_menu');

	//Main menu
	//Important: this block has to be rendered at the very beginning of this file
	$menuHtml = $this->getChildHtml('topMenu');

	//Switchers
	$currencySwitcher = $this->getChildHtml('currency');
	$languageSwitcher = $this->getChildHtml('store_language');
	$hasHeaderCollateral = ($currencySwitcher || $languageSwitcher) ? TRUE : FALSE;

	//Logo
	$logoHtml = $this->getChildHtml('logo');

	//Layout settings and basic flags
	//**************************************************************

	//Sticky header
	$sticky = $theme->getCfg('header/sticky');

	//Mobile header
	if ($sticky)
	{
		if (($mobileMenuThreshold = $helperThis->getMobileMenuThreshold()) === NULL)
		{
			$mobileMenuThreshold = 770; //Set default value, if threshold doesn't exist
		}
	}
	$mobileHeaderMode = $theme->getCfg('header/mode');

	//This flag indicates that in mobile header language/currency switchers should be hidden
	//and replaced with mobile versions of those switchers
	$moveSwitchers = FALSE;
	if ($mobileHeaderMode)
	{
		//Get only if mobile header enabled
		$moveSwitchers = $theme->getCfg('header/mobile_move_switchers');
	}

	//Get grid classes for header sections
	$grid = $helperThis->getGridClasses();

	//Get positions of header blocks
	$position = $helperThis->getPositions();

	//Get flags indicating if blocks need to be moved below the skip links on mobile view
	$move = $helperThis->getMoveBelowSkipLinks();

	//Get flags indicating if blocks are displayed directly inside the header block template or inside one of the child blocks
	$display = $helperThis->getDisplayedInHeaderBlock();

	//Check if main menu is displayed inisde a section (full-width section) at the bottom of the header
	$menuDisplayedInFullWidthContainer = $helperThis->isMenuDisplayedInFullWidthContainer();

	//Additional classes for primary header blocks holder
	$hpClasses = '';
	if ($menuDisplayedInFullWidthContainer === FALSE)
	{
		$hpClasses = ' hp-blocks-holder--stacked'; //Important: keep hte space at the beginning
	}

	//Additional classes
	//**************************************************************
	//Header
	$classes['root'] = '';
	if ($moveSwitchers)
		$classes['root'] .= ' move-switchers';
	
	//Menu
	$classes['nav-container'] = '';
	if ($sticky && $theme->getCfg('header/sticky_full_width'))
		$classes['nav-container'] .= ' sticky-container--full-width';

	$classes['nav'] = '';
	if ($menuDisplayedInFullWidthContainer === FALSE)
		$classes['nav'] .= ' simple';

	//Assign blocks to selected positions
	//**************************************************************
	$html = array();

	//Mini cart
	//--------------------------------------------------------------
	//Get flag which indicates that mini cart block exists and is displayed
	$existsInChildBlock['cart'] = Mage::registry('headerDisplayMiniCart');
	if ($position['cart'] === 'mainMenu')
	{
		$existsInChildBlock['cart'] = TRUE;
	}
	if ($display['cart'])
	{
		$cartHtml = $this->getChildHtml('cart_sidebar');
		if ($cartHtml)
		{
			$html[$position['cart']][] = $cartHtml;
		}
	}

	//Mini compare
	//--------------------------------------------------------------
	//Get flag which indicates that mini compare block exists and is displayed
	$existsInChildBlock['compare'] = Mage::registry('headerDisplayMiniCompare');
	if ($position['compare'] === 'mainMenu')
	{
		$existsInChildBlock['compare'] = TRUE;
	}
	if ($display['compare'])
	{
		$compareHtml = $this->getChildHtml('compareMini');
		if ($compareHtml)
		{
			$html[$position['compare']][] = $compareHtml;
		}
	}

	//Logo
	//--------------------------------------------------------------
	$html[$position['logo']][] = $logoHtml;

	//Search
	//--------------------------------------------------------------
	//Get flag which indicates that search box exists and is displayed
	$existsInChildBlock['search'] = Mage::registry('headerDisplaySearch');
	if ($position['search'] === 'mainMenu')
	{
		$existsInChildBlock['search'] = TRUE;
	}
	if ($display['search'])
	{
		$searchHtml = $this->getChildHtml('search_wrapper');
		if ($searchHtml)
		{
			$html[$position['search']][] = $searchHtml;
		}
	}

	//User menu
	//--------------------------------------------------------------
	$html[$position['user-menu']][] = $userMenuHtml;

	//User menu can contain account links (including Top Links).
	//Get flag which indicates that block with account links exists and is displayed.
	$existsInChildBlock['account-links'] = Mage::registry('headerDisplayAccountLinks');

	//Main menu
	//--------------------------------------------------------------
	$menuContainerHtml = '
	<div id="header-nav" class="nav-container skip-content sticky-container' . ($classes['nav-container'] ? $classes['nav-container'] : '') . '">
		<div class="nav container clearer' . ($classes['nav'] ? $classes['nav'] : '') . '">
			<div class="inner-container">' . $menuHtml . '</div> <!-- end: inner-container -->
		</div> <!-- end: nav -->
	</div> <!-- end: nav-container -->';

	if ($menuDisplayedInFullWidthContainer === FALSE)
	{
		$html[$position['main-menu']][] = $menuContainerHtml;
	}

	//Skip links and blocks displayed via skip links
	//**************************************************************
	//Skip links count
	$skipLinksCount = 0;

	//Search
	if (!empty($searchHtml) || $existsInChildBlock['search'])
	{
		$skipLinksCount++;
	}

	//Account links
	if ($existsInChildBlock['account-links'])
	{
		$skipLinksCount++;
	}

	//Mini cart
	if (!empty($cartHtml) || $existsInChildBlock['cart'])
	{
		$skipLinksCount++;
	}

	//Mini compare
	if (!empty($compareHtml) || $existsInChildBlock['compare'])
	{
		$skipLinksCount++;
	}

	//Main menu
	if (!empty($menuContainerHtml)) 
	{
		$skipLinksCount++;
	}
?>
<div id="top" class="header-container header-regular<?php if ($classes['root']) echo $classes['root']; ?>">
<div class="header-container2">
<div class="header-container3">

	<div class="header-top-container">
		<div class="header-top header container clearer">
			<div class="inner-container">

				<div class="left-column">

					<?php if (isset($html['topLeft_1'])): ?>
						<?php foreach ($html['topLeft_1'] as $element): ?>
							<div class="item item-left"><?php echo $element; ?></div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php echo $this->getChildHtml('container_header_top_left_1'); ?>

					<?php if ($tmpHtml = $this->getChildHtml('block_header_top_left')): ?>
						<div class="item item-left block_header_top_left"><?php echo $tmpHtml; ?></div>
					<?php endif; ?>
					<?php if ($tmpHtml = $this->getChildHtml('block_header_top_left2')): ?>
						<div class="item item-left block_header_top_left2"><?php echo $tmpHtml; ?></div>
					<?php endif; ?>

				</div> <!-- end: left column -->

				<div class="right-column">

					<?php if (isset($html['topRight_1'])): ?>
						<?php foreach ($html['topRight_1'] as $element): ?>
							<div class="item item-right"><?php echo $element; ?></div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php echo $this->getChildHtml('container_header_top_right_1'); ?>
					
					<?php if ($tmpHtml = $this->getChildHtml('block_header_top_right')): ?>
						<div class="item item-right block_header_top_right"><?php echo $tmpHtml; ?></div>
					<?php endif; ?>
					<div id="currency-switcher-wrapper-regular" class="item item-right"><?php echo $currencySwitcher; ?></div>
					<div id="lang-switcher-wrapper-regular" class="item item-right"><?php echo $languageSwitcher; ?></div>
					<?php if ($tmpHtml = $this->getChildHtml('block_header_top_right2')): ?>
						<div class="item item-right block_header_top_right2"><?php echo $tmpHtml; ?></div>
					<?php endif; ?>

				</div> <!-- end: right column -->

			</div> <!-- end: inner-container -->
		</div> <!-- end: header-top -->
	</div> <!-- end: header-top-container -->

	<div class="header-primary-container">
		<div class="header-primary header container">
			<div class="inner-container">

				<?php echo $this->getChildHtml('topContainer'); ?>

				<?php
					//Important: do not add any additional blocks directly inside the "hp-blocks-holder" div.
					//Additional blocks, if needed, can be added inside columns (left, central, righ).
				?>
				<div class="hp-blocks-holder<?php if($hpClasses) echo $hpClasses; ?> skip-links--<?php echo $skipLinksCount; ?>">

					<?php if ($hasHeaderCollateral && $mobileHeaderMode && $moveSwitchers): ?>
						<!-- Mobile header collaterals -->
						<div id="header-collateral" class="header-collateral">
							<?php echo $languageSwitcher; ?>
							<?php echo $currencySwitcher; ?>
						</div>
					<?php endif; ?>

					<!-- Mobile logo -->
					<div class="logo-wrapper--mobile">
						<a class="logo logo--mobile" href="<?php echo $this->getUrl('') ?>" title="<?php echo $this->getLogoAlt() ?>">
							<img width="284" height="65" src="<?php echo (($small = $this->getLogoSrcSmall()) ? $small : $this->getLogoSrc()); ?>" alt="<?php echo $this->getLogoAlt() ?>" />
						</a>
					</div>
					<div class="clearer after-mobile-logo"></div>

					<!-- Skip links -->

					<?php if (!empty($menuContainerHtml)): ?>
						<a href="#header-nav" class="skip-link skip-nav">
							<span class="icon ic ic-menu"></span>
							<span class="label"><?php echo $this->__('Menu'); ?></span>
						</a>
					<?php endif; ?>

					<?php if (!empty($searchHtml) || $existsInChildBlock['search']): ?>
						<a href="#header-search" class="skip-link skip-search">
							<span class="icon ic ic-search"></span>
							<span class="label"><?php echo $this->__('Search'); ?></span>
						</a>
					<?php endif; ?>

					<?php if ($existsInChildBlock['account-links']): ?>
						<a href="#header-account" class="skip-link skip-account">
							<span class="icon ic ic-user"></span>
							<span class="label"><?php echo $this->__('My Account'); ?></span>
						</a>
					<?php endif; ?>

					<!-- <a id="header-compare" href="#header-compare" class="skip-link skip-info" onclick="showinfoblock();">
						<span class="icon ic ic-info"></span>
						<span class="label"><?php echo $this->__('Info.'); ?></span>
					</a>
 -->
					<a href="#header-compare" class="skip-link skip-compare">
						<span class="icon ic ic-info"></span>
						<span class="label"><?php echo $this->__('Info'); ?></span>
					</a>

					<?php if (!empty($compareHtml) || $existsInChildBlock['compare']): ?>
						<!-- <a href="#header-compare" class="skip-link skip-compare">
							<span class="icon ic ic-compare"></span>
							<?php if (($compareCount = Mage::registry('miniCompareProductCount')) > 0): ?>
								<span class="count"><?php echo $compareCount; ?></span>
							<?php endif; ?>
							<span class="label"><?php echo $this->__('Compare'); ?></span>
						</a> -->
					<?php endif; ?>

						<!-- Mini cart wrapper for cart and its skip link on mobile devices -->
						<div id="mini-cart-wrapper-mobile"></div>

						<div class="skip-links-clearer clearer"></div>

					<!-- end: Skip links -->

					<!-- Additional containers for elements displayed on mobile devices -->

					<?php if ($move['search']): //Search on mobile devices ?>
						<div id="search-wrapper-mobile"></div>
					<?php endif; ?>

					<?php if ($move['user-menu']): //User Menu on mobile devices ?>
						<div id="user-menu-wrapper-mobile"></div>
					<?php endif; ?>

					<?php if ($move['compare']): //Mini compare on mobile devices ?>
						<div id="mini-compare-wrapper-mobile"></div>
					<?php endif; ?>

					<!-- Primary columns -->

					<?php if (isset($grid['primLeftCol'])): ?>
						<!-- Left column -->
						<div class="hp-block left-column <?php echo $grid['primLeftCol']; ?>">
							<?php echo $this->getChildHtml('container_header_primary_left_1'); ?>
							<?php if (isset($html['primLeftCol'])): ?>
								<?php foreach ($html['primLeftCol'] as $element): ?>
									<div class="item"><?php echo $element; ?></div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div> <!-- end: left column -->
					<?php endif; ?>

					<?php if (isset($grid['primCentralCol'])): ?>
						<!-- Central column -->
						<div class="hp-block central-column <?php echo $grid['primCentralCol']; ?>">
							<?php echo $this->getChildHtml('container_header_primary_central_1'); ?>
							<?php if (isset($html['primCentralCol'])): ?>
								<div class="item hide-below-960">
									<p class="welcome-msg"><?php echo $this->getChildHtml('welcome'); ?> <?php echo $this->getAdditionalHtml(); ?></p>
								</div>
								<?php foreach ($html['primCentralCol'] as $element): ?>
									<div class="item"><?php echo $element; ?></div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div> <!-- end: central column -->
					<?php endif; ?>

					<?php if (isset($grid['primRightCol'])): ?>
						<!-- Right column -->
						<div class="hp-block right-column <?php echo $grid['primRightCol']; ?>">
							<?php echo $this->getChildHtml('container_header_primary_right_1'); ?>
							<?php if (isset($html['primRightCol'])): ?>
								<?php foreach ($html['primRightCol'] as $element): ?>
									<div class="item"><?php echo $element; ?></div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div> <!-- end: right column -->
					<?php endif; ?>
					
				</div> <!-- end: hp-blocks-holder -->

			</div> <!-- end: inner-container -->
		</div> <!-- end: header-primary -->
	</div> <!-- end: header-primary-container -->

	<?php if ($menuDisplayedInFullWidthContainer): ?>
		<?php echo $menuContainerHtml; ?>
	<?php endif; ?>

</div> <!-- end: header-container3 -->
</div> <!-- end: header-container2 -->
</div> <!-- end: header-container -->
<div id="ajax_loader" style="display:none;"><p class="image" ><img width="150" height="150" src="<?php echo Mage::getBaseUrl(); ?>media/wysiwyg/Icon/loading.gif" alt="loading_gif" /></p></div>
<div class="stitchingservices"></div>

<div class="cart_success"></div>

<?php //Scripts %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% ?>

<script type="text/javascript">
//<![CDATA[

	<?php //Mobile mode ------------------------------------------------- ?>
	<?php if ($mobileHeaderMode): ?>

		var SmartHeader = {

			mobileHeaderThreshold : 770
			, rootContainer : jQuery('.header-container')

			, init : function()
			{
				enquire.register('(max-width: ' + (SmartHeader.mobileHeaderThreshold - 1) + 'px)', {
					match: SmartHeader.moveElementsToMobilePosition,
					unmatch: SmartHeader.moveElementsToRegularPosition
				});
			}

			, activateMobileHeader : function()
			{
				SmartHeader.rootContainer.addClass('header-mobile').removeClass('header-regular');
			}

			, activateRegularHeader : function()
			{
				SmartHeader.rootContainer.addClass('header-regular').removeClass('header-mobile');
			}

			, moveElementsToMobilePosition : function()
			{
				SmartHeader.activateMobileHeader();

				//Move cart
				jQuery('#mini-cart-wrapper-mobile').prepend(jQuery('#mini-cart'));

			<?php if ($move['search']): ?>
				//Move search
				jQuery('#search-wrapper-mobile').prepend(jQuery('#header-search'));
			<?php endif; ?>

			<?php if ($move['user-menu']): ?>
				//Move User Menu
				jQuery('#user-menu-wrapper-mobile').prepend(jQuery('#user-menu'));
			<?php endif; ?>

			<?php if ($move['compare']): ?>
				//Move compare
				jQuery('#mini-compare-wrapper-mobile').prepend(jQuery('#mini-compare'));
			<?php endif; ?>

				//Reset active state
				jQuery('.skip-active').removeClass('skip-active');
				
				//Disable dropdowns
				jQuery('#mini-cart').removeClass('dropdown');
				jQuery('#mini-compare').removeClass('dropdown');

				//Clean up after dropdowns: reset the "display" property
				jQuery('#header-cart').css('display', '');
				jQuery('#header-compare').css('display', '');

			}

			, moveElementsToRegularPosition : function()
			{
				SmartHeader.activateRegularHeader();

				//Move cart
				jQuery('#mini-cart-wrapper-regular').prepend(jQuery('#mini-cart'));

			<?php if ($move['search']): ?>
				//Move search
				jQuery('#search-wrapper-regular').prepend(jQuery('#header-search'));
			<?php endif; ?>

			<?php if ($move['user-menu']): ?>
				//Move User Menu
				jQuery('#user-menu-wrapper-regular').prepend(jQuery('#user-menu'));
			<?php endif; ?>

			<?php if ($move['compare']): ?>
				//Move compare
				jQuery('#mini-compare-wrapper-regular').prepend(jQuery('#mini-compare'));
			<?php endif; ?>

				//Reset active state
				jQuery('.skip-active').removeClass('skip-active');

				//Enable dropdowns
				jQuery('#mini-cart').addClass('dropdown');
				jQuery('#mini-compare').addClass('dropdown');
			}

		}; //end: SmartHeader

		//Important: mobile header code must be executed before sticky header code
		SmartHeader.init();

		jQuery(function($) {

			//Skip Links
			var skipContents = $('.skip-content');
			var skipLinks = $('.skip-link');

			skipLinks.on('click', function (e) {
				e.preventDefault();

				var self = $(this);
				var target = self.attr('href');

				//Get target element
				var elem = $(target);

				//Check if stub is open
				var isSkipContentOpen = elem.hasClass('skip-active') ? 1 : 0;

				//Hide all stubs
				skipLinks.removeClass('skip-active');
				skipContents.removeClass('skip-active');

				//Toggle stubs
				if (isSkipContentOpen) {
					self.removeClass('skip-active');
				} else {
					self.addClass('skip-active');
					elem.addClass('skip-active');
				}
			});

		}); //end: on document ready

	<?php endif; //end: mode  ?>



	<?php //Sticky header ------------------------------------------------- ?>
	<?php if ($sticky): ?>

		jQuery(function($) {

			var StickyHeader = {

				stickyThreshold : <?php echo $mobileMenuThreshold; ?> 
				, isSticky : false
				, isSuspended : false
				, headerContainer : $('.header-container')
				, stickyContainer : $('.sticky-container')	//.nav-container
				, stickyContainerOffsetTop : 55 //Position of the bottom edge of the sticky container relative to the viewport
				, requiredRecalculation : false //Flag: required recalculation of the position of the bottom edge of the sticky container

				, calculateStickyContainerOffsetTop : function()
				{
					//Calculate the position of the bottom edge of the sticky container relative to the viewport
					StickyHeader.stickyContainerOffsetTop = 
						StickyHeader.stickyContainer.offset().top + StickyHeader.stickyContainer.outerHeight();

					//Important: disable flag
					StickyHeader.requiredRecalculation = false;
				}

				, init : function()
				{
					StickyHeader.hookToActivatedDeactivated(); //Important: call before activateSticky is called
					StickyHeader.calculateStickyContainerOffsetTop();
					StickyHeader.applySticky();
					StickyHeader.hookToScroll();
					StickyHeader.hookToResize();

					if (StickyHeader.stickyThreshold > 0)
					{
						enquire.register('(max-width: ' + (StickyHeader.stickyThreshold - 1) + 'px)', {
							match: StickyHeader.suspendSticky,
							unmatch: StickyHeader.unsuspendSticky
						});
					}
				}

				, applySticky : function()
				{
					if (StickyHeader.isSuspended) return;

					//If recalculation required
					if (StickyHeader.requiredRecalculation)
					{
						//Important: recalculate only when header is not sticky
						if (!StickyHeader.isSticky)
						{
							StickyHeader.calculateStickyContainerOffsetTop();
						}
					}

					var viewportOffsetTop = $(window).scrollTop();
					if (viewportOffsetTop > StickyHeader.stickyContainerOffsetTop)
					{
						if (!StickyHeader.isSticky)
						{
							StickyHeader.activateSticky();
						}
					}
					else
					{
						if (StickyHeader.isSticky)
						{
							StickyHeader.deactivateSticky();
						}
					}
				}

				, activateSticky : function()
				{
					var stickyContainerHeight = StickyHeader.stickyContainer.outerHeight();
					var originalHeaderHeight = StickyHeader.headerContainer.css('height');

					//Compensate the change of the header height after the sticky container was removed from its normal position
					StickyHeader.headerContainer.css('height', originalHeaderHeight);

					//Trigger even just before making the header sticky
					$(document).trigger("sticky-header-before-activated");

					//Make the header sticky
					StickyHeader.headerContainer.addClass('sticky-header');
					StickyHeader.isSticky = true;

					//Effect
					StickyHeader.stickyContainer.css('margin-top', '-' + stickyContainerHeight + 'px').animate({'margin-top': '0'}, 200, 'easeOutCubic');
					//StickyHeader.stickyContainer.css('opacity', '0').animate({'opacity': '1'}, 300, 'easeOutCubic');
				}

				, deactivateSticky : function()
				{
					//Remove the compensation of the header height change
					StickyHeader.headerContainer.css('height', '');

					StickyHeader.headerContainer.removeClass('sticky-header');
					StickyHeader.isSticky = false;

					$(document).trigger("sticky-header-deactivated");
				}

				, suspendSticky : function()
				{
					StickyHeader.isSuspended = true;

					//Deactivate sticky header.
					//Important: call method only when sticky header is actually active.
					if (StickyHeader.isSticky)
					{
						StickyHeader.deactivateSticky();
					}
				}

				, unsuspendSticky : function()
				{
					StickyHeader.isSuspended = false;

					//Activate sticky header.
					//Important: call applySticky instead of activateSticky to check if activation is needed.
					StickyHeader.applySticky();
				}

				, hookToScroll : function()
				{
					$(window).on("scroll", StickyHeader.applySticky);
				}

				, hookToScrollDeferred : function()
				{
					var windowScrollTimeout;
					$(window).on("scroll", function() {
						clearTimeout(windowScrollTimeout);
						windowScrollTimeout = setTimeout(function() {
							StickyHeader.applySticky();
						}, 50);
					});
				}

				, hookToResize : function()
				{
					$(window).on('themeResize', function(e) {

						//Require recalculation
						StickyHeader.requiredRecalculation = true;

						//Remove the compensation of the header height change
						StickyHeader.headerContainer.css('height', '');
					});
				}

				, hookToActivatedDeactivated : function()
				{
					//Move elements to sticky header
					$(document).on('sticky-header-before-activated', function(e, data) {

						//Move mini cart to sticky header but only if mini cart is NOT yet inside the holder
						//(if parent of parent doesn't have class "nav-holder").
						if (jQuery('#mini-cart').parent().parent().hasClass('nav-holder') === false)
						{
							jQuery('#nav-holder1').prepend(jQuery('#mini-cart'));
						}

						//Move mini compare to sticky header but only if mini compare is NOT yet inside the holder
						//(if parent of parent doesn't have class "nav-holder").
						if (jQuery('#mini-compare').parent().parent().hasClass('nav-holder') === false)
						{
							jQuery('#nav-holder2').prepend(jQuery('#mini-compare'));
						}

					}); //end: on event

					//Move elements from sticky header to normal position
					$(document).on('sticky-header-deactivated', function(e, data) {

						//Move mini cart back to the regular container but only if mini cart is directly inside the holder
						if (jQuery('#mini-cart').parent().hasClass('nav-holder'))
						{
							jQuery('#mini-cart-wrapper-regular').prepend(jQuery('#mini-cart'));
						}

						//Move mini compare back to the regular container but only if mini compare is directly inside the holder
						if (jQuery('#mini-compare').parent().hasClass('nav-holder'))
						{
							jQuery('#mini-compare-wrapper-regular').prepend(jQuery('#mini-compare'));
						}

					}); //end: on event
				}

			}; //end: StickyHeader

			StickyHeader.init();

		}); //end: on document ready

	<?php endif; //end: if sticky  ?>

//]]>
</script>
<div class="zoom_overlay" style="display: none;">
	<div class="zoom_img_box"><p class="product_zoom_image"></p></div>
	<div class="zoom_msg ajax_message" onclick="close_zoom_img()"><span>Click here to close</span></div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var windowHeight = jQuery(window).height();
		jQuery('#header-nav').css('max-height',''+(windowHeight*0.7)+'px');
		jQuery('div#header-info').css('max-height',''+(windowHeight*0.7)+'px');
		jQuery(window).resize(function(){
			var windowHeight = jQuery(window).height();
			jQuery('#header-nav').css('max-height',''+(windowHeight*0.7)+'px');
			jQuery('div#header-info').css('max-height',''+(windowHeight*0.7)+'px');
		});
		jQuery('.opener').click(function(){
    		if(jQuery(this).parent().parent().attr('id') == 'nav1'){
    			if (jQuery(this).parent().attr('class').indexOf("item-active") >= 0){
    				jQuery(this).parent().removeClass('item-active');
    				jQuery(this).parent().find('div:visible:first').hide();
    			}else{
    				jQuery(this).parent().parent().find('li.nav-item:visible').each(function(){
	    				jQuery(this).removeClass('item-active');
	    				jQuery(this).find('div:visible:first').hide();
	    			});
    				jQuery(this).parent().addClass('item-active');
    				jQuery(this).parent().find('div:hidden:first').show();	
    			}
    		}
		});
	});
	function addstitchingservices(id){
		var url1 = '<?php echo Mage::getBaseUrl(); ?>newaddaction/index';
        var data1 = "&product_id="+id;
        try {
        	jQuery('#ajax_loader').show();
            jQuery.ajax({
               url: url1,
               type : 'post',
               data: data1,
               success: function(response){
                   if (response) {
                        jQuery('.stitchingservices').replaceWith(response);
                        jQuery('#ajax_loader').hide();
                        jQuery('.stitchingservices').simplePopup();
                   }else{
                        var string = '<div class="stitchingservices">Currently the Stitching Services are Unavailable for this product</div>';
                        jQuery('.stitchingservices').replaceWith(string);
                        jQuery('#ajax_loader').hide();
                        jQuery('.stitchingservices').simplePopup();
                   }
               }
			});
        }
        catch(e){ }
	}
	function showstitchingoptions(){
        document.getElementById("show_stitching_services").style.display="block";
    }
    function hidestitchingoptions(){
        document.getElementById("show_stitching_services").style.display="none";
    }
	function setLocationAjaxaddtocart(url,id,isfabric,available_qty){
    	if(isfabric == 1) { var qty = prompt_win(available_qty); }else { var qty = 1; }
    	if(qty > 0) {
    		url = '<?php echo Mage::getBaseUrl(); ?>newaddtocart.php';
	        data1 = '&id='+id+'&qty='+qty+'&store=<?php echo Mage::app()->getStore()->getId(); ?>';
	        jQuery('#ajax_loader').show();
	        try {
	            jQuery.ajax( {
	                url : url,
	                data : data1,
	                dataType : 'json',
	                success : function(data) {
	                	jQuery('#ajax_loader').hide();
	                	var string = jQuery('#mini-cart', data.top_cart);
	                	if(jQuery(document).width() > 769){
	                		jQuery("#mini-cart-wrapper-regular").html(data.top_cart);
	                		jQuery('.sticky-header').find('#nav > #nav-holder1:first').html(string);
	                	}else{
	                		jQuery('.header-mobile').find('#mini-cart-wrapper-mobile:first').html(string);
	                	}
                        if(data.result == 'success'){
                        	var string = '<div class="cart_success">Product was added to your shopping cart.</div>';
                        }else{
                        	var string = '<div class="cart_success">'+data.message+'</div>';
                        }
                        jQuery('.cart_success').replaceWith(string);
                        jQuery('.cart_success').simplePopup();
                        setTimeout(function(){ jQuery('.cart_success').hide(); }, 3000);
	                }
	            });
	        } catch (e) { }
    	};
    }
    function prompt_win(qty) {
    	var the_val = window.prompt("Available quantity: "+qty+";   Please enter the desired quantity","");
    	the_val = (Math.round(the_val * 10) / 10).toFixed(2)
		if(the_val != "" && parseFloat(the_val) <= parseFloat (qty)) return the_val;
		else if(the_val != null)  return prompt_win(qty);
	}
	function zoom_img(src){
		doc_width = jQuery(document).width();
		doc_height = jQuery(document).height();
		// var top = doc_height-jQuery(window).scrollTop();
		if(doc_width < 960) {
			var win = window.open('<?php echo Mage::getBaseUrl(); ?>showpopup.php?img='+src+'', '_blank');
		}else{
			jQuery(".zoom_overlay").css("width",doc_width);
			jQuery(".zoom_overlay").css("height",doc_height);
			// jQuery(".zoom_overlay").css("top",top);
			jQuery(".zoom_overlay").show();
			win_width = jQuery(window).width(); 
			// alert(jQuery(window).height());
			jQuery(".product_zoom_image").css("height",jQuery(window).height()*0.94);
			img_width = win_width * 0.9;
			jQuery(".product_zoom_image").html("<img width='"+img_width+"' src='"+src+"'/>");
		}
		
	}
	function close_zoom_img(){
		jQuery(".zoom_overlay").hide();
	}
</script>