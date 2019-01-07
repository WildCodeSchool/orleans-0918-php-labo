<?php
/**
 * Created by PhpStorm.
 * User: ln
 * Date: 12/12/18
 * Time: 14:41
 */

namespace App\Service;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SignatureService
{
    const NO_IMAGE_DATA = <<<EOT
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAArwAAADICAYAAAAKljK9AAACNklEQVR4nO3BMQEAAADCoPVPbQlPoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgLcBjMAAASbpGwwAAAAASUVORK5CYII=
EOT;

    /**
     * @var string
     */
    private $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function add(string $signature) : string
    {
        if (!empty($signature)) {
            $path = $this->projectDir . '/assets/images/signatures/' . uniqid('sign_') . ".png";
            file_put_contents($path, file_get_contents($signature));
            return $path;
        }
    }

    public function delete($path)
    {
        if (!empty($path)) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    public static function validate($object, ExecutionContextInterface $context, $payload)
    {
        if (empty($object)) {
            $context->buildViolation("Vous n'avez pas signé.")
                    ->atPath('signature')
                    ->addViolation();
        }

        if (self::NO_IMAGE_DATA === $object) {
            $context->buildViolation("Vous n'avez pas signé.")
                    ->atPath('signature')
                    ->addViolation();
        }
    }
}
