<?
/**
 * Вывод перенменной
 * @global type $USER
 * @param type $mas
 * @param type $prent
 * @param type $show
 */
function prent($mas, $prent = true, $show = false, $name = false)
    {
    global $USER;
    if ($USER->IsAdmin() || $show)
        {
        if ($name)
            {
            echo "<h3>" . $name . "</h3>";
            }
        echo "<pre style=\"text-align:left; background-color:#CCC;color:#000; font-size:10px; padding-bottom: 10px; border-bottom:1px solid #000;\">";
        if ($prent)
            print_r($mas);
        else
            var_dump($mas);
        echo "</pre>";
        }
    }

/**
 * Вывод исключений
 * @global type $USER
 * @param type $mas
 * @param type $prent
 * @param type $show
 */
function prentExpection($mas, $prent = true, $show = false, $name = false)
    {
    global $USER;
//    if ($USER->IsAdmin() || $show)
//        {
        if ($name)
            {
            echo "<h3>" . $name . "</h3>";
            }
        echo "<pre style=\"text-align:left; background-color:red;color:#fff; font-weight: bold; font-size:10px; padding-bottom: 10px; border-bottom:1px solid #000;\">";
        if ($prent)
            print_r($mas);
        else
            var_dump($mas);
        echo "</pre>";
//        }
    }

/**
 * Функция масшатибрования изображений с поддержкой кеширования
 * Поддерживает разные режимы работы MODE
 * MODE принимает значения: cut, in, inv, width
 * @param type $params - массив параметров ресайзера
 * @param type $req
 * @param type $SETSTYLE
 */
define("CHACHE_IMG_PATH", "{$_SERVER["DOCUMENT_ROOT"]}/images/cache/");
define("RETURN_IMG_PATH", "/images/cache/");

function imageResize($params, $filePath)
    {

    $params["WIDTH"] = !isset($params["WIDTH"]) ? 100 : intval($params["WIDTH"]);
    $params["HEIGHT"] = !isset($params["HEIGHT"]) ? 100 : intval($params["HEIGHT"]);
    $params["MODE"] = !isset($params["MODE"]) ? 'inv' : strtolower($params["MODE"]);


    $params["QUALITY"] = (!isset($params["QUALITY"]) || intval($params["QUALITY"]) <= 0 ) ? 100 : $params["QUALITY"];
    $params["HIQUALITY"] = !isset($params["HIQUALITY"]) ? (($params["WIDTH"] <= 200 || $params["HEIGHT"] <= 200) ? 1 : 0 ) : 0;

    $imageType = getFileExtension($filePath);

    $pathToOriginalFile = "{$_SERVER["DOCUMENT_ROOT"]}/{$filePath}";

    if (!file_exists($pathToOriginalFile))
        return;

    $salt = md5(strtolower($filePath) . implode('_', $params) . $SETSTYLE);
    $salt = substr($salt, 0, 3) . '/';

    $filename = basename($filePath);
    $pathToFile = $salt . $filename;

    // если изображение существует
    if (is_file(CHACHE_IMG_PATH . $pathToFile) == true)
        {
        if ($_REQUEST["clear_cache"] == 'IMAGE')
            { //при очистке кэша
            unlink(RETURN_IMG_PATH . $pathToFile);
            }
        else
            {
            return RETURN_IMG_PATH . $pathToFile;
            }
        }

    CheckDirPath(CHACHE_IMG_PATH . $salt);


    $i = getImageSize($pathToOriginalFile);

    if (intval($params["WIDTH"]) == 0)
        $params["WIDTH"] = intval($params["HEIGHT"] / $i[1] * $i[0]);

    if (intval($params["HEIGHT"]) == 0)
        $params["HEIGHT"] = intval($params["WIDTH"] / $i[0] * $i[1]);


    //если вырезаться будет cut проверка размеров
    if (($params["WIDTH"] > $i[0] || $params["HEIGHT"] > $i[1]) && ($params["MODE"] != "in" && $params["MODE"] != "inv"))
        {
        $params["WIDTH"] = $i[0];
        $params["HEIGHT"] = $i[1];
        }


    $im = ImageCreateTrueColor($params["WIDTH"], $params["HEIGHT"]);
    imageAlphaBlending($im, false);
    switch (strtolower($imageType))
        {
        case 'gif' :
            $i0 = ImageCreateFromGif($pathToOriginalFile);
            $icolor = imagecolorallocate($im, 255, 255, 255);
            imagefill($im, 0, 0, $icolor);
            break;
        case 'jpg' : case 'jpeg' :
            $i0 = ImageCreateFromJpeg($pathToOriginalFile);
            $icolor = imagecolorallocate($im, 255, 255, 255);
            imagefill($im, 0, 0, $icolor);
            break;
        case 'png' :
            $i0 = ImageCreateFromPng($pathToOriginalFile);
            $icolor = imagecolorallocate($im, 255, 255, 255);
            imagefill($im, 0, 0, $icolor);

            break;
        }

    if (!($i[0] == $params["WIDTH"] && $i[1] == $params["HEIGHT"] && !$SETSTYLE))
        {
        switch (strtolower($params["MODE"]))
            {
            case 'cut' :
                $k_x = $i [0] / $params["WIDTH"];
                $k_y = $i [1] / $params["HEIGHT"];
                if ($k_x > $k_y)
                    $k = $k_y;
                else
                    $k = $k_x;
                $pn["WIDTH"] = $i [0] / $k;
                $pn["HEIGHT"] = $i [1] / $k;
                $x = ($params["WIDTH"] - $pn["WIDTH"]) / 2;
                $y = ($params["HEIGHT"] - $pn["HEIGHT"]) / 2;


                imageCopyResampled($im, $i0, $x, $y, 0, 0, $pn["WIDTH"] + 2, $pn["HEIGHT"] + 2, $i[0], $i[1]);
                //                ( dst_im,  src_im, dstX, dstY,  srcX,  srcY, int dstW, int dstH, int srcW, int srcH)
                break;

            //вписана в квадрат без маштабирования (картинка может быть увеличена больше своего размера)
            case 'in' :

                if (($i [0] < $params["WIDTH"]) && ($i [1] < $params["HEIGHT"]))
                    {
                    $k_x = 1;
                    $k_y = 1;
                    }
                else
                    {
                    $k_x = $i[0] / $params["WIDTH"];
                    $k_y = $i[1] / $params["HEIGHT"];
                    }

                if ($k_x < $k_y)
                    $k = $k_y;
                else
                    $k = $k_x;

                $pn["WIDTH"] = intval($i[0] / $k);
                $pn["HEIGHT"] = intval($i[1] / $k);

                $x = intval(($params["WIDTH"] - $pn["WIDTH"]) / 2);
                $y = intval(($params["HEIGHT"] - $pn["HEIGHT"]) / 2);

                imageCopyResampled($im, $i0, $x, $y, 0, 0, $pn["WIDTH"], $pn["HEIGHT"], $i[0], $i[1]);
                // 1 первый параметр изборажение источник
                // 2 изображение которое вставляется
                // 3 4 -х и у с какой точки будет вставятся в изображении источник
                // 5 6 - ширина и высота куда будет вписано изображение


                break;
            //вписана в квадрат с маштабированием (картинка может быть увеличена)
            case 'inv' :

                $k_x = $i [0] / $params["WIDTH"];
                $k_y = $i [1] / $params["HEIGHT"];
                if ($k_x < $k_y)
                    $k = $k_y;
                else
                    $k = $k_x;
                $pn["WIDTH"] = $i [0] / $k;
                $pn["HEIGHT"] = $i [1] / $k;
                $x = ($params["WIDTH"] - $pn["WIDTH"]) / 2;
                $y = ($params["HEIGHT"] - $pn["HEIGHT"]) / 2;
                imageCopyResampled($im, $i0, $x, $y, 0, 0, $pn["WIDTH"], $pn["HEIGHT"], $i[0], $i[1]);


                if ($params["WIDTH"] == 55 && $params["HEIGHT"] == 45)
                    {
                    imageAlphaBlending($im, true);
                    $waterMark = ImageCreateFromPng($_SERVER["DOCUMENT_ROOT"] . "/img/video.png");
                    imageCopyResampled($im, $waterMark, 0, 0, 0, 0, $params["WIDTH"], $params["HEIGHT"], $params["WIDTH"], $params["HEIGHT"]);
                    }

                break;

            case 'width' :
                $factor = $i[1] / $i[0]; // определяем пропорцию   height / width

                if ($factor > 1.35)
                    {
                    $pn["WIDTH"] = $params["WIDTH"];
                    $scale_factor = $i[0] / $pn["WIDTH"]; // коэфффициент масштабирования
                    $pn["HEIGHT"] = ceil($i[1] / $scale_factor);
                    $x = 0;
                    $y = 0;
                    if (($params["HEIGHT"] / $pn["HEIGHT"]) < 0.6)
                        {
                        //echo 100 / ($pn["HEIGHT"] * 100) / ($params["HEIGHT"] *1.5);
                        $pn["HEIGHT"] = (100 / (($pn["HEIGHT"] * 100) / ($params["HEIGHT"] * 1.3))) * $pn["HEIGHT"];
                        $newKoef = $i[1] / $pn["HEIGHT"];
                        $pn["WIDTH"] = $i[0] / $newKoef;

                        $x = ($params["WIDTH"] - $pn["WIDTH"]) / 2;
                        //$y = ($params["HEIGHT"] - $pn["HEIGHT"]) / 2;
                        }

                    imageCopyResampled($im, $i0, $x, $y, 0, 0, $pn["WIDTH"], $pn["HEIGHT"], $i[0], $i[1]);
                    }
                else
                    {
                    if (($i [0] < $params["WIDTH"]) && ($i [1] < $params["HEIGHT"]))
                        {
                        $k_x = 1;
                        $k_y = 1;
                        }
                    else
                        {
                        $k_x = $i [0] / $params["WIDTH"];
                        $k_y = $i [1] / $params["HEIGHT"];
                        }

                    if ($k_x < $k_y)
                        $k = $k_y;
                    else
                        $k = $k_x;

                    $pn["WIDTH"] = $i [0] / $k;
                    $pn["HEIGHT"] = $i [1] / $k;

                    $x = ($params["WIDTH"] - $pn["WIDTH"]) / 2;
                    $y = ($params["HEIGHT"] - $pn["HEIGHT"]) / 2;
                    imageCopyResampled($im, $i0, $x, $y, 0, 0, $params["MODE"], $pn["HEIGHT"], $i[0], $i[1]);
                    }
                break;

            default : imageCopyResampled($im, $i0, 0, 0, 0, 0, $params["WIDTH"], $params["HEIGHT"], $i[0], $i[1]);
                break;
            }

        if ($params["HIQUALITY"])
            {
            $sharpenMatrix = array
             (
             array(-1.2, -1, -1.2),
             array(-1, 20, -1),
             array(-1.2, -1, -1.2)
            );
            // calculate the sharpen divisor
            $divisor = array_sum(array_map('array_sum', $sharpenMatrix));
            $offset = 0;
            // apply the matrix
            imageconvolution($im, $sharpenMatrix, $divisor, $offset);
            }


        switch (strtolower($imageType))
            {
            case 'gif' :imageSaveAlpha($im, true);
                @imageGif($im, CHACHE_IMG_PATH . $pathToFile);
                break;
            case 'jpg' : case 'jpeg' : @imageJpeg($im, CHACHE_IMG_PATH . $pathToFile, $params["QUALITY"]);
                break;
            case 'png' : imageSaveAlpha($im, true);
                @imagePng($im, CHACHE_IMG_PATH . $pathToFile);
                break;
            }
        }
    else
        {
        copy($pathToOriginalFile, CHACHE_IMG_PATH . $pathToFile);
        }

    return RETURN_IMG_PATH . $pathToFile;
    }
?>