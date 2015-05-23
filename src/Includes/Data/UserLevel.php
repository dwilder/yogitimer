<?php
namespace Src\Lib\Data;

/*
 * User Level is a word that describes how the user is progressing.
 * It is calculated from the total meditation time and the past 365 days.
 */
class UserLevel
{
    /*
     * Levels
     */
    private $levels = array(
        1 => 'beginner',
        2 => 'novice',
        3 => ''
    );
}
