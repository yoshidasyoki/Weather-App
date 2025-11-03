<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <link rel="stylesheet" href="css/vendor/sanitize.css">
    <link rel="stylesheet" href="css/errorPage.css">
</head>

<body>
    <h1><?= htmlspecialchars($title) ?></h1>
    <p>エラー発生により処理を中断しました。</p>

    <?php if (!empty($message)) : ?>
        <div class="message">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

        <a href="/" class="toHome">トップページに戻る</a>
</body>

</html>
