<?php
declare(strict_types=1);

namespace Controllers;

use Models\BindingModels\AddAdminBindingModel;
use Models\BindingModels\EditConferenceBindingModel;
use Models\ViewModels\ConferenceController\LecturesViewModel;
use Models\ViewModels\ConferenceController\OpenViewModel;
use Mvc\BaseController;
use Mvc\Normalizer;
use Models\BindingModels\ConferenceBindingModel;
use Models\ViewModels\ConferenceController\ConferenceViewModel;
use Models\ViewModels\ConferenceController\IndexViewModel;
use Models\ViewModels\ConferenceController\LectureViewModel;
use Models\ViewModels\ConferenceController\MaxLecturesViewModel;
use Models\ViewModels\ConferenceController\ManageAdminsViewModel;
use Models\ViewModels\ConferenceController\AdminViewModel;

class ConferenceController extends BaseController
{
    /**
     * @Get
     * @Route("conference/open")
     */

    public function open() : OpenViewModel
    {
        $this->db->prepare("SELECT
                            c.id as id, c.name as name, c.description as description, c.start_date as startDate, c.end_date as endDate, u.username as username, v.name as venueName
                            FROM conference c
                            JOIN users u
                            ON u.id = c.owner_id
                            JOIN venue v
                            ON v.id = c.venue_id
                            WHERE c.end_date >= CURDATE()
                            ORDER BY c.end_date DESC  ");
        $response = $this->db->execute()->fetchAllAssoc();
        $conferences = array();
        foreach ($response as $c) {
            $currentConfId = $c['id'];
            $this->db->prepare("SELECT
                            DISTINCT u.username as admin
                            FROM users u
                            JOIN conference_admins ca
                            ON ca.admin_id = u.id
                            WHERE ca.conference_id = $currentConfId
                            ORDER BY u.username");
            $responseAdmins = $this->db->execute()->fetchAllAssoc();

            $admins = array();
            foreach($responseAdmins as $a){
                if(!in_array($a['admin'], $admins)) {
                    $admins[] = $a['admin'];
                }
            }
            $conference = new ConferenceViewModel($c['id'], $c['name'], $c['description'], $c['username'], $c['venueName'], $c['startDate'], $c['endDate'], $admins);
            $conferences[] = $conference;
        }

        $openViewModel = new OpenViewModel($conferences);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $openViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.conferences');

        return $openViewModel;
    }

    public function index() : IndexViewModel
    {
        $this->db->prepare("SELECT
                            c.id as id, c.name as name, c.description as description, c.start_date as startDate, c.end_date as endDate, u.username as username, v.name as venueName
                            FROM conference c
                            JOIN users u
                            ON u.id = c.owner_id
                            JOIN venue v
                            ON v.id = c.venue_id
                            /*WHERE c.start_date < CURDATE() && c.end_date >= CURDATE()*/
                            ORDER BY c.end_date DESC  ");
        $response = $this->db->execute()->fetchAllAssoc();
        $conferences = array();

        foreach ($response as $c) {
            $currentConfId = $c['id'];
            $this->db->prepare("SELECT
                            DISTINCT u.username as admin
                            FROM users u
                            JOIN conference_admins ca
                            ON ca.admin_id = u.id
                            WHERE ca.conference_id = $currentConfId
                            ORDER BY u.username");
            $responseAdmins = $this->db->execute()->fetchAllAssoc();

            $admins = array();
            foreach($responseAdmins as $a){
                if(!in_array($a['admin'], $admins)) {
                    $admins[] = $a['admin'];
                }
            }
            $conference = new ConferenceViewModel($c['id'], $c['name'], $c['description'], $c['username'], $c['venueName'], $c['startDate'], $c['endDate'], $admins);
            $conferences[] = $conference;
        }

        $indexViewModel = new IndexViewModel($conferences);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $indexViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.conferences');

        return $indexViewModel;
    }

    /**
     * @Get
     * @Route("conference/registerForAllLectures/{lectureIds:string}")
     */

    public function registerForLectures()
    {
        $username =  $this->session->escapedUsername;
        $this->db->prepare("SELECT
                            id, username
                            FROM users
                            WHERE username LIKE ?",
            array($username));
        $response = $this->db->execute()->fetchRowAssoc();
        $userId = Normalizer::normalize($response['id'], 'noescape|int');
        if (!$response) {
            $name = $username;
            throw new \Exception("No user $name exists!", 404);
        }

        $lectureIds = array_map('intval', explode(',', $this->input->get(2)));

        foreach ($lectureIds as $lectureId) {
            $this->db->prepare("SELECT user_id, lecture_id
                            FROM user_lectures
                            WHERE user_id = ? AND lecture_id = ?",
                array($userId, $lectureId));
            $response = $this->db->execute()->fetchRowAssoc();
            if($response) {
                $this->redirect('/lecture/my');
            }

            $this->db->prepare("INSERT INTO user_lectures (user_id, lecture_id)
                            VALUES (?,?)",
                array($userId, $lectureId));
            $this->db->execute();
        }

        $this->redirect("/lecture/my");
    }

    /**
     * @Get
     * @Route("conference/maxLectures/{id:int}")
     */
    public function maxLectures() : MaxLecturesViewModel
    {
        $loggedUserUsername =  $this->session->escapedUsername;
        if($loggedUserUsername === null){
            throw new \Exception;
        }
        $this->db->prepare("SELECT l.id as id, l.name as name, l.description as description, l.start_time as startTime, l.end_time as endTime, u.username as speaker, c.name as conf, h.name as hall, h.limit as hallCount
                            From lecture l
                            JOIN user_lectures ul ON ul.lecture_id = l.id
                            JOIN users u ON u.id = ul.user_id
                            JOIN conference c ON c.id = l.conference_id
                            JOIN hall h ON h.id = l.hall_id
                            WHERE u.username = ?
                            ORDER BY l.start_time",
            array($loggedUserUsername));
        $response = $this->db->execute()->fetchAllAssoc();
        $registeredLectures = array();
        foreach ($response as $c) {
            $lecture = new LectureViewModel($c['id'], $c['name'], $c['description'], $c['startTime'], $c['endTime'], $c['speaker'], $c['conf'], $c['hall'], 0, $c['hallCount']);
            $registeredLectures[] = $lecture;
        }

        $confId = $this->input->get(2);
        $this->db->prepare("SELECT
                            s.id as id, s.name as name, s.description as description, s.start_time as startTime, s.end_time as endTime, u.username as speaker, c.name as conf, h.name as hall, h.limit as hallCount
                            FROM lecture s
                            JOIN users u
                            ON u.id = s.speaker_id
                            JOIN conference c
                            ON c.id = s.conference_id
                            JOIN hall h
                            ON h.id = s.hall_id
                            WHERE c.id = $confId AND s.start_time > NOW()
                            ORDER BY s.end_time ASC  ");
        $response = $this->db->execute()->fetchAllAssoc();
        $orderedLectures = array();
        foreach ($response as $c) {
            $this->db->prepare("SELECT COUNT(*) as countAll
                                FROM user_lectures
                                WHERE lecture_id = ?",
                array($c['id']));
            $responseUserLectures = $this->db->execute()->fetchRowAssoc();
            $count = Normalizer::normalize($responseUserLectures['countAll'], 'noescape|int');

            $lecture = new LectureViewModel($c['id'], $c['name'], $c['description'], $c['startTime'], $c['endTime'], $c['speaker'], $c['conf'], $c['hall'], $count,$c['hallCount']);
            $orderedLectures[] = $lecture;
        }
        $myLectures = array();
        $last = array_shift($orderedLectures);
        array_push($myLectures, $last);
        foreach ($orderedLectures as $lecture) {
            if(date_create($lecture->getStart()) >= date_create($last->getEnd())){
                array_push($myLectures, $lecture);
                $last = $lecture;
            }
        }

        $maxLecturesViewModel = new MaxLecturesViewModel($myLectures, $registeredLectures);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $maxLecturesViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.myLectures');

        return $maxLecturesViewModel;
    }

    /**
     * @Get
     * @Route("conference/lectures/{id:int}")
     */
    public function lectures() : LecturesViewModel
    {
        $confId = $this->input->get(2);
        $this->db->prepare("SELECT
                            s.id as id, s.name as name, s.description as description, s.start_time as startTime, s.end_time as endTime, u.username as speaker, c.name as conf, h.name as hall
                            FROM lecture s
                            JOIN users u
                            ON u.id = s.speaker_id
                            JOIN conference c
                            ON c.id = s.conference_id
                            JOIN hall h
                            ON h.id = s.hall_id
                            WHERE c.id = $confId
                            ORDER BY c.end_date DESC  ");
        $response = $this->db->execute()->fetchAllAssoc();
        $lectures = array();
        foreach ($response as $c) {
            $lecture = new LectureViewModel($c['id'], $c['name'], $c['description'], $c['startTime'], $c['endTime'], $c['speaker'], $c['conf'], $c['hall']);
            $lectures[] = $lecture;
        }

        $lecturesViewModel = new LecturesViewModel($lectures);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $lecturesViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.lectures');

        return $lecturesViewModel;
    }

    /**
     * @Get
     * @Route("conference/discardConf/{id:int}/remove")
     */
    public function discardConference() {
        $_SESSION['confIdToDelete'] = $this->input->get(2);
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'deleteConf');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.discardConference');
    }

    /**
     * @Route("conference/discardConf")
     */
    public function discardConf() {
        $this->db->prepare("DELETE
                            FROM conference
                            WHERE id = ?",
            array($_SESSION['confIdToDelete']));
        try {
            $response = $this->db->execute()->fetchAllAssoc();
            if (!$response) {
                throw new \Exception('No conference matching provided id!', 400);
            }
        }
        catch(\Exception $e) {
            $this->redirect('/conference/open');
        }
    }

    /**
     * @Route("conference/editConference/{id:int}/edit")
     */
    public function editConf() {
        $_SESSION['confIdToEdit'] = $this->input->get(2);
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'editConf');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.editConfLayout');
    }

    /**
     * @Route("conference/edit")
     * @Post
     * @param EditConferenceBindingModel $model
     * @throws \Exception
     */
    public function edit(EditConferenceBindingModel $model)
    {
        $this->db->prepare("UPDATE conference
                            SET name = ?, description = ?, start_date = ?, end_date = ?
                            WHERE id = ?",
            array($model->getName(), $model->getDescription(), $model->getStart(), $model->getEnd(), $_SESSION['confIdToEdit']));
        $this->db->execute();

        $this->db->prepare("SELECT
                            id
                            FROM conference
                            WHERE name = ? AND description = ?",
            array($model->getName(), $model->getDescription()));
        $response = $this->db->execute()->fetchRowAssoc();
        $conferenceId = Normalizer::normalize($response['id'], 'noescape|int');

        $this->redirect("/conference/$conferenceId/show");
    }

    /**
     * @Route("conference/create")
     */
    public function create()
    {
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'create');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.createConference');
    }

    /**
     * @Route("conference/add")
     * @Post
     * @param ConferenceBindingModel $model
     * @throws \Exception
     */
    public function add(ConferenceBindingModel $model)
    {
        $username = $this->session->escapedUsername;
        $this->db->prepare("SELECT
                            id, username
                            FROM users
                            WHERE username LIKE ?",
            array($username));
        $response = $this->db->execute()->fetchRowAssoc();
        $userId = Normalizer::normalize($response['id'], 'noescape|int');
        if (!$response) {
            $name = $username;
            throw new \Exception("No user $name exists!", 404);
        }

        $this->db->prepare("SELECT
                            id, name
                            FROM venue
                            WHERE name LIKE ?",
            array($model->getVenue()));
        $responseVenue = $this->db->execute()->fetchRowAssoc();
        $venueId = Normalizer::normalize($responseVenue['id'], 'noescape|int');
        $startDate = $model->getStart();
        $endDate = $model->getEnd();

        if (!$response) {
            $name = $model->getVenue();
            throw new \Exception("No venue $name exists!", 404);
        }

        $this->db->prepare("INSERT
                            INTO conference
                            (name, description, owner_id, venue_id, start_date, end_date)
                            VALUES (?, ?, ?, ?, ?, ?)",
            array($model->getName(), $model->getDescription(), $userId, $venueId, $startDate, $endDate));
        $this->db->execute();

        $this->db->prepare("SELECT
                            id
                            FROM conference
                            WHERE name = ? AND description = ?",
            array($model->getName(), $model->getDescription()));
        $response = $this->db->execute()->fetchRowAssoc();
        $conferenceId = Normalizer::normalize($response['id'], 'noescape|int');

        $this->redirect("/conference/$conferenceId/show");
    }

    /**
     * @Get
     * @Route("conference/{id:int}/show")
     */
    public function conference() : ConferenceViewModel
    {
        $id = $this->input->get(1);
        $this->db->prepare("SELECT
                            c.id as id, c.name as name, c.description as description, c.start_date as startDate, c.end_date as endDate, u.username as username, v.name as venueName
                            FROM conference c
                            JOIN users u
                            ON u.id = c.owner_id
                            JOIN venue v
                            ON v.id = c.venue_id
                            WHERE c.id = ?",
            array($id));
        $response = $this->db->execute()->fetchRowAssoc();
        if (!$response) {
            throw new \Exception("No conference with id '$id'!", 404);
        }


        $this->db->prepare("SELECT
                        DISTINCT u.username as admin
                        FROM users u
                        JOIN conference_admins ca
                        ON ca.admin_id = u.id
                        WHERE ca.conference_id = $id
                        ORDER BY u.username");
        $responseAdmins = $this->db->execute()->fetchAllAssoc();

        $admins = array();
        foreach ($responseAdmins as $a) {
            if (!in_array($a['admin'], $admins)) {
                $admins[] = $a['admin'];
            }
        }

        $conference = new ConferenceViewModel(
            Normalizer::normalize($response['id'], 'noescape|int'),
            $response['name'],
            $response['description'],
            $response['username'],
            $response['venueName'],
            $response['startDate'],
            $response['endDate'],
            $admins
        );
        $conferences[] = $conference;

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $conference);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.conference');

        return $conference;
    }

    /**
     * @Route("conference/manageAdmins/{id:int}")
     * @Get
     */
    public function manageAdmins() : ManageAdminsViewModel {
        $confId = $this->input->get(2);
        $this->db->prepare("SELECT
                                u.id, u.username
                            FROM users u
                            JOIN conference_admins ca
                            ON ca.admin_id = u.id
                            WHERE ca.conference_id = $confId");

        $response = $this->db->execute()->fetchAllAssoc();
        $confAdmins = array();
        foreach ($response as $user) {
            $confAdmin = new AdminViewModel($user['id'], $user['username']);
            $confAdmins[] = $confAdmin;
        }

        $manageAdmins = new ManageAdminsViewModel($confAdmins, $confId);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $manageAdmins);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.confAdmins');

        return $manageAdmins;
    }

    /**
     * @Route("conference/manageAdmins/conference/{id:int}/add")
     */
    public function addAdminView() {
        $_SESSION['confIdAddAdmin'] = $this->input->get(3);
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'addAdmin');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.addAdmin');
    }

    /**
     * @Post
     * @param AddAdminBindingModel $model
     * @Route("conference/addAdmin/{id:int}")
     */
    public function addAdmin(AddAdminBindingModel $model) {
        $confId = $this->input->get(2);
        $username = $model->getName();
        $this->db->prepare("SELECT u.id as id
                            FROM users u
                            WHERE u.username = ?",
            array($username));
        $response = $this->db->execute()->fetchRowAssoc();
        $userId = Normalizer::normalize($response['id'], 'noescape|int');

        $this->db->prepare("INSERT INTO conference_admins (conference_id, admin_id)
                            VALUES (?, ?)",
            array($confId, $userId));
        $this->db->execute();
        $this->redirect("/conference/manageAdmins/$confId");
    }

    /**
     * @Route("conference/manageAdmins/conference/{id:int}/deleteAdmin/{id:int}")
     */
    public function deleteAdmin() {
        $confId = $this->input->get(3);
        $userId = $this->input->get(5);
        $this->db->prepare("DELETE
                            FROM conference_admins
                            WHERE conference_id = $confId AND admin_id = $userId");
        try {
            $response = $this->db->execute()->fetchAllAssoc();
            if (!$response) {
                throw new \Exception('No user matching provided username exist!', 400);
            }
        }
        catch(\Exception $e) {
            $this->redirect("/conference/manageAdmins/$confId");
        }
    }
}