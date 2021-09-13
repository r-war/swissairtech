function CheckAll(chk)
{
	if(chk != null)
	{
		if(chk.length > 0)
		{
			for (i = 0; i < chk.length; i++)
			chk[i].checked = true ;
		}
		else
		{
			chk.checked = true ;
		}
	}
}

function UnCheckAll(chk)
{
	if(chk != null)
	{
		if(chk.length > 0)
		{
			for (i = 0; i < chk.length; i++)
			chk[i].checked = false ;
		}
		else
		{
			if(chk != 'undefine')
			{
				chk.checked = false ;
			}
		}
	}
}

function ToggleCheck(form)
{
	checkAll = document.getElementById('checkAll');
	chk = form.elements['c[]'];
	
	if(checkAll.checked == true)
	{
		CheckAll(chk);
	}
	else
	{
		UnCheckAll(chk);
	}
}