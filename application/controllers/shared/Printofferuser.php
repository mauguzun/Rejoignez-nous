<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// back / activity
class Printofferuser extends Shared_Controller
{
    private $data = [];
    private $_redirect ;

    private $_table = 'offers_users';
    private $_allowed = [1,2];

    public function __construct()
    {
        parent::__construct($this->_allowed);
        $this->_redirect = base_url().Shared_Controller::$map.'/application';
    }


    public function index($id,$user_id)
    {


        $query = $this->Crud->get_joins(
            $this->_table,
            [

                'offers_users_status'=>"$this->_table.offers_users_status_id = offers_users_status.id",
                'offers_users_applications_type'=>"$this->_table.offers_users_applications_type_id = offers_users_applications_type.id",
                'candidates'=>"$this->_table.user_id = candidates.user_id",

                'users'=>"$this->_table.user_id = users.id",

                'users_english_frechn_level'=>"$this->_table.user_id = users_english_frechn_level.user_id",
                'users_languages_level'=>"$this->_table.user_id = users_languages_level.user_id",
                'offers'=>"$this->_table.offer_id = offers.id",
                'application_contract'=>'offers.type = application_contract.id',
                'countries'=>"candidates.country_id = countries.id",
                'offers_activities'=>"offers.id = offers_activities.offer_id",
                'activities'=>"offers_activities.activiti_id = activities.id",
                'last_level_education'=>"last_level_education.user_id = $this->_table.user_id",
                'hr_offer_education_level'=>"last_level_education.education_level_id = hr_offer_education_level.id",
            ],
            "$this->_table.user_id as uid ,application_contract.type as type,
            offers_users_status.status as status,
            users.email as email,
            offers.id as oid,
            countries.name as country,
            GROUP_CONCAT(DISTINCT activities.activity ) as activities,
            last_level_education.*,
            hr_offer_education_level.level as education_level,
            offers.category as offer_cat,
            offers.id as oid,
            users_english_frechn_level.* ,$this->_table.*,candidates.*",
            ["{$this->_table}.date" => 'DESC'], "uid",
            ["{$this->_table}.offer_id" => $id , "{$this->_table}.user_id" => $user_id]);


        $query = $query[0];
        $query['date'] = time_stamp_to_date($query['date']);

        $managerial = $this->Crud->get_array('id','managerial','hr_offer_expirience_managerial');

        $query['mec_expirience'] = $this->_get_mex_expr($user_id,$managerial);

        $lang_level = $this->Crud->get_array('id','level','language_level');
        $query['english_level'] = $lang_level[$query['english_level']];
        $query['french_level'] = $lang_level[$query['french_level']];

        $pnc_query = $this->Crud->get_all('pnc_offer_experience',["user_id"=>$user_id] );
        $query['pnc_exp'] = $pnc_query;


        $query['pnt_exp'] = $this->Crud->get_all("pnt_offer_flight_expirience",["user_id"=>$user_id]);
        $query['pnt_exp_inst'] = $this->Crud->get_all("pnt_offer_experience_in_instructor",["user_id"=>$user_id]);


        // hr Expirience
        $hr_expirience = $this->Crud->get_joins('hr_offer_expirience',
            [
                'hr_offer_expirience_duration' => "hr_offer_expirience.duration  = hr_offer_expirience_duration.id",
                'hr_offer_expirience_managerial' => 'hr_offer_expirience.managerial = hr_offer_expirience_managerial.id'
            ],'*',['hr_offer_expirience.id'=>'ASC'],NULL,["hr_offer_expirience.user_id"=>$user_id]
        );

        $query['hr_expirience'] = $hr_expirience;
        /*  foreach ($hr_expirience as $row) {
        $query['hr_expirience'][] = ['area'=>$row['area'],'managerial'=>$row['managerial'],'duration'=>$row['duration']];
        }*/

        // all lang

        $more_lang = $this->Crud->get_joins('users_languages_level',
            ['language_level' => "users_languages_level.level_id  = language_level.id" ],
            '*',['users_languages_level.language'=>'ASC'],NULL,
            ["users_languages_level.user_id"=>$user_id]
        );
        $query['more_lang'] = [];
        foreach ($more_lang as $row) {
            $query['more_lang'][$row['language']] = $row['level'];
        }



        $query['handicaped'] = $this->_have($query['handicaped']);
		
		


        require_once("application/libraries/dompdf/vendor/autoload.php");


        // instantiate and use the dompdf class
        $dompdf = new  Dompdf\Dompdf();
        $dompdf->loadHtml($this->load->view('back/printer',['query'=>$query],TRUE));

       //$this->load->view('back/printer',['query'=>$query]);
      

       // (Optional) Setup the paper size and orientation
       $dompdf->setPaper('A4');

        // Render the HTML as PDF
        $dompdf->render();
        $dompdf->stream(url_title($query['first_name'].$query['last_name']), array("Attachment"=> false));
        
        exit(0);


    }

    private function _get_mex_expr($user_id,$managerial)
    {
        $mec_expirience = $this->Crud->get_row(['user_id'=>$user_id],'mechanic_offer_aeronautical_experience');
        if ($mec_expirience) {
            $mechanic_period = $this->Crud->get_array('id','period','mechanic_offer_aeronautical_experience_list');

            $mec_expirience['b737_classic'] = $mechanic_period[$mec_expirience['b737_classic']];
            $mec_expirience['b737_ng'] = $mechanic_period[$mec_expirience['b737_ng']];
            $mec_expirience['part_66_license'] = $this->_have($mec_expirience['part_66_license']) ;
            $mec_expirience['managerial_duties'] = $managerial[$mec_expirience['managerial_duties']] ;

        }
        return $mec_expirience;
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
