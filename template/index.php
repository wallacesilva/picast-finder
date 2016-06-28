<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    
    <title>YoutubeCast</title>
    
    <link href="<?php echo base_url('assets/vendors/material-icons/material-icons.css'); ?>" type="text/css" rel="stylesheet"/> 
    <link href="<?php echo base_url('assets/vendors/materialize/css/materialize.min.css'); ?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url('assets/vendors/sweetalert/sweetalert.css'); ?>" type="text/css" rel="stylesheet"/> 
    <link href="<?php echo base_url('assets/css/main.css'); ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
    <style>
    .ytc-video-img{width:100%;}
    .ytc-video-title{
        width: 100%;
        display: inline-block;
        text-align:justify;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .ytc-video-duration
    {
        margin-top: -20px;
        position: relative;
        top:-30px;
        text-align: right;
        padding:5px;
    }
    .ytc-search-box span{margin-top: 10px;}
    </style>
</head>
<body>
    <nav class="red darken-1" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="<?php echo base_url(); ?>" class="brand-logo"><strong>Youtube</strong>Cast</a>

            <ul class="right hide-on-med-and-down">
                <li><a href="/videos">Videos</a></li>
                <li><a href="/videos">Canais</a></li>
            </ul>

            <ul id="nav-mobile" class="side-nav">
                <li><a href="/videos">Videos</a></li>
                <li><a href="/videos">Canais</a></li>
            </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
    </nav>

    <div class="section" id="index-banner">
        
        <div class="container">
        
<?php 
//print_r($videosResponse);
/*  //$video['id']['videoId'];
    //$video['snippet']['thumbnails']['default']['url'];
    //$video['snippet']['channelId'];
    //$video['snippet']['title'];
    //$video['snippet']['description'];
    //$video['snippet']['channelTitle'];
*/
?>
            <div class="row">
                <h4 class="col s12">Videos</h4>
            </div>
            <div class="row">
                <div class="col s12">
                    <form action="<?php echo base_url('/search/') ?>">
                    <div class="ytc-search-box search-wrapper card col s12">
                        <input id="ytc-search-input" name="ytc_search" class="col s11 m11 l11">
                        <span class="col s1 m1 l1"><i class="material-icons">search</i></span>
                    </div>
                    </form>
                </div>
            </div>
            <div class="row">

<?php foreach ($videosResponse['items'] as $video): ?>
    <div class="col s12 m4 l3">
        <div class="card-panel grey lighten-5 z-depth-1">
            <div class="row">
                <div class="col s12">
                    <img src="<?php echo str_replace('default', '0', $video['snippet']['thumbnails']['default']['url']); ?>" alt="" class="responsive-img ytc-video-img"> 
                    <span class="ytc-video-duration black white-text"><?php echo app_convert_duration($video['contentDetails']['duration']); ?></span> <br>
                    <span class="ytc-video-title blue-text"><?php echo $video['snippet']['title']; ?></span> <br>
                    <span class="ytc-video-channel gray-text"><?php echo $video['snippet']['channelTitle']; ?></span> <br>
                    <span class="ytc-video-date gray-text right"><?php echo date('d/m/Y', strtotime($video['snippet']['publishedAt'])); ?></span>
                </div>
                <div class="col s6">
                    <a class="ytc-btn-infos waves-effect waves-light blue-grey darken-1 btn col s12" data-ytc-content-id="<?php echo $video['id']; ?>">Infos</a>
                </div>
                <div class="col s6">
                    <a class="ytc-btn-play waves-effect waves-light red darken-1 btn col s12" href="<?php echo ytc_play_url($video['id']) ?>">Play</a>
                </div>
                <span class="hide" id="ytc_content_<?php echo $video['id']; ?>">
                    
                </span>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php /*foreach ($videosArr as $video): ?>
    <div class="col s12 m4 l3">
        <div class="card-panel grey lighten-5 z-depth-1">
            <div class="row">
                <div class="col s12">
                    <img src="<?php echo $video['snippet']['thumbnails']['default']['url']; ?>" alt="" class="responsive-img ytc-video-img"> 
                    <span class="ytc-video-title blue-text"><?php echo $video['snippet']['title']; ?></span> <br>
                    <span class="ytc-video-channel gray-text"><?php echo $video['snippet']['channelTitle']; ?></span> <br>
                    <span class="ytc-video-date gray-text right"><?php echo date('d/m/Y', strtotime($video['snippet']['publishedAt'])); ?></span>
                </div>
                <div class="col s6">
                    <a class="ytc-btn-infos waves-effect waves-light blue-grey darken-1 btn col s12" data-ytc-content-id="<?php echo $video['id']['videoId']; ?>">Infos</a>
                </div>
                <div class="col s6">
                    <a class="ytc-btn-play waves-effect waves-light red darken-1 btn col s12" href="<?php echo ytc_play_url($video['id']['videoId']) ?>">Play</a>
                </div>
                <span class="hide" id="ytc_content_<?php echo $video['id']['videoId']; ?>">
                    
                </span>
            </div>
        </div>
    </div>
<?php endforeach; */?>

            </div>

        </div>

    </div>

    <!-- Modal Structure -->
    <div id="modal-ytc-more-infos" class="modal">
        <div class="modal-content">
          <h4>Modal Header</h4>
          <p>A bunch of text</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>

    <script src="<?php echo base_url('assets/vendors/jquery/jquery-2.1.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/materialize/js/materialize.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/sweetalert/sweetalert.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
    <script>
    jQuery(document).ready(function($){
        $('.ytc-btn-play').click(function(e){
            e.preventDefault();

            $.get($(this).attr('href'), function(data){
                // do things, if necessary
            });

            return false;
            
        });
        
        $('.ytc-btn-infos').click(function(e){
            e.preventDefault();

            var ytc_content_id = 'ytc_content_'+$(this).attr('ytc-content-id');

            sweetAlert({
                title: "Mais informações sobre o video",
                text: "",
                type: "warning",
                allowOutsideClick: true, // poder clicar fora e sair
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, deletar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function(isConfirm){
                console.log(form_confirm_id);
                if (isConfirm) {
                    $(form_confirm_id).submit();
                }
            }
            );
        });
    });
    </script>
</body>
</html>