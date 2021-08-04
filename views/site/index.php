<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'File uploader';
?>
<div class="site-index">
    <form method="POST">
        <input multiple type="file" name="files" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/msword, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.openxmlformats-officedocument.presentationml.presentation, application/vnd.ms-powerpoint, application/pdf, image/*">
    </form>
</div>
