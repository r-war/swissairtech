<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>{if $oSeo instanceof Seo}{$oSeo->getMetaTitle()}{else}{$oMod->getName()} | {$aConfig.web_title}{/if}</title>
    {if $oSeo instanceof Seo}
    <meta name="keywords" content="{$oSeo->getMetaKeywords()}" />
    <meta name="description" content="{$oSeo->getMetaDescription()}" />
    {else}
    <meta name="keywords" content="{$aConfig.meta_name_keywords}" />
    <meta name="description" content="{$aConfig.meta_name_description}" />
    {/if}
    {if $aConfig.web_ico !=''}
      <link rel="icon"  href="/contents/images/{$aConfig.web_ico}">
    {/if}
     <link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300|Open+Sans:400,800,700,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}animate.css">
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}menu/menuzord.css">
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}menu/menuzord-min.css">
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}style.css">
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}responsive.css">


    <script type="text/javascript" src="{#JS_PATH#}vendor/modernizr-2.8.3.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}/revolution/navstylechange.css" media="screen" >
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}/revolution/settings.css" media="screen" >
    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}/revolution/rev-style.css" media="screen" >

    <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}/custom.css" media="screen" >
    
  </head>

  {*
  
  <body>
    <div class="page-loader">
      <div class="loader"></div>
    </div>
    <header>
      <div class="hidden-tablet-landscape-up">
        <div class="header header-mobile-1">
          <div class="top-header">
            <div class="container-fluid">
                <div class="logo">
                    <a href="/">
                        <img src="{#CONTENT_PATH#}{$aConfig.web_logo}" alt="Consulting" />
                    </a>
                </div>
                <button class="hamburger hamburger--spin hidden-tablet-landscape-up" id="toggle-icon">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
          </div>
          <div class="au-navbar-mobile navbar-mobile-1">
            {$interceptor->menu($oMod)}
          </div>
          <div class="container-fluid">
            {$aConfig.address}
          </div>
        </div>
      </div>
      <div class="hidden-tablet-landscape">
        <div class="topbar topbar-1 bg-black">
          <div class="container">
            <div class="block-left">
                <p class="text-block">{$aConfig.header_motto}</p>
            </div>
            <div class="block-right">
              <ul class="horizontal-list">
                {if $aConfig.facebook_link!=''}
                <li class="social-item-1">
                    <a href="{$aConfig.facebook_link}" class="fa fa-facebook" target="_blank"></a>
                </li>
                {/if}
                {if $aConfig.twitter_link!=''}
                <li class="social-item-1">
                    <a href="{$aConfig.twitter_link}" class="fa fa-twitter" target="_blank"></a>
                </li>
                {/if}
                {if $aConfig.instagram_link!=''}
                <li class="social-item-1">
                    <a href="{$aConfig.instagram_link}" class="fa fa-instagram" target="_blank"></a>
                </li>
                {/if}
                {if $aConfig.linkedin_link!=''}
                <li class="social-item-1">
                    <a href="{$aConfig.linkedin_link}" class="fa fa-linkedin" target="_blank"></a>
                </li>
                {/if}
                {if $aConfig.mail_link!=''}
                <li class="social-item-1">
                    <a href="{$aConfig.mail_link}" class="fa fa-envelope" target="_blank"></a>
                </li>
                {/if}
              </ul>
            </div>
          </div>
        </div>
        <div class="header header-1">
          <div class="container">
            <div class="block-left">
              <div class="logo">
                <a href="/">
                  <img src="{#CONTENT_PATH#}{$aConfig.web_logo}" alt="Consulting" />
                </a>
              </div>
            </div>
            <div class="block-right">
              {$aConfig.address}
            </div>
          </div>
        </div>
      </div>
      <div class="section section-navbar-1 bg-grey hidden-tablet-landscape" id="js-navbar-fixed">
        <div class="container">
          <div class="block-left">
            <div class="logo-mobile">
              <a href="/">
                <img src="{#CONTENT_PATH#}{$aConfig.web_logo}" alt="Consulting">
              </a>
            </div>
            <nav>
              <div class="au-navbar navbar-1">
                {$interceptor->menu($oMod)}
              </div>
            </nav>
          </div>

      </div>
    </header>
        <!--# end main screen #-->    
  *}

<body class="home about common-style">
  <div id="main-menu" class="main-menu responsive-device-menu scrol_fixed_nav">
    <nav id="menuzord" class="menuzord red">
      <a href="/" class="menuzord-brand"><img src="{#CONTENT_PATH#}{$aConfig.web_logo}" width="100" alt=""
          srcset=""></a>

      <div class="menu-right-part">
        <div class="social-btn">
          <ul>
            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
          </ul>
        </div>
      </div><!-- /.menu-right-part -->
      {$interceptor->menu($oMod)}
    </nav>
  </div>
