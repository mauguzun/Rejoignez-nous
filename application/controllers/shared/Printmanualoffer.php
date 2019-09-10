<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Printmanualoffer extends Shared_Controller
{

    private $table = 'application';
    private $_allowed = [1,2];

    public function __construct()
    {
        parent::__construct($this->_allowed);
    }


    public function index($app_id)
    {

	

		$query = $this->Crud->get_joins(
			$this->table,
			[
				"candidates"=>"$this->table.user_id = candidates.user_id",

				"applicaiton_misc"=>"$this->table.id = applicaiton_misc.application_id",
				'countries'=>"$this->table.country_id = countries.id",
				'application_languages_level'=>"$this->table.id = application_languages_level.application_id",
				'last_level_education'=>"$this->table.id = last_level_education.application_id",
				'hr_offer_education_level'=>"last_level_education.education_level_id = hr_offer_education_level.id",
				'application_hr_expirience'=>"$this->table.id = application_hr_expirience.application_id",
				'application_english_frechn_level'=>"$this->table.id = application_english_frechn_level.application_id",

			],
			"
			$this->table.* ,
			applicaiton_misc.*,
			
			countries.name as country,
			$this->table.id as aid,
			last_level_education.*,
			application_english_frechn_level.*,
			hr_offer_education_level.level as education_level,
			application_languages_level.* ,candidates.*",
			NULL,
			null,
			["{$this->table}.id" => $app_id]);



		$query      = $query[0];
		
	    $query['application_id'] = $app_id;

	
		$query['handicaped'] = $this->_have($query['handicaped']);
		
		require_once("application/libraries/dompdf/vendor/autoload.php");

		$dompdf = new  Dompdf\Dompdf();
		$dompdf->loadHtml($this->load->view('front/apply/printer_manualy',['query'=>$query],TRUE));

		$dompdf->setPaper('A4');


		$dompdf->render();
		$dompdf->stream(url_title($query['first_name'].$query['last_name']), array("Attachment"=> false));

		exit(0);

    }

 

    private function _have($arg)
    {

        $have = lang('yes_toogle');

        if (strpos($arg, ',')) {
            $arr = explode(',',$arg);
            return max($arr) > 0  ? $have[1] : $have[0];
        }
        return $arg > 0  ? $have[1] : $have[0];

    }
}
