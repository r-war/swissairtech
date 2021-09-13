<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="height:100%">
<tr>
	<td align="center" valign="top">
	<br style="height:20px"/>
	<div class="errorBack" style="margin:10px">
	<table cellpadding="3" cellspacing="0" border="0" width="100%">
	<tr>
		<td style="border-bottom-color: #ECECEC;color: #000; border-bottom-style: solid; border-bottom-width: 1px;" valign="top" align="center">
		{$sExceptionMessage}
		</td>
	</tr>
	{if $oAttributes->getValue('TESTING') == true}
	<tr>
		<td style="color: #000;">
		{$sExceptionStackTrace|nl2br}
		</td>
	</tr>
	{/if}
	</table>
	</div>
	</td>
</tr>
</table>