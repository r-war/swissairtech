<?php

class MyPropelPager extends PropelPager {

	protected $con;
	protected $currentCount;

	public function setPageKey($sPageKey)
	{
		$this->pageKey = $sPageKey;
	}

	/**
	 * Guesses the Peer count method based on the select method.
	 */
	private function guessPeerCountMethod()
	{
		$selectMethod = $this->getPeerSelectMethod();
		if ($selectMethod == 'doSelect') {
			$countMethod = 'doCount';
		} elseif ( ($pos = stripos($selectMethod, 'doSelectJoin')) === 0) {
			$countMethod = 'doCount' . substr($selectMethod, strlen('doSelect'));
		} else {
			// we will fall back to doCount() if we don't understand the join
			// method; however, it probably won't be accurate.  Maybe triggering an error would
			// be appropriate ...
			$countMethod = 'doCount';
		}
		$this->setPeerCountMethod($countMethod);
	}
	
	public function getResult()
	{
		$this->doRs();

		return $this->rs;
	}

	/**
	 * Get the paged resultset
	 *
	 * Main method which creates a paged result set based on the criteria
	 * and the requested peer select method.
	 *
	 */
	private function doRs()
	{
//		print $this->getStart().'-'.$this->getRowsPerPage();
		if(!isset($this->rs))
		{
			$this->criteria->setOffset($this->getStart());
			$this->criteria->setLimit($this->getRowsPerPage());
			$this->rs = call_user_func_array(
				array(
					$this->getPeerClass(), 
					$this->getPeerSelectMethod()
				), 
				array(
					$this->criteria,
					$this->con
				)
			);
//			Common::printArray(BasePeer::createSelectSql($this->criteria,$temp=array()));
//			Common::printArray($this->rs);
			$this->currentCount = count($this->rs);
		}
	}

	/**
	 * Set the current page number (First page is 1).
	 * @param      int $page
	 * @return     void
	 */
	public function setPage($page)
	{
		if((int) $page == 0)
		{
			$page = 1;
		}
		$this->page = $page;
		// (re-)calculate start rec
		//$this->calculateStart();
	}

	/**
	 * Get current page.
	 * @return     int
	 */
	public function getPage()
	{
		if($this->getTotalPages() > 0)
		{
			if($this->page > $this->getTotalPages())
			{
				return $this->getTotalPages();
			}
			if($this->page < 1)
			{
				return 1;
			}
	
			return $this->page;
		}
		
		return 1;
	}

	/**
	 * Set the number of rows per page.
	 * @param      int $r
	 */
	public function setRowsPerPage($r)
	{
		if((int) $r == 0)
		{
			$r = 20;
		}
		$this->max = $r;
		// (re-)calculate start rec
		//$this->calculateStart();
	}

	/**
	 * Calculate startrow / max rows based on current page and rows-per-page.
	 * @return     void
	 */
	private function getStart()
	{
//		print '#'.$this->getPage().'-'.$this->getRowsPerPage().'#';
		$iStart = ( ($this->getPage() - 1) * $this->getRowsPerPage() );
		if($iStart < 0)
		{
			$iStart = 0;
		}
//		print $iStart.'*';
		return $iStart;
//		print $this->start .'*';
	}

	
	public function getPageKey()
	{
		return $this->pageKey;
	}
	
	public function getPageURL()
	{
		return $this->pageKey .'='.$this->getPage();
	}
	
	public function getPrevURL()
	{
		return $this->pageKey .'='.$this->getPrev();
	}
	
	public function getFirstURL()
	{
		return $this->pageKey .'='.$this->getFirstPage();
	}
	
	public function getNextURL()
	{
		return $this->pageKey .'='.$this->getNext();
	}
	
	public function getLastURL()
	{
		return $this->pageKey .'='.$this->getLastPage();
	}
	
	public function getStartRecord()
	{
		if($this->currentCount == 0)
		{
			return 0;
		}
		else 
		{
			return $this->getStart() + 1;
		}
	}
	
	public function getEndRecord()
	{
		$iRecordCount = ($this->currentCount-1);
		
		if($iRecordCount < 0)
		{
			$iRecordCount = 0;
		}
		
		return $this->getStartRecord() + $iRecordCount;
	}
}
