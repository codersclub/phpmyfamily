<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2004  Simon E Booth (simon.booth@giric.com)

	//This program is free software; you can redistribute it and/or
	//modify it under the terms of the GNU General Public License
	//as published by the Free Software Foundation; either version 2
	//of the License, or (at your option) any later version.

	//This program is distributed in the hope that it will be useful,
	//but WITHOUT ANY WARRANTY; without even the implied warranty of
	//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	//GNU General Public License for more details.

	//You should have received a copy of the GNU General Public License
	//along with this program; if not, write to the Free Software
	//Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
	
	// Translation by Patrice Levesque

//=====================================================================================================================

//=====================================================================================================================
//  global definitions
//=====================================================================================================================

	$charset			= "ISO-8859-1";
	$clang				= "fr";
	$dir				= "ltr";
	$datefmt 			= "'%d/%m/%Y'";
	// flags are from http://flags.sourceforge.net
	// I can't find a copyrigh to credit
	// but I'm sure somebody has it
	$flag				= "images/fr.gif";

//=====================================================================================================================
// some date stuff
// This is really out of place, but $restictdate is defined in config.inc.php and $datefmt here.
// Neither should be moved to the other == catch 22
// if anybody can think of a better way to set nulldate and dispdate - let me know!
//=====================================================================================================================
	$dquery = "SELECT DATE_FORMAT('0000-00-00', ".$datefmt." ) , DATE_FORMAT( '".$restrictdate."', ".$datefmt." )";
	$dresult = mysql_query($dquery) or die("OOOOOppppps");
	while ($row = mysql_fetch_array($dresult)) {
		$nulldate = $row[0];
		$dispdate = $row[1];
	}
	mysql_free_result($dresult);

//=====================================================================================================================
// strings for translation
//=====================================================================================================================

	$strOnFile			= "individus r�pertori�s";
	$strSelect			= "Choisir un individu";
	$strUnknown			= "inconnu";
	$strLoggedIn		= "Vous �tes authentif� sous ";
	$strAdmin			= "admin";
	$strLoggedOut		= "Vous n'�tes pas authentifi�: ";
	$strYes				= "Oui";
	$strNo				= "Non";
	$strSubmit			= "Soumettre";
	$strReset			= "R�initialiser";
	$strLogout			= "sortie";
	$strHome			= "d�part";
	$strEdit			= "modifier";
	$strAdd				= "ajouter";
	$strDetails			= "D�tails";
	$strBorn			= "N�(e)";
	$strCertified		= "Certifi�";
	$strFather			= "P�re";
	$strRestricted		= "Priv�";
	$strDied			= "D�c�d�(e)";
	$strMother			= "M�re";
	$strChildren		= "Enfants";
	$strSiblings		= "Fr�res et soeurs";
	$strMarried			= "Mari�(e)";
	$strInsert			= "ins�rer";
	$strNewMarriage		= "nouveau mariage";
	$strNotes			= "Notes";
	$strGallery			= "Galerie d'images";
	$strUpload			= "t�l�verser";
	$strNewImage		= "nouvelle image";
	$strNoImages		= "Aucune image disponible";
	$strCensusDetails	= "D�tails de recensement";
	$strNewCensus		= "Nouveau recensement";
	$strNoInfo			= "Aucune information disponible";
	$strYear			= "Ann�e";
	$strAddress			= "Adresse";
	$strCondition		= "Condition";
	$strOf				= "de";
	$strAge				= "�ge";
	$strProfession		= "Profession";
	$strBirthPlace		= "Lieu de naissance";
	$strDocTrans		= "Transcriptions de documents";
	$strNewTrans		= "nouvelle transcription";
	$strTitle			= "Titre";
	$strDesc			= "Description";
	$strDate			= "Date";
	$strRightClick		= "Cliquer sur le titre du document pour t�l�charger (Cliquer du bouton de droite &#38; Enregistrer sous... avec in Internet Explorer)";
	$strStats			= "Statistiques du site";
	$strArea			= "Zone";
	$strNo				= "Nombre";
	$strCensusRecs		= "Recensements";
	$strImages			= "Images";
	$strLast20			= "20 derniers individus mis � jour";
	$strPerson			= "Individu";
	$strUpdated			= "Mis � jour";
	$strEditing			= "�dition";
	$strName			= "Nom";
	$strDOB				= "Date de naissance";
	$strDateFmt			= "Utiliser le format AAAA-MM-JJ";
	$strDOD				= "Date de d�c�s";
	$strCauseDeath		= "Cause du d�c�s";
	$strMarriage		= "Mariage";
	$strSpouse			= "�poux(se)";
	$strDOM				= "Date du mariage";
	$strMarriagePlace	= "Lieu du mariage";
	$strCensus			= "Recensement";
	$strSchedule 		= "Horaire";
	$strDragons			= "Des dragons!";
	$strGender			= "Sexe";
	$strMale			= "Male";
	$strFemale			= "Femelle";
	$strNewPassword		= "Nouveau mot de passe";
	$strOldPassword		= "Ancien mot de passe";
	$strReOldPassword	= "R�inscrire l'ancien mot de passe";
	$strChange			= "Changer";
	$strPwdChange		= "Changement de mot de passe";
	$strPwdChangeMsg	= "Remplir ce formulaire pour changer de mot de passe.";
	$strLogin			= "Authentification";
	$strUsername		= "Nom d'utilisateur";
	$strPassword		= "Mot de passe";
	$strRePassword		= "R�inscrire le mot de passe";
	$strForbidden		= "Interdit";
	$strForbiddenMsg	= "Vous n'avez pas de permissions suffisantes pour voir la page demand�e.  Cliquer <a href=\"index.php\">ici</a> pour poursuivre.";
	$strDelete			= "effacer";
	$strFUpload			= "Fichier � t�l�verser";
	$strFTitle			= "Titre du fichier";
	$strFDesc			= "Description du fichier";
	$strFDate			= "Date du fichier";
	$strIUpload			= "Image � t�l�verser";
	$strISize			= "JPEG seulement (taille max 1MB)";
	$strITitle			= "Titre de l'image";
	$strIDesc			= "Description de l'image";
	$strIDate			= "Date de l'image";
	$strOn				= "le";
	$strAt				= "�";
	$strAdminFuncs		= "Fonctions d'administrateur";
	$strAction			= "action";
	$strUserCreate		= "Cr�er un nouvel usager";
	$strCreate			= "Cr�er";
	$strBack			= "Retour";
	$strToHome			= "au d�part.";
	$strNewMsg			= "Assurez-vous que la personne n'existe pas d�j� dans la base de donn�es!";
	$strIndex			= "Tous les d�tails pour les personnes n�es apr�s $dispdate sont priv�es afin de prot�ger les identit�s.  Si vous �tes enregistr�(e) vous pourrez voir et modifier les enregistrements.  Si vous croyez que votre arbre g�n�alogique correspond � celui-ci, <a href=\"$1\">laissez-moi savoir</a>.";
	$strNote			= "Note";
	$strFooter			= "Communiquez avec le <a href=\"$1\">webmestre</a> s'il y a probl�me.";
	$strPowered			= "Propuls� par";
	$strPedigreeOf		= "Arbre de";
	$strBirths			= "Naissances";
	$strAnniversary		= "Anniversaire";
	$strUpcoming		= "Anniversaires � venir";
	$strMarriages		= "Mariages";
	$strDeaths			= "D�c�s";
	$strConfirmDelete	= "\"\\u00cates-vous certain de vouloir effacer\\n'\" + year + \"' \" + section +\"?\"";
	$strTranscript		= "transcription";
	$strImage			= "image";
	$strDoubleDelete	= "\"\\u00cates-vous vraiment certain de vouloir EFFACER cet individu\\nCe processus est IRR\\u00c9VERSIBLE!!\"";
	$strBirthCert		= "Naissance certifi�e?";
	$strDeathCert		= "D�c�s certifi�?";
	$strMarriageCert	= "Mariage certifi�?";
	$strNewPerson		= "un nouvel individu";
	$strPedigree		= "arbre";
	$strToDetails		= "d�tails";
	$strSurnameIndex	= "Index des noms de famille";
	$strTracking		= "Suivi";
	$strTrack			= "suivre";
	$strThisPerson		= "cet individu";
	$strTrackSpeel		= "Utiliser le formulaire plus bas pour suivre cet individu.  Vous recevrez un courriel � chaque fois que la fiche sera mise � jour";
	$strEmail			= "Courriel";
	$strSubscribe		= "s'inscrire";
	$strUnSubscribe		= "se d�sincrire";
	$strMonAccept		= "Votre requ�te de suivi a �t� accept�e.<br />Vous recevrez un courriel � chaque mise � jour de la fiche de cet individu.<br />";
	$strMonCease		= "Votre requ�te de cesser le suivi a �t� accept�e.<br />Vous ne recevrez plus de courriels.<br />";
    $strMonError		= "Un probl�me avec votre requ�te de suivi est survenu.<br />Contacter l'administrateur du site pour assistance";
	$strMonRequest		= "Votre reqwu�te de suivi pour cet individu est en traitement.<br />Un courriel a �t� envoy� � votre adresse et vous devrez suivre les instructions qui y sont inscrites.<br />";
    $strCeaseRequest	= "Votre req�te de cessation de suivi cet individu est en traitement.<br />Un courriel a �t� envoy� � votre adresse et vous devrez suivre les instructions qui y sont inscrites.<br />";
	$strAlreadyMon		= "Vous suivez d�j� cet individu.<br />Aucune action entreprise.<br />";
	$strNotMon			= "Vous ne suivez pas encore cet individu.<br />Aucune action entreprise.<br />";
	$strRandomImage		= "Image au hasard";
	$strMailTo			= "Envoyer un message";
	$strSubject			= "Sujet";
	$strNoEmail			= "\"Vous devez fournir une adresse de courriel\"";
	$strEmailSent		= "Votre courriel a �t� envoy� au webmestre.";
	$strExecute			= "Temps d'ex�cution";
	$strSeconds			= "secondes";

//=====================================================================================================================
//  email definitions
//=====================================================================================================================

	$eTrackSubject		= "[phpmyfamily] $1 a �t� mis � jour";
	$eTrackBodyTop		= "Ceci est un message automatique.  $1 � $2 a �t� alter�.  Cliquer ci-dessous pour voir la fiche modifi�e\n\n";
	$eTrackBodyBottom	= "Ce message a �t� envoy� car vous avez demand� le suivi pour cet individu.  Cliquez plus bas pour vous retirer de ce suivi.\n\n";
	$eSubSubject		= "[phpmyfamily] requ�te de suivi";
	$eSubBody			= "Ceci est un message automatique.  Vous recevez ce message parce que vous avez choisi de suivre la fichie de $1.  Pour confirmer cette inscription, cliquez le lien plus bas d'ici les prochaines 24 heures.\n\n";
	$eUnSubBody			= "Ceci est un message automatique.  Vous recevez ce message parce que vous avez choisi de ne plus suivre la fichie de $1.  Pour confirmer cette d�sinscription, cliquez le lien plus bas d'ici les prochaines 24 heures.\n\n";

//=====================================================================================================================
//  error definitions
//=====================================================================================================================

	$err_listpeeps		= "Erreur lors du listage des individus dans la base de donn�es";
	$err_image_insert	= "Erreur lors de l'insertion de l'image dans la base de donn�es";
	$err_list_enums		= "Erreur lors de l'�num�ration des types sur la colonne";
	$err_list_census	= "Erreur lors du listage des recensements disponibles";
	$err_keywords		= "Erreur lors de la r�cup�ration dans la base de donn�es des noms pour mots-clefs";
	$err_changed		= "Erreur lors de la r�cup�ration de la liste des derniers individus modifi�s";
	$err_father			= "Erreur lors de la r�cup�ration des d�tails du p�re";
	$err_mother			= "Erreur lors de la r�cup�ration des d�tails de la m�re";
	$err_spouse			= "Erreur lors de la r�cup�ration des d�tails de l'�poux";
	$err_marriage		= "Erreur lors de la r�cup�ration des d�tails du mariage";
	$err_census_ret		= "Erreur lors de la r�cup�ration des d�tails du recensement";
	$err_children		= "Erreur lors de la r�cup�ration des d�tails des enfants";
	$err_siblings		= "Erreur lors de la r�cup�ration des d�tails des fr�res et soeurs";
	$err_transcript		= "Erreur lors de l'insertion de transcription dans la base de donn�es";
	$err_trans			= "Erreur lors de la r�cup�ration des transcriptions";
	$err_detail			= "Erreur lors de l'insertion des d�tails de l'individu dans la base de donn�es";
	$err_census			= "Erreur lors de l'insertion du recensement dans la base de donn�es";
	$err_logon			= "Erreur d'authentification";
	$err_change			= "Erreur lors du changement de mot de passe";
	$err_pwd_incorrect	= "Erreur - Mot de passe incorrect";
	$err_pwd_match		= "Erreur - Les deux mots de passe ne concordent pas";
	$err_update			= "Erreur lors de la mise � jour du nouveau mot de passe";
	$err_pwd_success	= "Mot de passe mis � jour avec succ�s";
	$err_image			= "Erreur lors de la r�cup�ration de l'image dans la base de donn�es";
	$err_images			= "Erreur lors de la r�cup�ration des images dans la base de donn�es";
	$err_person			= "Erreur lors de la r�cup�ration de l'invididu dans la base de donn�es";
	$err_new_user		= "Erreur lors de l'insertion du nouvel usager dans la base de donn�es";
	$err_user_exist		= "Erreur - l'usager existe d�j�";
	$err_pwd			= "Erreur lors de la r�cup�ration du mot de passe";
	$err_delete_user	= "Erreur lors de l'effacement de l'usager";
	$err_users			= "Erreur lors de la r�cup�ration des usagers dans la base de donn�es";
	$err_census_delete	= "Erreur lors de l'effacement du recensement";
	$err_marriage_delete= "Erreur lors de l'effacement du mariage";
	$err_trans_delete	= "Erreur lors de l'effacement de la transcription";
	$err_person_delete	= "Erreur lors de l'effacement de l'individu";
	$err_trans_file		= "Erreur lors de l'effacement du fichier de transcription";
	$err_image_file		= "Erreur lors de l'effacement du fichier image";
	$err_child_update	= "Erreur lors de la mise � jour des fiches des enfants";
	$err_person_update	= "Erreur lors de la mise � jour des d�tails d'individus";
	$err_marriage_insert= "Erreur lors de l'insertion du mariage dans la base de donn�es";

	// eof
?>
