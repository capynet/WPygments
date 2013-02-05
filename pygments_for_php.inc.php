<?php
/**
 * Comunicates with our middleware, and it call pygmentize.
 *
 * @param $code
 * @param $language
 * @param string $style
 * @param int $tabwidth
 * @return string
 */
function pygmentize($code, $language, $style = "default", $tabwidth = 4)
{

    $pygments_bind_app = "python " . dirname(__FILE__) . "/bind.py";

    // Create a temporary file as bridge for code...
    $temp_name = tempnam("/tmp", "pygmentize_");
    $file_handle = fopen($temp_name, "w");
    fwrite($file_handle, $code);
    fclose($file_handle);
    chmod($temp_name, 0777);

    //Settings
    $pygments_bind_params = array(
        "--sourcefile" => $temp_name,
        "--style" => $style,
        "--lang" => $language,
        "--tabwidth" => $tabwidth,
        "--getstyles" => true,
    );

    $params = " ";
    foreach ($pygments_bind_params as $k => $v) {
        $params .= $k . "=" . $v . " ";
    }

    $command = $pygments_bind_app . " " . rtrim($params);
    $output = array();
    $retval = -1;

    exec($command, $output, $retval);
    unlink($temp_name);

    $divider = array_search('<<<<< divide&conquer >>>>>>', $output);
    $arrCode = array_splice($output, 0, $divider);
    $arrStyles = array_splice($output, 1);

    return array(
        "code" => utf8_decode(implode("\n", $arrCode)),
        "styles" => implode("\n", $arrStyles)
    );

}
