<?php


namespace app\models;


use Yii;
use yii\web\UploadedFile;

class SafeUploadedFile extends UploadedFile
{
    const ALLOWED_EXTENSIONS = ["pdf", "bmp", "jpeg", "jpg", "gif", "png", "doc", "docx", "pptx", "ppt", "xls", "xlsx"];


    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    private function isAllowedExtension(): bool
    {
        return in_array($this->getExtension(), self::ALLOWED_EXTENSIONS);
    }

    public function save(bool $randomFileName = true): bool
    {
        if (!$this->isAllowedExtension() || $this->hasError) {
            return false;
        }

        $targetPath = Yii::getAlias("@app/web/uploads/" . date("Y") . "/" . date("m"));

        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0755, true);
        }

        $targetName = $randomFileName ? $this->generateRandomName() : $this->name;

        $targetFullName = $this->changeFileNameIfExist($targetPath, $targetName);

        return move_uploaded_file($this->tempName, $targetFullName);
    }

    private function changeFileNameIfExist(string $path, string $filename): string
    {
        $fullPath = $path . "/" . $filename;

        if (file_exists($fullPath)) {
            $filename = pathinfo($filename, PATHINFO_FILENAME) . uniqid() . "." . pathinfo($filename, PATHINFO_EXTENSION);

            $fullPath = $this->changeFileNameIfExist($path, $filename);
        }

        return $fullPath;
    }

    private function generateRandomName(): string
    {
        return md5(microtime() . rand(0, 9000)) . "." . $this->getExtension();
    }
}