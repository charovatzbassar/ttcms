<?php

class Utils {
    public static function calculateCategory($dateOfBirth) {
        $today = new DateTime();
        $dob = new DateTime($dateOfBirth);
        $age = $today->diff($dob)->y;

        switch ($age) {
            case ($age < 10):
                return "MINI_MINI_CADET";
            case ($age < 13):
                return "MINI_CADET";
            case ($age < 15):
                return "CADET";
            case ($age < 19):
                return "JUNIOR";
            case ($age < 40):
                return "SENIOR";
            default:
                return "VETERAN";
        }
    }
}

?>