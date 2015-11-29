<div class="row">
    <?php
    $lecture = $this->_viewBag['body'];
    if(true) :?>
        <div class="panel panel-default col-md-12 margin-left2">
            <div class="panel-body">
                <?php if (\Mvc\App::getInstance()->isLogged() && $_SESSION['role'] == 'site administrator') : ?>
                    <a class="margin-right float-right panel panel-danger col-sm-1 btn btn-default text-center"
                       href="/lecture/editLecture/<?= $lecture->getId() ?>/edit">Edit lecture</a>
                    <?php if($_SESSION['role'] == 'site administrator') : ?>
                        <a class="margin-right float-right panel panel-danger col-sm-1 btn btn-default text-center"
                           href="/lecture/removeLecture/<?= $lecture->getId() ?>/remove">Remove</a>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="block">
                    <div class="title"><?= $lecture->getName() ?></div>
                </div>
                <div class="block margin-top">
                    <div>
                        <p><i><?= $lecture->getDescription() ?></i></p>
                    </div>
                    <p><b>Speaker </b> <?= $lecture->getSpeaker() ?></p>
                    <p><b>Start </b> <?= date_format(date_create($lecture->getStart()), 'd F Y H:i')?></p>
                    <p><b>End </b> <?= date_format(date_create($lecture->getEnd()), 'd F Y H:i') ?></p>
                    <p><b>Conference </b> <?= $lecture->getConference() ?></p>
                    <p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?= $lecture->getHall() ?></p>

                </div>
            </div>
        </div>
    <?php endif; ?>
    ?>
</div>