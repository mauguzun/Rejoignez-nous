<?

class Ajax_Controller extends CI_Controller
{


	private $_result;

	public function __construct($group)
	{
		parent::__construct();
		$this->load->language('admin');

		if(!$this->ion_auth->in_group($group))
		{
			show_error('please login',401,'please login');
		}
		$this->_result = [];

	}

	public function toogle()
	{


		if(isset($_POST))
		{

			$this->load->library('html/toogle');

			$toogle = $this->toogle->init(0,$_POST['column'],$_POST['table'])->set_text(lang('pub_toogle'))->set_flag($_POST['value']);
			$toogle->set_toogle();

			$this->Crud->update(['id'=>$_POST['id']],[$_POST['column']=>$toogle->get_value()],$_POST['table']);

			$this->_result['text'] = $toogle->get_text();
			$this->_result['value'] = $toogle->get_value();
			$this->_result['class'] = $toogle->get_class();
			
			
			echo json_encode($this->_result);
			return;
		}
		echo json_encode(['error'=>TRUE]);

	}



	public function typehead()
	{

		if(isset($_POST))
		{
			$arr = $this->Crud->clearArray($_POST,['query','table','column']);
			if($arr)
			{
				$query = $this->Crud->get_like([$arr['column']=>$arr['query']],$arr['table']);

				foreach($query as $value)
				{
					array_push($this->_result,$value[$arr['column']]);
				}
				//$this->_result = array_map( function( $a ) { return $a[$arr['column']]; }, $query );
				echo json_encode($this->_result);
				return;
			}
		}
		echo json_encode(['error'=>TRUE]);
	}





	public function user_modal($table,$column,$id,$selector = "id")
	{


		$user_id = $this->ion_auth->user()->row()->id;
		$this->show_modal(['user_id'=>$user_id,$selector=>$id],$table,$column);
	}

	public function modal($table,$column,$id,$selector = "id")
	{

		$this->show_modal([$selector=>$id],$table,$column);

	}

	public function copy($id = NULL)
	{


		$offers = $this->Crud->get_row(['id'=>$id],'offers');
		unset($offers['id']);
		$offers['title'] .= ' copy';
		$new_id = $this->Crud->add($offers,'offers');
		// lets tec :)

		foreach($this->Crud->get_all('offers_activities',['offer_id'=>$id]) as $value){
			$row = $value;
			$row['offer_id'] = $new_id;
			$this->Crud->add($row,'offers_activities');
		}
		if($new_id)
		{
			echo json_encode(['done'=>$new_id]);
			return;
		}


		echo json_encode(['error'=>TRUE]);
	}

	protected function show_modal($where,$table,$column)
	{

		$query = $this->Crud->get_row($where,$table);
		if($query && isset($query[$column]))
		{
			$this->_result['text'] = $query[$column];
			echo json_encode($this->_result);
			return;
		}
		echo json_encode(['error'=>TRUE]);
	}


}