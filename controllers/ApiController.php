<?php


namespace app\controllers;


use app\models\SafeUploadedFile;

class ApiController extends \yii\web\Controller
{
    public function actionLoadFiles()
    {
        $success = true;

        foreach ($_FILES as $key => $file) {
            $file = SafeUploadedFile::getInstanceByName($key);

            if (!$file->save()) $success = false;
        }

        return $this->asJson([
            'success' => $success
        ]);
    }

}