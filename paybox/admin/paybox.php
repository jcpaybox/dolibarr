<?php
/* Copyright (C) 2004      Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2005-2010 Laurent Destailleur  <eldy@users.sourceforge.org>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */

/**	    \file       htdocs/paybox/admin/paybox.php
 *		\ingroup    paybox
 *		\brief      Page to setup paybox module
 *		\version    $Id: paybox.php,v 1.9 2010/11/01 12:41:33 eldy Exp $
 */

require("../../main.inc.php");
require_once(DOL_DOCUMENT_ROOT."/lib/admin.lib.php");
require_once(DOL_DOCUMENT_ROOT."/lib/doleditor.class.php");

$servicename='PayBox';

$langs->load("admin");
$langs->load("other");
$langs->load("paybox");

if (!$user->admin)
  accessforbidden();


if ($_POST["action"] == 'setvalue' && $user->admin)
{
	//$result=dolibarr_set_const($db, "PAYBOX_IBS_DEVISE",$_POST["PAYBOX_IBS_DEVISE"],'chaine',0,'',$conf->entity);
//	$result=dolibarr_set_const($db, "PAYBOX_CGI_URL_V1",$_POST["PAYBOX_CGI_URL_V1"],'chaine',0,'',$conf->entity);
	$result=dolibarr_set_const($db, "PAYBOX_CGI_URL_V2",$_POST["PAYBOX_CGI_URL_V2"],'chaine',0,'',$conf->entity);
	$result=dolibarr_set_const($db, "PAYBOX_IBS_SITE",$_POST["PAYBOX_IBS_SITE"],'chaine',0,'',$conf->entity);
	$result=dolibarr_set_const($db, "PAYBOX_IBS_RANG",$_POST["PAYBOX_IBS_RANG"],'chaine',0,'',$conf->entity);
	$result=dolibarr_set_const($db, "PAYBOX_PBX_IDENTIFIANT",$_POST["PAYBOX_PBX_IDENTIFIANT"],'chaine',0,'',$conf->entity);
	$result=dolibarr_set_const($db, "PAYBOX_PBX_HMAC",$_POST["PAYBOX_PBX_HMAC"],'chaine',0,'',$conf->entity);

    $result=dolibarr_set_const($db, "PAYBOX_CREDITOR",$_POST["PAYBOX_CREDITOR"],'chaine',0,'',$conf->entity);
	$result=dolibarr_set_const($db, "PAYBOX_CSS_URL",$_POST["PAYBOX_CSS_URL"],'chaine',0,'',$conf->entity);

    $result=dolibarr_set_const($db, "PAYBOX_MESSAGE_OK",$_POST["PAYBOX_MESSAGE_OK"],'chaine',0,'',$conf->entity);
    $result=dolibarr_set_const($db, "PAYBOX_MESSAGE_KO",$_POST["PAYBOX_MESSAGE_KO"],'chaine',0,'',$conf->entity);

    if ($result >= 0)
  	{
  		$mesg='<div class="ok">'.$langs->trans("SetupSaved").'</div>';
  	}
  	else
  	{
		dol_print_error($db);
    }
}


/*
 *	View
 */

$IBS_SITE="1999888";    # Site test
if (empty($conf->global->PAYBOX_IBS_SITE)) $conf->global->PAYBOX_IBS_SITE=$IBS_SITE;
$IBS_RANG="99";         # Rang test
if (empty($conf->global->PAYBOX_IBS_RANG)) $conf->global->PAYBOX_IBS_RANG=$IBS_RANG;
$IBS_DEVISE="978";      # Euro
if (empty($conf->global->PAYBOX_IBS_DEVISE)) $conf->global->PAYBOX_IBS_DEVISE=$IBS_DEVISE;
$IBS_HMAC="0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF";    # Site test
if (empty($conf->global->PAYBOX_IBS_HMAC)) $conf->global->PAYBOX_IBS_HMAC=$IBS_HMAC;
$IBS_HASH="256";    # Site test
if (empty($conf->global->PAYBOX_IBS_HASH)) $conf->global->PAYBOX_IBS_HASH=$IBS_HMAC;

llxHeader();

$linkback='<a href="'.DOL_URL_ROOT.'/admin/modules.php">'.$langs->trans("BackToModuleList").'</a>';
print_fiche_titre($langs->trans("PayBoxSetup"),$linkback,'setup');

print $langs->trans("PayBoxDesc")."<br>\n";


if ($mesg) print '<br>'.$mesg;

print '<br>';
print '<form method="post" action="'.$_SERVER["PHP_SELF"].'">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
print '<input type="hidden" name="action" value="setvalue">';

$var=true;

print '<table class="nobordernopadding" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("AccountParameter").'</td>';
print '<td>'.$langs->trans("Value").'</td>';
print "</tr>\n";

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print '<span class="fieldrequired">'.$langs->trans("PAYBOX_PBX_SITE").'</span></td><td>';
print '<input size="32" type="text" name="PAYBOX_IBS_SITE" value="'.$conf->global->PAYBOX_IBS_SITE.'">';
print '<br>'.$langs->trans("Example").': 1999888 ('.$langs->trans("Test").')';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print '<span class="fieldrequired">'.$langs->trans("PAYBOX_PBX_RANG").'</span></td><td>';
print '<input size="32" type="text" name="PAYBOX_IBS_RANG" value="'.$conf->global->PAYBOX_IBS_RANG.'">';
print '<br>'.$langs->trans("Example").': 99 ('.$langs->trans("Test").')';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print '<span class="fieldrequired">'.$langs->trans("PAYBOX_PBX_IDENTIFIANT").'</span></td><td>';
print '<input size="32" type="text" name="PAYBOX_PBX_IDENTIFIANT" value="'.$conf->global->PAYBOX_PBX_IDENTIFIANT.'">';
print '<br>'.$langs->trans("Example").': 2 ('.$langs->trans("Test").')';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print '<span class="fieldrequired">'.$langs->trans("PAYBOX_PBX_HMAC").'</span></td><td>';
print '<input size="32" type="text" name="PAYBOX_PBX_HMAC" value="'.$conf->global->PAYBOX_PBX_HMAC.'">';
print '<br>'.$langs->trans("Example").': 0123456789....ABCDEF ('.$langs->trans("Test").')';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print '<span class="fieldrequired">'.$langs->trans("PAYBOX_PBX_HASH").'</span></td><td>';
print '<input size="32" type="text" name="PAYBOX_PBX_HASH" value="'.$conf->global->PAYBOX_PBX_HASH.'">';
print '<br>'.$langs->trans("Example").': 256 ('.$langs->trans("Test").')';
print '</td></tr>';

$var=true;
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("UsageParameter").'</td>';
print '<td>'.$langs->trans("Value").'</td>';
print "</tr>\n";

/*
$var=!$var;
print '<tr '.$bc[$var].'><td>';
print $langs->trans("PAYBOX_IBS_DEVISE").'</td><td>';
print '<input size="32" type="text" name="PAYBOX_IBS_DEVISE" value="'.$conf->global->PAYBOX_IBS_DEVISE.'">';
print '<br>'.$langs->trans("Example").': 978 (EUR)';
print '</td></tr>';
*/

/*
$var=!$var;
print '<tr '.$bc[$var].'><td>';
print $langs->trans("PAYBOX_CGI_URL_V1").'</td><td>';
print '<input size="64" type="text" name="PAYBOX_CGI_URL_V1" value="'.$conf->global->PAYBOX_CGI_URL_V1.'">';
print '<br>'.$langs->trans("Example").': http://mysite/cgi-bin/module_linux.cgi';
print '</td></tr>';
*/

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print '<span class="fieldrequired">'.$langs->trans("PAYBOX_CGI_URL_V2").'</span></td><td>';
print '<input size="64" type="text" name="PAYBOX_CGI_URL_V2" value="'.$conf->global->PAYBOX_CGI_URL_V2.'">';
print '<br>'.$langs->trans("Example").': http://mysite/cgi-bin/modulev2_redhat72.cgi';
print '<br><!>'.$langs->trans("LeaveEmptyWhenYouUseHMAC")."<!>";
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print '<span class="fieldrequired">'.$langs->trans("PAYBOX_CGI_URL_HMAC").'</span></td><td>';
print '<input size="64" type="text" name="PAYBOX_CGI_URL_HMAC" value="'.$conf->global->PAYBOX_CGI_URL_V2.'">';
print '<br>'.$langs->trans("ForProduction").' : https//tpeweb.paybox.com/php/';
print '<br>'.$langs->trans("ForTest").' : https//preprod-toeweb.paybox.com/php/';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print $langs->trans("VendorName").'</td><td>';
print '<input size="64" type="text" name="PAYBOX_CREDITOR" value="'.$conf->global->PAYBOX_CREDITOR.'">';
print '<br>'.$langs->trans("Example").': '.$mysoc->nom;
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print $langs->trans("CSSUrlForPaymentForm").'</td><td>';
print '<input size="64" type="text" name="PAYBOX_CSS_URL" value="'.$conf->global->PAYBOX_CSS_URL.'">';
print '<br>'.$langs->trans("Example").': http://mysite/mycss.css';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print $langs->trans("MessageOK").'</td><td>';
$doleditor=new DolEditor('PAYBOX_MESSAGE_OK',$conf->global->PAYBOX_MESSAGE_OK,60,'Basic','In',false,true,true,ROWS_2,60);
$doleditor->Create();
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'><td>';
print $langs->trans("MessageKO").'</td><td>';
$doleditor=new DolEditor('PAYBOX_MESSAGE_KO',$conf->global->PAYBOX_MESSAGE_KO,60,'Basic','In',false,true,true,ROWS_2,60);
$doleditor->Create();
print '</td></tr>';

print '<tr><td colspan="2" align="center"><br><input type="submit" class="button" value="'.$langs->trans("Modify").'"></td></tr>';
print '</table></form>';

print '<br><br>';

print '<u>'.$langs->trans("FollowingUrlAreAvailableToMakePayments").':</u><br>';
// Should work with DOL_URL_ROOT='' or DOL_URL_ROOT='/dolibarr'
$urlwithouturlroot=preg_replace('/'.preg_quote(DOL_URL_ROOT,'/').'$/i','',$dolibarr_main_url_root);
print img_picto('','object_globe.png').' '.$langs->trans("ToOfferALinkForOnlinePaymentOnFreeAmount",$servicename).':<br>';
print '<b>'.$urlwithouturlroot.DOL_URL_ROOT.'/public/paybox/newpayment.php?amount=<i>9.99</i>&tag=<i>your_free_tag</i></b>'."<br>\n";
if ($conf->commande->enabled)
{
	print img_picto('','object_globe.png').' '.$langs->trans("ToOfferALinkForOnlinePaymentOnOrder",$servicename).':<br>';
	print '<b>'.$urlwithouturlroot.DOL_URL_ROOT.'/public/paybox/newpayment.php?source=order&ref=<i>order_ref</i></b>'."<br>\n";
}
if ($conf->facture->enabled)
{
	print img_picto('','object_globe.png').' '.$langs->trans("ToOfferALinkForOnlinePaymentOnInvoice",$servicename).':<br>';
	print '<b>'.$urlwithouturlroot.DOL_URL_ROOT.'/public/paybox/newpayment.php?source=invoice&ref=<i>invoice_ref</i></b>'."<br>\n";
//	print $langs->trans("SetupPayBoxToHavePaymentCreatedAutomatically",$langs->transnoentitiesnoconv("FeatureNotYetAvailable"))."<br>\n";
}
if ($conf->contrat->enabled)
{
	print img_picto('','object_globe.png').' '.$langs->trans("ToOfferALinkForOnlinePaymentOnContractLine",$servicename).':<br>';
	print '<b>'.$urlwithouturlroot.DOL_URL_ROOT.'/public/paybox/newpayment.php?source=contractline&ref=<i>contractline_ref</i></b>'."<br>\n";
}
if ($conf->adherent->enabled)
{
	print img_picto('','object_globe.png').' '.$langs->trans("ToOfferALinkForOnlinePaymentOnMemberSubscription",$servicename).':<br>';
	print '<b>'.$urlwithouturlroot.DOL_URL_ROOT.'/public/paybox/newpayment.php?source=membersubscription&ref=<i>member_ref</i></b>'."<br>\n";
}

print "<br>";
print info_admin($langs->trans("YouCanAddTagOnUrl"));

$db->close();

llxFooter('$Date: 2010/11/01 12:41:33 $ - $Revision: 1.9 $');
?>
