<?php
function convert_number_to_words($number) {
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    if (!is_numeric($number)) {
        return false;
    }
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }
    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    $string = $fraction = null;
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}
function convert_digit_to_words($no)  //taking number as parameter
{
	//creating array  of word for each digit
	$words = array(
		'0'=> 'Zero' ,
		'1'=> 'one' ,
		'2'=> 'two' ,
		'3' => 'three',
		'4' => 'four',
		'5' => 'five',
		'6' => 'six',
		'7' => 'seven',
		'8' => 'eight',
		'9' => 'nine',
		'10' => 'ten',
		'11' => 'eleven',
		'12' => 'twelve',
		'13' => 'thirteen',
		'14' => 'fourteen',
		'15' => 'fifteen',
		'16' => 'sixteen',
		'17' => 'seventeen',
		'18' => 'eighteen',
		'19' => 'nineteen',
		'20' => 'twenty',
		'30' => 'thirty',
		'40' => 'forty',
		'50' => 'fifty',
		'60' => 'sixty',
		'70' => 'seventy',
		'80' => 'eighty',
		'90' => 'ninty',
		'100' => 'hundred',
		'1000' => 'thousand',
		'100000' => 'lakh',
		'10000000' => 'crore'
	);
 //for decimal number taking decimal part
$cash=(int)$no;  //take number wihout decimal
$decpart = $no - $cash; //get decimal part of number
$decpart=sprintf("%01.2f",$decpart); //take only two digit after decimal
$decpart1=substr($decpart,2,1); //take first digit after decimal
$decpart2=substr($decpart,3,1);   //take second digit after decimal  
if($decpart2 == 0) $decpart2 = '';
$decimalstr='';
//if given no. is decimal than  preparing string for decimal digit's word
if($decpart > 0) {
	$decimalstr.="point ".$words[$decpart1]." ".$words[$decpart2];
}
if($no == 0)
	return ' ';
else {
	$novalue = '';
	$highno = $no;
	$remainno=0;
	$value=100;
	$value1=1000;       
	while($no >= 100) {
		if(($value <= $no) &&($no  < $value1))    {
			$novalue=$words["$value"];
			$highno = (int)($no/$value);
			$remainno = $no % $value;
			break;
		}
		$value= $value1;
		$value1 = $value * 100;
	}       
	if(array_key_exists("$highno",$words))  //check if $high value is in $words array
		return $words["$highno"]." ".$novalue." ".convert_digit_to_words($remainno).$decimalstr;  //recursion
	else {
		$unit=$highno%10;
		$ten =(int)($highno/10)*10;            
		return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".convert_digit_to_words($remainno
		).$decimalstr; //recursion
		}
	}
}
?>
<?php //print_r($_REQUEST);
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::app();
	$invoice = Mage::getModel('sales/order_invoice')->load($_REQUEST['id']);
	$order = $invoice->getOrder();
	// print_r($invoice->getData());
	$invoicecurrencycode = $invoice->getOrderCurrencyCode();
	$invoiceno = $invoice->getIncrementId();
	$invoicedate = $invoice->getCreatedAt();
	$date_string = $invoicedate;
	$base = Mage::app()->getStore()->getBaseCurrencyCode();
	$curr = $invoice->getOrderCurrencyCode();
	$date = strtotime($date_string);
	$invoicedaten = date('d/m/y', $date);
	if($order->getPayment()->getMethodInstance()->getCode() == 'icici_standard') {
		$authorised_dealer_code = '6390230-8400009';
	}else{
		$authorised_dealer_code = '0510010-8400009';
	}
	$payment = $order->getPayment();
	$tran = $payment->getLastTransId();

	$orderdate = $order->getCreatedAt();
	$orderno = $order->getIncrementId();
	$date_string1 = $orderdate;
	$date = strtotime($date_string1);
	$orderdaten = date('d/m/y', $date);
	$total = $order->getGrandTotal();
	$totalinword = convert_number_to_words(number_format($order->getGrandTotal(),2));
	$totalinword_inr = convert_digit_to_words($order->getBaseGrandTotal());
	$i = 0;
	$shipping =$order->getShippingAddress()->getData();

	$cusnameship = $shipping['firstname']." ".$shipping['lastname'];
	$companyship = $shipping['company']; 
	$streetship = $shipping['street'];
	$regionship = $shipping['city'].", ".$shipping['region'].", ".$shipping['postcode'];
	$countryship = $shipping['country_id'];
	$telephoneship = $shipping['telephone'];

	$billing = $order->getBillingAddress()->getData();
	$cusnamebilll = $billing['firstname']." ".$billing['lastname'];
	$companybilll = $billing['company']; 
	$streetbilll = $billing['street'];
	$regionbilll = $billing['city'].", ".$billing['region'].", ".$billing['postcode'];
	$countrybilll = $billing['country_id'];
	$telephonebilll = $billing['telephone'];

	$items = $order->getAllItems();
	$read = Mage::getSingleton('core/resource')->getConnection('core_read');
	$query = "SELECT * FROM `invoice_cardholders_list` WHERE `invoice` = '".$invoiceno."' limit 0,1";
	$check = $read->fetchAll($query);
	$cardholdername = '';
	foreach ($check as $value) {
		$cardholdername = $value['name'];
	}
	if(strtoupper($cardholdername) == strtoupper($cusnamebilll)){
		$cardholdername = '';
	}
	if(sizeof($check) == 0){ ?>
		<input type="hidden" id="invoice_num" value="<?php echo $invoiceno; ?>" />
		<script src=https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js></script>
		<script>
			var jQuery = jQuery.noConflict()
			jQuery(document).ready(function() {
				var the_val = window.prompt("Please enter Cardholder`s name ","");
				if(the_val.length > 0){
					var id = jQuery('#invoice_num').val();
					jQuery.ajax({
						url: 'https://www.mysoresareeudyog.com/savecardholdername.php?invoice='+id,
						type: 'POST',
						data: { name: the_val },
						success: function( response ) { location.reload(); },
						error: function(xhr) {
							alert('Card holders name is not saved. Please try again');
							location.reload();
						}
					});
				}else{
					alert('Please enter a Cardholder`s name');
					location.reload();
				}
			});
		</script>
	<?php }
	$invoice .= '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head><title>Commercial Invoice</title>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';
	$invoice .='<style type="text/css">
	.cardholder_name { margin: 0 !important; }
#Table_01 td,#Table_01 th  { border-right:1px solid #000;border-bottom:1px solid #000; }
</style>
</head>
<body bgcolor="#FFFFFF">
<table id="Table_01" width="766" border="0" cellpadding="10px" cellspacing="0" style="font-size:12px; border-style:inset; border:1px solid #000;font-family:arial;">
	<tr style="text-align:center"><th colspan="14">COMMERCIAL INVOICE</th></tr>
	
	<tr>
		<td colspan="6" style="font-weight:bold;background-color:#EAEAEA;">
			Exporter</td>
		<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;">
			Invoice No. & Date</td>
		<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;">
			Exporter Ref.</td>
	</tr>
	<tr>
		<td colspan="6" rowspan="4">
			Mysore Saree Udyog LLP.<br/>			
			#294, 1st Floor, Century Plaza, <br/> 
			K Kamaraj Road, Bangalore, <br/>
			Karnataka, India - 560042.	<br/><br/>
			Phone:+91 8722 8023 03/17. 		<br/>
			Email:ecommerce@mysoresareeudyog.com  <br/>
		</td>
		<td colspan="3">
			'.$invoiceno.'</td>
		<td>
			'.$invoicedaten.'</td>
		<td colspan="4">
			IEC Code : 0703023012</td>
	</tr>
	<tr>
		<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;">
			Buyer\'s Order No. & Date</td>
		<td colspan="4"  style="font-weight:bold;background-color:#EAEAEA;">Authorised Dealer Code</td>
	</tr>
	<tr>
		<td colspan="3">'.$orderno.'</td>
		<td>'.$orderdaten.'</td>
		<td colspan="4">'.$authorised_dealer_code.'</td>
	</tr>
	<tr>
		<td colspan="4" style="font-weight:bold;">
		Other reference(s)</td>
		<td colspan="4"><strong>TIN NO:</strong> 29701262761 </td>
	</tr>
	<tr>
		<td colspan="8" style="font-weight:bold;background-color:#EAEAEA;">
			Consignee</td>
				<td colspan="8" style="font-weight:bold;background-color:#EAEAEA;">
			Buver(if other than Consignee)</td>	
	</tr>
	<tr>
		<td colspan="8">'.$cusnameship.'<br />'.$companyship.'<br/>'.$streetship.'<br/>'.$regionship.'<br/>'.$countryship.'<br/>'.$telephoneship.'<br/>
			</td>';
			if (strlen($cardholdername) > 0) {
				$invoice1 = $cardholdername.'<br> C/o : ';
			}else{
				$invoice1 = '';
			}
		$invoice .='<td colspan="8"><p class="cardholder_name" ></p>'.$invoice1.''.$cusnamebilll.'<br />'.$companybilll.'<br/>'.$streetbilll.'<br/>'.$regionbilll.'<br/>'.$countryship.'<br/>'.$telephonebilll.'<br/></td>
	</tr>
	<tr>
		<td colspan="8" style="font-weight:bold;background-color:#EAEAEA;text-transform:capitalize" >
			CTC Person: '.$cusnameship.'</td>
		<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;">
			Country of origin of goods</td>
		<td colspan="2" style="font-weight:bold;background-color:#EAEAEA;">
			Country of final destination</td>
	</tr>
	<tr>
		<td colspan="8" style="font-weight:bold;background-color:#EAEAEA;">
			Tel No.: '.$telephoneship.'</td>
		<td colspan="4">
			INDIA</td>
		<td colspan="2">'.$countryship.'
			</td>
	</tr>
	<tr>
		<td colspan="8" style="font-weight:bold;background-color:#EAEAEA;">
			</td>
		<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;">
			Terms of Delivery & payment</td>
	</tr>
	<tr>
		<td colspan="1" style="font-weight:bold;">
			Pre-Carriage by</td>
		<td colspan="7">
			Place of Receipt by pre-carrier</td>
			<td style="width:50px;" colspan="1">';
			if (number_format($order->getFeeAmount(),2) > 0 || $countryship == 'AE' || $countryship == 'US' || $countryship == 'HK') {
				$invoice .='<span>C I F</span>';
			} else {
				$invoice .='<span style="border:2px solid black;border-radius:10px;padding:5px;">C I F</span>';
			}
			$invoice .='</td>
		<td>
			C & F </td>
		<td>
			F O B</td>
		<td colspan="1">';
		if (number_format($order->getFeeAmount(),2) > 0 || $countryship == 'AE' || $countryship == 'US' || $countryship == 'HK') {
			$invoice .='<span style="border:2px solid black;border-radius:10px;padding:5px;">D D P</span>';
		} else {
			$invoice .='<span">D D P</span>';
		}
		$invoice .='</td>
	</tr>
	<tr>
		<td colspan="8">
			</td>
		<td colspan="4" rowspan="1">
			</td>
	</tr>
	<tr>
		<td colspan="1" style="font-weight:bold;background-color:#EAEAEA;">
			Vessel / Flight No.</td>
		<td colspan="7" style="font-weight:bold;background-color:#EAEAEA;">
			Port of Loading: Bangalore</td>
		<td colspan="4" style="font-weight:bold;background-color:#EAEAEA;">
			Payment terms :</td>	
	</tr>
	<tr>
		<td colspan="8">
			</td>
		
		<td>D P </td>
		<td>D A </td>
		<td colspan="2" style="text-align: center;"><span style="border:2px solid black;border-radius:10px;padding:5px;">A P</span> </td>
	</tr>
	<tr>
		<td colspan="1">
			Port of Discharge</td>
			<td colspan="7" style="font-weight:bold;">
			Final Destination: <br/> '.$regionship.', '.$countryship.'</td>

	</tr>
	<tr style="font-weight:bold;margin-top:10px; padding:10px;cell-spacing:10px;background-color:#EAEAEA;">
		<td >
			Mark & Numbers.<br/>Box No.</td>

		<td colspan="4">
			Serial number</td>
		<td colspan="3">
			Description of Goods</td>
		<td style="border-top:1px solid;">
			Net Weight<br/>Kilograms</td>
		<td style="border-top:1px solid;">
			Gross Weight<br/>Kilograms</td>
		<td style="border-top:1px solid;">
			Quantity<br/>pcs</td>
		<td style="border-top:1px solid;">
			Quantity<br/>mtrs</td>
		<td style="border-top:1px solid;">
			Rate<br/>('.$order->getOrderCurrencyCode().')</td>
		<td style="border-top:1px solid;">
			Amount<br/>('.$order->getOrderCurrencyCode().')</td>
	</tr>';
	$stitching_services_weight = 0;
	foreach ($items as $item){
		if($item->getIsQtyDecimal()) {
			// $qty1 = 0; 
			$qty1 = ceil(round($item->getQtyOrdered())/5);
		  }
		  else {
			$qty1 = $item->getQtyOrdered();
		}
		$total_qty1 +=  $qty1;
	}
	$boxweight = ceil($total_qty1/3);
	$boxweight = $boxweight*0.300;
	$grossboxweight = $boxweight;
	$boxweight = $boxweight / $total_qty1;

	foreach($items as $item) { 
		$stitching_services_weight1 = 0;
		// }
		if($item->getIsQtyDecimal()) {
			$qty = ""; 
			$qty_mtr = number_format($item->getQtyOrdered(),2);
		}
		else {
			$qty =round($item->getQtyOrdered());
			$qty_mtr = "";
		}
		$total_qty +=  $qty;
		$total_qty_mtr +=  $qty_mtr;
		$i++;
		$price = number_format($item->getPrice(),2);
		$row_total = number_format($item->getRowTotal(),2);
		$price_inr = number_format($item->getBasePrice(),2);
		$row_total_inr = number_format($item->getBaseRowTotal(),2);
		$inter_total = 0;
		$inter_total = $item->getRowTotal()+$inter_total;
		$productweight = number_format( ($item->getWeight() + $stitching_services_weight1) * $item->getQtyOrdered(),2);
		if($item->getIsQtyDecimal()) {
			$qty2 = ceil(round($item->getQtyOrdered())/5);
		}else {
			$qty2 = $item->getQtyOrdered();
		}
		$productgrossweight = $productweight + ($boxweight*$qty2);
		$invoice .='<tr style="margin-top:10px;">
			<td>&nbsp;</td>
			<td>'.$i.'</td>
			<td  colspan="6">'.str_ireplace('with blouse', ' ', $item->getName()).' - '.$item->getSku().'</td>
			<td>'.$productweight.'</td>
			<td>'.number_format($productgrossweight,2).'</td>
			<td>'.$qty.'</td>
			<td>'.$qty_mtr.'</td>
			<td>&nbsp;'.$price.'</td>
			<td style="text-align:right">&nbsp;'.$row_total.'</td>
		</tr>';
	}

	$insurance_charge = $order->getShippingAmount() * 0.5 / 100;
	$freight_charge = $order->getShippingAmount() * 99.5 / 100;
 	$invoice .='<tr style="margin-top:10px;">
		<td  colspan="8" style="text-align:left;font-weight:bold">
			Cost of Goods Total</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right">'.number_format($order->getSubtotal(),2).'</td>
	</tr>

	<tr style="margin-top:10px;">
		<td  colspan="8" style="text-align:rightfont-weight:bold;">
			Discount</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td  style="text-align:right">'. number_format($order->getDiscountAmount(),2).'</td>
	</tr>

	<tr style="margin-top:10px;">
		<td  colspan="8" style="text-align:rightfont-weight:bold;">
			Insurances Charges</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td  style="text-align:right">'. number_format($insurance_charge,2).'</td>
	</tr>

<tr style="margin-top:10px;">
		<td  colspan="8" style="text-align:rightfont-weight:bold;">
			Freight Charges</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style="text-align:right">'. number_format($freight_charge,2).'</td>
	</tr>


<tr style="margin-top:10px;">
		<td  colspan="8" style="font-weight:bold">Total quantity and value</td>
		<td>'.number_format($order->getWeight()+$stitching_services_weight,2).'</td>
		<td>'.number_format($order->getWeight()+$stitching_services_weight+$grossboxweight,2).'</td>
		<td>'. $total_qty.'</td>
		<td>'. $total_qty_mtr.'</td>
		<td>&nbsp;</td>
		<td style="text-align:right">'.number_format($order->getGrandTotal(),2).'</td>
	</tr>



<tr style="margin-top:10px;">
		<td colspan="14">Exchange Rate - '.$order->getOrderCurrencyCode().' 1 = INR '.number_format((1/$order->getBaseToOrderRate()),2).'

		</td>
</tr>';
if($invoicecurrencycode != 'INR') { 
 $invoice .= '<tr style="margin-top:10px;" >
		<td colspan="14" style="font-weight:bold;">Total in '.$order->getOrderCurrencyCode().' : <span style="text-transform:capitalize">'.$totalinword.'</span> only</td>
</tr>';
}

 $invoice .= '<tr style="margin-top:10px;">
		<td colspan="14" style="font-weight:bold;">Total in INR : ('.number_format($order->getBaseGrandTotal(),2).') <span style="text-transform:capitalize">'.$totalinword_inr.'</span> only				
					
				</td>
</tr>
<tr style="margin-top:10px;" >
		<td colspan="14" style="font-weight:bold;">Declaration:	We declare that this Invoice shows the actual price of goods described and that all particulars are true and correct.
				
					
				</td>
</tr>

<tr style="margin-top:10px;">
				<td colspan="14" style="font-weight:bold;">	Date: '.date('d/m/y').' </td>	
</tr>
<tr>
				<td colspan="14" style="font-weight:bold;padding-bottom:50px;">	Signature / Co stamp: Mysore Saree Udyog LLP.	
				
				</td>
</tr>

</table>

</body>
</html>			';
echo $invoice;
 ?>