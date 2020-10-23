<?php
include_once ('configuration_base.php') ;

$dbb = new db("root", "","localhost","base_sing_emedical", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
$errors = array();

/* les fonctions de mon projet */

function verification_document($intitule_document)
{
	global $dbb ;
	$getrows = $dbb -> getRows("SELECT * FROM tb_document WHERE intitule_document=?",array($intitule_document));
    return $getrows;	
}


function ajout_document($intitule_document,$code_type,$fichier_document,$description_document,$code_admin,$source_document,$photo_couverture,$etat_document)
{
	try 
	{
		global $dbb;
		$stmt=$dbb->datab->prepare("INSERT INTO tb_document(intitule_document,code_type,fichier_document,description_document,code_admin,source_document,photo_couverture,etat_document) VALUES(:intitule_document,:code_type,:fichier_document,:description_document,:code_admin,:source_document,:photo_couverture,:etat_document)");
		$stmt->bindparam(':intitule_document',$intitule_document,PDO::PARAM_STR);
		$stmt->bindparam(':code_type',$code_type,PDO::PARAM_STR);
		$stmt->bindparam(':fichier_document',$fichier_document,PDO::PARAM_STR);
		$stmt->bindparam(':description_document',$description_document,PDO::PARAM_STR);
		$stmt->bindparam(':code_admin',$code_admin,PDO::PARAM_STR);
		$stmt->bindparam(':source_document',$source_document,PDO::PARAM_STR);
		$stmt->bindparam(':photo_couverture',$photo_couverture,PDO::PARAM_STR);
		$stmt->bindparam(':etat_document',$etat_document,PDO::PARAM_STR);
		
		$etat = $stmt->execute();
	}
	
	catch(PDOException $e)
	{
		throw new Exception($e->getMessage());
	}
}




function afficher_admin()
{
	global $dbb;
	$getrows=$dbb->getRows("SELECT * FROM tb_admin  WHERE etat !=1 ");
    return $getrows;	
}




function afficher_activite($langue)
{
	global $dbb;
	$getrows=$dbb->getRows("SELECT * FROM tb_activite_plan  WHERE etat_activite!=1 AND langue=?",array($langue));
    return $getrows;	
}


function connecter_utilisateur($mail_admin,$mot_de_pass)
{
	global $dbb;
	$getrows=$dbb->getRows("SELECT * FROM tb_admin  WHERE mail_admin=? AND mot_de_pass=?",array($mail_admin,$mot_de_pass));
    return $getrows;	
}

?>