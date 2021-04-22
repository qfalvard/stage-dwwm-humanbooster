# TOUTES LES ROUTES D'ADMINISTRATION 

* ROUTES FILTREES :
  * Adresse :
    * @Route("/admin/adresse")
  * Evaluation :
    * Formateur :
      * Evaluation des stagiaire (name : evaluation_evaluer)
        * @Route("/formateur/evaluations/session/{id_session}/module/{id_module}/evaluer", name="evaluation_evaluer", methods={"GET","POST"})
      * Nouvelle évaluation
        * @Route("/formateur/evaluations/ajouter", name="evaluation_new", methods={"GET","POST"})

* UTILISATEURS :
   * @Route("/admin", name="admin") 
     * panneau d'administration générale (à venir)
   * @Route("admin/utilisateurs", name="utilisateurs_index")
     * liste de tous les utilisateurs
   * @Route("admin/utilisateurs/{id}/edit", name="utilisateurs_edit", methods={"GET","POST"})
     * page d'édition d'un utilisateur
   * @Route("/admin/utilsateurs/ajouter", name="app_register")
     * page de création d'un utilisateur

* TITRES PROFESSIONNELS :
    * Titres Professionnels : 
      * @Route("/admin/titres/ajouter", name="titre_professionnel_new", methods={"GET","POST"})
        page de création d'un titre professionnel
      * @Route("/admin/titres/{id}/editer", name="titre_professionnel_edit", methods={"GET","POST"})
        page d'édition d'un titre professionnel
      * @Route("/admin/titres/{id}/supprimer", name="titre_professionnel_delete", methods={"DELETE"})
        page de suppression d'un titre professionnel
    * CCP : 
      * @Route("/admin/titres/ccp/ajouter", name="c_c_p_new", methods={"GET","POST"})
        page de création d'un CPP
      * @Route("/admin/titres/cpp/{id}/editer", name="c_c_p_edit", methods={"GET","POST"})
        page d'édition d'un CPP
      * @Route("/admin/titres/cpp/{id}/supprimer", name="c_c_p_delete", methods={"DELETE"})
        page de suppression d'un CPP
    * Compétences : 
      * @Route("/admin/titres/competences/ajouter", name="competence_new", methods={"GET","POST"})
        * page de création d'une compétence
      * @Route("/admin/titres/competences/{id}/editer", name="competence_edit", methods={"GET","POST"})
        page d'édition d'une compétence
      * @Route("/admin/titres/competences/{id}/supprimer", name="competence_delete", methods={"DELETE"})
        page de suppression d'une compétence
    * Modules : 
      * @Route("/admin/titres/modules/ajouter", name="module_new", methods={"GET","POST"})
        page de création d'un module
      * @Route("/admin/titres/modules/{id}/editer", name="module_edit", methods={"GET","POST"})
        page d'édition d'un module
      * @Route("/admin/titres/modules/{id}/supprimer", name="module_delete", methods={"DELETE"})
        page de suppression d'un module
    * Objectifs : 
      * @Route("/admin/titres/objectifs/ajouter", name="objectif_new", methods={"GET","POST"})
        page de création d'un objectif
      * @Route("/admin/titres/objectifs/{id}/editer", name="objectif_edit", methods={"GET","POST"})
        page d'édition d'un objectif
      * @Route("/admin/titres/objects/{id}/supprimer", name="objectif_delete", methods={"DELETE"})
        page de suppression d'un objectif

* SESSION DE FORMATION: 
    * @Route("/admin/session") en préfixe
    * @Route("/", name="session_index", methods={"GET"})
      page de la liste des sessions
    * @Route("/ajouter", name="session_new", methods={"GET","POST"})
      page de création d'une session
    * @Route("/{id}/details", name="session_show", methods={"GET"})
      page détaillée d'une session
    * @Route("/{id}/editer", name="session_edit", methods={"GET","POST"})
      page d'édition d'une session
    * @Route("/{id}/supprimer", name="session_delete", methods={"DELETE"})
      page de suppression d'une session

* EVALUATIONS: 
    * @Route("/admin/evaluations/ajouter", name="evaluation_new", methods={"GET","POST"})
      page de creation d'une evaluation
    * @Route("/admin/evaluations/{id}/details", name="evaluation_show", methods={"GET"})
      page de détails d'une évaluation
    * @Route("/admin/evaluations/{id}/editer", name="evaluation_edit", methods={"GET","POST"})
      page d'édition d'une évaluation
    * @Route("/admin/evaluations/{id}/supprimer", name="evaluation_delete", methods={"DELETE"})
      page de suppression d'une évalution

* MAIL: 

    * @Route("/admin/utilisteurs/{id}/nouveau_mail", name="app_generate_new_token", methods={"GET"})
      page permettant l'envoi d'un nouveau mail d'identification


    
# TOUTES LES ROUTES PAR CONTROLLER :


# AdminController.php 

 * @Route("/admin", name="admin")
 * @Route("/admin/utilisateurs", name="utilisateurs_index")
 * @Route("/admin/utilisateurs/{id}/edit", name="utilisateurs_edit", methods={"GET","POST"})

 # CCPController.php

* @Route("/admin/titres/cpp", name="c_c_p_index", methods={"GET"})
* @Route("/admin/titres/ccp/ajouter", name="c_c_p_new", methods={"GET","POST"})
* @Route("/admin/titres/cpp/{id}/details", name="c_c_p_show", methods={"GET"})
* @Route("/admin/titres/cpp/{id}/editer", name="c_c_p_edit", methods={"GET","POST"})
* @Route("/admin/titres/cpp/{id}/supprimer", name="c_c_p_delete", methods={"DELETE"})

# CompetenceController.php

* @Route("/titres/competences", name="competence_index", methods={"GET"})
* @Route("/admin/titres/competences/ajouter", name="competence_new", methods={"GET","POST"})
* @Route("/titres/competences/{id}/details", name="competence_show", methods={"GET"})
* @Route("/admin/titres/competences/{id}/editer", name="competence_edit", methods={"GET","POST"})
* @Route("/admin/titres/competences/{id}/supprimer", name="competence_delete", methods={"DELETE"})

# DashboardController.php

* @Route("/", name="dashboard")

# EvaluationsController.php

* @Route("/evaluations", name="evaluation_index", methods={"GET"})
* @Route("/admin/evaluations/ajouter", name="evaluation_new", methods={"GET","POST"})
* @Route("/admin/evaluations/{id}/details", name="evaluation_show", methods={"GET"})
* @Route("/admin/evaluations/{id}/editer", name="evaluation_edit", methods={"GET","POST"})
* @Route("/admin/evaluations/{id}/supprimer", name="evaluation_delete", methods={"DELETE"})

# LoginController.php

* @Route("/connexion", name="app_login")
* @Route("/deconnexion", name="app_logout")

# ModuleController.php

* @Route("/admin/titres/modules", name="module_index", methods={"GET"})
* @Route("/admin/titres/modules/ajouter", name="module_new", methods={"GET","POST"})
* @Route("/admin/titres/modules/{id}/details", name="module_show", methods={"GET"})
* @Route("/admin/titres/modules/{id}/editer", name="module_edit", methods={"GET","POST"})
* @Route("/admin/titres/modules/{id}/supprimer", name="module_delete", methods={"DELETE"})

# ObjectifsController.php

* @Route("/admin/titres/objectifs", name="objectif_index", methods={"GET"})
* @Route("/admin/titres/objectifs/ajouter", name="objectif_new", methods={"GET","POST"})
* @Route("/admin/titres/objectifs/{id}/details", name="objectif_show", methods={"GET"})
* @Route("/admin/titres/objectifs/{id}/editer", name="objectif_edit", methods={"GET","POST"})
* @Route("/admin/titres/objects/{id}/supprimer", name="objectif_delete", methods={"DELETE"})

# RegistrationController.php

* @Route("/admin/utilsateurs/ajouter", name="app_register")
* @Route("/admin/utilisteurs/{id}/nouveau_mail", name="app_generate_new_token", methods={"GET"})
* @Route("/confirmation_compte/{token}", name="confirm_account")
* @Route("/oubli_mdp", name="app_oubli_mdp")
* @Route("/nouveau_mdp/{token}", name="app_new_mdp")

# SessionController.php

* @Route("/admin/session") en préfixe
* @Route("/", name="session_index", methods={"GET"})
* @Route("/ajouter", name="session_new", methods={"GET","POST"})
* @Route("/{id}/details", name="session_show", methods={"GET"})
* @Route("/{id}/editer", name="session_edit", methods={"GET","POST"})
* @Route("/{id}/supprimer", name="session_delete", methods={"DELETE"})

# TitreProfessionnelController.php

* @Route("/titres", name="titre_professionnel_index", methods={"GET"})
* @Route("/admin/titres/ajouter", name="titre_professionnel_new", methods={"GET","POST"})
* @Route("/titres/{id}/details", name="titre_professionnel_show", methods={"GET"})
* @Route("/admin/titres/{id}/editer", name="titre_professionnel_edit", methods={"GET","POST"})
* @Route("/admin/titres/{id}/supprimer", name="titre_professionnel_delete", methods={"DELETE"})