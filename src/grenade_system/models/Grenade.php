<?php


namespace grenade_system\models;


class Grenade
{
    const NAME = "";
    const RANGE = 0;
    const DELAY = 0;
    const DURATION = 0;


    static function fromString(string $text): ?Grenade {
        switch ($text) {
            case FlameBottle::NAME:
                return new FlameBottle();
                break;
            case FragGrenade::NAME:
                return new FragGrenade();
                break;
            case SmokeGrenade::NAME:
                return new SmokeGrenade();
                break;
        }

        return null;
    }
}