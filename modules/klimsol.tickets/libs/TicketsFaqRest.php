<?php 

namespace Bitrix\Klimsol;

class TicketsFaqRest 
// extends \IRestService
{
	public static function OnRestServiceBuildDescription()
	{
		return array(
			'crm' => array(
				'tickets.faq.list' => array(
					'callback' => array(__CLASS__, 'TicketsFaqList'),
					'options' => array(),
				),
			)
		);
	}

	public static function TicketsFaqFilter () {
		if (isset($_GET['faq_id'])) {
			return [
				'ID' => $_GET['faq_id']
			];
		}
		return [];
	}

	public static function TicketsFaqList()
	{
		return FaqTable::GetList([
			'filter' => self::TicketsFaqFilter(),
		])->FetchAll();
	}
}


?>