<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*  only used /shared/Applicationsinresponse
*/
class Appresp extends CI_Model{

	function get_applications($category = NULL ){

		if(is_array($category)){
			$category = "and offers.category =1 or offers.category = 4";
		}
		else{
			$category = !$category ?  "" : "and offers.category = $category";
		}


		$query = $this->db->query("
			SELECT
			`offers`.`id` AS `oid`,
			`offers`.`title` AS `of_title`,
			`offers`.`status` AS `status`,
			`offers`.`type` AS `type`,
			`offers`.`pub_date` AS `pub_date`,
			`offers`.`period` AS `period`,
			`offers_category`.category as `cat`,
			`application_contract`.`type` as `contract_title`,
			
			COUNT(DISTINCT application.user_id) AS total_application,
			COUNT(DISTINCT not_consulted.id) AS not_consulted,
			COUNT(DISTINCT successful_applications.id) AS successful_applications,
			COUNT(DISTINCT unsuccessful_applications.id) AS unsuccessful_applications,
			COUNT(DISTINCT undecided_applications.id) AS undecided_applications,
			COUNT(DISTINCT interesting_for_another_position.id) AS interesting_for_another_position,
			GROUP_CONCAT(DISTINCT functions.function ) as functions ,
			GROUP_CONCAT(DISTINCT activities.activity ) as activities 
		

			FROM
			`offers`
			
			
			
			LEFT JOIN `functions` ON `functions`.`id` = `offers`.`function_id`
			LEFT JOIN `activities` ON `functions`.`activity_id` = `activities`.`id`
						
			LEFT JOIN `offers_category` ON `offers`.`category` = `offers_category`.`id`
			LEFT JOIN `application` ON `offers`.`id` = `application`.`offer_id`
			LEFT JOIN `application_status` ON `application`.`application_statuts` = `application_status`.`id`
			LEFT JOIN `users` ON `application`.`user_id` = `users`.`id`
			LEFT JOIN `users` AS `total` ON `application`.`user_id` = `total`.`id`
			LEFT JOIN `application_contract`  ON `offers`.`type` = `application_contract`.`id`

			LEFT JOIN `users` AS `not_consulted` ON `application`.`user_id` = `not_consulted`.`id`
			AND application.application_statuts = 2
			LEFT JOIN `users` AS `successful_applications` ON `application`.`user_id` = `successful_applications`.`id`
			AND application.application_statuts = 3
			LEFT JOIN `users` AS `unsuccessful_applications` ON `application`.`user_id` = `unsuccessful_applications`.`id`
			AND application.application_statuts = 4
			LEFT JOIN `users` AS `undecided_applications` ON `application`.`user_id` = `undecided_applications`.`id`
			AND application.application_statuts = 5
			LEFT JOIN `users` AS `interesting_for_another_position` ON `application`.`user_id` = `interesting_for_another_position`.`id`
			AND application.application_statuts = 6


			where application.filled = 1  and application.manualy = 0  and application.deleted = 0  $category
			GROUP BY
			`oid`

			");

		return $query->result_array();
	}

	

	public function get_manualy($category = NULL){
		if(is_array($category)){
			$category = "and offers.category =1 or offers.category = 4";
		}
		else{
			$category = !$category ?  "" : "and offers.category = $category";
		}
		$query = $this->db->query("
			SELECT
			`offers`.`id` AS `oid`,
			`offers`.`title` AS `of_title`,
			`offers`.`status` AS `status`,
			`offers`.`type` AS `type`,
			`offers`.`pub_date` AS `pub_date`,
			`offers`.`period` AS `period`,
			`offers_category`.category as `cat`,
			COUNT(DISTINCT application.user_id) AS total_application,
			COUNT(DISTINCT not_consulted.user_id) AS not_consulted,
			COUNT(DISTINCT successful_applications.user_id) AS successful_applications,
			COUNT(DISTINCT unsuccessful_applications.user_id) AS unsuccessful_applications,
			COUNT(DISTINCT undecided_applications.user_id) AS undecided_applications,
			COUNT(DISTINCT interesting_for_another_position.user_id) AS interesting_for_another_position,
			GROUP_CONCAT(DISTINCT functions.function ) as functions ,
			GROUP_CONCAT(DISTINCT activities.activity ) as activities 


			FROM
			`offers`
	
			LEFT JOIN `functions` ON `functions`.`id` = `offers`.`function_id`
			LEFT JOIN `activities` ON `functions`.`activity_id` = `activities`.`id`
			
			LEFT JOIN `offers_category` ON `offers`.`category` = `offers_category`.`id`
			LEFT JOIN `application` ON `offers`.`id` = `application`.`offer_id` and `application`.`manualy` = 1
			LEFT JOIN `application_status` ON `application`.`application_statuts` = `application_status`.`id`
			LEFT JOIN `candidates` ON `application`.`user_id` = `candidates`.`user_id`
			LEFT JOIN `candidates` AS `total` ON `application`.`user_id` = `total`.`user_id`

			LEFT JOIN `candidates` AS `not_consulted` ON `application`.`user_id` = `not_consulted`.`user_id`
			AND application.application_statuts = 2
			LEFT JOIN `candidates` AS `successful_applications` ON `application`.`user_id` = `successful_applications`.`user_id`
			AND application.application_statuts = 3
			LEFT JOIN `candidates` AS `unsuccessful_applications` ON `application`.`user_id` = `unsuccessful_applications`.`user_id`
			AND application.application_statuts = 4
			LEFT JOIN `candidates` AS `undecided_applications` ON `application`.`user_id` = `undecided_applications`.`user_id`
			AND application.application_statuts = 5
			LEFT JOIN `candidates` AS `interesting_for_another_position` ON `application`.`user_id` = `interesting_for_another_position`.`user_id`
			AND application.application_statuts = 6


			where application.filled = 1  and application.manualy = 1  and application.deleted = 0  $category
			GROUP BY
			`oid`

			");

		return $query->result_array();
	}



	public function get_unsolicited($category = NULL){
		$query = $this->db->query("
			SELECT
			application.filled AS aid,

			`application`.`filled` AS `oid`,
			`application`.`filled` AS `of_title`,
			`application`.`filled` AS `status`,
			`application`.`filled` AS `type`,
			`application`.`filled` AS `pub_date`,
			`application`.`filled` AS `period`,
			`application`.filled as `cat`,
			COUNT(
			DISTINCT application.user_id
			) AS total_application,
			COUNT(
			DISTINCT not_consulted.user_id
			) AS not_consulted,
			COUNT(
			DISTINCT successful_applications.user_id
			) AS successful_applications,
			COUNT(
			DISTINCT unsuccessful_applications.user_id
			) AS unsuccessful_applications,
			COUNT(
			DISTINCT undecided_applications.user_id
			) AS undecided_applications,
			COUNT(
			DISTINCT interesting_for_another_position.user_id
			) AS interesting_for_another_position
			FROM
			`application_un`
			LEFT JOIN `application` ON `application_un`.`application_id` = `application`.`id`

			LEFT JOIN `candidates` ON `application`.`user_id` = `candidates`.`user_id`
			LEFT JOIN `candidates` AS `total` ON `application`.`user_id` = `total`.`user_id`
			LEFT JOIN `candidates` AS `not_consulted` ON `application`.`user_id` = `not_consulted`.`user_id`
			AND application.application_statuts = 2
			LEFT JOIN `candidates` AS `successful_applications` ON `application`.`user_id` = `successful_applications`.`user_id`
			AND application.application_statuts = 3
			LEFT JOIN `candidates` AS `unsuccessful_applications` ON `application`.`user_id` = `unsuccessful_applications`.`user_id`
			AND application.application_statuts = 4
			LEFT JOIN `candidates` AS `undecided_applications` ON `application`.`user_id` = `undecided_applications`.`user_id`
			AND application.application_statuts = 5
			LEFT JOIN `candidates` AS `interesting_for_another_position` ON `application`.`user_id` = `interesting_for_another_position`.`user_id`
			AND application.application_statuts = 6
			WHERE
			application.filled = 1
			AND application.deleted = 0
			GROUP BY aid

			");
			
		

		return $query->result_array();
	}


	public function get_unsolicited_new($category = null){
		$query = $this->db->query("
			SELECT
			application.filled AS aid,
			`application_un`.`contract_id` AS `contract`,
			`application`.`add_date` AS `date`,
			`application_un`.`function` AS `function`,
			`application_contract`.`type` AS `contract`,
			`application`.`filled` AS `oid`,
			`application`.`filled` AS `of_title`,
			`application`.`filled` AS `status`,
			`application`.`filled` AS `type`,
			`application`.`filled` AS `pub_date`,
			`application`.`filled` AS `period`,
			`application`.filled AS `cat`,
			COUNT( DISTINCT application.user_id ) AS total_application,
			COUNT( DISTINCT not_consulted.user_id ) AS not_consulted,
			COUNT( DISTINCT successful_applications.user_id ) AS successful_applications,
			COUNT( DISTINCT unsuccessful_applications.user_id ) AS unsuccessful_applications,
			COUNT( DISTINCT undecided_applications.user_id ) AS undecided_applications,
			COUNT( DISTINCT interesting_for_another_position.user_id ) AS interesting_for_another_position 
			FROM
			`application_un`
			LEFT JOIN `application` ON `application_un`.`application_id` = `application`.`id`
			LEFT JOIN `candidates` ON `application`.`user_id` = `candidates`.`user_id`
			LEFT JOIN `candidates` AS `total` ON `application`.`user_id` = `total`.`user_id`
			LEFT JOIN `application_contract`  ON `application_un`.`contract_id` = `application_contract`.`id`
			LEFT JOIN `candidates` AS `not_consulted` ON `application`.`user_id` = `not_consulted`.`user_id` 
			AND application.application_statuts = 2
			LEFT JOIN `candidates` AS `successful_applications` ON `application`.`user_id` = `successful_applications`.`user_id` 
			AND application.application_statuts = 3
			LEFT JOIN `candidates` AS `unsuccessful_applications` ON `application`.`user_id` = `unsuccessful_applications`.`user_id` 
			AND application.application_statuts = 4
			LEFT JOIN `candidates` AS `undecided_applications` ON `application`.`user_id` = `undecided_applications`.`user_id` 
			AND application.application_statuts = 5
			LEFT JOIN `candidates` AS `interesting_for_another_position` ON `application`.`user_id` = `interesting_for_another_position`.`user_id` 
			AND application.application_statuts = 6 
			WHERE
			application.filled = 1 
			AND application.deleted = 0 
			GROUP BY
			application_un.contract_id,application_un.`function`
			");
			
		

		return $query->result_array();
		
	}
}