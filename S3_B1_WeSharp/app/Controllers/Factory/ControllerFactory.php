<?php
declare(strict_types=1);

namespace App\Controllers\Factory;

use App\Controllers\AdminController;
use App\Controllers\CoursController;
use App\Controllers\QcmController;
use App\Controllers\LoginController;

use App\DAO\InterfacesDAO\ICoursDAO;
use App\DAO\InterfacesDAO\IQcmDAO;
use App\DAO\InterfacesDAO\IMatieresDAO;
use App\DAO\InterfacesDAO\IUserCompteDAO;
use App\DAO\InterfacesDAO\IEtudierCoursDAO; 

/**
 * Represents a factory for the controllers
 */
class ControllerFactory
{
    /**
     * Builds the correct controller and action based on the requested page.
     *
     * @return array [controllerInstance, methodName] The instance of the controller needed and the name of the method that needs to be executed
     */
    public static function create(string $page, ICoursDAO $coursDao, IQcmDAO $qcmDao, IMatieresDAO $matieresDao, IUserCompteDAO $userCompteDao, IEtudierCoursDAO $etudierCoursDAO): array
    {
        $res = [null, null];
        
        switch ($page) {

            // Homepage
            case 'accueil': break;

            // Login page
            case 'login': $res = [new LoginController($userCompteDao), 'login']; break;

            // Logout
            case 'logout': $res = [new LoginController($userCompteDao), 'logout']; break;

            // Administrator page
            case 'admin': $res = [new AdminController($coursDao, $qcmDao, $matieresDao, $userCompteDao), 'adminPage']; break;

            // List of courses
            case 'cours': $res = [new CoursController($coursDao, $matieresDao, $etudierCoursDAO), 'afficherListeCoursFiltres']; break;

            // Displays a course
            case 'cours_lecture': $res = [new CoursController($coursDao, $matieresDao, $etudierCoursDAO), 'afficherCours']; break;

            // List of qcms
            case 'qcm': $res = [new QcmController($qcmDao, $matieresDao), 'afficherListeQcmFiltres']; break;

            // Starts a qcm
            case 'qcm_start': $res = [new QcmController($qcmDao, $matieresDao), 'start']; break;

            // Displays a question of the qcm
            case 'qcm_questions': $res = [new QcmController($qcmDao, $matieresDao), 'question']; break;

            // Displays the results of the qcm
            case 'qcm_result': $res = [new QcmController($qcmDao, $matieresDao), 'result']; break;

            // Default
            default: break;
        }

        return $res;
    }
}
