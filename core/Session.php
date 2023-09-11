<?php

namespace app\core;
use ReflectionClass;

class Session
{
     const FLASH_KEY = 'flash_messages';
     const FLASH_DANGER = 'danger';
     const FLASH_WARNING = 'warning';
     const FLASH_INFO = 'info';
     const FLASH_SUCCESS = 'success';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message,
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }
    public function getFlashMessage(): string
    {
        $flashTypes = ['danger', 'success', 'warning', 'info'];
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        $formattedMessages = '';

        foreach ($flashTypes as $type) {
            if (isset($flashMessages[$type])) {
                $flashMessage = $flashMessages[$type];
                $formattedMessages .= sprintf('<div class="alert alert-%s">%s</div>',
                    $type, $flashMessage['value']);
            }
        }

        return $formattedMessages;
    }
//    public function getFlashMessage(): string
//    {
//        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
//        $formattedMessages = '';
//        $flashTypes = $this->getFlashTypes();
//        foreach ($flashTypes as $type) {
//            if (isset($flashMessages[$type])) {
//                $flashMessage = $flashMessages[$type];
//                $formattedMessages .= sprintf('<div class="alert alert-%s">%s</div>',
//                    $type, $flashMessage['value']);
//            }
//        }
//
//        return $formattedMessages;
//    }
//
//    private function getFlashTypes(): array
//    {
//        $reflectionClass = new ReflectionClass($this);
//        $constants = $reflectionClass->getConstants();
//        $flashTypes = [];
//        foreach ($constants as $constantName => $constantValue) {
//            if (strpos($constantName, 'FLASH_') === 0) {
//                $flashTypes[] = $constantValue;
//            }
//        }
//        return $flashTypes;
//    }

    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
}


