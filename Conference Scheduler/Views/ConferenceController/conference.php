<div class="row">
    <?php
    $conference = $this->_viewBag['body'];
    $confId = $conference->getId();
    if(true) :?>
        <div class="panel panel-default col-md-12 margin-left2">
            <div class="panel-body">
                <div class="block">
                    <div class="title"><?= $conference->getName() ?></div>
                </div>
                <div class="block margin-top">
                    <div>
                        <p><i><?= $conference->getDescription() ?></i></p>
                    </div>
                    <p><b>Owner</b> <?= $conference->getOwner() ?></p>
                    <p><b>From </b> <?= date_format(date_create($conference->getStart()), 'd F Y')?></p>
                    <p><b>To </b> <?= date_format(date_create($conference->getEnd()), 'd F Y') ?></p>
                    <?php if(!(count($conference->getAdmins()) < 1)) :?>
                        <p><b>Administrators: </b><?= implode(', ', $conference->getAdmins()) ?></p>
                    <?php endif; ?>
                    <?php if((count($conference->getAdmins()) < 1)) :?>
                        <p><i>No administrators registered at this point.</i></p>
                    <?php endif; ?>
                    <p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span><?= $conference->getVenue() ?></p>
                </div>
            </div>
            <?php if((\Mvc\App::getInstance()->isLogged())) :?>
                <?php \Mvc\FormViewHelper::init()
                    ->initLink()->setAttribute('href', "/conference/lectures/$confId")->setAttribute('class', 'margin-left float-left btn btn-info')->setValue('Lectures')->create()
                    ->render(); ?>
                <?php \Mvc\FormViewHelper::init()
                    ->initLink()->setAttribute('href', "/conference/maxLectures/$confId")->setAttribute('class', 'margin-left float-left btn btn-info')->setValue('Max Lectures')->create()
                    ->render(); ?>
            <?php endif; ?>
            <br/>
            <br/>
            <?php if(($conference->getOwner() === $_SESSION['username'])) :?>
                <a class="margin-right2 float-left btn btn-success col-sm-2 text-center"
                   href="/lecture/addLecture/<?= $conference->getId() ?>/add">Add lecture</a>
                <a class="margin-right2 float-left btn btn-danger col-lg-3 text-center"
                   href="/conference/manageAdmins/<?= $conference->getId() ?>">Manage Admins</a>
            <?php endif; ?>
            <?php if (in_array($_SESSION['username'], $conference->getAdmins()) || (\Mvc\App::getInstance()->isLogged() && ($conference->getOwner() === $_SESSION['username'])) || ($_SESSION['role'] == 'site administrator')/* || $_SESSION['role'] === 'conference administrator'*/) : ?>
                <a class="margin-right2 float-left btn btn-warning col-sm-2 text-center"
                   href="/conference/editConference/<?= $conference->getId() ?>/edit">Edit</a>
                <?php if(($conference->getOwner() === $_SESSION['username']) || $_SESSION['role'] == 'site administrator') : ?>
                    <a class="margin-right2 float-left btn btn-danger col-sm-2 text-center"
                       href="/conference/discardConf/<?= $conference->getId() ?>/remove">Discard</a>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

