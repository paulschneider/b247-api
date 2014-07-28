<?php namespace Apiv1\Factory;

Class PageMaker {

	public static function make($items = [], $page = 1, $limit = 20)
	{
		if( \Input::get('page') )
		{
			$page = \Input::get('page');
		} 

		if( \Input::get('size') )
		{
			$limit = \Input::get('size');
		}

		$counter = 0;
		$pagination = new \stdClass();
		$pagination->meta = new \stdClass();
		$pagination->meta->totalItems	= count($items);
		$pagination->meta->perPage = (int) $limit;
		$pagination->meta->hasPages = (bool) false;
		$pagination->items = array();

        $offset = $pagination->meta->perPage * ($page-1);

 		if(is_array($items) && $pagination->meta->totalItems)
		{
			foreach($items AS $key => $item)
			{
				if($page == 1)
				{
					if($counter+1*$page <= $pagination->meta->perPage*$page)
					{
						$pagination->items[$key] = $item;
					}
				}
				else
				{
					if($counter >= $pagination->meta->perPage*$page-$pagination->meta->perPage && $counter <= $pagination->meta->perPage*$page-1)
					{
						$pagination->items[$key] = $item;
					}
				}
				$counter++;
			}
		}

        if($pagination->meta->totalItems > $limit)
		{
			$pagination->meta->hasMultiplePages	= true;
		}

		$pagination->meta->totalPages = (int) ceil($pagination->meta->totalItems/$pagination->meta->perPage);
		$pagination->meta->currentPage = (int) $page;
		$pagination->meta->nextPage = (int) $page+1;
		$pagination->meta->prevPage = $page-1 == 0 ? null : (int) $page-1;

		return $pagination;
	}
}