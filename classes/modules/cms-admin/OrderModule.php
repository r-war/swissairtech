<?php
include_once 'AbstractAdminModule.php';

class OrderModule extends AbstractAdminModule
{
	protected $oOrderHeader;
	
	public function getName()
	{
		$sName = 'Order ';
		if($this->oOrderHeader instanceof OrderHeader)
			$sName .= '#'.$this->oOrderHeader->getOrderId();
		
		return $sName;
	}
	
	public function init()
	{
		$this->oOrderHeader = OrderHeaderPeer::retrieveByPK(
			$this->oData->get('select',
				$this->oData->get('delete',
					$this->oData->get('cancel',
						$this->oData->get('submitcancel')
					)
				)
			)
		);
		
		$this->addLink('mode='. $this->oData->get('mode'));
	}
	
	public function ajaxHandler($sAjax)
	{
		switch($sAjax)
		{
			case 'form':
				if($this->oData->isExists('keywords')) $this->addLink('keywords='.urlencode($this->oData->get('keywords')));
				if($this->oData->isExists('approve'))
				{
					$this->updateStatus(2);
				}
				elseif($this->oData->isExists('process'))
				{
					$this->updateStatus(3);
				}
				elseif($this->oData->isExists('deliver'))
				{
					$this->updateStatus(4);
				}
				
				$this->aContext['oOrderHeader'] = $this->oOrderHeader;
			break;

		}
	}
	
	public function doBuildTemplate()
	{
		if($this->oData->isExists('cancel'))
		{
			if($this->oOrderHeader->getStatus() < 9)
			{
				$this->aContext['bReviewCancel'] = true;
				$this->aContext['oOrderHeader'] = $this->oOrderHeader;
				$this->aContext['sDefaultMessage'] = ConfigurationPeer::getValueByKey('content_canceled_order');
			}
		}	
		else if($this->oData->isExists('submitcancel'))
		{
			$this->doCancel();
		}
		else if($this->oData->isExists('delete'))
		{
			$this->doDelete();
		}
		else if($this->oData->isExists('deleteChecked'))
		{
			if(is_array($this->oData->get('c')))
			{
				foreach($this->oData->get('c') as $id)
				{
					$this->oOrderHeader = OrderHeaderPeer::retrieveByPK($id);
					
					if($this->oOrderHeader instanceof OrderHeader)
					{
						$this->doDelete();
					}
				}
				$this->oOrderHeader = null;
			}
		}
		
		$this->preparePage();
	}
	
	private function preparePage()
	{
		$this->regSortable(array_merge(
			OrderHeaderPeer::getFieldNames(BasePeer::TYPE_COLNAME),
			ProductPeer::getFieldNames(BasePeer::TYPE_COLNAME)
		));
		
		$oParam = $this->doHandleParameter();
		$iStatus = $this->oData->get('mode',1);
		if($iStatus != 'all')
		{
			$oParam->set('status', $iStatus);
		}
		
		$this->aContext['aOrderHeader'] = OrderHeaderPeer::getAll(
			$oParam,
			$this->getSortable(),
			$this->getPageList(),
			$oPager
		);

		$this->regPageList(
			$oPager
		);
	}
	
	private function updateStatus($iStatus)
	{
		$this->doValidate($this->oOrderHeader);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				
				if($this->oData->isExists('notes'))
					$this->oOrderHeader->setNotes($this->oData->get('notes'));
				
				$this->oOrderHeader->setStatus($iStatus);
				$this->oOrderHeader->save();
				if($iStatus == 4)
				{
					$bSuccess = $this->doEmail();
					if($bSuccess) $oCon->commit();
					else{
						$this->error('Mail not sent, please try again !');
						throw new Exception('Mail not sent, please try again !');
					}
				}
				else {
					$oCon->commit();
				}

				$oCon->commit();
	
				$this->info('succeed-order-updated',
					array(
						$this->oOrderHeader->getOrderId()
					)
				);
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
					
				$this->error('failed-order-updated',
						array(
							$this->oOrderHeader->getOrderId(),
							$oEx->getMessage()
						)
				);
				$this->errorHandler($oEx);
			}
		}
	}
	
	private function doCancel()
	{
		$this->doValidate($this->oOrderHeader);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
		
				$aOrderDetail = $this->oOrderHeader->getOrderDetails();
				foreach ($aOrderDetail as $oOrderDetail)
				{
					$oProductDetail = ProductDetailPeer::retrieveByPKLockedByOrderDetail($oOrderDetail);
					$oProductDetail->setStock($oProductDetail->getStock()+$oOrderDetail->getQty());
					$oProductDetail->save(); 
				}
				$this->oOrderHeader->setNotes($this->oData->get('notes'));
				$this->oOrderHeader->setExtra($this->oData->get('extra'));
				$this->oOrderHeader->setStatus(9);
				$this->oOrderHeader->save();
				
				$bSuccess = $this->doEmail();
				if($bSuccess) $oCon->commit();
				else{
					$this->error('Mail not sent, please try again !');
					throw new Exception('Mail not sent, please try again !');
				}
	
				$this->info('succeed-order-canceled',
						array(
								$this->oOrderHeader->getOrderId()
						)
				);
				
				$this->oOrderHeader = null;
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
					
				$this->error('failed-order-canceled',
						array(
								$this->oOrderHeader->getOrderId(),
								$oEx->getMessage()
						)
				);
				$this->errorHandler($oEx);
			}
		}
	}	
	
	private function doDelete()
	{
		$oCon = $this->getCon();
		try
		{
			$oCon->beginTransaction();
			
			if($this->oOrderHeader->getStatus() < 9)
			{
				$aOrderDetail = $this->oOrderHeader->getOrderDetails();
				foreach ($aOrderDetail as $oOrderDetail)
				{
					$oProductDetail = ProductDetailPeer::retrieveByPKLockedByOrderDetail($oOrderDetail);
					$oProductDetail->setStock($oProductDetail->getStock()+$oOrderDetail->getQty());
					$oProductDetail->save();  
				}
			}
			
			$this->oOrderHeader->delete();
			$oCon->commit();
			
			$this->info('succeed-order-deleted',
				array(
					$this->oOrderHeader->getOrderId()
				)
			);
		}
		catch (Exception $oEx)
		{
			$oCon->rollBack();
						
			$this->error('failed-order-deleted',
				array(
					$this->oOrderHeader->getOrderId(),
					$oEx->getCause()->getMessage()
				)
			);
			$this->errorHandler($oEx);
	  	}
		$this->oOrderHeader = null;
	}
	
	private function doEmail()
	{
		$aEmailTo = array();
		$sConfigEmail = $this->aConfig['email_enquiry'];
		$aEmail = explode(',', $sConfigEmail);
		foreach ($aEmail as $sEmailTemp)
		{
			$aEmailTo[] = array(trim($sEmailTemp),trim($sEmailTemp));
		}
		
		$aSmtp['host'] = $this->aConfig['smtp_host'];
   		$aSmtp['username'] = $this->aConfig['smtp_user'];
        $aSmtp['password'] = $this->aConfig['smtp_password'];
		$aSmtp['port'] = $this->aConfig['smtp_port'];
        if($aSmtp['host'] == 'smtp.gmail.com')
        	$aSmtp['isgmail'] = true;
		
		$this->sendMail(
			array($this->aConfig['email_from'], $this->aConfig['web_title']),
			$aEmailTo,
			$this->aConfig['web_title'].' : Update Order '.$this->oOrderHeader->getOrderId(),
			'order.tpl',
			array(
				'oOrder' => $this->oOrderHeader,
				'aOrderDetail' => $this->oOrderHeader->getOrderDetails(),	
				'aConfig' => $this->aConfig,
				'oMod' => $this,
				'sTitle' =>$this->aConfig['web_title'].' : Update Order '.$this->oOrderHeader->getOrderId(),
			),
			'text/html',
			null, 
			array($this->oOrderHeader->getEmail(), $this->oOrderHeader->getName()),
			$aSmtp
		);
		
		$bSuccess = $this->sendMail(
				array($this->aConfig['email_from'], $this->aConfig['web_title']),
				array(array($this->oOrderHeader->getEmail(), $this->oOrderHeader->getName())),
				$this->aConfig['web_title'].' : Update Order '.$this->oOrderHeader->getOrderId(),
				'order.tpl',
				array(
						'oOrder' => $this->oOrderHeader,
						'aOrderDetail' => $this->oOrderHeader->getOrderDetails(),	
						'aConfig' => $this->aConfig,
						'oMod' => $this,
						'sTitle' =>$this->aConfig['web_title'].' : Update Order '.$this->oOrderHeader->getOrderId(),
				),
				'text/html',
				null, null,
				$aSmtp
		);
		
		return $bSuccess;
	}
	
	private function doUpdateShippingCost()
	{
		$this->doValidate($this->oOrderHeader);
		if($this->noError())
		{
			$oCon = $this->getCon();
			try
			{
				$oCon->beginTransaction();
				$iCharge = number_format($this->oOrderHeader->getPrice() * 0.05, 2, '.', '');
				$this->oOrderHeader->setTotal($this->oOrderHeader->getTotal()-$this->oOrderHeader->getShippingCost()+$this->oData->get('shippingcost')-$this->oOrderHeader->getCreditCardFee()+$iCharge);
				$this->oOrderHeader->setShippingCost($this->oData->get('shippingcost'));
				$this->oOrderHeader->setCreditCardFee($iCharge);				
				// $this->oOrderHeader->setPayment(1);
				$this->oOrderHeader->save();
				
				$aSmtp['host'] = $this->getConfigurationValue('smtp_host');
           		$aSmtp['username'] = $this->getConfigurationValue('smtp_user');
                $aSmtp['password'] = $this->getConfigurationValue('smtp_password');
				$aSmtp['port'] = $this->getConfigurationValue('smtp_port');
                if($aSmtp['host'] == 'smtp.gmail.com')
                	$aSmtp['isgmail'] = true;
				
				$this->sendMail(
					array($this->getConfigurationValue('email_from'), $this->getConfigurationValue('web_title')),
					array(array($this->oOrderHeader->getEmail(),$this->oOrderHeader->getName())),
					$this->getConfigurationValue('web_title').' : Confirmation Order '.$this->oOrderHeader->getOrderId(),
					'order.tpl',
					array(
						'oOrder' => $this->oOrderHeader,
						'aOrderDetail' => $this->oOrderHeader->getOrderDetails(),	
						'oMod' => $this,
						'sTitle' =>$this->getConfigurationValue('web_title').' : Confirmation Order '.$this->oOrderHeader->getOrderId(),
					),
					'text/html',
					null, 
					array(),
					$aSmtp
				);
				
				$oCon->commit();
				
				$this->info('succeed-quotation-saved',
					array(
						$this->oOrderHeader->getOrderId()
					)
				);
			}
			catch (Exception $oEx)
			{
				$oCon->rollBack();
							
				$this->error('failed-quotation-saved',
					array(
						$this->oOrderHeader->getOrderId(),
						$oEx->getMessage()
					)
				);
				$this->errorHandler($oEx);
		  	}
		}
	}
}
?>