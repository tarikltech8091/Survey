<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Common extends Model
{

    /**
     * Convert data time to sec, min, hour, day, month, year.
     *
     * @param date $datetime
     * @param bool $full
     * @return string
     */
    public static function TiemElapasedString($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


        /**
     * Common District.
     *
     * @param 
     * @return string
     */
    public static function AllDistrict()
    {

        $string = array(
                        'Dhaka',
                        'Faridpur',
                        'Gazipur',
                        'Gopalganj',
                        'Jamalpur',
                        'Kishoreganj',
                        'Madaripur',
                        'Manikganj',
                        'Munshiganj',
                        'Mymensingh',
                        'Narayanganj',
                        'Narsingdi',
                        'Netrokona',
                        'Rajbari',
                        'Shariatpur',
                        'Sherpur',
                        'Tangail',
                        'Bogura',
                        'Joypurhat',
                        'Naogaon',
                        'Natore',
                        'Chapainawabganj',
                        'Pabna',
                        'Rajshahi',
                        'Sirajgonj',
                        'Dinajpur',
                        'Gaibandha',
                        'Kurigram',
                        'Lalmonirhat',
                        'Nilphamari',
                        'Panchagarh',
                        'Rangpur',
                        'Thakurgaon',
                        'Barguna',
                        'Barishal',
                        'Bhola',
                        'Jhalokati',
                        'Patuakhali',
                        'Pirojpur',
                        'Bandarban',
                        'Brahmanbaria',
                        'Chandpur',
                        'Chattogram',
                        'Cumilla',
                        'Coxsbazar',
                        'Feni',
                        'Khagrachhari',
                        'Lakshmipur',
                        'Noakhali',
                        'Rangamati',
                        'Habiganj',
                        'Moulvibazar',
                        'Sunamganj',
                        'Sylhet',
                        'Bagerhat',
                        'Chuadanga',
                        'Jashore',
                        'Jhenaidah',
                        'Khulna',
                        'Kushtia',
                        'Magura',
                        'Meherpur',
                        'Narail',
                        'Satkhira'
                    );

        return $string;

        /*foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now'*/;
    }


}
