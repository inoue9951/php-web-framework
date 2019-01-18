<?= $this->setLayoutVar('title', 'マイページ'); ?>
<link rel="stylesheet" type="text/css" href="/css/users/show.css">
<script type="text/javascript" src="/js/users/show.js"></script>
<div class="row mt-5">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <h2>マイページ</h2>
            </div>
            <div class="col-md-9">
                <p class="text-right mt-3 mb-0"><?= $user->name ?>でログインしています</p>
            </div>
        </div>
        <hr class="mt-0">
    </div>
    <div class="col-md-3">
        <div class="list-group">
            <p class="list-group-item active">メニュー</p>
            <button type="button" id="topic" class="menuBtn list-group-item list-group-item-action disabled">Topic & News</button>
            <button type="button" id="conference" class="menuBtn list-group-item list-group-item-action disabled">学会発表</button>
            <button type="button" id="international" class="menuBtn list-group-item list-group-item-action disabled">国際交流</button>
            <button type="button" id="teacher" class="menuBtn list-group-item list-group-item-action disabled">教員情報</button>
            <button type="button" id="user" class="menuBtn list-group-item list-group-item-action">ユーザ情報</button>
        </div>
    </div>
    <div id="contentArea" class="col-md-8 offset-md-1">
        <?php
            require dirname(__FILE__) . '/section/topicSection.php';
            require dirname(__FILE__) . '/section/conferenceSection.php';
            require dirname(__FILE__) . '/section/internationalSection.php';
            require dirname(__FILE__) . '/section/teacherSection.php';
            require dirname(__FILE__) . '/section/userSection.php';
        ?>
    </div>
</div>
