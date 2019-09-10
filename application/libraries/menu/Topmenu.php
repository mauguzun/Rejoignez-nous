<?php

class Topmenu
{

    public function get($logined  )
    {

        $menu =
        [
            'offers'=>'our_offers',
            
           // '#help'=>'need_help',            
            '#contact'=>'contact',
            'policy'=>'our_recruitment_policy',
          //  'not/index'=>'gallery_of_professions',
        ];

        if ($logined) {
            $menu['auth/logout'] = 'logout';
        }else {
            $menu['auth/login'] = 'candidate_space';
        }
        return $menu;
    }


}
?>