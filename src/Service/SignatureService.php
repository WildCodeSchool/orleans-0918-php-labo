<?php
/**
 * Created by PhpStorm.
 * User: ln
 * Date: 12/12/18
 * Time: 14:41
 */

namespace App\Service;

class SignatureService
{
    /**
     * @var string
     */
    private $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * @param string $signature
     * @return string
     */
    public function add(string $signature) : string
    {
        if (!empty($signature)) {
            $filename = uniqid('sign_') . ".png";
            $path = $this->projectDir . '/public/build/images/signatures/' .$filename ;
            file_put_contents($path, file_get_contents($signature));
            return $filename;
        }
    }

    /**
     * @param $path
     */
    public function delete($path)
    {
        if (!empty($path)) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
