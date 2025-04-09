<?php

if (!function_exists('currencyToFloat')) {
    function currencyToFloat($val)
    {
        // Converts 12.3456,78 to 123456,78
        $val = str_replace(',', '', $val);
        $val = str_replace('', '.', $val);
        return (float) $val;
    }
}

if (!function_exists('extractFloatCurrency')) {

    function extractFloatCurrency($val)
    {
        $pattern = '/(?<=R\$).*?(?=\(|$)/';

        if (preg_match($pattern, $val, $matches)) {
            $returnVal = str_replace(["\u{A0}", "."], '', $matches[0]);
            $returnVal = floatval(str_replace(',', '.', $returnVal));
            return $returnVal;
        }
        return null;
    }
}


if (!function_exists('stringMask')) {
    function stringMask($string, $mask)
    {
        // converts string to a masked value represented by #
        // ex (07062561070, ###.###.###-##)
        // returns 070.625.610-70
        $masked = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($string[$k]))
                    $masked .= $string[$k++];
            } else {
                if (isset($mask[$i]))
                    $masked .= $mask[$i];
            }
        }
        return $masked;
    }
}

if (!function_exists('multiplyTime')) {
    function multiplyTime($time, $factor)
    {

        $carbonTime = Carbon\Carbon::createFromFormat('H:i:s', $time);
        $totalSeconds = $carbonTime->hour * 3600 + $carbonTime->minute * 60 + $carbonTime->second;

        $resultInSeconds = $totalSeconds * $factor;

        // Convert back to hours, minutes, and seconds
        $resultHours = $resultInSeconds / 3600;
        $remainingSeconds = $resultInSeconds % 3600;
        $resultMinutes = $remainingSeconds / 60;
        $resultSeconds = $remainingSeconds % 60;

        // Format the result as HH:MM:SS
        return sprintf('%02d:%02d:%02d', $resultHours, $resultMinutes, $resultSeconds);
    }
}


if (!function_exists('sumTime')) {
    function sumTime(array $times)
    {
        $total = 0;

        foreach ($times as $time) {

            if (!$time) {
                continue;
            }

            $isNegative = false;

            if (strpos($time, '-') === 0) {
                $isNegative = true;

                $time = substr($time, 1);
            }
            $carbonTime = Carbon\Carbon::createFromFormat('H:i:s', $time);

            $seconds = $carbonTime->hour * 3600 + $carbonTime->minute * 60 + $carbonTime->second;
            if ($isNegative) {
                $total -= $seconds;
            } else {
                $total += $seconds;
            }
        }

        $totalHours = $total / 3600;
        $remainingSeconds = $total % 3600;
        $totalMinutes = $remainingSeconds / 60;
        $totalSeconds = $remainingSeconds % 60;

        // Format the result as HH:MM:SS
        return sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds);
    }
}

if (!function_exists('getRandomChars')) {
    function getRandomChars($string, $charNumber = 5)
    {
        $result = [];
        $length = strlen($string);

        if ($charNumber > $length) {
            $charNumber = $length; // Ensure we don't ask for more characters than are in the string
        }

        $randomIndexes = array_rand(array_flip(range(0, $length - 1)), $charNumber);

        foreach ((array) $randomIndexes as $index) {
            $result[] = $string[$index];
        }

        return $result;
    }
}

if (!function_exists('distanceLocations')) {

    /**
     *
     * @param array $from
     * @param array $to
     *
     * @return float [km]
     */
    function distanceLocations($from, $to)
    {
        $rad = M_PI / 180;
        //Calculate distance from latitude and longitude
        $theta = $from['long'] - $to['long'];
        $dist = sin($from['lat'] * $rad)
            * sin($to['lat'] * $rad) + cos($from['lat'] * $rad)
            * cos($to['lat'] * $rad) * cos($theta * $rad);


        $distance = acos($dist) / $rad * 60 * 1.853;

        if ($distance < 1) {
            return $distance;
        } else {
            return round($distance);
        }
    }
}