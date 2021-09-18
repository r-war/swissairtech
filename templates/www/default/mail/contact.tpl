 <div style="letter-spacing: 596px; line-height: 0; mso-hide: all">&nbsp;</div>
<div style="padding:0px;margin:20px 0px 20px 0px;font-family:helvetica, tahoma;font-size:13px;line-height: 140%;">
    <div align="center">
        <div align="left" style="min-width: 99%;border-width: 1px;background-color:#FFFFFF;border-color: #BED1BD;border-style: solid;">
            <table cellpadding="20" cellspacing="0" border="0" style="min-width:100%">
                <tr>
                    <td style="border-width: 0px 0px 1px 0px;border-color: #BED1BD;border-style: solid;background-color: #FFF;">
                        <table cellpadding="5" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td>
                                    <a href="{$oMod->getBaseDomain()}" target="_blank"><img src="{$oMod->getBaseDomain()}/contents/images/{$aConfig.web_logo}"  style="max-width:300px; max-height:100px" border="0"/></a>
                                </td>
                                <td style="vertical-align: baseline; text-align: right;">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border-width: 0px 0px 1px 0px;border-color: #BED1BD;border-style: solid;">
				<table width="100%" cellpadding="5">
					<tbody>
                    {foreach $data as $key=>$value}
						<tr>
							<th width="30%" align="right">{$key}:</th>
							<td width="70%">{$value}</td>
						</tr>
                    {/foreach}

					</tbody>
				</table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellpadding="5" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td align="right">
                                    {$aConfig.copyright}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>