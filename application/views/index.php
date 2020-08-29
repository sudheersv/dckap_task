<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>User Management </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href=""> 

        <!-- CSS 
        ========================= -->
        <!--bootstrap min css-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css?v=0.2">
        <!--font awesome css-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font.awesome.css">
        <!-- Main Style CSS -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css?v=0.3">
        <!-- Main Style CSS -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/switch.css?v=0.3">
        <!--jquery min js-->
        <script src="<?php echo base_url() ?>assets/js/jquery-3.4.1.min.js"></script>
        <!--bootstrap min js-->
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

        <script>
            var Site = {url: '<?php echo base_url() ?>'}
        </script>
        <style>
            #modal {
                display:    none;
                position:   fixed;
                z-index:    1000;
                top:        0;
                left:       0;
                height:     100%;
                width:      100%;
                background: rgba( 255, 255, 255, .8 ) 
                    url('<?php echo base_url() ?>assets/img/loader.gif') 
                    50% 50% 
                    no-repeat;
            }

            /* When the body has the loading class, we turn
               the scrollbar off with overflow:hidden */
            body.loading {
                overflow: hidden;   
            }

            /* Anytime the body has the loading class, our
               modal element will be visible */
            body.loading #modal {
                display: block;
            }

        </style>
    </head>

    <body>

        <?php echo $yield ?>

        <!--popper min js-->
        <script src="<?php echo base_url() ?>assets/js/popper.js"></script>
        <!--jquery validator js-->
        <script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
        <!-- Notify min JS -->
        <script src="<?php echo base_url() ?>assets/js/notify.min.js"></script>

        <!-- Main JS -->
        <script src="<?php echo base_url() ?>assets/js/main.js"></script>
        
        <div id="modal"></div>

    </body>
</html>