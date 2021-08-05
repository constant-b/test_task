<?php

/* @var $this yii\web\View */

$this->title = 'File uploader';
?>
<div class="site-index">
    <form id="fileLoaderForm" method="POST">
        <div class="file-upload">
            <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>

            <div class="image-upload-wrap">
                <input class="file-upload-input" multiple type="file" name="files" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/msword, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.openxmlformats-officedocument.presentationml.presentation, application/vnd.ms-powerpoint, application/pdf, image/*">
                <div class="drag-text">
                    <h3>Drag and drop a file or select add Image</h3>
                </div>
            </div>
            <div class="for-clone" style="display: none">
                <div class="file-upload-content">
                    <img class="file-upload-image" src="#" alt="your image"/>
                    <div class="image-title-wrap"></div>
                    <div class="custom-progress-bar" style="width: 100%; height: 20px; background: lightgrey;">
                        <div class="inner" style="background: #00aa00; height: 20px; width: 0"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
