<?php
function ValidateEmail($email)
{
   $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
   return preg_match($pattern, $email);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formid'] == 'form1')
{
   $mailto = 'sales@remark.kz';
   $mailfrom = 'sales@remark.kz';
   $subject = 'sales@remark.kz';
   $message = 'Values submitted from web site form: remark.kz';
   $success_url = './index.php';
   $error_url = './index.php';
   $error = '';
   $eol = "\n";
   $max_filesize = isset($_POST['filesize']) ? $_POST['filesize'] * 1024 : 1024000;
   $boundary = md5(uniqid(time()));

   $header  = 'From: '.$mailfrom.$eol;
   $header .= 'Reply-To: '.$mailfrom.$eol;
   $header .= 'MIME-Version: 1.0'.$eol;
   $header .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'.$eol;
   $header .= 'X-Mailer: PHP v'.phpversion().$eol;
   if (!ValidateEmail($mailfrom))
   {
      $error .= "The specified email address is invalid!\n<br>";
   }

   if (!empty($error))
   {
      $errorcode = file_get_contents($error_url);
      $replace = "##error##";
      $errorcode = str_replace($replace, $error, $errorcode);
      echo $errorcode;
      exit;
   }

   $internalfields = array ("submit", "reset", "send", "filesize", "formid", "captcha_code", "recaptcha_challenge_field", "recaptcha_response_field");
   $message .= $eol;
   $message .= "IP Address : ";
   $message .= $_SERVER['REMOTE_ADDR'];
   $message .= $eol;
   foreach ($_POST as $key => $value)
   {
      if (!in_array(strtolower($key), $internalfields))
      {
         if (!is_array($value))
         {
            $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
         }
         else
         {
            $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
         }
      }
   }

   $body  = 'This is a multi-part message in MIME format.'.$eol.$eol;
   $body .= '--'.$boundary.$eol;
   $body .= 'Content-Type: text/plain; charset=utf-8'.$eol;
   $body .= 'Content-Transfer-Encoding: 8bit'.$eol;
   $body .= $eol.stripslashes($message).$eol;
   if (!empty($_FILES))
   {
       foreach ($_FILES as $key => $value)
       {
          if ($_FILES[$key]['error'] == 0 && $_FILES[$key]['size'] <= $max_filesize)
          {
             $body .= '--'.$boundary.$eol;
             $body .= 'Content-Type: '.$_FILES[$key]['type'].'; name='.$_FILES[$key]['name'].$eol;
             $body .= 'Content-Transfer-Encoding: base64'.$eol;
             $body .= 'Content-Disposition: attachment; filename='.$_FILES[$key]['name'].$eol;
             $body .= $eol.chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))).$eol;
          }
      }
   }
   $body .= '--'.$boundary.'--'.$eol;
   if ($mailto != '')
   {
      mail($mailto, $subject, $body, $header);
   }
   header('Location: '.$success_url);
   exit;
}
?>



<!DOCTYPE html>
<html lang="n">

<head>

    <meta charset="utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ReMark.KZ - Digital агентство</title>

    <meta name="description" content="SMM, PPC, Контекстная реклама, Создание сайта">
    <meta name="author" content="SMM, PPC, Контекстная реклама, Создание сайта">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <script defer>$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})</script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    <!-- Google Tag Manager -->
    <script defer>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TDHGPSZ');</script>
    <!-- End Google Tag Manager -->
    <meta name="google-site-verification" content="7omiWtJlr2prnU4yBXrcyitZF0OuaY8O6_MAqQ6Ja7A" />
    <meta name="yandex-verification" content="8a47df43e68b7314" />

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

</head>

<body>
    <header>
        <div class="head-cont">
            <a href="index.html"><img class="logo" src="img/1b_logo.png" title="ReMark.KZ - Digital агентство" /></a>
            <a href="index.html"><i class="fa fa-home fa-2x home" style="color: #fff;"></i></a>
            

            <div class="head-menu">
                <ul>
                    <i class="ln1"></i>
                    <li><a href="about.html">О нас</a></li>
                    <li><a href="seo.html">SEO</a></li>
                    <li><a href="smm.html">SMM</a></li>
                    <li><a href="ppc.html">PPC</a></li>
                    <li><a href="sozdanie_saita.html" style="margin-right: -12px; font-size: 13px">СОЗДАНИЕ<br>САЙТА</a></li>
                    <a href="" class="border-rigth"></a>
                </ul>
            </div>

            <div class="icon-bar">
                <ul>
                    <li><a class="left-what" href="https://api.whatsapp.com/send?phone=77071748194" target="_blank"><img src="img/1b_whatsapp.png"></a></li>
                    <li><a style="margin-left: -35px" href="#" target="_blank"><img src="img/1b_fb.png"></a></li>
                    <li><a href="#" target="_blank"><img src="img/1b_instagram.png"></a></li>
                    <li><a style="margin-right: 20px" href="https://web.telegram.org/#/im?p=@yerekensky" target="_blank"><img src="img/1b_telegram.png"></a></li>
                    <i class="inline"></i>
                </ul>
            </div>

            <div class="head-email">
                <a class="email" href="mailto:sales@remark.kz">sales@remark.kz</a><br>
                <a class="tel1" href="tel:+7 747 299 40 15">+7 747 299 40 15</a>
            </div>
            <a href="about.html" class="about">О нас</a>

        </div>
    </header>

    <section class="big-cont">
        <canvas style="position:absolute;"></canvas>
        <div class="big_logo"><img src="img/1b_big_logo.png"></div>
        <p class="txt1">DIGITAL для ВАШЕГО <br> БИЗНЕСА</p>
    </section>

    <section class="adap-menu">
        <div class="item">
            <img src="img/bg-menu.png" alt="">
            <a href="smm.html">
                <p><span>SMM</span></p>
            </a>
        </div>
        <div class="item">
            <img src="img/bg-menu.png" alt="">
            <a href="seo.html">
                <p><span>SEO</span></p>
            </a>
        </div>
        <div class="item">
            <img src="img/bg-menu.png" alt="">
            <a href="ppc.html">
                <p><span>PPS</span></p>
            </a>
        </div>
        <div class="item font-min-con">
            <img src="img/bg-menu.png" alt="">
            <a href="sozdanie_saita.html">
                <p><span class="font-min">СОЗДАНИЕ <br> САЙТА</span></p>
            </a>
        </div>


    </section>

    <section class="digital-cont">
        <img class="b2_lnimg" src="img/2b_lnimg.png">
        <div class="digital-text">
            <p class="b2_txt1"><strong>DIGITAL–МАРКЕТИНГ</strong> – продвижение
                вашего продукта с использованием современных информационных технологий.</p>
            <p class="b2_txt2"><b>МЫ ПРЕДЛАГАЕМ</b><br> Внедрить в вашу маркетинговую и PR стратегию такие инструменты, как seo–оптимизация сайта, контекстная реклама и продвижение в социальных сетях.</p>
        </div>
    </section>

    <section class="digital-adap-cont">
        <div class="digital">
            <img src="img/digital-icon-2.png" alt="">
            <p><strong>DIGITAL–МАРКЕТИНГ</strong> – продвижение
                вашего продукта с использованием современных информационных технологий.</p>
        </div>
        <div class="handshake">
            <img src="img/handshake.png" alt="">
            <p style="text-align: right"><b>МЫ ПРЕДЛАГАЕМ</b><br> Внедрить в вашу маркетинговую и PR стратегию такие инструменты, как seo–оптимизация сайта, контекстная реклама и продвижение в социальных сетях.</p>
        </div>

    </section>

    <section class="market-cont">
        <img src="img/b3_bg.png" class="market-bg" width="1352px" alt="">
        <img src="img/b3txt.png" class="market-text" alt="">
        <img src="img/3%20stranica.png" class="market-adap" alt="">
    </section>

    <section class="step-work-cont">
        <h3>ЭТАПЫ РАБОТЫ</h3>
        <hr class="ln3">
        <div class="step-cont">
            <ul>
                <li><img class="b4img2" src="img/b4img1.png">
                    <p class="b4txt">ЗАЯВКА</p>
                    <img src="img/liniya%202.png" class="work-line" alt="line">
                </li>
                <i class="border-left"></i>
                <li><img class="b4img2" src="img/b4img2.png">
                    <p class="b4txt">РЕАЛИЗАЦИЯ</p>
                    <img src="img/liniya%202.png" class="work-line" alt="line">
                </li>
                <i class="border-left"></i>
                <li><img class="b4img2" src="img/b4img3.png">
                    <p class="b4txt">РЕЗУЛЬТАТ</p>
                </li>
            </ul>
        </div>

    </section>

    <section class="contact-cont">

        <div class="row b6-1">
            <div class="col-md-12">
                <h4 class="b6">БЕСПЛАТНЫЙ АНАЛИЗ ВАШЕГО БИЗНЕСА</h4>
            </div>
            <div class="col-md-12">
                <div class="card1 b6-1">
                    <div class="card-body b6-1">
                        <form name="contact" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form1">
                            <input type="hidden" name="formid" value="form1">
                            <div class="form-row">
                                <div class="form-group col-md-4">

                                </div>
                                <div class="form-group col-md-4">
                                    <input required class="form-control1" id="fullname" name="fullname" placeholder="Напишите  Ф.И.О." type="text">
                                </div>
                                <div class="form-group col-md-4">

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">

                                </div>
                                <div class="form-group col-md-2">
                                    <input id="tel" name="tel" placeholder="Номер телефона" class="form-control1" required="required" type="text">
                                </div>
                                <div class="form-group col-md-2 b6-1">
                                    <input required type="email" class="form-control1 b6-1" name="email" id="email" placeholder="Напишите Email">
                                </div>
                                <div class="form-group col-md-4">

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12 text-center">
                                    <button type="submit" class="btn btn-danger"> Отправить </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="foot-cont">
            <a href="index.php"><img src="img/1b_logo.png" title="ReMark.KZ - Digital агентство" class="foot-logo" /></a>

            <div class="foot-menu">
                <ul>
                    <li><a href="about.php">О нас</a></li>
                    <li><a href="seo.php">SEO</a></li>
                    <li><a href="smm.php">SMM</a></li>
                    <li><a href="ppc.php" title="Контекстная реклама">PPC</a></li>
                    <li><a href="sozdanie_saita.php">СОЗДАНИЕ<br>САЙТА</a></li>
                </ul>
            </div>

            <div class="contact-menu">
                <hr class="hr-foot">
                <i class="fas fa-phone facolor1"></i>
                <a class="tel1" href="tel:+7 707 174 81 94">+7 707 174 81 94</a><br /><br />
                <div class="adr1"><i class="fas fa-map-marker-alt facolor1"></i> г. Астана, ул. Достык 5/2, вп 202</div><br />
                <i class="fas fa-envelope facolor1"></i>
                <a class="email2" href="mailto:sales@remark.kz">sales@remark.kz</a>
                <hr class="hr-foot-bot">
            </div>
               
            <div class="contact-social">
                <a href="https://api.whatsapp.com/send?phone=77071748194"><img src="img/1b_whatsapp.png"></a>
                <a href="#"><img src="img/1b_instagram.png"></a>
                <a href="#"><img src="img/1b_fb.png"></a>
                <a href="https://web.telegram.org/#/im?p=@yerekensky"><img src="img/1b_telegram.png"></a>
            </div>

        </div>


    </footer>

    <div>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/zepto/1.0/zepto.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/stats.js/r11/Stats.js'></script>
        <script src="js/index.js"></script>
    </div>
</body>
</html>