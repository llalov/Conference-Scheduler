<div class="row">
    <?php
    foreach ($this->_viewBag['body']->getLectures() as $lecture) :?>
        <div class="panel panel-info col-md-5 margin-right">
            <div class="panel-body">
                <div class="block">
                    <div class="title"><?= $lecture->getDescription() ?></div>
                </div>
                <div class="block margin-top">
                    <p><b>Speaker </b> <?= $lecture->getSpeaker() ?></p>
                    <p><b>Start</b> <?= date_format(date_create($lecture->getStart()), 'd F Y H:i')?></p>
                    <p><b>End </b> <?= date_format(date_create($lecture->getEnd()), 'd F Y H:i') ?></p>
                    <p><b>Conference</b> <?= $lecture->getConference() ?></p>
                    <p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?= $lecture->getHall() ?></p>
                    <a class="panel panel-danger col-sm-4 btn btn-default text-center"
                       href="/lecture/<?= $lecture->getId() ?>/show/0/3">Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>