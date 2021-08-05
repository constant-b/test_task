<?php


namespace app\models;


use Yii;
use yii\web\UploadedFile;

class SafeUploadedFile extends UploadedFile
{
    const ALLOWED_EXTENSIONS = ["pdf", "bmp", "jpeg", "jpg", "gif", "png", "doc", "docx", "pptx", "ppt", "xls", "xlsx"];


    /**
     * SafeUploadedFile constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * Checks file extension.
     *
     * @return bool
     */
    private function isAllowedExtension(): bool
    {
        return in_array($this->getExtension(), self::ALLOWED_EXTENSIONS);
    }

    /**
     * Saves uploaded file.
     * If target file already exist, unique id will be added to filename.
     *
     * @param bool $randomFileName If param is true file name will be generated automatically
     *
     * @return bool
     */
    public function save(bool $randomFileName = true): bool
    {
        if (!$this->isAllowedExtension() || $this->hasError) return false;

        $targetPath = Yii::getAlias("@app/web/uploads/" . date("Y") . "/" . date("m"));

        if (!is_dir($targetPath)) mkdir($targetPath, 0755, true);

        $targetName = $randomFileName ? $this->generateRandomName() : $this->name;

        $targetFullName = $this->changeFileNameIfExist($targetPath, $targetName);

        return move_uploaded_file($this->tempName, $targetFullName);
    }

    /**
     * Adds an unique id to the file name if such file already exists.
     *
     * @param string $path     Path to the folder where the photo will be saved
     * @param string $filename The name with which the file will be saved
     *
     * @return string
     */
    private function changeFileNameIfExist(string $path, string $filename): string
    {
        $fullPath = $path . "/" . $filename;

        if (file_exists($fullPath)) {
            $filename = pathinfo($filename, PATHINFO_FILENAME) . uniqid() . "." . pathinfo($filename, PATHINFO_EXTENSION);

            $fullPath = $this->changeFileNameIfExist($path, $filename);
        }

        return $fullPath;
    }

    /**
     * Generates random file name.
     *
     * @return string
     */
    private function generateRandomName(): string
    {
        return md5(microtime() . rand(0, 9000)) . "." . $this->getExtension();
    }
}