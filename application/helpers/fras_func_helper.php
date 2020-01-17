<?php

class FRASFUNC
{
    public function null_blank_replace($str)
    {
        if ($str != NULL && $str != "-") $output = $str;
        else $output = "-";

        return $output;
    }
    public function default_timezone()
    {
        date_default_timezone_set('Asia/Jakarta');

        return;
    }
    public function default_language()
    {
        return 'ID';
    }
    public function replace_mobile_phone($str)
    {
        return str_repeat('*', strlen($str) - 3) . substr($str, -3);
    }
    public function replace_email($str)
    {
        $str = explode("@", $str);

        return str_repeat('*', strlen($str[0]) - 3) . substr($str[0], -3) . '@' . $str[1];
    }
    function getTimeDifference($date1, $date2)
    {
        $diff = abs(strtotime($date2) - strtotime($date1));

        return $diff;
    }

    function cleanInput($data)
    {
        $filter = trim(stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
        return $filter;
    }
    function genRandomNumber($length = 6)
    {
        return substr(str_shuffle("0123456789"), 0, $length);
    }
    function genRandomString($length = 13)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function removeSymbol($string)
    {
        return preg_replace('/[^\p{L}\p{N}\s]/u', '', $string);
    }
    function removeWhitespace($string)
    {
        return preg_replace('/\s+/', '', $string);
    }
    function fixApostrophe($string)
    {
        if (strpos($string, '&#039;') !== false) return str_replace("&#039;", "\\'", $string);
        else return str_replace("'", "\\'", $string);
    }
    function convertStringToArrayWithKey($str)
    {
        $associativeArray = array();

        $str = str_replace(array('{', '}'), '', $str);
        $str = explode(',', $str);
        foreach ($str as $value) {
            $value = str_replace(array('"'), '', $value);
            $key = trim(explode(":", $value)[0]);
            $val = substr($value, strpos($value, ":") + 1);
            $associativeArray[$key] = $val;
        }

        return $associativeArray;
    }
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }
    function getNamaBulan3($bln)
    {
        $bulan = array("JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES");

        return $bulan[($bln - 1)];
    }
    function getNamaBulan($bln)
    {
        $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        return $bulan[($bln - 1)];
    }
    public function json_decode_nice($json, $assoc = FALSE)
    {
        $json = str_replace(array("\n", "\r"), "", $json);
        $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/', '$1"$3":', $json);
        $json = preg_replace('/(,)\s*}$/', '}', $json);
        return json_decode($json, $assoc);
    }
    function getDeleteData($dbdelete)
    {
        $dbdeleteKEY = array_keys($dbdelete);
        $hasil = '';

        for ($i = 0; $i < sizeof($dbdeleteKEY); $i++) {
            $hasil .= '(' . $dbdeleteKEY[$i] . ' => ' . $dbdelete[$dbdeleteKEY[$i]] . '), ';
        }

        return substr($hasil, 0, -2);
    }
    function getInsertData($dbinsert)
    {
        $dbinsertKEY = array_keys($dbinsert);
        $hasil = '';

        for ($i = 0; $i < sizeof($dbinsertKEY); $i++) {
            $hasil .= '(' . $dbinsertKEY[$i] . ' => ' . $dbinsert[$dbinsertKEY[$i]] . '), ';
        }
        return substr($hasil, 0, -2);
    }
    function getUpdateData($dbawal, $dbakhir)
    {
        $dbakhirKEY = array_keys($dbakhir);
        $hasil = '';

        for ($i = 0; $i < sizeof($dbakhirKEY); $i++) {
            if ($dbakhir[$dbakhirKEY[$i]] != $dbawal[$dbakhirKEY[$i]]) {
                $hasil .= $dbakhirKEY[$i] . '(' . $dbawal[$dbakhirKEY[$i]] . ' => ' . $dbakhir[$dbakhirKEY[$i]] . '), ';
            }
        }

        return substr($hasil, 0, -2);
    }
}
