<?php namespace Api\Factory;

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
		$pagination->totalItems	= count($items);
		$pagination->perPage = $limit;
		$pagination->hasPages = false;
		$pagination->items = array();

        $offset = $pagination->perPage * ($page-1);

 		if(is_array($items) && $pagination->totalItems)
		{
			foreach($items AS $key => $item)
			{
				if($page == 1)
				{
					if($counter+1*$page <= $pagination->perPage*$page)
					{
						$pagination->items[$key] = $item;
					}
				}
				else
				{
					if($counter >= $pagination->perPage*$page-$pagination->perPage && $counter <= $pagination->perPage*$page-1)
					{
						$pagination->items[$key] = $item;
					}
				}
				$counter++;
			}
		}

        if($pagination->totalItems > $limit)
		{
			$pagination->hasPages	= true;
		}

		$pagination->totalPages = ceil($pagination->totalItems/$pagination->perPage);
		$pagination->currentPage = $page;
		$pagination->nextPage = $page+1;
		$pagination->prevPage = $page-1 == 0 ? 1 : $page-1;

		return $pagination;
	}

}