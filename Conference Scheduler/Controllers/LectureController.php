<?php
declare(strict_types=1);

namespace Controllers;

use Mvc\Normalizer;
use Mvc\BaseController;
use Models\ViewModels\LectureController\MyViewModel;
use Models\ViewModels\LectureController\MyLectureViewModel;
use Models\ViewModels\LectureController\OpenViewModel;
use Models\ViewModels\LectureController\IndexViewModel;
use Models\ViewModels\LectureController\LectureViewModel;
use Models\BindingModels\EditLectureBindingModel;
use Models\BindingModels\LectureBindingModel;
use Models\ViewModels\LectureController\OpenLectureViewModel;

class LectureController extends BaseController
{
    /**
     * @Route("lecture/unregisterLecture/{lectureId:int}/unregister")
     *
     */
    public function unregisterForLecture() {
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

        $lectureId = $this->input->get(2);
        $this->db->prepare("DELETE
                            FROM user_lectures
                            WHERE user_id = ? AND lecture_id = ?",
            array($userId, $lectureId));
        try {
            $response = $this->db->execute()->fetchAllAssoc();
            if (!$response) {
                throw new \Exception('No lecture matching provided id exist!', 400);
            }
        }
        catch(\Exception $e) {
            $this->redirect('/lecture/my');
        }
    }

    /**
     * @Get
     * @Route("lecture/{lectureId:int}/registerForLecture")
     *
     */

    public function registerForLecture()
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
        $lectureId = $this->input->get(1);

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
        $this->redirect("/lecture/my");
    }
    /**
     * @Get
     * @Route("lecture/my")
     */

    public function my() : MyViewModel
    {
        $loggedUsername =  $this->session->escapedUsername;
        if($loggedUsername === null){
            throw new \Exception;
        }
        $this->db->prepare("SELECT l.id as id, l.name as name, l.description as description, l.start_time as startTime, l.end_time as endTime, u.username as speaker, c.name as conf, h.name as hall
                            From lecture l
                            JOIN user_lectures ul ON ul.lecture_id = l.id
                            JOIN users u ON u.id = ul.user_id
                            JOIN conference c ON c.id = l.conference_id
                            JOIN hall h ON h.id = l.hall_id
                            WHERE u.username = ?
                            ORDER BY l.start_time",
                            array($loggedUsername));
        $response = $this->db->execute()->fetchAllAssoc();
        $lectures = array();
        foreach ($response as $c) {
            $lecture = new MyLectureViewModel($c['id'], $c['name'], $c['description'], $c['startTime'], $c['endTime'], $c['speaker'], $c['conf'], $c['hall']);
            $lectures[] = $lecture;
        }

        $myViewModel = new MyViewModel($lectures);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $myViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.lectures');

        return $myViewModel;
    }
    /**
     * @Get
     * @Route("lecture/open")
     */
    public function open() : OpenViewModel
    {
        $username =  $this->session->escapedUsername;
        if($username === null){
            throw new \Exception;
        }

        $this->db->prepare("SELECT l.id as id, l.name as name, l.description as description, l.start_time as startTime, l.end_time as endTime, u.username as speaker, c.name as conf, h.name as hall
                            From lecture l
                            JOIN user_lectures ul ON ul.lecture_id = l.id
                            JOIN users u ON u.id = ul.user_id
                            JOIN conference c ON c.id = l.conference_id
                            JOIN hall h ON h.id = l.hall_id
                            WHERE u.username = ?
                            ORDER BY l.start_time",
            array($username));
        $response = $this->db->execute()->fetchAllAssoc();
        $usersLectures = array();
        $_SESSION['usersLectures'] = array();
        foreach ($response as $c) {
            $lecture = new MyLectureViewModel($c['id'], $c['name'], $c['description'], $c['startTime'], $c['endTime'], $c['speaker'], $c['conf'], $c['hall']);
            $_SESSION['usersLectures'][] = $lecture;
            $usersLectures[] = $lecture;
        }

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

        $this->db->prepare("SELECT lecture_id
                            FROM user_lectures
                            WHERE user_id = ?",
            array($userId));
        $response = $this->db->execute()->fetchAllAssoc();
        $lectureIds = array();
        foreach ($response as $item) {
            foreach ($item as $id) {
                array_push($lectureIds, $id);
            }
        }
        $_SESSION['response1'] = $lectureIds;
        $this->db->prepare("SELECT
                            s.id as id, s.name as name, s.description as description, s.start_time as startTime, s.end_time as endTime, u.username as speaker, c.name as conf, h.name as hall, h.limit as hallCount
                            FROM lecture s
                            JOIN users u
                            ON u.id = s.speaker_id
                            JOIN conference c
                            ON c.id = s.conference_id
                            JOIN hall h
                            ON h.id = s.hall_id
                            WHERE s.start_time > NOW()
                            ORDER BY c.end_date DESC  ");
        $response = $this->db->execute()->fetchAllAssoc();
        $lectures = array();

        foreach ($response as $c) {
            $this->db->prepare("SELECT COUNT(*) as countAll
                                FROM user_lectures
                                WHERE lecture_id = ?",
                array($c['id']));
            $responseUserLectures = $this->db->execute()->fetchRowAssoc();
            $count = Normalizer::normalize($responseUserLectures['countAll'], 'noescape|int');
            $lecture = new OpenLectureViewModel($c['id'], $c['name'], $c['description'], $c['startTime'], $c['endTime'], $c['speaker'], $c['conf'], $c['hall'], $count, $c['hallCount']);

            $lectures[] = $lecture;
        }

        $openViewModel = new OpenViewModel($lectures, $usersLectures);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $openViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.lectures');

        return $openViewModel;
    }

    public function index() : IndexViewModel
    {
        $this->db->prepare("SELECT
                            s.id as id, s.name as name, s.description as description, s.start_time as startTime, s.end_time as endTime, u.username as speaker, c.name as conf, h.name as hall
                            FROM lecture s
                            JOIN users u
                            ON u.id = s.speaker_id
                            JOIN conference c
                            ON c.id = s.conference_id
                            JOIN hall h
                            ON h.id = s.hall_id
                            ORDER BY c.end_date DESC  ");
        $response = $this->db->execute()->fetchAllAssoc();
        $lectures = array();
        foreach ($response as $c) {
            $lecture = new LectureViewModel($c['id'], $c['name'], $c['description'], $c['startTime'], $c['endTime'], $c['speaker'], $c['conf'], $c['hall']);
            $lectures[] = $lecture;
        }

        $indexViewModel = new IndexViewModel($lectures);

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $indexViewModel);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.lectures');

        return $indexViewModel;
    }

    /**
     * @Route("lecture/addLecture/{id:int}/add")
     */
    public function create()
    {
        $_SESSION['confIdAddLecture'] = $this->input->get(2);
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'addLecture');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.addLectureLayout');
    }

    /**
     * @Route("lecture/add")
     * @Post
     * @param LectureBindingModel $model
     * @throws \Exception
     */
    public function add(LectureBindingModel $model)
    {
        $username = $model->getSpeaker();
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

        $hall = $model->getHall();
        $this->db->prepare("SELECT
                            id, name
                            FROM hall
                            WHERE name LIKE ?",
            array($hall));
        $response = $this->db->execute()->fetchRowAssoc();
        $hallId = Normalizer::normalize($response['id'], 'noescape|int');
        if (!$response) {
            throw new \Exception("No hall $hall exists!", 404);
        }

        $confId = $_SESSION['confIdAddLecture'];

        $this->db->prepare("INSERT
                            INTO lecture
                            (name, description, start_time, end_time, speaker_id, hall_id, conference_id)
                            VALUES (?, ?, ?, ?, ?, ?, ?)",
            array($model->getName(), $model->getDescription(), $model->getStart(), $model->getEnd(), $userId, $hallId, $confId));
        $this->db->execute();

        $this->db->prepare("SELECT
                            id
                            FROM lecture
                            WHERE name = ? AND description = ?",
            array($model->getName(), $model->getDescription()));
        $response = $this->db->execute()->fetchRowAssoc();
        $lectureId = Normalizer::normalize($response['id'], 'noescape|int');

        $this->redirect("/lecture/$lectureId/show");
    }

    /**
     * @Route("lecture/editLecture/{id:int}/edit")
     */
    public function editLecture() {
        $_SESSION['lectureToEdit'] = $this->input->get(2);
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'editLecture');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.editLectureLayout');
    }

    /**
     * @Route("lecture/edit")
     * @Post
     * @param EditLectureBindingModel $model
     * @throws \Exception
     */
    public function edit(EditLectureBindingModel $model)
    {
        $username = $model->getSpeaker();
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

        $hall = $model->getHall();
        $this->db->prepare("SELECT
                            id, name
                            FROM hall
                            WHERE name LIKE ?",
            array($hall));
        $response = $this->db->execute()->fetchRowAssoc();
        $hallId = Normalizer::normalize($response['id'], 'noescape|int');
        if (!$response) {
            throw new \Exception("No hall $hall exists!", 404);
        }

        $conf = $model->getConf();
        $this->db->prepare("SELECT
                            id, name
                            FROM conference
                            WHERE name LIKE ?",
            array($conf));
        $response = $this->db->execute()->fetchRowAssoc();
        $confId = Normalizer::normalize($response['id'], 'noescape|int');
        if (!$response) {
            throw new \Exception("No conference $conf exists!", 404);
        }

        $this->db->prepare("UPDATE lecture
                            SET name = ?, description = ?, start_time = ?, end_time = ?, speaker_id = ?, hall_id = ?, conference_id = ?
                            WHERE id = ?",
            array($model->getName(), $model->getDescription(), $model->getStart(), $model->getEnd(), $userId, $hallId, $confId, $_SESSION['lectureToEdit']));
        $this->db->execute();

        $this->db->prepare("SELECT
                            id
                            FROM lecture
                            WHERE name = ? AND description = ?",
            array($model->getName(), $model->getDescription()));
        $response = $this->db->execute()->fetchRowAssoc();
        $lectureId = Normalizer::normalize($response['id'], 'noescape|int');

        $this->redirect("/lecture/$lectureId/show");
    }

    /**
     * @Get
     * @Route("lecture/removeLecture/{id:int}/remove")
     */
    public function removeLecture() {
        $_SESSION['lectureIdToDelete'] = $this->input->get(2);
        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', 'removeLecture');
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.deleteLecture');
    }

    /**
     * @Route("lecture/deleteLecture")
     */
    public function deleteLecture() {
        $this->db->prepare("DELETE
                            FROM lecture
                            WHERE id = ?",
            array($_SESSION['lectureIdToDelete']));
        try {
            $response = $this->db->execute()->fetchAllAssoc();
            if (!$response) {
                throw new \Exception('No lecture matching provided id exist!', 400);
            }
        }
        catch(\Exception $e) {
            $this->redirect('/lecture/open');
        }
    }

    /**
     * @Get
     * @Route("lecture/{id:int}/show")
     */
    public function lecture() : LectureViewModel
    {
        $id = $this->input->get(1);
        $this->db->prepare("SELECT
                            c.id as id, c.name as name, c.description as description, c.start_time as startTime, c.end_time as endTime, u.username as speaker, h.name as hall, conf.name as conference
                            FROM lecture c
                            JOIN users u
                            ON u.id = c.speaker_id
                            JOIN conference conf
                            ON conf.id = c.conference_id
                            JOIN hall h
                            ON h.id = c.hall_id
                            WHERE c.id = ?",
            array($id));
        $response = $this->db->execute()->fetchRowAssoc();
        if (!$response) {
            throw new \Exception("No lecture with id '$id'!", 404);
        }

        $lecture = new LectureViewModel(
            Normalizer::normalize($response['id'], 'noescape|int'),
            $response['name'],
            $response['description'],
            $response['startTime'],
            $response['endTime'],
            $response['speaker'],
            $response['conference'],
            $response['hall']
        );
        $lectures[] = $lecture;

        $this->view->appendToLayout('header', 'header');
        $this->view->appendToLayout('meta', 'meta');
        $this->view->appendToLayout('body', $lecture);
        $this->view->appendToLayout('footer', 'footer');
        $this->view->displayLayout('Layouts.lecture');

        return $lecture;
    }
}