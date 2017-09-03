<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Học Tiếng Pháp mỗi ngày nhanh và hiệu quả</title>

    <link rel="stylesheet" href="http://test.local.com/001/app.css"/>


    <style>
        .phrase-played {
            color: darkolivegreen;
        }

        .word-played {
            color: darkgoldenrod;
        }

        .playlist [data-audioalias] {
            cursor: pointer;
        }

        .pagination > li {
            font-size: 16px;
        }

        .article .ibox-content {
            padding: 10px;
        }

        #scrollToTop.affix-top {
            position: absolute; /* allows it to "slide" up into view */
            bottom: 20px; /* negative of the offset - height of link element */
            right: 10px; /* padding from the left side of the window */
        }

        #scrollToTop.affix {
            position: fixed; /* keeps it on the bottom once in view */
            bottom: 50px; /* height of link element */
            right: 10px; /* padding from the left side of the window */
        }

        .tip {
            background-color: #F9F2F4;
            border-radius: 4px;
            color: #ca4440;
            font-size: 90%;
            padding: 2px 4px;
            white-space: normal;
        }

        .menu-item, .nav-label {
            font-size: 13px;
        }

        .btn-info a {
            color: #FFFFFF;
        }

        body {
            font-size: 14px;
        }
    </style>


    <style>
        .article-title {
            text-align: center;
            margin: 20px 0 20px 0;
        }
    </style>

    <link rel="icon" type="image/x-icon" href="/themes/tiengphap/favicon.ico"/>
    <script>
        var sroot = '/assets/bean/js';
        var audio_server_url = 'http://audio-server.sunrise.vn';
    </script>
    
</head>
<body data-spy="scroll"
      data-target=".navbar-spied">
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a href="/">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong
                                            class="font-bold">Học Tiếng Pháp
                                    </strong>
                                </span>
                                                                                            </span>
                        </a>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="menu-item">
                    <a href="#">
                        <i class="fa fa-wheelchair"></i> <span
                                class="nav-label">Nhập môn tiếng Pháp</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="/peterbean/post/bang-chu-cai"><i
                                        class="fa fa-font"></i> Bảng chữ cái</a></li>
                        <li><a href="#"><i class="fa fa-commenting"></i> Ngữ âm cơ bản</a></li>
                        <li><a href="dashboard_3.html"><i class="fa fa-volume-up"></i> Nguyên tắc ghép âm</a></li>
                        <li><a href="#"><i class="fa fa-wordpress"></i> Ngữ vựng</a></li>
                        <li><a href="#"><i class="fa fa-cubes"></i> Ngữ pháp</a></li>
                    </ul>
                </li>

            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i
                                class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" method="post" action="#">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control"
                                   name="top-search" id="top-search">
                        </div>
                    </form>
                </div>

            </nav>
        </div>
            <div class="row col-lg-6">
                <nav id="navbar1" class="navbar-spied navbar navbar-inverse" style="z-index: 9;" data-spy="affix"
                     data-offset-top="60" data-offset-bottom="200">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#">Brand</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li><a href="#sectionA1">Link AAA</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Dropdown <span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#sectionA2">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#sectionA4">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#sectionA5">Separated link</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#sectionA3">Link</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
            </div>
            <div class="row col-lg-6">
                <nav id="navbar2" class="navbar-spied navbar navbar-inverse" style="z-index: 9;" data-spy="affix"
                     data-offset-top="60" data-offset-bottom="200">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li><a href="#sectionB1">B1</a></li>
                                <li><a href="#sectionB2">B2</a></li>
                                <li><a href="#sectionB3">B3</a></li>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#sectionB4">B4</a></li>
                                <li><a href="#sectionB5">B5</a></li>
                                <li><a href="#sectionB6">B6</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
            </div>
        
        

        
        <div class="wrapper wrapper-content  animated fadeInRight article">
            <div class="row">
                <div class="col-sm-8 col-lg-8 col-lg-offset-1">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="pull-right">
                            </div>
                            <div class="text-center article-title">
                                <span class="text-muted"><i class="fa fa-clock-o"></i> 31-08-2017 </span>
                                <h3>
                                    Bảng chữ cái
                                </h3>
                            </div>
                            <div class="article-content row">
                                <div style="text-align: left;" class="col-md-6" >
                                    <h1 id="sectionA1">test A1</h1>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="JH9N-0000-0000-00OV-G4IE"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> A &#91;a&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info disabled">Như chữ <strong>A</strong> tiếng Việt</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="R126-0000-0000-00OV-G4M7"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> B &#91;be&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info disabled">Như <strong>Bê</strong> tiếng Việt</span>
                                                </td>
                                            </tr>

                                            <tr id="sectionA2">
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="31J1-0000-0000-00OV-G4MM"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> C &#91;se&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info disabled">Như <strong>Xê</strong> tiếng Việt</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="FMAN-0000-0000-00OV-G4MR"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> D &#91;de&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info disabled">Như <strong>Đê</strong> tiếng Việt</span>
                                                </td>
                                            </tr>

                                            <tr id="sectionA3">
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="O197-0000-0000-00OV-G4N3"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> E &#91;ø&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info"><strong><a href="#ø">Hơi khác Ơ tiếng Việt 1 xíu</a></strong> </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="8P72-0000-0000-00OV-G4ND"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> F &#91;ɛf&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info disabled">Na ná <strong>Ép ph(ờ)</strong> tiếng Việt</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="XQPJ-0000-0000-00OV-G4NI"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> G &#91;ʒe&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info"><strong><a href="#ʒe">KHÁC tiếng Việt</a></strong></span>
                                                </td>
                                            </tr>

                                            <tr id="sectionA4">
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="V7JA-0000-0000-00OV-G4NN"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> H &#91;aʃ&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info"><strong><a href="#aʃ">KHÁC tiếng Việt</a></strong></span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="KDIQ-0000-0000-00OV-G4O0"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> I &#91;i&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info disabled">Như <strong>i</strong> tiếng Việt</span>
                                                </td>
                                            </tr>

                                            <tr id="sectionA5">
                                                <td>
                                                    <span class="btn btn-default playAudioOnClick"
                                                          data-audioalias="3DKY-0000-0000-00OV-G4O7"><i
                                                                class="fa fa-volume-up" aria-hidden="true"> J &#91;ʒi&#93; </i></span>
                                                </td>
                                                <td>
                                                    <span class="btn btn-info disabled">Tương tự <strong>G</strong> tiếng Pháp</span>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <div style="text-align: left;" class="col-md-6" >
                                    <h3 id="sectionB1" ><a href="#" name="ø">[ø] Nguyên-âm
                                            nửa-đóng tròn-môi trước</a></h3>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4><h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4><h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4><h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4><h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4><h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4><h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <h4>Voyelle mi-fermée antérieure arrondie</h4>
                                    <span class="btn btn-default playAudioOnClick"
                                          data-audioalias="O197-0000-0000-00OV-G4N3"><i class="fa fa-volume-up"
                                                                                        aria-hidden="true"> E &#91;ø&#93; </i></span>
                                    <ol>
                                        Chữ cái E tiếng Pháp phát âm như sau:
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm Ơ của
                                            tiếng Việt
                                        </li>
                                        <li><strong>Nguyên âm nửa-đóng (Voyelle mi-fermée)</strong> nghĩa là bạn đặt đầu
                                            lưỡi ở khoảng 1/4 miệng tính từ môi trên xuống
                                        </li>
                                        <li><strong>Tròn-môi</strong> nghĩa là bạn tròn môi như chữ O tiếng Việt</li>
                                        <li><strong>Phần cuống lưỡi</strong> thả lỏng, đưa về phía trước chứ không đưa
                                            nhẹ lên như âm Ơ tiếng Việt
                                        </li>
                                    </ol>
                                    <span class="tip"><i class="fa fa-hand-o-right" aria-hidden="true"> </i> Nếu thấy khó quá thì bạn cứ phát âm như âm Ơ tiếng Việt. Người Pháp vẫn có thể hiểu được.</span>

                                    <h3 id="sectionB2" ><a href="#" name="ʒe">[ʒ] Xuýt-âm hữu-thanh vòm-miệng - chân-răng </a></h3>
                                    <h4>Consonne fricative palato-alvéolaire voisée</h4>
                                    <span class="btn btn-default playAudioOnClick"
                                          data-audioalias="XQPJ-0000-0000-00OV-G4NI"><i class="fa fa-volume-up"
                                                                                        aria-hidden="true"> G &#91;ʒe&#93; </i></span>
                                    <ol>
                                        Chữ cái G tiếng Pháp phát âm như sau:
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm Giê của
                                            miền Bắc
                                        </li>
                                        <li><strong>Thay vì chỉ có đầu lưỡi chạm vào chân răng</strong> bạn nâng phần
                                            thân lưỡi lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    <ol>
                                        Chữ cái G tiếng Pháp phát âm như sau:
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm Giê của
                                            miền Bắc
                                        </li>
                                        <li><strong>Thay vì chỉ có đầu lưỡi chạm vào chân răng</strong> bạn nâng phần
                                            thân lưỡi lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    <ol>
                                        Chữ cái G tiếng Pháp phát âm như sau:
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm Giê của
                                            miền Bắc
                                        </li>
                                        <li><strong>Thay vì chỉ có đầu lưỡi chạm vào chân răng</strong> bạn nâng phần
                                            thân lưỡi lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    <ol>
                                        Chữ cái G tiếng Pháp phát âm như sau:
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm Giê của
                                            miền Bắc
                                        </li>
                                        <li><strong>Thay vì chỉ có đầu lưỡi chạm vào chân răng</strong> bạn nâng phần
                                            thân lưỡi lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    <ol>
                                        Chữ cái G tiếng Pháp phát âm như sau:
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm Giê của
                                            miền Bắc
                                        </li>
                                        <li><strong>Thay vì chỉ có đầu lưỡi chạm vào chân răng</strong> bạn nâng phần
                                            thân lưỡi lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    <ol>
                                        Chữ cái G tiếng Pháp phát âm như sau:
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm Giê của
                                            miền Bắc
                                        </li>
                                        <li><strong>Thay vì chỉ có đầu lưỡi chạm vào chân răng</strong> bạn nâng phần
                                            thân lưỡi lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    
                                    <span class="tip"><i class="fa fa-hand-o-right" aria-hidden="true"> </i> Giống chữ cái G tiếng Việt khi được phát âm theo kiểu cũ (hệ Pháp).</span>


                                    <h3 id="sectionB3" ><a href="#" name="aʃ">[ ʃ ] Xuýt-âm vô-thanh vòm-miệng - chân-răng </a></h3>
                                    <h4>Consonne fricative palato-alvéolaire sourde</h4>
                                    <span class="btn btn-default playAudioOnClick"
                                          data-audioalias="V7JA-0000-0000-00OV-G4NN"><i class="fa fa-volume-up"
                                                                                        aria-hidden="true"> H &#91;aʃ&#93; </i></span>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    <span class="tip"><i class="fa fa-hand-o-right"
                                                         aria-hidden="true"> </i> Tương tự <strong>ash</strong> tiếng Anh</span>



                                    <h3 id="sectionB4" ><a href="#" name="aʃ">[ ʃ ] Xuýt-âm vô-thanh vòm-miệng - chân-răng </a></h3>
                                    <h4>Consonne fricative palato-alvéolaire sourde</h4>
                                    <span class="btn btn-default playAudioOnClick"
                                          data-audioalias="V7JA-0000-0000-00OV-G4NN"><i class="fa fa-volume-up"
                                                                                        aria-hidden="true"> H &#91;aʃ&#93; </i></span>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>


                                    <h3 id="sectionB5" ><a href="#" name="aʃ">[ ʃ ] Xuýt-âm vô-thanh vòm-miệng - chân-răng </a></h3>
                                    <h4>Consonne fricative palato-alvéolaire sourde</h4>
                                    <span class="btn btn-default playAudioOnClick"
                                          data-audioalias="V7JA-0000-0000-00OV-G4NN"><i class="fa fa-volume-up"
                                                                                        aria-hidden="true"> H &#91;aʃ&#93; </i></span>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>


                                    <h3 id="sectionB6" ><a href="#" name="aʃ">[ ʃ ] Xuýt-âm vô-thanh vòm-miệng - chân-răng </a></h3>
                                    <h4>Consonne fricative palato-alvéolaire sourde</h4>
                                    <span class="btn btn-default playAudioOnClick"
                                          data-audioalias="V7JA-0000-0000-00OV-G4NN"><i class="fa fa-volume-up"
                                                                                        aria-hidden="true"> H &#91;aʃ&#93; </i></span>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>
                                    Thường H là âm câm nhưng khi đánh vần Chữ-cái, nó được phát âm cách riêng.
                                    <ol>
                                        Chữ cái H tiếng Pháp phát âm như sau:
                                        <li>H [aʃ] là sự kết hợp giữa âm A và S (sờ nặng) tiếng Việt [ ʃ ]</li>
                                        <li><strong>Bắt đầu</strong> bằng cách đặt miệng và lưỡi như khi phát âm ÁT
                                            tiếng Việt
                                        </li>
                                        <li><strong>Thay âm T bằng âm S (sờ nặng)</strong> bằng cách nâng phần thân lưỡi
                                            lên cho nó chạm luôn vào <strong>vòm họng</strong></li>
                                    </ol>

                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-right">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-2">
                    <div class="ibox text-center">
                        <div class="ibox-content">
                            <h3>Advertising</h3>
                            <h3>Contact: 0166 914 0 916</h3>
                        </div>
                    </div>

                </div>
            </div>


        </div>


        <span id="scrollToTop">
                <a href="#top" class="well well-sm"
                   onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
                    <i class="glyphicon glyphicon-chevron-up"></i> Back to Top
                </a>
            </span><!-- /scrollToTop -->

        <div class="footer">
            <div class="pull-right">

            </div>
            <div>
                3.2.6 <a href="http://www.web4u.vn" target="_blank"><strong>Thiết kế web</strong></a> và phát triển bởi
                Sunrise Solutions Co., ltd &copy; 2008-2017
            </div>
        </div>

    </div>
</div>


<script src="bundles/sonatacore/vendor/jquery/dist/jquery.min.js"></script>
<script src="bundles/sonatacore/vendor/bootstrap/dist/js/bootstrap.js"></script>
<!-- Main scripts -->
<script src="assets/bean/js/audio.js"></script>

<script>
    (function ($) {
        $('#scrollToTop').affix({
            // how far to scroll down before link "slides" into view
            offset: {top: 50}
        });

        $(document).on("click", ".vocab-entry-popover-audio", function () {
            var audioalias = $(this).data('audioalias');
            stopAudio();
            initAudio(audioalias);
            playAudio();
        });

        /* ----------------------------------------------- */
        /* ----------------------------------------------- */
        /* OnLoad Page */
        $(document).ready(
            function ($) {

                $('.menu-item').hover(
                    function (e) {
                        $(this).addClass('active');
                        $(this).children('ul').addClass('in');
                    }, function (e) {
                        $(this).removeClass('active');
                        $(this).children('ul').removeClass('in');
                    });
            }
        );
        /* OnLoad Window */
        var init = function () {

        };
        window.onload = init;

    })(jQuery);

</script>


<script>
    H5PIntegration = []
</script>


<script>

    $(document).ready(function () {

        $('.btn-content').on('click', function (e) {
            _h5pId = $(this).data('h5ptarget');
            var $h5p = $('#h5p_' + _h5pId);
            var $h5pActive = $('.h5p-app-active');

            if ($h5p.hasClass('h5p-app-active')) {
                $h5p.addClass('hidden');
                $h5p.removeClass('h5p-app-active');

            } else {
                $h5pActive.addClass('hidden');
                $h5pActive.removeClass('h5p-app-active');

                $h5p.removeClass('hidden');
                $h5p.addClass('h5p-app-active');
            }

        });
    });

</script>
<script>


</script>
<script>
    jQuery(document).ready(function ($) {
//            $('#h5p-mcq0').text('testing ahihi');
    });
</script>


</body>

</html>