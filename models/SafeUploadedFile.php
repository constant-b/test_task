<?php


namespace app\models;


use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class SafeUploadedFile extends UploadedFile
{
    const ALLOWED_EXTENSIONS = ["pdf", "bmp", "jpeg", "jpg", "gif", "png", "doc", "docx", "pptx", "ppt", "xls", "xlsx"];

    private $_tempResource;

    public function __construct($config = [])
    {
        $this->_tempResource = ArrayHelper::getValue($config, 'tempResource');

        parent::__construct($config);
    }

    private function checkExtension(): bool
    {
        return in_array($this->getExtension(), self::ALLOWED_EXTENSIONS);
    }

    public function save(): bool
    {
        if ($this->hasError && $this->checkExtension()) {
            return false;
        }

        $targetPath = Yii::getAlias("@app/web/uploads/" . date("Y") . "/" . date("m"));

        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $targetFileName = $targetPath . "/" . $this->generateRandomName();

        if (is_resource($this->_tempResource)) {
            return @fclose($this->_tempResource);
        }

        return move_uploaded_file($this->tempName, $targetFileName);
    }

    private function generateRandomName(): string
    {
        return md5(microtime() . rand(0, 9000)) . "." . $this->getExtension();
    }
}