<?php
class ImageUploader extends Conexao
{
    private $uploadDir;
    private $allowedTypes;
    private $maxSize;

    public function __construct($uploadDir = "Public/Images/", $maxSize = 5 * 1024 * 1024)
    {
        $this->uploadDir = $uploadDir;
        $this->allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $this->maxSize = $maxSize;

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0775, true);
        }
    }

    public function upload($file, $id)
    {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Erro no upload.'];
        }

        if ($file['size'] > $this->maxSize) {
            return ['success' => false, 'message' => 'Arquivo muito grande.'];
        }

        if (!in_array($file['type'], $this->allowedTypes)) {
            return ['success' => false, 'message' => 'Tipo de arquivo não permitido.'];
        }

        $filename = $id . '.webp';
        $destination = $this->uploadDir .  "/" . $filename;

        // Criar a imagem baseada no tipo do arquivo
        $sourceImage = $this->createImageFromFile($file);
        if (!$sourceImage) {
            return ['success' => false, 'message' => 'Erro ao processar a imagem.'];
        }

        // Converter para WebP
        if (imagewebp($sourceImage, $destination, 80)) {
            imagedestroy($sourceImage);
            return ['success' => true, 'path' => $destination, 'filename' => $filename . '.webp'];
        }

        imagedestroy($sourceImage);
        return ['success' => false, 'message' => 'Falha ao converter para WebP.'];
    }

    private function createImageFromFile($file)
    {
        switch ($file['type']) {
            case 'image/jpeg':
                return imagecreatefromjpeg($file['tmp_name']);
            case 'image/png':
                return imagecreatefrompng($file['tmp_name']);
            case 'image/gif':
                return imagecreatefromgif($file['tmp_name']);
            case 'image/webp':
                return imagecreatefromwebp($file['tmp_name']);
            default:
                return false;
        }
    }
}
