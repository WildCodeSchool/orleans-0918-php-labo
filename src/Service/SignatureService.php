<?php
/**
 * Created by PhpStorm.
 * User: ln
 * Date: 12/12/18
 * Time: 14:41
 */

namespace App\Service;

/**
 * Class SignatureService
 * @package App\Service
 */
class SignatureService
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * SignatureService constructor.
     * @param string $projectDir
     */
    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * @param string $signature
     * @return string
     * @throws \Exception
     */
    public function add(string $signature) : string
    {
        if (empty($signature)) {
            throw new \Exception('Empty signature');
        }

        $fileName=uniqid('sign_') . ".png";
        $path = $this->projectDir . '/public/build/images/signatures/'. $fileName ;
        file_put_contents($path, file_get_contents($signature));
        return $fileName;
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
