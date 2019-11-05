<?php

class Uploadlist
{

    public function get_pnt()
    {
        return  [
	        'certificate_of_flang',
	        'attestation',
	        'attestation_of_medical_fitness',
	        'carnet_of_flight',
	        'attestation_of_irme',
	        'id_photo'
        ];
       
    }

	public function get_pnc()
	{
		return  [
	        'certificate_of_flang',
	        'medical_aptitude',
	        'photo_in_feet',
	        'passport',
	        'certificate_of_registration_at_the_employment_center',
	        'vaccine_against_yellow_fever',
	        'id_photo'
        ];
		
	}
	
	public function get_main(){
		
		return [
			'cv','covver_letter'
		];
	}
	
	public function get_mechanic()
	{
		return  [
	        'complementary_documents',
        ];
	}
	
	public function site_img(){
		return 'img';
	}
	
	public function get_pricacy(){
		return 'privacy';
	}
	
		public function get_unsolocated()
	{
		return  [
	        
	        'covver_letter',
	       'cv',
        ];
		
	}
	
	
}
