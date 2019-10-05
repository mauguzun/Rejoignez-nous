<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'vendor/autoload.php';
class Fake extends CI_Controller
{


    private    $faker;
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->faker = Faker\Factory::create();


        $activites = array_column($this->Crud->get_all('activities'),'id');



        for ($i = 0; $i < 1000 ; $i++) {

            $user = [
                'title' => $this->faker->userName,
                'category'=>rand(1,5),
                'type'=>rand(1,4),
                'location'=>rand(1,4),
                'start_date'=>$this->faker->date($format = 'Y-m-d'),
                'pub_date'=>$this->faker->date($format = 'Y-m-d'),
                'period'=>rand(1,1123123),
                'status'=>1,
                'admin_id'=>39,
                'mission'=>$this->faker->text(255),
                'profile'=>$this->faker->text(255),
            ];
            
            $d  = new DateTime();
 

            $id     = $this->Crud->add($offers,'offers');


            if ($id) {
                $count = rand(2,7);

                for ($i = 0; $i < $count; $i++) {
                    $this->Crud->add(['offer_id'=>$id,
                            'activiti_id'=>$activites[rand(0,count($activites))]],'offers_activities');

                }
            }



        }

    }

}
