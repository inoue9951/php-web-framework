<?= $this->setLayoutVar('title', 'ログイン'); ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-7">
        <h3 class="text-center">ログイン</h3>
        <hr>
    </div>
    <div class="col-md-6">
        <?php if ($alert) { ?>
            <div class="alert alert-danger" role="alert">
                入力内容を確認してください
            </div>
        <?php } ?>

        <form action="/login/auth" method="post">
            <div class="form-group">
                <label for="userId">ユーザID</label>
                <input type="text" class="form-control" name="login[user_id]" placeholder="user id">
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" class="form-control" name="login[password]" placeholder="password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary form-control">ログイン</button>
            </div>
        </form>
    </div>
</div>

