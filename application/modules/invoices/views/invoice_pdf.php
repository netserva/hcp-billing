<?php declare(strict_types=1);
ini_set('memory_limit', '-1');
function stripAccents($string)
{
    $chars = ['Ά' => 'Α', 'ά' => 'α', 'Έ' => 'Ε', 'έ' => 'ε', 'Ή' => 'Η', 'ή' => 'η', 'Ί' => 'Ι', 'ί' => 'ι', 'Ό' => 'Ο', 'ό' => 'ο', 'Ύ' => 'Υ', 'ύ' => 'υ', 'Ώ' => 'Ω', 'ώ' => 'ω'];
    foreach ($chars as $find => $replace) {
        $string = str_replace($find, $replace, $string);
    }

    return $string;
}

$ratio = 1.3;
$logo_height = intval(config_item('invoice_logo_height') / $ratio);
$logo_width = intval(config_item('invoice_logo_width') / $ratio);
$color = config_item('invoice_color');

$inv = Invoice::view_by_id($id);
$l = Client::view_by_id($inv->client)->language;
$client_cur = Client::view_by_id($inv->client)->currency;
$lang2 = $this->lang->load('hd_lang', $l, true, false, '', true); ?>
<html>
<head>
    <style>
        body {
            font-family: dejavusanscondensed;
            font-size: 10pt;
            line-height: 13pt;
            color: #777777;
        }
        p {
            margin: 4pt 0 0 0;
        }
        td {
            vertical-align: top;
        }
        .items td {
            border: 0.2mm solid #ffffff;
            background-color: #F5F5F5;
        }
        table thead td {
            vertical-align: bottom;
            text-align: center;
            text-transform: uppercase;
            font-size: 7pt;
            font-weight: bold;
            background-color: #FFFFFF;
            color: #111111;
        }
        table thead td {
            border-bottom: 0.2mm solid <?php echo $color; ?>;
        }
        table .last td  {
            border-bottom: 0.2mm solid <?php echo $color; ?>;
        }
        table .first td  {
            border-top: 0.2mm solid <?php echo $color; ?>;
        }
        .watermark {
            text-transform: uppercase;
            font-weight: bold;
            position: absolute;
            left: 100px;
            top: 400px;
        }
    </style>
</head>
<body>
<?php
$watermark = $lang2[Invoice::payment_status($inv->inv_id)];
$watermark = stripAccents(mb_strtoupper($watermark));
?>
<watermarktext content="<?php echo $watermark; ?>" alpha="0.05" />
<htmlpageheader name="myheader">
    <div>
        <table width="100%">
            <tr>
                <td width="60%" height="<?php echo $logo_height; ?>">
                    <img style="height: <?php echo $logo_height; ?>px; width: <?php echo $logo_width; ?>px;" src="<?php echo base_url(); ?>resource/images/logos/<?php echo config_item('invoice_logo'); ?>" />
                </td>
                <td width="40%" style="text-align: right;">
                    <div style="font-weight: bold; color: #111111; font-size: 20pt; text-transform: uppercase;"><?php echo stripAccents($lang2['invoice']); ?></div>
                    <table>
                        <tr>
                            <td width="10%">&nbsp;</td>
                            <td width="55%" style="color: <?php echo $color; ?>; text-align: left; font-size: 9pt; text-transform: uppercase;"><?php echo stripAccents($lang2['reference_no']); ?>:</td>
                            <td width="25%" style="text-align: right; font-size: 9pt;"><?php echo $inv->reference_no; ?></td>
                        </tr>
                        <tr>
                            <td width="10%">&nbsp;</td>
                            <td width="55%" style="color: <?php echo $color; ?>; text-align: left; font-size: 9pt; text-transform: uppercase;"><?php echo stripAccents($lang2['invoice_date']); ?>:</td>
                            <td width="25%" style="text-align: right; font-size: 9pt;"><?php echo strftime(config_item('date_format'), strtotime($inv->date_saved)); ?></td>
                        </tr>
                        <tr>
                            <td width="10%">&nbsp;</td>
                            <td width="55%" style="color: <?php echo $color; ?>; text-align: left; font-size: 9pt; text-transform: uppercase;"><?php echo stripAccents($lang2['payment_due']); ?>:</td>
                            <td width="25%" style="text-align: right; font-size: 9pt;"><?php echo strftime(config_item('date_format'), strtotime($inv->due_date)); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <div style="font-size: 9pt; text-align: left; padding-top: 3mm; width:40%; float:left;">
        <?php echo nl2br(config_item('invoice_footer')); ?>
    </div>
    <div style="font-size: 9pt; text-align: right; padding-top: 3mm; width:40%; float:right;">
        <?php echo $lang2['page']; ?> {PAGENO} <?php echo $lang2['page_of']; ?> {nb}
    </div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1"  />
<sethtmlpagefooter name="myfooter" value="on" />

<div style="height:<?php echo $logo_height; ?>px;">&nbsp;</div>
<div style="margin-bottom: 20px; margin-top: 30px;">
    <table width="100%" cellpadding="10" style="vertical-align: top;">
        <tr>

            <?php if ('FALSE' == config_item('swap_to_from')) { ?>
                <td width="45%" style="border-bottom:0.2mm solid <?php echo $color; ?>; font-size: 9pt; font-weight:bold; color: <?php echo $color; ?>; text-transform: uppercase;"><?php echo stripAccents($lang2['received_from']); ?></td>
                <td width="10%">&nbsp;</td>
            <?php } ?>

            <td width="45%" style="border-bottom:0.2mm solid <?php echo $color; ?>; font-size: 9pt; font-weight:bold; color: <?php echo $color; ?>; text-transform: uppercase;"><?php echo stripAccents($lang2['bill_to']); ?></td>


            <?php if ('TRUE' == config_item('swap_to_from')) { ?>
                <td width="10%">&nbsp;</td>
                <td width="45%" style="border-bottom:0.2mm solid <?php echo $color; ?>; font-size: 9pt; font-weight:bold; color: <?php echo $color; ?>; text-transform: uppercase;"><?php echo stripAccents($lang2['received_from']); ?></td>
            <?php } ?>

        </tr>
        <tr>
            <?php if ('FALSE' == config_item('swap_to_from')) { ?>
                <td width="45%">
                    <span style="font-size: 11pt; font-weight: bold; color: #111111;"><?php echo (config_item('company_legal_name_'.$l) ? config_item('company_legal_name_'.$l) : config_item('company_legal_name')); ?></span><br/>
                    <?php echo (config_item('company_address_'.$l) ? config_item('company_address_'.$l) : config_item('company_address')); ?><br>
                    <?php echo (config_item('company_city_'.$l) ? config_item('company_city_'.$l) : config_item('company_city')); ?>
                    <?php if ('' != config_item('company_zip_code_'.$l) || '' != config_item('company_zip_code')) { ?>
                        , <?php echo (config_item('company_zip_code_'.$l) ? config_item('company_zip_code_'.$l) : config_item('company_zip_code')); ?><br>
                    <?php } ?>
                    <?php if ('' != config_item('company_state_'.$l) || '' != config_item('company_state')) { ?>
                        <?php echo (config_item('company_state_'.$l) ? config_item('company_state_'.$l) : config_item('company_state')); ?>,
                    <?php } ?>
                    <?php echo (config_item('company_country_'.$l) ? config_item('company_country_'.$l) : config_item('company_country')); ?><br>
                    <?php echo $lang2['phone']; ?> | <?php echo (config_item('company_phone_'.$l) ? config_item('company_phone_'.$l) : config_item('company_phone')); ?><br>
                    <?php if ('' != config_item('company_phone_2_'.$l) || '' != config_item('company_phone_2')) { ?>
                        , <?php echo (config_item('company_phone_2_'.$l) ? config_item('company_phone_2_'.$l) : config_item('company_phone_2')); ?><br>
                    <?php } ?>
                    <?php if ('' != config_item('company_fax_'.$l) || '' != config_item('company_fax')) { ?>
                        <?php echo $lang2['fax']; ?> | <?php echo (config_item('company_fax_'.$l) ? config_item('company_fax_'.$l) : config_item('company_fax')); ?><br>
                    <?php } ?>
                    <?php if ('' != config_item('company_registration_'.$l) || '' != config_item('company_registration')) { ?>
                        <?php echo $lang2['company_registration']; ?> | <?php echo (config_item('company_registration_'.$l) ? config_item('company_registration_'.$l) : config_item('company_registration')); ?><br>
                    <?php } ?>
                    <?php if ('' != config_item('company_vat_'.$l) || '' != config_item('company_vat')) { ?>
                        <?php echo $lang2['company_vat']; ?> | <?php echo (config_item('company_vat_'.$l) ? config_item('company_vat_'.$l) : config_item('company_vat')); ?><br>
                    <?php } ?>
                </td>
                <td width="10%">&nbsp;</td>
            <?php } ?>
            <td width="45%">
        <span style="font-size: 11pt; font-weight: bold; color: #111111;">
        <?php echo Client::view_by_id($inv->client)->company_name; ?></span><br/>
                <?php echo Client::view_by_id($inv->client)->company_address; ?><br/>
                <?php echo Client::view_by_id($inv->client)->city; ?>
                <?php if ('' != Client::view_by_id($inv->client)->zip) {
    echo ', '.Client::view_by_id($inv->client)->zip;
} ?><br/>
                <?php if ('' != Client::view_by_id($inv->client)->state) {
    echo Client::view_by_id($inv->client)->state.', ';
} ?>
                <?php echo Client::view_by_id($inv->client)->country; ?> <br/>
                <?php $phone = Client::view_by_id($inv->client)->company_phone; ?>
                <?php if ('' != $phone) { ?>
                    <span><?php echo $lang2['phone']; ?> | </span><?php echo $phone; ?><br/>
                <?php } ?>
                <?php $fax = Client::view_by_id($inv->client)->company_fax; ?>
                <?php if ('' != $fax) { ?>
                    <span><?php echo $lang2['fax']; ?> | </span><?php echo $fax; ?><br/>
                <?php } ?>
                <?php $vat = Client::view_by_id($inv->client)->VAT; ?>
                <?php if ('' != $vat) { ?>
                    <span><?php echo $lang2['company_vat']; ?> | </span><?php echo $vat; ?> <br/>
                <?php } ?>
            </td>
            <?php if ('TRUE' == config_item('swap_to_from')) { ?>
                <td width="10%">&nbsp;</td>
                <td width="45%">
                    <span style="font-size: 11pt; font-weight: bold; color: #111111;"><?php echo (config_item('company_legal_name_'.$l) ? config_item('company_legal_name_'.$l) : config_item('company_legal_name')); ?></span><br/>
                    <?php echo (config_item('company_address_'.$l) ? config_item('company_address_'.$l) : config_item('company_address')); ?><br>
                    <?php echo (config_item('company_city_'.$l) ? config_item('company_city_'.$l) : config_item('company_city')); ?>
                    <?php if ('' != config_item('company_zip_code_'.$l) || '' != config_item('company_zip_code')) { ?>
                        , <?php echo (config_item('company_zip_code_'.$l) ? config_item('company_zip_code_'.$l) : config_item('company_zip_code')); ?>
                    <?php } ?><br>
                    <?php if ('' != config_item('company_state_'.$l) || '' != config_item('company_state')) { ?>
                        <?php echo (config_item('company_state_'.$l) ? config_item('company_state_'.$l) : config_item('company_state')); ?>,
                    <?php } ?>
                    <?php echo (config_item('company_country_'.$l) ? config_item('company_country_'.$l) : config_item('company_country')); ?><br>
                    <?php echo $lang2['phone']; ?> | <?php echo (config_item('company_phone_'.$l) ? config_item('company_phone_'.$l) : config_item('company_phone')); ?>
                    <?php if ('' != config_item('company_phone_2_'.$l) || '' != config_item('company_phone_2')) { ?>
                        , <?php echo (config_item('company_phone_2_'.$l) ? config_item('company_phone_2_'.$l) : config_item('company_phone_2')); ?>
                    <?php } ?><br>
                    <?php if ('' != config_item('company_fax_'.$l) || '' != config_item('company_fax')) { ?>
                        <?php echo $lang2['fax']; ?> | <?php echo (config_item('company_fax_'.$l) ? config_item('company_fax_'.$l) : config_item('company_fax')); ?><br>
                    <?php } ?>
                    <?php if ('' != config_item('company_vat_'.$l) || '' != config_item('company_vat')) { ?>
                        <?php echo $lang2['company_vat']; ?> | <?php echo (config_item('company_vat_'.$l) ? config_item('company_vat_'.$l) : config_item('company_vat')); ?>
                    <?php } ?><br>
                </td>

            <?php } ?>
        </tr>
    </table>
</div>
<sethtmlpageheader name="myheader" value="off" />
<table class="items" width="100%" style="border-spacing:3px; font-size: 9pt; border-collapse: collapse;" cellpadding="10">
    <thead>
    <tr>
        <?php if ('FALSE' == config_item('show_invoice_tax')) { ?>
            <td width="60%" style="text-align: left;"><?php echo stripAccents($lang2['item_name']); ?> </td>
            <td width="10%"><?php echo stripAccents($lang2['qty']); ?> </td>
            <td width="15%"><?php echo stripAccents($lang2['unit_price']); ?> </td>
            <td width="15%"><?php echo stripAccents($lang2['total']); ?> </td>
        <?php } else { ?>
            <td width="45%" style="text-align: left;"><?php echo stripAccents($lang2['item_name']); ?> </td>
            <td width="10%"><?php echo stripAccents($lang2['qty']); ?> </td>
            <td width="15%"><?php echo stripAccents($lang2['unit_price']); ?> </td>
            <td width="15%"><?php echo stripAccents($lang2['tax']); ?> </td>
            <td width="15%"><?php echo stripAccents($lang2['total']); ?> </td>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php foreach (Invoice::has_items($id) as $idx => $item) { ?>
        <tr<?php echo $idx + 1 == count(Invoice::has_items($id)) ? ' class="last"' : ''; ?>>
            <?php if ('FALSE' == config_item('show_invoice_tax')) { ?>
                <td width="60%" style="text-align: left;"><div style="margin-bottom:6px; font-weight:bold; color: #111111;"><?php echo $item->item_name; ?></div>
                    <?php echo nl2br($item->item_desc); ?></td>
                <td width="10%" style="text-align: center;"><?php echo Applib::format_quantity($item->quantity); ?></td>
                <td width="15%" style="text-align: right;"><?php if (!User::is_admin() && !User::is_staff()) {
    echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $item->unit_cost));
} else {
                                            echo Applib::format_currency($inv->currency, $item->unit_cost);
                                        }
                                    ?></td>
                <td width="15%" style="text-align: right;"> <?php if (!User::is_admin() && !User::is_staff()) {
                                        echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $item->total_cost));
                                    } else {
                                            echo Applib::format_currency($inv->currency, $item->total_cost);
                                        }
                                       ?> </td>
            <?php } else { ?>
                <td width="45%" style="text-align: left;"><div style="margin-bottom:6px; font-weight:bold; color: #111111;"><?php echo $item->item_name; ?></div>
                    <?php echo nl2br($item->item_desc); ?></td>
                <td width="10%" style="text-align: center;"><?php echo Applib::format_quantity($item->quantity); ?></td>
                <td width="15%" style="text-align: right;"><?php if (!User::is_admin() && !User::is_staff()) {
                                           echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $item->unit_cost));
                                       } else {
                                            echo Applib::format_currency($inv->currency, $item->unit_cost);
                                        }
                                    ?> </td>
                <td width="15%" style="text-align: right;"><?php if (!User::is_admin() && !User::is_staff()) {
                                        echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $item->item_tax_total));
                                    } else {
                                            echo Applib::format_currency($inv->currency, $item->item_tax_total);
                                        }
                                       ?></td>
                <td width="15%" style="text-align: right;"><?php if (!User::is_admin() && !User::is_staff()) {
                                           echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, $item->total_cost));
                                       } else {
                                            echo Applib::format_currency($inv->currency, $item->total_cost);
                                        }
                                       ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
    <?php $colspan = ('FALSE' == config_item('show_invoice_tax') ? '1' : '2'); ?>
    <tr class="first">

        <td colspan="<?php echo $colspan; ?>" style="background-color:#ffffff;"></td>
        <td colspan="2" style="font-size: 8pt; color: #111111;"><strong><?php echo $lang2['total']; ?></strong></td>
        <td style="font-weight: bold; color: #111111; text-align: right;"><?php if (!User::is_admin() && !User::is_staff()) {
                                           echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_subtotal($inv->inv_id)));
                                       } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_subtotal($inv->inv_id));
                                        }
                                     ?></td>
    </tr>
    <?php if ($inv->tax > 0) { ?>
        <tr>
            <td colspan="<?php echo $colspan; ?>" style="background-color:#ffffff;"></td>
            <td colspan="2" style="font-size: 8pt; color: #111111;">
                <strong><?php echo config_item('tax_name'); ?> (<?php echo Applib::format_tax($inv->tax); ?>%)</strong></td>
            <td style="font-weight: bold; color: #111111; text-align: right;"><?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_tax($inv->inv_id)));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_tax($inv->inv_id));
                                        }
                                     ?></td>
        </tr>
    <?php } ?>

    <?php if ($inv->tax2 > 0) { ?>
        <tr>
            <td colspan="<?php echo $colspan; ?>" style="background-color:#ffffff;"></td>
            <td colspan="2" style="font-size: 8pt; color: #111111;">
                <strong><?php echo $lang2['tax']; ?> 2 (<?php echo Applib::format_tax($inv->tax2); ?>%)</strong></td>
            <td style="font-weight: bold; color: #111111; text-align: right;"><?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_tax($inv->inv_id, 'tax2')));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_tax($inv->inv_id, 'tax2'));
                                        }
                                     ?></td>
        </tr>
    <?php } ?>

    <?php if ($inv->discount > 0) { ?>
        <tr>
            <td colspan="<?php echo $colspan; ?>" style="background-color:#ffffff;"></td>
            <td colspan="2" style="font-size: 8pt; color: #111111;">
                <strong><?php echo $lang2['discount']; ?> - <?php echo Applib::format_tax($inv->discount); ?>%</strong></td>
            <td style="font-weight: bold; color: #111111; text-align: right;"> <?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_discount($inv->inv_id)));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_discount($inv->inv_id));
                                        }
                                     ?> </td>
        </tr>
    <?php } ?>
    <?php if ($inv->extra_fee > 0) { ?>
        <tr>
            <td colspan="<?php echo $colspan; ?>" style="background-color:#ffffff;"></td>
            <td colspan="2" style="font-size: 8pt; color: #111111;">
                <strong><?php echo $lang2['extra_fee']; ?> - <?php echo Applib::format_tax($inv->extra_fee); ?>%</strong></td>
            <td style="font-weight: bold; color: #111111; text-align: right;"><?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_fee($inv->inv_id)));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_fee($inv->inv_id));
                                        }
                                     ?></td>
        </tr>
    <?php } ?>
    <?php
    $payment_made = Invoice::get_invoice_paid($inv->inv_id);
    if ($payment_made > 0) { ?>
        <tr>
            <td colspan="<?php echo $colspan; ?>" style="background-color:#ffffff;"></td>
            <td colspan="2" style="font-size: 8pt; color: #111111;"><strong><?php echo $lang2['payment_made']; ?></strong></td>
            <td style="font-weight: bold; color: #111111; text-align: right;">
            <?php if (!User::is_admin() && !User::is_staff()) {
        echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_paid($inv->inv_id)));
    } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_paid($inv->inv_id));
                                        }
                                     ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="<?php echo $colspan; ?>" style="background-color:#ffffff;"></td>
        <td colspan="2" style="font-size: 8pt; color: #111111; background-color: <?php echo $color; ?>; color:#ffffff;"><strong><?php echo $lang2['balance_due']; ?></strong></td>
        <td style="font-weight: bold; color: #111111; text-align: right; background-color: <?php echo $color; ?>; color:#ffffff;"><?php if (!User::is_admin() && !User::is_staff()) {
                                         echo Applib::format_currency($client_cur, Applib::client_currency($client_cur, Invoice::get_invoice_due_amount($inv->inv_id)));
                                     } else {
                                            echo Applib::format_currency($inv->currency, Invoice::get_invoice_due_amount($inv->inv_id));
                                        }
                                     ?></td>
    </tr>

    </tbody>
</table>
<div style="margin-top:40px;">
    <h4 style="padding:5px 0; color: #111111; border-bottom: 0.2mm solid <?php echo $color; ?>; font-size:9pt; text-transform: uppercase;"><?php echo stripAccents($lang2['payment_information']); ?></h4>
    <?php echo $inv->notes; ?>
</div>

</body>
</html>
