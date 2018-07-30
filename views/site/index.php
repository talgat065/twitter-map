<?php
$this->title = 'Twitter Map';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-8">
                <div id="map" style="width: 700px; height: 500px"></div>
            </div>
            <div class="col-md-4">
                <?php if (! Yii::$app->getUser()->isGuest): ?>
                    <button id="update" class="btn btn-success">update</button>
                <?php else: ?>
                    <p><a href="/user/security/login">Sign in</a> via Twitter to get new tweets</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="js/map.js"></script>
