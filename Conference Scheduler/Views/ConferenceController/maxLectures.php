<div class="row">
    <?php
    $lectureIds = array();
    $check = false;
    $checkCollision = false;
    $userLectures = $this->_viewBag['body']->getUserLectures();
    if(($this->_viewBag['body']->getLectures()[0] !== null)) {
    foreach ($this->_viewBag['body']->getLectures() as $lecture) :?>
        <?php
        $start = strtotime($lecture->getStart());
        $end = strtotime($lecture->getEnd());
        ?>
        <?php array_push($lectureIds, $lecture->getId()); ?>
        <div class="panel panel-info col-md-5 margin-right">
            <div class="panel-body">
                <div class="block">
                    <a class="panel panel-danger col-sm-4 btn btn-default text-center"
                       href="/lecture/<?= $lecture->getId() ?>/show/0/3"><?= $lecture->getName() ?></a>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;<i><?= $lecture->getDescription() ?></i></p>
                </div>
                <div class="block margin-top">
                    <p><b>Start:</b> <?= date_format(date_create($lecture->getStart()), 'd F Y H:i')?></p>
                    <p><b>End:</b> <?= date_format(date_create($lecture->getEnd()), 'd F Y H:i') ?></p>
                    <p><b>Speaker:</b> <?= $lecture->getSpeaker() ?></p>
                    <p><b>Conference:</b> <?= $lecture->getConference() ?></p>
                    <p><b>Hall:</b> <?= $lecture->getHall() ?></p>
                    <?php if((int)$lecture->getHallCount() === (int)$lecture->getUsersRegistered()) :?>
                        <?php $check = true; ?>
                    <?php endif; ?>
                    <?php if(!(count($userLectures) < 1)) :?>
                        <?php foreach($userLectures as $userLecture) :?>
                            <?php
                            $endUser = strtotime($userLecture->getEnd());
                            $startUser = strtotime($userLecture->getStart());
                            ?>
                            <?php $checkCollision = !($end <= $startUser || $start >= $endUser);
                            if($checkCollision) {
                                break;
                            }
                            ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>


    <?php if(!$check && !$checkCollision) :?>
    <a class="btn btn-primary col-sm-4 text-center"
       href="/conference/registerForAllLectures/<?= implode(',', $lectureIds) ?>">Visit all lectures</a>
    <?php endif; ?>
    <?php if($check) :?>
        <p class="block alert alert-warning">You cannot mark all of the lectures! There's a lecture, that has reached it's capacity.</p>
    <?php endif; ?>
    <?php if(($checkCollision)) : ?>
        <div class="orange">
            <p class="block alert alert-warning">You'll attend another lecture or one of the given in this period of time.</p>
        </div>
    <?php endif; ?>
    <?php } ?>
    <?php if($this->_viewBag['body']->getLectures()[0] === null) :?>
    <h1 class="alert alert-info text-center">No lectures added for this conference yet.</h1>
    <?php endif; ?>
</div>