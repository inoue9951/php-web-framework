<div class="section" id="userSection">
    <div class="row">
        <div class="col-md-4">
            <h3>ユーザ情報</h3>
        </div>
        <div class="col-md-8">
            <!--a class="ml-2 float-right btn btn-primary" href="/users/edit/<?= $user->user_id; ?>">編集</a-->
            <?php
            // 管理者のみ表示
            if ($user->roles()->find_one()->role_name == 'superuser') {
            ?>
            <a class="float-right btn btn-primary" href="/users/add">新規作成</a>
            <?php
            }
            ?>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered mt-2">
                <thead>
                    <tr class="text-light bg-primary">
                        <th>ID</th>
                        <th>ユーザ名</th>
                        <th>権限</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-truncate"><?= $user->user_id; ?></td>
                        <td class="text-truncate"><?= $user->name; ?></td>
                        <td class="text-truncate"><?= $user->roles()->find_one()->role_name; ?>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
        // 管理者のみ表示
        if ($user->roles()->find_one()->role_name == 'superuser') {
        ?>
        <div class="col-md-12 mt-3">
            <h3>ユーザ一覧</h3>
            <table class="table table-bordered mt-2">
                <thead>
                    <tr class="text-light bg-primary">
                        <th>ID</th>
                        <th>ユーザ名</th>
                        <th>権限</th>
                        <!--th>編集</th>
                        <th>削除</th-->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $userObj) {
                    ?>
                        <tr>
                            <td class="text-truncate"><?= $userObj->user_id; ?></td>
                            <td class="text-truncate"><?= $userObj->name; ?></td>
                            <td class="text-truncate"><?= $userObj->roles()->find_one()->role_name; ?></td>
                            <!--td><a class="btn btn-primary d-block" href="/users/edit/<?= $userObj->user_id; ?>">編集</a></td>
                            <td><a class="btn btn-danger d-block" href="">削除</a></td-->
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        }
        ?>
    </div>
</div>
