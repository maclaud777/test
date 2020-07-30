<?php
declare(strict_types=1);

namespace Core;

/**
 * Class Session
 */
class Session
{
    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * @param bool $write
     */
    public function start($write = false): void
    {
        session_start();

        if (!$write) {
            $this->writeClose();
        }
    }

    /**
     *
     */
    public function writeClose(): void
    {
        session_write_close();
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param null|mixed $default
     * @return null|mixed
     */
    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function destroy(): void
    {
        if ($this->isActive()) {
            session_unset();
            session_destroy();
        }
    }
}