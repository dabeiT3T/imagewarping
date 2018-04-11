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
     * Statically initiates an Warping instance
     *
     * @param  mixed $data
     *
     * @return ImageWarping\Warping
     */
    public static function make($data)
    {
        return self::getManager()->make;
    }
}
