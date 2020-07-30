<?php
declare(strict_types=1);

namespace Core;

use DateTime;
use ReflectionClass;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use ReflectionException;

/**
 * Class Logger
 * @package Core
 */
class Logger extends AbstractLogger implements LoggerInterface
{

    /**
     * @var string
     */
    public string $filePath;

    /**
     * @var string
     */
    public string $template = "{date} {level} {message} {context}";

    /**
     * @var string
     */
    public string $dateFormat = DateTime::RFC2822;

    /**
     * Logger constructor.
     * @param array $loggerConfig
     * @throws ReflectionException
     */
    public function __construct(array $loggerConfig)
    {
        $reflection = new ReflectionClass($this);
        foreach ($loggerConfig as $attribute => $value) {
            $property = $reflection->getProperty($attribute);
            if ($property->isPublic())
            {
                $property->setValue($this, $value);
            }
        }

        if (!file_exists($this->filePath)) {
            touch($this->filePath);
        }
    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     */
    public function log($level, $message, array $context = [])
    {
        file_put_contents($this->filePath, trim(strtr($this->template, [
                '{date}'    => $this->getDate(),
                '{level}'   => $level,
                '{message}' => $message,
                '{context}' => $this->contextStringify($context),
            ])) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @return string
     */
    protected function getDate()
    {
        return (new DateTime())->format($this->dateFormat);
    }

    /**
     * @param array $context
     * @return string
     */
    protected function contextStringify(array $context = [])
    {
        return !empty($context) ? json_encode($context) : null;
    }
}
