{if $oPager instanceof PropelPager}
	<div class="pull-left">
		{loc k=displaying} {$oPager->getStartRecord()} {loc k=to} {$oPager->getEndRecord()} ({loc k=from} {$oPager->getTotalRecordCount()} {loc k=items})
	</div>
	<div class="pagination pull-right" style="margin: 0px">
	    <ul>
	    	{if !$oPager->atFirstPage()}
				<li><a href="{if $sBaseUrl != null}{$sBaseUrl}?{$oPager->getFirstURL()}{else}{$oMod->getPage($oMod->getModule(),$oPager->getFirstURL())}{/if}" title="{loc k=first}">&laquo;</a></li> 
				<li><a href="{if $sBaseUrl != null}{$sBaseUrl}?{$oPager->getPrevURL()}{else}{$oMod->getPage($oMod->getModule(),$oPager->getPrevURL())}{/if}" title="{loc k=previous}">&lsaquo;</a></li>
			{/if}
		    {foreach from=$oPager->getPrevLinks() key=page_idx item=iPage}
			{assign var=sPageURL value=$oPager->getPageKey()|cat:'='|cat:$iPage}
			<li><a href="{if $sBaseUrl != null}{$sBaseUrl}?{$sPageURL}{else}{$oMod->getPage($oMod->getModule(),$sPageURL)}{/if}">{$iPage}</a></li>
			{/foreach}
			<li class="active"><a href="{if $sBaseUrl != null}{$sBaseUrl}?{$oPager->getPageURL()}{else}{$oMod->getPage($oMod->getModule(),$oPager->getPageURL())}{/if}"><b>{$oPager->getPage()}</b></a></li> 
			{foreach from=$oPager->getNextLinks() key=page_idx item=iPage}
			{assign var=sPageURL value=$oPager->getPageKey()|cat:'='|cat:$iPage}
			<li><a href="{if $sBaseUrl != null}{$sBaseUrl}?{$sPageURL}{else}{$oMod->getPage($oMod->getModule(),$sPageURL)}{/if}">{$iPage}</a></li> 
			{/foreach}
		    {if !$oPager->atLastPage()}
				<li><a href="{if $sBaseUrl != null}{$sBaseUrl}?{$oPager->getNextURL()}{else}{$oMod->getPage($oMod->getModule(),$oPager->getNextURL())}{/if}" title="{loc k=next}">&rsaquo;</a></li>
				<li><a href="{if $sBaseUrl != null}{$sBaseUrl}?{$oPager->getLastURL()}{else}{$oMod->getPage($oMod->getModule(),$oPager->getLastURL())}{/if}" title="{loc k=last}">&raquo;</a></li> 
			{/if}
	    </ul>
    </div>
{/if}
{*
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td>
		{if $sBaseUrl == null}{assign var=sBaseUrl value=$oMod->getPage($oMod->getModule(),$oPager->getPageKey())}{/if} 
		{if $bSecond}
			<input type="text" id="goToPage2" class="textbox" value="{$oPager->getPage()}" style="width:30px"/> <input type="button" class="button" value="{loc k=go}" onclick="document.location='{$sBaseUrl}&{$oPager->getPageKey()}=' + document.getElementById('goToPage2').value"/>
		{else}
			<input type="text" id="goToPage" class="textbox" value="{$oPager->getPage()}" style="width:30px"/> <input type="button" class="button" value="{loc k=go}" onclick="document.location='{$sBaseUrl}&{$oPager->getPageKey()}=' + document.getElementById('goToPage').value"/>
		{/if}
	</td>
*}