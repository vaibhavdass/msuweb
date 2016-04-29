<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    design
 * @package     base_default
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
?>
<?php
/**
 * Shopping cart template
 *
 * @see Mage_Checkout_Block_Cart
 */
?>
<div class="cart">
    <div class="page-title title-buttons">
        <h1><?php echo $this->__('Shopping Cart') ?></h1>
        <?php /* if(!$this->hasError()): ?>
        <ul class="checkout-types">
        <?php foreach ($this->getMethods('top_methods') as $method): ?>
            <?php if ($methodHtml = $this->getMethodHtml($method)): ?>
            <li><?php echo $methodHtml; ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
        </ul>
        <?php endif; */ ?>
    </div>
    <?php echo $this->getMessagesBlock()->getGroupedHtml() ?>
    <?php echo $this->getChildHtml('form_before') ?>
    <form action="<?php echo $this->getUrl('checkout/cart/updatePost') ?>" method="post" class="the-cart-form">
        <?php echo $this->getBlockHtml('formkey'); ?>
        <fieldset>
        <div class="cart-table-wrapper">
            <table id="shopping-cart-table" class="data-table cart-table">
                <col class="col-img" width="1" />
                <col />
                <col class="col-edit" width="1" />
            <?php if ($this->helper('wishlist')->isAllowInCart()) : ?>
                <col class="col-wish" width="1" />
            <?php endif ?>
            <?php if ($this->helper('tax')->displayCartPriceExclTax() || $this->helper('tax')->displayCartBothPrices()): ?>
                <col class="col-unit-price" width="1" />
            <?php endif; ?>
            <?php if ($this->helper('tax')->displayCartPriceInclTax() || $this->helper('tax')->displayCartBothPrices()): ?>
                <col class="col-unit-price" width="1" />
            <?php endif; ?>
                <col width="1" />
            <?php if ($this->helper('tax')->displayCartPriceExclTax() || $this->helper('tax')->displayCartBothPrices()): ?>
                <col class="<?php if($this->helper('tax')->displayCartBothPrices()) echo 'col-total-excl'; else echo 'col-total'; ?>" width="1" />
            <?php endif; ?>
            <?php if ($this->helper('tax')->displayCartPriceInclTax() || $this->helper('tax')->displayCartBothPrices()): ?>
                <col class="<?php if($this->helper('tax')->displayCartBothPrices()) echo 'col-total-incl'; else echo 'col-total'; ?>" width="1" />
            <?php endif; ?>
                <col class="col-delete" width="1" />

            <?php $mergedCells = ($this->helper('tax')->displayCartBothPrices() ? 2 : 1); ?>
                <thead>
                    <tr>
                        <th class="col-img" rowspan="<?php echo $mergedCells; ?>">&nbsp;</th>
                        <th rowspan="<?php echo $mergedCells; ?>"><span class="nobr"><?php echo $this->__('Product Name') ?></span></th>
                        <!-- <th class="col-edit" rowspan="<?php echo $mergedCells; ?>"><?php echo $this->__('UOM') ?></th> -->
                        <th class="col-edit a-center" rowspan="<?php echo $mergedCells; ?>"><span class="nobr"><?php echo $this->__(' &nbsp; UOM &nbsp; &nbsp; &nbsp; ') ?></span></th>
                        <th class="col-edit a-center" rowspan="<?php echo $mergedCells; ?>"><span class="nobr">
                        <?php echo $this->__('Weight(kg)') ?></span></th>
                        <?php if ($this->helper('wishlist')->isAllowInCart()) : ?>
                        <th class="col-wish a-center" rowspan="<?php echo $mergedCells; ?>"><span class="nobr"><?php echo $this->__('Move to Wishlist') ?></span></th>
                        <?php endif ?>
                        <th class="col-unit-price a-center" colspan="<?php echo $mergedCells; ?>"><span class="nobr"><?php echo $this->__('Unit Price') ?></span></th>
                        <th rowspan="<?php echo $mergedCells; ?>" class="a-center"><?php echo $this->__('Qty') ?></th>
                        <th class="a-center" colspan="<?php echo $mergedCells; ?>"><?php echo $this->__('Subtotal') ?></th>
                        <th class="col-delete a-center" rowspan="<?php echo $mergedCells; ?>">&nbsp;</th>
                    </tr>
                    <?php if ($this->helper('tax')->displayCartBothPrices()): ?>
                    <tr>
                        <th class="col-unit-price a-right"><?php echo $this->helper('tax')->getIncExcTaxLabel(false) ?></th>
                        <th class="col-unit-price"><?php echo $this->helper('tax')->getIncExcTaxLabel(true) ?></th>
                        <th class="col-total-excl a-right"><?php echo $this->helper('tax')->getIncExcTaxLabel(false) ?></th>
                        <th class="col-total-incl"><?php echo $this->helper('tax')->getIncExcTaxLabel(true) ?></th>
                    </tr>
                    <?php endif; ?>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="50" class="a-right">
                            <?php if($this->getContinueShoppingUrl()): ?>
                                <button type="button" title="<?php echo Mage::helper('core')->quoteEscape($this->__('Continue Shopping')) ?>" class="button btn-continue btn-inline" onclick="setLocation('<?php echo Mage::helper('core')->quoteEscape($this->getContinueShoppingUrl()) ?>')"><span><span><?php echo $this->__('Continue Shopping') ?></span></span></button>
                            <?php endif; ?>
                            <button type="submit" name="update_cart_action" value="update_qty" title="<?php echo Mage::helper('core')->quoteEscape($this->__('Update Shopping Cart')); ?>" class="button btn-update btn-inline"><span><span><?php echo $this->__('Update Shopping Cart'); ?></span></span></button>

							<?php /*?>
                            <a id="link-cart-update" href="#">Test submit</a>
                            <script type="text/javascript">
                            jQuery(function($){
                                $('#link-cart-update').click(function() {
                                    $('.the-cart-form').submit();
                                });
                            });
                            </script>
							<?php */?>
                            
							<?php /*?>
                            <button type="submit" name="update_cart_action" value="empty_cart" title="<?php echo $this->__('Clear Shopping Cart'); ?>" class="button btn-empty" id="empty_cart_button"><span><span><?php echo $this->__('Clear Shopping Cart'); ?></span></span></button>
                            <!--[if lt IE 8]>
                            <input type="hidden" id="update_cart_action_container" />
                            <script type="text/javascript">
                            //<![CDATA[
                                Event.observe(window, 'load', function()
                                {
                                    // Internet Explorer (lt 8) does not support value attribute in button elements
                                    $emptyCartButton = $('empty_cart_button');
                                    $cartActionContainer = $('update_cart_action_container');
                                    if ($emptyCartButton && $cartActionContainer) {
                                        Event.observe($emptyCartButton, 'click', function()
                                        {
                                            $emptyCartButton.setAttribute('name', 'update_cart_action_temp');
                                            $cartActionContainer.setAttribute('name', 'update_cart_action');
                                            $cartActionContainer.setValue('empty_cart');
                                        });
                                    }

                                });
                            //]]>
                            </script>
                            <![endif]-->
                            <?php */?>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                <?php foreach($this->getItems() as $_item): ?>
                    <?php echo $this->getItemHtml($_item) ?>
                <?php endforeach ?>
                </tbody>
            </table>
            <script type="text/javascript">decorateTable('shopping-cart-table')</script>
        <!-- end: cart-table-wrapper -->
        </fieldset>
    </form>
    <div class="cart-collaterals nested-container">
    	<div class="cart-right-column grid12-4">
            <div class="totals grid-full alpha omega">
                <div class="totals-inner">
                <?php echo $this->getChildHtml('totals'); ?>
                <?php if(!$this->hasError()): ?>
                    <ul class="checkout-types">
                    <?php foreach ($this->getMethods('methods') as $method): ?>
                    	<?php if ($methodHtml = $this->getMethodHtml($method)): ?>
                    		<li><?php echo $methodHtml; ?></li>
                    	<?php endif; ?>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                </div>
            </div>
			<?php if ($tmpHtml = $this->getChildHtml('block_cart_below_totals')): ?>
            	<div class="block_cart_below_totals grid-full alpha omega"><?php echo $tmpHtml; ?></div>
            <?php endif; ?>
        </div> <!-- end: cart-right-column -->
        <div class="cart-left-column grid12-8">
        	<?php if ($tmpHtml = $this->getChildHtml('checkout.cart.extra')): ?>
            <div class="grid-full alpha omega">
                <?php /* Extensions placeholder */ ?>
                <?php echo $tmpHtml; ?>
			</div>
            <?php endif; ?>
            
            <?php if ($tmpHtml = $this->getChildHtml('block_cart_below_table')): ?>
            	<div class="block_cart_below_table grid-full alpha omega"><?php echo $tmpHtml; ?></div>
            <?php endif; ?>
            
			<div class="grid12-6 mobile-grid-half">
            	<?php if (!$this->getIsVirtual()): echo $this->getChildHtml('shipping'); endif; ?>
			</div>
			<div class="grid12-6 mobile-grid-half">
            	<?php echo $this->getChildHtml('coupon') ?>
            </div>
            <div class="grid-full alpha omega">
                <?php echo $this->getChildHtml('crosssell') ?>
            </div>
        </div> <!-- end: cart-left-column -->
    </div>
</div>
<div id="stantard-dialogBox"></div>
<div class="stitchingservices"></div>
<script type="text/javascript">
    var jQuery = jQuery.noConflict();
    jQuery(function(){
        jQuery('.btn-stantard').click(function(){
            if(jQuery(this).attr('href') == '#'){
                var data1 = "&product_id="+jQuery(this).attr('data');
                var url1 = '<?php echo Mage::getBaseUrl(); ?>newaddaction/index';
                try {
                    jQuery.ajax({
                       url: url1,
                       type : 'post',
                       data: data1,
                       success: function(response){
                           if (response) {
                                jQuery('.stitchingservices').replaceWith(response);
                                jQuery('.stitchingservices').simplePopup();
                           }else{
                                var string = '<div class="stitchingservices">Currently the Stitching Services are Unavailable for this product</div>';
                                jQuery('.stitchingservices').replaceWith(string);
                                jQuery('.stitchingservices').simplePopup();
                           }
                       }
                       });
                }
                catch(e){ }
            }
        })
    })
</script>
<script type="text/javascript">
    function showstitchingoptions(){
        document.getElementById("show_stitching_services").style.display="block";
    }
    function hidestitchingoptions(){
        document.getElementById("show_stitching_services").style.display="none";
    }
</script>