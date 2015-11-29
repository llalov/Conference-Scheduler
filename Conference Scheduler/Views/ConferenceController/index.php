<div class="row">
<?php
foreach ($this->_viewBag['body']->getConferences() as $conference) :?>
    <div class="panel panel-default col-md-5 margin-right">
        <div class="panel-body">
            <div class="block">
                <div class="title"><?= $conference->getName() ?></div>
            </div>
            <div class="block margin-top">
                <p><b>Owner </b> <?= $conference->getOwner() ?></p>
                <p><b>From </b> <?= date_format(date_create($conference->getStart()), 'd F Y')?></p>
                <p><b>To </b> <?= date_format(date_create($conference->getEnd()), 'd F Y') ?></p>
                <?php if(!(count($conference->getAdmins()) < 1)) :?>
                <p><b>Administrators </b><?= implode(', ', $conference->getAdmins()) ?></p>
                <?php endif; ?>
                <?php if((count($conference->getAdmins()) < 1)) :?>
                    <p><b>Administrators </b><i>No administrators registered at this point.</i></p>
                <?php endif; ?>
                <p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?= $conference->getVenue() ?></p>
                <a class="panel panel-primary col-sm-4 btn btn-default text-center"
                   href="/conference/<?= $conference->getId() ?>/show/0/3">Details</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>