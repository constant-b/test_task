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
     *
     * @return Response
     * @throws HttpException Throws 400 error if $_FILES is empty
     */
    public function actionLoadFiles(): Response
    {
        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $file) {
                $file = SafeUploadedFile::getInstanceByName($key);

                return $this->asJson([
                    'success' => $file->save(false)
                ]);
            }
        }

        throw new HttpException(400);
    }

}