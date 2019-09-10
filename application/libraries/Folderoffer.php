<?

class Folderoffer
{

	public  function get_map($category)
	{
		
		switch($category)
		{
			case 1:
			return  'hr';
			break;

			case 2:
			return 'pnc';
			break;
			
			case 3:
			return 'pnt';
			break;
			
			
			case 4:
			return 'mechanic';
			break;
			
			
			
			default:
			return NULL;
		}
		
	}
	
/*	public  function get_map($offer)
	{
		$url = base_url().'apply/';
		switch($offer['category'])
		{
			case 1:
			$url .= 'hr/main/index/'.$offer['id'];
			break;

			case 2:
			$url .= 'pnc/main/index/'.$offer['id'];
			break;
			
			case 3:
			$url .= 'pnt/main/index/'.$offer['id'];
			break;
			
			
			case 4:
			$url .= 'mechanic/main/index/'.$offer['id'];
			break;
			
			
			
			default:
			break;
		}
		return $url;
	}*/
	
	
}