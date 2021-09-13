<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>{$aConfig.web_title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<div style="padding:0px;margin:20px 0px 20px 0px;font-family:tahoma;font-size:13px;line-height: 140%;">
	<div align="center">
		<div align="left" style="width: 700px;border-width: 1px;background-color:#FFFFFF;border-color: #BED1BD;border-style: solid;">
		<table cellpadding="20" cellspacing="0" border="0" width="100%">
		<tr>
			<td style="border-width: 0px 0px 1px 0px;border-color: #BED1BD;border-style: solid;background-color: #FFFFFF;">
			<table cellpadding="5" cellspacing="0" border="0" width="100%">
			<tr>
				<td>
					<a href="{$oMod->getBaseDomain()}" target="_blank"><img src="{$oMod->getBaseDomain()}/contents/{$oMod->getBaseDomain(false)}/images/{$aConfig.web_logo}"  style="max-width:650px; max-height:100px" border="0"/></a>
				</td>
		         <td style="vertical-align: baseline; text-align: right;">

	                {if $aConfig.facebook_link}<a href="{$aConfig.facebook_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-facebook_on.png"></a>{/if}
                    {if $aConfig.twitter_link}<a href="{$aConfig.twitter_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-twitter_on.png"></a>{/if}
                    {if $aConfig.youtube_link}<a href="{$aConfig.youtube_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-youtube_on.png"></a>{/if}
                    {if $aConfig.google_link}<a href="{$aConfig.google_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-google_on.png"></a>{/if}
                    {if $aConfig.linkedin_link}<a href="{$aConfig.linkedin_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-linkedin_on.png"></a>{/if}


                    {if $aConfig.pinterest_link}<a href="{$aConfig.pinterest_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/ico-pinterest.png"></a>{/if}
                    {if $aConfig.instagram_link}<a href="{$aConfig.instagram_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/ico-instagram.png"></a>{/if}
                    {if $aConfig.blogger_link}<a href="{$aConfig.blogger_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-blogger.png"></a>{/if}
				</td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<th style="padding:0px;font-size:20px;text-align:left;padding: 10px 30px;border-width: 0px 0px 1px 0px;border-color: #BED1BD;border-style: solid;color:#000; background-color: #E8C30B">
				{$sTitle}
			</th>
		</tr>
		<tr>
			<td style="border-width: 0px 0px 1px 0px;border-color: #BED1BD;border-style: solid;">
				Dear {$oUser->getName()},
				<br/>
				<br/>Thank you for creating your account at our Website. Your account details are as follows:
				<br/>Email Address: {$oUser->getEmail()}
				<br/>Password: {$sPassword}
				<br/> 
				<br/>To sign in to your account, please visit <a href="{$oMod->getBaseDomain()}/login">click here</a>.
				<br/>
				<br/>If you have any questions regarding your account, click 'Reply' and we'll be more than happy to help.
				<br/>
				<br/>Many love and thanks!
			</td>
		</tr>
		<tr>
			<td>
			<table cellpadding="5" cellspacing="0" border="0" width="100%">
			<tr>
				<td align="right">
					{$aConfig.copyright|@nl2br}
				</td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
		</div>
	</div>
</div>
</body>
</html>