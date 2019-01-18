<?= $this->setLayoutVar('title', 'ユーザ作成'); ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-7">
        <h3 class="text-center">ユーザ登録</h3>
        <hr>
    </div>
    <div class="col-md-6">
        <?php if ($alert) { ?>
            <div class="alert alert-danger" role="alert">
                入力内容を確認してください
            </div>
        <?php } ?>

        <form action="/users/create" method="post">
            <div class="form-group">
                <label for="userId">ユーザID</label>
                <input type="text" class="form-control" name="user[user_id]"
                    value="<?= $user->user_id; ?>" placeholder="user id">
                <small class="form-text text-muted">半角英数字8文字以上(記号不可)</small>
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" class="form-control" name="user[password]"
                    value="<?= $user->password; ?>" placeholder="password">
                <small class="form-text text-muted">半角英数字8文字以上(記号不可)</small>
            </div>

            <div class="form-group">
                <label for="name">ユーザ名</label>
                <input type="text" class="form-control" name="user[name]"
                    value="<?= $user->name; ?>" placehlder="name">
                <small class="form-text text-muted">空白のみの入力は不可</small>
            </div>

            <div class="form-group">
                <label for="role">権限</label>
                <select class="form-control" name="user[roles_id]">
                <?php
                foreach ($roles as $role) {
                    echo '<option value="' . $role->id . '">' . $role->role_name . '</option>';
                }
                ?>
                </select>
                <small class="form-text text-muted">ユーザの権限を選択してください</small>
            </div>

            <div class="form-group">
                <button type="submit" class="form-control btn btn-primary">登録</button>
            </div>
        </form>
    </div>
</div>
