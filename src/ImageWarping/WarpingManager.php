<?php

namespace ImageWarping;

class WarpingManager
{

    protected $gd;

    /**
     *
     * Creates new instance of Warping Manager
     *
     */
    public function __construct()
    {
        
    }

    public function loadBmp($path)
    {
        $this->gd = imagecreatefrombmp($path);
        return $this;
    }

    public function loadGD($data)
    {

    }

    public function loadJpep($path)
    {
        $this->gd = imagecreatefromjpeg($path);
        return $this;
    }

    public function loadPng($path)
    {
        $this->gd = imagecreatefrompng($path);
        return $this;
    }

    public function loadString($data)
    {
        $this->gd = imagecreatefromstring($data);
        return $this;
    }

    public function loadBase64($data)
    {
        $this->gd = imagecreatefromstring(base64_decode($data));
        return $this;
    }

    protected function hypotsq($x, $y)
    {
        return $x*$x + $y*$y;
    }

    protected function mapping($x, $y, $ox, $oy, $radius, $radius_sq, $mou_dx, $mou_dy)
    {
        $u = $x;
        $v = $y;
        $dx = $u - $ox;
        $dy = $v - $oy;
        if (abs($dx) < $radius && abs($dy) < $radius) {
            $rsq = $this->hypotsq($dx, $dy);
            if ($rsq < $radius_sq) {
                $msq = $this->hypotsq($dx - $mou_dx, $dy - $mou_dy);
                $edge_dist = $radius_sq - $rsq;
                $a = $edge_dist / ($edge_dist + $msq);
                $a *= $a;
                $u -= $a * $mou_dx;
                $v -= $a * $mou_dy;
            }
        }
        return [$u, $v];
    }

    protected function pickColorInBounds($img, $x, $y, $type)
    {
        // '500', '461'
        // $h = $this->height;
        // $w = $this->width;

        if ($x <= 0 || $y <= 0 || $x >= $w || $y >= $h)
            return [0, 0, 0];
        else {
            $rgb = imagecolorat($img, $x, $y);
            return [
                ($rgb >> 16) & 0xFF,
                ($rgb >> 8) & 0xFF,
                $rgb & 0xFF,
            ];
        }
    }
    
    protected function bilinearInter($img, $u, $v)
    {
        $ltx = (int)$u;
        $lty = (int)$v;
        $t = $u - $ltx;
        $u = $v - $lty;
        $s1 = $t * $u;
        $s2 = (1 - $t) * $u;
        $s3 = $t * (1 - $u);
        $s4 = (1 - $t) * (1 - $u);
        $rgb1 = $this->pickColorInBounds($img, $ltx, $lty, 'array');
        $rgb2 = $this->pickColorInBounds($img, $ltx + 1, $lty, 'array');
        $rgb3 = $this->pickColorInBounds($img, $ltx, $lty + 1, 'array');
        $rgb4 = $this->pickColorInBounds($img, $ltx + 1, $lty + 1, 'array');
        return [
            (int)($rgb1[0] * $s4 + $rgb2[0] * $s3 + $rgb3[0] * $s2 + $rgb4[0] * $s1),
            (int)($rgb1[1] * $s4 + $rgb2[1] * $s3 + $rgb3[1] * $s2 + $rgb4[1] * $s1),
            (int)($rgb1[2] * $s4 + $rgb2[2] * $s3 + $rgb3[2] * $s2 + $rgb4[2] * $s1),
        ];
    }

    
}
