<?php

namespace ImageWarping;

class WarpingManagerStatic
{
    /**
     * Instance of ImageWarping\WarpingManager
     *
     * @var ImageManager
     */
    public static $manager;

    /**
     * Creates a new instance
     *
     * @param WarpingManager $manager
     */
    public function __construct(WarpingManager $manager = null)
    {
        self::$manager = $manager ? $manager : new WarpingManager;
    }

    /**
     * Get or create new WarpingManager instance
     *
     * @return WarpingManager
     */
    public static function getManager()
    {
        return self::$manager ? self::$manager : new WarpingManager;
    }

    /**
     * Statically initiates an Warping instance from following types
     *
     * @param  mixed $data
     *
     * @return ImageWarping\Warping
     */
    public static function loadBmp($path)
    {
        return self::getManager()->loadBmp($path);
    }

    public static function loadGD($data)
    {
        return self::getManager()->loadGD($data);
    }

    public static function loadJpeg($path)
    {
        return self::getManager()->loadJpeg($path);
    }

    public static function loadPng($path)
    {
        return self::getManager()->loadPng($path);
    }

    public static function loadString($data)
    {
        return self::getManager()->loadString($data);
    }

    public static function loadBase64($data)
    {
        return self::getManager()->loadBase64($data);
    }
}
