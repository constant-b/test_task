<?php

namespace app\controllers;

use yii\web\Response;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\SafeUploadedFile;

class ApiController extends Controller
{
    /**
     * The method saves the files from $_FILES array.
     * Throws 400 error if $_FILES array is empty
     *
     * @return Response
     * @throws HttpException
     */
    public function actionLoadFiles(): Response
    {
        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $file) {
                $file = SafeUploadedFile::getInstanceByName($key);

                return $this->asJson([
                    'success' => $file->save()
                ]);
            }
        }

        throw new HttpException(400);
    }

}