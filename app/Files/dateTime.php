<?php

use Carbon\Carbon;

// Date Customize
function dateCustomize()
{
    return str_replace('/', '-', settings('date_format'));
}

// Output Date Format
function outputDateFormat()
{
    // $dbDate = dateCustomize();
    $dbDate = settings('date_format');

    if ($dbDate == 'DD-MM-YYYY') {
        $outputDateFormat = 'd-m-Y';
    } elseif ($dbDate == 'MM-DD-YYYY') {
        $outputDateFormat = 'm-d-Y';
    } elseif ($dbDate == 'YYYY-MM-DD') {
        $outputDateFormat = 'Y-m-d';
    } elseif ($dbDate == 'YYYY-DD-MM') {
        $outputDateFormat = 'Y-d-m';
    } elseif ($dbDate == 'DD/MM/YYYY') {
        $outputDateFormat = 'd/m/Y';
    } elseif ($dbDate == 'MM/DD/YYYY') {
        $outputDateFormat = 'm/d/Y';
    } elseif ($dbDate == 'YYYY/MM/DD') {
        $outputDateFormat = 'Y/m/d';
    } elseif ($dbDate == 'YYYY/DD/MM') {
        $outputDateFormat = 'Y/d/m';
    }

    return $outputDateFormat;
}

// Input Date Format
function inputDateFormat()
{
    return settings('date_format');
    // return dateCustomize();
}

// Output Time Format
function outputTimeFormat()
{
    // 24 Hour Format
    $outputTimeFormat = 'H:i:s';

    // 12 Hour Format
    if (settings('time_format') == '12h') {
        $outputTimeFormat = 'g:i A';
    }

    return $outputTimeFormat;
}

// Input Time Format
function inputTimeFormat()
{
    // 24 Hour Format
    $inputTimeFormat = 'HH:mm:ss';

    // 12 Hour Format
    if (settings('time_format') == '12h') {
        $inputTimeFormat = 'hh:mm A';
    }

    return $inputTimeFormat;
}

// Output Date & Time Format
function outputDateTimeFormat()
{
    return outputDateFormat() . ' ' . outputTimeFormat();
}

// Input Date & Time Format
function inputDateTimeFormat()
{
    return inputDateFormat() . ' ' . inputTimeFormat();
}


// Get Formatted Date
function getFormattedDate($date)
{
    return Carbon::parse($date)->format(outputDateFormat());
}

// Get Formatted Time
function getFormattedTime($time)
{
    return Carbon::parse($time)->format(outputTimeFormat());
}

// Get Formatted Date & Time
function getFormattedDateTime($dateTime)
{
    return Carbon::parse($dateTime)->format(outputDateTimeFormat());
}



// Hour Format 24h / 12h
function hourFormat()
{
    // 24 Hour Format
    $hourFormat = 'true';

    // 12 Hour Format
    if (settings('time_format') == '12h') {
        $hourFormat = 'false';
    }

    return $hourFormat;
}

// Prepare Date Validate
function prepareDateValidate($date)
{
    return Carbon::createFromFormat(outputDateFormat(), $date)->format('Y-m-d');
}
