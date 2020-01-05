<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_title extends CI_Migration
{

	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();


	}

	public function up()
	{
		$this->dbforge->modify_column('offers',[
				'title'=>[
					'type' => 'varchar',
					'constraint'=>'250'
				]
			]);


		$this->Crud->add(['id'=>77,'name'=>'communication','description'=>'Communication'],'groups');

		$this->db->query('DROP TABLE IF EXISTS `emails`;');
		$this->db->query('DROP TABLE IF EXISTS `email_template`;');
		$this->db->query('CREATE TABLE `email_template`  (`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
			`placeholder` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
			PRIMARY KEY (`id`) USING BTREE) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;');

		$this->db->query("INSERT INTO `email_template` VALUES (1, 'Application done', '#first_name #last_name');");

		//  tempalte

		$this->db->query('DROP TABLE IF EXISTS `email_template_translate`;');
		$this->db->query('CREATE TABLE `email_template_translate`  (
			`lang` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
			`subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
			`body` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
			`template_id` int(11) NOT NULL,
			PRIMARY KEY (`lang`, `template_id`) USING BTREE
			) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;');

		$this->db->query("INSERT INTO `email_template_translate` VALUES ('en', 'Subject in englsih', '<h3><b>Bonjour</b> #first_name   #last_name </h3><p>Nous vous remercions pour votre candidature que nous examinerons avec le plus grand soin. </p><p>Si celle-ci correspond à nos attentes, nous ne manquerons pas de vous contacter prochainement. </p><p><span style=\"background-color: rgb(231, 214, 222);\">Sans réponse de notre part  veuillez considérer que nous ne pouvons donner une suite favorable à votre candidature.</span></p><p><span style=\"background-color: rgb(231, 214, 222);\"> Nous nous permettrons cependant de revenir vers vous si d’autres opportunités, en adéquation avec votre profil, se présentaient.</span></p><p><span style=\"background-color: rgb(231, 214, 222);\"> Avec nos salutations distinguées,</span></p><p><b> La Direction des Ressources Humaines</b></p>', 1);");
		$this->db->query("INSERT INTO `email_template_translate` VALUES ('fr', 'Subject France', '<h3><b>Bonjour</b> #first_name&nbsp; &nbsp;#last_name&nbsp;</h3><p>Nous vous remercions pour votre candidature que nous examinerons avec le plus grand soin. </p><p>Si celle-ci correspond à nos attentes, nous ne manquerons pas de vous contacter prochainement. </p><p><span style=\"background-color: rgb(231, 214, 222);\">Sans réponse de notre part&nbsp; veuillez considérer que nous ne pouvons donner une suite favorable à votre candidature.</span></p><p><span style=\"background-color: rgb(231, 214, 222);\"> Nous nous permettrons cependant de revenir vers vous si d’autres opportunités, en adéquation avec votre profil, se présentaient.</span></p><p><span style=\"background-color: rgb(231, 214, 222);\"> Avec nos salutations distinguées,</span></p><p><b> La Direction des Ressources Humaines</b></p>', 1);
			");


	}

	public function down()
	{


	}
}